<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamBatch;

class ExamBatchController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $students = json_decode($request->students);
        $time = $request->time;
        $course_id = $request->course_id;
        $faculty_id = $request->faculty_id;

        $newExamBatch = ExamBatch::create([
            "time" => $time,
            "course_id" => $course_id,
            "faculty_id" => $faculty_id,
        ]);

        $newExamBatch->students()->attach($students);
    }
    
    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
}
