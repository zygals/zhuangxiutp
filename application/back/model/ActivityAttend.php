<?php

namespace app\back\model;

use think\Model;

class ActivityAttend extends Base {

  protected $dateFormat='Y-m-d H:i:s';

    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常', 2 => '不显示'];
        return $status[$value];
    }


    public static function getList($data=[]) {
        $where = ['activity_attend.activity_id' => ['=', $data['activity_id']]];
        $order = "activity_attend.create_time desc";
        if (!empty($data['name_'])) {
            $where['activity_attend.truename|activity_attend.mobile|activity_attend.zuoji'] = ['like', '%' . $data['name_'] . '%'];
        }

        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }
        $list_ = self::where($where)->join('activity','activity.id=activity_attend.activity_id','left')->field('activity_attend.*,activity.name activity_name,activity.type')->order($order)->paginate(10);

        return $list_;

    }


}
