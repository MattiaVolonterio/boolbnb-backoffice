<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index(Apartment $apartment = null)
    {
        // dichiarazione array dei messaggi
        $messages = [];

        // se viene passato nella rotta un appartamento recupero i messaggi di quell'appartamento se no li recupero tutti
        if ($apartment) {
            $messages = Message::where('apartment_id', $apartment->id)->with('apartment:id,name')->orderBy('id', 'DESC')->get();
        } else {
            $apartments = Apartment::where('user_id', Auth::id())->get();
            foreach ($apartments as $apartment) {
                $messages_col = Message::where('apartment_id', $apartment->id)->with('apartment:id,name')->orderBy('id', 'DESC')->get()->toArray();
                foreach ($messages_col as $message) {
                    $dateString = strtotime($message['created_at']);
                    $message['created_at'] = date('d-m-Y H:i:s', $dateString);
                    $messages[] = $message;
                };
            }
        }


        // $messages = collect($messages);

        return view('admin.messages.index', compact('messages'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return back();
    }
}
