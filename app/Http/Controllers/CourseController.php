<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Course;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function store(Request $request){
        $newCourse = Course::create([
            "title" => $request->title,
            "category" => strtoupper($request->category),
            "description" => $request->description,
            "duration" => $request->duration,
            "prerequisites_json" => $request->prerequisites_json,
            "advantages_json" => $request->advantages_json,
            "course_outline" => $request->course_outline,
        ]);
        $faculties = json_decode($request->faculties);

        $newCourse->faculties()->attach($faculties);

        return response()->json([
            "message" => "Course created successfully",
            "response" => $newCourse,
        ]);
    }

    public function index(){
        $courses = Course::all();
        return response()->json([
            "response" => $courses
        ]);
    }

    public function destroy($id){
        Course::where("id", $id)->delete();
        return response()->json([
            "response" => "Course deleted successfully",
        ]);
    }

    public function show($id){
        $course = Course::find($id);
        $batches = $course->batches;
        $faculties = $course->faculties;
        $students = $course->students;

        return response()->json([
            "response" => [
                "course" => $course,
                "batches" => $batches,
                "faculties" => $faculties,
                "students" => $students,
            ],
        ]);
    }

    public function update(Request $request, $id){
        $newCourse = json_decode($request->course);
        Course::where("id", $id)->update($newCourse);
        // Update faculties

        return response()->json([
            "response" => "Course edited successfully",
        ]);
    }

}
