<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Course;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function store(Request $request){
        $newCourse = Course::create(json_decode($request->course));
        $faculties = json_decode($request->faculties);

        $newCourse->faculties()->attach($faculties);

        return response()->json([
            "response" => "Course created successfully",
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

    public function update(Request $request, $id){
        $newCourse = json_decode($request->course);
        Course::where("id", $id)->update($newCourse);
        // Update faculties

        return response()->json([
            "response" => "Course edited successfully",
        ]);
    }

}
