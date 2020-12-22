<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function spots(){
        return $this->hasMany('App\Models\Spot');
    }

    protected $fillable = ['name', 'weather', 'degrees'];
}
