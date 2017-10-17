<?php

namespace app\wx\controller;

use app\common\model\School;
use think\Request;
class SchoolController extends BaseController
{
   public function index(Request $request){
        $data = $request->param();
        if(empty($data['title'])){
            $data['title']='';
        }
      return json(['code'=>0,'msg'=>'school_index','data'=>School::getList(['paixu'=>'sort','title'=>$data['title']],'id,title,lishu,img,city')]);
   }
   public function read(Request $request){
       $data = $request->param();
       $rule = ['school_id' => 'require|number'];
       $res = $this->validate($data, $rule);
       if ($res !== true) {
           return json(['code' => __LINE__, 'msg' => $res]);
       }
       return json(['code' => 0, 'msg' => 'school/read', 'data' =>School::read($data['school_id'])]);
   }
   public function search(Request $request){

   }
}
