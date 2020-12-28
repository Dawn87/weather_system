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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//查詢某城市景點資訊:變數傳城市名稱
Route::get('/select_spots/{name}', [App\Http\Controllers\api\SpotInfoController::class, 'show']);
//更新收藏狀態:變數傳景點id
Route::put('/update_fav/{id}', [App\Http\Controllers\api\SpotInfoController::class, 'update']);
//登入
//Route::get('api/login', [App\Http\Controllers\api\SpotInfoController::class, 'create']);
//Route::post('api/login', [App\Http\Controllers\api\SpotInfoController::class, 'store']);
//Route::get('api/logout', [App\Http\Controllers\api\SpotInfoController::class, 'destroy']);

//Route::POST('/logintemp', [App\Http\Controllers\api\SpotInfoController::class, 'login']);

//註冊
//Route::get('api/register', [App\Http\Controllers\api\SpotInfoController::class, 'create']);
//Route::post('api/register', [App\Http\Controllers\api\SpotInfoController::class, 'store']);
//Route::POST('/registertemp', [App\Http\Controllers\api\SpotInfoController::class, 'register']);


//Test
Route::middleware('auth:api')->get('/member', function (Request $request) {
    return $request;
});

Route::post('/register', [App\Http\Controllers\TestRegisterController::class, 'register']); //註冊
Route::post('/login', [App\Http\Controllers\TestLoginController::class, 'login']); //登入


Route::middleware('auth:api')->get('member', 'TestMemberController@index');  //查看
Route::middleware('auth:api')->put('member', 'TestMemberController@update'); //編輯
Route::middleware('auth:api')->delete('member/{members}', 'TestMemberController@destroy'); //刪除
Route::middleware('auth:api')->get('logout', 'TestLogoutController@logout'); //登出
