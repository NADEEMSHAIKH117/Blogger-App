<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\UserController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::post('createBlog',[BlogController::class, 'createBlog']);
    Route::get('displayBlogById',[BlogController::class, 'displayBlogById']);

    Route::post('createComment',[CommentsController::class, 'createComment']);
    Route::get('displayCommentsById',[CommentsController::class, 'displayCommentsById']);
    Route::post('addCommentByNoteId',[CommentsController::class, 'addCommentByNoteId']);
});
