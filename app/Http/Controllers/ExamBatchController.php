<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamBatch;
use \PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function addQuestions(Request $request, $id){
        $questionsPath = $request->file("questions")->path();
        $spreadsheet = IOFactory::load($questionsPath);
        $lettersToIds = [
            "A" => 1,
            "B" => 2,
            "C" => 3,
            "D" => 4,
        ];
        $questions = [];
        $loopIsRunning = true;
        $row = 2;

        while($loopIsRunning){
            $question = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();

            if(!$question){
                $loopIsRunning= false;
                break;
            }

            $answer = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
            $options = [];
            for ($column = 3; $column < 7; $column++) { 
                $option = [
                    "option" => $spreadsheet->getActiveSheet()->getCellByColumnAndRow($column, $row)->getValue(),
                    "id" => $column - 2 //Option A is 1, Option B is 2, ans so on
                ];

                array_push($options, $option);
            }

            array_push($questions, [
                "question" => $question,
                "options" => $options,
                "answer" => $lettersToIds[strtoupper(trim($answer))],
            ]);

            $row++;
        }

        $questions_json = json_encode($questions);

        ExamBatch::where("id", $id)->update([
            "questions_json" => $questions_json,
        ]);

        return response()->json([
            "response" => "Questions uploaded successfully",
        ]);
    }


}
