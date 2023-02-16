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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//posts
// Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);

Route::get('/posts', [App\Http\Controllers\Api\PostController::class, 'index']);
Route::get('/posts/{param}', [App\Http\Controllers\Api\PostController::class, 'show']);
Route::delete('/posts/{param}', [App\Http\Controllers\Api\PostController::class, 'destroy']);
Route::post('/posts', [App\Http\Controllers\Api\PostController::class, 'store']);
Route::put('/posts/{param}', [App\Http\Controllers\Api\PostController::class, 'update']);

Route::get('/', [App\Http\Controllers\Controller::class, 'checkConnection']);

Route::get('/guest-books', [App\Http\Controllers\Api\GuestBookController::class, 'index']);
Route::post('/guest-books', [App\Http\Controllers\Api\GuestBookController::class, 'store']);
Route::put('/guest-books/{param}', [App\Http\Controllers\Api\GuestBookController::class, 'update']);
