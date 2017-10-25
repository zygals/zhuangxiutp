<?php

namespace app\api\controller;

use app\api\model\Address;
use MongoDB\Driver\ReadConcern;
use think\Request;


class AddressController extends BaseController {
    /**
     * 显示用户地址列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {

        $data = $request->param();
        $rule = ['username' => 'require'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
//        $aa = Address::getList($data);dump($aa);exit;
        return json(Address::getList($data));
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create() {


    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
        //return 234;
        $data = $request->param();
        $rules = ['order_id' => 'require|number', 'user_name' => 'require', 'true_name' => 'require', 'mobile' => 'require', 'pcd' => 'require', 'info' => 'require'];
        $res = $this->validate($data, $rules);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $m_ = new Address();
        return json($m_->addAddress($data));

    }
   public function read(Request $request){
       $data = $request->param();
       $rules = ['address_id' => 'require|number'];
       $res = $this->validate($data, $rules);
       if ($res !== true) {
           return json(['code' => __LINE__, 'msg' => $res]);
       }
       return json(['code'=>0,'msg'=>'address/read','data'=>Address::read($data['address_id'])]);
   }
}
