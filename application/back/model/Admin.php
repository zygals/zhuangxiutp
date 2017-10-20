<?php

namespace app\back\model;

use think\Model;

class Admin extends model {


    public function getStAttr($value) {
        $status = [0 => 'deleted', 1 => '正常', 2 => '禁用'];
        return $status[$value];
    }

    public function getTypeAttr($value) {
        $status = [1 => '超级', 2 => '商户', 3 => '系统一般'];
        return $status[$value];
    }

    public static function pwdGenerate($pass) {
        return md5(md5($pass) . 'zhuangxiu');
    }

    public static function findByName($name) {
        $row_ = self::where(['name' => $name])->find();
        return $row_;
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
}
