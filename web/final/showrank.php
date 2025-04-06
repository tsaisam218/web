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
$result = updatedb($sqlcmd, $db_conn);
$sqlcmd = 'select * from score_average order by average_score desc';
$rs = querydb($sqlcmd, $db_conn);
?>

<body>
    <div style="text-align:center;width:100%;border: 5px double white;font-size:33px;margin:10px auto;background-color:#204969;padding:10px;color:#dadada;">
        I3A43 showrank<br>
    </div>
    <table class="mistab" width="75%" align="center" style="border:3px #000000 dashed;" cellpadding="10" border='1'>
        <tr>
            <th width="15%">班號</th>
            <th width="15%">姓名</th>
            <th width="20%">平均成績</th>
            <th width="20%">排名</a></th>
        </tr>
        <?php
        foreach ($rs as $item) {
            $studentId = $item['student_id'];
            $studentName = $item['student_name'];
            $averageScore = $item['average_score'];
            $rank = $item['rank'];
        ?>
            <tr align="center">
                <td><?php echo $studentId ?></td>
                <td><?php echo $studentName ?></td>
                <td><?php echo $averageScore ?></td>
                <td><?php echo $rank ?></td>
            </tr>
        <?php } ?>
</body>
<footer style="text-align:center;margin:30px 0 6px;"><a href="index.php">回目錄</a><br /></footer>
</html>