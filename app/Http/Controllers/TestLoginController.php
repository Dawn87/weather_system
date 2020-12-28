<?php

namespace App\Http\Controllers;

use Str;
use App\Models\Test;
use Illuminate\Http\Request;

class TestLoginController extends TestController
{
    public function login(Request $request)
    {
        $member = Test::where('email', $request->email)->where('password', $request->password)->first();
        $apiToken = Str::random(10); //隨機產生一組10個英數字組成的字串
        if($member)
        {
            if ($member->update(['api_token'=>$apiToken]))
            { //更新 api_token
//                if ($member->isAdmin)
//                    return "login as admin, your api token is $apiToken";
//                    return response()->json('Imlogin', 200);
//                else{
//                    return "login as user, your api token is $apiToken";
                    return response()->json('Imlogin', 200);
            }
        }
        else
            {
            return "Wrong email or password！";
        }

    }
}
