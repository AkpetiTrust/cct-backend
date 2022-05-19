<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Student;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function add(Request $request){
        $name = $request->name;
        $email = $request->email;
        $courses = $request->courses;
        $registration_number = Str::random(10);
        Student::create([
            "name" => $name,
            "email" => $email,
            "registration_number" => $registration_number,
        ]);

        return response()->json([
            "response" => "Student added successfully",
        ]);
    }

    public function get(){
        $students = Student::all();
        return response()->json([
            "response" => $students
        ]);
    }

    public function delete(Request $request){
        Student::where("id", $request->id)->delete();
        return response()->json([
            "response" => "Student deleted successfully",
        ]);
    }

    public function edit(Request $request){
        $newStudent = json_decode($request->newStudent);
        Student::where("id", $request->id)->update($newStudent);
    }

}
