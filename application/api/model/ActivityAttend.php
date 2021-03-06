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
        $list_ =self::where(['user_id'=>$user_id,'activity_attend.st'=>1])->field("activity_attend.*, FROM_UNIXTIME( time_to, '%Y-%m-%d %H:%i:%S' ) time_to,activity.name activity_name,activity.address activity_address,activity.img activity_img,activity.type,activity.img_big img_big")->join('activity','activity.id=activity_attend.activity_id')->order('activity_attend.id desc')->select() ;
        if($list_->isEmpty()){
return ['code'=>__LINE__];
        }
        return ['code'=>0,'msg'=>'数据成功','data'=>$list_];
    }

    public static function delMyAttend($id){
       $row = self::where(['id'=>$id])->find();
       $row->st=2;
        $row->save();
        $row_activity= Activity::where(['id'=>$row->activity_id])->find();
        $row_activity->setDec('pnum');
        return ['code'=>0,'msg'=>'删除成功'];
    }


}
