<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
});


Route::resource('/posts', 'App\Http\Controllers\PostsController');
Route::resource('/auth', 'App\Http\Controllers\AuthController');
Route::resource('/tags', 'App\Http\Controllers\TagController');


Route::middleware('notauthentificated')->group(function (){
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::get('/register', [AuthController::class, 'showRegister']);
});

Route::middleware('authentificated')->group(function (){
    Route::get('/createpost', [PostsController::class, 'createPost']);
    Route::get('/logout', [AuthController::class, 'destroy']);
    Route::post('/createcomment', [CommentsController::class, 'store']);
    Route::get('/deletecomment/{id}', [CommentsController::class, 'destroy']);
    Route::get('/updatecomment/{id}', [CommentsController::class, 'showUpdateComment']);
    Route::put('/updatecomment/{id}', [CommentsController::class, 'update']);
    Route::get('/updatepost/{id}', [PostsController::class, 'showUpdatePost']);
});
Route::get('/email/verify/{id}', [AuthController::class, 'verifyEmail']);

