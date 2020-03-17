<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class  Address extends  Model{
    //模型关联数据表
    public $table = 'address';
    
    //主键
    public  $primaryKey = 'openid';
    
    //允许批量操作字段
    //public $fillable = ['username','password','create_time',];
    public $guarded = [];//全部允许
    
    public $timestamps = false;
    
}