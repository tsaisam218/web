<?php
session_start();
require_once("../include/gpsvars.php");
$ErrMsg = "";
$SucMsg = "";
$flag = 0;
$flag2 = 0;
if (!isset($ID)) $ID = "";
if (!isset($PWD)) $PWD = "";
/////////////////////////////////////
$AccountCheck = "/^[a-zA-Z0-9]{3,16}$/";
//$AccountCheck2 = "/^[a-zA-Z]$/";
//$AccountCheck3 = "/^[0-9]$/";
/////////////////////////////////////
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
	if(!(strlen($PWD) >= 3 && strlen($PWD) <= 16)) $ErrMsg = '<font color="RED">密碼格式錯誤</font>';
	if(empty($PWD)) $ErrMsg = '<font color="RED">密碼不可為空白</font>';
	if(strlen($PWD) >= 3 && strlen($PWD) <= 16) $PWD = sha1($PWD);
    if (!(strlen($ID) >= 3 && strlen($ID) <= 16) || (!preg_match($AccountCheck, $ID))) $ErrMsg = '<font color="RED">帳號格式錯誤</font>';
	if(empty($ID)) $ErrMsg = '<font color="RED">帳號不可為空白</font>';
	if(empty($ErrMsg)){
		$sqlcmd = "SELECT Account FROM User2 WHERE Account='$ID'";
		$rs = querydb($sqlcmd, $db_conn);
        if(empty($rs)){
			$sqlcmd2 = "INSERT INTO User2 (Account, Password) VALUES (" . "?, ?)";
			$rsi = $db_conn->prepare($sqlcmd2);
			$rsi->execute(array($ID, $PWD));
			$rsi->fetchALL(PDO::FETCH_ASSOC);
print_r($rsi);
			$SucMsg = '<font color="GREEN">帳號註冊成功</font>';
		}
		else{
			$ErrMsg = '<font color="Red">'
			. '此帳號已有人使用 請更換帳號</font>';
		}
	}
}
$_SESSION['VerifyCode'] = mt_rand(1000,9999);
?>
<?php
    
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
    <td align="center" style = "font-size:50px; font-family:Microsoft JhengHei"><b>英文單字測驗系統<br>註冊頁面</b>
    </td>
  </tr>
  <tr style = "background:#FFFAEB80" height="35">
    <td align="center", style = "font-size:27px; font-family:Microsoft JhengHei"><b>帳號</b><br>
      <input type="text" style="font-size:27px; font-family:Microsoft JhengHei" name="ID" size="20" maxlength="16"
        value="<?php echo $ID; ?>" placeholder="3~16字元 英數字混合"class="pwdtext">
    </td>
  </tr>
  <tr style = "background:#FFFAEB80" height="10">
    <td> </td>
  </tr>
  <tr style = "background:#FFFAEB80" height="35">
    <td align="center", style = "font-size:27px; font-family:Microsoft JhengHei"><b>密碼</b><br>
     <input type="password" style="font-size:27px; font-family:Microsoft JhengHei" name="PWD" size="20" maxlength="16" placeholder="3~16字元" class="pwdtext">
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
      <input type="submit" name="Submit" style="background: url(Login2圖片/register.png); width:86px; height:49px; text-align:center; border:0px" value=""><br>
	  <a href = "login2.php"><font size = "3" face = "Microsoft JhengHei" color="black">已有帳號? 登入</font></a>
    </td>
  </tr>
  </table>
  </form>
  </td>
</tr>
</table>
</div>
<?php if (!empty($ErrMsg)) echo $ErrMsg; 
      else{echo $SucMsg;}
?>
</body>
</html>