<?php

namespace app\api\model;

use app\back\model\OrderGood;
use app\back\model\Tuangou;
use think\Db;
use think\Model;

class Dingdan extends Base{
    protected $dateFormat='Y-m-d H:i:s';
	const ORDER_ST_DAIZHIFU = 1;
	const ORDER_ST_PAID = 2;
	const ORDER_ST_REFUNDED = 3;
	const ORDER_ST_USER_CANCEL = 4;
	const ORDER_ST_USER_DELETE = 5;
	const ORDER_ST_USER_REFUND = 6;
	const ORDER_ST_ADMIN_DELETE = 0;
	const ORDER_ST_YOUHUI_GOOD = 7;
	const ORDER_ST_YOUHUI_QUANKUAN = 8;
	const GOOT_ST_DAIFAHUO = 1;
	const GOOT_ST_DAIFANKUI = 3; //已收货
	const GOOT_ST_FANKUIOK = 4; //已评价
	const ORDER_TYPE_SHOP = 1; //单商家订单
	const ORDER_TYPE_CONTACT = 2; //多商家订单
	const ORDER_TYPE_GROUP_DEPOSIT = 3; //限人订金
	const ORDER_TYPE_GROUP_FINAL = 6; //限人订金
	const  ORDER_TYPE_SHOP_DEPOSIT = 4; //商家订金订单
	const  ORDER_TYPE_SHOP_MONEY_ALL = 5; //全款订单
	//public static $arrStatus = [1 => '未支付' , 2 => '已支付' , 4 => '用户取消' , 5 => '用户删除',6=>'申请退款'];

	public function getStAttr($value){
		$status = ['0' => '管理员删除' , 1 => '待支付' , 2 => '已支付' , 3 => '已退款', 4 => '用户取消' , 5 => '用户删除',6=>'申请退款',7=>'订金抵扣商品',8=>'订金抵扣全款'];
		return $status[$value];
	}

	//订单的商品总状态
	public function getGoodstAttr($value){
		$status = [1 => '没发货' , 2 => '已发货' , 3 => '已收货' , 4 => '已评价' , 5 => '部分发货'];
		return $status[$value];
	}

