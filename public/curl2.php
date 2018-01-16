<?php
$phpInput=file_get_contents('php://input');
echo urldecode($phpInput);
?>