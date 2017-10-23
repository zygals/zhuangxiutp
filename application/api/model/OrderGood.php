<?php

namespace app\api\model;

use think\Model;

class OrderGood extends model {
    const ST_PREPARE = 1;
    const ST_SENT = 2;
    const ST_TAKEN = 3;
    const ST_RETURN = 4;

    public static function getGood($order_id) {

        $where = ['order_id' => $order_id,'good.st'=>1];
        $list_ = self::where($where)->alias('od')->join('good','od.good_id=good.id')->field('od.*,good.name good_name,good.price,good.img')->order('od.create_time asc')->select();

        return $list_;
    }

    public static  function getGoodOn($good_id){
        $list_ = self::where("good_id=:good_id  and (st=1 or st=2)",['good_id'=>$good_id])->fetchSql()->find();
      //dump($list_);exit;
        return $list_;
    }


}
