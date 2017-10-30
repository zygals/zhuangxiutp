<?php

namespace app\api\model;

use think\Model;

class OrderGood extends model {
    const ST_PREPARE = 1;
    const ST_SENT = 2;
    const ST_TAKEN = 3;
    const ST_RETURN = 4;

	public function getStAttr($value){
		$status = [1 => '没发货', 2 => '已发货',3=>'已收货'];
		return $status[$value];
	}
    public static function getGood($order_id) {
		$where = ['order_id' => $order_id];
		$list_ = self::where($where)->order('create_time asc')->field('id,name good_name,good_id,price,num,img,st')->select();
		return $list_;

    }

    public static  function getGoodOn($good_id){
        $list_ = self::where("good_id=:good_id  and (st=1 or st=2)",['good_id'=>$good_id])->fetchSql()->find();
      //dump($list_);exit;
        return $list_;
    }


}
