<?php
namespace app\wx\controller;
use app\common\model\Ad;
use app\common\model\Setting;
use think\Controller;
use think\Request;
use think\Session;

class BaseController extends Controller {
		/*public function __construct() {
		}*/
		/*
		 *  根据id查找对象，并返回数组
		 * */
    public function _initialize() {
        parent::_initialize();
    }

    public function findById($id,$model){
        if(empty($id) || !is_numeric($id)){
            $this->error('id参数有误');
        }
        $row = $model->find($id);
        if(!$row){
            $this->error('对象不存在');
        }
        return $row;
    }


}