	public function getTypeAttr($value){
		$status = [1 => '普通' ,/* 2 => '限量' ,*/
				   3 => '限人' , 4 => '商家订金' , 5 => '商家全款' , 6 => '限人尾款'];
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

	/**
	 * 添加订单--商家订金或商家全款
	 * zhunagxiu
	 * submit order
	 * zyg
	 */
	public function addOrderDeposit($data){
		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		/*if ( $row = self::where( ['user_id' => $user_id , 'type' => $data['type_'] , 'shop_id' => $data['shop_id'],'st'=>1] )->find() ) {
			return ['code' => __LINE__ , 'msg' => '不能重复添加'];
		}*/
		$data_order['shop_id'] = $data['shop_id'];
		$data_order['sum_price'] = $data['sum_price'];
		$data_order['orderno'] = $this->makeTradeNo( $data['username'] );
		$data_order['type'] = $data['type_'];//订金类型4 ，全款类型=5
		$data_order['user_id'] = $user_id;
		$data_order['address_id'] = $data['address_id'];
		$data_order['beizhu'] = $data['beizhu'];
		$data_order['sum_price_youhui'] = $data['youhui']; //订金或全款优惠
       if($data['type_']==self::ORDER_TYPE_SHOP_MONEY_ALL && $data['order_id_deposit']>0 ){
            //用了订金
            $row_deposit=self::where(['id'=>$data['order_id_deposit'],'st'=>self::ORDER_ST_PAID])->find();
            $row_deposit->st=self::ORDER_ST_YOUHUI_QUANKUAN;
            $row_deposit->orderno_youhui = $data_order['orderno'];
            $data_order['sum_price_youhui'] = $data['youhui']+$row_deposit->sum_price+$row_deposit->sum_price_youhui;
            $data_order['orderno_youhui'] = $row_deposit->orderno;//被优惠订单
            $row_deposit->save();
        }
		if ( !$this->save( $data_order ) ) {
			return ['code' => __LINE__ , 'msg' => '添加失败'];
		}

		//给商家订单量增加一个
		Shop::increaseOrdernum( $data_order['shop_id'] );
		return ['code' => 0 , 'msg' => '添加成功' , 'order_id' => $this->id , 'type' => $data['type_']];
	}

	/*
	 * 我的订单-团购订金
	 * */

	public static function hasOrderGroupDeposit($data){
		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		if ( $row = self::where( ['user_id' => $user_id , 'type' => self::ORDER_TYPE_GROUP_DEPOSIT , 'group_id' => $data['t_id'],'st'=>['in','1,2']] )->find() ) {
			return ['code' => 0 , 'msg' => '有订金订单' , 'data' => $row];
		}
		return ['code' => __LINE__ , 'msg' => '无订金订单'];
	}
	/*
		 * 我是否下过些团购尾款订单？
		 * zhuangxiu-zyg
		 * */
	public static function hasOrderGroupFinal($data){
		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		if ( $row = self::where( ['user_id' => $user_id , 'type' => self::ORDER_TYPE_GROUP_FINAL , 'group_id' => $data['t_id'],'st'=>['in','1,2']] )->find() ) {
			return ['code' => 0 , 'msg' => '有尾款订单' , 'data' => $row];
		}
		return ['code' => __LINE__ , 'msg' => '无尾款订单'];
	}

	/**
	 * 添加订单--团购订金或是尾款
	 * zhunagxiu
	 * submit order
	 * zyg
	 */
	public function addOrderGroupDeposit($data){
		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		//如果已添加不重复
		if ( $row = self::where( ['user_id' => $user_id , 'type' => $data['type_'] , 'group_id' => $data['t_id'],'st'=>['in','1,2']] )->find() ) {
			return ['code' => __LINE__ , 'msg' => '不能重复添加'];
		}
		//dump($row);exit;
		$row_group = self::getById( $data['t_id'] , new Tuangou() );
		if ( !$row_group ) {
			return ['code' => __LINE__ , 'msg' => '团购数据没有'];
		}
		$data_order['shop_id'] = $row_group->shop_id;
		$data_order['group_id'] = $row_group->id;
		$data_order['orderno'] = $this->makeTradeNo( $data['username'] );
		$data_order['type'] = $data['type_'];
		$data_order['user_id'] = $user_id;
		$data_order['address_id'] = $data['address_id'];
		if ( $data['type_'] == self::ORDER_TYPE_GROUP_DEPOSIT ) {
			$data_order['sum_price'] = $row_group->deposit;
		} else {
			$data_order['sum_price'] = $row_group->price_group - $row_group->deposit;
		}
		if ( !empty( $data['beizhu'] ) ) {
			$data_order['beizhu'] = $data['beizhu'];
		}

		if ( !$this->save( $data_order ) ) {
			return ['code' => __LINE__ , 'msg' => '添加订单失败'];
		}
		//给商家订单量增加一个
		Shop::increaseOrdernum( $data_order['shop_id'] );
		//添加订单商品
		$row_good = self::getById( $row_group->good_id , new Good() );
		if ( !$row_good ) {
			return ['code' => __LINE__ , 'msg' => '团购商品没有'];
		}
		$data_order_good['order_id'] = $this->id; //new order_id
		$data_order_good['shop_id'] = $row_group->shop_id;
		$data_order_good['good_id'] = $row_good->id;
		$data_order_good['name'] = $row_good['name'];
		$data_order_good['img'] = $row_good->img;
		$data_order_good['unit'] = $row_good->unit;
		$data_order_good['price'] = $row_good->price;
		$data_order_good['price_group'] = $row_group->price_group;
		$data_order_good['group_deposit'] = $row_group->deposit;
		if ( !( new OrderGood() )->save( $data_order_good ) ) {
			return ['code' => __LINE__ , 'msg' => '添加订单成功，商品添加失败'];
		}
		return ['code' => 0 , 'msg' => '添加成功' , 'order_id' => $this->id,'type'=>$data['type_']];
	}

	/*
	 * 添加商品订单 zhuangxiu - zyg
	 *
	 * */
	public function addOrder($data){
		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		$arr_shop_good_list = json_decode( $data['shop_good_list'] );
		if ( !is_array( $arr_shop_good_list ) ) {
			return ['code' => __LINE__ , 'msg' => '数据错误'];
		}

		$sum_price_all = 0;
		foreach ( $arr_shop_good_list as $shop ) {
			$row_cart = self::getById( $shop->cart_id , new Cart );
			if ( !$row_cart ) {
				return ['code' => __LINE__ , 'msg' => '没有数据'];
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
				return ['code' => 0 , 'msg' => '添加失败'];
			}
		}

		foreach ( $arr_shop_good_list as $shop ) {
			//添加商家订单表开始
			$sum_price = 0;
			foreach ( $shop->shop_goods as $good ) {
				$row_good = self::getById( $good->good_id , new Good() );
				if ( !$row_good ) {
					return ['code' => __LINE__ , 'msg' => '商品不存在'];
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
            //是否用了订金
            if(!empty($data['order_id_deposit']) && $data['order_id_deposit']){
                $row_deposit=self::where(['id'=>$data['order_id_deposit'],'st'=>self::ORDER_ST_PAID])->find();
                $row_deposit->st=self::ORDER_ST_YOUHUI_GOOD;
                $row_deposit->orderno_youhui = $data_order['orderno'];
                $data_order['sum_price_youhui'] = $row_deposit->sum_price+ $row_deposit->sum_price_youhui;
                $data_order['orderno_youhui'] = $row_deposit->orderno;//被优惠订单
                $data_order['sum_price'] -= ($row_deposit->sum_price+ $row_deposit->sum_price_youhui);
                $row_deposit->save();
            }
			if ( !$new_order_id = $this->insertGetId( $data_order ) ) {
				return ['code' => __LINE__ , 'msg' => '添加失败'];
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
					return ['code' => __LINE__ , 'msg' => '添加失败'];
				}
			}
			//删除原购物车
			/*$row_cart = self::getById( $shop->cart_id , new Cart );
			$row_cart->sum_price = 0;
			$row_cart->st = 0;
			$row_cart->save();
			CartGood::where( ['cart_id' => $row_cart->id] )->update( ['st' => 0] );*/
		}
		if ( $new_order_contact_id == 0 ) {//如果是单商家订单
			return ['code' => 0 , 'msg' => 'dingdan shop order save_all ok' , 'type' => self::ORDER_TYPE_SHOP , 'data' => $new_order_id];
		} else {
			return ['code' => 0 , 'msg' => 'dingdan pingtai order save_all ok' , 'type' => self::ORDER_TYPE_CONTACT , 'data' => $new_order_contact_id];
		}
	}

	//生成订单号 wx
	public function makeTradeNo($username){
		return date( 'mdHis' , time() ) .mt_rand(1,99). mt_rand( 10 , 999 ) . '_' . $username;
	}
    public static function makeRefundNo() {
        return date('mdHis', time()) . mt_rand(10, 99) .'_refund';
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
			return ['code' => __LINE__ , 'msg' => '订单不存在'];
		}
		$list_order_goods = OrderGood::getGood( $order_id );
		if ( count( $list_order_goods ) == 0 ) {
			return ['code' => __LINE__ , 'msg' => '订单商品不存在'];
		}
		return ['code' => 0 , 'msg' => '查询订单成功' , 'data' => ['order' => $row_order , 'order_goods' => $list_order_goods]];
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
			return ['code' => __LINE__ , 'msg' => '订单不存在'];
		}
		foreach ( $list_order as $k => $row_order ) {
			$list_order_good = OrderGood::getGood( $row_order->id );
			$list_order[$k]['goods'] = $list_order_good;
			$list_order[$k]['good_num'] = count( $list_order_good );
		}
		return ['code' => 0 , 'msg' => '获取订单列表成功' , 'data' => $list_order];

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
		}elseif ( $data['st'] == 'refundByUser' ) {
            $row_->st = self::ORDER_ST_USER_REFUND;
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
		if ( $data['type_'] == Dingdan::ORDER_TYPE_SHOP || $data['type_'] == Dingdan::ORDER_TYPE_SHOP_DEPOSIT || $data['type_'] == Dingdan::ORDER_TYPE_SHOP_MONEY_ALL || $data['type_'] == Dingdan::ORDER_TYPE_GROUP_DEPOSIT || $data['type_'] == Dingdan::ORDER_TYPE_GROUP_FINAL ) {
			$row_order = self::find( ['id' => $data['order_id']] );
			if ( !$row_order ) {
				return ['code' => __LINE__ , 'msg' => '订单不存在'];
			}
			$row_order->st = self::ORDER_ST_PAID;
			//全款被订金优惠
            /*if($data['type_']==self::ORDER_TYPE_SHOP_MONEY_ALL && !empty($data['order_id_deposit']) && $data['order_id_deposit']>0  ){
                //用了订金
                $row_deposit=self::where(['id'=>$data['order_id_deposit'],'st'=>self::ORDER_ST_PAID])->find();

                $row_deposit->st=self::ORDER_ST_YOUHUI_QUANKUAN;
                $row_deposit->orderno_youhui = $row_order->orderno;
                $row_order->sum_price_youhui = $row_deposit->sum_price;
                $row_order->orderno_youhui= $row_deposit->orderno;//被优惠订单
                $row_deposit->save();
            }*/
			if ( !$row_order->save() ) {
				return ['code' => 0 , 'msg' => '支付状态失败'];
			}
			//订单支付完成，则商家收益也增加
			$admin_shop = Admin::where( ['shop_id' => $row_order->shop_id , 'st' => 1] )->find();
			if ( !$admin_shop ) {
				return ['code' => __LINE__ , 'msg' => '店铺管理员不存在或没有权限'];
			}
			$admin_shop->income += $row_order->sum_price;
			$admin_shop->save();

			//给商家增加交易量
			Shop::incTradenum( $row_order->shop_id );
			if ( $data['type_'] == Dingdan::ORDER_TYPE_SHOP || $data['type_'] == Dingdan::ORDER_TYPE_GROUP_FINAL) {
				//给订单中的商品增加销量
				\app\api\model\OrderGood::increseSales( $row_order->id );
			}
			//将用户团购订金订单取消
            if($data['type_'] == Dingdan::ORDER_TYPE_GROUP_FINAL){
                $user_id=User::getUserIdByName($data['username']);
                self::where(['user_id'=>$user_id,'type'=>self::ORDER_TYPE_GROUP_DEPOSIT,'group_id'=>$row_order->group_id])->save(['st'=>self::ORDER_ST_USER_CANCEL]);
			}


			return ['code' => 0 , 'msg' => '订单为已支付'];
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
				return ['code' => __LINE__ , 'msg' => '联合订单状态修改失败'];
			}
			//给下面商家管理员增加收益
			$list_order = Order::where( ['order_contact_id' => $row_order_contact->id] )->select();
			foreach ( $list_order as $order ) {
				$admin_shop = Admin::where( ['shop_id' => $order->shop_id , 'st' => 1] )->find();
				if ( !$admin_shop ) {
					return ['code' => __LINE__ , 'msg' => '店铺管理员不存在或没有权限'];
				}
				$admin_shop->income += $order->sum_price;
				$admin_shop->save();

				//给商家增加交易量
				Shop::incTradenum( $order->shop_id );
				//给订单中商品增加销量
				OrderGood::increseSales( $order->id );
			}
			return ['code' => 0 , 'msg' => '更改成功'];
		} else {
			return ['code' => __LINE__ , 'msg' => '更改失败'];
		}
	}
	/*
	 *  * 取订金订单或全款
	 * zhugnxiu-zyg
	 * */
	public static function getOrderUserDeposit($data){
        $user_id = User::getUserIdByName( $data['username'] );
        if ( is_array( $user_id ) ) {
            return $user_id;
        }
        $list_= self::where(['user_id'=>$user_id,'st'=>self::ORDER_ST_PAID,'type'=>$data['type_']])->select();
        if($list_->isEmpty()){
            return ['code'=>__LINE__,'msg'=>'暂无订金优惠订单'];
        }
        return ['code'=>0,'data'=>$list_];

    }
    /*
     * 取用户在某个商过的订金订单
     * */
    public static function getShopDeposit($data){
        $user_id = User::getUserIdByName( $data['username'] );
        if ( is_array( $user_id ) ) {
            return $user_id;
        }
        $row_ = self::where(['user_id'=>$user_id,'shop_id'=>$data['shop_id'],'st'=>self::ORDER_ST_PAID,'type'=>self::ORDER_TYPE_SHOP_DEPOSIT])->order('create_time asc')->field('id,sum_price,sum_price_youhui')->find();
        if(!$row_){
            return ['code'=>__LINE__];
        }
        return ['code'=>0,'data'=>$row_];

    }

    public static function testshiwu(){
        $data = ['orderno' => 'orderno5'];
        Db::startTrans();
        try{
            $id= (new  Dingdan2)->insertGetId($data);
            //$id=Db::table('dingdan2')->insertGetId($data);
            $data2 = ['order_id' => $id,'good_id'=>$id];
           // Db::table('dingdan_good2')->insert($data2);
            (new Dingdan_good2())->insert($data2);
            // 提交事务
            Db::commit();
            echo 'tijiao';
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            echo 'hui';
        }
    }

}
