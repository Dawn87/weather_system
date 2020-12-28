<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use http\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TestController as TestController;



class TestRegisterController extends TestController
{
    public function register(Request $request)
    {
        $this->middleware('guest');
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tests'],
            'password' => ['required', 'string', 'min:6', 'max:12'],
        ]);

//        $apiToken = Str::random(10);
        $create = Test::create([
            'email' => $request['email'],
            'password' => $request['password'],
//            'password' => Hash::make($request['password']),

        ]);

        $create->api_token = str::random(10);
        $create->save();

        if ($create){
//            return "Register as a fucknormal user. Your api token is $apiToken";
            return response()->json('Success', 200);
        } else{
            return response()->json('Fail', 200);
        }



}






//    public function register(Request $request): string
//    {
//        $request->validate([
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
//            'password' => ['required', 'string', 'min:6', 'max:12'],
//        ]);
//
//        $apiToken = Str::random(10);
//        $create = Test::create([
//            'email' => $request['email'],
//            'password' => $request['password'],
//            'api_token' => $apiToken,
//        ]);
//
//        if ($create)
//            return "Register as a normal user. Your api token is $apiToken";
//    }

}
