<?php

namespace app\api\controller;

use app\api\model\Collect;
use app\api\model\Good;
use app\api\model\GoodAttr;
use think\Request;
use app\api\model\Cate;

class CollectController extends BaseController {
    /**
     * 点击收藏商品
     */
    public function collect_good(Request $request){
        $data = $request->param();
        $rule = ['username' => 'require','good_id'=>'require|number'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $colGood = new Collect();
        return json($colGood->colGood($data));
    }

    /**
     * 点击收藏商家
     *
     */
    public function collect_shop(Request $request){
        $data = $request->param();
        $rule = ['username' => 'require','shop_id'=>'require|number'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $colShop = new Collect();
        return json($colShop->colShop($data));
    }

    /**
     * 商品收藏列表
     * @return \think\response\Json
     */
    public function good(Request $request){
        $data = $request->param();
        $rule = ['username' => 'require'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json(Collect::getList($data));
    }

    /**
     * 店铺收藏
     * @return \think\response\Json
     */
    public function shop_(Request $request) {
        $data = $request->param();
        $rule = ['username' => 'require'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }

        return json(['code' => 0, 'msg' => 'collect/shop', 'data' => Collect::getShop($data)]);
    }

//    public function delete(Request $request){
//        $data = $request->param();
//        $rule = ['user_name' => 'require','good_id'=>'require|number'];
//        $res = $this->validate($data, $rule);
//        if ($res !== true) {
//            return json(['code' => __LINE__, 'msg' => $res]);
//        }
//
//        return json(Collect::delRow($data));
//    }

    /**
     * 长按删除收藏
     *
     */
    public function delete(Request $request){
        $data = $request -> param();
        $rule = ['id'=>'require|number'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json(Collect::delRow($data));
    }

}
