<?php

namespace app\wx\controller;

use app\common\model\Collect;
use app\common\model\Good;
use app\common\model\GoodAttr;
use think\Request;
use app\common\model\Cate;

class CollectController extends BaseController {

    public function index(Request $request) {
        $data = $request->param();
        $rule = ['user_name' => 'require'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }

        return json(['code' => 0, 'msg' => 'collect/index', 'data' => Collect::getList($data)]);
    }

    public function delete(Request $request){
        $data = $request->param();
        $rule = ['user_name' => 'require','good_id'=>'require|number'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }

        return json(Collect::delRow($data));
    }

}
