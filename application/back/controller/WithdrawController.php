<?php

namespace app\back\controller;

use app\back\model\Dingdan;
use app\back\model\Setting;
use think\Request;
use app\back\model\Admin;
use app\back\model\Withdraw;


class WithdrawController extends BaseController{

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request){
        $data = $request->param();
//        dump($data);exit;
        $list_ = Withdraw::getList($data);
        return $this->fetch('index',['list_'=>$list_]);

    }

    /**
     * 收益提现列表
     * @return \think\Response
     */
    public function edit(Request $request){
        $benefit = Admin::getBenefit();$min=Setting::getMinBenefit();
        if($benefit < Setting::getMinBenefit()){
            $this->error('提现最小金额为'.$min);
        }
        $minBenefit = Setting::getMinBenefit(); //限定最小
        $id = session('admin_zhx')->id;
        $remain = Withdraw::getRemain(); //还可提多少
        return $this->fetch('edit',['admin_id'=>$id,'minBenefit'=>$minBenefit,'benefit'=>$benefit,'title'=>'申请提现','act'=>'save','remain'=>$remain]);
    }

    /**
     * 收益提现逻辑处理
     * @param Request $request
     */
    public function save(Request $request){
        $data = $request->param();
        if(!Admin::isShopAdmin()){
            $this->error('非商户管理员没有权限！');
        }
        $min=Setting::getMinBenefit();
        if($data['cash'] < $min){
            $this->error('提现最小金额为'.$min);
        }
        if($data['cash']>Withdraw::getRemain()['remain']){
            $this->error('提现超出收益！');
        }

        $data['admin_id']= session('admin_zhx')->id;
//        dump($data);exit;
        (new Withdraw())->save($data);
        $this->success('申请成功，请等待管理员审核', 'index', '', 3);
    }

    /*
     *
     *将状态改为已通过
     * */
    public function updateSt(Request $request){
        $data=$request->post();
        $rule =['pass_admin'=>'require','withdraw_id'=>'require|number'];
        $res=$this->validate($data,$rule);
        if($res!==true){
            return ['code'=>__LINE__,'msg'=>$res];
        }
        return json(Withdraw::updateWithdrawStOk($data));
    }

}