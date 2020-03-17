<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\Product;
use App\Model\Order;
use Illuminate\Support\Facades\DB;
class MiaoShaController extends Controller
{
    #创建1000个测试用户
    /*public function AddUserToRedis() {
        Redis::del('user_list_id');
        $user_count = 1000;
        for ($i = 1; $i < $user_count; $i++) {
            //$userinfo['id'] = $i;
            //$userinfo['name'] = "用户》".$i;
            try {
                //Redis::hmset('user_list_info_'.$i,$userinfo);
                Redis::rpush('user_list_id',$i);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        $user_num = Redis::llen('user_list_id');
        echo $user_num;
        epre(Redis::lrange('user_list_id',0,-1));
    }*/
    public function Kill($id) {
        #将需要秒杀的商品放入Redis中
        $this->AddGoodToRedis($id);
        //监控销量
        Redis::watch('sales_'.$id);
        $sales = Redis::get('sales_'.$id);
        if($sales >= Redis::get('good_number_'.$id)){
            exit("秒杀结束");
        }
        //事物 回滚
        Redis::multi();
        Redis::incr('sales_'.$id);
        sleep(2);
        $back = Redis::exec();
        if($back){
            $this->getOrder($id);
        }
    }


    //添加商品
    public function AddGoodToRedis($id) {
        $count = 0;
        if(Redis::exists('good_number_'.$id)){
            //获取redis中库存数量
            echo "redis获取:".Redis::get('good_number_'.$id);
            //$count = Redis::get('good_number_'.$id);
        }else{
            //把库存放入Redis中
            $good = Product::find($id)->toArray();
            if (!$good) {
                //return "商品不存在";
                $this->DoLog("商品不存在");
                return;
            }
            $count = $good['number'];
            Redis::set('good_number_'.$id,$count);
            echo "sql获取:".Redis::get('good_number_'.$id);;
        }
   }

    public function getOrder($id) {
        DB::beginTransaction();
        ///开启事务对库存以及下单进行处理
        try {
            //创建订单
            $order = new Order();
            $order['goods_id'] = $id;
            $order['user_id'] = time();
            $order['goods_number'] = 1;
            $order->save();

            //对商品表进行加锁(悲观锁)
            $good = DB::table("s_goods")->where(['id' => $id])->sharedLock()->first();
            //减少库存
            if ($good) {
                $ok = DB::table('s_goods')->where(['id' => $id])->decrement('number');
                if ($ok) {
                    // 提交事务
                    DB::commit();
                    echo Redis::get('sales_'.$id)."<Br>";
                    echo'下单成功';

                } else {
                    if (!$ok) {
                        return "库存减少失败";
                    }
                }
            } else {
                $this->DoLog("库存剩余为空");
                return "库存剩余为空";
            }
            DB::rollBack();

            return 'error';

        } catch (Exception $e) {

            // 出错回滚数据

            DB::rollBack();

            return 'error';

            //执行其他操作
        }
    }
//
    public function DoLog($log) {
        file_put_contents("test.txt", $log . '\r\n', FILE_APPEND);
    }


    public function Kill2($id) {
        #将需要秒杀的商品放入Redis中 先执行AddGoodToRedis2
        //lpop原子性  一个一个排队  取出第一个商品
        $count = Redis::lpop('good_number2_'.$id);
        if(!$count) {
            echo '被抢光了';
            exit;
        }
        $this->getOrder($id);


//        $data = Redis::lrange('good_number2_'.$id, 0, -1);
//        epre($data);
//        echo "恭喜您抢到了".$count;
//        //$this->DoLog("恭喜您抢到了");
//        $msg ="恭喜您抢到了".$count;
//        Redis::lpush('good_number2_secuess', $msg);
    }

    public function AddGoodToRedis2($id) {
        /*if(Redis::exists('good_number2_'.$id)){
            //获取redis中库存数量
            echo "redis获取:". Redis::llen('good_number2_'.$id);
            //$count = Redis::get('good_number_'.$id);
        }else{*/
            //把库存放入Redis中
            $good = Product::find($id)->toArray();
            if (!$good) {
                //return "商品不存在";
                $this->DoLog("商品不存在");
                return;
            }
            //echo "sql获取:".Redis::get('good_number_'.$id);;
            ///将实际库存添加到Redis中
            //秒杀数量 为 mysql 减去 redis数量
            $kucun = $good['number'] - Redis::llen('good_number2_'.$id);
            for ($i = 0; $i < $kucun; $i++) {
                Redis::lpush('good_number2_'.$id, "商品:".$id);
            }
            epre(Redis::lrange('good_number2_'.$id, 0, -1));
            //echo "sql获取：". Redis::llen('good_number2_'.$id);
        //}
    }


















}
