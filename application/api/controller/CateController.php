<?php

namespace app\api\controller;

use app\api\model\Ad;
use app\api\model\Good;
use think\Request;
use app\api\model\Cate;

class CateController extends BaseController {

    /*
     * 行业分类列表
     * */
    public function index(Request $request) {

        return json(Cate::getList(['type_id' => Cate::TYPE_HANGYE]));

    }

    public function read(Request $request) {

    }


}
