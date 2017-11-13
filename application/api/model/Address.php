<?php

namespace app\api\model;


use think\Model;

class Address extends Base{
	/**
	 * 获取用户地址列表
	 * @return array|false|object|\PDOStatement|string|Model
	 */
	public static function getList($data){
		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		$list_ = self::where( ['user_id' => $user_id , 'address.st' => 1] )->field( 'id,truename,mobile,is_default,pcd,info' )->order( 'address.is_default desc' )->paginate( 5 );
		if ( count( $list_ ) == 0 ) {
			return ['code' => __LINE__ , 'msg' => '没数据啊!'];
		}
		return $list_;
	}

	//use
	public static function getUserDefaultAddress($user_id){
		$row_ = self::where( ['user_id' => $user_id] )->order( 'create_time desc' )->find();
		if ( !$row_ ) {
			$row_ = (object) ['id' => 0];
		}
		// dump($user_id);exit;
		return $row_;
	}

	/**
	 * 添加地址
	 * @return array
	 */
	public function saveAdd($data){

		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		$data['user_id'] = $user_id;
		unset( $data['username'] );
		$res = $this->where( 'user_id' , $user_id )->find();
		if ( !$res ) {
			$data['is_default'] = 1;
			if ( $this->save( $data ) ) {
				return ['code' => 0 , 'msg' => '添加成功' , 'data' => $this->id];
			} else {
				return ['code' => __LINE__ , '添加失败'];
			}
		}
		/* if($data['is_default']==1){
				$this->where('user_id',$user_id)->update(['is_default'=>0]);
			}*/

		if ( $this->save( $data ) ) {
			return ['code' => 0 , 'msg' => '添加成功' , 'data' => $this->id];
		} else {
			return ['code' => __LINE__ , '添加失败'];
		}
	}

	/**
	 * 查询出要修改的单条地址信息
	 * @return array
	 */
	public function editAdd($data){
		$address_id = $data['id'];
		$row_ = self::where( ['id' => $data['id'] , 'st' => 1] )->field( 'id,user_id,truename,mobile,is_default,pcd,info' )->find();
		return $row_;
	}

	/**
	 * 执行修改接口
	 * @return array
	 *
	 */
	public function updAdd($data){
		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		if ( isset( $data['is_default'] ) && $data['is_default'] == 1 ) {
			$this->where( 'user_id' , $user_id )->update( ['is_default' => 0] );
		}
		unset( $data['username'] );
		if ( $this->save( $data , ['id' => $data['id']] ) ) {
			return ['code' => 0 , 'msg' => '添加成功' , 'data' => $this->id];
		} else {
			return ['code' => __LINE__ , '添加失败'];
		}

	}

	/**
	 * 执行删除接口
	 * @return array
	 *
	 */
	public function delAdd($data){
		$id = $data['id'];
		unset( $data['username'] );
		if ( $this->where( ['id' => $id] )->update( ['st' => 0] ) ) {
			return ['code' => 0 , 'msg' => 'del address success'];
		} else {
			return ['code' => __LINE__ , 'del address failed'];
		}
	}

	public function choAdd($data){
		$id = $data['id'];
		$user_id = User::getUserIdByName( $data['username'] );
		unset( $data['username'] );
		$this->where( 'user_id' , $user_id )->update( ['is_default' => 0] );
		if ( $this->where( 'id' , $id )->update( ['is_default' => 1] ) ) {
			return ['code' => 0 , 'msg' => 'choose default address success'];
		} else {
			return ['code' => __LINE__ , 'choose default address failed'];
		}

	}


	// use
	/*
	 *
如果没有地址则添加，在添加完，要更新订单的地址
	 * */
	public function addAddress($data){
		$order_id = $data['order_id'];
		unset( $data['order_id'] );
		$user_id = User::getUserIdByName( $data['user_name'] );
		unset( $data['user_name'] );

		$data['user_id'] = $user_id;

		if ( $this->save( $data ) ) {
			$m_order = new Dingdan();
			$m_order->save( ['address_id' => $this->id] , ['id' => $order_id] );
			return ['code' => 0 , 'msg' => 'add address ok' , 'data' => $this->id];
		} else {
			return ['code' => __LINE__ , 'add address error'];
		}
	}

	/*
 * 查询订单地址
 * zhuangxiu-zyg
 * */
	public static function read($address_id){
		if ( !$row_ = self::find( $address_id ) ) {
			return ['code' => __LINE__ , 'msg' => 'address not exists'];

		}
		return ['code' => 0 , 'msg' => 'address ok' , 'data' => $row_];
	}

	public static function getDefault($username){
		$user_id = User::getUserIdByName( $username );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		$row_address = self::where( ['user_id' => $user_id , 'is_default' => 1 , 'st' => 1] )->find();
		if ( !$row_address ) {
			$row_address = self::where( ['user_id' => $user_id , 'st' => 1] )->order( 'create_time desc' )->find();
		}
		if ( !$row_address ) {
			return ['code' => __LINE__ , 'msg' => 'address not exsits'];
		}
		return ['code' => 0 , 'msg' => 'get address default ok' , 'data' => $row_address];

	}
}
