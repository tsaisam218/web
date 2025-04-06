<?php
function userauth($ID, $PWD, $db_conn) {
    $sqlcmd = "SELECT * FROM User2 WHERE Account = '$ID'";
    $rs = querydb($sqlcmd, $db_conn);
    $retcode = 0;
	
    if (count($rs) > 0) {
        $Password = sha1($PWD);
        if ($Password == $rs[0]['Password']) $retcode = 1;
    }
    return $retcode;
}
session_start();
//session_unset();
require_once("../include/gpsvars.php");
$ErrMsg = "";
if (!isset($ID)) $ID = "";
$flag = 0;
if(isset($Submit) && isset($vCode)){
	$VerifyCode = $_SESSION['VerifyCode'];
	if($vCode <> $VerifyCode){
		$ErrMsg = '<font color="Red">驗證碼錯誤！</font>';
		$flag = 1;
	}
}
if (isset($Submit) && $flag == 0) {
	require ("../include/configure.php");
	require ("../include/db_func.php");
	$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
    if (strlen($ID) > 0 && strlen($ID) <= 16 && $ID == addslashes($ID)) {
        $Authorized = userauth($ID,$PWD,$db_conn);
		if ($Authorized) {
		    $sqlcmd = "SELECT * FROM User2 WHERE Account='$ID'";
		    $rs = querydb($sqlcmd, $db_conn);
			$Account = $rs[0]['Account'];
			$UserId = $rs[0]['UserId'];
	        $_SESSION['Account'] = $Account;
			$_SESSION['UserId'] = $UserId;
            header ("Location: ViewWordList.php");
            exit();
		}
		$ErrMsg = '<font color="Red">'
			. '您並非合法使用者或是使用權已被停止</font>';
    } else {
		$ErrMsg = '<font color="Red">'
			. 'ID錯誤，您並非合法使用者或是使用權已被停止</font>';
	}
  if (empty($ErrMsg)) $ErrMsg = '<font color="Red">登入錯誤</font>';
}
$_SESSION['VerifyCode'] = mt_rand(1000,9999);
?>
<HTML>
<HEAD>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=utf-8">
<meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>英文單字測驗系統</title>
<style type="text/css">
<!--
body {font-family: 新細明體, arial; font-size: 12pt; color: #000000}
pre, tt {font-size: 12pt}
th {font-family: 新細明體, arial; font-size: 12pt; font-weight: bold; background-color: #F0E68C}
td {font-family: 新細明體, arial; font-size: 12pt;}
form {font-family: 新細明體, arial; font-size: 12pt;}
input {font-family: 新細明體, arial; font-size: 12pt; color: #000000}
input.pwdtext {font-family: helvetica, sans-serif;}
a:active{color:#FF0000; text-decoration: none}
a:link{color:#0000FF; text-decoration: none}
a:visited{color:#0000FF; text-decoration: none}
a:hover{color:#FF0000; text-decoration: none}
//-->
</style>
</HEAD>
<script type="text/javascript">
<!--
function setFocus()
{
<?php if (empty($ID)) { ?>
    document.LoginForm.ID.focus();
<?php } else { ?>
    document.LoginForm.PWD.focus();
<?php } ?>
}
//-->
</script>
<center>
<BODY background = "Login2圖片/bg.jpg"
  topmargin="0" leftmargin="0" rightmargin="0" onload="setFocus()">
<div style="margin-top:180px;">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
<tr><td>&nbsp;</td></tr>
<tr>
  <td>
  <form method="POST" name="LoginForm" action="">
  <table width="500" border="0" cellspacing="0" cellpadding="2"
    align="center" bordercolor="Blue">
  <tr style = "background:#FFEAC588" height="100">
    <td align="center" style = "font-size:50px; font-family:Microsoft JhengHei"><b>英文單字測驗系統<br>登入頁面</b>
    </td>
  </tr>
  <tr style = "background:#FFFAEB80" height="35">
    <td align="center", style = "font-size:27px; font-family:Microsoft JhengHei"><b>帳號</b><br>
      <input type="text" style="font-size:27px; font-family:Microsoft JhengHei" name="ID" size="20" maxlength="16"
        value="<?php echo $ID; ?>" class="pwdtext">
    </td>
  </tr>
  <tr style = "background:#FFFAEB80" height="10">
    <td> </td>
  </tr>
  <tr style = "background:#FFFAEB80" height="35">
    <td align="center", style = "font-size:27px; font-family:Microsoft JhengHei"><b>密碼</b><br>
     <input type="password" style="font-size:27px; font-family:Microsoft JhengHei" name="PWD" size="20" maxlength="16" class="pwdtext">
    </td>
  </tr>
  <tr style = "background:#FFFAEB80" height="10">
    <td> </td>
  </tr>
  <tr style = "background:#FFFAEB80" height="35">
	<td align="center", style = "font-size:27px; font-family:Microsoft JhengHei">&nbsp;
	<img src="../images/chapcha.php" width="100px" height="39px" style="vertical-align:text-bottom;">
	<input type="submit" name="ReGen" style="background: url(Login2圖片/Regen.png); width:91px; height:30px; text-align:center; border:0px" value="" />
	</td>
  </tr>
  <tr style = "background:#FFFAEB80" height="10">
    <td> </td>
  </tr>
  <tr>
    <td align="center" style = "background:#FFFAEB80">
    <input type="text" style="font-size:27px; font-family:Microsoft JhengHei; text-align:center;" name="vCode" size="13" maxlength="4" placeholder="請輸入驗證碼">&nbsp;&nbsp;
	</td>
  </tr>
    <tr style = "background:#FFFAEB80" height="10">
    <td> </td>
  </tr>
  <tr style = "background:#FFFAEB80" height="100">
    <td align="center">
      <input type="submit" name="Submit" style="background: url(Login2圖片/login.png); width:86px; height:49px; text-align:center; border:0px" value=""><br>
	  <a href = "register.php"><font size = "3" face = "Microsoft JhengHei" color="black">註冊新帳號</font></a>
    </td>
  </tr>
  </table>
  </form>
  </td>
</tr>
</table>
</div>
<?php if (!empty($ErrMsg)) echo $ErrMsg; ?>
</body>
</html>