<?php

namespace app\api\model;

use think\Model;

class ActivityAttend extends Base {

    public static function getMyAttend($username) {
        $user_id = User::getUserIdByName($username);
        if (is_array($user_id)) {
            return $user_id;
        }
        $list_ =self::where(['user_id'=>$user_id])->field('activity_attend.*,activity.name activity_name')->join('activity','activity.id=activity_attend.activity_id')->select() ;
        if($list_->isEmpty()){
return ['code'=>__LINE__,'msg'=>'报名不存在'];
        }
        return ['code'=>0,'msg'=>'attend ok','data'=>$list_];
    }


}
