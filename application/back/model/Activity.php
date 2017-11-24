<?php

namespace app\back\model;

use think\Model;

class Activity extends Base {



    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常', 2 => '不显示'];
        return $status[$value];
    }


    public static function getList($data=[],$where = ['st' => ['<>', 0]]) {
        $order = "create_time desc";
        if (!empty($data['name'])) {
            $where['name'] = ['like', '%' . $data['name'] . '%'];
        }
        if (!empty($data['type'])) {
            $where['type'] = $data['type'];
        }

        if (!empty($data['online'])) {
            if($data['online']=='now'){
                $where['end_time'] = ['>' ,time()];
                $where['start_time'] = ['<' ,time()];
            }else if($data['type']=='online'){
                $where['end_time'] = ['<' ,time()];
            }
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }
        $list_ = self::where($where)->field('name,id,img,FROM_UNIXTIME(start_time,"%Y-%m-%d") start_time,FROM_UNIXTIME(end_time,"%Y-%m-%d") end_time,address,pnum,create_time')->order($order)->paginate(10);

        return $list_;

    }


}
