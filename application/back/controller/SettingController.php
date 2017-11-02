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
    public function index() {
        $list = Setting::getSet();
        return $this->fetch('edit',['list'=>$list,'act'=>'save']);
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
        $data = $request->param();
        $file = $request->file('img');
        $set = new Setting();
        if($set->where('id',1)->find()){
            $row_ = $this->findById(1,new Setting());
            if(!empty($file)){
                $path_name = 'setting';
                $size = $file->getSize();
                if ($size > config('upload_size') ) {
                    $this->error('图片大小超过限定！');
                }
                $this->deleteImg($row_->img);
                $arr = $this->dealImg($file, $path_name);
                $data['img'] = $arr['save_url_path'];
            }
            if($this->saveById(1,new Setting(),$data)){
                $this->success('编辑成功', 'index', 1);
            }else{
                $this->error('没有修改', 'index', 1);
            }
        }else{
            if (empty($file)) {
                $this->error('请上传图片或检查图片大小！');
            }
            $size = $file->getSize();
            if ($size > config('upload_size')) {
                $this->error('图片大小超过限定！');
            }
            $path_name = 'setting';

            $arr = $this->dealImg($file, $path_name);

            $data['img'] = $arr['save_url_path'];

            $Ad = new Setting();
            $Ad->save($data);
            $this->success('添加成功', 'index', '', 1);
        }


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
