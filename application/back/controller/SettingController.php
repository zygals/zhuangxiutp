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
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
        $data = $request->param();
        $file = $request->file('img');
        $file2 = $request->file('baoming_img_big');
        $file3 = $request->file('wode_baoming_img');
        $set = new Setting();
        if($set->order('create_time asc')->find()){
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
            if(!empty($file2)){
                $path_name = 'setting';
                $size = $file2->getSize();
                if ($size > config('upload_size') ) {
                    $this->error('图片大小超过限定！');
                }
                $this->deleteImg($row_->baoming_img_big);
                $arr = $this->dealImg($file2, $path_name);
                $data['baoming_img_big'] = $arr['save_url_path'];
            }
			if(!empty($file3)){//我的报名小图
                $path_name = 'setting';
                $size = $file3->getSize();
                if ($size > config('upload_size') ) {
                    $this->error('图片大小超过限定！');
                }
                $this->deleteImg($row_->wode_baoming_img);
                $arr = $this->dealImg($file3, $path_name);
                $data['wode_baoming_img'] = $arr['save_url_path'];
            }
            if($this->saveById(1,new Setting(),$data)){
                $this->success('编辑成功', 'index', 1);
            }else{
                $this->error('没有修改', 'index', 1);
            }
        }else{
            if (!empty($file)) {
               // $this->error('请上传图片或检查图片大小！');
                $size = $file->getSize();
                if ($size > config('upload_size')) {
                    $this->error('图片大小超过限定！');
                }
                $path_name = 'setting';

                $arr = $this->dealImg($file, $path_name);

                $data['img'] = $arr['save_url_path'];
            }
            if(!empty($file2)){
                $path_name = 'setting';
                $size = $file2->getSize();
                if ($size > config('upload_size') ) {
                    $this->error('图片大小超过限定！');
                }
                $arr = $this->dealImg($file2, $path_name);
                $data['baoming_img_big'] = $arr['save_url_path'];
            }


            $Ad = new Setting();
            $Ad->save($data);
            $this->success('添加成功', 'index', '', 1);
        }


    }







}
