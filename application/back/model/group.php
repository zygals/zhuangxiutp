<?php

namespace app\back\model;

use think\Model;

class Group extends model {

    public function getTypeAttr($value) {
        $type = [ 1 => '限人团购','2'=>'限时限量'];
        return $type[$value];
    }
    public function getStAttr($value) {
        $status = [ 0=>'删除',1 => '正在进行',2=>'下架','3'=>'成功',4=>'不成功'];
        return $status[$value];
    }
    public static function getListAll(){
        $where = ['st' => ['=',1],'type'=>['=',2]];
        $order = "create_time asc";
        $list_ = self::where($where)->order($order)->select();

        return $list_;
    }
    public static function getList($data=[],$field='group.*,shop.name shop_name,good.name good_name',$where=['group.st' => [['<>',0],['<>',2]]]) {
        $order = "group.create_time desc";
//        if(!empty($data['name'])){
//            $where['name'] = ['like','%'.$data['name'].'%'];
//        }
//        if (!empty($data['paixu'])) {
//            $order = $data['paixu'] . ' asc';
//        }
//        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
//            $order = $data['paixu'] . ' desc';
//        }
        $list_ = self::where($where)->join('shop','shop.id=group.shop_id')->join('good','good.id=group.good_id')->field($field)->order($order)->paginate();

        return $list_;
    }

    public static function findByCateId($cate_id,$limit) {
        $where['status'] = ['=', 1];
        if($cate_id){
            $where['cate_id']=$cate_id;
        }
        if($limit==0){
            $list_ = self::where($where)->order('create_time desc')->select();
        }else{
            $list_ = self::where($where)->order('create_time desc')->limit($limit)->select();
        }

        return $list_;
    }
    public static function getIndexShow(){
        $where['good_new.status'] = ['=', 1];
        $where['good_new.index_show'] = 1;
        $list_ = self::where($where)->alias('good')->join('cate', 'good.cate_id=cate.id', 'left')->field('good.*,cate.name cate_name')->order('sort asc,create_time asc')->limit(2)->select();

        return $list_;
    }

    /* 查询单条团购信息
     *
     * @param: $id
     *
     * */

    public static function findById($id,$field='group.*,shop.name shop_name,good.name good_name,good.price good_price') {
        $where['group.id']=['=',$id];
        $list_ = self::where($where)->join('shop','shop.id=group.shop_id')->join('good','good.id=group.good_id')->field($field)->find();
        return $list_;
    }


}
