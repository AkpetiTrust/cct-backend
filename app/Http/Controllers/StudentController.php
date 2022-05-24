<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Student;
use \App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            "email" => "unique:students"
        ]);

        $name = $request->name;
        $email = $request->email;
        $courses = json_decode($request->courses);
        $newStudent = Student::create([
            "name" => $name,
            "email" => $email,
        ]);

        $newStudent->courses()->attach($courses);
        $newStudent->courses;

        return response()->json([
            "response" => $newStudent,
        ]);
    }

    public function index(){
        $students = Student::all();
        foreach ($students as $student) {
            $student->courses;
        }
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
        // Todo, validate new email coming in.
        $name = $request->name;
        $email = $request->email;
        $courses = json_decode($request->courses);
        $newStudent = [
            "name" => $name,
            "email" => $email,
        ];
        $studentToEdit = Student::find($id);
        $studentToEdit->update($newStudent);
        $studentToEdit->courses()->sync($courses);
        $studentToEdit->courses;

        return response()->json([
            "response" => $studentToEdit,
        ]);
    }

    public function getBatches(){
        date_default_timezone_set("Africa/Lagos");
        $user = Auth::user();
        $batches = $user->examBatches;
        $response = [];
        foreach ($batches as $batch) {
            $time = $batch->time;
            $courseTitle =  $batch->course->title;
            $gracePeriodInSeconds = 10*60*60;
            if(time() < (strtotime($time) + $gracePeriodInSeconds)){
                array_push($response, [
                    "time" => $time,
                    "course" => $courseTitle,
                    "id" => $batch->id,
                ]);
            }
        }
        return response()->json([
            "response" => $response,
        ]);
    }

}
