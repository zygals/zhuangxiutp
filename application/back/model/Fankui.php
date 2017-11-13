<?php

namespace app\back\model;

use think\Model;

class Fankui extends Base {
    public function getStAttr($value){
        $st = [0=>'deleted',1=>'正常','不显示'];
        return $st[$value];
    }
    public function getStarAttr($value){
        $star = [1=>'好评',2=>'中评',3=>'差评'];
        return $star[$value];
    }

    public  function addFankui($data) {
        $good = OrderGood::getGood($data['order_id']);
        $user_id = User::getUserIdByName($data['user_name']);

        $data_['order_id']= $data['order_id'];
        $data_['user_id']= $user_id;
        $data_['good_id']= $good[0]->good_id;
        $data_['cont']= $data['cont'];

        $this->save($data_);
        Dingdan::updateSt(['st'=>'fankui','order_id'=>$data['order_id']]);
        return ['code'=>0,'msg'=>'add fankui ok'];
    }
    public static function getListPage($data=[]){
        $order = 'create_time desc';
        $where = ['fankui.st'=>['<>',0]];
        $time_from = isset($data['time_from'])?$data['time_from']:'';
        $time_to = isset($data['time_to'])?$data['time_to']:'';
        if(!empty($time_from)){
            $where['fankui.create_time']=['gt',strtotime($time_from)];
        }
        if(!empty($time_to)){
            $where['fankui.create_time']=['lt',strtotime($time_to)];
        }
        if(!empty($time_to) && !empty($time_from)){
            $where['fankui.create_time']=[['gt',strtotime($time_from)],['lt',strtotime($time_to)]];
        }
        if(!empty($data['paixu'])){
            $where['star'] = $data['paixu'];
        }
        $list_ = self::where($where)->join('dingdan','fankui.order_id=dingdan.id','left')->join('user','fankui.user_id=user.id','left')->join('shop','fankui.shop_id=shop.id','left')->field('fankui.*,dingdan.orderno,user.username username,shop.name shop_name')->paginate(10);
        return $list_;
    }
    public static function getList($data){
        $user_id = User::getUserIdByName($data['user_name']);
        if(is_array($user_id)){
            return $user_id;
        }
        $list_ = self::where(['user_id'=>$user_id,'fankui.st'=>1])->join('good','good.id=fankui.good_id')->join('user','fankui.user_id=user.id')->field('fankui.*,good.img,good.title,cont,nickname,vistar')->paginate(10);
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
