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




// Google地圖API
// Route::get('/getSite', 'SiteController@test');


Route::get('/', 'UserController@welcome');
Route::get('download/{country}', 'SiteController@download')->name('download');

// 搜尋景點
Route::get('/search', 'SiteController@index');
Route::get('/search/result', 'SiteController@search');
Route::get('/search/{country}/{site_id}/message', 'SiteController@siteAllMsg');

// ========================================== Auth ==========================================
// Auth::routes();
// Custom Auth Route
// Authentication Routes...

Route::group(['middleware' => 'guest'], function() {
	// 註冊
	Route::get('/register', function () {
	    return view('test_register');
	});
	Route::post('/register', 'UserController@register');

	// 登入
	Route::get('/login', function () {
	    return view('welcome');
	});
	Route::post('/login', 'UserController@login');
});

// 需登入後才能執行
Route::group(['middleware' => 'auth'], function() {
	// 登出
	Route::get('/logout', 'UserController@logout');
	// 管理員頁面顯示所有帳號
	Route::get('/admin', 'UserController@showAllMemberInfo');
	// 管理員搜尋帳號
	Route::get('/admin/search/account', 'UserController@searchAcount');
	// 管理員顯示所有留言
	Route::get('/admin/message/', 'UserController@showAllMessage');
	Route::get('/admin/message/{country}', 'UserController@showAllMessage');
	// 管理員搜尋留言
	Route::get('/admin/message/{country}/search', 'UserController@searchMessages');
	// 修改個人資料
	Route::get('/updateInfo/{user_id}', 'UserController@updateInfoModal');
	// 修改個人資料
	Route::put('/updateInfo/{user_id}', 'UserController@updateInfo');
	// 重製密碼
	Route::put('/resetPassword/{user_id}', 'UserController@resetPassword');
	// 修改密碼
	Route::put('/updatePassword/{user_id}', 'UserController@updatePassword');
	// 刪除帳戶
	Route::delete('/{user_id}/deleteAccount', 'UserController@deleteAccount');

	// 顯示用戶頁面，顯示個人資料和留言
	Route::get('/user', 'UserController@show_member_message');
	Route::get('/user/{country}', 'UserController@show_member_message');

});

// 需登入：留言功能
Route::group(['middleware' => 'auth'], function() {
	// 顯示該名User的所有留言
	Route::get('/message', 'MsgController@index');
	// 新增留言
	Route::post('/search/{country}/{site_id}/message', 'MsgController@store');
    // 刪除留言
	Route::delete('/message/{country}/{msg_id}', 'MsgController@destroy');
	// 編輯留言
	Route::get('/message/{country}/{msg_id}/edit','MsgController@edit');
	Route::put('/message/{country}/{msg_id}','MsgController@update');
});