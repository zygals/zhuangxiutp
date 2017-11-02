<?php

namespace app\api\controller;

use app\api\model\User;
use think\Request;


class UserController extends BaseController {
    //注册
    public function index(Request $request) {
        $data = $request->param();
        $rule = ['code'=>'require'];
        $res = $this->validate($data,$rule);
        if(!$res == true){
            return json(['code'=>__LINE__,'msg'=>$res]);
        }
        $code = $data['code'];
        $appid = config('wx_appid');
        $appsecret = config('wx_appsecret');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$code&grant_type=authorization_code");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
		if(!$output){
			return json(['code'=>__LINE__,'msg'=>'登录或注册失败！']);
		}
        curl_close($ch);
        $open_id = json_decode($output)->openid;
        return json(User::registUserByOpenId($open_id));
    }

    public function save(Request $request)
    {

        $data = $request->param();
        $rule = ['username'=>'require'];
        $res = $this->validate($data,$rule);
        if(!$res == true){
            return json(['code'=>__LINE__,'msg'=>$res]);
        }
        $m_ = new User();
        $m_->where(['username'=>$data['username']])->update($data);
         return json(['code'=>0,'msg'=>'save userinfo ok']);
    }
}
