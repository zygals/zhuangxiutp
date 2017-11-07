<?php
namespace app\back\validate;

use think\Validate;

class AdValidate extends Validate{
	protected $rule = [
        'url_to'=>'number'

	];
	protected $message  =   [



	];
	protected $scene = [
		//'goodnew'  =>  ['name','cate_id'],

	];

}