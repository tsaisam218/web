<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort'])) header("Location: contactmgm.php");
// Authentication 認證
require_once("../include/auth.php");
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' AND valid='Y'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die('Unknown or invalid user!');
$UserGroupID = $rs[0]['groupid'];
if (!isset($GroupID))  $GroupID = $rs[0]['groupid'];
if (!isset($Name)) $Name = '';
if (!isset($Phone)) $Phone = '';
if (!isset($Address)) $Address = '';
// 取出群組資料
$sqlcmd = "SELECT * FROM groups WHERE valid='Y' AND (groupid='$UserGroupID' "
  . "OR groupid IN (SELECT groupid FROM privileges "
  . "WHERE loginid='$LoginID' AND privilege > 1 AND valid='Y'))";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die('No group could be found!');
$GroupNames = array();
foreach ($rs as $item) {
  $ID = $item['groupid'];
  $GroupNames[$ID] = $item['groupname'];
}
$GroupIDs = '';
foreach ($GroupNames as $ID => $GroupName) $GroupIDs .= "','" . $ID;
$GroupIDs = "(" . substr($GroupIDs, 2) . "')";
if (isset($Confirm)) {   // 確認按鈕
  if (empty($Name)) $ErrMsg = '姓名不可為空白\n';
  if (empty($Phone)) $ErrMsg = '電話不可為空白\n';
  if (empty($GroupID) || $GroupID <> addslashes($GroupID)) $ErrMsg = '群組資料錯誤\n';

  if (empty($ErrMsg)) {
    // 確定此用戶可設定所選定群組的聯絡人資料
    $sqlcmd = "SELECT privilege FROM privileges "
      . "WHERE loginid='$LoginID' AND groupid='$GroupID' AND privilege>0";
    $rs = querydb($sqlcmd, $db_conn);
    // 若權限表未設定權限，則設為用戶的群組
    if (count($rs) <= 0) $GroupID = $UserGroupID;
    $sqlcmd = 'INSERT INTO namelist (name,phone,address,groupid) VALUES ('
      . "'$Name','$Phone','$Address','$GroupID')";
    $result = updatedb($sqlcmd, $db_conn);

    $sqlcmd = "SELECT count(*) AS reccount FROM namelist WHERE groupid IN $GroupIDs ";
    $rs = querydb($sqlcmd, $db_conn);
    $RecCount = $rs[0]['reccount'];
    $TotalPage = (int) ceil($RecCount / $ItemPerPage);
    $_SESSION['CurPage'] = $TotalPage;

    header("Location: contactmgm.php");
  }
}
$PageTitle = '示範新增人員資料';
require_once("../include/header.php");
?>
<div align="center">
  <form action="" method="post" name="inputform">
    <b>新增人員資料</b>
    <table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
      <tr height="30">
        <th width="40%">姓名</th>
        <td><input type="text" name="Name" value="<?php echo $Name ?>" size="20"></td>
      </tr>
      <tr height="30">
        <th>單位</th>
        <td><select name="GroupID">
            <?php
            foreach ($GroupNames as $ID => $GroupName) {
              echo '    <option value="' . $ID . '"';
              if ($ID == $GID) echo ' selected';
              echo ">$GroupName</option>\n";
            }
            ?>
          </select>
        </td>
      </tr>
      <tr height="30">
        <th width="40%">電話</th>
        <td><input type="text" name="Phone" value="<?php echo $Phone ?>" size="20"></td>
      </tr>
      <tr height="30">
        <th width="40%">地址</th>
        <td><input type="text" name="Address" value="<?php echo $Address ?>" size="50"></td>
      </tr>
    </table>
    <input type="submit" name="Confirm" value="存檔送出">&nbsp;
    <input type="submit" name="Abort" value="放棄新增">
  </form>
</div>
<?php
require_once('../include/footer.php');
?>