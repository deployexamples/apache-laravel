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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::group(['prefix' => 'auth'], function () {
// });
// Route::post('/login', 'AuthController@login');
// Route::get('/getLoggedUser','AuthController@getLoggedUser')->middleware('auth:api');



// Route::post('/user', 'UserController@store');
// Route::get('/getUser','UserController@index');
// Route::get('/showUser/{user_id}','UserController@show');



// Route::post('/questionStore','QuestionController@store');
// Route::get('/getQuestion','QuestionController@getQuestion');
// Route::post('/vote/{question_id}','QuestionController@vote');
// Route::get('/show/{question_id}','QuestionController@show');




// Route::post('/commentStore','CommentController@store');
// Route::get('/getAllComment','CommentController@getAllComment');
// Route::get('/getComment/{question_id}','CommentController@getComment');

Route::middleware(['cors'])->group(function () {
    Route::post('/login', 'AuthController@login');
Route::get('/getLoggedUser','AuthController@getLoggedUser')->middleware('auth:api');



Route::post('/user', 'UserController@store');
Route::get('/getUser','UserController@index');
Route::get('/showUser/{user_id}','UserController@show');



Route::post('/questionStore','QuestionController@store');
Route::get('/getQuestion','QuestionController@getQuestion');
Route::post('/vote/{question_id}','QuestionController@vote');
Route::get('/show/{question_id}','QuestionController@show');




Route::post('/commentStore','CommentController@store');
Route::get('/getAllComment','CommentController@getAllComment');
Route::get('/getComment/{question_id}','CommentController@getComment');
});



