<?php

namespace app\back\model;

use think\Model;

class Admin extends Base {


    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常', 2 => '禁用'];
        return $status[$value];
    }

    public function getTypeAttr($value) {
        $status = [1 => '超级', 2 => '商户', 3 => '一般'];
        return $status[$value];
    }

    public static function pwdGenerate($pass) {
        return md5(md5($pass) . 'zhuangxiu');
    }

    public static function findByName($name) {
        $row_ = self::where(['name' => $name])->find();
        return $row_;
    }

    public static  function getList($data=[]){
        $order = "create_time asc";
        $where = ['st'=>['=',1]];
       // dump($data['shop_id']);exit;
        if (!empty($data['shop_id'])) {
            $where['shop_id'] = $data['shop_id'];
        }
       // dump($where);exit;
      if (!empty($data['name_'])) {
            $where['name|truename']=['like', '%' . $data['name_'] . '%'];
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }
        $list_ = self::where($where)->order($order)->paginate(10);
        return $list_;
    }

    /*
     * 判断是不是商户管理员
     * */
    public static function isShopAdmin() {
        if (session('admin_zhx')->type == '商户') {
            return true;
        }
        return false;
    }
    /*
  * 判断是不是超级管理
  * */
    public static function isAdmin(){
        if (session('admin_zhx')->type == '超级') {
            return true;
        }
        return false;
    }
    /*
* 判断是不是超级管理
* */
    public static function isGeneral(){
        if (session('admin_zhx')->type == '一般') {
            return true;
        }
        return false;
    }

    /**
     * 获取商品管理员用户收益
     */
    public static function getBenefit(){
        $id = session('admin_zhx')->id;
        $benefit = self::where('id',$id)->find();
        return $benefit['income'];
    }

    /**
     * 通过admin_id获取管理员用户收益
     */
    public static function getBenefitByAdminId($data){
        $benefit = self::where(['id'=>$data])->find();
        return $benefit['income'];
    }
	/*
	 * 根据商家id查询相应的管理员，一个商家只有一个管理员
	 * zhuangxiu-zyg
	 *
	 * @return boolean
	 * */
	public static function findShopAdmin($shop_id){
		return self::where(['shop_id'=>$shop_id,'st'=>1])->find();
	}
}
