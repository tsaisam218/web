<?php
session_start();
$UserId = $_SESSION['UserId'];
if (!isset($UserId)) die('Unknown or invalid user!');

// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
require_once("../include/xss.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

if (!isset($english))  $english = '';
if (!isset($chinese)) $chinese = '';

if (isset($Confirm)) {   // 確認按鈕

	$english = htmlspecialchars($english);
	$chinese = htmlspecialchars($chinese);

	if (empty($chinese)) $ErrMsg =  $ErrMsg . '英文不可為空白 ';
	if (empty($english)) $ErrMsg = $ErrMsg . "中文不可為空白 ";

	$english = mb_substr($english, 0, 50);
	$chinese = mb_substr($chinese, 0, 20);

	if (empty($ErrMsg)) {
		$repeatsql = "SELECT * FROM Word WHERE English = '$english'"
			. " AND Chinese = '$chinese' AND UserId = '$UserId'";

		$repeat = querydb($repeatsql, $db_conn);
		//print_r($repeat);
		if (empty($repeat) && empty($ErrMsg)) {
			$sqlcmd = "INSERT INTO Word (English, Chinese, UserId) VALUES ("
				. ":english, :chinese, :UserId)";
			$result = $db_conn->prepare($sqlcmd);
			$result->execute(array(
				':english' => $english,
				':chinese' => $chinese,
				':UserId' => $UserId,
			));
			//print_r($result);
			echo "<script type='text/javascript'>alert('新增成功');</script>";
		} else {
			echo "<script type='text/javascript'>alert('重複新增');</script>";
		}
	} else
		echo "<script type='text/javascript'>alert('$ErrMsg');</script>";
}
require_once("css.html");
require_once("../include/header.php");
?>
<?php require_once("header.html"); ?>
<div align="center">
	<form action="" method="post" name="inputform">
		<b>新增英文單字表</b>
		<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
			<tr height="30">

				<th width="40%">英文</th>
				<td><input type="text" name="english" size="50">
				</td>
			</tr>

			<th width="40%">中文</th>
			<td><input type="text" name="chinese" size="20"></td>
			</tr>
			</select>
			</td>
			</tr>
		</table>
		<input type="submit" name="Confirm" value="存檔送出">
	</form>
</div>
<?php
require_once('../include/footer.php');
?>