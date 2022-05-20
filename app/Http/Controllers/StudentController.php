<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Student;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function store(Request $request){
        $name = $request->name;
        $email = $request->email;
        $courses = json_decode($request->courses);
        $newStudent = Student::create([
            "name" => $name,
            "email" => $email,
        ]);

        // Untested
        $newStudent->courses()->attach($courses);

        return response()->json([
            "response" => "Student added successfully",
        ]);
    }

    public function index(){
        $students = Student::all();
        return response()->json([
            "response" => $students
        ]);
    }

    public function destroy($id){
        Student::where("id", $id)->delete();
        return response()->json([
            "response" => "Student deleted successfully",
        ]);
    }

    public function update(Request $request, $id){
        $name = $request->name;
        $email = $request->email;
        $courses = json_decode($request->courses);
        $newStudent = [
            "name" => $name,
            "email" => $email,
        ];
        Student::where("id", $id)->update($newStudent);
        // Update courses

        return response()->json([
            "response" => "Student edited successfully",
        ]);
    }

}
