<?php

namespace app\api\model;

use think\Db;
use think\Model;

class Cart extends Base {

    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常'];
        return $status[$value];
    }

    public function getTypeAttr($value) {
        $status = [1 => '行业', 2 => '百科'];
        return $status[$value];
    }

    /*
     * using zyg
     * */
    public function addCart($data) {
        $user_id = User::getUserIdByName($data['username']);
        if (is_array($user_id)) {
            return $user_id;
        }

        $row_good = self::getById($data['good_id'], new Good);
        if (!$row_good) {
            return ['code' => __LINE__, 'msg' => '无商品'];
        }
        $row_cart = self::where(['user_id' => $user_id, 'shop_id' => $row_good->shop_id])->find();
        if (is_array($row_good)) {
            return $row_good;
        }
        if (!$row_cart) {//没有此商家的购物车
            $data_cart['user_id'] = $user_id;
            $data_cart['shop_id'] = $row_good->shop_id;
            $data_cart['sum_price'] = $row_good->price * $data['num'];

            $this->save($data_cart);
            $data_good = ['cart_id' => $this->id, 'good_id' => $row_good->id, 'shop_id' => $row_good->shop_id, 'num' => $data['num']];
            return (new CartGood)->addGood($data_good);

        }

        $row_cart->sum_price += $row_good->price * $data['num'];
        $row_cart->st = 1;
        $row_cart->save();
        $data_good = ['cart_id' => $row_cart->id, 'good_id' => $row_good->id, 'shop_id' => $row_good->shop_id, 'num' => $data['num']];

        return (new CartGood)->addGood($data_good);

    }

    /*
     * using  zyg
     * */
    public static function getListByUser($username) {
        $user_id = User::getUserIdByName($username);
        if (is_array($user_id)) {
            return $user_id;
        }
        $list_cart = self::where(['user_id' => $user_id, 'cart.st' => 1])->join('shop', 'cart.shop_id=shop.id')->field('cart.id cart_id,cart.shop_id,sum_price,shop.name shop_name')->select();
        if ($list_cart->isEmpty()) {
            return ['code' => __LINE__, 'msg' => '无商品'];
        }
        $sum_price_all = 0;
        if(!$list_cart->isEmpty()){
            foreach ($list_cart as $k => $cart) {
                $list_good = CartGood::getGoodsByShop($cart->shop_id);
                if (!$list_good->isEmpty()) {
                    $sum_price_all += $cart->sum_price;
                    $list_cart[$k]['shop_goods'] = $list_good;
                }

            }
        }

        return ['code' => 0, 'msg' => 'get cart shop and goods ok', 'sum_price_all' => $sum_price_all, 'data' => $list_cart];

    }

    /*
     * using zyg
     * */
    public function deleteGood($data) {

        $user_id = User::getUserIdByName($data['username']);
        if (is_array($user_id)) {
            return $user_id;
        }

        $row_cart_good = self::getById($data['cart_good_id'], new CartGood());
        if (!$row_cart_good) {
            return ['code' => __LINE__, 'msg' => '无商品'];
        }

        $row_good = self::getById($row_cart_good->good_id, new Good(), 'price');
        if (!$row_good) {
            return ['code' => __LINE__, 'msg' => '商品不存在'];
        }
        Db::startTrans();
        try{
            $minus_price = $row_cart_good->num * $row_good->price;

            $row_cart_good->st = 0;
            $row_cart_good->save();

            $row_cart = self::getById($row_cart_good->cart_id, new Cart);
            $row_cart->sum_price -= $minus_price;

            $row_cart_good = CartGood::where(['cart_id'=>$row_cart->id,'st'=>1])->find();
            if (!$row_cart_good) {
                $row_cart->sum_price =0;
                $row_cart->st = 0;
            }
            $row_cart->save();
            Db::commit();
            return ['code' => 0, 'msg' => '删除成功'];
        }catch (\Exception $e){
            Db::rollback();
            return ['code' => __LINE__, 'msg' => '删除失败'];
        }




    }

}
