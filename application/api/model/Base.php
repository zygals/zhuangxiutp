<?php

namespace app\api\model;

use think\Model;

class Base extends model {
    public static function getPageStr($data,$page_str) {
        if(isset($data['page'])){
            unset($data['page']);
        }
        if(count($data)>0){

            $query_str = '';
            foreach($data as $k=>$v){
                $query_str.= $k.'='.$v.'&';
            }
            $page_str = preg_replace("/(page=)/im", $query_str.'page=', $page_str);
        }
        return $page_str;
    }
    protected static function getListCommon($data=[],$where = ['st' => ['<>', 0]]){

        $order = "create_time desc";

        if (!empty($data['name'])) {
            $where['name'] = ['like', '%' . $data['name'] . '%'];
        }
        if (!empty($data['paixu'])) {
            $order = $data['paixu'] . ' asc';
        }
        if (!empty($data['paixu']) && !empty($data['sort_type'])) {
            $order = $data['paixu'] . ' desc';
        }
        $list_ = self::where($where)->order($order)->paginate();

        return $list_;
    }

    //wx
    public static function getById($id,$model,$field='*',$where=['st'=>1]){

        $row = $model->field($field)->where($where)->find($id);
        if(!$row){
           return [];
        }
        return $row;
    }

    public static function getByDivId($model,$where=['st'=>1],$field='*'){

        $row = $model->where($where)->find();
        return $row;
    }

    public static function getByShopId($shop_id,$model,$field='*',$where=['st'=>1]){

        $row = $model->field($field)->where($where)->where('shop_id',$shop_id)->paginate();
        if(!$row){
            return [];
        }
        return $row;
    }

    //curl请求
    protected function https_request($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $out = curl_exec($ch);
        curl_close($ch);
        return json_decode($out, true);
    }
    protected function http_request($url, $data = null, $headers = array()) {
        $curl = curl_init();
        if (count($headers) >= 1) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
    public function getToken(){
        $appid=config('wx_appid');
        $appsecret=config('wx_appsecret');
        $file = file_get_contents("./access_token.json",true);

        $result = json_decode($file,true);

        if (time() > $result['expires'] || $file==''){

            $data = array();
            $data['access_token'] = $this->getNewToken($appid,$appsecret);
            $data['expires']=time()+7000;
            $jsonStr =  json_encode($data);
            $fp = fopen("./access_token.json", "w");
            fwrite($fp, $jsonStr);
            fclose($fp);
            return $data['access_token'];
        }else{
            return $result['access_token'];
        }
    }
    private function getNewToken($appid,$appsecret){

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $access_token_Arr =   json_decode($this->http_request($url),true);

        return $access_token_Arr['access_token'];


}

}