<?php
require_once('../include/gpsvars.php');
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
require_once('../include/db_func.php');
require_once('../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if (isset($_POST['send'])) {
    $db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
    $SpreadSheet = new Spreadsheet();
    $SpreadSheet->getProperties()
        ->setCreator("Instructor, TTUCSE")
        ->setLastModifiedBy("Instructor")
        ->setTitle("I4010 Demo")
        ->setSubject("Excel download")
        ->setDescription("Contact Information")
        ->setKeywords("Contact Excel openxml php")
        ->setCategory("Contact list Document");
    $SpreadSheet->setActiveSheetIndex(0);
    $idx = 0;
    $sqlcmd = 'select * from score_average order by average_score desc';
    $TestData = querydb($sqlcmd, $db_conn);
    $CellColName = array('A', 'B', 'C', 'D', 'E');
    $ColumnTitle = array(
        'A1' => '班號', 'B1' => '姓名', 'C1' => '平均成績',
        'D1' => '排名'
    );
    foreach ($ColumnTitle as $ID => $sValue) {
        $SpreadSheet->setActiveSheetIndex(0)->setCellValue($ID, $sValue);
    }
    $Row = 2;
    foreach ($TestData as $curData) {
        $studentId = $curData['student_id'];
        $studentName = $curData['student_name'];
        $averageScore = $curData['average_score'];
        $rank = $curData['rank'];
        $c00 = $CellColName[0] . $Row;
        $c01 = $CellColName[1] . $Row;
        $c02 = $CellColName[2] . $Row;
        $c03 = $CellColName[3] . $Row;
        $SpreadSheet->setActiveSheetIndex(0)
            ->setCellValue($c00, $studentId)
            ->setCellValue($c01, $studentName)
            ->setCellValue($c02, $averageScore)
            ->setCellValue($c03, $rank);
        $Row++;
    }
    $OutputFile = 'ui3a43.xlsx';
    $SpreadSheet->setActiveSheetIndex(0);
    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $OutputFile . '"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($SpreadSheet, 'Xlsx');
    $writer->save('php://output');
    exit();
}
?>

<html>

<body>
    <div style="text-align:center;width:100%;border: 5px double white;font-size:33px;margin:10px auto;background-color:#204969;padding:10px;color:#dadada;">
        I3A43 export<br>
    </div>
    <div style="text-align:center;">
        <form action="" method="post">
            <input type="submit" value="匯出" name="send">
        </form>
    </div>
</body>
<footer style="text-align:center;margin:30px 0 6px;"><a href="index.php">回目錄</a><br />
</footer>

</html>