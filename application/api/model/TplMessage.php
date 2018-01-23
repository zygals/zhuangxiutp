<?php
/**
 * Created by PhpStorm.
 * User: zhangyg
 * Date: 17-12-12
 * Time: 下午4:09
 */
namespace app\api\model;

class TplMessage extends Base {

    public function sendPayOkMsg($row_order,$prepay_id){
        $access_token = $this->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token;
        $user = User::getById($row_order->user_id,new User(),'open_id');
        $shop = Shop::getById($row_order->shop_id,new Shop());

        $good_name='无';
        if(in_array($row_order->getData('type'),[Dingdan::ORDER_TYPE_SHOP,Dingdan::ORDER_TYPE_SHOP_DEPOSIT,Dingdan::ORDER_TYPE_SHOP_MONEY_ALL])){
            $list_order_good = OrderGood::getGood($row_order->id);
            $good_name='';
            foreach ($list_order_good as $good){
                $good_name.=$good['good_name'].',';
            }
            $good_name=trim($good_name,',');
        }
        $arr = [
            'touser'=>$user->open_id,
            "template_id"=>config('template_id_payok'),
            "form_id"=>$prepay_id,
            "page"=>'pages/index/index',
            "data"=>[
                'keyword1'=>[
                    "value"=> $row_order->orderno,
                    "color"=> '#173177',
                ],
                'keyword2'=>[
                    "value"=> $row_order->sum_price.'元',
                    "color"=> '#173177',
                ],
                'keyword3'=>[
                    "value"=> $row_order->create_time,
                    "color"=> '#173177',
                ],
                'keyword4'=>[
                    "value"=> $good_name,
                    "color"=> '#173177',
                ],
                'keyword5'=>[
                    "value"=> $row_order->update_time,
                    "color"=> '#173177',
                ],
                'keyword6'=>[
                    "value"=> $row_order['type'],
                    "color"=> '#173177',
                ],
                'keyword7'=>[
                    "value"=> $shop['name'],
                    "color"=> '#173177',
                ],
            ],
            "emphasis_keyword"=>"keyword2.DATA" ,
        ];

        $this->http_request($url,json_encode($arr,JSON_UNESCAPED_UNICODE));

    }
}