<?php
namespace app\back\validate;

use think\Validate;

class ShopValidate extends Validate{
	protected $rule = [
		'name'  =>  'require',
		'truename'  =>  'require',
		//'phone' =>  'require|mobile',
		'addr' =>  'require',
		'cate_id' =>  'require|number',


	];
	protected $message  =   [
		'name.require' => 'name 必须',
		'truename.require'   => 'truename 必须',
		'phone.require'   => 'phone 必须',


	];
	protected $scene = [


	];

}