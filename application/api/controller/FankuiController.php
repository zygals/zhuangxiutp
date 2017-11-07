<?php

namespace app\api\controller;

use app\api\model\Dingdan;
use app\api\model\Fankui;
use app\api\model\OrderGood;
use app\back\model\Shop;
use think\Request;


class FankuiController extends BaseController {

    // wx
    public function index(Request $request) {
        $data = $request->param();
        $rule = ['user_name' => 'require'];
        $res = $this->validate($data, $rule);
        if (true !== $res) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json(Fankui::getList($data));
    }



    /**
     * 保存新建的资源
     * use
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
        $data = $request->param();
        $rules = [
            'user_name' => 'require',
            'order_id' => 'require|number',
            'cont' => 'require',
            'shop_id'=>'require|number',
        ];
        $res = $this->validate($data, $rules);
        if (true !== $res) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }

        return json((new Fankui())->addFankui($data));
    }

    /**
     * 获取评价商品信息
     */
    public function getInfo(Request $request){
        $data = $request->param();
        //获取订单信息&店铺信息&商品信息
        $list_ = OrderGood::getListByOrderId($data['order_id']);
        return json(['code'=>0,'msg'=>'fankui/getInfo','data'=>$list_]);
    }



    /**
     * 显示指定的资源 use
     *
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

    public function delete(Request $request){
        $data = $request->param();
        $rule = ['order_id' => 'require','good_id'=>'require|number'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }

        return json(Fankui::delRow($data));
    }

}
