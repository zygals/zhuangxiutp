<?php
namespace app\back\validate;

use think\Validate;

class ShopValidate extends Validate{
    protected $regex = [ 'mobile' => '^1[34587][0-9]\d{4,8}$'];
	protected $rule = [
		'name'  =>  'require',
		'truename'  =>  'require',
		'phone' =>  'require|regex:mobile',
		'addr' =>  'require',
		'city' =>  'require',
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