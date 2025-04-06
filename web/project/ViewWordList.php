<?php

// Authentication 認證
session_start();
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

//$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' AND valid='Y'";
$userid = $_SESSION['UserId'];
//echo $userid;
$sqlcmd = "SELECT * FROM Word WHERE UserId='$userid'";
$rs = querydb($sqlcmd, $db_conn);

$UserId = $rs[0]['UserId'];

$ItemPerPage = 20;
$PageTitle = '單位人員資訊系統示範';
require_once("css.html");
require_once("../include/header.php");


$sqlcmd = "SELECT count(*) AS reccount FROM Word ";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['CurPage'])) $Page = $_SESSION['CurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
if(!isset($Page)||$Page<1) $Page =1;
$_SESSION['CurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;
$sqlcmd = "SELECT * FROM Word WHERE UserId='$userid'"
    . "LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
?>
<body>
<?php require_once("header.html");?>
<?php
	if(!isset($Set))
		$Set = 1;
?>

<div>
<Script Language="JavaScript">
<!--
function confirmation(DspMsg, PassArg) {
var name = confirm(DspMsg)
    if (name == true) {
      location=PassArg;
    }
}
-->
</SCRIPT>
<div id="logo">單字表</div>

<table border="0" width="90%" align="center" cellspacing="0"
  cellpadding="2">
<tr>
  <td width="50%" align="left">
<?php if ($TotalPage > 1) { ?>
<form name="SelPage" method="POST" action="">
  第<select name="Page" onchange="submit();">
<?php 
for ($p=1; $p<=$TotalPage; $p++) { 
    echo '  <option value="' . $p . '"';
    if ($p == $Page) echo ' selected';
    echo ">$p</option>\n";
}
?>
  </select>頁 共<?php echo $TotalPage ?>頁
</form>
<?php } ?>

<td>
  <td align="center" width="50%">
	<div>排序方式：
	<form method="POST" action="">
		<select name="Set" onchange="submit();">
		<?php
			
			for($n=1;$n<=2;$n++)
			{
				echo '<option value="' . $n . '"';
				if($n==$Set)
				{
					
					echo 'selected';
					
				}
				
				switch($n){
					case 1:
						echo '>' .'依照編號排序'. '</option>';
					case 2:
						echo '>' .'依照錯誤次數排序'. '</option>';
				}
				
				
			}
			
		?>
		
		
		
			
		</select>
		
		

	
	</form>
	
	</div>
  </td>
</tr>  
</table>
<table class="mistab" width="50%" align="center">
<tr align="center">
  <th width="10%">編號</th>
  <th width="10%">英文</th>
  <th width="10%">中文</th>
  <th width="5%">錯誤次數</th>
 
</tr>
<?php
if($Set==1)
{
	$num = 1;
	foreach ($Contacts AS $item) {
	  //$WordId = $item['WordId'];
	  $WordId = $num;
	  $EngWord = $item['English'];
	  $ChiWord = $item['Chinese'];
	  $WrongTime = $item['WrongTime']; 
	  $num++;

  
  
?>
  <tr align="center">
  <td><?php echo $WordId ?></td>   
  <td><?php echo $EngWord ?></td> 
  <td><?php echo $ChiWord ?></td> 
  <td><?php echo $WrongTime ?></td>      
  </tr>
<?php
}
}

if($Set==2)
{
	$tempA = array();
	$tempW = array();
	$num = 1;
	foreach ($Contacts AS $item) {
	  array_push($tempA, $num);
	  array_push($tempW, $item['WrongTime']);
	  $num++;
	}
	
	for($i=1;$i<count($tempW);$i++) {
	  $key = $tempW[$i];
	  $keyA = $tempA[$i];
	  $j = $i-1;
	  
	  while($j>=0 && $tempW[$j] < $key)
	  {
		  $tempA[$j+1] = $tempA[$j];
		  $tempW[$j+1] = $tempW[$j];
		  $j--;
	  }
	  $tempA[$j+1] = $keyA;
	  $tempW[$j+1] = $key;
	  //print_r($tempA);
	}
	
	for($i=0;$i<count($tempA);$i++)
	{
	  $WordId = $tempA[$i];
	  $EngWord = $Contacts[$tempA[$i]-1]['English'];
	  $ChiWord = $Contacts[$tempA[$i]-1]['Chinese'];
	  $WrongTime = $Contacts[$tempA[$i]-1]['WrongTime']; 
	  
	?>
  <tr align="center">
  <td><?php echo $WordId ?></td>   
  <td><?php echo $EngWord ?></td> 
  <td><?php echo $ChiWord ?></td> 
  <td><?php echo $WrongTime ?></td>      
  </tr>
<?php
	}
}

?>
</div>
</body>
</html>