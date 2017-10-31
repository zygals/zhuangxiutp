<?php

namespace app\back\model;

use think\Model;

class Baoming extends Base{


	public function getStAttr($value){
		$status = [0 => 'deleted' , 1 => '没验房' , 2 => '已验房'];
		return $status[$value];
	}

	public static function getList($data=[],$where = ['st' => ['<>', 0]]) {
		return self::getListCommon($data,$where);

	}


}
