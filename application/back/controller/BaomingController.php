<?php

namespace app\back\controller;


use app\back\model\Ad;

use app\back\model\Article;
use app\back\model\Base;
use app\back\model\Baoming;
use think\Request;

class BaomingController extends BaseController{
	public function __construct(){
		parent::__construct();
		$this->assign( ['model_name' => '验房报名'] );
	}

	/**
	 * 显示资源列表
	 *
	 * @return \think\Response
	 */
	public function index(Request $request){
		$data = $request->param();
//        dump($data);exit;
//        exit;
		$list_ = Baoming::getList( $data );

		$page_str = $list_->render();
		$page_str = Base::getPageStr( $data , $page_str );
		$url = $request->url();
		return $this->fetch( 'index' , ['list_' => $list_ , 'page_str' => $page_str , 'url' => $url] );
	}
	public function edit_article(Request $request){
		$data = $request->param();
		$row_article = Article::where(['baoming_id'=>$data['id']])->find();
		if(!$row_article){
			$this->error('总结不存在');
		}
		$referer = $request->header()['referer'];
 		 return $this->fetch('',['row_article'=>$row_article,'title'=>'修改总结','act'=>'update_article','referer'=>$referer]);

	}
	public function update_article(Request $request){
		$data = $request->param();
		$file = $request->file('img');
		$row_ = $this->findById($data['id'],new Article());
		if(!empty($file)){
			$path_name = 'article';
			$size = $file->getSize();
			if ($size > config('upload_size') ) {
				$this->error('图片大小超过限定！');
			}
			$this->deleteImg($row_->img);
			$arr = $this->dealImg($file, $path_name);
			$data['img'] = $arr['save_url_path'];
		}

		$referer = $data['referer'];unset( $data['referer'] );
		if ( $this->saveById( $data['id'] , new Article() , $data ) ) {

			$this->success( '编辑成功' , $referer , '' , 1 );
		} else {
			$this->error( '没有修改' , $referer , '' , 1 );
		}

	}
	/**
	 * 显示编辑资源表单页.
	 *
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function edit(Request $request){
		$data = $request->param();
		$referer = $request->header()['referer'];
		$row_ = $this->findById( $data['id'] , new Baoming() );
		return $this->fetch( '' , ['row_' => $row_ , 'referer' => $referer , 'title' => '修改报名状态' , 'act' => 'update'] );
	}


	/**
	 * 保存更新的资源
	 *
	 * @param  \think\Request $request
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function update(Request $request){
		$data = $request->param();
		$referer = $data['referer'];
		unset( $data['referer'] );
		if ( $this->saveById( $data['id'] , new Baoming() , $data ) ) {

			$this->success( '编辑成功' , $referer , '' , 1 );
		} else {
			$this->error( '没有修改' , $referer , '' , 1 );
		}
	}

	/*
	 * 添加验房日记
	 * */
	public function add(Request $request){
		$data = $request->param();
		$row_ = $this->findById( $data['id'] , new  Baoming() );
		return $this->fetch( '' , ['baoming' => $row_ , 'title' => '添加验房记录' , 'act' => 'save'] );
	}

	public function save(Request $request){
		$data = $request->param();
/*
		$res = $this->validate($data, 'AdValidate');
		if ($res !== true) {
			$this->error($res);
		}*/
		$file = $request->file('img');

		if (empty($file)) {
			$this->error('请上传图片或检查图片大小！');
		}
		$size = $file->getSize();
		if ($size > config('upload_size')) {
			$this->error('图片大小超过限定！');
		}
		$path_name = 'article';

		$arr = $this->dealImg($file, $path_name);

		$data['img'] = $arr['save_url_path'];
     	$data['type'] = 2;//验房的文章
		$Ad = new Article();
		$Ad->save($data);
		$this->saveById($data['baoming_id'],new Baoming(),['article_st'=>1]);
		$this->success('添加成功', 'index', '', 1);
	}

	/**
	 * soft-delete 指定资源
	 *
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function delete(Request $request){
		$data = $request->param();

		if ( $row_=$this->deleteStatusById( $data['id'] , new Baoming() ) ) {
			//删除对应的难房记录
           if($row_->article_st==1){
			   Article::where(['baoming_id'=>$row_->id])->update(['st'=>0]);
		   }

			$this->success( '删除成功' , $data['url'] , '' , 1 );
		} else {
			$this->error( '删除失败' , $data['url'] , '' , 3 );
		}
	}


}
