<?php

namespace app\back\controller;

use think\Request;
use app\back\model\User;
use app\back\model\AdminLog;
class IndexController extends BaseController
{
   public function index(Request $request){
        $list_ = AdminLog::getLogs();
        return $this->fetch('index',['list_'=>$list_]);
   }
}
