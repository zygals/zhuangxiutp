<?php

namespace app\back\model;

use think\Db;

class Withdraw extends Base {

    const ST_WAIT = 1; // 待审核
    const ST_OK = 2; //审核成功
    const ST_FAIL = 3; // 审核失败

    public static $stStatus = [1 => '待审核', 2 => '审核成功', 3 => '审核失败'];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function getStAttr($value) {
        $status = [1 => '待审核', 2 => '审核通过', 3 => '审核失败'];
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
        $sum_widthdraw = self::where(['admin_id' => session('admin_zhx')->id, 'st' => 1])->field('cash')->sum('cash');
        //echo $income-$sum_widthdraw;exit;
        return ['already_apply' => $sum_widthdraw, 'remain' => $income - $sum_widthdraw];
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
            Db::commit();
            return ['code' => 0, 'msg' => '已转账'];
        } catch (\Exception $e) {
            Db::rollback();
            return ['code' => __LINE__, 'msg' => '已转账失败'];
        }

    }


    /*
     *
     *
     *
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
            }//5   6
            if ($refund > ($admin_shop->income - $row_->cash)) {
                $row_->st = self::ST_FAIL;
                $row_->verify_time = time();
                $row_->save();
                Db::commit();
                return ['code' => 0, 'msg' => '申请退款总额>可用收益,审核失败！'];
            }
            $row_->st = self::ST_OK;
            $row_->verify_time = time();
            $row_->save();

            // 提交事务
            Db::commit();
            return ['code' => 0, 'msg' => '审核成功，请于线下转账给商家' . $row_->cach . '元'];

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
        $row_ = self::where(['admin_id' => $admin_->id, 'st' => 1])->find();
        if (!$row_) {
            return false;
        }
        return true;
    }
}

