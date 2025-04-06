
<html>
<head>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
<meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.6">
<title>I4010 網頁程設</title>
</head>

<body>
<div style="text-align:center;width:60%;border: 5px double;font-size:33px;margin:10px auto;background-color:rgb(205, 220, 252);padding:10px;">
I4010 網頁程式設計與安全實務
</div>
<div style="text-align:center;margin:30px 0 6px;">
<form method="POST" action="">
<select name="SelMonth" onchange="">
<?php
	for($m=1;$m<=12;$m++){
		echo '<option value="'.$m.'"';
		if ($m==$SelMonth)echo 'seleted';
		echo ">".$m."月</options>";
	}
?>
</select>
</form>
</div>
</body>
<footer style="text-align:center;margin:30px 0 6px;"><a href="index.php">回目錄</a><br /></footer>
</html>