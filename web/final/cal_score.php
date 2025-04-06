<?php
ini_set("memory_limit", "1024M");
set_time_limit(300);
header('Content-type: text/html; charset=utf-8');
session_start();
// if (!isset($_SESSION['LoginID']) || empty($_SESSION['LoginID'])) {
//   header("Location:/index.php");
//   exit();
// }
require_once("../include/gpsvars.php");
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
require_once("../include/db_func.php");
require_once("../include/xss.php");
require_once('../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$sqlcmd = 'TRUNCATE TABLE score_average';
$result = updatedb($sqlcmd, $db_conn);
$sqlcmd = 'select * from score order by student_id';
$rs = querydb($sqlcmd, $db_conn);
$totalScore = 0;
$totalCredit = 0;
$nowId = '';
$studentId = '';
$studentName = '';
for ($i = 0; $i < count($rs); $i++) {
    if ($rs[$i]['student_id'] != $nowId) {
        if ($i != 0) {
            $FinalScore = round($totalScore / $totalCredit, 1);
            $sqlcmd = "INSERT INTO score_average (student_id,student_name,average_score,rank) VALUES ('$studentId', '$studentName', '$FinalScore', 0)";
            $result = updatedb($sqlcmd, $db_conn);
        }
        $totalScore = 0;
        $totalCredit = 0;
        $nowId = '';
    }
    $studentId = $rs[$i]['student_id'];
    $nowId = $studentId;
    $studentName = $rs[$i]['student_name'];
    $totalScore += ($rs[$i]['score']) * ($rs[$i]['credit']);
    $totalCredit += $rs[$i]['credit'];
}
$FinalScore = $totalScore / $totalCredit;
$sqlcmd = "INSERT INTO score_average (student_id,student_name,average_score,rank) VALUES ('$studentId', '$studentName', '$FinalScore', 0)";
$result = updatedb($sqlcmd, $db_conn);

$sqlcmd = 'select * from score_average order by average_score desc';
$rs = querydb($sqlcmd, $db_conn);
for($i=0;$i<count($rs);$i++){
    $studentId = $rs[$i]['student_id'];
    $nowRank=$i+1;
    $sqlcmd="UPDATE score_average SET rank = '$nowRank' WHERE student_id='$studentId'";
    $result = updatedb($sqlcmd, $db_conn);
}
?>

<body>
    <div style="text-align:center;width:100%;border: 5px double white;font-size:33px;margin:10px auto;background-color:#204969;padding:10px;color:#dadada;">
        I3A43 cal_score<br>
    </div>

</body>
<footer style="text-align:center;margin:30px 0 6px;"><a href="index.php">回目錄</a><br /></footer>
</html>