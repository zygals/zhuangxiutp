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
    /**
     * 取我报名
     *zhuangxiu-zyg
     */
    public function read(Request $request) {
        $data = $request->param();
        $rule = ['username'=>'require'];
        $res = $this->validate($data,$rule);
        if($res !== true){
            return json(['code'=>__LINE__,'msg'=>$res]);
        }
        return json( Baoming::findOne($data['username']));

    }
    /**
     * 改我的报名验房
     *zhuangxiu-zyg
     */
    public function update(Request $request) {
        $data = $request->param();
        $res = $this->validate($data, 'BaomingValidate');
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json((new Baoming)->updateBaoMing($data));

    }
	/**
	 *查询报名人数
	 *zhuangxiu-zyg
	 */
/*	public function getnum(Request $request){
		$data = $request->param();
		$rule = ['username'=>'require'];
		$res = $this->validate($data,$rule);
		if ($res !== true) {
			return json(['code' => __LINE__, 'msg' => $res]);
		}
		return json((new Baoming)->getNum($data));

	}*/




}
