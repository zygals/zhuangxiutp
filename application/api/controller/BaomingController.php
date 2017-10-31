<?php

namespace app\api\controller;


use app\back\model\Ad;


use app\api\model\Baoming;
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
		$res = $this->validate($data, 'BaomingValidate');
		if ($res !== true) {
			return json(['code' => __LINE__, 'msg' => $res]);
		}
		return json((new Baoming)->addBaoMing($data));

    }




}
