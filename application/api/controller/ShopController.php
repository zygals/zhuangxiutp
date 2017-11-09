<?php

namespace app\api\controller;

use app\api\model\Shop;
use app\api\model\ShopAddress;
use app\api\model\TuanGou;
use think\Request;
class ShopController extends BaseController
{
    /*
     * 商家列表：可以根据分类查询，根据销量等排序
     * */
   public function index(Request $request){

       $data = $request->param();
       $rule = ['cate_id' => 'number'];
       $res = $this->validate($data, $rule);
       if ($res !== true) {
           return json(['code' => __LINE__, 'msg' => $res]);
       }
       return json(Shop::getList($data));

   }

    /**
     * 商家详情:获取商家的详细信息
     * @return \think\response\Json
     *
     */
   public function read(Request $request){
       $data = $request->param();
       $rule = ['shop_id' => 'require|number','username'=>'require'];
       $res = $this->validate($data, $rule);
       if ($res !== true) {
           return json(['code' => __LINE__, 'msg' => $res]);
       }
       return json(Shop::read($data));
   }

    /**
     * 店铺详情-查询门店地址列表
     * @return \think\response\Json
     */
   public function addr(Request $request){
       $data = $request->param();
       $rule = ['shop_id' => 'require|number'];
       $res = $this->validate($data, $rule);
       if ($res !== true) {
           return json(['code' => __LINE__, 'msg' => $res]);
       }

       return json(['code' => 0, 'msg' => 'shop/addr', 'data' =>ShopAddress::getAddressByShop($data['shop_id'])]);
   }

    /**
     * 是否参加团购
     */
    public function isGroup(Request $request){
        $data = $request->param();
        return json(TuanGou::isAttend($data['shop_id']));
    }
}
