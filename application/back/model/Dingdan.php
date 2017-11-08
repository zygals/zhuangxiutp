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
			$where['orderno'] = $data['orderno'];
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
	// 添加订单 wx
	/*public function addOrder($data) {
		$user_id = User::getUserIdByName($data['username']);
		if (is_array($user_id)) {
			return $user_id;
		}
		$row_good = Good::read($data['good_id']);
		//库存判断
		if($row_good->store < $data['nums']){
			return ['code'=>__LINE__,'msg'=>'库存不足'];
		}
		if(!$row_good){
			return ['code'=>__LINE__,'msg'=>'商品暂不存在'];
		}
		$sum_price = $row_good->price * $data['nums'];
		$data_order['user_id'] = $user_id;
		$data_order['st'] = 1;
		$data_order['goodst'] = 1;
		$data_order['orderno'] = $this->makeTradeNo($data['username']);
		$address = Address::getUserDefaultAddress($user_id);

		$data_order['address_id'] = $address->id;

		$data_order['sum_price'] = $sum_price ;

		if (!$this->save($data_order)) {
			return ['code' => __LINE__, 'msg' => '订单添加失败'];
		}
		$new_order_id = $this->getLastInsID();
			$data_order_good['order_id'] = $new_order_id;
			$data_order_good['good_id'] = $row_good->id;
			$data_order_good['nums'] = $data['nums'];
			(new OrderGood())->save($data_order_good);

		return ['code' => 0, 'msg' => 'add order and add order_good ok', 'data' => $new_order_id];
	}*/
	//生成订单号 wx
	/* public function makeTradeNo($username) {
			return date('mdHis', time()) . mt_rand(10, 99) . '_' . $username;
		}*/
	//wx
	/*public function getOrder($data) {
		$order_id = $data['order_id'];
		$row_order = self::find($order_id);
		if (!$row_order) {
			return ['code' => __LINE__, 'msg' => 'order is not exists'];
		}
		$list_order_goods = (new OrderGood)->alias('og')->where('order_id', $order_id)->join('good', 'good.id=og.good_id')->field("og.nums,good.id good_id,good.title,good.price,good.img")->select();
		if (count($list_order_goods) == 0) {
			return ['code' => __LINE__, 'msg' => '订单商品不存在'];
		}
		$row_address = [];
		if($row_order->address_id!==0){
			$row_address = Address::read($row_order->address_id);
		}
		return ['code' => 0, 'msg' => 'get order and order_goods ok', 'data' => ['order' => $row_order, 'order_goods' => $list_order_goods,'address'=>$row_address]];
	}
	public function getOrderAdress($data) {
		$row_ = Address::get(['id' => $data['address_id']]);
		if (!$row_) {
			return ['code' => __LINE__, 'msg' => 'address not exists'];
		}
		return ['code' => 0, 'msg' => 'get new address ok', 'data' => $row_];
	}*/
	//wx
	/*public static function getMyOrders($data) {
		$user_id = User::getUserIdByName($data['user_name']);
		if (is_array($user_id)) {
			return $user_id;
		}
		$where = ['st' => ['neq',0],'user_id'=>$user_id];
		$where2 = ['st' => ['neq',5]];
		//return ['code' => 3, 'msg' => 'dfsgdsg'];
		$list_order = self::where($where)->where($where2)->order('create_time desc')->paginate();
		foreach ($list_order as $k => $row_order) {
			$list_order_good =  OrderGood::getGood($row_order->id);
			$list_order[$k]['goods'] = $list_order_good;
		}
		return ['code' => 0, 'msg' => 'get order and order_goods ok', 'data' => $list_order];

	}*/

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
