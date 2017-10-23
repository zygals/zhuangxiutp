<?php

namespace app\api\controller;

use app\api\model\CateArticle;
use app\api\model\Good;
use think\Request;
use app\api\model\Cate;
class CateArticleController extends BaseController
{

   public function index(Request $request){
      $data = $request->param();
      //$rule = ['type'=>'require|number|in:1,2'];
//      $res = $this->validate($data,$rule);
//      if($res !==true){
//          return json(['code'=>__LINE__,'msg'=>$res]);
//      }
      return json(['code'=>0,'msg'=>'CateArticle/index','data'=>CateArticle::getList(['paixu'=>'sort'],['st'=>1])]);
   }
   public function read(Request $request){

   }
   

}
