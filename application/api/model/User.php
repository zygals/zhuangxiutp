<?php

namespace app\api\model;

use think\Model;

class User extends Base
{

	public function getSexAttr($value)
	{
		$status = [0=>'',1=>'男',2=>'女'];
		return $status[$value];
	}
    //分页查询
	public function getAllUsers($data){
	    $where = [];
        $order = 'create_time desc';
	    if(!empty($data['time_from'])){
            $where['create_time']=['gt',strtotime($data['time_from'])];
        }
        if(!empty($data['time_to'])){
            $where['create_time']=['lt',strtotime($data['time_to'])];
        }
 		 if(!empty($data['time_from']) && !empty($data['time_to'])){
            $where['create_time']=[['gt',strtotime($data['time_from'])],['lt',strtotime($data['time_to'])]];
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }

        $list=$this->where($where)->order($order)->paginate(config('paginate.list_rows'));

		return $list;
	}
//wx
    public static function registUserByOpenId($openid){
        $row_= self::get(['open_id'=>$openid]);
        if(!$row_){
            $data = [
                'open_id'=>$openid,
                'username'=> self::randomName(6),
                'create_time'=>time(),
                'update_time'=>time(),
            ];
            $res = self::insert($data);
            if($res){

                return ['code'=>0,'msg'=>'register user ok','data'=>$data['username']];
            }
            return ['code'=>__LINE__,'msg'=>'register user error'];
        }
        $row_->update_time = time();$row_->save();
        return ['code'=>0,'msg'=>'already register user ok','data'=>$row_['username']];

    }//wx
    public static function getUserIdByName($username){
        $row_ = self::get(['username'=>$username]);
        if(!$row_){
            return ['code'=>__LINE__,'msg'=>'用户不存在'];
        }
        return $row_->id;
    }//wx
    public static function randomName($length){
        $chars = 'abcdefghijklmnopqrstuvwxyzAB_CD-EFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $name = '';
        for ( $i = 0; $i < $length; $i++ )
        {

            $name .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        $user = self::find(['username'=>$name]);
        if($user){
            return  self::randomName($length);
        }
        return $name;
    }

}
