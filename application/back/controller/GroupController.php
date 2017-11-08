<?php

namespace app\back\controller;


use app\api\model\Dingdan;
use app\back\model\Ad;

use app\back\model\Base;
use app\back\model\Tuangou;
use think\Request;
use app\back\model\Admin;
use app\back\model\Shop;
use app\back\model\Good;
use app\back\model\Article;


class GroupController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */

    public function index(Request $request) {
//        dump(1);exit;
        $data = $request->param();
//        dump($data);exit;
//        $isShopAdmin = Admin::isShopAdmin();
        $list_ = Tuangou::getList($data);

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
        $shop = Shop::getShopList();
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
//        dump($data);exit;
//        dump($data);exit;
      //  $data['end_time']=strtotime($data['end_time']);
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
//        dump($data);exit;
        $Tuangou = new Tuangou();
        $Tuangou->save($data);
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
        $row_ = Tuangou::findById($data['id']);
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
       // $data['end_time']=strtotime($data['end_time']);
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

        $row_ = $this->findById($data['id'],new Tuangou());

        if($this->saveById($data['id'],new Tuangou(),$data)){

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

        if( $this->deleteStatusById($data['id'],new Tuangou())){
            $this->success('删除成功', $data['url'], '', 1);
        }else{
            $this->error('删除失败', $data['url'], '', 3);
        }
    }

    /*
     * 下架团购活动
     * */
    public function down(Request $request) {
        $data = $request->param();
        //下架条件：
        $allow_ = true;
        $res = Dingdan::where(['group_id'=>$data['id'],'goodst'=>['in','1,2,5']])->select();
        if(count($res)>0){
            $allow_ = false;
        }
        if ($allow_ == false) {
            $this->error('此团购活动有未完成的订单，不能下架','index');
        }
        //可以下架
        $row_ = $this->findById($data['id'],new Tuangou());
        $row_->st = 2;
        $row_->save();
        $this->success('下架成功','index', '', 1);
    }

    /**
     * 删除下架的团购活动
     */


    /**
     * @param Request $request
     * 团购活动添加总结
     */
    public function add(Request $request){
        $data = $request->param();
        $tuangou_id = $data['id'];
        return $this->fetch( '' , [ 'title' => '添加团购总结' , 'act' => 'saveArticle','tuangou_id'=>$tuangou_id] );
    }

    /**
     * 处理团购活动添加的总结
     */
    public function saveArticle(Request $request){
        $data = $request->param();
        $file = $request->file('img');

        if (empty($file)) {
            $this->error('请上传图片或检查图片大小！');
        }
        $size = $file->getSize();
        if ($size > config('upload_size')) {
            $this->error('图片大小超过限定！');
        }
        $path_name = 'article';
        $arr = $this->dealImg($file, $path_name);

        $data['img'] = $arr['save_url_path'];
        $data['type'] = 3;//团购的文章
        $Ad = new Article();
        $Ad->save($data);
        $this->saveById($data['tuangou_id'],new Tuangou(),['article_st'=>1]);

        $this->success('添加成功', 'index', '', 1);
    }

    /**
     * 修改团购总结
     */
    public function edit_article(Request $request){
        $data = $request->param();
        $row_article = Article::where(['tuangou_id'=>$data['id']])->find();
        if(!$row_article){
            $this->error('总结不存在');
        }
        $referer = $request->header()['referer'];
        return $this->fetch('',['row_article'=>$row_article,'title'=>'修改团购总结','act'=>'update_article','referer'=>$referer]);
    }

    /**
     * 处理修改团购总结
     */
    public function update_article(Request $request){
        $data = $request->param();
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
        $referer = $data['referer'];unset( $data['referer'] );
        if ( $this->saveById( $data['id'] , new Article() , $data ) ) {

            $this->success( '编辑成功' , $referer , '' , 1 );
        } else {
            $this->error( '没有修改' , $referer , '' , 1 );
        }
    }





}
