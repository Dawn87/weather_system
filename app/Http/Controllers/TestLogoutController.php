<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Test;

class TestLogoutController extends Controller
{
    public function logout()
    {
        if ( Auth::user()->update(['api_token'=>'logged out'])) { //更新api token
            return "You've logged out";
        }
    }
}
