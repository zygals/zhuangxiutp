<?php

namespace app\back\controller;

use app\back\model\Ad;
use app\back\model\AdminLog;
use app\back\model\Base;
use app\back\model\MenuAdmin;
use app\back\model\Shop;
use think\Request;
use app\back\model\Admin;
use \think\captcha\Captcha;

class AdminController extends BaseController {
    //admins list
    public function index(Request $request) {
        //not use layout.html
        $data = $request->param();
        $list_admin = Admin::getList($data);

        $page_str = $list_admin->render();
        $page_str = Base::getPageStr($data,$page_str);
        $url = $request->url();
        return $this->fetch('', ['list_admin' => $list_admin,'page_str'=>$page_str,'url'=>$url]);
    }

    //login.html
    public function login() {
        if(!empty(session('admin_zhx'))){
            $this->error('您已登录！');
        }
        return $this->fetch('');
    }

    /*
     *   login submit
     * */
    public function sigin(Request $request) {
        if(!empty(session('admin_zhx'))){
            $this->error('您已登录！');
        }
        $captcha = new Captcha();
        if (!$captcha->check($request->param('captcha'))) {
            $this->error('验证码不正确！');
        }
        $name = $request->param('name');
        $pass = $request->param('pass');

        $pwd = Admin::pwdGenerate($pass);
        //return $pwd;
        $condition = array();
        $condition['name'] = $name;
        $condition['pwd'] = $pwd;
        $admin = Admin::get($condition);

        if ($admin) {
            if ($admin->type == '商户') {
                if ($admin->st != '正常') {
                    $this->error('禁用或删联系平台！');
                }
            }
            $admin->setInc('times');
            session('admin_zhx', (object)array('name' => $admin->name, 'id' => $admin->id, 'type' => $admin->type, 'truename' => $admin->truename, 'shop_id' => $admin->shop_id,'privilege'=>$admin->privilege));
            //dump(session('admin_zhx'));exit;
            $ip = $_SERVER['REMOTE_ADDR'];
            (new AdminLog())->addLog($admin->id, $ip);
            $this->redirect("index/index");
        } else {
            $this->error('用户名或密码有误！');
        }
    }

    //captcha
    public function captcha() {
        $captcha = new Captcha(['fontSize' => 16, 'useCurve' => false, 'imageH' => 35, 'imageW' => 100, 'length' => 3, 'useNoise' => false]);
        return $captcha->entry();
    }

    public function logout() {
        session(null);
        $this->redirect('login');
    }

    /*
     * add admin from shop list
     * 添加商户管理员
     * */
    public function create(Request $request) {
        $data = $request->param();
        $rule = ['shop_id' => 'require|number'];
        $referer = $request->header()['referer'];
        $res = $this->validate($data, $rule);
        if (true !== $res) {
            $this->error($res);
        }

        $row_shop = $this->findById($data['shop_id'], new Shop());
        return $this->fetch('', ['row_shop' => $row_shop, 'referer' => $referer]);
    }

    /*
     *保存一般管理员
     * */
    public function save(Request $request) {
        $data = $request->param();
        $referer = $data['referer'];
        unset($data['referer']);
        $rule = ['shop_id' => 'require', 'truename' => 'require', 'name' => 'require', 'pass' => 'require', 'repass' => 'require|confirm:pass'];
        $msg = ['truename' => '姓名必须', 'pass' => '密码必须', 'repass' => '重复密码必须', 'name.require' => '账号必须', 'repass.confirm' => '两次密码不一致'];
        $res = $this->validate($data, $rule, $msg);
        if (true !== $res) {
            $this->error($res);
        }
        $row_admin = Admin::findByName($data['name']);
        if ($row_admin) {
            $this->error('账号已经存在！', $referer);
        }
        $row_shop = $this->findById($data['shop_id'], new Shop());
        $data['pwd'] = Admin::pwdGenerate($data['pass']);
        unset ($data['pass'], $data['repass']);

        $data['type'] = 2;// 店铺管理员（一般）

        $model_admin = new Admin();
        if (!$model_admin->save($data)) {
            $this->error('添加失败！', $referer);
        }

        $new_id = $model_admin->id;
        $row_shop->admin_id = $new_id;
        $row_shop->save();
        $this->success('添加成功', $referer, '', 1);
    }

    /*
  *   改商户管理员的密码
  * */
    public function edit_(Request $request) {
        $data = $request->param();
        $rule = ['shop_id' => 'require', 'admin_id' => 'require'];
        $referer = $request->header()['referer'];
        $res = $this->validate($data, $rule);
        if (true !== $res) {
            $this->error($res);
        }

        $row_admin = $this->findById($data['admin_id'], new Admin());
        $row_shop = $this->findById($data['shop_id'], new Shop());

        return $this->fetch('', ['row_admin' => $row_admin, 'row_shop' => $row_shop, 'referer' => $referer]);
    }

