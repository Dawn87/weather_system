<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\TaiwanMessage;
use App\KoreaMessage;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';
    const ROLE_ADMIN = '1';
    const ROLE_USER = '0';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account','name', 'email', 'password','isAdmin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function isAdmin(){

        if(Auth::user()){

            $rs = User::where('id', Auth::user()->id)->value('isAdmin');
            return $rs == '1' ? true : false;
        }
    }

    public static function getAllMemberInfo () {

        return User::select('id','name','account','email')->orderBy('isAdmin','desc')->paginate(10);
    }

    public static function getOneMemberInfo ($user_id) {

        return User::find($user_id);
    }
    
    // 可以取得該User對TW景點的所有message。
    public function twMessages(){

        return $this->hasMany('App\TaiwanMessage');
    }

    // 可以取得該User對KR景點的所有message。
    public function krMessages(){

        return $this->hasMany('App\KoreaMessage');
    }
}
