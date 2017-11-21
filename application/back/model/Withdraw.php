<?php

namespace app\back\model;

use think\Model;
use think\Request;

class Withdraw extends Base{
    public static $stStatus  = [1=>'待审核',2=>'已通过',3=>'未通过'];
    public static $cashStStatus  = [0=>'待转账',1=>'转账成功',2=>'转账失败'];

    public function getStAttr($value){
        $status = [1 => '待审核', 2 => '通过', 3 => '未通过'];
        return $status[$value];
    }

    public function getCashStAttr($value){
        $status = [0 => '待转账',1 => '转账成功', 2 => '转账失败'];
        return $status[$value];
    }

    public static function getList($data,$field=['withdraw.*,admin.truename admin_truename,admin.name admin_name']){
        $order = 'create_time desc';
//        dump(session('admin_zhx'));exit;
        $where = '';
        $time_from = isset($data['time_from'])?$data['time_from']:'';
        $time_to = isset($data['time_to'])?$data['time_to']:'';
        if(Admin::isShopAdmin()){
            $where['withdraw.admin_id'] = session('admin_zhx')->id;
        }
        if(!empty($time_from)){
            $where['withdraw.create_time']=['gt',strtotime($time_from)];
        }
        if(!empty($time_to)){
            $where['withdraw.create_time']=['lt',strtotime($time_to)];
        }
        if(!empty($time_to) && !empty($time_from)){
            $where['withdraw.create_time']=[['gt',strtotime($time_from)],['lt',strtotime($time_to)]];
        }
        if(!empty($data['cash'])){
            $where['cash']= $data['cash'];
        }
        if(!empty($data['st'])){
            $where['withdraw.st']= $data['st'];
        }
        if(!empty($data['cash_st'])){
            $where['withdraw.cash_st']= $data['cash_st'];
        }
//        dump($where);exit;
        $list_ = self::where($where)->join('admin','admin.id=withdraw.admin_id')->field($field)->order($order)->paginate(10);
        return $list_;
    }

    public static function getListByWithdrawId($id,$field='withdraw.*,admin.truename admin_truename'){
        $row_ = self::join('admin','admin.id=withdraw.admin_id')->field($field)->where(['withdraw.id'=>$id])->find();
        return $row_;
    }
}

