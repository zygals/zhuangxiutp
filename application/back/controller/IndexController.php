<?php

namespace app\back\controller;

use think\Cache;
use think\Request;
use app\back\model\User;
use app\back\model\AdminLog;
class IndexController extends BaseController
{
   public function index(Request $request){
        $list_ = AdminLog::getLogs();
        return $this->fetch('index',['list_'=>$list_]);
   }
   /*
    * 清理前台缓存
    * */
   public function clear_cache(Request $request){
       Cache::clear();
       $back='index/index';
       if(!empty($request->header()['referer'])){
           $back=$request->header()['referer'];
       }
       $this->success('缓存清理成功',$back,'',1);

   }

}
