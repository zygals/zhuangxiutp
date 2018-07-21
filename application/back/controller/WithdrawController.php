<?php

namespace app\back\controller;

use app\back\model\Dingdan;
use app\back\model\Setting;
use app\back\model\Base;
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
       // dump($data);exit;
        $list_ = Withdraw::getList($data);
        // echo '<pre>';
        // print_r($list_);die;
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data, $page_str);
        return $this->fetch('index',['list_'=>$list_,'page_str'=>$page_str]);

    }

    /**
     * 收益提现列表
     * @return \think\Response
     */
    public function edit(Request $request){
        $keti = Admin::getketixian();//还可提多少
        //$remain = Withdraw::getRemain();
        return $this->fetch('edit',['keti'=>$keti,'title'=>'申请提现','act'=>'save']);
    }

    /**
     * 收益提现逻辑处理
     * @param Request $request
     */
    public function save(Request $request){
        $data = $request->param();
        $rule =['cash'=>'require|number'];
        $res=$this->validate($data,$rule);
        if($res!==true){
            $this->error($res);
        }
        if(!Admin::isShopAdmin()){
            $this->error('非商户管理员没有权限！');
        }
        $min=Setting::getMinBenefit();
        if($data['cash'] < $min){
            $this->error('单次提现金额最小为'.$min);
        }
        $data['admin_id']= session('admin_zhx')->id;
      //  $remian = Withdraw::getRemain();
        /*
        //提现５００，实际确认收货的也是500，则可以提现，如此时提现６００则不能提现，提示失败！
        $confirm_order = Dingdan::getConfirmOrderSum($data['admin_id']);
        if(is_array($confirm_order)){
            $this->error($confirm_order['msg']);
        }
        $withdraw_ok=Admin::where(['id'=>$data['admin_id']])->value('withdraw_ok');
        if($confirm_order>0 && $withdraw_ok>0){
            $shou = $confirm_order-$withdraw_ok;
        }else{
            $shou = $confirm_order;
        }*/
        //$keti = $shou-$remian['already_apply'];
        $keti = Admin::getketixian();
        if($data['cash']  > $keti ){
            $this->error("提现金额超过可提现的金额({$keti} 元)，申请失败");
        }
       /* if($data['cash'] > $remian['remain']){
            $this->error('提现超出可用收益！');
        }*/

        //如果有申请退款的订单，则
        /*$refund=Dingdan::getAllRedundOfMe($data['admin_id']);
        if(is_array($refund)) {
            $this->error($refund['msg']);
        }
        if(($refund + $data['cash']) > Withdraw::getRemain()['remain']){
            $this->error("申请失败，有申请退款的订单合计 {$refund}！");
        }*/
        (new Withdraw())->save($data);
        //锁定收益+
        Admin::increaseLock($data['cash']);
        $this->success('申请成功，申请金额暂时被冻结!请等待管理员审核', 'index', '', 3);
    }

    /*
     *
     *将状态改为已通过或没通过
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
    /*
     *
     *将状态改为已通过或没通过
     * */
    public function update_cashst(Request $request){
        $data=$request->post();
        $rule =['pass_admin'=>'require','withdraw_id'=>'require|number'];
        $res=$this->validate($data,$rule);
        if($res!==true){
            return ['code'=>__LINE__,'msg'=>$res];
        }
        return json(Withdraw::updateCashst($data));
    }

}