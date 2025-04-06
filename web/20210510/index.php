<?php
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$sqlcmd = "SELECT * FROM namelist WHERE cid= :cid";
$statement = $db_conn->prepare($sqlcmd);
//$rs = querydb($sqlcmd, $db_conn);
$statement->execute(array('cid' => $CID));
print_r($statement->fetchALL(PDO::FETCH_ASSOC));
//print_r($rs);
require_once('../include/header.php');
?>
<body>
<div style="margin-top:60px;text-align:center;">
<form method="POST" action="">
用戶編號：<input type="text" name="CID" size="16" maxlength="16">&nbsp;&nbsp;
<input type="submit" name="Submit" value="查詢">
</form>
</body>
</html>