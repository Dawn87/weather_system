<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use http\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TestController as TestController;



class RegisterController extends TestController
{
    public function register(Request $request)
    {
        // $this->middleware('guest');
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'max:12'],
        ]);

//        $apiToken = Str::random(10);
        $create = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'gender' => $request['gender'],
//            'password' => Hash::make($request['password']),

        ]);

        $create->remember_token = str::random(10);
        $create->save();

        if ($create){
//            return "Register as a fucknormal user. Your api token is $apiToken";
            return response()->json('Success', 200);
        } else{
            return response()->json('Fail', 200);
        }



    }
}