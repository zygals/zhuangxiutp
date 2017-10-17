<?php
namespace app\back\validate;

use think\Validate;

class DingdanValidate extends Validate{
	protected $rule = [
		'good_st'  =>  'require|number|in:1,2',


	];
	protected $message  =   [
		'good_st.require' => '商品状态必须',
		'good_st.number' => '商品状态为数字',


	];
	protected $scene = [
		//'goodnew'  =>  ['name','cate_id'],

	];

}