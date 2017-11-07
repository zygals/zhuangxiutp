<?php

namespace app\api\model;

use think\Model;

class Fankui extends Base {
    public function getStAttr($value){
        $st = [0=>'deleted',1=>'正常','不显示'];
        return $st[$value];
    }

    public  function addFankui($data) {
        $good = OrderGood::getGood($data['order_id']);
//        dump($good);exit;
        $user_id = User::getUserIdByName($data['user_name']);
        unset($data['user_name']);
        $data_['order_id']= $data['order_id'];
        $data_['user_id']= $user_id;
        $data_['cont']= $data['cont'];
        $data_['shop_id']= $data['shop_id'];
        $this->save($data_);
        Dingdan::updateSt(['st'=>'fankui','order_id'=>$data['order_id']]);

        return ['code'=>0,'msg'=>'add fankui ok'];
    }
    public static function getListPage($data=[]){
        $list_ = self::where(['fankui.st'=>['<>',0]])->join('dingdan','fankui.order_id=dingdan.id')->join('user','fankui.user_id=user.id')->join('shop','fankui.shop_id=shop.id')->field('fankui.*,dingdan.orderno,user.username username,shop.name shop_name')->paginate();
        return $list_;
    }
    public static function getList($data){
        $user_id = User::getUserIdByName($data['user_name']);
        if(is_array($user_id)){
            return $user_id;
        }
        $list_ = self::where(['user_id'=>$user_id,'fankui.st'=>1])->join('good','good.id=fankui.good_id')->join('user','fankui.user_id=user.id')->field('fankui.*,good.img,good.title,cont,nickname,vistar')->paginate();
        return ['code'=>0,'msg'=>'get fankui ok','data'=>$list_];
    }
    //wx
    public static function delRow($data){
        $row_ = self::where(['order_id'=>$data['order_id'],'good_id'=>$data['good_id'],'st'=>1])->find();
        if(!$row_){
            return ['code'=>__LINE__,'msg'=>'不存在'];
        }
        $row_->st=0;
        $row_->save();
        return ['code'=>0,'msg'=>'删除成功'];
    }


}
