<?php

namespace app\api\model;

use app\back\model\User;
use think\Model;
use think\Request;

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

        return ['code'=>0,'msg'=>'添加成功'];
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
        return ['code'=>0,'msg'=>'数据成功','data'=>$list_];
    }
    //wx
    public static function delRow($data){
        $id = $data['id'];
        $row_ = self::where(['id'=>$id])->find();
        if(!$row_){
            return ['code'=>__LINE__,'msg'=>'不存在'];
        }
        $row_->st=0;
        $row_->save();
        return ['code'=>0,'msg'=>'删除成功'];
    }
    /**
     * 获取用户所有的评价
     */
    public static function getEvalute($data){
        $user_id = User::getUserIdByName($data);
        $field = 'fankui.*,nickname,vistar';
        $row_ = self::where(['user_id'=>$user_id,'fankui.st'=>1])->join('user','user.id=fankui.user_id','left')->order('create_time desc')->field($field)->paginate();
        if($row_->isEmpty()){
            return ['code'=>__LINE__,'msg'=>'暂无评论'];
        }
        //获取评价数
        $evalute['best'] = self::where(['user_id'=>$user_id,'star'=>1])->count();
        $evalute['mid'] = self::where(['user_id'=>$user_id,'star'=>2])->count();
        $evalute['bad'] = self::where(['user_id'=>$user_id,'star'=>3])->count();
        return ['code'=>0,'msg'=>'数据成功','data'=>$row_,'evalute'=>$evalute];
    }

    /**
     * 获取店铺所有的评价
     */
    public static function getShopEvalute($data){
        $field = 'fankui.*,nickname,vistar';
        $listRows = 4;
        $row_ = self::where('shop_id',$data['shop_id'])->join('user','user.id=fankui.user_id')->order('create_time desc')->field($field)->paginate($listRows);
        if($row_->isEmpty()){
            return ['code'=>__LINE__];
        }
        return ['code'=>0,'msg'=>'数据成功','data'=>$row_];
    }


}