    /*
     * 改商户管理员的密码
     * */
    public function update_(Request $request) {

        $data = $request->param();
        $referer = $data['referer'];
        unset($data['referer']);
        // dump(url('logout'));exit;
        $rule = ['admin_id' => 'require|number', 'repass' => 'confirm:pass'];
        $res = $this->validate($data, $rule);
        if (true !== $res) {
            $this->error($res);
        }

        if (!empty($data['pass']) && !empty($data['repass'])) {

            $data['pwd'] = Admin::pwdGenerate($data['pass']);
        }
        $data['id'] = $data['admin_id'];
        unset ($data['pass'], $data['repass'], $data['admin_id']);

        if (!($this->saveById($data['id'], new Admin(), $data))) {
            $this->error('没有修改内容！', $referer);
        }
        if (Admin::isShopAdmin()) {
            $this->success('修改成功,请重新登录', url('logout'), '', 1);
        } else {

            $this->success('修改成功', $referer, '', 1);
        }

    }

    /*
     * update pwd of admin
     * */
    public function edit() {

        return $this->fetch('');
    }

    public function update(Request $request) {
        $data = $request->param();
        $rule = ['pass' => 'require', 'pass_new' => 'require', 'repass_new' => 'require|confirm:pass_new'];
        $msg = ['pass' => '原始密码必须', 'pass_new' => '新密码必须', 'repass_new.require' => '确认密码必须', 'repass_new.confirm' => '确认密码与新密码不一致'];
        $res = $this->validate($data, $rule, $msg);
        if (true !== $res) {
            $this->error($res);
        }
        $row_ = $this->findById(1, new Admin);
        if (Admin::pwdGenerate($data['pass']) !== $row_->pwd) {
            $this->error('原始密码有误');
        }
        $row_->pwd = Admin::pwdGenerate($data['pass_new']);
        //$data_update=['pwd'=>];
        $row_->save();
        $this->success('修改成功，请用新密码登录', 'logout');
    }

    /*
     *添加一般管理员（平台）
     * */
    public function create_() {
        $list_power = MenuAdmin::getPower();

        return $this->fetch('', ['list_power' => $list_power]);
    }
/*
 * 添加一般管理员（平台）
 * */
    public function save_(Request $request) {

        $data = $request->param();

        $rule = ['name' => 'require', 'pass' => 'require', 'repass' => 'require|confirm:pass', 'privilege' => 'require|array'];
        $msg = ['pass' => '密码必须', 'repass' => '重复密码必须', 'name.require' => '账号必须', 'repass.confirm' => '两次密码不一致'];
        $res = $this->validate($data, $rule, $msg);
        if (true !== $res) {
            $this->error($res);
        }
        $data['pwd'] = Admin::pwdGenerate($data['pass']);
        unset ($data['pass'], $data['repass']);
        $data['privilege'] = implode(',', $data['privilege']);
        $data['type'] = 3; //ping tai

        if (!(new Admin())->save($data)) {
            $this->error('添加失败！');
        }
        $this->success('添加成功', 'index', '', 1);
    }
    //修改一般管理员信息：姓名，权限，密码。
    public function edit_general(Request $request) {
        $data = $request->param();
        $row_admin = $this->findById($data['admin_id'], new Admin());
        $row_admin->privilege = explode(',', $row_admin->privilege);
        $list_power = MenuAdmin::getPower();

        $referer = $request->header()['referer'];
        return $this->fetch('', ['row_admin' => $row_admin, 'list_power' => $list_power,'referer'=>$referer]);
    }

    public function update_general(Request $request) {
        $data = $request->param();
        $rule = ['name' => 'require', 'repass' => 'confirm:pass', 'privilege' => 'require|array'];
        $msg = ['name.require' => '账号必须', 'repass.confirm' => '两次密码不一致', 'privilege.require' => '权限必须'];
        $res = $this->validate($data, $rule, $msg);
        if (true !== $res) {
            $this->error($res);
        }
//        dump($data);exit;
        if (!empty($data['pass'])) {

            $data['pwd'] = Admin::pwdGenerate($data['pass']);
        }
        unset ($data['pass'], $data['repass']);
        $data['privilege'] = implode(',', $data['privilege']);
        $referer = $data['referer']; unset($data['referer']);
        if (!($this->saveById($data['id'], new Admin(), $data))) {
            $this->error('修改失败！');
        }

        $this->success('修改成功',$referer, '', 1);
    }
    /*
     *删除一般管理员
     * */
    public function delete(Request $request){
        $data = $request->param();
        if( $this->deleteStatusById($data['id'],new Admin())){
            $this->success('删除成功','index', '', 1);
        }else{
            $this->error('删除失败');
        }
    }

}