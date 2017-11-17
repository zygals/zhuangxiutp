<?php

namespace app\api\controller;

use app\api\model\Dingdan;
use app\api\model\OrderGood;
use app\api\model\Pay;
use app\api\model\User;
use think\Request;
class PayController extends BaseController {
    public function pay_ok(Request $request) {
		/*$res =$request->param();
        $f=fopen('pay.txt','w');
		fwrite($f,json_encode($res));*/

    }
	/*
	 * 订单支付(可能是多商家的订单)
	 * zhuangxiu-zyg
	 * @order_id :dingdan表中id
	 * */
    public function pay_now(Request $request) {

//        dump($request->domain());
        $rules = ['username' => 'require', 'order_id' => 'require|number','type_'=>'require'];
		$data = $request->param();
        $res = $this->validate($data, $rules);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
		return json((new Pay)->requestWxPay($data,$request));

    }
    public function refund(Request $request){
        $rules = ['order_id' => 'require', 'admin_pass' => 'require'];
        $data = $request->param();
        $res = $this->validate($data, $rules);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json((new Pay)->refundToUser($data));

    }


}