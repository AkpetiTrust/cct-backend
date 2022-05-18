<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function get(){
        $messages = Message::all();
        return response()->json($messages);
    }
    
    public function post(Request $request){
        Message::create([
            "name" => $request->name,
            "email" => $request->email,
            "message" => $request->message,
        ]);

        return response()->json([
            "response" => "Message sent successfully",
        ]);
    }
}
