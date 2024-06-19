<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
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
Route::controller(PostsController::class)->group(function () {
    Route::get('/posts', 'index')->middleware(['default_limit_value']);
    Route::delete('/posts/{post}', 'destroy');
});

Route::controller(CommentsController::class)->group(function () {
    Route::get('/comments', 'index')->middleware(['default_limit_value']);
    Route::post('/comments', 'store');
    Route::delete('/comments/{comment}', 'destroy');
});
