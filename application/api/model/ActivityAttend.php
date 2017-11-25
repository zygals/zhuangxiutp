<?php

namespace app\api\model;

use think\Model;

class ActivityAttend extends Base {
	/*
	 * 取我的在线报名
	 * zhuangxiu-zyg
	 * */

    public static function getMyAttend($username) {
        $user_id = User::getUserIdByName($username);
        if (is_array($user_id)) {
            return $user_id;
        }
        $list_ =self::where(['user_id'=>$user_id])->field("activity_attend.*, FROM_UNIXTIME( time_to, '%Y-%m-%d %H:%i:%S' ) time_to,activity.name activity_name,activity.address activity_address,activity.img activity_img,activity.type")->join('activity','activity.id=activity_attend.activity_id')->select() ;
        if($list_->isEmpty()){
return ['code'=>__LINE__];
        }
        return ['code'=>0,'msg'=>'数据成功','data'=>$list_];
    }


}
