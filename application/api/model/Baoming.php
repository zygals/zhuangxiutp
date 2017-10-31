<?php

namespace app\api\model;

use app\back\model\User;
use think\Model;

class Baoming extends Base{


	public function getStAttr($value){
		$status = [0 => 'deleted' , 1 => '没验房' , 2 => '已验房'];
		return $status[$value];
	}

	public function addBaoMing($data){
		$user_id = User::getUserIdByName( $data['username'] );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		$data['user_id'] = $user_id;
		unset( $data['username'] );
		if ( !empty( $data['time_to'] ) ) {
			$data['time_to'] = strtotime( $data['time_to'] );
		}
		if ( !$this->save( $data ) ) {
			return ['code' => __LINE__ , 'msg' => 'add baoming error'];
		}
		return ['code' => 0 , 'msg' => 'add baoming ok'];
	}

	/**
	 * 查询我的报名
	 *zhuangxiu-zyg
	 */
	public static function getList($username){
		$user_id = User::getUserIdByName( $username );
		if ( is_array( $user_id ) ) {
			return $user_id;
		}
		$list_ = self::where(['user_id'=>$user_id])->select();
		if($list_->isEmpty()){
			return ['code'=>__LINE__,'msg'=>'baoming not exists'];
		}
		return ['code'=>0,'msg'=>'baoming ok','data'=>$list_];

	}


}
