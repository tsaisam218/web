<?php
	session_start();
	function distance($x, $y){
		return (sqrt($x*$x+$y*$y));
	}
	function isInside($x, $y){
		$Inside = FALSE;
		if($y<=($x*$x)) $Inside = TRUE;
		return $Inside;
	}
	if(!isset($_SESSION['InCount'])) $_SESSION['InCount'] = 0;
	if(!isset($_SESSION['LCount'])) $_SESSION['LCount'] = 0;
	$InsideCount = 0;
	$LoopCount = 10000;
	for($i=0;$i<$LoopCount;$i++){
		$x = mt_rand(0, 1000000)/1000000;
		$y = mt_rand(0, 1000000)/1000000;
		if(isInside($x, $y))$InsideCount++;
	}
	$InsideCount +=$_SESSION['InCount'];
	$LoopCount += $_SESSION['LCount'];
	$_SESSION['InCount']=$InsideCount;
	$_SESSION['LCount']=$LoopCount;
	$Area = $InsideCount/$LoopCount;
	$PI = $Area*4;
?>
<html>
<head>
<META HTTP-EQUIV="Refresh" CONTENT="2">
<title>網頁程式範例首頁</title>
</head>
<body>
<div style="text-align:center;margin-top:20px;font-size:30px;font-weight:bold;">
I4010 網頁程式設計與安全實務</div>
<div style="text-align:center;margin-top:60px;font-size:20px;">
計算拋物線與x軸之面積<br/><br/>
<?php
echo '面積 = '.$Area;
?>
</div>
</body>
<footer style="text-align:center;margin:30px 0 6px;"><a href="index.php">回目錄</a><br /></footer>
</html>