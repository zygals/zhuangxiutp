<?php

namespace app\api\model;

use app\back\model\Tuangou;
use think\Model;

class Dingdan extends Base{
	const ORDER_ST_DAIZHIFU = 1;
	const ORDER_ST_PAID = 2;
	const ORDER_ST_USER_CANCEL = 4;
	const ORDER_ST_USER_DELETE = 5;
	const ORDER_ST_ADMIN_DELETE = 0;
	const GOOT_ST_DAIFAHUO = 1;
	const GOOT_ST_DAIFANKUI = 3; //已收货
	const GOOT_ST_FANKUIOK = 4; //已评价
	const ORDER_TYPE_SHOP = 1; //单商家订单
	const ORDER_TYPE_CONTACT = 2; //多商家订单
	const  ORDER_TYPE_LIMIT_=1;
	public static $arrStatus = [1 => '未支付' , 2 => '已支付' , 4 => '用户取消' , 5 => '用户删除'];

	public function getStAttr($value){
		$status = ['0' => '管理员删除' , 1 => '待支付' , 2 => '已支付' , 4 => '用户取消' , 5 => '用户删除'];
		return $status[$value];
	}

    //订单的商品总状态
	public function getGoodstAttr($value){
		$status = [1 => '没发货' , 2 => '已发货' , 3 => '已收货' , 4 => '已评价' , 5 => '部分发货'];
		return $status[$value];
	}
	public function getTypeAttr($value){
		$status = [ 1 => '普通' , 2 => '限量' , 3 => '限人',4=>'订金',5=>'全款' ];
		return $status[$value];
	}
	/*
	 * 添加订单-团购  不要了
	 * zhuangxiu-zyg
	 * */
	/*public function addOrderGroup($data){
		$user_id = User::getUserIdByName($data['username']);
		if(is_array($user_id)){
			return $user_id;
		}
		$row_group = self::getById( $data['group_id'] , new Tuangou() , '*' , ['group_st' => 1] );//正在进行;
		if ( !$row_group ) {
			return ['code' => __LINE__ , 'msg' => 'group not find'];
		}
		$data_order_group = [];
		$data_order_group['shop_id'] = $row_group->shop_id;
		$data_order_group['user_id'] = $user_id;
		$data_order_group['orderno'] = $this->makeTradeNo($data['username']);
		$data_order_group['address_id'] = $data['address_id'];
		$data_order_group['sum_price'] = $row_group->price_group;
		$data_order_group['type'] = $row_group->getData('type');
		$data_order_group['create_time'] =time();
		$data_order_group['update_time'] = time();
		if(!$new_order_id=$this->insertGetId($data_order_group)){
			return ['code' => __LINE__ , 'msg' => 'save order error'];
		}
		//添加订单商品
		$row_good = self::getById($row_group->good_id,new Good(),'name,img,unit');
        $data_order_good['order_id'] = $new_order_id;
        $data_order_good['shop_id'] = $row_group->shop_id;
        $data_order_good['good_id'] = $row_group->good_id;
        $data_order_good['num'] = 1;
        $data_order_good['st'] = 1;
        $data_order_good['img'] = $row_good->img;
        $data_order_good['name'] = $row_good['name'];
        $data_order_good['price'] =$row_group->price_group;
        $data_order_good['unit'] =$row_good->unit;
		if(!(new OrderGood())->save($data_order_good)){
			return ['code' => __LINE__ , 'msg' => 'save order ok,but save order_good error'];
		}
		return ['code' => 0 , 'msg' => 'save group order and order_good ok','type_shop'=>self::ORDER_TYPE_SHOP,'type_group'=>''];

	}*/

	public static function findOne($order_id){
		$row_ = self::where( ['dingdan.id' => $order_id] )->join( 'user' , 'dingdan.user_id=user.id' )->join( 'shop' , 'shop.id=dingdan.shop_id' )->join( 'address' , 'address.id=dingdan.address_id' )->field( 'dingdan.*,address.truename,address.mobile,address.pcd,address.info,user.username,shop.id shop_id,shop.name shop_name' )->find();

		return $row_;
	}

