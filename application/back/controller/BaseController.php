<?php
namespace app\back\controller;

use app\back\model\Admin;
use app\back\model\MenuAdmin;
use think\Controller;
use think\Request;

class BaseController extends Controller {

    public function __construct() {

        parent::__construct();
        $request = Request::instance();
        $current_request = strtolower($request->controller() . "/" . $request->action());

        $not_logins = array(
            'admin/login',
            'admin/sigin',
            'admin/logout',
            'admin/captcha'
        );
        //echo $current_request;exit;
        if (!(session('admin_zhx') || in_array($current_request, $not_logins))) {
            $this->redirect("admin/login");
        }

        //商户权限
        if (!empty(session('admin_zhx')) && Admin::isShopAdmin()) {
            $allow_act = false;
            $list_menu = MenuAdmin::getList();
            foreach ($list_menu as $row_) {
                foreach ($row_['childs'] as $row_child) {
                    if (strtolower($row_child->controller) == strtolower($request->controller()) || $current_request == 'index/index' || $current_request == 'admin/edit_' || $current_request == 'admin/update_' || $current_request == 'admin/logout') {

                        $allow_act = true;
                    }
                }
            }

            if ($allow_act == false) {
                $this->error('没有权限');
            }
        }

        if(!empty(session('admin_zhx')) && Admin::isGeneral()){
            $my_power = MenuAdmin::getListNormal();
            $is_have_power = false;
            foreach ($my_power as $power){
                $power_str = strtolower($power->controller).'/'.$power->action;

                if($power_str==$current_request || strtolower($power->controller)==strtolower($request->controller()) || $current_request=='admin/sigin' || $current_request=='admin/login' ||$current_request=='index/index'|| $current_request=='admin/logout'){
                    $is_have_power=true;
                    break;
                }
            }
            if($is_have_power==false){
                $this->error('您没有此权限');
            }
        }

    }


    public function findById($id, $model) {
        if (empty($id) || !is_numeric($id)) {
            $this->error('id参数有误');
        }
        $row = $model->find($id);
        if (!$row) {
            $this->error('对象不存在');
        }
        return $row;
    }

    public function deleteById($id, $model) {
        if (empty($id) || !is_numeric($id)) {
            $this->error('id参数有误');
        }
        $row = $model->find($id);
        if (!$row) {
            $this->error('对象不存在');
        }
        if ($row->delete()) {
            return true;
        }
        return false;
    }

    protected function deleteStatusById($id, $model) {
        if (empty($id) || !is_numeric($id)) {
            $this->error('id参数有误');
        }
        $row = $model->find($id);
        if (!$row) {
            $this->error('对象不存在');
        }
        $row->st = 0;
        if ($row->save()) {
            return $row;
        }
        return false;
    }

    protected function saveById($id, $model, $data) {
        if (empty($id) || !is_numeric($id)) {
            $this->error('id参数有误');
        }
        $row = $model->find($id);
        if (!$row) {
            $this->error('对象不存在');
        }
        if ($row->save($data)) {
            return true;
        }
        return false;
    }

    protected function dealImg($file, $type) {
        $upload_dir = ROOT_PATH . 'public/upload/' . $type . '/';
        $info = $file->move($upload_dir);
        if ($info) {
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            $url_path = "/upload/$type/" . $info->getSaveName();
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }

        return ['save_url_path' => $url_path, $info, 'info' => $info];
    }

    //对图片处理
    protected function thumbImg($type, $imgInfo, $width, $height) {
        $open_img = ROOT_PATH . 'public' . $imgInfo['save_url_path'];
        //  dump($path);exit;
        $deliter = explode('.', $imgInfo['save_url_path']);
        $save_thumb_img = ROOT_PATH . 'public' . $deliter[0] . '_mobile.' . $deliter[1];

        $image = \think\Image::open($open_img);
        //  $image->crop($width,$height)->save($save_thumb_img);
        $image->thumb($width, $height, \think\Image::THUMB_CENTER)->save($save_thumb_img);
        $save_thumb_img_url = '/upload/' . $type . '/' . explode('.', $imgInfo['info']->getSaveName())[0] . '_mobile.' . $deliter[1];
        return ['img_mobile' => $save_thumb_img_url];
    }

    public function deleteImg($path) {
        $file = ROOT_PATH . 'public/' . $path;
        if (is_file($file)) {
            unlink($file);
        }

    }

}