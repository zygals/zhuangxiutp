<?php

namespace app\back\controller;


use app\back\model\Ad;

use app\back\model\Base;
use think\Request;


class XmlController extends BaseController {
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request) {

        return $this->fetch('create',['act'=>'save']);
    }
    public function save(Request $request){
        $data = $request->post();
        $fc = file_get_contents("php://input");
        $xml = simplexml_load_string($fc);
     dump($xml);
        $fp = fopen('xml.txt','w');
        fwrite($fp,$data['cont']);
        //$xml = $data['cont'];
       // $xml = simplexml_load_string($data['cont']);
        //print_r( (string) $xml->appid);
        //$login = $xml->login;//这里返回的依然是个SimpleXMLElement对象
       // print_r($login);
       // $login = (string) $xml->login;//在做数据比较时，注意要先强制转换
       // print_r($login);
        exit;
    }


}
