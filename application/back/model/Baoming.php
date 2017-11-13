<?php

namespace app\back\model;

use think\Model;

class Baoming extends Base{


	public function getStAttr($value){
		$status = [0 => 'deleted' , 1 => '没验房' , 2 => '已验房'];
		return $status[$value];
	}

	public static function getList($data=[],$where = ['st' => ['<>', 0]]) {
		$order = "create_time desc";
		if (!empty($data['name_'])) {
			$where['truename|mobile'] = ['like', '%' . $data['name_'] . '%'];
		}
		if (!empty($data['paixu'])) {
			$order = $data['paixu'] . ' asc';
		}
		if (!empty($data['paixu']) && !empty($data['sort_type'])) {
			$order = $data['paixu'] . ' desc';
		}
		$list_ = self::where($where)->field('id,truename,mobile,address,create_time,from_unixtime(time_to) time_to,st,article_st')->order($order)->paginate(10);

		return $list_;

	}


}
