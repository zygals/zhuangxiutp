<?php

namespace app\back\model;
use think\Model;
class Message extends Base{
    protected  $dateFormat='Y-m-d H:i:s';
    public function getStatusAttr($value){
        $status = [0 => '删除', 1 => '未读',2=>'已读'];
        return $status[$value];
    }
    /**
     * @param array $data
     * @param array $where
     * 处理主页资源列表
     */
    public static function getList($where=['message.status' => ['<>',0]]){
       $order = 'message.create_time desc';
        $fields = 'message.*,user.nickname,user.username ,shop.name shop_name';
        $list_ = self::where($where)->join('shop','shop.id=message.shop_id')->join('user','user.id=message.user_id')->field($fields)->order($order)->group('message.user_id,message.shop_id')->paginate(10);
        return $list_;
    }

    /**
     * 通过id查询出该用户所有的留言
     */
    public static function getListById($data){
        $order = 'message.create_time asc';
        $fields = 'message.*,user.nickname,user.username,shop.name shop_name';
        $list_ = self::where(['user_id'=>$data['user_id'],'shop_id'=>$data['shop_id']])->join('user','message.user_id=user.id')->join('shop','shop.id=message.shop_id')->field($fields)->order($order)->paginate(5);
        return $list_;
    }

    /**
     * 通过id查询出该条留言
     */
    public static function geyListById($data){

    }


}