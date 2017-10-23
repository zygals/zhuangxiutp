<?php

namespace app\api\model;

use think\Model;

class Attr extends model {
    const TYPE_SELECT = 1;  //
    const TYPE_INPUT = 2;   //
    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常'];
        return $status[$value];
    }
    public function getTypeIdAttr($value) {
        $status = [1 => '图书', 2 => '真题'];
        return $status[$value];
    }

    public function getInputTypeAttr($value) {
        $status = [1 => '下拉添加', 2 => '表单输入'];
        return $status[$value];
    }
    public static function getList($data) {
        $where = ['attr.st' => ['=',1]];
        if(!empty($data['type_id'])){
            $where['type_id']=$data['type_id'];
        }
        $list_ = self::where($where)->order('create_time asc')->paginate();


        return $list_;
    }
    public static function getListByCateId($data){
        $where = ['st' => 1,'type_id'=>$data['type']];
      //  dump($where);exit;
        $list_ = self::where($where)->order('create_time asc')->select();
        return $list_;
    }

}
