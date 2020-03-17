<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class  UserInfo extends  Model{
    //模型关联数据表
    public $table = 'users_info';
    
    //主键
    public  $primaryKey = 'id';
    
    //允许批量操作字段
    //public $fillable = ['username','password','create_time',];
    public $guarded = [];//全部允许
    
    public $timestamps = false;
    
}