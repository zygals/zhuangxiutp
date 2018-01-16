<?php
// pay nodify_url
$fc = file_get_contents("php://input");
$xml = simplexml_load_string($fc);
$fp = fopen('xml.txt', 'a');

$str = 'appid:' . (string)$xml->appid . "return_code:" . (string)$xml->return_code . "result_code:" . (string)$xml->result_code . 'is_string:' . is_string($fc) .'-time_end'.(string)$xml->time_end. 'out_trade_no'.(string)$xml->out_trade_no.'-sign'.(string)$xml->sign."\n";
fwrite($fp, $str);
echo "<xml>
   <return_code><![CDATA[SUCCESS]]></return_code>
   <return_msg><![CDATA[OK]]></return_msg>
   </xml>";
exit;