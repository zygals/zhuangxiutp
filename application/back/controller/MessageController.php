<?php

namespace app\back\controller;
use app\back\model\Message;
use think\Request;
use app\back\model\Base;

class MessageController extends BaseController{
    /**
     * 展示留言主页
     * @param Request $request
     */
    public function index(Request $request){
        $data = $request->param();
        $list_ = Message::getList($data);
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data, $page_str);
        $url = $request->url();
        return $this->fetch('index', ['list_' => $list_,'title'=>'查看留言','page_str' => $page_str,'url'=>$url]);
    }

    /**
     * 查看留言(更改留言状态为已查看)
     */
    public function edit(Request $request){
        $data = $request->param();
        $list = Message::getListById($data);
        if($list->isEmpty()){
            $this->error('暂无数据');
        }
        $page_str = $list->render();
        $page_str = Base::getPageStr($data,$page_str);
        $url = $request->url();
//        dump($list);exit;
        return $this->fetch('info',['list_'=>$list,'page_str' => $page_str,'title'=>'留言列表','url'=>$url]);
    }
/*
 * 管理员回复
 * */
    public function save(Request $request){
        $data=$request->post();
        $data['type']=2;
         $back = $data['url'];unset ($data['url']);
        (new Message())->save($data);
        $this->success('成功',$back,'',1);
    }

    /**
     * 删除留言
     */
    public function delete(Request $request){
        $data = $request->param();
        if ($this->deleteStatusById($data['id'], new Message())) {
            return json(['code'=>0]);
        } else {
            return json(['code'=>1,'msg'=>'删除失败']);
        }
    }
}
