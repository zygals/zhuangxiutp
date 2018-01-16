<?php
$data=array(
    "name" => "zhngyg",
    "msg" => "zhangyingg ai lisehn"
);
echo json_encode($data),"<br>";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://huahui.qingyy.net/zhuangxiutp/public/curl2.php");
curl_setopt($ch, CURLOPT_POST, 1);
//The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($ch, CURLOPT_POSTFIELDS , json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);

echo $output;

curl_close($ch);
?>