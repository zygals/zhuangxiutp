<?php

namespace app\api\model;

use think\Model;
use app\api\model\GoodAttr;

class Article extends Base{

	public function getStAttr($value){
		$status = [0 => 'deleted' , 1 => '正常' , 2 => '不显示'];
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
	public static function getListIndex($type = 1){
		$order = "article.update_time desc";
		$where = ['article.st' => 1 , 'index_show' => 1 , 'article.type' => $type];
		$fields = "article.id,article.name,article.img";
		if ( $type == 1 ) {
			$list_ = self::where( $where )->join( 'cate' , 'article.cate_id=cate.id' , 'left' )->field( $fields )->order( $order )->limit( 5 )->select();
		}else{
			$list_ = self::where( $where )->join( 'cate' , 'article.cate_id=cate.id' , 'left' )->field( $fields )->order( $order )->paginate();
		}
		if ( $list_->isEmpty() ) {
			$order = "article.create_time desc";
			$where = ['article.st' => 1 , 'article.type' => $type];
			if ( $type == 1 ) {
				$list_ = self::where( $where )->join( 'cate' , 'article.cate_id=cate.id' , 'left' )->field( $fields )->order( $order )->limit( 5 )->select();
			}else{
				$list_ = self::where( $where )->join( 'cate' , 'article.cate_id=cate.id' , 'left' )->field( $fields )->order( $order )->paginate();
			}
		}

		return $list_;
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
