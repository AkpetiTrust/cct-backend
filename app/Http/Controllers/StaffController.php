<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Staff;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function add(Request $request){
        $name = $request->name;
        $email = $request->email;
        $staff_id = Str::random(10);
        Staff::create([
            "name" => $name,
            "email" => $email,
            "staff_id" => $staff_id,
            "is_admin" => false,
        ]);

        return response()->json([
            "response" => "Staff added successfully",
        ]);
    }

    public function get(){
        $staff = Staff::all();
        return response()->json([
            "response" => $staff
        ]);
    }

    public function delete(Request $request){
        Staff::where("id", $request->id)->delete();
        return response()->json([
            "response" => "Staff deleted successfully",
        ]);
    }

    public function edit(Request $request){
        $newStaff = json_decode($request->newStaff);
        Staff::where("id", $request->id)->update($newStaff);
    }

}
