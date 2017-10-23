<?php

namespace app\api\model;

use think\Model;

class Ad extends Base {



    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常', 2 => '不显示'];
        return $status[$value];
    }


    public static function getList($data=[],$where = ['st' => ['<>', 0]]) {
        return self::getListCommon($data,$where);

    }


}
