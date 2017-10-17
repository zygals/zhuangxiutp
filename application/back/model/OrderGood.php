<?php

namespace app\back\model;

use think\Model;

class OrderGood extends model {


    public static function getGood($order_id) {
        $where = ['order_id' => $order_id,'good.st'=>1];

        $list_ = self::where($where)->alias('od')->join('good','od.good_id=good.id')->field('od.*,good.title good_name,good.price,good.img,good.type,good.store')->order('od.create_time asc')->select();

        return $list_;
    }


}
