<?php
$SystemName = '網頁程式設計與安全實務';
$dbhost = "i4010db.isrcttu.net:4010";
$dbname = "I4010_9632";
$dbuser = "ui3a43";
$dbpwd = "410706143";
$uDate = date("Y-m-d H:i:s");
$ErrMsg = "";
$UserIP = '';
if (isset($_SERVER['HTTP_VIA']) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
    $UserIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if (isset($_SERVER['REMOTE_ADDR'])) $UserIP = $_SERVER['REMOTE_ADDR'];
?>
