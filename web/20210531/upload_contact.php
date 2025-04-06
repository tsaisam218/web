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
require_once("../include/configure.php");
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

    if ($arrWorkSheet[0][0] <> '姓名') {
      $ErrMsg .= '資料格式不符(A)\n';
    }
    if ($arrWorkSheet[0][1] <> '性別') {
      $ErrMsg .= '資料格式不符(B)\n';
    }
    if ($arrWorkSheet[0][2] <> '生日') {
      $ErrMsg .= '資料格式不符(C)\n';
    }
    if ($arrWorkSheet[0][3] <> '電話') {
      $ErrMsg .= '資料格式不符(D)\n';
    }
    if ($arrWorkSheet[0][4] <> '地址') {
      $ErrMsg .= '資料格式不符(D)\n';
    }
    if (!empty($ErrMsg)) {
      $arrWorkSheet = array();
    }

    $SqlcmdPrefix = 'INSERT INTO namelist (name,Gender,birthday,phone,address) VALUES (';
    $nRow = count($arrWorkSheet);
    for ($Row = 1; $Row < $nRow; $Row++) {
      $TotalPeocessing++;
      $Name = $arrWorkSheet[$Row][0];
      $Phone = $arrWorkSheet[$Row][3];
      $Gender = $arrWorkSheet[$Row][1];
      $Birthday = $arrWorkSheet[$Row][2];
      $Address = $arrWorkSheet[$Row][4];
      $oldDate = strtotime($Birthday);
      $newDate = date('Y-m-d',$oldDate);
      // 安全檢查與處裡
      // 寫入資料庫，是否允許重複輸入
      $sqlcmd = "SELECT * FROM namelist WHERE name = '$Name' AND birthday = '$newDate'";
      $result = updatedb($sqlcmd, $db_conn);
      if($result->rowCount() == 0){
        $sqlcmd = "INSERT INTO namelist (name,Gender,birthday,phone,address) VALUES ('$Name', '$Gender', '$newDate', '$Phone', '$Address')";
        $result = updatedb($sqlcmd, $db_conn);
        $InsertCount++;
      }
      else{
        $sqlcmd="UPDATE namelist SET phone='$Phone', address='$Address', Gender = '$Gender' WHERE name='$Name' AND birthday = '$newDate'";
        $result = updatedb($sqlcmd, $db_conn);
        $UpdateCount++;
      }
    }
  } else {
    $ErrMsg .= '檔案名稱為空白或不存在，檔案大小為0或超過上限(2MBytes)！\n';
  }

  $Msg .= date('Y-m-d H:i:s') . "處理結束。</br>";
  $Msg .= "處理 $TotalPeocessing 筆資料，匯入 $InsertCount 筆，更新 $UpdateCount 筆。</br>";
}
require_once("../include/header.php");
$ThisPageTitle = '聯絡人資料上傳';
?>

<body>
  <div>
    <table width="720" align="center" border="0">
      <tr>
        <td>請選擇檔案，然後點選上傳檔案按鈕，即可將資料上傳至系統中，
          上傳的檔案大小以2MBytes為限。</td>
      </tr>
      <tr>
        <td>
          檔案格式：Excel檔<br />
          第一列(欄位A~D)：姓名 | 電話 | 性別 | 生日<br />
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