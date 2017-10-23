<?php

namespace app\api\model;

use think\Model;

class MenuAdmin extends model {


    public function getIsShowToShopAttr($value) {
        $status = [0=>'不可用', 1 => '可用'];
        return $status[$value];
    }

    public static function getList() {

        if(Admin::isShopAdmin()){
           //dump( session('admin_zhx'));exit;
            $list_first = self::where(['pid' => 0,'is_show_to_shop'=>1])->order('sort asc')->select();
            foreach ($list_first as $k => $first) {
                $list_second = self::where(['pid' => $first->id,'is_show_to_shop'=>1])->order('sort asc')->select();

                $list_first[$k]['childs'] = $list_second;
            }
        }else{
           // dump( session('admin_zhx'));exit;
            $list_first = self::where(['pid' => 0])->order('sort asc')->select();
            foreach ($list_first as $k => $first) {
                $list_second = self::where(['pid' => $first->id])->order('sort asc')->select();

                $list_first[$k]['childs'] = $list_second;
            }
        }

      // dump($list_first);exit;
        return $list_first;
    }
    /*
     *取一般管理员菜单
     * */
    public static function getListNormal(){
       // dump(98798797);exit;
        $list_first = self::where(['id' => ['in',session('admin_zhx')->privilege]])->order('sort asc')->select();
        return $list_first;
    }
    public static function getPower(){
        $list_ =  self::where(['pid' => ['<>',0]])->order('sort asc')->select();

        return $list_;
    }

    public function getName($pid){
        return $pid==0?'一级':$this->where('id',$pid)->value('name');
    }

    public function haveChild($id) {
        $row_ = $this->where(['pid' => $id])->find();
        return $row_;
    }
    public static function getListFirst(){
        $list_first = self::where(['pid' => 0])->order('sort asc')->select();


        return $list_first;
    }
}
