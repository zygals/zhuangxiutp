<?php

namespace app\api\model;

use think\Model;

class Shop extends Base {
    public function getToTopAttr($value) {
        $status = [0 => '否', 1 => '是'];
        return $status[$value];
    }
    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常'];
        return $status[$value];
    }
    public static function getListAll(){
        $where = ['shop.st' => ['=',1]];
        $order = "create_time asc";
        $list_ = self::where($where)->join('cate','shop.cate_id=cate.id')->field('shop.*,cate.name cate_name')->order($order)->select();

        return $list_;
    }
    // 1,2,3   1
    public static function getListByCateId($cate_id){
        $row_ = self::where(['cate_id'=>$cate_id,'st'=>['=',1]])->find();
        if($row_){
            return true;
        }
        return false;
    }
    public static function getList($data=[]) {
        $field='shop.id shop_id,shop.name,shop.img,shop.ordernum,shop.tradenum,shop.img,shop.logo,cate.name cate_name';
        $where=['shop.st' => 1];
        $order = "ordernum desc,tradenum desc";

        if(!empty($data['cate_id'])){
            $where['cate_id'] = $data['cate_id'];
        }
        if(!empty($data['name_'])){
            $where['shop.name|shop.truename|city'] = ['like','%'.$data['name_'].'%'];
        }

        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' desc';
        }
        if (!empty($data['paixu']) && $data['paixu']=='hot') {
            $where['shop.to_top'] = 1;
            $order = "shop.update_time desc";
        }
        /*if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' asc';
        }*/


        $list_ = self::where($where)->join('cate','shop.cate_id=cate.id')->order($order)->field($field)->paginate();
       // dump($list_);exit;
        if($list_->isEmpty()){
            return ['code'=>__LINE__,'msg'=>'shop not exists'];
        }
        return ['code'=>0,'msg'=>'shop list ok','data'=>$list_];
    }
    public static function getIndexList(){
        $where = ['st' => ['=',1]];
        $list_ = self::where($where)->order('create_time asc')->select();

        return $list_;
    }
    //wx

    public static function read($school_id){
        return self::getById($school_id,new self(),'id,title,img_big');
    }
}
