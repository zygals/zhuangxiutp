<?php

namespace app\api\controller;


use app\api\model\Message;
use think\Request;

class MessageController extends BaseController
{
    /*
    *  select message from user and shop
    * */
    public function index(Request $request){
        $data = $request->get();
        $rule=[
            'username'=>'require','shop_id'=>'require'
        ];
        $res = $this->validate($data,$rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json( Message::getList($data));
    }
    /*
     * add message from user
     * */
   public function save(Request $request){
       $data = $request->post();
       $rule=[
           'username'=>'require','shop_id'=>'require','message'=>'require'
       ];
       $res = $this->validate($data,$rule);
       if ($res !== true) {
           return json(['code' => __LINE__, 'msg' => $res]);
       }
       return json((new Message)->addMessage($data));
   }

}
