<?php

namespace app\back\controller;

use app\back\model\Base;
use think\Request;

class WithdrowController extends BaseController{

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request){

        $data = $request->param();
        return $this->fetch('index');

    }

}