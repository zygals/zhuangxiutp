<?php

namespace app\api\model;

use think\Model;

class Cate extends model {
    const TYPE_HANGYE = 1;//
    const TYPE_BAIKE = 2;   //

    public static $type_cate = [
        0 => [
            'type_id' => 1,
            'title' => '行业',
        ],
        1 => [
            'type_id' => 2,
            'title' => '百科',
        ]
    ];

    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常'];
        return $status[$value];
    }

    public function getTypeAttr($value) {
        $status = [1 => '行业', 2 => '百科'];
        return $status[$value];
    }

    public static function getList($data=[],$field='id,name,type,sort',$where=['st' => ['<>', 0]]) {
//        $where = ['st' => ['<>', 0]];
        $order = "sort asc";
        if (!empty($data['type_id'])) {
            $where['type'] = $data['type_id'];
        }

        $list_ = self::where($where)->order($order)->field($field)->select();
        if($list_->isEmpty()){
            return ['code'=>__LINE__,'msg'=>'分类不存在'];
        }
        return ['code'=>0,'msg'=>'cate ok','data'=>$list_];
    }

    public static function getAllCateByType($type) {
        $where = ['st' => ['<>', 0],'type'=>$type];
        $order = "create_time desc";
        $list_ = self::where($where)->order($order)->select();

        return $list_;
    }

    public static function getListAll(){
        $where = ['st' => ['=',1],'type'=>['=',2]];
        $order = "create_time asc";
        $list_ = self::where($where)->order($order)->select();

        return $list_;
    }


}
