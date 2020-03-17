<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class  Customer extends  Model{
    //模型关联数据表
    public $table = 'customer';
    
    //主键
    public  $primaryKey = 'openid';

    //主键string 需要加这条
    public $incrementing = false;
    //允许批量操作字段
    //public $fillable = ['username','password','create_time',];
    public $guarded = [];//全部允许
    
    public $timestamps = false;
    
}