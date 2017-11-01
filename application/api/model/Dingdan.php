<?php

namespace app\api\model;

use think\Model;
use app\api\model\Good;
use app\api\model\OrderGood;

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
	/*
		* 立即购买，显示订单详情 zyg
		* */
	/* public static function getDetail($data){

		 $row_good = self::getById($data['good_id'],new Good);
		  if(!$row_good){
			  return ['code'=>__LINE__,'msg'=>'good not exsits'];
		  }
		  $row_shop = self::getById($row_good->shop_id,new Shop);
		 if(!$row_shop){
			 return ['code'=>__LINE__,'msg'=>'good of shop not exsits'];
		 }
		 return ['code'=>0,'msg'=>'get shop and good ok','data'=>['shop'=>$row_shop,'good'=>$row_good]];

	 }*/

	public static function findOne($order_id){
		$row_ = self::where( ['dingdan.id' => $order_id] )->join( 'user' , 'dingdan.user_id=user.id' )->join( 'shop' , 'shop.id=dingdan.shop_id' )->join( 'address' , 'address.id=dingdan.address_id' )->field( 'dingdan.*,address.truename,address.mobile,address.pcd,address.info,user.username,shop.id shop_id,shop.name shop_name' )->find();

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
		if ( !empty( $data['st'] ) ) {
			$where['dingdan.st'] = $data['st'];
		}
		if ( !empty( $data['paixu'] ) ) {
			$order = $data['paixu'] . ' asc';
		}
		if ( !empty( $data['paixu'] ) && !empty( $data['sort_type'] ) ) {
			$order = $data['paixu'] . ' desc';
		}
		$list = self::where( $where )->join( 'user' , 'user.id=dingdan.user_id' )->join( 'shop' , 'dingdan.shop_id=shop.id' )->field( 'dingdan.*,user.username,shop.name shop_name' )->order( $order )->paginate();
		//dump($list);

		return $list;
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
			$sum_price_all += $row_cart->sum_price;
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
			$row_cart->st = 0;
			$row_cart->save();
			 OrderGood::where(['cart_id'=>$row_cart->id])->update(['st'=>0]);
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
		/*$row_address = [];
		if ( $row_order->address_id !== 0 ) {
			$row_address = Address::read( $row_order->address_id );
		}*/
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
			OrderGood::updateSt( $data['order_id'] , 'taken' );
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
			if(!$row_order->save()){
				return ['code' => 0 , 'msg' => 'order_shop paid failed'];
			}
			return ['code' => 0 , 'msg' => 'order_shop paid ok'];
		} elseif ( $data['type_'] == Dingdan::ORDER_TYPE_CONTACT ) {
			$row_order_contact = self::getById( $data['order_id'] , new OrderContact() );
			if ( !$row_order_contact ) {
				return ['code' => __LINE__ , 'msg' => '联合订单不存在'];
			}
			$row_order_contact->st = OrderContact::ORDER_CONTACT_PAID;
			$row_order_contact->save();
			//且要改下面所有商家订单状态的已支付
			$res = self::where( ['order_contact_id' => $row_order_contact->id] )->update( ['st' => self::ORDER_ST_PAID] );
			if(!$res){
				return ['code' => __LINE__ , 'msg' => 'order_contact paid failed'];
			}
			return ['code' => 0 , 'msg' => 'order_contact paid ok'];
		} else {
			return ['code' => __LINE__ , 'msg' => 'type_ error'];
		}
	}

}
