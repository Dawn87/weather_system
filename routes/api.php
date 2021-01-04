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
Route::get('/select/{name}/{email}', [App\Http\Controllers\api\SpotInfoController::class, 'show']);
//更新收藏狀態:變數傳景點id
Route::put('/update/{id}/{email}', [App\Http\Controllers\api\SpotInfoController::class, 'update']);

Route::get('/fav/{email}',[App\Http\Controllers\api\SpotInfoController::class, 'favorite']);

Route::get('/pop/{email}',[App\Http\Controllers\api\SpotInfoController::class, 'popular']);

Route::post('/member/{name}/{gender}/{email}',[App\Http\Controllers\api\SpotInfoController::class, 'member']);

Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']); //註冊
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']); //登入
Route::post('/logout', [App\Http\Controllers\LogoutController::class, 'logout']); //登出

