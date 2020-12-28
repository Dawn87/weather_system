<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Spot;
use App\Models\User;
use Auth;
use DB;

class SpotInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function popular() //顯示popular景點
    {
        $spot = Spot::orderBy('total_fav','desc')->take(10)->get();

        return response()->json($spot)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function favorite($email) //顯示使用者收藏景點
    {
        $user_id = User::where('email', $email)->value('id');
        
        $user_fav = User::find($user_id) -> spots;
        
        return response()->json($user_fav)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $city_id = City::where('name', $name)->value('id');
        //取得景點資訊
        $spot = Spot::select('id','name','info','address','image','total_fav')->where('city_id', $city_id)->get();
        //假設登入id=2的會員帳號
        Auth::loginUsingId(2);
        //取得目前登入之會員資料
        $user = Auth::user();

        for ($i = 0; $i < count($spot); $i++){
            //判斷是否有收藏
            if ($user->spots()->find($spot[$i]->id))
                $spot[$i]->status = true;
            else
                $spot[$i]->status = false;
        }
        
        return response()->json($spot)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
    /*
    
    $spot[0]->users()->save($user);  
     $user->spots()->value('spot_id') ==> 1
     $user->spots()->find(1)
     $spot[1]->status = true
    */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //假設登入id=2的會員帳號
        Auth::loginUsingId(2);
        //取得目前登入之會員資料
        $user = Auth::user();
        //檢查spot_user是否有資料
        $spot = $user->spots()->find($id);
        //如果已經收藏過
        if ($spot) {
            //刪除景點總收藏
            $t = $spot->total_fav;
            //if ($t == 0) =>例外
            $t--;
            $spot->total_fav = $t;
            $spot->save();

            //刪除收藏紀錄=>沒收藏過
            $user->spots()->detach($id);
            $status = "成功刪除!";
        } else {
            //取得景點資訊
            $spot_info = Spot::find($id);
            //增加景點總收藏
            $t = $spot_info->total_fav;
            $t++;
            $spot_info->total_fav = $t;
            $spot_info->save();

            //加入收藏
            $user->spots()->save($spot_info);
            $status = "成功新增!";
        }

        return response()->json($status)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
