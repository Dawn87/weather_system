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
Route::get('/select/{name}', [App\Http\Controllers\api\SpotInfoController::class, 'show']);
//更新收藏狀態:變數傳景點id
Route::put('/update/{id}', [App\Http\Controllers\api\SpotInfoController::class, 'update']);

Route::get('/fav/{username}',[App\Http\Controllers\api\SpotInfoController::class, 'favorite']);

Route::get('/pop',[App\Http\Controllers\api\SpotInfoController::class, 'popular']);

Route::get('/member/{name}/{gender}',[App\Http\Controllers\api\SpotInfoController::class, 'member']);
<<<<<<< HEAD
Route::get('/member',[App\Http\Controllers\api\SpotInfoController::class, 'showmember']);

Route::post('/register', [App\Http\Controllers\TestRegisterController::class, 'register']); //註冊
Route::post('/login', [App\Http\Controllers\TestLoginController::class, 'login']); //登入
=======



Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']); //註冊
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']); //登入
Route::post('/logout', [App\Http\Controllers\LogoutController::class, 'logout']); //登入


>>>>>>> c5f6c125cd3d42b88196fcfa9dd553fa98d3586f
