<?php

namespace app\wx\controller;

use app\common\model\Ad;
use app\common\model\Good;
use think\Request;
use app\common\model\Cate;
class CateController extends BaseController
{

   public function index(Request $request){
      $data = $request->param();
      $rule = ['type'=>'require|number|in:1,2'];
      $res = $this->validate($data,$rule);
      if($res !==true){
          return json(['code'=>__LINE__,'msg'=>$res]);
      }
      return json(['code'=>0,'msg'=>'cate/index','data'=>Cate::getList(['type_id'=>$data['type'],'paixu'=>'sort'],'*',['st'=>1])]);
   }
   public function read(Request $request){

   }
   

}
