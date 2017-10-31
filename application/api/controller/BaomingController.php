<?php

namespace app\api\controller;


use app\back\model\Ad;

use app\back\model\Base;
use app\back\model\Baoming;
use think\Request;


class BaomingController extends BaseController {

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {
        $data = $request->param();
//        dump($data);exit;
//        exit;
        $list_ = Baoming::getList($data);


    }


    /**
     * 报名验房
     *zhuangxiu-zyg
     */
    public function save(Request $request) {
		$data = $request->param();
		$rule = ['truename' => 'require','mobile'=>'require|number','username'=>'require'];
		$res = $this->validate($data, $rule);
		if ($res !== true) {
			return json(['code' => __LINE__, 'msg' => $res]);
		}
		return json((new Baoming)->addBaoMing($data));


    }




}
