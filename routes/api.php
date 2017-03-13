<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// select2 ajax 请求话题选项[20170313]
Route::get('/topics', function(Request $request){
  $topics = \App\Models\Topic::select(['id', 'name'])
      ->where('name', 'like', '%'.$request->query('q').'%')
       ->get();
    return $topics;
})->middleware('api');
