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
        return json(Ad::getList());

   }







}
