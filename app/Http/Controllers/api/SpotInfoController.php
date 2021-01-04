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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name,$email)
    {
        //取得城市ID
        $city_id = City::where('name', $name)->value('id');
        //取得景點資訊
        $spot = Spot::select('id','name','info','address','image','total_fav')->where('city_id', $city_id)->get();
        //取得城市天氣
        $cityweather = City::find($city_id) ->weather;
        $citydegree = City::find($city_id) ->degrees;
        //假設登入id=2的會員帳號
        //Auth::loginUsingId(2);
        //取得目前登入之會員資料
        $user_id = User::where('email', $email)->value('id');
        $user = User::find($user_id);

        for ($i = 0; $i < count($spot); $i++){
            //判斷是否有收藏
            if ($user->spots()->find($spot[$i]->id))
                $spot[$i]->status = true;
            else
                $spot[$i]->status = false;
        }
        
        $array = array('weather' => $cityweather,'degree' => $citydegree, 'spot_info' => $spot);
        
        return response()->json($array)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, $email)
    {
        //假設登入id=2的會員帳號
        //Auth::loginUsingId(2);
        //取得目前登入之會員資料
        $user_id = User::where('email', $email)->value('id');
        $user = User::find($user_id);
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

    public function popular($email) //顯示popular景點
    {
        $spot = Spot::orderBy('total_fav','desc')->take(10)->get();
        
        for($i = 0; $i < count($spot); $i++)
        {
            $city_id = $spot[$i] ->city_id;
            $cityweather= City::find($city_id) ->weather;
            $citydegree = City::find($city_id) ->degrees; 
            $spot[$i]->weather =  $cityweather;
            $spot[$i]->degree =  $citydegree;
        }
        
        //Auth::loginUsingId(2);

        $user_id = User::where('email', $email)->value('id');
        $user = User::find($user_id);

        for ($i = 0; $i < count($spot); $i++){
            //判斷是否有收藏
            if ($user->spots()->find($spot[$i]->id))
                $spot[$i]->status = true;
            else
                $spot[$i]->status = false;
        }

        return response()->json($spot)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function favorite($email) //顯示使用者收藏景點
    {
        $user_id = User::where('email', $email)->value('id');
        
        $user_fav = User::find($user_id) -> spots ;

        $sortfav = $user_fav -> sortByDesc('id');

        for($i = 0; $i < count($sortfav); $i++)
        {
            $city_id = $sortfav[$i] ->city_id;
            $cityweather= City::find($city_id) ->weather;
            $citydegree = City::find($city_id) ->degrees; 
            $sortfav[$i]->weather =  $cityweather;
            $sortfav[$i]->degree =  $citydegree;
            $sortfav[$i]->status = true;
        }
                        
        return response()->json($sortfav)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
   
    }

    public function member($name,$gender,$email)
    {
        //Auth::loginUsingId(1);
        $user_id = User::where('email', $email)->value('id');
        $user = User::find($user_id);//取得目前登入之會員資料
        //Update原本姓名欄位的資料後save()
        $user ->name = $name; 
        //Update gender
        $user ->gender = $gender;
        $status = $user ->save();
        return response()->json($status);
    }

    public function showmember($email)
    {
        //Auth::loginUsingId(1);
        $user_id = User::where('email', $email)->value('id');
        $user = User::find($user_id);//取得目前登入之會員資料
        
        $useremail = $user ->email;

        $username = $user ->name;
        
        $usergender = $user ->gender;
       
        $array = array('email' => $useremail,'name' => $username, 'gender' => $usergender);
        
        return response()->json($array)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    
    }
}