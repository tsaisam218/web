<?php
// ���{���]���ثe�u�Τ@�ӰѼƧY�i���o�Ӥ��A�]�����w���ü{�A�Ы�Ҧp���i�I
// �ܼƤΨ禡�B�z�A�Ъ`�N�䶶��
require_once("../include/configure.php");
$ID = $_GET['ID'];
if (!isset($ID)) exit;
$filetype = 'image/pjpeg';
$filename = $AttachDir . '/' . str_pad($ID, 8, '0', STR_PAD_LEFT) . '.jpg';
$fp = @fopen($filename,'r');
if ($fp) {
    $output = fread($fp, filesize($filename));
    header("Content-type: $filetype \n");
    header("Content-Disposition: filename=$filename \n");
    echo $output;
} else die ('File Not Exist!');

?>