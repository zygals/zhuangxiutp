<?php

namespace app\api\model;

use think\Model;

class OrderGood extends Base{
	const ST_PREPARE = 1;
	const ST_SENT = 2;
	const ST_TAKEN = 3;
	const ST_RETURN = 4;

	public function getStAttr($value){
		$status = [1 => '没发货' , 2 => '已发货' , 3 => '已收货'];
		return $status[$value];
	}
	/*
	 *取订单商品
	 * zhuangiu-zyg
	 * */
	public static function getGood($order_id){
		$where = ['order_id' => $order_id];
		$list_ = self::where( $where )->order( 'create_time asc' )->field( 'id,name good_name,good_id,price,num,img,st,unit')->select();
		return $list_;
	}
	/*
	 *
	 * zhuangiu-zyg
	 * */
	public static function getGoodOn($good_id){
		$list_ = self::where( "good_id=:good_id  and (st=1 or st=2)" , ['good_id' => $good_id] )->find();
		//dump($list_);exit;
		return $list_;
	}
	/*
	 * 给订单中的商品增加销量
	 * zhuangiu-zyg
	 * */
	public static function increseSales($order_id){
        $list_order_good = self::where(['order_id'=>$order_id])->select();
		foreach($list_order_good as $order_good){
			$good = self::getById($order_good->good_id,new  Good());
			$good->sales += $order_good->num;
			$good->save();
		}
	}

	/**
	 * 通过order_id获取信息
	 */
	public static function getListByOrderId($data){
		$field = 'dingdan.orderno,shop.name shop_name,order_good.img,order_good.name,order_good.good_id,order_good.shop_id,dingdan.user_id,order_good.order_id';
		$row_ = self::where(['order_good.order_id'=>$data])->join('dingdan','dingdan.id=order_good.order_id')->join('shop','shop.id=order_good.shop_id')->field($field)->select();
		return $row_;
	}







}
