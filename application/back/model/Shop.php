<?php

namespace app\back\model;

use think\Model;

class Shop extends Base {

    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常'];
        return $status[$value];
    }
    public static function getListAll(){
        $where = ['st' => ['=',1]];
        $order = "create_time asc";
        $list_ = self::where($where)->join('cate','shop.cate_id=cate.id')->field('shop.*,')->order($order)->select();

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
    public static function getList($data=[],$field='shop.*,cate.name cate_name,admin.id admin_id,admin.name admin_name,admin.st admin_st',$where=['shop.st' => ['=',1]]) {
       // $where = ['st' => ['<>',0]];
        $order = "create_time desc";
        if(!empty($data['cate_id'])){
            $where['cate_id'] = $data['cate_id'];
        }
        if(!empty($data['name_'])){
            $where['shop.name|shop.truename'] = ['like','%'.$data['name_'].'%'];
        }
        if(!empty($data['city'])){
            $where['city'] = ['like','%'.$data['city'].'%'];
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }
        $list_ = self::where($where)->join('cate','shop.cate_id=cate.id')->join('admin','admin.id=shop.admin_id','left')->order($order)->field($field)->paginate();

        return $list_;
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
