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

// 关注按钮
Route::post('question/follower', function(Request $request){
    $followed = \App\Models\Follow::where('question_id', $request->get('question'))
                 ->where('user_id', $request->get('user'))
                 ->count();
    if($followed)
    {
        return response()->json(['followed' => true]);
    }
   return response()->json(['followed' => false]);
})->middleware('auth:api');

// 关注动作
Route::post('question/follow', function(Request $request){
    $followed = \App\Models\Follow::where('question_id', $request->get('question'))
        ->where('user_id', $request->get('user'))
        ->first();

    // 取消关注
    if($followed !== null)
    {
        $followed->delete();
        return response()->json(['followed' => false]);
    }

    // 添加关注
    \App\Models\Follow::create([
        'question_id' => $request->get('question'),
        'user_id'     => $request->get('user')
    ]);
    return response()->json(['followed' => true]);
})->middleware('api');
