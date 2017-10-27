<?php

namespace app\api\model;

use think\Model;

class CartGood extends model {

    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常'];
        return $status[$value];
    }

    public function getTypeAttr($value) {
        $status = [1 => '行业', 2 => '百科'];
        return $status[$value];
    }
    /*
      * useing
      * */

    public function addGood($data) {
        $row_ = self::where(['good_id' => $data['good_id'], 'st' => 1])->find();
        if (!$row_) {
            if (!$this->save($data)) {
                return ['code' => __LINE__, 'msg' => 'add cart_good error'];
            }
            return ['code' => 0, 'msg' => 'add cart_good ok'];
        }
        //dump($row_);exit;
        $row_->num += $data['num'];
        if (!$row_->save()) {
            return ['code' => __LINE__, 'msg' => 'update cart_good error'];
        }
        return ['code' => 0, 'msg' => 'update cart_good ok'];
    }

    /*
     * useing
     * */
    public static function getGoodsByShop($shop_id) {
        $list_ = self::where(['cart_good.shop_id'=>$shop_id,'cart_good.st'=>1])->join('good','cart_good.good_id=good.id')->field('id cart_good_id,cart_id,cart_good.shop_id,good_id,num,good.name good_name,good.img,good.price')->select();
        return $list_;
    }

}
