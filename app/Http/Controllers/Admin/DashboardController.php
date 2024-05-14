<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function index()
  {
    $apartments = Apartment::where('user_id', Auth::id())->get();
    // sistemazione path assoluto cover img
    $messages = [];
    foreach ($apartments as $apartment) {
      $apartment->cover_img = $apartment->cover_img ? asset('storage/uploads/cover/' . $apartment->cover_img) : 'https://placehold.co/600x400';
      $messages_col = Message::where('apartment_id', $apartment->id)->with('apartment:id,name')->orderBy('id', 'DESC')->get()->toArray();
      foreach ($messages_col as $message) {
        $dateString = strtotime($message['created_at']);
        $message['created_at'] = date('d:m:Y H:i:s', $dateString);
        $messages[] = $message;
      };
    }
    return view('admin.dashboard', compact('apartments', 'messages'));
  }
}
