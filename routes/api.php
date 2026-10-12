<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


use App\Http\Controllers\TestController;

// API cho bài test
Route::post('/tests/{test_id}/import', [TestController::class, 'importExcel']);
Route::get('/tests/{test_id}', [TestController::class, 'getTestQuestions']);
Route::post('/tests/{test_id}/submit', [TestController::class, 'submitTest']);
