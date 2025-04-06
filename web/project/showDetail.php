<?php
// Authentication 認證
require_once("../include/auth.php");
// session_start();
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
$QuizNo = $_SESSION['QuizNo'];
$QuizNoIndex = $_SESSION['QuizNoIndex'];
$sqlcmd = "SELECT count(*) AS reccount FROM Quiz_detail WHERE QuizNo = '$QuizNo' ORDER BY WordId ASC"; //找出有幾筆資料
$rs = querydb($sqlcmd, $db_conn);
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
$sqlcmd = "SELECT * FROM Quiz_detail WHERE QuizNo = '$QuizNo' ORDER BY WordId ASC LIMIT $StartRec,$ItemPerPage"; //取出對應資料數
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

    <div id="logo"><?php echo "第 " . ($QuizNoIndex) . " 次 測驗結果"; ?></div>

    <table id="menu" width="100%" align="center" cellspacing="2" cellpadding="4">
      <tr>
        <td width="30%" align="center"><a href="showQuiz.php">返回測驗查詢表</a></td>
        <td></td>
      </tr>
    </table>

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
          <th width="15%">題號</th>
          <th width="15%">測驗類型</th>
          <th width="15%">題目</th>
          <th width="15%">答題結果</th>
          <th width="15%">正確答案</th>
          <th>使用者答案</th>
        </tr>
        <?php
        $index = 1;
        foreach ($Contacts as $item) {
          $WordId = $item['WordId'];
          $IsCorrect = $item['IsCorrect'];
          if ($IsCorrect == 1) $IsCorrect = "正確";
          else  $IsCorrect = "錯誤";
          $UserAns = $item['UserAns'];
          $Type = $item['Type'];
          $sqlcmd = "SELECT English,Chinese FROM Word WHERE WordId = '$WordId'"; //取出對應資料數
          $temp = querydb($sqlcmd, $db_conn);
          if ($Type == 1) {
            $Type = "中轉英";
            $test = $temp[0]['Chinese'];
            $Ans = $temp[0]['English'];
          } else {
            $Type = "英轉中";
            $test = $temp[0]['English'];
            $Ans = $temp[0]['Chinese'];
          }
        ?>
          <tr align="center">
            <td><?php echo $index++; ?></td>
            <td><?php echo $Type; ?></td>
            <td><?php echo $test; ?></td>
            <td><?php echo $IsCorrect; ?></td>
            <td><?php echo $Ans; ?></td>
            <td><?php echo $UserAns; ?></td>
          </tr>
        <?php
        }
        ?>
    </form>
  </div>
</body>

</html>