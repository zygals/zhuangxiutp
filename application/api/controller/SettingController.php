<?php

namespace app\api\controller;

use app\api\model\Setting;
use app\api\model\User;
use app\api\controller\BaseController;
use think\Request;

class SettingController extends BaseController{
    /**
     * 获取平台设置接口
     */
    public function get_set(){
        return json(Setting::findOne());
    }
}