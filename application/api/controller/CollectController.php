<?php

namespace app\api\controller;

use app\api\model\Collect;
use app\api\model\Good;
use app\api\model\GoodAttr;
use think\Request;
use app\api\model\Cate;

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
