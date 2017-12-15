<?php

namespace app\back\model;

use think\Db;

class Withdraw extends Base{
    public static $stStatus  = [1=>'待转账',2=>'转账成功'];
    protected $dateFormat='Y-m-d H:i:s';

    public function getStAttr($value){
        $status = [1 => '待转账',2 => '转账成功'];
        return $status[$value];
    }

    public static function getList($data,$field=['withdraw.*,admin.truename admin_truename,admin.name admin_name']){
        $order = 'create_time desc';
//        dump(session('admin_zhx'));exit;
        $where = '';
        /*$time_from = isset($data['time_from'])?$data['time_from']:'';
        $time_to = isset($data['time_to'])?$data['time_to']:'';*/
        if(Admin::isShopAdmin()){
            $where['withdraw.admin_id'] = session('admin_zhx')->id;
        }
       /* if(!empty($time_from)){
            $where['withdraw.create_time']=['gt',strtotime($time_from)];
        }
        if(!empty($time_to)){
            $where['withdraw.create_time']=['lt',strtotime($time_to)];
        }
        if(!empty($time_to) && !empty($time_from)){
            $where['withdraw.create_time']=[['gt',strtotime($time_from)],['lt',strtotime($time_to)]];
        }*/
        if(!empty($data['cash'])){
            $where['cash']= $data['cash'];
        }
        if(!empty($data['st'])){
            $where['withdraw.st']= $data['st'];
        }
        if(!empty($data['cash_st'])){
            $where['withdraw.cash_st']= $data['cash_st'];
        }
        if (!empty($data['paixu'])) {
            $order = 'withdraw.'.$data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = 'withdraw.'.$data['paixu'] . ' desc';
        }
//        dump($where);exit;
        $list_ = self::where($where)->join('admin','admin.id=withdraw.admin_id')->field($field)->order($order)->paginate(10);
        return $list_;
    }

    public static function getListByWithdrawId($id,$field='withdraw.*,admin.truename admin_truename'){
        $row_ = self::join('admin','admin.id=withdraw.admin_id')->field($field)->where(['withdraw.id'=>$id])->find();
        return $row_;
    }
    /*
     * 还可提现多少
     * */
    public static function getRemain(){
        $income=Admin::getBenefit();
        $sum_widthdraw = self::where(['admin_id'=>session('admin_zhx')->id,'st'=>1])->field('cash')->sum('cash');
        return ['already_apply'=>$sum_widthdraw,'remain'=>$income-$sum_widthdraw];
    }
    public static function updateWithdrawStOk($data){
        if(is_array($ret=Admin::passRight($data['pass_admin']))){
            return $ret;
        }
        $row_ = self::where(['id'=>$data['withdraw_id']])->find();
        if($row_->st=='转账成功'){
            return ['code'=>__LINE__,'msg'=>'已通过'];
        }
        $admin_income = self::getById($row_->admin_id,new Admin());
        if(!$admin_income){
            return ['code'=>__LINE__,'msg'=>'管理员禁用或不存在'];
        }
        Db::startTrans();

        try{
            $row_->st=2;
            $row_->save();
            $admin_income->setDec('income',$row_->cash);
            $admin_income->setInc('withdraw_ok',$row_->cash);
            // 提交事务
            Db::commit();
            return ['code'=>0,'msg'=>'通过成功'];

        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return ['code'=>__LINE__,'msg'=>'通过失败'];

        }



    }
}

