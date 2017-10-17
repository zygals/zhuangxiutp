<?php

namespace app\back\controller;


use app\back\model\Base;
use app\back\model\Good;
use app\back\model\GoodAttr;
use app\back\model\Cate;

use app\back\model\Shop;
use think\Request;


class GoodController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {
        $data = $request->param();
       $rule = ['cate_id' => 'number','type_id'=>'number|in:1,2','index_show'=>'number|in:1','sort_type'=>'desc'];
        $res = $this->validate($data, $rule);
        if ($res !== true) {
            $this->error($res);
        }
        $list_cate = [];
        if(!empty($data['type_id'])){
            $list_cate = Cate::getAllCateByType($data['type_id']);
        }
        $list_ = Good::getList($data);
        $page_str = $list_->render();

        $page_str = Base::getPageStr($data,$page_str);
        $url = $request->url();


        $list_shop= Shop::getListAll();
        return $this->fetch('index', ['list_' => $list_,'list_shop'=>$list_shop,'list_cate'=>$list_cate,'url'=>$url,'page_str'=>$page_str]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create(Request $request) {
        $data = $request->param();
        $list_shop= Shop::getListAll();
        $list_cate= Cate::getList(['type'=>1]);
        return $this->fetch('', ['list_cate' => $list_cate,'list_shop' => $list_shop,'title'=>'添加资料','act'=>'save']);

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
        $data = $request->param();

        $res = $this->validate($data, 'GoodValidate');
        if ($res !== true) {
            $this->error($res);
        }
        $file = $request->file('img');
        $file2 = $request->file('img_big');

        if (empty($file) || empty($file2)) {
            $this->error('请上传图片或检查图片大小！');
        }

        $size = $file->getSize();
        $size2 = $file2->getSize();
        if ($size > config('upload_size') || $size2 > config('upload_size')) {
            $this->error('图片大小超过限定！');
        }

        $path_name = 'good';
        $arr = $this->dealImg($file, $path_name);
        $arr2 = $this->dealImg($file2, $path_name);
        $data['img'] = $arr['save_url_path'];
        $data['img_big'] = $arr2['save_url_path'];
        $Good = new Good();
        $Good->save($data);
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
        $row_ = $this->findById($data['id'],new Good());
       // dump($row_->type);exit;
        $referer = $request->header()['referer'];
        $list_cate = Cate::getAllCateByType(Cate::getTypeIdAttr($row_->type));
        $list_shop= Shop::getListAll();
        $list_good_attr=[];
        if($row_->is_add_attr){
            $list_good_attr = (new GoodAttr)->getGoodAttr($data['id']);
        }
        $row_->good_attrs = $list_good_attr;
        //dump($row_);
        return $this->fetch('',['row_'=>$row_,'title'=>'修改资料'.$row_->title,'act'=>'update','referer'=>$referer,'list_cate'=>$list_cate,'list_shop'=>$list_shop]);
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
        $res = $this->validate($data, 'GoodValidate');
        if ($res !== true) {
            $this->error($res);
        }
        $row_ = $this->findById($data['id'],new Good());

        $file = $request->file('img');
        $file2 = $request->file('img_big');

        if(!empty($file)){
            $path_name = 'good';
            $size = $file->getSize();
            if ($size > config('upload_size') ) {
                $this->error('图片大小超过限定！');
            }
            $this->deleteImg($row_->img);
            $arr = $this->dealImg($file, $path_name);
            $data['img'] = $arr['save_url_path'];
        }
        if(!empty($file2)){
            $path_name = 'good';
            $size = $file2->getSize();
            if ($size > config('upload_size') ) {
                $this->error('图片大小超过限定！');
            }
            $this->deleteImg($row_->img_big);
            $arr = $this->dealImg($file2, $path_name);
            $data['img_big'] = $arr['save_url_path'];
        }
        if($this->saveById($data['id'],new Good(),$data)){

            $this->success('编辑成功', $referer, '', 1);
        }else{
            $this->error('编辑失败', $referer, '', 1);
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

        if( $this->deleteStatusById($data['id'],new Good())){
            $this->success('删除成功', $data['url'], '', 1);
        }else{
            $this->error('删除失败', $data['url'], '', 3);
        }
    }


}
