<?php

namespace app\api\model;
use think\Model;
class Message extends Base{

    public function addMessage($data) {
        $user_id=User::getUserIdByName($data['username']);
        if(is_array($user_id)){
            return $user_id;
        }
        $data['user_id']=$user_id;unset($data['username']);
          if(!$this->save($data)){
              return ['code'=>__LINE__,'msg'=>'添加失败'];
          }
        return ['code'=>0,'msg'=>'添加成功'];
    }
    public static function getList($data){
        $user_id=User::getUserIdByName($data['username']);

        $list_=self::where(['user_id'=>$user_id])->order('create_time asc')->paginate(10);

        if($list_->isEmpty()){
            return ['code'=>__LINE__,'msg'=>'暂无对话'];
        }
        return ['code'=>0,'msg'=>'数据成功','data'=>$list_];
    }

}