	/*
	 * 添加订单 zhuangxiu - zyg
	 *
	 * */
	public function addOrder($data){
		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		$arr_shop_good_list = json_decode( $data['shop_good_list'] );
		if ( !is_array( $arr_shop_good_list ) ) {
			return ['code' => __LINE__ , 'msg' => 'shop_good_list data error'];
		}
		$sum_price_all = 0;
		foreach ( $arr_shop_good_list as $shop ) {
			$row_cart = self::getById( $shop->cart_id , new Cart );
			if ( !$row_cart ) {
				return ['code' => __LINE__ , 'msg' => 'cart not exists'];
			}
			$list_cart_good = CartGood::where( ['cart_id' => $row_cart->id , 'st' => 1] )->select();
			$sum_price = 0;
			foreach ( $list_cart_good as $good ) {
				$row_good = self::getById( $good->good_id , new Good() );
				$sum_price += $row_good->price * $good->num;
			}
			$sum_price_all += $sum_price;
		}
		//添加平台订单
		$new_order_contact_id = 0;
		if ( count( $arr_shop_good_list ) > 1 ) {
			$data_order_contact = [
				'orderno' => $this->makeTradeNo( $data['username'] ) ,
				'sum_price_all' => $sum_price_all ,
				'st' => 1 ,//待支付
				'create_time' => time() ,
				'update_time' => time() ,
			];
			if ( !$new_order_contact_id = ( new OrderContact() )->insertGetId( $data_order_contact ) ) {
				return ['code' => 0 , 'msg' => 'add order_contact error'];
			}
		}

		foreach ( $arr_shop_good_list as $shop ) {
			//添加商家订单表开始
			$sum_price = 0;
			foreach ( $shop->shop_goods as $good ) {
				$row_good = self::getById( $good->good_id , new Good() );
				if ( !$row_good ) {
					return ['code' => __LINE__ , 'msg' => 'good not exits'];
				}
				$sum_price += $row_good->price * $good->num;
			}
			$data_order = [
				'order_contact_id' => $new_order_contact_id ,
				'shop_id' => $shop->shop_id ,
				'orderno' => $this->makeTradeNo( $data['username'] ) ,
				'user_id' => $user_id ,
				'address_id' => $data['address_id'] ,
				'sum_price' => $sum_price ,
				'st' => self::ORDER_ST_DAIZHIFU ,
				'goodst' => self::GOOT_ST_DAIFAHUO ,
				'create_time' => time() ,
				'update_time' => time() ,
			];
			if ( !$new_order_id = $this->insertGetId( $data_order ) ) {
				return ['code' => __LINE__ , 'msg' => 'add order error'];
			}
			//添加商家订单表end
			//给商家订单量增加一个
			Shop::increaseOrdernum( $shop->shop_id );
			//  添加订单商品
			foreach ( $shop->shop_goods as $good ) {
				$row_good = self::getById( $good->good_id , new Good() );
				$data_order_good = [
					'order_id' => $new_order_id ,
					'shop_id' => $row_good->shop_id ,
					'img' => $row_good->img ,
					'price' => $row_good->price ,
					'unit' => $row_good->unit ,
					'name' => $row_good['name'] ,
					'good_id' => $row_good->id ,
					'num' => $good->num ,
					'st' => OrderGood::ST_PREPARE ,

				];
				if ( !( new OrderGood() )->save( $data_order_good ) ) {
					return ['code' => __LINE__ , 'msg' => 'add order_good error'];
				}
			}
			//删除原购物车
			$row_cart = self::getById( $shop->cart_id , new Cart );
			$row_cart->sum_price = 0;
			$row_cart->st = 0;
			$row_cart->save();
			CartGood::where( ['cart_id' => $row_cart->id] )->update( ['st' => 0] );
		}
		if ( $new_order_contact_id == 0 ) {//如果是单商家订单
			return ['code' => 0 , 'msg' => 'dingdan shop order save_all ok' , 'type' => self::ORDER_TYPE_SHOP , 'data' => $new_order_id];
		} else {
			return ['code' => 0 , 'msg' => 'dingdan pingtai order save_all ok' , 'type' => self::ORDER_TYPE_CONTACT , 'data' => $new_order_contact_id];
		}
	}

	//生成订单号 wx
	public function makeTradeNo($username){
		return date( 'mdHis' , time() ) . mt_rand( 10 , 99 ) . '_' . $username;
	}

	/**
	 * 查询某个商家订单
	 *zhuangxiu-zyg
	 *
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function getOrder($data){
		$order_id = $data['order_id'];
		$row_order = self::where( ['dingdan.id' => $order_id] )->join( '
		shop' , 'shop.id=dingdan.shop_id' )->field( 'dingdan.*,shop.name shop_name' )->find();
		if ( !$row_order ) {
			return ['code' => __LINE__ , 'msg' => 'order is not exists'];
		}
		$list_order_goods = OrderGood::getGood( $order_id );
		if ( count( $list_order_goods ) == 0 ) {
			return ['code' => __LINE__ , 'msg' => '订单商品不存在'];
		}

		return ['code' => 0 , 'msg' => 'get order_goods ok' , 'data' => ['order' => $row_order , 'order_goods' => $list_order_goods]];
	}

	/*
	   取用户订单列表
	 * zhuangxiu-zyg
	 * */
	public static function getMyOrders($data){
		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		$where = ['dingdan.st' => ['neq' , 0] , 'user_id' => $user_id];
		$where2 = ['dingdan.st' => ['neq' , self::ORDER_ST_USER_DELETE]];
		$list_order = self::where( $where )->where( $where2 )->join( 'shop' , 'shop.id=dingdan.shop_id' )->field( 'dingdan.*,shop.name shop_name' )->order( 'create_time desc' )->select();
		if ( $list_order->isEmpty() ) {
			return ['code' => __LINE__ , 'msg' => 'order not exists'];
		}
		foreach ( $list_order as $k => $row_order ) {
			$list_order_good = OrderGood::getGood( $row_order->id );
			$list_order[$k]['goods'] = $list_order_good;
			$list_order[$k]['good_num'] = count( $list_order_good );
		}
		return ['code' => 0 , 'msg' => 'get order and order_goods ok' , 'data' => $list_order];

	}

