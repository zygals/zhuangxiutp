<?php

namespace app\back\controller;

use app\back\model\Admin;
use app\back\model\Article;
use app\back\model\Base;
use app\back\model\Good;
use app\back\model\Shop;

use app\back\model\Cate;

use think\Request;


class ShopController extends BaseController {
    /**
     * 显示资源列表
     *.
     * 0
     * @return \think\Response
     */
    public function index(Request $request) {
        $data = $request->param();
        $list_ = Shop::getList($data);
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data,$page_str);
        $url = $request->url();
        $list_cate = Cate::getList(['type_id'=>1]);
        return $this->fetch('index', ['list_' => $list_,'url'=>$url,'list_cate'=>$list_cate,'page_str'=>$page_str]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create() {
        $list_cate = Cate::getList(['type_id'=>1]);
        return $this->fetch('', ['title'=>'添加商户','act'=>'save','list_cate'=>$list_cate]);

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {

        $data = $request->param();
        //dump($data);exit;
        $res = $this->validate($data, 'ShopValidate');
        if ($res !== true) {
            $this->error($res);
        }
        $file = $request->file('img');
        $file2 = $request->file('logo');

        if (empty($file) || empty($file2)) {
            $this->error('请上传图片或检查图片大小！');
        }
        $size = $file->getSize();
        $size2 = $file2->getSize();
        if ($size > config('upload_size') || $size2 > config('upload_size')) {
            $this->error('图片大小超过限定！');
        }

        $path_name = 'shop';
        $arr = $this->dealImg($file, $path_name);
        $arr2 = $this->dealImg($file2, $path_name);
        $data['img'] = $arr['save_url_path'];
        $data['logo'] = $arr2['save_url_path'];
        if(!empty($data['cate_ids'])){
            $data['cate_ids'] = implode(',',$data['cate_ids']);
        }

        $shop = new Shop();
        $shop->save($data);
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
        $row_ = $this->findById($data['id'],new Shop());
       // dump($row_->type);exit;
        $referer = $request->header()['referer'];
        $list_cate = Cate::getList(['type_id'=>1]);
        return $this->fetch('',['row_'=>$row_,'list_cate'=>$list_cate,'title'=>'修改商户'.$row_->name,'act'=>'update','referer'=>$referer]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request) {
        //dump($request->param());exit;
        $data = $request->param();
        $referer = $data['referer'];unset($data['referer']);
        $res = $this->validate($data, 'ShopValidate');
        if ($res !== true) {
            $this->error($res);
        }
        $row_ = $this->findById($data['id'],new Shop());

        $file = $request->file('img');
        $file2 = $request->file('logo');
        $path_name = 'shop';
        if(!empty($file)){
            $size = $file->getSize();
            if ($size > config('upload_size') ) {
                $this->error('图片大小超过限定！');
            }
            $this->deleteImg($row_->img);
            $arr = $this->dealImg($file, $path_name);
            $data['img'] = $arr['save_url_path'];
        }
        if(!empty($file2)){
            $size = $file2->getSize();
            if ($size > config('upload_size') ) {
                $this->error('图片大小超过限定！');
            }
            $this->deleteImg($row_->logo);
            $arr = $this->dealImg($file2, $path_name);
            $data['logo'] = $arr['save_url_path'];
        }
        if($this->saveById($data['id'],new Shop(),$data)){

            $this->success('编辑成功', $referer, '', 1);
        }else{
            $this->error('没有修改内容', $referer, '', 1);
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
        $list_good = Good::getListByshopId($data['id']);
        if($list_good){
            $this->error('商户下有商品，不允许删除');
        }

        if( $ret = $this->deleteStatusById($data['id'],new Shop())){
            //同时删除管理员
            $this->deleteStatusById($ret->admin_id,new Admin());
            $this->success('删除成功', $data['url'], '', 1);
        }else{
            $this->error('删除失败', $data['url'], '', 3);
        }
    }


}
