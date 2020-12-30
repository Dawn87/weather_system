<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class LogoutController extends TestController
{
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json('Imlogout', 200);
    }
    
}