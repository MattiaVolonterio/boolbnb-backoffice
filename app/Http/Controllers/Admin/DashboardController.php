<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
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

    // Messaggi totali per mese
    $result_1 = DB::select(DB::raw(
      "SELECT 
       SUM(DATE(messages.created_at) BETWEEN '2023-06-01' AND '2023-06-30') AS Giugno,
       SUM(DATE(messages.created_at) BETWEEN '2023-07-01' AND '2023-07-31') AS Luglio,
       SUM(DATE(messages.created_at) BETWEEN '2023-08-01' AND '2023-08-31') AS Agosto,
       SUM(DATE(messages.created_at) BETWEEN '2023-09-01' AND '2023-09-30') AS Settembre,
       SUM(DATE(messages.created_at) BETWEEN '2023-10-01' AND '2023-10-31') AS Ottobre,
       SUM(DATE(messages.created_at) BETWEEN '2023-11-01' AND '2023-11-30') AS Novembre,
       SUM(DATE(messages.created_at) BETWEEN '2023-12-01' AND '2023-12-31') AS Dicembre,
       SUM(DATE(messages.created_at) BETWEEN '2024-01-01' AND '2024-01-31') AS Gennaio,
       SUM(DATE(messages.created_at) BETWEEN '2024-02-01' AND '2024-02-28') AS Febbraio, 
       SUM(DATE(messages.created_at) BETWEEN '2024-03-01' AND '2024-03-31') AS Marzo, 
       SUM(DATE(messages.created_at) BETWEEN '2024-04-01' AND '2024-04-30') AS Aprile,
       SUM(DATE(messages.created_at) BETWEEN '2024-05-01' AND '2024-05-31') AS Maggio
      FROM apartments  
      INNER JOIN users ON users.id = apartments.user_id
      INNER JOIN messages ON messages.apartment_id = apartments.id
      WHERE (users.id = $authID) AND (DATE(messages.created_at) BETWEEN '2023-06-01' AND '2024-05-31')"
    ));



    // Visualizzazioni totali per mese
    $result_2 = DB::select(DB::raw(
      "SELECT 
       SUM(DATE(visits.created_at) BETWEEN '2023-06-01' AND '2023-06-30') AS Giugno,
       SUM(DATE(visits.created_at) BETWEEN '2023-07-01' AND '2023-07-31') AS Luglio,
       SUM(DATE(visits.created_at) BETWEEN '2023-08-01' AND '2023-08-31') AS Agosto,
       SUM(DATE(visits.created_at) BETWEEN '2023-09-01' AND '2023-09-30') AS Settembre,
       SUM(DATE(visits.created_at) BETWEEN '2023-10-01' AND '2023-10-31') AS Ottobre,
       SUM(DATE(visits.created_at) BETWEEN '2023-11-01' AND '2023-11-30') AS Novembre,
       SUM(DATE(visits.created_at) BETWEEN '2023-12-01' AND '2023-12-31') AS Dicembre,
       SUM(DATE(visits.created_at) BETWEEN '2024-01-01' AND '2024-01-31') AS Gennaio,
       SUM(DATE(visits.created_at) BETWEEN '2024-02-01' AND '2024-02-28') AS Febbraio, 
       SUM(DATE(visits.created_at) BETWEEN '2024-03-01' AND '2024-03-31') AS Marzo, 
       SUM(DATE(visits.created_at) BETWEEN '2024-04-01' AND '2024-04-30') AS Aprile,
       SUM(DATE(visits.created_at) BETWEEN '2024-05-01' AND '2024-05-31') AS Maggio
      FROM apartments  
      INNER JOIN users ON users.id = apartments.user_id
      INNER JOIN visits ON visits.apartment_id = apartments.id
      WHERE (users.id = $authID) AND (DATE(visits.created_at) BETWEEN '2023-06-01' AND '2024-05-31')"
    ));

    // dichiarazione array di labels, messaggi totali e visualizzazione views
    $labels = [];
    $result_messages = [];
    $result_views = [];

    foreach ($result_1[0] as $key => $result) {
      $labels[] = $key;
      $result_messages[] = $result;
    }

    foreach ($result_2[0] as $key => $result) {
      $result_views[] = $result;
    }

    $data = [
      'labels' => $labels,
      'messages' => $result_messages,
      'views' => $result_views,
    ];


    // return
    return view('admin.dashboard', compact('apartments', 'apartments_sponsor', 'messages', 'data'));
  }
}
