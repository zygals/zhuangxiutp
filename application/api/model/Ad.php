<?php

namespace app\api\model;

use think\Model;

class Ad extends Base {



    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常', 2 => '不显示'];
        return $status[$value];
    }


    public static function getList($data=[],$where = ['st' => ['=', 1]]) {
        $order = "sort asc";

        $list_ = self::where($where)->field('id,name,img')->order($order)->select();

        return $list_;

    }


}
