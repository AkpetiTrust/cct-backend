<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function get(){
        $messages = Message::orderBy("created_at", "desc")->get();
        return response()->json([
            "response" => $messages,
        ]);
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

    public function delete(Request $request){
        Message::where("id", $request->id)->delete();
        return response()->json([
            "response" => "Message deleted successfully",
        ]);
    }
}
