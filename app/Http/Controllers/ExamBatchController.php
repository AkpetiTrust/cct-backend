<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamBatch;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;

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

        return response()->json([
            "response" => "Batch created successfully"
        ]);
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
                "id" => $row -1
            ]);

            $row++;
        }

        $questions_json = json_encode($questions);

        ExamBatch::where("id", $id)->update([
            "questions_json" => $questions_json,
        ]);

        return response()->json([
            "response" => "Questions uploaded successfully",
            "questions" => $questions,
        ]);
    }

    public function addDuration(Request $request, $id){
        ExamBatch::where("id", $id)->update([
            "duration_in_minutes" => $request->duration_in_minutes,
        ]);
    }

    public function show($id){
        $examBatch = ExamBatch::find($id);
        $examBatch->students;
        $examBatch->course;

        return response()->json([
            "response" => $examBatch
        ]);
    }


    public function showBatchToStudent($id){
        $examBatch =  ExamBatch::find($id);
        $time = $examBatch->time;
        $duration = $examBatch->duration_in_minutes;
        $questionNumber = json_decode($examBatch->questions_json) !== null ? count(json_decode($examBatch->questions_json)) : 0;
        $course = $examBatch->course->title;

        return response()->json([
            "response" => [
                "time" => $time,
                "duration" => $duration,
                "questionNumber" => $questionNumber,
                "course" => $course
            ]
            ]);
    }


    public function getExamQuestions($id){
        date_default_timezone_set("Africa/Lagos");
        $user = Auth::user();
        $examBatch =  ExamBatch::find($id);
        $gracePeriodInSeconds = 10*60*60;
        if($examBatch->students()->find($user->id)){
            $currentTimeInSeconds = time();
            $examTimeInSeconds = strtotime($examBatch->time);
            
            if($currentTimeInSeconds > ($examTimeInSeconds + $gracePeriodInSeconds)){
                return response()->json([
                    "error" => "Sorry but you've missed the exam"
                ]);
            }else if($currentTimeInSeconds < $examTimeInSeconds){
                return response()->json([
                    "error" => "It's not time for the exam yet"
                ]);
            }

            $questions = json_decode($examBatch->questions_json);
            $questionsToShow = [];
            foreach ($questions as $question) {
                $questionToShow = [
                    "question" => $question->question,
                    "options" => $question->options,
                    "id" => $question->id
                ];

                array_push($questionsToShow, $questionToShow);
            }

            return response()->json([
                "questions" => $questionsToShow,
                "course" => $examBatch->course->title
            ]);

        }

        return response()->json([
            "error" => "You aren't batched for this exam"
        ]);
    }


    public function submitQuestions(Request $request, $id){
        date_default_timezone_set("Africa/Lagos");
        $user = Auth::user();
        $examBatch =  ExamBatch::find($id);
        $gracePeriodInSeconds = 10*60*60;
        if($examBatch->students()->find($user->id)){
            $currentTimeInSeconds = time();
            $examTimeInSeconds = strtotime($examBatch->time);
            
            if($currentTimeInSeconds > ($examTimeInSeconds + $gracePeriodInSeconds)){
                return response()->json([
                    "error" => "Sorry but you've missed the exam"
                ]);
            }else if($currentTimeInSeconds < $examTimeInSeconds){
                return response()->json([
                    "error" => "It's not time for the exam yet"
                ]);
            }

            $studentAnswers = json_decode($request->answers);
            $actualAnswers = [];
            $questions = json_decode($examBatch->questions_json);
            foreach ($questions as $question ) {
                array_push($actualAnswers, $question->answer);
            }
            $result_json = json_encode([
                "studentAnswers" => $studentAnswers,
                "actualAnswers" => $actualAnswers,
            ]);


            return $result_json;

        }

        return response()->json([
            "error" => "You aren't batched for this exam"
        ]);
    }

}
