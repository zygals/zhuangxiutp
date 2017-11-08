<?php

namespace app\api\model;

use app\back\model\User;
use think\Model;

class Baoming extends Base {


    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '没验房', 2 => '已验房'];
        return $status[$value];
    }

    public function addBaoMing($data) {
        $user_id = User::getUserIdByName($data['username']);
        if (is_array($user_id)) {
            return $user_id;
        }
        $data['user_id'] = $user_id;
        unset($data['username']);
        if (!empty($data['time_to'])) {
            $data['time_to'] = strtotime($data['time_to']);
        }
        if (!$this->save($data)) {
            return ['code' => __LINE__, 'msg' => 'add baoming error'];
        }
        return ['code' => 0, 'msg' => 'add baoming ok'];
    }

    /**
     * 改我的报名验房
     *zhuangxiu-zyg
     */
    public function updateBaoMing($data) {
        $user_id = User::getUserIdByName($data['username']);
        if (is_array($user_id)) {
            return $user_id;
        }
        $data['user_id'] = $user_id;
        unset($data['username']);
        if (!empty($data['time_to'])) {
            $data['time_to'] = strtotime($data['time_to']);
        }
        $row_ = self::where(['user_id' => $user_id])->find();
        if (!$row_->save($data)) {
            return ['code' => __LINE__, 'msg' => 'update baoming error'];
        }
        return ['code' => 0, 'msg' => 'update baoming ok'];
    }

    /**
     * 查询我的报名
     *zhuangxiu-zyg
     */
    public static function getList($username) {
        $user_id = User::getUserIdByName($username);
        if (is_array($user_id)) {
            return $user_id;
        }
        $list_ = self::where(['user_id' => $user_id,'st'=>['<>',0]])->field('id,truename,mobile,address,create_time,from_unixtime(time_to) time_to,st,article_st')->select();
        if ($list_->isEmpty()) {
            return ['code' => __LINE__, 'msg' => '暂无数据'];
        }
        return ['code' => 0, 'msg' => '数据成功', 'data' => $list_];

    }

    /**
     *查询报名人数
     *zhuangxiu-zyg
     */
/*    public function getNum() {
        $num = $this->count();
        if (!$num) {
            return ['code' => __LINE__, 'msg' => 'baoming num error'];
        }
        return ['code' => 0, 'data' => $num];
    }*/

    /**
     * 取我报名
     *zhuangxiu-zyg
     */

    public static function findOne($username) {
        $user_id = \app\api\model\User::getUserIdByName($username);
        if (is_array($user_id)) {
            return $user_id;
        }
        $row_ = self::where(['user_id' => $user_id,'st'=>['<>',0]])->field('truename,mobile,address,id,from_unixtime(time_to,"%Y-%m-%d") time_to')->find();
        if ($row_) {
            return ['code' => 0, 'msg' => 'my baoming ok', 'data' => $row_];
        }
        return ['code' => __LINE__, 'msg' => 'my baoming no'];
    }


}
