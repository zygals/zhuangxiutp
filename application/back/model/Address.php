<?php

namespace app\back\model;

use think\Model;

class Address extends Base
{

    //use
    public static function getUserDefaultAddress($user_id){
        $row_ = self::where(['user_id'=>$user_id])->order('create_time desc')->find();
        if(!$row_){
            $row_ = (object)['id'=>0];
        }
        // dump($user_id);exit;
        return $row_;
    }

    // use
    /*
     *
如果没有地址则添加，在添加完，要更新订单的地址
     * */
    public function addAddress($data){
        $order_id = $data['order_id'];
        unset($data['order_id']);
        $user_id = User::getUserIdByName($data['user_name']);
        unset($data['user_name']);

        $data['user_id'] = $user_id;

        if($this->save($data)){
            $m_order = new Dingdan();
            $m_order->save(['address_id'=>$this->id],['id'=>$order_id]);
            return ['code'=>0,'msg'=>'add address ok','data'=>$this->id];
        }else{
            return [__LINE__,'add address error'];
        }
    }
    public static function read($address_id){
            return self::find($address_id);
    }
}
