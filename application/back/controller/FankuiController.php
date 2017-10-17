<?php

namespace app\back\controller;

use app\back\model\Address;
use app\back\model\Base;
use app\back\model\Dingdan;
use app\back\model\Cate;

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

        $data = $request->param();
        $rules = ['time_from' => 'date', 'time_to' => 'date'];
        $msg = ['time_from' => '日期格式有误', 'time_to' => '日期格式有误'];
        $res = $this->validate($request->get(), $rules, $msg);
        if ($res !== true) {
            $this->error($res);
        }

        $list_ = Dingdan::getAlldingdans($data);
        $page_str = $list_->render();
        $page_str = Base::getPageStr($data, $page_str);
        $url = $request->url();
        return $this->fetch('index', ['list_' => $list_,'page_str'=>$page_str,'url'=>$url]);

    }



    /**
     * 显示订单详情
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read(Request $request) {
//      return 23;
        $data = $request->param();
        $row_order = $this->findById($data['id'], new Dingdan());
        $row_user = $this->findById($row_order->user_id,new User());
        $row_address = $this->findById($row_order->address_id,new Address());
        $list_good =  OrderGood::getGood($row_order->id);
       // dump($row_good);exit;
        return $this->fetch('', ['row_order' => $row_order,'row_user'=>$row_user,'row_address'=>$row_address, 'list_good'=>$list_good,'title'=>'订单详情 '.$row_order->orderno]);
    }
    //改发货状态
    public  function edit(Request $request){
        $data = $request->param();
        $referer = $request->header()['referer'];
        $row_ = $this->findById($data['id'], new Dingdan());
        return $this->fetch('',['row_'=>$row_,'act'=>'update','title'=>'改 '.$row_->orderno.' 发货状态','referer'=>$referer]);
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
        $referer = $data['referer'];unset($data['referer']);
        $res = $this->validate($data, 'DingdanValidate');
        if ($res !== true) {
            $this->error($res);
        }

        if($this->saveById($data['id'],new Dingdan(),$data)){
            if($data['good_st']==2){

                Good::updateStore($data['id']);
            }
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
        if ($this->deleteStatusById($data['id'], new Dingdan())) {
            $this->success('删除成功',  $data['url'], '', 1);
        } else {
            $this->error('删除失败',  $data['url'], '', 3);
        }
    }


}
