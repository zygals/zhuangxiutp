<?php

namespace app\back\controller;

use think\Request;


class ShopConfirmController extends BaseController {
    /**
     * 显示资源列表
     *.
     * 0
     * @return \think\Response
     */
    public function index(Request $request) {
        $data = $request->param();
        $list_ = School::getList($data);
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data,$page_str);
        $url = $request->url();

        return $this->fetch('index', ['list_' => $list_,'url'=>$url,'page_str'=>$page_str]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create() {

        return $this->fetch('', ['title'=>'添加学校','act'=>'save']);

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
        $data = $request->param();
        $res = $this->validate($data, 'SchoolValidate');
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

        $path_name = 'school';
        $arr = $this->dealImg($file, $path_name);
        $arr2 = $this->dealImg($file2, $path_name);
        $data['img'] = $arr['save_url_path'];
        $data['img_big'] = $arr2['save_url_path'];
        $School = new School();
        $School->save($data);
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
        $row_ = $this->findById($data['id'],new School());
       // dump($row_->type);exit;
        $referer = $request->header()['referer'];
        return $this->fetch('',['row_'=>$row_,'title'=>'修改院校'.$row_->title,'act'=>'update','referer'=>$referer]);
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
        $res = $this->validate($data, 'SchoolValidate');
        if ($res !== true) {
            $this->error($res);
        }
        $row_ = $this->findById($data['id'],new School());

        $file = $request->file('img');
        $file2 = $request->file('img_big');
        $path_name = 'school';
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
            $this->deleteImg($row_->img_big);
            $arr = $this->dealImg($file2, $path_name);
            $data['img_big'] = $arr['save_url_path'];
        }
        if($this->saveById($data['id'],new School(),$data)){

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
        $list_article = Article::getListBySchoolId($data['id']);
        if($list_article){
            $this->error('院校下有资讯，不允许删除');
        }
        $list_good = Good::getListBySchoolId($data['id']);
        if($list_good){
            $this->error('院校下有资料，不允许删除');
        }
        if( $this->deleteStatusById($data['id'],new School())){
            $this->success('删除成功', $data['url'], '', 1);
        }else{
            $this->error('删除失败', $data['url'], '', 3);
        }
    }


}
