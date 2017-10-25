<?php
namespace app\back\validate;

use think\Validate;

class GoodValidate extends Validate{
	protected $rule = [
		'name'  =>  'require',
		'price'  =>  'require|float',
		'shop_id' =>  'require|number',
		'unit' =>  'require',

		//'desc' =>  'require',


	];
	protected $message  =   [
		'name.require' => '名称必须',
		'shop_id.require'   => 'shop_id 必须',
		//'desc'   => '描述必须',


	];
	protected $scene = [


	];

}