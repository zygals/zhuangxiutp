<?php
namespace app\back\validate;

use think\Validate;

class ArticleValidate extends Validate{
	protected $rule = [
		'name'  =>  'require',
		'cont' =>  'require',
		'sort' =>  'number',
		'index_show' =>  'boolean',
		//'cate_id'  =>  'require',

	];
	protected $message  =   [
		'name.require' => '名称必须',
		'img.require'   => '图片必须',
		'cont.require'   => '内容必须',


	];
	protected $scene = [
		//'goodnew'  =>  ['name','cate_id'],

	];

}