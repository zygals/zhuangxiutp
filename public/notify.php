<?php

$fp1 = fopen('xml.txt', 'a');
fwrite($fp1,__LINE__."qingqiu\n");
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
    echo $output;
}

// pay nodify_url
$weixin_notify = file_get_contents("php://input");


$url = "https://huahui.qingyy.net/zhuangxiutp/public/index.php/api/dingdan/notify_";


http_request($url,'weixin_notify='.$weixin_notify); //weixin_notify=abc&cde=fgi
