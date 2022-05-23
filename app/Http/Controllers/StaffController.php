<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Staff;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function store(Request $request){
        $request->validate([
            "email" => "unique:staff"
        ]);

        $name = $request->name;
        $email = $request->email;
        $newStaff = Staff::create([
            "name" => $name,
            "email" => $email,
            "is_admin" => false,
        ]);

        return response()->json([
            "message" => "Staff added successfully",
            "response" => $newStaff
        ]);
    }

    public function index(){
        $staff = Staff::all();
        return response()->json([
            "response" => $staff
        ]);
    }

    public function destroy($id){
        Staff::where("id", $id)->delete();
        return response()->json([
            "response" => "Staff deleted successfully",
        ]);
    }

    public function update(Request $request, $id){
        $name = $request->name;
        $email = $request->email;
        $newStaff = [
            "name" => $name,
            "email" => $email,
        ];
        Staff::where("id", $id)->update($newStaff);

        return response()->json([
            "response" => "Staff edited successfully",
        ]);
    }

}
