<?php

namespace app\api\model;

use think\Model;

class CateArticle extends model {

    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常'];
        return $status[$value];
    }
    public static function getListAll(){
        $where = ['st' => ['=',1],'type'=>['=',2]];
        $order = "create_time asc";
        $list_ = self::where($where)->order($order)->select();

        return $list_;
    }
    public static function getList($data=[],$where=['st' => ['<>',0]]) {
        $order = "create_time desc";
        if(!empty($data['name'])){
            $where['name'] = ['like','%'.$data['name'].'%'];
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }
        $list_ = self::where($where)->order($order)->paginate();

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


}
