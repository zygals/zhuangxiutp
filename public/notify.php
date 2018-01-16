<?php


// pay nodify_url
$fc = file_get_contents("php://input");

$url = "http://www.jb51.net";
if (isset($url))
{
    Header("Location: $url");
}
