<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('email/verify/{token}', ['as' => 'email.verify', 'uses' => 'EmailController@verify'] );

// 问答路由
Route::resource('questions', 'QuestionsController', ['names' =>
  ['create' => 'question.create'],
  ['show' => 'question.show'],
  ['edit' => 'question.edit'],
]);

Route::Post('questions/{question}/answer', 'AnswersController@store');

// 关注问题,注意，这里的question为变量，在控制器中以该名字获取 question = 10;
Route::get('questions/{question}/follow', 'QuestionFollowController@follow');
