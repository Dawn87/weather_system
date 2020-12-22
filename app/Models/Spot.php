<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    public function city(){
        return $this->belongsTo('App\Models\City');
    }

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }

    protected $fillable = ['name', 'info', 'address', 'image', 'city_id'];
}
