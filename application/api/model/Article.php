<?php

namespace app\api\model;

use think\Model;
use app\api\model\GoodAttr;

class Article extends Base{

	public function getStAttr($value){
		$status = [0 => 'deleted' , 1 => '正常' , 2 => '不显示'];
		return $status[$value];
	}
	public function getTypeAttr($value){
		$status = [ 1 => '百科', 2 => '验房', 3 => '限人团购'];
		return $status[$value];
	}

	public function getIndexShowAttr($value){
		$status = [0 => '否' , 1 => '是'];
		return $status[$value];
	}

	public static function getListBySchoolId($school_id){
		$row_ = self::where( ['school_id' => $school_id , 'st' => 1] )->find();
		if ( $row_ ) {
			return true;
		}
		return false;
	}

	public static function getListByCateId($cate_article_id){
		$row_ = self::where( ['cate_article_id' => $cate_article_id , 'st' => 1] )->find();
		if ( $row_ ) {
			return true;
		}
		return false;
	}
	/*
	 * index article list;验房 article list
	 * zhuangxiu-zyg
	 * */
	public static function getListIndex(){
		$order = "article.update_time desc";
		$where = ['article.st' => 1 , 'index_show' => 1 , 'article.type' => 1];
		$fields = "article.id,article.name,article.img,article.charm,left(article.cont,80) cont_limit";
		$list_ = self::where( $where )->join( 'cate' , 'article.cate_id=cate.id' , 'left' )->field( $fields )->order( $order )->limit( 5 )->cache()->select();
		return ['code'=>0,'msg'=>'百科成功','data'=>$list_];
	}
	/*
	 * index article list;验房 article list
	 * zhuangxiu-zyg
	 * */
	public static function getListYanfang(){
		$order = "article.update_time desc";
		$where = ['article.st' => 1 , 'index_show' => 1 , 'article.type' => 2];
		$fields = "article.id,article.name,article.img,article.charm,left(article.cont,80) cont_limit";
		$list_ = self::where( $where )->join( 'cate' , 'article.cate_id=cate.id' , 'left' )->field( $fields )->order( $order )->paginate();
		return ['code'=>0,'msg'=>'验房文章成功','data'=>$list_];
	}

	//wx
	public static function getNew(){
		$list_ = self::where( ['index_show' => 1 , 'st' => 1] )->field( 'id,title,cont,create_time' )->limit( 5 )->order( 'sort asc' )->select();
		foreach ( $list_ as $k => $value ) {
			if ( mb_strlen( $value->cont , "UTF8" ) > 40 ) {
				$list_[$k]->cont = mb_substr( $value->cont , 0 , 100 , 'utf-8' ) . '...';
			}

		}
		return $list_;
	}

	public static function read($id){
		return self::getById( $id , new self() );
	}



}
