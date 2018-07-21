<?php

namespace app\api\controller;

use app\api\model\Address;
use MongoDB\Driver\ReadConcern;
use think\Request;
use app\api\validate\AddressValidate;


class AddressController extends BaseController {
    /**
     * 显示用户地址列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {

        $data = $request->param();
        $rule = ['username'=>'require'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
//        $aa = Address::getList($data);dump($aa);exit;
        return json(Address::getList($data));
    }

    /**
     * 添加地址
     *
     * @return \think\Response
     */
    public function add(Request $request) {
        $data = $request->param();
        $res = $this->validate($data, 'AddressValidate');
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $add = new Address();
        return json($add->saveAdd($data));

    }

    /**
     * 修改地址列表
     *
     */
    public function edit(Request $request){
        $data = $request->param();
        $rules = ['username'=>'require','id'=>'require|number'];
        $res = $this->validate($data, $rules);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $add = new Address();
        return json(['code'=>0,'msg'=>'address/edit','data'=>$add->editAdd($data)]);
    }

    /**
     * 执行修改地址接口
     * @return array
     */
    public function update(Request $request){
        $data = $request->param();
        $res = $this->validate($data, 'AddressValidate');
        if($res !== true){
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $add = new Address();
        return json($add->updAdd($data));
    }

    /**
     * 执行删除地址接口
     */
    public function delete(Request $request){
        $data = $request->param();
        $rules = [
            'username'=>'require',
            'id'=>'require|number',
        ];
        $res = $this->validate($data,$rules);
        if($res !== true){
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $add = new Address();
        return json($add->delAdd($data));
    }

    /**
     * 修改默认地址接口
     */
    public function choose(Request $request){
        $data = $request->param();
        $rules = [
            'username'=>'require',
            'id'=>'require|number',
        ];
        $res = $this->validate($data,$rules);
        if($res !== true){
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $add = new Address();
        return json($add->choAdd($data));
    }
   /*
    *  查询用户默认地址，如果没有，则提示添加，
    * */

   public function default_address(Request $request){
       $data=$request->param();
       $rules = [
           'username'=>'require',
       ];
       $res = $this->validate($data,$rules);
       if($res !== true){
           return json(['code' => __LINE__, 'msg' => $res]);
       }
       return json(Address::getDefault($data['username']));

   }

	/*
	 * 查询订单地址
	 * zhuangxiu-zyg
	 * */
	public function read(Request $request){
		$data=$request->param();
		$rules = [
			'address_id'=>'require',
		];
		$res = $this->validate($data,$rules);
		if($res !== true){
			return json(['code' => __LINE__, 'msg' => $res]);
		}
		return json(Address::read($data['address_id']));
	}

}
