<?php

namespace app\back\model;

use think\Db;

class Withdraw extends Base {

    const ST_WAIT = 1; // 待审核
    const ST_OK = 2; //审核成功
    const ST_FAIL = 3; // 审核失败

    public static $stStatus = [1 => '待审核', 2 => '审核通过', 3 => '审核不通过'];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function getStAttr($value) {
        $status = [1 => '待审核', 2 => '审核通过', 3 => '审核不通过',9=>'delete'];
        return $status[$value];
    }

    public function getCashstAttr($value) {
        $status = [1 => '待转账', 2 => '已转账'];
        return $status[$value];
    }

    public static function getList($data, $field = ['withdraw.*,admin.truename admin_truename,admin.name admin_name']) {
        $order = 'create_time desc';
//        dump(session('admin_zhx'));exit;
        $where = '';
        /*$time_from = isset($data['time_from'])?$data['time_from']:'';
        $time_to = isset($data['time_to'])?$data['time_to']:'';*/
        if (Admin::isShopAdmin()) {
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
        if (!empty($data['cash'])) {
            $where['cash'] = $data['cash'];
        }
        if (!empty($data['st'])) {
            $where['withdraw.st'] = $data['st'];
        }
        if (!empty($data['cash_st'])) {
            $where['withdraw.cash_st'] = $data['cash_st'];
        }
        if (!empty($data['paixu'])) {
            $order = 'withdraw.' . $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = 'withdraw.' . $data['paixu'] . ' desc';
        }
//        dump($where);exit;
        $list_ = self::where($where)->join('admin', 'admin.id=withdraw.admin_id')->field($field)->order($order)->paginate(10);
        return $list_;
    }

    public static function getListByWithdrawId($id, $field = 'withdraw.*,admin.truename admin_truename') {
        $row_ = self::join('admin', 'admin.id=withdraw.admin_id')->field($field)->where(['withdraw.id' => $id])->find();
        return $row_;
    }

    /*
     * 还可提现多少
     * */
    public static function getRemain() {
        $income = Admin::getBenefit();
         $lock= Admin::getBenefitLock();
        return ['already_apply' => $lock, 'remain' => $income - $lock];
    }
    /*
     * 还可提现多少
     * */
    public static function getRemainByAdmin($admin_id) {
        $income = Admin::getBenefitByAdmin($admin_id);
         $lock= Admin::getBenefitLockByAdmin($admin_id);
        return ['already_apply' => $lock, 'remain' => $income - $lock];
    }


    public static function updateCashst($data) {
        if (is_array($ret = Admin::passRight($data['pass_admin']))) {
            return $ret;
        }
        $row_ = self::where(['id' => $data['withdraw_id']])->find();
        if ($row_->cashst == 2) {
            return ['code' => __LINE__, 'msg' => '已转账'];
        }
        $admin_shop = self::getById($row_->admin_id, new Admin());
        Db::startTrans();
        try {
            $row_->cashst = 2;
            $row_->transfer_time = time();
            $row_->save();
            $admin_shop->setDec('income', $row_->cash);
            $admin_shop->setInc('withdraw_ok', $row_->cash);
            $admin_shop->setDec('income_lock',$row_->cash); //冻结减
            Db::commit();
            return ['code' => 0, 'msg' => '已转账'];
        } catch (\Exception $e) {
            Db::rollback();
            return ['code' => __LINE__, 'msg' => '已转账失败'];
        }

    }


    /*
     *
        审核
        1、如通过，则状态为审核通过（同时线下转账后）、可后台操作转账（维护数据正确性：1、收益减；2、冻结减）
        2、如不通过，则状态不通过，后台无后续操作（维护数据正确性：1、冻结减 ；2、收益加）

     * */
    public static function updateWithdrawStOk($data) {
        if (is_array($ret = Admin::passRight($data['pass_admin']))) {
            return $ret;
        }
        $row_ = self::where(['id' => $data['withdraw_id']])->find();

        $admin_shop = self::getById($row_->admin_id, new Admin());

        if (!$admin_shop) {
            return ['code' => __LINE__, 'msg' => '管理员禁用或不存在'];
        }

        Db::startTrans();

        try {
            $refund = Dingdan::getAllRedundOfMe($row_->admin_id);
            if (is_array($refund)) {
                return $refund;
            }
            //2100      4000-2000
            $remain = self::getRemainByAdmin($row_->admin_id);
            $confirm_order = Dingdan::getConfirmOrderSum($row_->admin_id);
            if($row_->cash + $remain['already_apply'] > $confirm_order){
                $row_->st = self::ST_FAIL;
                $row_->verify_time = time();
                $row_->save();
                $admin_shop->setDec('income_lock',$row_->cash); //冻结减
                Db::commit();
                return ['code' => 0, 'msg' => "提现金额超过实际收货的订单（订金或全款）:({$confirm_order}元)，审核失败"];
            }

            if ($refund + $row_->cash > $remain['remain']) {
                $row_->st = self::ST_FAIL;
                $row_->verify_time = time();
                $row_->save();
                $admin_shop->setDec('income_lock',$row_->cash); //冻结减
                Db::commit();
                return ['code' => 0, 'msg' => '申请退款总额>可用收益,审核失败！'];
            }

            $row_->st = self::ST_OK;
            $row_->verify_time = time();
            $row_->save();
            // 提交事务
             Db::commit();
            return ['code' => 0, 'msg' => '审核通过，请于线下转账给商家' . $row_->cash . '元，并在后台维护数据正确性！'];

        } catch (\Exception $e) {
            // 回滚事务

            Db::rollback();
            return ['code' => __LINE__, 'msg' => '通过失败'];

        }


    }

    /*
     * 商户有是否有申请提现
     * */
    public static function haveWithdraw($shop_id) {
        $admin_ = Admin::where(['shop_id' => $shop_id, 'st' => 1])->find();
        if (!$admin_) {
            return ['code' => __LINE__, 'msg' => '管理员禁用或删除'];
        }
        $row_1 = self::where(['admin_id' => $admin_->id, 'st' => self::ST_WAIT])->find();
        $row_2= self::where(['admin_id' => $admin_->id, 'st' => self::ST_OK,'cashst'=>1])->find();
        if (!$row_1 && !$row_2) {
            return false;
        }
        return true;
    }
}

