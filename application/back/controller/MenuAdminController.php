<?php

namespace app\back\controller;

use think\Request;
use app\back\model\User;
use app\back\model\MenuAdmin;

class MenuAdminController extends BaseController {
    public function index() {
        $list_ = MenuAdmin::getList();
        //dump($list_);
        return $this->fetch('index', ['list_' => $list_]);
    }

    public function create() {
        $list_menu =  MenuAdmin::getListFirst();
        return $this->fetch('create',['list_menu'=>$list_menu]);
    }

    public function save(Request $request) {


        $data = $request->param();

        $m_ = new MenuAdmin();
        $m_->save($data);
        $this->redirect('index');
    }

    public function edit($id) {
        $list_menu = null;
        $row_ = $this->findById($id,new MenuAdmin());
        if($row_->pid!=0){

            $list_menu =  MenuAdmin::getListFirst();
        }
        return $this->fetch('edit',['row_'=>$row_,'list_menu'=>$list_menu]);
    }

    public function update(Request $request) {
        $data = $request->param();
        //dump($data);exit;
        $m_ = new MenuAdmin();
        $m_->save($data,$data['id']);
        $this->redirect('index');
    }

    public function delete(Request $request) {
        $id = $request->get('id');
        $row_ = $this->findById($id,new MenuAdmin());
        if($row_->pid==0){
           $child = (new MenuAdmin())->haveChild($id);
           if($child){
               $this->error('一级下面有二级，不能删除');
           }
        }
       // return 1;
        if($this->deleteById($id,new MenuAdmin())){
            $this->redirect('index');
        }else{
            $this->error('删除失败');
        }
    }
}
