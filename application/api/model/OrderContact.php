<?php

namespace app\api\model;

use think\Model;

class OrderContact extends model {

	const ORDER_CONTACT_NO_PAY=1;
	const ORDER_CONTACT_PAID=2;
	public function getStAttr($value){
		$status = [ 1 => '待支付' , 2 => '已支付' , 4 => '用户取消' ,5 => '用户删除'];
		return $status[$value];
	}


}
