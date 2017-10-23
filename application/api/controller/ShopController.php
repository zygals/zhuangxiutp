<?php

namespace app\api\controller;

use app\api\model\Shop;
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
   public function read(Request $request){
       $data = $request->param();
       $rule = ['school_id' => 'require|number'];
       $res = $this->validate($data, $rule);
       if ($res !== true) {
           return json(['code' => __LINE__, 'msg' => $res]);
       }
       return json(['code' => 0, 'msg' => 'school/read', 'data' =>School::read($data['school_id'])]);
   }
   public function search(Request $request){

   }
}
