<?php
ini_set("memory_limit", "1024M");
set_time_limit(300);
header('Content-type: text/html; charset=utf-8');

session_start();
$UserId = $_SESSION['UserId'];
if (!isset($UserId)) die ('Unknown or invalid user!');


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
$english = '';
$chinese = '';

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
		$ErrorCount = 0;
	
		if (!empty($ErrMsg)) {
			$arrWorkSheet = array();
		}

		$SqlcmdPrefix = "INSERT INTO Word (English, Chinese, UserId) VALUES ("
			. ":english, :chinese, :UserId)";
		
		$result = $db_conn->prepare($SqlcmdPrefix);
		$db_conn->beginTransaction();
		$nRow = count($arrWorkSheet);
		for ($Row = 1; $Row < $nRow; $Row++) {
			$TotalPeocessing++;
			$english = $arrWorkSheet[$Row][0];
			$chinese = $arrWorkSheet[$Row][1];
	

			// 安全檢查與處裡
			$english = htmlspecialchars($english);
			$chinese = htmlspecialchars($chinese);
			
			$english = mb_substr($english, 0, 50);
			$chinese = mb_substr($chinese, 0, 20);
			
			if ($ErrMsg <> "") {
				$ErrorCount++;
				$ErrMsg .= "(第 $Row 筆資料)";
			}

			// 寫入資料庫，是否允許重複輸入

			$repeatsql = "SELECT * FROM Word WHERE English = '$english'"
				. " AND Chinese = '$chinese'";
			
			$repeat = querydb($repeatsql, $db_conn);
			if (empty($repeat) && $ErrMsg == "") {
				$result->execute(array(
					':english' => $english,
					':chinese' => $chinese,
					':UserId' => $UserId,
			
				));
				$InsertCount++;
			}
		}
		$db_conn->commit();

	} else {
		$ErrMsg .= '檔案名稱為空白或不存在，檔案大小為0或超過上限(2MBytes)！\n';
	}

	if ($ErrMsg <> "") echo "<script type='text/javascript'>alert('$ErrMsg');</script>";

	$Msg .= date('Y-m-d H:i:s') . "處理結束。</br>";
	$Msg .= "處理 $TotalPeocessing 筆資料，匯入 $InsertCount 筆，錯誤資料 $ErrorCount 筆。</br>";
}
require_once("css.html");
require_once("../include/header.php");
$ThisPageTitle = '聯絡人資料上傳';
?>

<body>
<?php require_once("header.html"); ?>
	<div>
		<table width="720" align="center" border="0">
			<tr>
				<td>請選擇檔案，然後點選上傳檔案按鈕，即可將資料上傳至系統中，
					上傳的檔案大小以2MBytes為限。</td>
			</tr>
			<tr>
				<td>
					檔案格式：Excel檔 (xlsx, ods)<br />
					第一列(欄位A~B)：English | Chinese <br />
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