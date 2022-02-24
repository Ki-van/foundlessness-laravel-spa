<?php

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\ArticleImageController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\DomainController;
use App\Http\Controllers\API\MarkController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\UserController;
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




Route::apiResource('/article', ArticleController::class);
Route::apiResource('/comment', CommentController::class);
Route::apiResource('/mark', MarkController::class);
Route::apiResource('/tag', TagController::class);
Route::apiResource('/user', UserController::class);
Route::apiResource('/domain', DomainController::class);

Route::post('/storage/images/uploadByFile', [ArticleImageController::class, 'uploadFile']);

Route::group(['prefix' => 'books', 'middleware' => 'auth:sanctum'], function () {

});

