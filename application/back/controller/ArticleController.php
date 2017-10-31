<?php

namespace app\back\controller;

use app\back\model\Article;
use app\back\model\Base;
use app\back\model\Cate;
use app\back\model\School;
use think\Request;


class ArticleController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {
        $data = $request->param();
//       dump($data);exit;
        $list_ = Article::getList($data);
        $Article_cate = Cate::getListAll();
//        dump($Article_cate);exit;
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data,$page_str);
        $url = $request->url();
        return $this->fetch('index', ['list_' => $list_,'Article_cate'=>$Article_cate,'url'=>$url,'page_str'=>$page_str]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create() {
        $list_cate_article = Cate::getListAll();
        return $this->fetch('',['title'=>'添加百科','act'=>'save','list_cate_article'=>$list_cate_article]);

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
//        dump($request->param());exit;
        $data = $request->param();
        $res = $this->validate($data,"ArticleValidate");
        if ($res !== true) {
            $this->error($res);
        }

        $file = $request->file('img');
        if(empty($file)){
            $this->error('请上传图片或检查图片大小');
        }

        $size = $file->getSize();
        if($size>config('upload_size')){
            $this->error('图片大小超出限制');
        }
        $path_name = 'article';

        $arr = $this->dealImg($file, $path_name);

        $data['img'] = $arr['save_url_path'];
        $Article = new Article();
        $Article->save($data);
        $this->success('添加成功','index','',1);

    }


    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit(Request $request) {
//        return 23;
        $data = $request->param();

        $row_ = $this->findById($data['id'],new Article());
        $list_cate_article = Cate::getListAll();
        $referer = $request->header()['referer'];
        return $this->fetch('',['act'=>'update','title'=>'修改百科 '.$row_->name,'row_'=>$row_,'referer'=>$referer,'list_cate_article'=>$list_cate_article]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request) {
        $data = $request->param();
//        dump($data);exit;
        $referer = $data['referer'];unset($data['referer']);
//        $res = $this->validate($data,'ArticleValidate');
//        if ($res !== true) {
//            $this->error($res);
//        }
        $file = $request->file('img');
        $row_ = $this->findById($data['id'],new Article());
        if(!empty($file)){
            $path_name = 'article';
            $size = $file->getSize();
            if ($size > config('upload_size') ) {
                $this->error('图片大小超过限定！');
            }
            $this->deleteImg($row_->img);
            $arr = $this->dealImg($file, $path_name);
            $data['img'] = $arr['save_url_path'];
        }
        if($this->saveById($data['id'],new Article(),$data)){

            $this->success('编辑成功', $referer, '', 1);
        }else{
            $this->error('编辑失败', $referer, '', 3);
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
        if( $this->deleteStatusById($data['id'],new Article())){
            $this->success('删除成功', $data['url'], '', 1);
        }else{
            $this->error('删除失败', $data['url'], '', 3);
        }
    }


}
