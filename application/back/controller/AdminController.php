<?php

namespace app\back\controller;

use app\back\model\Ad;
use app\back\model\AdminLog;
use app\back\model\Shop;
use think\Request;
use app\back\model\Admin;
use \think\captcha\Captcha;
class AdminController extends BaseController{
	//admins list
	public function index(){
		//not use layout.html

		$list_admin = Admin::all(['status'=>1]);

		return $this->fetch('',['list_admin'=>$list_admin]);
	}

	//login.html
	public function login(){

		return $this->fetch('');
	}
	/*
	 *   login submit
	 * */
	public function sigin(Request $request){
		$captcha = new Captcha();
		if(!$captcha->check($request->param('captcha'))){
			$this->error('验证码不正确！');
		}
		$name=$request->param('name');
		$pass=$request->param('pass');

		$pwd=Admin::pwdGenerate($pass);
        //return $pwd;
		$condition=array();
		$condition['name']=$name;
		$condition['pwd']=$pwd;
		$admin = Admin::get($condition);

		if($admin->type=='商户'){
           if($admin->st=='禁用'){
               $this->error('禁用,请联系平台！');
           }
        }
		if($admin){

            $admin->setInc('times');
			session('admin_zhx',(object)array('name'=>$admin->name,'id'=>$admin->id,'type'=>$admin->type,'truename'=>$admin->truename));
            //dump(session('admin_zhx'));exit;
          $ip = $_SERVER['REMOTE_ADDR'];
            (new AdminLog())->addLog($admin->id,$ip);
			 $this->redirect("index/index");
		}else{
			 $this->error('用户名或密码有误！');
		}
	}
	//captcha
	public function captcha(){
		$captcha = new Captcha(['fontSize'=>16,'useCurve'=>false,'imageH'=>35,'imageW'=>100,'length'=>3,'useNoise'=>false]);
		return $captcha->entry();
	}
	public function logout(){
		session(null);
		$this->redirect('login');
	}
	/*
	 * add admin from shop list
	 * */
    public function create(Request $request) {
	    $data = $request->param();
        $rule = ['shop_id'=>'require|number'];
        $referer = $request->header()['referer'];
        $res = $this->validate($data,$rule);
        if(true!==$res){
            $this->error($res);
        }

        $row_shop = $this->findById($data['shop_id'],new Shop());
        return $this->fetch('', ['row_shop'=>$row_shop,'referer'=>$referer]);
    }
    /*
     *保存一般管理员
     * */
    public function save(Request $request) {
        $data = $request->param();
        $referer = $data['referer'];unset($data['referer']);
        $rule = ['shop_id'=>'require','truename' => 'require','name' => 'require', 'pass' => 'require', 'repass' => 'require|confirm:pass'];
        $msg = ['truename' => '姓名必须','pass' => '密码必须', 'repass' => '重复密码必须', 'name.require' => '账号必须', 'repass.confirm' => '两次密码不一致'];
        $res = $this->validate($data, $rule, $msg);
        if (true !== $res) {
            $this->error($res);
        }
        $row_admin = Admin::findByName($data['name']);
        if($row_admin){
            $this->error('账号已经存在！',$referer);
        }
        $row_shop = $this->findById($data['shop_id'],new Shop());
        $data['pwd'] = Admin::pwdGenerate($data['pass']);
        unset ($data['pass'], $data['repass']);

        $data['type'] = 2;// 店铺管理员（一般）

        $model_admin = new Admin();
        if (!$model_admin->save($data)) {
            $this->error('添加失败！',$referer);
        }

        $new_id = $model_admin->id;
        $row_shop->admin_id = $new_id;
        $row_shop->save();
        $this->success('添加成功', $referer, '', 1);
    }
    /*
  *   改一般管理员的密码
  * */
    public function edit_(Request $request){
        $data = $request->param();
        $rule = ['shop_id'=>'require','admin_id'=>'require'];
        $referer = $request->header()['referer'];
        $res = $this->validate($data, $rule);
        if (true !== $res) {
            $this->error($res);
        }

        $row_admin = $this->findById($data['admin_id'],new Admin());
        $row_shop = $this->findById($data['shop_id'],new Shop());

        return $this->fetch('',['row_admin'=>$row_admin,'row_shop'=>$row_shop,'referer'=>$referer]);
    }
    /*
     * 改一般管理员的密码
     * */
    public function update_(Request $request) {
        $data = $request->param();
        $referer = $data['referer'];unset($data['referer']);
        //dump($data);exit;
        $rule = ['admin_id'=>'require|number','repass' => 'confirm:pass'];
        $res = $this->validate($data,$rule);
        if(true!==$res){
            $this->error($res);
        }

        if (!empty($data['pass']) && !empty($data['repass'])) {

            $data['pwd'] = Admin::pwdGenerate($data['pass']);
        }
        $data['id'] = $data['admin_id'];
        unset ($data['pass'], $data['repass'],$data['admin_id']);

        if (!($this->saveById($data['id'], new Admin(), $data))) {
            $this->error('没有修改内容！',$referer);
        }
        $this->success('修改成功', $referer, '', 1);
    }
    /*
     * update pwd of admin
     * */
	public function edit(){

	    return $this->fetch('');
    }
    public function update(Request $request){
        $data = $request->param();
        //dump($data);exit;
        $rule = ['pass'=>'require','pass_new'=>'require','repass_new'=>'require|confirm:pass_new'];
        $msg = ['pass'=>'原始密码必须','pass_new'=>'新密码必须','repass_new.require'=>'确认密码必须','repass_new.confirm'=>'确认密码与新密码不一致'];
        $res = $this->validate($data,$rule,$msg);
        if(true!==$res){
            $this->error($res);
        }
        $row_= $this->findById(1,new Admin);
        if(Admin::pwdGenerate($data['pass']) !== $row_->pwd){
            $this->error('原始密码有误');
        }
        $row_-> pwd = Admin::pwdGenerate($data['pass_new']);
        //$data_update=['pwd'=>];
        $row_->save();
        $this->success('修改成功，请用新密码登录','logout');
    }

}