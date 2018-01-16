<?php
$data=array(
    "name" => "zhngyg",
    "msg" => "zhangyingg ai lisehn"
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://huahui.qingyy.net/zhuangxiutp/public/crul2.php");
curl_setopt($ch, CURLOPT_POST, 1);
//The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($ch, CURLOPT_POSTFIELDS , http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);

echo $output;

curl_close($ch);
?>