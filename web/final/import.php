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

$ErrMsg = '';
$Msg = '';
$LoginID = $_SESSION['LoginID'];
$SchYear = date('Y');
$lastupdate = date('Y-m-d H:i:s');
if (isset($upload)) {
    $sqlcmd = 'TRUNCATE TABLE score';
    $result = updatedb($sqlcmd, $db_conn);
    $sqlcmd = 'TRUNCATE TABLE score_average';
    $result = updatedb($sqlcmd, $db_conn);
    $fname = $_FILES['userfile']['tmp_name'];
    $fsize = $_FILES['userfile']['size'];
    $inputFile = $_FILES['userfile']['name'];
    $extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));
    if (($extension == 'XLSX' || $extension == 'ODS') && !empty($fname) && $fsize > 0) {
        //Read spreadsheeet workbook
        try {
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($fname);
            $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $sheetData = $objReader->load($fname);
        } catch (Exception $e) {
            die($e->getMessage());
        }
        $arrWorkSheet = $sheetData->getSheet(0)->toArray();
        $LastColumn = count($arrWorkSheet[0]);

        $TotalPeocessing = 0;
        $InsertCount = 0;
        $UpdateCount = 0;

        if ($arrWorkSheet[0][0] <> '班號') {
            $ErrMsg .= '資料格式不符(A)\n';
        }
        if ($arrWorkSheet[0][1] <> '姓名') {
            $ErrMsg .= '資料格式不符(B)\n';
        }
        if ($arrWorkSheet[0][2] <> '課程編號') {
            $ErrMsg .= '資料格式不符(C)\n';
        }
        if ($arrWorkSheet[0][3] <> '學分數') {
            $ErrMsg .= '資料格式不符(D)\n';
        }
        if ($arrWorkSheet[0][4] <> '成績') {
            $ErrMsg .= '資料格式不符(D)\n';
        }
        if (!empty($ErrMsg)) {
            $arrWorkSheet = array();
        }

        $SqlcmdPrefix = 'INSERT INTO score (student_id,student_name,subject_id,credit,score) VALUES (';
        $nRow = count($arrWorkSheet);
        for ($Row = 1; $Row < $nRow; $Row++) {
            $TotalPeocessing++;
            $student_id = $arrWorkSheet[$Row][0];
            $student_name = $arrWorkSheet[$Row][1];
            $subject_id = $arrWorkSheet[$Row][2];
            $credit = $arrWorkSheet[$Row][3];
            $score = $arrWorkSheet[$Row][4];

            $sqlcmd = "INSERT INTO score (student_id,student_name,subject_id,credit,score) VALUES ('$student_id', '$student_name', '$subject_id', '$credit', '$score')";
            $result = updatedb($sqlcmd, $db_conn);
            $InsertCount++;
        }
    } else {
        $ErrMsg .= '檔案名稱為空白或不存在，檔案大小為0或超過上限(2MBytes)！\n';
    }

    $Msg .= date('Y-m-d H:i:s') . "處理結束。</br>";
    $Msg .= "處理 $TotalPeocessing 筆資料，匯入 $InsertCount 筆，更新 $UpdateCount 筆。</br>";
}
require_once("../include/header.php");
$ThisPageTitle = '成績上傳';
?>

<body>
    <div style="text-align:center;width:100%;border: 5px double white;font-size:33px;margin:10px auto;background-color:#204969;padding:10px;color:#dadada;">
        I3A43 import<br>
    </div>
    <div>
        <table width="720" align="center" border="0">
            <tr>
                <td>請選擇檔案，然後點選上傳檔案按鈕，即可將資料上傳至系統中，
                    上傳的檔案大小以2MBytes為限。</td>
            </tr>
            <tr>
                <td>
                    檔案格式：Excel檔<br />
                    第一列(欄位A~E)：班號 | 姓名 | 課程編號 | 學分數 | 成績<br />
                    第二列以後依序填入資料<br />
                    註：第一列必須輸入上述字樣，否則資料不會被接受，如果有要變更如分梯次等資料，修改後重新上傳即可
                </td>
            </tr>
        </table>
        <div style="width:720px;margin:12px auto 0 auto;">
            <form method="post" enctype="multipart/form-data" action="">
                <input type="hidden" name="MAX_FILE_SIZE" value="2100000">
                <div style="text-align:center;border:2px solid brown;padding:12px 3px;">
                    上傳檔名：<input name="userfile" type="file">&nbsp;
                    <input type="submit" name="upload" value="上傳檔案">
                </div>
            </form>
        </div>
        <?php if (!empty($Msg)) { ?>
            <div style="text-align:center;"><?php echo $Msg; ?></div>
        <?php } ?>
        <?php
        require_once('../include/footer.php');
        ?>
    </div>
</body>

</html>

<footer style="text-align:center;margin:30px 0 6px;"><a href="index.php">回目錄</a><br /></footer>