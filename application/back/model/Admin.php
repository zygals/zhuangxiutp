<?php

namespace app\back\model;

//use app\api\model\Dingdan;
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
    public static function findByName2($name,$admin_id) {
        $row_ = self::where(['id'=>['<>',$admin_id],'name' => $name])->find();
        return $row_;
    }

    public static  function getList($data=[]){
        $order = "create_time asc";
        $where = ['admin.st'=>['=',1]];
        if(Admin::isShopAdmin()){
            $where['shop_id']=session('admin_zhx')->shop_id;
        }
       // dump($data['shop_id']);exit;
        if (!empty($data['shop_id'])) {
            $where['shop_id'] = $data['shop_id'];
        }
       // dump($where);exit;
      if (!empty($data['name_'])) {
            $where['admin.name|admin.truename']=['like', '%' . trim($data['name_']) . '%'];
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }

        $list_ = self::where($where)->join('shop','admin.shop_id=shop.id','left')->field('admin.*,shop.name shop_name,shop.st shop_st')->order($order)->paginate(10);

       foreach($list_ as $admin){
           $shouyi= Dingdan::getConfirmOrderSum($admin->id); //统计收益方法;
           if(is_numeric($shouyi)){
               $admin['income'] = $shouyi;
           }
       }
//        dump($list_[2]->income);
        return $list_;
    }

    public function getShopSt($shop_st){
        switch ($shop_st){
            case 0:
                return '删除';
                break;
            case 1:
                return '正常';
                break;
            case 2:
                return '关';
                break;
        }

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
 * 获取商品管理员yitixian
 */
    public static function getwithdrawok(){
        $id = session('admin_zhx')->id;
        return   self::where('id',$id)->value('withdraw_ok');
    }
    /**
 * 获取商品管理员ketixian
 */
    public static function getketixian(){
        $id = session('admin_zhx')->id;
        //$remian = Withdraw::getRemain();
//        $confirm_order = Dingdan::getConfirmOrderSum($id);
        $withdraw_ok=Admin::where(['id'=>$id])->value('withdraw_ok');//已提现的
        $lock= Admin::getBenefitLock(); //冻结的
//        if($confirm_order>0 && $withdraw_ok>0){
//            $shou = $confirm_order-$withdraw_ok;
//        }else{
//            $shou = $confirm_order;
//        }
        $shouyi= Dingdan::getConfirmOrderSum($id);
        if(is_numeric($shouyi)){
            $keti=$shouyi-$withdraw_ok-$lock;
        }else{
            $keti=0;  //被禁用可能
        }
        return $keti;
    }


    /**
     * 获取商品管理员 ，已锁定收益
     */
    public static function getBenefitLock(){
        $id = session('admin_zhx')->id;
       return self::where('id',$id)->value('income_lock');

    }

    /**
     * 通过admin_id获取管理员用户收益
     */
    public static function getBenefitLockByAdmin($admin_id){
        return self::where(['id'=>$admin_id])->value('income_lock');
    }
    /**
     * 通过admin_id获取管理员用户收益
     */
    public static function getBenefitByAdmin($admin_id){
        return self::where(['id'=>$admin_id])->value('income');
    }


    /**
     * 通过admin_id获取管理员用户收益
     */
    public static function getBenefitByAdminId($shop_id){
        $benefit = self::where(['shop_id'=>$shop_id])->find();
        return $benefit['income'];
    }

    public static function increaseLock($cash){

        self::where('id',session('admin_zhx')->id)->setInc('income_lock',$cash);
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
/*
 * 管理员密码不对，返回数组
 * */
	public static function passRight($pass_admin){
        $admin = Admin::where(['type' => 1])->find();
        //dump($admin);exit;
        if (Admin::pwdGenerate($pass_admin) !== $admin->pwd) {
            return ['code' => __LINE__, 'msg' => '密码有误！'];
        }
        return true;
    }
}
