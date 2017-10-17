<?php
namespace app\back\validate;

use think\Validate;

class ArticleValidate extends Validate{
	protected $rule = [
		'title'  =>  'require',
		'school_id' =>  'require|number',
		'cate_article_id' =>  'require|number',
		'cont' =>  'require',
		'sort' =>  'number',
		'index_show' =>  'boolean',


	];
	protected $message  =   [
		'title.require' => '名称必须',
		'school_id.require'   => '院校必须',
		'cate_article_id.require'   => '分类必须',
		'cont.require'   => '内容必须',


	];
	protected $scene = [
		//'goodnew'  =>  ['name','cate_id'],

	];

}