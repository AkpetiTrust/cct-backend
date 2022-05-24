<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExamBatchController;
use App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("/login", [AuthController::class, "login"]);
Route::post("/messages", [MessagesController::class, "store"]);
Route::get("/courses", [CourseController::class, "index"]);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum', 'abilities:admin-abilities']], function () {
    Route::resource('messages', MessagesController::class)->only(['index', 'destroy']);
    Route::post('delete-messages', [MessagesController::class, "deleteMessages"]);
    Route::resource('staff', StaffController::class)->except(['create', 'show', 'edit']);
    Route::resource('students', StudentController::class)->except(['create', 'show', 'edit']);
    Route::resource('courses', CourseController::class)->except(['create', 'edit', 'index']);
});

Route::group(['middleware' => ['auth:sanctum', 'abilities:staff-abilities']], function () {
    Route::post("/add-questions/{id}", [ExamBatchController::class, "addQuestions"]);
});
