<?php

namespace app\api\controller;

use app\api\model\Cart;
use think\Request;

class CartController extends BaseController {

    /*
    * 添加购物车：给用户加一个购物车，一个商家对应一个车
    * */
    public function index(Request $request) {
        $data = $request->param();
        $rule = ['username'=>'require'];
        $res = $this->validate($data,$rule);
        //dump( $res);exit;
        if($res !== true){
            return json(['code'=>__LINE__,'msg'=>$res]);
        }
        return json(Cart::getListByUser($data['username']));
    }

    /*
     * 添加购物车：给用户加一个购物车，一个商家对应一个车
     * */
    public function save(Request $request) {
        $data = $request->param();
        //dump( $data);exit;
        $rule = ['username'=>'require','good_id'=>'require|number','num'=>'require|number'];
        $res = $this->validate($data,$rule);
        //dump( $res);exit;
        if($res !== true){
            return json(['code'=>__LINE__,'msg'=>$res]);
        }
        return json((new Cart)->addCart($data));

    }
    /*
     * 删除购物车商品
     * */
    public function delete_good(Request $request) {
        $data = $request->param();
        //dump( $data);exit;
        $rule = ['username'=>'require','cart_good_id'=>'require|number'];
        $res = $this->validate($data,$rule);
        //dump( $res);exit;
        if($res !== true){
            return json(['code'=>__LINE__,'msg'=>$res]);
        }
        return json((new Cart)->deleteGood($data));

    }



}
