<?php
// ���{���]���ثe�u�Τ@�ӰѼƧY�i���o�Ӥ��A�]�����w���ü{�A�Ы�Ҧp���i�I
// �ܼƤΨ禡�B�z�A�Ъ`�N�䶶��
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$ID = $_GET['ID'];
if (!isset($ID)) exit;
$sqlcmd = "SELECT * FROM namelist WHERE cid='$ID'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs)>0) {
    $Image = $rs[0]['userimage'];
    $filename = $ID . '.png';
    $filetype = 'application/x-png';
    header("Content-type: $filetype \n");
    header("Content-Disposition: filename=$filename \n");
    echo $Image;
} else die ('File Not Exist!');

?>