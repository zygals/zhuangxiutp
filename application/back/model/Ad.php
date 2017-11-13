<?php

namespace app\back\model;

use think\Model;

class Ad extends Base {

    const URL_TO_ACTIVITY_DETAIL=1;
    const URL_TO_GOOD_DETAIL=2;
    const URL_TO_SHOP_DETAIL=3;
    const URL_TO_SHOP_LIST=4;
    const URL_TO_ONLINEGROUP_LIST=5;
    const URL_TO_CHECKROOM_LIST=6;


    public function getUrlToAttr($value) {
        $status = [0=>'无', 1 => '活动详情', 2 => '商品详情',3=> '店铺详情', 4 => '店铺列表',5=>'线上拼团',6=>'公益验房'];
        return $status[$value];
    }

    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常', 2 => '不显示'];
        return $status[$value];
    }


    public static function getList($data=[],$where = ['st' => ['<>', 0]]) {
        return self::getListCommon($data,$where);

    }


}
