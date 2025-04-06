<?php
// Authentication 認證
session_start();
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
require_once("css.html");
require_once("../include/header.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
//判斷現在的使用者
/*$LoginID = "inori";
$sqlcmd = "SELECT * FROM User2 WHERE Account='$LoginID'";
$rs = querydb($sqlcmd, $db_conn);
$UserId = $rs[0]['UserId'];
if (count($rs) <= 0) die ('Unknown or invalid user!');*/

$UserId = $_SESSION['UserId'];
if (!isset($UserId)) die('Unknown or invalid user!');

$ItemPerPage = 30; //每頁可以有幾筆資料
$sqlcmd = "SELECT count(*) AS reccount FROM Quiz_master WHERE UserId = '$UserId' ORDER BY UserId ASC, QuizNo ASC "; //找出有幾筆資料
$rs = querydb($sqlcmd, $db_conn);

$sqlcmd = "SELECT  QuizNo FROM Quiz_master WHERE UserId = '$UserId' ORDER BY QuizNo ASC";
$rs2 = querydb($sqlcmd, $db_conn);
$quizArr = array();
for($i=0;$i<count($rs2);$i++){
    $quizArr[$i] =  $rs2[$i]['QuizNo'];
}

if (isset($Detail)) {
  $select = mb_substr($Detail, 3, -4);
  $_SESSION['QuizNoIndex'] = $select;
  $_SESSION['QuizNo'] = $quizArr[$select-1];
  header("Location: showDetail.php");
  exit();
}

$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount / $ItemPerPage); //算出需要幾頁呈現
if (!isset($Page)) { //繼承目前所在頁數
  if (isset($_SESSION['CurPage'])) $Page = $_SESSION['CurPage'];
  else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage; //目前所在頁數上限
if (!isset($Page) || $Page < 1) $Page = 1; //目前所在頁數下限
$_SESSION['CurPage'] = $Page; //暫存目前所在頁數
$StartRec = ($Page - 1) * $ItemPerPage; //找出要開始呈現的第一筆資料數
$sqlcmd = "SELECT * FROM Quiz_master WHERE UserId = '$UserId' ORDER BY UserId ASC, QuizNo ASC LIMIT $StartRec,$ItemPerPage "; //取出對應資料數
$Contacts = querydb($sqlcmd, $db_conn);
?>

<body>
  <?php require_once("header.html"); ?>
  <div>
    <Script Language="JavaScript">
      <!--
      function confirmation(DspMsg, PassArg) { //不知道幹嘛的
        var name = confirm(DspMsg)
        if (name == true) {
          location = PassArg;
        }
      }
      -->
    </SCRIPT>

    <div id="logo">測驗查詢表</div>
    <table border="0" width="90%" align="center" cellspacing="0" cellpadding="2">
      <tr>
        <td width="50%" align="left">
          <?php if ($TotalPage > 1) { ?>
            <form name="SelPage" method="POST" action="">
              <!--下拉式選單選頁數-->
              第<select name="Page" onchange="submit();">
                <?php
                for ($p = 1; $p <= $TotalPage; $p++) {
                  echo '  <option value="' . $p . '"';
                  if ($p == $Page) echo ' selected';
                  echo ">$p</option>\n";
                }
                ?>
              </select>頁 共<?php echo $TotalPage ?>頁
            </form>
        </td>
      <?php } ?>
      </tr>
    </table>
    <form name="ToDetail" method="POST" action="">
      <table class="mistab" width="50%" align="center">
        <tr align="center">
          <th width="10%">選項</th>
          <th width="15%">測驗編號</th>
          <th width="15%">答對題數</th>
          <th width="15%">答錯題數</th>
        </tr>
        <?php
        $i=1;
        foreach ($Contacts as $item) {
          $QuizNo = $item['QuizNo'];
          $Correct = $item['Correct'];
          $Wrong = $item['Wrong'];
        ?>
          <tr align="center">
            <td><input type="submit" name="Detail" value="<?php echo "查看 " . $i . " 號測驗"; ?>"></td>
            <td><?php echo $i ?></td>
            <td><?php echo $Correct ?></td>
            <td><?php echo $Wrong ?></td>
          </tr>
        <?php
        $i++;
        }
        ?>
    </form>
  </div>
</body>

</html>