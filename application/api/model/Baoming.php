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
            return ['code' => __LINE__, 'msg' => '修改失败'];
        }
        return ['code' => 0, 'msg' => '修改成功'];
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
        $row_ = self::where(['user_id' => $user_id,'st'=>['<>',0]])->order('create_time desc')->field('truename,mobile,address,id,from_unixtime(time_to,"%Y-%m-%d") time_to,st')->find();
	 if($row_->time_to=='1970-01-01'){
		 $row_->time_to='';
	 }
        if ($row_) {
            return ['code' => 0, 'msg' => '数据成功', 'data' => $row_];
        }
        return ['code' => __LINE__, 'msg' => '暂无数据'];
    }


}