	/*
	 * 更改订单状态，物流状态
	 * zhuangxiu-zyg
	 * */

	public static function updateSt($data){
		$row_ = self::find( ['id' => $data['order_id']] );
		if ( !$row_ ) {
			return ['code' => __LINE__ , 'msg' => '订单不存在'];
		}
		if ( $data['st'] == 'cancel' ) {
			$row_->st = self::ORDER_ST_USER_CANCEL;
		} elseif ( $data['st'] == 'paid' ) {
			$row_->st = self::ORDER_ST_PAID;
		} elseif ( $data['st'] == 'taken' ) {
			$row_->goodst = self::GOOT_ST_DAIFANKUI;//已收货
			OrderGood::where( ['order_id' => $data['order_id']] )->update( ['st' => OrderGood::ST_TAKEN] );
		} elseif ( $data['st'] == 'fankui' ) {//已评价
			$row_->goodst = self::GOOT_ST_FANKUIOK;
		} elseif ( $data['st'] == 'delByUser' ) {
			$row_->st = self::ORDER_ST_USER_DELETE;
		}
		$row_->save();
		return ['code' => 0 , 'msg' => '订单状态更改'];
	}

	/**
	 * 更改订单支付状态
	 *zhuangxiu-zyg
	 * @return \think\Response
	 */
	public static function updatePaySt($data){
		if ( $data['type_'] == Dingdan::ORDER_TYPE_SHOP ) {
			$row_order = self::find( ['id' => $data['order_id']] );
			if ( !$row_order ) {
				return ['code' => __LINE__ , 'msg' => '订单不存在'];
			}
			$row_order->st = self::ORDER_ST_PAID;
			if ( !$row_order->save() ) {
				return ['code' => 0 , 'msg' => 'order_shop paid failed'];
			}
			//订单支付完成，则商家收益也增加
			$admin_shop = Admin::where( ['shop_id' => $row_order->shop_id , 'st' => 1] )->find();
			if ( !$admin_shop ) {
				return ['code' => __LINE__ , 'msg' => 'shop admin not exsits or not allowed'];
			}
			$admin_shop->income += $row_order->sum_price;
			$admin_shop->save();
			//给商家增加交易量
			Shop::incTradenum( $row_order->shop_id );

			//给订单中的商品增加销量
			OrderGood::increseSales( $row_order->id );
			return ['code' => 0 , 'msg' => 'order_shop paid ok and shop admin income ok'];
		} elseif ( $data['type_'] == Dingdan::ORDER_TYPE_CONTACT ) {
			$row_order_contact = self::getById( $data['order_id'] , new OrderContact() );
			if ( !$row_order_contact ) {
				return ['code' => __LINE__ , 'msg' => '联合订单不存在'];
			}
			$row_order_contact->st = OrderContact::ORDER_CONTACT_PAID;
			$row_order_contact->save();
			//且要改下面所有商家订单状态的已支付
			$res = self::where( ['order_contact_id' => $row_order_contact->id] )->update( ['st' => self::ORDER_ST_PAID] );
			if ( !$res ) {
				return ['code' => __LINE__ , 'msg' => 'order_contact paid failed'];
			}
			//给下面商家管理员增加收益
			$list_order = Order::where( ['order_contact_id' => $row_order_contact->id] )->select();
			foreach ( $list_order as $order ) {
				$admin_shop = Admin::where( ['shop_id' => $order->shop_id , 'st' => 1] )->find();
				if ( !$admin_shop ) {
					return ['code' => __LINE__ , 'msg' => 'shop admin not exsits or not allowed'];
				}
				$admin_shop->income += $order->sum_price;
				$admin_shop->save();

				//给商家增加交易量
				Shop::incTradenum( $order->shop_id );
				//给订单中商品增加销量
				OrderGood::increseSales( $order->id );
			}
			return ['code' => 0 , 'msg' => 'order_contact paid ok and shop admin income ok'];
		} else {
			return ['code' => __LINE__ , 'msg' => 'type_ error'];
		}
	}





}
