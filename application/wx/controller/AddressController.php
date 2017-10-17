<?php

namespace app\wx\controller;

use app\common\model\Address;
use MongoDB\Driver\ReadConcern;
use think\Request;


class AddressController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {

        $m_users = new Address();
        $list = $m_users->getAllAddresss($request);
        //return json_encode($list);
        /*$last_url='';
        $order_id=$request->get('order_id');

        if($order_id!=null){
            $last_url = url('order/index')."?order_id=".$request->get('order_id');
        }*/
        return $this->fetch('index', ['list' => $list/*,'last_url'=>$last_url*/]);
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
