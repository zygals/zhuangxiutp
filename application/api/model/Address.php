<?php

namespace app\api\model;


use think\Model;

class Address extends Base
{

    /**
     * 获取用户地址列表
     * @return array|false|object|\PDOStatement|string|Model
     */
    public static function getList($data){
        $user_id =User::getUserIdByName($data['username']);
        if(is_array($user_id)){
            return $user_id;
        }
        $list_ = self::where( ['user_id'=>$user_id,'address.st'=>1])->field('id,truename,mobile,is_default,pcd,info')->order('address.create_time desc')->paginate();
        if(count($list_)==0){
            return ['code'=>__LINE__,'msg'=>'没数据啊!'];
        }
        return $list_;
    }
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
