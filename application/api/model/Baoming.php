<?php

namespace app\api\model;

use think\Model;

class Baoming extends Base {



    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '没验房', 2 => '已验房'];
        return $status[$value];
    }

	public function addBaoMing($data){
		$user_id = User::getUserIdByName($data['username']);
		if (is_array($user_id)) {
			return $user_id;
		}
		$data['user_id'] = $user_id;unset($data['username']);
		if(!$this->save($data)){
			return ['code'=>__LINE__,'msg'=>'add baoming error'];
		}
		return ['code'=>0,'msg'=>'add baoming ok'];
	}
    public static function getList($data=[],$where = ['st' => ['<>', 0]]) {


    }


}
