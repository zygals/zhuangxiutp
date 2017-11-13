<?php

namespace app\api\model;

use think\Model;

class Pay extends Base {
	public function requestWxPay($data,$request){
		$user_id = User::getUserIdByName($data['username']);
		if(is_array($user_id)){
			return json($user_id);
		}
		if($data['type_']==Dingdan::ORDER_TYPE_SHOP || $data['type_']==Dingdan::ORDER_TYPE_SHOP_DEPOSIT || $data['type_']==Dingdan::ORDER_TYPE_SHOP_MONEY_ALL || $data['type_']==Dingdan::ORDER_TYPE_GROUP_DEPOSIT ||$data['type_']==Dingdan::ORDER_TYPE_GROUP_FINAL){
		//单商家订单
			$row_order = Dingdan::where(['id'=>$data['order_id']])->find();
			$fee = $row_order->sum_price;
		}elseif($data['type_']==Dingdan::ORDER_TYPE_CONTACT){
		//平台多商家订单
			$row_order = OrderContact::where(['id'=>$data['order_id']])->find();
			$fee = $row_order->sum_price_all;
		}
		if(!$row_order){
			return ['code'=>__LINE__,'msg'=>'订单不存在'];
		}
		if($row_order->st=='已支付'){
			return ['code'=>__LINE__,'msg'=>'订单已支付'];
		}
		$appid = config('wx_appid');//如果是公众号 就是公众号的appid
		$mch_id =  config('wx_mchid');
		$body = 'xiaochengxu zhuangxiu zhifu';
		$nonce_str = $this->nonce_str();//随机字符串
		$notify_url = $request->domain().url('pay_ok');
//		dump($notify_url);exit;
		$openid = User::where(['id'=>$user_id])->value('open_id');
		$out_trade_no = $row_order->orderno;//商户订单号
		$spbill_create_ip = config('wx_spbill_create_ip');
		$total_fee = $fee * 100;//以分为单位
		$trade_type = 'JSAPI';//交易类型 默认

		//这里是按照顺序的 因为下面的签名是按照顺序 排序错误 肯定出错
		$post['appid'] = $appid;
		$post['body'] = $body;
		$post['mch_id'] = $mch_id;
		$post['nonce_str'] = $nonce_str;//随机字符串
		$post['notify_url'] = $notify_url;
		$post['openid'] = $openid;
		$post['out_trade_no'] = $out_trade_no;
		$post['spbill_create_ip'] = $spbill_create_ip;//终端的ip
		$post['total_fee'] = $total_fee;//总金额 最低为一块钱 必须是整数
		$post['trade_type'] = $trade_type;
		$sign = $this->sign($post);//签名            <notify_url>' . $notify_url . '</notify_url>
		$post_xml = '<xml>
           <appid>' . $appid . '</appid>
           <body>' . $body . '</body>
           <mch_id>' . $mch_id . '</mch_id>
           <nonce_str>' . $nonce_str . '</nonce_str>
            <notify_url>' . $notify_url . '</notify_url>
           <openid>' . $openid . '</openid>
           <out_trade_no>' . $out_trade_no . '</out_trade_no>
           <spbill_create_ip>' . $spbill_create_ip . '</spbill_create_ip>
           <total_fee>' . $total_fee . '</total_fee>
           <trade_type>' . $trade_type . '</trade_type>
           <sign>' . $sign . '</sign>
        </xml> ';
		//统一接口prepay_id
		$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
		$xml = $this->http_request($url, $post_xml);
		$array = $this->xml($xml);//全要大写
		if ($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS') {
			$time = time();
			$tmp = '';//临时数组用于签名
			$tmp['appId'] = $appid;
			$tmp['nonceStr'] = $nonce_str;
			$tmp['package'] = 'prepay_id=' . $array['PREPAY_ID'];
			$tmp['signType'] = 'MD5';
			$tmp['timeStamp'] = "$time";

			$data_return['code'] = 0;
			$data_return['timeStamp'] = "$time";//时间戳
			$data_return['nonceStr'] = $nonce_str;//随机字符串
			$data_return['signType'] = 'MD5';//签名算法，暂支持 MD5
			$data_return['package'] = 'prepay_id=' . $array['PREPAY_ID'];//统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
			$data_return['paySign'] = $this->sign($tmp);//签名,具体签名方案参见微信公众号支付帮助文档;
			$data_return['out_trade_no'] = $out_trade_no;

		} else {
			$data_return['code'] = __LINE__;
			$data_return['RETURN_CODE'] = $array['RETURN_CODE'];
			$data_return['RETURN_MSG'] = $array['RETURN_MSG'];
		}
		return ($data_return);
	}
//随机32位字符串
	private function nonce_str() {
		$result = '';
		$str = 'QWERTYUIOPASDFGHJKLZXVBNMqwertyuioplkjhgfdsamnbvcxz';
		for ($i = 0; $i < 32; $i++) {
			$result .= $str[rand(0, 48)];
		}
		return $result;
	}




//签名 $data要先排好顺序
	private function sign($data) {
		$stringA = '';
		foreach ($data as $key => $value) {
			if (!$value) continue;
			if ($stringA) $stringA .= '&' . $key . "=" . $value;
			else $stringA = $key . "=" . $value;
		}

		$wx_key = config('wx_mchkey');//申请支付后有给予一个商户账号和密码，登陆后自己设置key

		$stringSignTemp = $stringA . '&key=' . $wx_key;
		return strtoupper(md5($stringSignTemp));
	}


//curl请求啊
	function http_request($url, $data = null, $headers = array()) {
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


//获取xml
	private function xml($xml) {
		$p = xml_parser_create();
		xml_parse_into_struct($p, $xml, $vals, $index);
		xml_parser_free($p);
		$data = "";
		foreach ($index as $key => $value) {
			if ($key == 'xml' || $key == 'XML') continue;
			$tag = $vals[$value[0]]['tag'];
			$value = $vals[$value[0]]['value'];
			$data[$tag] = $value;
		}
		return $data;
	}


}
