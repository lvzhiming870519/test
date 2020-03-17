<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\Customer;
use App\Model\Address;
class RedisController extends Controller
{
    public function detail(){
        return view('redisdetail');
    }
    public function index(){
        return view('redis');
    }

    //通过string  存取list数据
    public function list(){
        $data = [];
        if(Redis::exists('address')){
            $data = json_decode(Redis::get('address'),true);
            echo "redsi";
        }else{
            $data = Address::get()->toArray();
            //一直有效
            Redis::set('address',json_encode($data));
            //10,秒过期
            //Redis::setex('address',10,json_encode($data));
            echo "mysql";
            //epre($data);
        }
        return view('list',compact('data'));
    }
    //哈希存取list数据
    public function list1()
    {
        // 定义Redis的key
        $listKey = 'LIST:Address';
        $hashKey = 'HASH:Address:';
        $data = null;
        // 查看key是否存在？
        if(empty(Redis::exists($listKey))){
            // 如果Redis不存在 读数据库然后写入redis

            $data = Address::get()->toArray();
            // 遍历时写入Redis list为索引 hash为数据
            foreach($data as $v){
                Redis::rpush($listKey,$v['id']);
                Redis::hMset($hashKey.$v['id'],$v);
            }
            echo "sql读取";
            epre($data);
            return;
        }
        // 如果redis存在 直接读redis的数据
        // 取出admin队列的唯一识别id数组
        $list = Redis::lrange($listKey,0,-1);

        foreach($list as $v){
            $data[] = Redis::hGetall($hashKey.$v);
        }
        echo "redis读取";
        //epre($data);
        return view('list',compact('data'));
    }



    public function redistyep() {
        // 清空Redis数据库
        //Redis::flushall();


        // redis的string类型   一个字符串
//        Redis::set("laravel","Hello woshi laravel");
//        epre(Redis::get("laravel")) ;
//        过期时间设置 10秒
//        Redis::setex("laravel",10,"Hello woshi laravel");

//        redis的哈希类型  一条数据
//        Redis::hmset('happy:huizhou',['name'=>"惠州"]);
//        Redis::hmset("fail:xiaoshou",[
//            "lover" => "黑嘿嘿?",
//            'nice' => "我是xiaoshou",
//            '挑衅' => '来打我啊'
//        ]);
//        epre(Redis::hgetall("happy:huizhou"));
//        epre(Redis::hgetall('fail:xiaoshou'));
//        echo "<br/><hr/>";
////        一适合存一条条数据
//        $user = Customer::find('oe99h1qdfZpZoNOWJ23wwGHR0Rlw')->toArray();
//        Redis::hmset('user',$user);
//        epre(Redis::hgetall("user"));


       


//
//        // redis的无序列表  dump
//        Redis::sAdd('huizhou','小东','小追命','小龙女');
//        Redis::sAdd('xiaoshou','小明','小追命','阳光宅猫');
////        #获取无序集合
//       dump(Redis::smembers('huizhou'));
//        dump(Redis::smembers('xiaoshou'));
//        #获取并集
////        dump(Redis::sunion('huizhou','xiaoshou'));
//        #获取交集
//        #dump(Redis::sinter("xiaoshou",'huizhou'));
//        #获取差集  要查那个多出来 就把哪个放前面
//        dump(Redis::sdiff("xiaoshou",'huizhou'));
//        dump(Redis::sdiff('huizhou',"xiaoshou"));
//        echo "<br/><hr/>";
//
//
//        // redis的list链表的使用
//        #栈 -> 先进后出  倒着排
//        Redis::lpush("list1",'one');
//        Redis::lpush("list1",'two');
//        Redis::lpush("list1",'three');
//        dump(Redis::lrange('list1',0,-1));
//
////        #队列 ->先进先出  正这排
//        Redis::rpush('rlist','one');
//        Redis::rpush('rlist','two');
//        Redis::rpush('rlist','three');
//        dump(Redis::lrange("rlist",0,-1));
////        #返回和移除列表的第一个元素
//        dump(Redis::lpop("list1"));
//

       // redis的有序集合
//        Redis::zadd("zlist",1,"小明");
//        Redis::zadd("zlist",3,"惠州");
//        Redis::zadd("zlist",2,"加藤杰");
        #正的输入
//        dump(Redis::zrange("zlist",0,-1));
        #反的输入
//        dump(Redis::zrevrange("zlist",0,-1));

//        lsize,llen
//        描述：返回的列表的长度。如果列表不存在或为空，该命令返回0。如果该键不是列表，该命令返回FALSE。
    }




}
