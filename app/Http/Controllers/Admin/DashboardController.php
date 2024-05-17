<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    // recuperare tutti gli appartmaneti dell'utente
    $apartments = Apartment::where('user_id', Auth::id())->get();
    // recuperare gli appartmaneti con sponsorizzazione valida dell'utente registrato
    $apartments_sponsor = Apartment::select('id', 'name', 'cover_img')->where('user_id', Auth::id())->whereHas('sponsorships', function (EloquentBuilder $query) {
      $query->where('end_date', '>', now());
    })->groupBy('id')->get();

    // sistemazione path assoluto
    foreach ($apartments_sponsor as $apartment_sponsor) {
      $apartment_sponsor->cover_img = $apartment_sponsor->cover_img ? asset('storage/uploads/cover/' . $apartment_sponsor->cover_img) : 'https://placehold.co/600x400';
    }

    // dichiarazione array dei messaggi
    $messages = [];

    // per ogni appartmanto recupero i messagg
    foreach ($apartments as $apartment) {
      $messages_col = Message::where('apartment_id', $apartment->id)->with('apartment:id,name')->orderBy('created_at', 'DESC')->get()->toArray();
      foreach ($messages_col as $message) {
        // cambio formato data
        $dateString = strtotime($message['created_at']);
        $message['created_at'] = date('d-m-Y H:i:s', $dateString);
        $messages[] = $message;
      };
    }

    // recupero id dell'utente registrato
    $authID = Auth::id();

    $date = Carbon::parse('2018-03-16')->locale('it');
    $todayDate = Carbon::now();

    //Create a months array
    $totalArray = [];
    $label_to_print = [];

    //Get start and end of all months
    for ($i = 0; $i <= 12; $i++) {
      $startDate = Carbon::now()->subYear();
      $totalArray[] = $startDate->addMonths($i)->firstOfMonth()->format('Y-m-d');
      $totalArray[] = $startDate->endOfMonth()->format('Y-m-d');
      $month_base = $startDate->format('F');
      $month_translated = ucfirst(Carbon::translateTimeString($month_base, 'en', 'it'));
      $label_to_print[] = $month_translated;
    }

    $date_of_start_char = $totalArray[0];


    // Messaggi totali per mesi
    $result_1 = DB::table('apartments')->selectRaw("
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Giugno2,
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Giugno,
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Luglio,
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Agosto,
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Settembre,
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Ottobre,
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Novembre,
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Dicembre,
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Gennaio,
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Febbraio, 
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Marzo, 
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Aprile,
      SUM(DATE(messages.created_at) BETWEEN ? AND ?) AS Maggio", [$totalArray])
      ->join('users', 'users.id', '=', 'apartments.user_id')
      ->join('messages', 'messages.apartment_id', '=', 'apartments.id')
      ->where('users.id', '=', $authID)
      ->whereBetween('messages.created_at', [date($date_of_start_char), date($todayDate)])
      ->get();




    // Visualizzazioni totali per mese

    $result_2 = DB::table('apartments')->selectRaw("
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Giugno2,
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Giugno,
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Luglio,
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Agosto,
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Settembre,
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Ottobre,
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Novembre,
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Dicembre,
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Gennaio,
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Febbraio, 
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Marzo, 
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Aprile,
    SUM(DATE(visits.created_at) BETWEEN ? AND ?) AS Maggio", [$totalArray])
      ->join('users', 'users.id', '=', 'apartments.user_id')
      ->join('visits', 'visits.apartment_id', '=', 'apartments.id')
      ->where('users.id', '=', $authID)
      ->whereBetween('visits.created_at', [date($date_of_start_char), date($todayDate)])
      ->get();

    // dichiarazione array di labels, messaggi totali e visualizzazione views
    $result_messages = [];
    $result_views = [];

    foreach ($result_1[0] as $key => $result) {
      $result_messages[] = $result;
    }

    foreach ($result_2[0] as $key => $result) {
      $result_views[] = $result;
    }

    $data = [
      'labels' => $label_to_print,
      'messages' => $result_messages,
      'views' => $result_views,
    ];


    // return
    return view('admin.dashboard', compact('apartments', 'apartments_sponsor', 'messages', 'data'));
  }
}
