<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\RoomCreateController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\FileController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('room-creates', RoomCreateController::class);
Route::post('/check-if-exist', [RoomCreateController::class, 'checkIfExist']);
Route::post('/room-check/{room_id}', [RoomCreateController::class, 'checkRoom']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/upload', [FileUploadController::class, 'upload']);
//     Route::get('/files', [FileUploadController::class, 'getFiles']);
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/upload', [FileController::class, 'upload']);
    Route::get('/files', [FileController::class, 'index']);
    Route::get('/download/{id}', [FileController::class, 'download']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/polls', [PollController::class, 'index']);
    Route::post('/polls', [PollController::class, 'store']);
    Route::get('/polls/{poll}', [PollController::class, 'show']);
    Route::post('/polls/{poll}/responses', [PollController::class, 'submitResponse']);
    Route::get('/polls/{poll}/results', [PollController::class, 'results']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/quizzes', [QuizController::class, 'store']);
    Route::post('/quizzes/{quiz}/answers', [QuizController::class, 'submitAnswers']);
});
