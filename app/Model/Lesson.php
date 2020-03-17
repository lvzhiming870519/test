<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
