<?php
$fc = file_get_contents("php://input");
$xml = simplexml_load_string($fc);
$fp = fopen('xml.txt','a');
$str = 'appid:'.(string)$xml->appid."return_code:".(string)$xml->return_code."result_code:".(string)$xml->result_code.'is_string:'.is_string($fc)."\n";
fwrite($fp,$str);
return 1;