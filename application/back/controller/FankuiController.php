<?php

namespace app\back\controller;

use app\back\model\Address;
use app\back\model\Base;
use app\back\model\Dingdan;
use app\back\model\Cate;

use app\back\model\Fankui;
use app\back\model\Good;
use app\back\model\OrderGood;
use app\back\model\User;
use think\Request;


class FankuiController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {
//return 123;
        $data = $request->param();
//        dump($data);exit;
        $rules = ['time_from' => 'date', 'time_to' => 'date'];
        $msg = ['time_from' => '日期格式有误', 'time_to' => '日期格式有误'];
        $res = $this->validate($request->get(), $rules, $msg);
        if ($res !== true) {
            $this->error($res);
        }
        $list_ = Fankui::getListPage($data);
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data, $page_str);
        $url = $request->url();
        return $this->fetch('index', ['list_' => $list_,'page_str'=>$page_str,'url'=>$url]);

    }



    public  function edit(Request $request){
        $data = $request->param();
        $row_= $this->findById($data['id'],new Fankui());

        $referer = $request->header()['referer'];
        return $this->fetch('',['row_'=>$row_,'title'=>'编辑评价','act'=>'update','referer'=>$referer]);
    }
    /**
     *  改发货状态
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request) {

        $data = $request->param();
       // dump($data);exit;
        $referer = $data['referer'];unset($data['referer']);


        if($this->saveById($data['id'],new Fankui(),$data)){

            $this->success('编辑成功', $referer, '', 1);
        }else{
            $this->error('没有改', $referer, '', 1);
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
        if ($this->deleteStatusById($data['id'], new Fankui())) {
            $this->success('删除成功',  $data['url'], '', 1);
        } else {
            $this->error('删除失败',  $data['url'], '', 3);
        }
    }


}
