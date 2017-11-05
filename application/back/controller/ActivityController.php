<?php

namespace app\back\controller;


use app\back\model\Activity;

use app\back\model\ActivityAttend;
use app\back\model\Base;
use think\Request;


class ActivityController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {
        $data = $request->param();

        $list_ = Activity::getList($data);
        $page_str = $list_->render();
        $page_str =Base::getPageStr($data,$page_str);
        $url = $request->url();
        return $this->fetch('index', ['list_' => $list_, 'page_str'=>$page_str,'url'=>$url]);
    }

    /**
     *  查看报名
     * zhuangxiu-zyg
     *
     * @return \think\Response
     */
    public function index_attend(Request $request) {

        $data = $request->param();
        $rule = ['activity_id'=>'require'];
        $res = $this->validate($data, $rule);
       if ($res !== true) {
           $this->error($res);
       }
        $list_ = ActivityAttend::getList($data);
       if($list_->isEmpty()){
           $this->error('暂无数据','','',1);
       }
        $page_str = $list_->render();
        $page_str =Base::getPageStr($data,$page_str);
        $url = $request->url();
        return $this->fetch('index_attend', ['list_' => $list_, 'page_str'=>$page_str,'url'=>$url]);
    }


    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create() {


        return $this->fetch('', ['title'=>'添加活动','act'=>'save']);

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
        $data = $request->param();

       /* $res = $this->validate($data, 'ActivityValidate');
        if ($res !== true) {
            $this->error($res);
        }*/
        $file = $request->file('img');
        $file2 = $request->file('img_big');

        if (empty($file)) {
            //$this->error('请上传图片或检查图片大小！');
        }
        if(!empty($file)){
            $size = $file->getSize();
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }
            $path_name = 'activity';

            $arr = $this->dealImg($file, $path_name);

            $data['img'] = $arr['save_url_path'];
        }
        if(!empty($file2)){
            $size = $file2->getSize();
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }
            $path_name = 'activity';

            $arr = $this->dealImg($file2, $path_name);

            $data['img_big'] = $arr['save_url_path'];
        }
         $data['start_time'] = strtotime( $data['start_time']);
         $data['end_time'] = strtotime( $data['end_time']);

        $Activity = new Activity();
        $Activity->save($data);
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
        $row_ = $this->findById($data['id'],new Activity());
        return $this->fetch('',['row_'=>$row_,'referer'=>$referer,'title'=>'修改活动 '.$row_->name,'act'=>'update']);
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
        /*$res = $this->validate($data, 'ActivityValidate');
        if ($res !== true) {
            $this->error($res);
        }*/
        $file = $request->file('img');
        $file2 = $request->file('img_big');
        $row_ = $this->findById($data['id'],new Activity());
        if(!empty($file)){
            $path_name = 'activity';
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
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }
            $path_name = 'activity';
            $this->deleteImg($row_->img_big);
            $arr = $this->dealImg($file2, $path_name);
            $data['img_big'] = $arr['save_url_path'];
        }
        $data['start_time'] = strtotime( $data['start_time']);
        $data['end_time'] = strtotime( $data['end_time']);
        if($this->saveById($data['id'],new Activity(),$data)){
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

        if( $this->deleteStatusById($data['id'],new Activity())){
            $this->success('删除成功', $data['url'], '', 1);
        }else{
            $this->error('删除失败', $data['url'], '', 3);
        }
    }



}
