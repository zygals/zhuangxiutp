<?php

namespace app\back\controller;

use app\back\model\Setting;
use think\Request;
use think\Session;


class SettingController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {

    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create() {



    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {

    }


    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit(Request $request) {
        $row_ = (new Setting)->findSets();
        return $this->fetch('',['row_'=>$row_]);
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
        //dump($data);exit;
        if($this->saveById($data['id'],new Setting(),$data)){

            Session::delete('setting');
            $this->success('编辑成功', 'edit', '', 1);
        }else{
            $this->error('编辑失败', 'edit', '', 3);
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
        if( $this->deleteStatusById($data['id'],new Setting())){
            $this->success('删除成功', 'index?page='.$data['page'], '', 1);
        }else{
            $this->error('删除失败', 'index?page='.$data['page'], '', 3);
        }
    }


}
