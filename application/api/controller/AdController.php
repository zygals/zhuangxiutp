<?php

namespace app\api\controller;

use app\api\model\Article;
use app\api\model\Cate;
use app\api\model\Good;

use think\Request;
use app\api\model\Ad;
class AdController extends BaseController
{
    /*
     * ad list
     * zhuangxiu-zyg
     * */

   public function index() {
        $list_ad=Ad::getList(['paixu'=>'sort'],['st'=>1]);

        return json(['code'=>0,'msg'=>'ad list from "ad/index"','data'=>$list_ad]);

   }







}
