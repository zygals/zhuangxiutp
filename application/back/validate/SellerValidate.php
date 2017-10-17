<?php
namespace app\back\validate;

use think\Validate;

class SellerValidate extends Validate{
	protected $rule = [
		'name'  =>  'require',
		'mobile' =>  'require',
		//'mobile' =>  'require|^1[34578]\d{9}$',


	];
	protected $message  =   [
		'name.require' => '名称必须',
		'mobile.require'   => '手机必须',
		//'mobile.mobile'   => '手机号码不正确',


	];
	protected $scene = [


	];

}