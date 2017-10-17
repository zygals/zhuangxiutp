<?php

namespace app\wx\controller;

use app\common\model\Collect;
use app\common\model\Good;
use app\common\model\GoodAttr;
use think\Request;
use app\common\model\Cate;

class GoodController extends BaseController {

    public function index(Request $request) {
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
    }

    public function read(Request $request) {
        $data = $request->param();
        $rule = ['good_id' => 'require|number','user_name'=>'require'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            return json(['code' => __LINE__, 'msg' => $res]);
        }
        $row_ =  Good::read($data['good_id']);
        if(!empty($row_)){
            $list_good_attr=[];
            if($row_->is_add_attr){
                $list_good_attr = (new GoodAttr)->getGoodAttr($data['good_id']);
            }
            $row_->good_attrs = $list_good_attr;
            $row_->isFav = Collect::ifFav($data);
        }
        return json(['code' => 0, 'msg' => 'good/read', 'data' =>$row_]);
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


}
