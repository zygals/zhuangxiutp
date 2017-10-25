<?php

namespace app\back\controller;


use app\back\model\Ad;

use app\back\model\Base;
use think\Request;
use app\back\model\Group;
use app\back\model\Admin;
use app\back\model\Shop;
use app\back\model\Good;


class GroupController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {
        $data = $request->param();
//        $isShopAdmin = Admin::isShopAdmin();
        $list_ = Group::getList($data);
        $page_str = $list_->render();
        $page_str =Base::getPageStr($data,$page_str);
        $url = $request->url();
        return $this->fetch('index', ['list_' => $list_, 'page_str'=>$page_str,'url'=>$url]);
    }
    public function mobile_index(Request $request){
        $data = $request->param();
        $rule = ['position' => 'number'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            $this->error($res);
        }
        $m_ = new Ad();
        $list_ = $m_->getListMobile($data);
        $list_position = Ad::getPositions();
        $current = $request->url();
        //dump($current);exit;
        return $this->fetch('', ['list_' => $list_, 'list_position' => $list_position,'current'=>$current]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create() {

        $isShopAdmin = Admin::isShopAdmin();
        $shop = Shop::getList();
        return $this->fetch('', ['title'=>'添加团购活动','isShopAdmin'=>$isShopAdmin,'shop'=>$shop,'act'=>'save',]);

    }

    public function ajax(Request $request){
        $shop_id = $request->param();
        $id = $shop_id['shop_id'];
        $good = new Good;
        $res = $good->where('shop_id',$id)->select();
        return $res;
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
        $data = $request->param();
        dump($data);exit;
        $data['end_time']=strtotime($data['end_time']);
//        $res = $this->validate($data, 'AdValidate');
//        if ($res !== true) {
//            $this->error($res);
//        }
        if($data['type']==1){
            $data['store'] = 0;
        }else{
            $data['pnum'] = 0;
            $data['deposit'] = 0;
        }

        $group = new Group();
        $group->save($data);
        $this->success('添加成功', 'index', '', 1);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit(Request $request) {
        $data = $request->param();
        $referer=$request->header()['referer'];
        $row_ = Group::findById($data['id']);
//        dump($row_);exit;
        return $this->fetch('',['row_'=>$row_,'referer'=>$referer,'title'=>'修改团购活动信息 ','act'=>'update']);
    }


    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request) {
//        dump($request->param());exit;
        $data = $request->param();
        $data['end_time']=strtotime($data['end_time']);
        if($data['type']==1){
            $data['store'] = 0;
        }else{
            $data['pnum'] = 0;
            $data['deposit'] = 0;
        }
        $referer = $data['referer'];unset($data['referer']);
        $res = $this->validate($data, 'AdValidate');
        if ($res !== true) {
            $this->error($res);
        }

        $row_ = $this->findById($data['id'],new Group());

        if($this->saveById($data['id'],new Group(),$data)){

            $this->success('编辑成功', $referer, '', 1);
        }else{
            $this->error('没有修改', $referer, '', 1);
        }
    }


    /**
     * soft-delete 指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete(Request $request) {
        $data = $request->param();

        if( $this->deleteStatusById($data['id'],new Ad())){
            $this->success('删除成功', $data['url'], '', 1);
        }else{
            $this->error('删除失败', $data['url'], '', 3);
        }
    }

    /*
     * 下架商品
     * */
    public function down(Request $request) {
        $data = $request->param();
        //   dump($data);exit;
        //下架条件：
        $allow_ = true;
        if (OrderGood::getGoodOn($data['id'])) {
            $allow_ = false;
        }
        if ($allow_ == false) {
            $this->error('商品被加入订单，不能下架', $data['url']);
        }
        //可以下架
        $row_ = $this->findById($data['id'], new Good());
        $row_->st = 2;
        $row_->save();
        $this->success('下架成功', $data['url'], '', 1);
    }



}
