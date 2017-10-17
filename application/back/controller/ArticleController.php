<?php

namespace app\back\controller;

use app\back\model\Article;
use app\back\model\Base;
use app\back\model\CateArticle;
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
        $list_ = Article::getList($data);
        $list_cate_article = CateArticle::getListAll();
        $list_school= School::getListAll();
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data,$page_str);
        $url = $request->url();
        return $this->fetch('index', ['list_' => $list_,'list_school'=>$list_school,'list_cate_article'=>$list_cate_article,'url'=>$url,'page_str'=>$page_str]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create() {
        $list_cate_article = CateArticle::getListAll();
        $list_school= School::getListAll();
        return $this->fetch('',['title'=>'添加资讯','act'=>'save','list_school'=>$list_school,'list_cate_article'=>$list_cate_article]);

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
       // dump($request->param());exit;
        $data = $request->param();
        $res = $this->validate($data,"ArticleValidate");
        if ($res !== true) {
            $this->error($res);
        }
        $Article = new Article();
        $Article->save($data);
        $this->success('添加成功', 'index', '', 1);
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
        $list_cate_article = CateArticle::getListAll();
        $list_school= School::getListAll();
        $referer = $request->header()['referer'];
        return $this->fetch('',['act'=>'update','title'=>'修改资讯 '.$row_->title,'row_'=>$row_,'referer'=>$referer,'list_school'=>$list_school,'list_cate_article'=>$list_cate_article]);
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
       // dump($data);exit;
        $referer = $data['referer'];unset($data['referer']);
        $res = $this->validate($data,'ArticleValidate');
        if ($res !== true) {
            $this->error($res);
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
