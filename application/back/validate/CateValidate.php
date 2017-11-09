<?php
namespace app\back\validate;

use think\Validate;

class CateValidate extends Validate{
	protected $rule = [
		'name'  =>  'require',

		'type' =>  'require|number',
        'sort'=>'number',

	];
	protected $message  =   [
		'name.require' => '名称必须',
		'type.require'   => '类型必须',
		'sort.number'   => '排序必须为数字',


	];
	protected $scene = [
		//'goodnew'  =>  ['name','cate_id'],

	];

}