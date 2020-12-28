<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Spot;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Exception;
use Log;

class SpotInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //???
        $spot = $user->spots()->find($id);
        //如果已經收藏過
        if ($spot) {
            //刪除景點總收藏

            //刪除收藏紀錄=>沒收藏過
            $user->spots()->detach($id);
            $status = "成功刪除!";
        } else {
            //取得景點資訊??
            $spot = Spot::find($id);
            //增加景點總收藏


            //加入收藏
            $user->spots()->save($spot);
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


    //1.
    function login(Request $request)
    {    $this->middleware('guest');
//        if (Auth::check()) {
//            return redirect()->back()->withErrors('u already login');
//        }
//        else {
            $validator = Validator::make($request->all(),[
                'account' => ['required', 'string'],
                'password' => ['required', 'string', 'min:6'],
            ]);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator);

            } else {

                if (Auth::attempt([
                    'account' => $request->username,
                    'password' => $request->password
                ])){

                    return response()->json('Imlogin', 200);

                } else {

                    return response()->json('Imnotlogin', 200);
                }
            }

//        }
    }

    public function logout(Request $request) {

        Auth::logout();

        return response()->json(logout, 200);

    }

    public function register(Request $request)
    {
        $this->middleware('guest');
        Log::info('register',$request -> input());

        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string'],
            'account' => ['required', 'string', 'unique:users,account'],
            'password' => ['required', 'string', 'min:6'],
            'email' => ['required', 'email'],
            'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator);

        } else {

            $user = \App\User::create([
                'name' => $request['name'],
                'account' => $request['account'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'isAdmin' => User::ROLE_USER, // 預設為一般使用者
            ]);

            if ($request->hasFile('avatar')) {
                $avatar_file = $request->file('avatar');
                $folder_name = 'members';
                $path = public_path($folder_name);
                $name = 'avatar_'.$user->id.'.'.$avatar_file->getClientOriginalExtension();
                $avatar_file->move($path, $name);
                $user->avatar = '/'.$folder_name.'/'.$name;
            }
            $user->save();

             return response()->json(Successstatus, 200);
        }
    }
}
