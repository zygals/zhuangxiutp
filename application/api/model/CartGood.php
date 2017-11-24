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
                return ['code' => __LINE__, 'msg' => '添加失败'];
            }
            return ['code' => 0, 'msg' => '添加成功'];
        }
        //dump($row_);exit;
        $row_->num += $data['num'];
        if (!$row_->save()) {
            return ['code' => __LINE__, 'msg' => '修改失败'];
        }
        return ['code' => 0, 'msg' => '修改成功'];
    }

    /*
     * useing
     * */
    public static function getGoodsByShop($shop_id) {
        $list_ = self::where(['cart_good.shop_id'=>$shop_id,'cart_good.st'=>1,'good.st'=>1])->join('good','cart_good.good_id=good.id')->field('cart_good.id cart_good_id,cart_id,cart_good.shop_id,good_id,num,good.name good_name,good.img,good.price,good.unit')->select();
        return $list_;
    }

}
