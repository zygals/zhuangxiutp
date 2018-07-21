<?php

namespace app\back\model;
use think\Model;
class Message extends Base{
    protected  $dateFormat='Y-m-d H:i:s';
    public function getStAttr($value){
        $status = [0 => '删除', 1 => '正常',2=>'用户删除'];
        return $status[$value];
    }
    /**
     * @param array $data
     * @param array $where
     * 处理主页资源列表
     */
    public static function getList($data=[],$where=['message.st' => ['=',1]]){
        if(Admin::isShopAdmin()){
            $where['message.shop_id']=session('admin_zhx')->shop_id;
        }
        if(!empty($data['shop_id'])){
            $where['message.shop_id']=$data['shop_id'];
        }
       $order = 'message.create_time desc';
        $fields = 'message.*,user.nickname,user.username ,shop.name shop_name,count(message.id) sum';
        $list_ = self::where($where)->join('shop','shop.id=message.shop_id')->join('user','user.id=message.user_id')->field($fields)->order($order)->group('message.user_id,message.shop_id')->paginate(10);
        return $list_;
    }

    /**
     * 通过id查询出该用户所有的留言
     */
    public static function getListById($data){
        $order = 'message.create_time asc';
        $fields = 'message.*,user.nickname,user.username,shop.name shop_name';
        $list_ = self::where(['message.st'=>1,'user_id'=>$data['user_id'],'shop_id'=>$data['shop_id']])->join('user','message.user_id=user.id')->join('shop','shop.id=message.shop_id')->field($fields)->order($order)->paginate(20);
        return $list_;
    }

    /**
     * 通过id查询出该条留言
     */
    public static function geyListById($data){

    }


}