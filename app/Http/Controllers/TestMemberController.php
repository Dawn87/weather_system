<?php

namespace App\Http\Controllers;

use App\User;
use http\Exception;
use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\TestController as TestController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use luminate\Http\JsonResponse;

class TestMemberController extends TestController
{
    public function index()
    {
        $admins = Test::all();
        $members = [
            'mail' => Auth::user()->email,
            'password' => Auth::user()->password,
        ];
        if (Auth::user()->isAdmin) //是管理者，回傳所有會員資料
            return $this->sendResponse($admins->toArray(), 'Members retrieved successfully.');
        else //不是管理者，回傳該會員自己的資料
            return $members;
    }
    public function adminStore(Request $request) { //管理者註冊的function
        try {
            $request->validate([ //這邊會驗證註冊的資料是否符合格式
                'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
                'password' => ['required', 'string', 'min:6', 'max:12'],
            ]);

            $apiToken = Str::random(10);
            $create = Member::create([
                'email' => $request['email'],
                'password' => $request['password'],
                'isAdmin' => '1',
                'api_token' => $apiToken,
            ]);

            if ($create) {
                return "Register as an admin. Your Token is $apiToken.";
            }

        } catch (Exception $e) {
            sendError($e, 'Registered failed.', 500);

        }

    }
    //註冊
    public function register(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6'],
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {

            return response()->json('Fail', 200);

        } else {

            $user = Test::create([
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            $user->save();
            return response()->json('Success', 200);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Member $members
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [ //修改會員資料一樣要驗證是否符合格式
            'email' => ['string', 'email', 'max:255', 'unique:members'],
            'password' => ['string', 'min:6', 'max:12'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $member = Auth::user();
        if ($member->update($request->all()))
            return $this->sendResponse($member->toArray(), 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Test $members
     * @return string
     */
    public function destroy(Test $members)
    {
        if ( Auth::user()->isAdmin){ //驗證是否為管理者
            if ($members->delete())
                return $this->sendResponse($members->toArray(), 'Test deleted successfully.');
        }
        else
            return "You have no authority to delete";

    }

}
