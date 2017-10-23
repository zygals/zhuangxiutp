<?php
namespace app\back\validate;

use think\Validate;

class ShopAddressValidate extends Validate{
   // protected $regex = [ 'mobile' => '^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\\d{8}$'];
	protected $rule = [
        'shop_id'=>'require|number',
		'name_' =>  'require|array',
		'truename_' =>  'require|array',
		'address_' =>  'require|array',
		'mobile_' =>  'require|array',



	];
	protected $message  =   [
		'name.require' => 'name 必须',
		'truename.require'   => 'truename 必须',
		'address_.require'   => 'address_ 必须',


	];
	protected $scene = [


	];

}