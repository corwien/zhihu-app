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

// 通知
Route::get('notifications', 'NotificationsController@index');
Route::get('notifications/{notification}', 'NotificationsController@show');

// 私信
Route::get('inbox', 'InboxController@index');
Route::get('inbox/{dialogId}', 'InboxController@show');
Route::post('inbox/{dialogId}/store', 'InboxController@store');

// 上传头像
Route::get('avatar', 'UsersController@avatar');
Route::post('avatar', 'UsersController@avatarUpload');

// 密码
Route::get('password', 'PasswordController@password');
Route::post('password/update', 'PasswordController@update');

// 个人设置
Route::get('setting', 'SettingController@index');
Route::post('setting', 'SettingController@store');


