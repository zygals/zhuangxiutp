<?php
namespace app\api\controller;
use app\api\model\Ad;
use app\api\model\Setting;
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

    //curl请求
    public function https_request($url,$data) {
        $ch = curl_init();
       /* //设置参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if(!empty($data)){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //采集
        $output = curl_exec($ch);
        //关闭
        curl_close($ch);
        return $output;*/
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        $out = json_encode($output);
        return $out;
    }

    function api_notice_increment($url, $data){
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        curl_close($ch);
        //     var_dump($tmpInfo);
        //    exit;
        return $tmpInfo;
    }


}