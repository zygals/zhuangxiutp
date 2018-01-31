<?php
namespace app\api\model;
use think\model;

    class AccessToken extends Base{

        /**
         * 返回access_token
         * @return mixed
         */
        public function getToken(){
            $appid=config('appid');
            $appsecret=config('appsecret');
            $file = file_get_contents("./access_token.json",true);
            $result = json_decode($file,true);
            if (time() > $result['expires']){
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

        /**
         * 获取新的access_token
         * @param $appid
         * @param $appsecret
         * @return mixed
         */
        private function getNewToken($appid,$appsecret){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
            $access_token_Arr =   $this->https_request($url);
            return $access_token_Arr['access_token'];
        }
    }