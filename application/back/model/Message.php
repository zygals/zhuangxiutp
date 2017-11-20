<?php

namespace app\back\model;
use think\Model;
class Message extends Base{
    public function getStatusAttr($value){
        $status = [0 => '删除', 1 => '未读',2=>'已读'];
        return $status[$value];
    }
    /**
     * @param array $data
     * @param array $where
     * 处理主页资源列表
     */
    public static function getList($data=[],$where=['message.status' => ['<>',0],'message.type' => '1']){
       // $order = 'create_time desc';
        $fields = 'message.*,user.nickname,shop.name';
        $list_ = self::where($where)->join('shop','shop.id=message.shop_id')->join('user','user.id=message.user_id')->field($fields)->order('')->paginate(10);
        return $list_;
    }

    /**
     * 通过id查询出该用户所有的留言
     */
    public static function getListById($data){
        $order = 'create_time desc';
        $fields = 'message.*,user.nickname,shop.name';
        $list_ = self::where('id',$data)->find();
        if($list_->status == '未读'){
            $message = new Message();
            $message->save(['status'=>2,'read_time'=>time()],['id'=>$data]);
        }
        $where['user_id'] = array('eq',$list_['user_id']);
        $where['shop_id'] = array('eq',$list_['shop_id']);
        $where['status'] = array('<>',0);
        $list = self::where($where)->join('shop','shop.id=message.shop_id')->join('user','user.id=message.user_id')->order($order)->field($fields)->paginate(10);
        return $list;
    }

    /**
     * 通过id查询出该条留言
     */
    public static function geyListById($data){

    }


}