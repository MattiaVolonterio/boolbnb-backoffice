<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(MessageStoreRequest $request){
        $message = new Message;

        $data = $request->all();
        $message->apartment_id = $data['apartment_id'];
        $message->customer_email = $data['customer_email'];
        $message->name = $data['name'];
        $message->content = $data['content'];

        $message->save();

        return response()->json(['success' => true, 'message'=>'Messaggio inviato con successo']);

    }
}
