<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(){
        $messages = Message::orderBy("created_at", "desc")->get();
        return response()->json([
            "response" => $messages,
        ]);
    }
    
    public function store(Request $request){
        Message::create([
            "name" => $request->name,
            "email" => $request->email,
            "message" => $request->message,
        ]);

        return response()->json([
            "response" => "Message sent successfully",
        ]);
    }

    public function destroy($id){
        try{
            Message::findOrFail($id)->delete();
        }catch(\Exception $e){
            return response()->json([
                "response" => "Something went wrong",
            ], 500);
        }
        return response()->json([
            "response" => "Message deleted successfully",
        ]);
    }
}
