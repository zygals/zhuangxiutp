<?php

namespace app\api\controller;

use app\api\model\Dingdan;
use app\api\model\OrderGood;
use app\api\model\Pay;
use app\api\model\User;
use think\Request;
class PayController extends BaseController {
    public function pay_ok(Request $request) {
		//这个回调方法不能调用成功，不知道什么原因？
    }
	/*
	 * 订单支付(可能是多商家的订单)
	 * zhuangxiu-zyg
	 * @order_id :dingdan表中id
	 * */
    public function pay_now(Request $request) {

        $rules = ['username' => 'require', 'order_id' => 'require|number','type_'=>'require'];
		$data = $request->param();
        $res = $this->validate($data, $rules);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
		return json((new Pay)->requestWxPay($data));

    }


}