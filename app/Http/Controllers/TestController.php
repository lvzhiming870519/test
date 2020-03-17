<?php

namespace App\Http\Controllers;

use App\Model\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\User;
class TestController extends Controller
{
    public function index()
    {

        $user = User::find(1);

        //一对一
        //$data = $user->userinfo->toArray();


        //一对多
        //$data = $user->news->toArray();


        //属于关机
        //$data = $user->group->toArray();

        //多对多
        //data = $user->lessons->toArray();
        $lesson = Lesson::find(1);
        $data = $lesson->users->toArray();
       // $data = $lesson->users->coutn();//统计数量
        epre($data);



    }


}
