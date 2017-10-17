<?php

namespace app\back\model;

use think\Model;

class SchoolRec extends model {

    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常'];
        return $status[$value];
    }
    public function getTypeAttr($value) {
        $status = [1 => '区块上部', 2 => '区块下部'];
        return $status[$value];
    }

    public static function getList($data=[]) {
        $where = ['school_rec.st' => ['<>',0]];
        $order = "create_time desc";
        if(!empty($data['type'])){
            $where['type']= $data['type'];
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }
        $list_ = self::where($where)->alias('sr')->join('school','sr.school_id=school.id')->field('sr.*,school.title school_name')->order($order)->paginate();

        return $list_;
    }



}
