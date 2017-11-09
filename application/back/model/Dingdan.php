<?php

namespace app\back\model;

use think\Model;
use app\back\model\Good;
use app\back\model\OrderGood;

class Dingdan extends model{
	const GOODST_WEIFAHUO = 1;
	const GOODST_YIFAHUO = 2;
	const GOODST_BUFEN_FAHUO = 5;

	public static $arrStatus = [1 => '未支付' , 2 => '已支付' , 4 => '用户取消' , 5 => '用户删除'];

	public function getStAttr($value){
		$status = ['0' => '管理员删除' , 1 => '未支付' , 2 => '已支付' , 4 => '用户取消' , 5 => '用户删除'];
		return $status[$value];
	}
	public function getTypeAttr($value){
		$status = [1 => '普通' ,/* 2 => '限量' ,*/
				   3 => '限人' , 4 => '商家订金' , 5 => '商家全款'];
		return $status[$value];
	}
	public function getGoodstAttr($value){
		$status = [1 => '未发货' , 2 => '已发货' , 5 => '部分发货' , 3 => '已收货' , 4 => '已评价'];
		return $status[$value];
	}

	public static function findOne($order_id){
		$row_ = self::where( ['dingdan.id' => $order_id] )->join( 'user' , 'dingdan.user_id=user.id' )->join( 'shop' , 'shop.id=dingdan.shop_id' )->join( 'address' , 'address.id=dingdan.address_id'
,'left')->join('order_contact','order_contact.id=dingdan.order_contact_id','left')->field( 'dingdan.*,address.truename,address.mobile,address.pcd,address.info,user.username,shop.id shop_id,shop.name shop_name,order_contact.orderno orderno_contact' )->find();

		return $row_;
	}

	/*
	 * //分页查询
	 * */
	public static function getAlldingdans($data){
		$where = ['dingdan.st' => ['<>' , 0]];
		$order = ['create_time desc'];
		$time_from = isset( $data['time_from'] ) ? $data['time_from'] : '';
		$time_to = isset( $data['time_to'] ) ? $data['time_from'] : '';
		if ( Admin::isShopAdmin() ) {
			$where['dingdan.shop_id'] = session( 'admin_zhx' )->shop_id;
		}
		if ( !empty( $time_from ) ) {
			$where['dingdan.create_time'] = ['gt' , strtotime( $time_from )];
		}
		if ( !empty( $time_to ) ) {
			$where['dingdan.create_time'] = ['lt' , strtotime( $time_to )];
		}
		if ( !empty( $time_to ) && !empty( $time_from ) ) {
			$where['create_time'] = [['gt' , strtotime( $time_from )] , ['lt' , strtotime( $time_to )]];
		}
		if ( !empty( $data['orderno'] ) ) {
			$where['dingdan.orderno'] = $data['orderno'];
		}
		if ( !empty( $data['shop_id'] ) ) {
			$where['shop_id'] = $data['shop_id'];
		}
		if ( !empty( $data['st'] ) ) {
			$where['dingdan.st'] = $data['st'];
		}
		if ( !empty( $data['paixu'] ) ) {
			$order = $data['paixu'] . ' asc';
		}
		if ( !empty( $data['paixu'] ) && !empty( $data['sort_type'] ) ) {
			$order = $data['paixu'] . ' desc';
		}
		$list = self::where( $where )->join( 'user' , 'user.id=dingdan.user_id' )->join( 'shop' , 'dingdan.shop_id=shop.id' )->join( 'order_contact' , 'dingdan.order_contact_id=order_contact.id' , 'left' )->field( 'dingdan.*,user.username,shop.name shop_name,order_contact.orderno orderno_contact' )->order( $order )->paginate();
		//dump($list);

		return $list;
	}


	/*
	 * 更改订单发货状态
	 * zhuangiu - zyg
	 * */
	public static function updateGoodst($id , $type){
		$row_ = self::where( ['id' => $id] )->find();
		if ( $type == 'all' ) {
			$row_->goodst = self::GOODST_YIFAHUO;
		} elseif ( $type == 'part' ) {
			$row_->goodst = self::GOODST_BUFEN_FAHUO;
		}
		$row_->save();
	}

	/*
	 *管理员改订单状态为已支付
	 *
	 * zhuangxiu-zyg
	 * */
	public static function stPaid($data){
		$admin = Admin::where( ['type' => 1] )->find();
		//dump($admin);exit;
		if ( Admin::pwdGenerate( $data['pass_admin'] ) !== $admin->pwd ) {
			return ['code'=>__LINE__,'msg'=>'密码有误！'];
		}
		$row_order = self::where(['id'=>$data['order_id']])->find();
		$row_order->st=2;
		$row_order->save();
		//同时增加商家收益
		$admin_shop = Admin::where( ['shop_id' => $row_order->shop_id , 'st' => 1] )->find();
		if ( !$admin_shop ) {
			return ['code' => __LINE__ , 'msg' => '店铺管理员不存在或没有权限'];
		}
		$admin_shop->income += $row_order->sum_price;
		$admin_shop->save();
		return ['code'=>0,'msg'=>'状态改为已支付,且商家收益增加'];

	}
}
