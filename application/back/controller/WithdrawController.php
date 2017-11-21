<?php

namespace app\back\controller;

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
        $benefit = Admin::getBenefit();
        $minBenefit = Setting::getMinBenefit();
        $id = session('admin_zhx')->id;
        $referer = $request->header()['referer'];
        return $this->fetch('edit',['admin_id'=>$id,'minBenefit'=>$minBenefit,'benefit'=>$benefit,'referer'=>$referer,'title'=>'申请提现','act'=>'update']);
    }

    /**
     * 收益提现逻辑处理
     * @param Request $request
     */
    public function update(Request $request){
        $data = $request->param();
        $referer = $data['referer'];unset($data['referer']);
        $income = $data['benefit']-$data['cash'];
        $admin = new Admin();
        $admin->save(['income'=>$income],['id'=>$data['admin_id']]);
        unset($data['benefit']);
        $withdraw = new Withdraw();
        $withdraw->save($data);
        $this->success('申请成功', 'index', '', 1);
    }

    public function editSt(Request $request){
        $data = $request->param();

//        dump($data);exit;
        $row_ = Withdraw::getListByWithdrawId($data['id']);

//        dump($row_['admin_id']);exit;
        $benefit = Admin::getBenefitByAdminId($row_['admin_id']);
//        dump($benefit);exit;
        $minBenefit = Setting::getMinBenefit();
        $referer = $request->header()['referer'];
        return $this->fetch('edit_st',['row_'=>$row_,'benefit'=>$benefit,'minBenefit'=>$minBenefit,'referer'=>$referer,'act'=>'updateSt','title'=>'修改提现信息']);

    }

    public function updateSt(Request $request){
        $data=$request->param();
//        dump($data);exit;
        $referer = $data['referer'];unset($data['referer']);

        if($this->saveById($data['id'],new Withdraw(),$data)){

            $this->success('修改成功', $referer, '', 1);
        }else{
            $this->error('没有修改', $referer, '', 1);
        }
    }

}