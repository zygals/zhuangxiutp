<?php

namespace app\api\model;

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
        $where = ['st'=>['<>',0]];
        if (!empty($data['name_'])) {
            $where[] = ['name|truename'=>'like', '%' . $data['name_'] . '%'];
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }
        $list_ = self::where($where)->order($order)->paginate();
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
}
