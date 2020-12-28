<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Test extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email', 'password',
//        'api_token', 'isAdmin',
    ];
}
