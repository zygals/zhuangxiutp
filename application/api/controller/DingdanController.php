<?php

namespace app\api\controller;

use app\api\model\Dingdan;
use think\Request;


class DingdanController extends BaseController {

    /*
     * 取用户订单列表
     * zhuangxiu-zyg
     * */
    public function index(Request $request) {
        $data = $request->param();
        $rule = ['username' => 'require'];
        $res = $this->validate($data, $rule);
        if (true !== $res) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json(Dingdan::getMyOrders($data));
    }

    /**
     * 更改订单状态或是发货状态
     *zhuangxiu-zyg
     * @return \think\Response
     */
    public function update_st(Request $request) {
        $data = $request->param();
        $rule = ['order_id' => 'require|number','st'=>'require'];
        $res = $this->validate($data, $rule);
        if (true !== $res) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json(Dingdan::updateSt($data));

    }
	/**
	 * 更改订单支付状态为已支付：
	 *zhuangxiu-zyg
	 * @return \think\Response
	 */
	public function update_pay_st(Request $request) {
		$data = $request->param();
		$rule = ['order_id' => 'require|number','st'=>'require','type_'=>'require'];
		$res = $this->validate($data, $rule);
		if (true !== $res) {
			return json(['code' => __LINE__, 'msg' => $res]);
		}
		return json(Dingdan::updatePaySt($data));

	}
    /**
	 * 购物车-》订单确认页-》提交订单
     * zhunagxiu
     * submit order
     * zyg
     */
    public function save_all(Request $request) {
        $data = $request->param();
        $rules = [
            'username' => 'require',
            'shop_good_list' => 'require',
            'sum_price_all' => 'require|float',
            'address_id' => 'require|number',
        ];
        $res = $this->validate($data, $rules);
        if (true !== $res) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json((new Dingdan)->addOrder($data));
    }

	/**
	 * 添加订单--商家订金或是全款
	 * zhunagxiu
	 * submit order
	 * zyg
	 */
	public function save_deposit(Request $request) {
		$data = $request->param();
		$rules = [
			'type_'=>'require|in:4,5',
			'username' => 'require',
			'shop_id' => 'require',
			'sum_price' => 'require|float',
			'address_id' => 'require|number',
		];
		$res = $this->validate($data, $rules);
		if (true !== $res) {
			return json(['code' => __LINE__, 'msg' => $res]);
		}
		return json((new Dingdan)->addOrderDeposit($data));
	}

	/**
	 * 添加订单--团购订金
	 * zhunagxiu- zyg
	 *
	 */
	public function save_group_deposit(Request $request) {
		$data = $request->param();
		$rules = [
			't_id'=>'require',
			'username' => 'require',
			//'shop_id' => 'require',
			//'good_id'=>'require',
			//'price_group' => 'require',
			//'sum_price' => 'require|float',//订金
			'address_id' => 'require|number',
		];
		$res = $this->validate($data, $rules);
		if (true !== $res) {
			return json(['code' => __LINE__, 'msg' => $res]);
		}
		return json((new Dingdan)->addOrderGroupDeposit($data));
	}

    /**
     * 查询某个商家订单
     *zhuangxiu-zyg
     * @param  int $id
     * @return \think\Response
     */
    public function read(Request $request) {
        $data = $request->param();
        $rules = [
            'order_id' => 'require|number',
        ];
        $res = $this->validate($data, $rules);
        if (true !== $res) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $m_ = new Dingdan();
        return json($m_->getOrder($data));

    }
	/*
	 * 我是否下过些团购订金订单？
	 * zhuangxiu-zyg
	 * */
	public function has_order_group_deposit(Request $request){
		$data = $request->param();
		$rules = [
			'username' => 'require',
			't_id' => 'require|number',
		];
		$res = $this->validate($data, $rules);
		if (true !== $res) {
			return json(['code' => __LINE__, 'msg' => $res]);
		}
       return json(Dingdan::hasOrderGroupDeposit($data));
	}

    /*
     * 添加订单-团购  不要了
     * zhuangxiu-zyg
     * */
 /* public function save_group(Request $request){
        $data = $request->param();
        $rules = [
            'username' => 'require',
            'group_id'=>'require|number',
            'address_id'=>'require|number',
        ];
        $res = $this->validate($data, $rules);
        if (true !== $res) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json((new Dingdan)->addOrderGroup($data));

    }*/



}
