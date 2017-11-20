<?php

namespace app\api\controller;

use app\api\model\Collect;
use app\api\model\Good;
use app\api\model\GoodAttr;
use app\api\model\GoodImgBigs;
use app\api\model\TuanGou;
use think\Request;
use app\api\model\Cate;

class GoodController extends BaseController {

   /* public function index(Request $request) {
        $data = $request->param();
        $rule = ['type' => 'require|number|in:1,2', 'cate_id' => 'require|number','school_id'=>'number'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        if(!isset($data['school_id'])){
            $data['school_id'] = 0 ;
        }
        if(empty($data['title'])){
            $data['title']='';
        }
        return json(['code' => 0, 'msg' => 'good/index', 'data' => Good::getList(['type_id' => $data['type'], 'cate_id' => $data['cate_id'],'school_id' => $data['school_id'], 'title'=>$data['title'],'paixu' => 'sort'], 'good.id,good.title,img,good.price,good.type', ['good.st' => 1])]);
    }*/

    /**
     * 店铺详情-全部宝贝页面列表
     * @return \think\response\Json
     */
    public function shop_goods(Request $request) {
        $data = $request->param();
        $rule = ['shop_id' => 'require|number'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }

        $row_ =  Good::read($data['shop_id']);
        return json(['code' => 0, 'msg' => 'good/shop_goods', 'data' =>$row_]);
    }
    public function collect(Request $request){
        $data = $request->param();
        $rule = ['good_id' => 'require|number','user_name'=>'require'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
         return json((new Collect)->addCollect($data['good_id'],$data['user_name']));
    }

    /*
     * 商品详情接口
     * */
    public function read(Request $request){
        $data = $request->param();
        $rule = ['good_id' => 'require|number','username'=>'require'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        return json(Good::findOne($data));

    }

    /**
     * 商品多图接口
     */
    public function images(Request $requset){
        $data = $requset->param();
        return json(GoodImgBigs::getImg($data['good_id']));
    }
    /**
     * 团购多图
     */
    public function getImages(Request $request){
        $data = $request->param();
        return json(TuanGou::getImg($data['t_id']));
    }


}
