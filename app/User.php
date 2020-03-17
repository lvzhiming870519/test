<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //return $this->hasMany('App\Models\post','外键','主键')->select('id','content','title');


    //一对一
    protected function userinfo(){
        return $this->hasOne('App\Model\UserInfo');
    }

    //一对多
    public function news()
    {
        return $this->hasMany('App\Model\News');
    }

    //属于关系
    public function group(){
        return $this->belongsTo('App\Model\Group');
    }

    //多对多中间表名称  按表名手字母  A-Z 排名 比如 banner 和 coupon  就为banner_coupon
    public function lessons(){
        return $this->belongsToMany('App\Model\Lesson');
    }

}
