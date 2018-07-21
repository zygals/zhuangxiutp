<?php

namespace app\api\model;

use think\Model;
use app\api\model\GoodAttr;

class Collect extends Base {




    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常'];
        return $status[$value];
    }//wx
    public function addCollect($good_id,$user_name){
        $user_id = User::getUserIdByName($user_name);
        if(is_array($user_id)){
            return $user_id;
        }
        $data=['user_id'=>$user_id,'good_id'=>$good_id];
        if(!$this->save($data)){
            return ['code'=>__LINE__,'msg'=>'收藏失败'];
        }
        return ['code'=>0,'msg'=>'collect ok'];

    }
    public function getTypeAttr($value){
        $status = [1 => '图书', 2 => '真题'];
        return $status[$value];
    }
    //wx
    /**
     * 查询用户收藏的商品
     * @return $list_
     */
   public static function getList($data){
        $user_id = User::getUserIdByName($data['username']);
        if(is_array($user_id)){
            return $user_id;
        }

        $list_ = self::where(['collect.st'=>1,'collect.type'=>1,'user_id'=>$user_id])->join('good','good.id=collect.collect_id')->field('collect.id c_id,collect_id,name,img,price')->order('collect.create_time desc')->paginate();
       if($list_->isEmpty()){
           return ['code'=>__LINE__,'msg'=>'没数据啊!'];
       }
       return ['code'=>0,'data'=>$list_];
   }

    /**
     * 查询用户收藏的商铺
     * @return array|bool|mixed
     *
     */

    public static function getShop($data){
        $user_id = User::getUserIdByName($data['username']);
        if(is_array($user_id)){
            return $user_id;
        }
        $list_ = self::where(['collect.st'=>1,'collect.type'=>2,'user_id'=>$user_id])->join('shop','shop.id=collect.collect_id')->field('collect.id c_id,collect_id,name,img')->order('collect.create_time desc')->paginate();
        return $list_;
    }
   //wx
   public static function ifFav($data){
       $user_id = User::getUserIdByName($data['user_name']);
       if(is_array($user_id)){
           return $user_id;
       }
       $row_ = self::where(['user_id'=>$user_id,'good_id'=>$data['good_id'],'st'=>1])->find();
       if($row_){
           return true;
       }
        return false;
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
     * 用户收藏商品
     * @param $data
     * @return array|mixed
     * mazhida 2017年10月26日 18:31:56
     */
    public function colGood($data){
        $user_id = User::getUserIdByName($data['username']);
        if(is_array($user_id)){
            return $user_id;
        }
       $res = $this->where(['user_id'=>$user_id,'collect_id'=>$data['good_id'],'type'=>1])->find();
       if($res){
            if($res['st']=='正常'){
                $this->where(['id'=>$res['id']])->update(['st'=>'0']);
                return ['code'=>0,'msg'=>'删除成功'];
            }else{
                $this->where(['id'=>$res['id']])->update(['st'=>'1']);
                return ['code'=>0,'msg'=>'添加成功'];
            }
       }else{
           $data['user_id'] = $user_id;
           $data['collect_id'] = $data['good_id'];
           $data['type'] = 1;
           unset($data['username']);
           unset($data['good_id']);
           $this->save($data);
           return ['code'=>0,'msg'=>'添加成功'];
       }

    }

    /**
     * 用户收藏商铺
     *
     */
    public function colShop($data){
        $user_id = User::getUserIdByName($data['username']);
        if(is_array($user_id)){
            return $user_id;
        }
        $res = $this->where(['user_id'=>$user_id,'collect_id'=>$data['shop_id'],'type'=>2])->find();
        if($res){
            if($res['st']=='正常'){
                $this->where(['id'=>$res['id']])->update(['st'=>'0']);
                return ['code'=>0,'msg'=>'删除成功'];
            }else{
                $this->where(['id'=>$res['id']])->update(['st'=>'1']);
                return ['code'=>0,'msg'=>'添加成功'];
            }
        }else{
            $data['user_id'] = $user_id;
            $data['collect_id'] = $data['shop_id'];
            $data['type'] = 2;
            unset($data['username']);
            unset($data['shop_id']);
            $this->save($data);
            return ['code'=>0,'msg'=>'添加成功'];
        }
    }
}
