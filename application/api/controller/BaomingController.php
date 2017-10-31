<?php

namespace app\api\controller;


use app\back\model\Ad;


use app\api\model\Baoming;
use think\Request;


class BaomingController extends BaseController {

    /**
     * 查询我的报名
     *zhuangxiu-zyg
     * @return \think\Response
     */
    public function index(Request $request) {
		$data = $request->param();
		$rule = ['username'=>'require'];
		$res = $this->validate($data,$rule);
		//dump( $res);exit;
		if($res !== true){
			return json(['code'=>__LINE__,'msg'=>$res]);
		}
      return json( Baoming::getList($data['username']));
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
