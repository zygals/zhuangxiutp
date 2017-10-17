<?php

namespace app\back\controller;

use app\back\model\Cate;
use think\Request;


class AjaxController extends BaseController {

    public function index(Request $request) {
        $data = $request->param();
        $rule = ['type_id'=>'require'];
        $res = $this->validate($data,$rule);
        if($res!==true){
            return json(['code'=>__LINE__,'msg'=>$res]);
        }
        $list_cate = Cate::getAllCateByType($data['type_id']);
        return json(['code'=>0,'msg'=>'get cate ok','data'=>$list_cate]);
    }

    public function read(Request $request) {


    }
}
