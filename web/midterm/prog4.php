<?php
session_start();
unset($_SESSION['times']);
unset($_SESSION['wrongLog']);
function NumberGen()
{
	$arrNumber = array();
	$arrNumber[0] = rand(3, 9);
	for ($i = 1; $i <= 1; $i++) {
		while (1) {
			$n = rand(3, 9);
			if (!in_array($n, $arrNumber)) {
				$arrNumber[$i] = $n;
				break;
			}
		}
	}
	return $arrNumber;
}
function ABCompare($MyNumber, $YourNumber)
{
	$A = $B = 0;
	for ($i = 0; $i < 2; $i++) {
		$n = $YourNumber[$i];
		if (in_array($n, $MyNumber)) {
			if ($n == $MyNumber[$i]) $A++;
			else $B++;
		}
	}
	$ans = $A . 'V' . $B . 'X';
	return $ans;
}

if (isset($_POST['retry'])) {
	session_destroy();
	session_start();
	$_SESSION['time'] = 0;
}
if (isset($_SESSION['my'])) {
	$arrNumber = $_SESSION['my'];
} else {
	$arrNumber = NumberGen();
	$_SESSION['my'] = $arrNumber;
	$_SESSION['time'] = 0;
}
$yGuess = '';
$Legal = True;
if (isset($_POST['send']) && !empty($_POST['send'])) {
	if (isset($_POST['num1'])) $yGuess = $_POST['num1'];
	if (strlen($yGuess) == 2 && is_numeric($yGuess)) {
		if (is_numeric($yGuess)) {
			$arrYourNumber = array();
			for ($i = 0; $i < 2; $i++) {
				$arrYourNumber[$i] = substr($yGuess, $i, 1);
			}
			$Legal = TRUE;
			if ($arrYourNumber[0] == $arrYourNumber[1]) {
						$Legal = FALSE;
						$_SESSION['wrongLog'] = "輸入數字有重複";
			}
			for ($x = 0; $x < 2; $x++) {
				if ($arrYourNumber[$x] <=2) {
					$Legal = FALSE;
					$_SESSION['wrongLog'] = "輸入數字超出範圍";
					if ($arrYourNumber[0] == $arrYourNumber[1]) {
					$Legal = FALSE;
					$_SESSION['wrongLog'] = "輸入數字有重複.輸入數字超出範圍";
					}
				}
			}
			if ($Legal === TRUE) {
				$yGuess = $arrYourNumber;
				$time = $_SESSION['time'];
				$_SESSION['time'] = $time + 1;
			}
		}
	} else {
		$Legal = FALSE;
		if (strlen($yGuess) != 2) $_SESSION['wrongLog'] = "請輸入2位數";
		if (!is_numeric($yGuess)) $_SESSION['wrongLog'] = "請輸入數字";
	}
}
?>
<html>

<head>
	<meta HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
	<meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
	<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.6">
	<title>Prog4</title>
</head>

<body>
	<div style="text-align:center;width:100%;border: 5px double white;font-size:33px;margin:10px auto;background-color:#204969;padding:10px;color:#dadada;">
		I3A43 Prog4
	</div>
	<div style="text-align:center;margin:20px 0 6px;border: 5px dotted black;background-color:#09ffc8;color:black">
		<form action="" method="POST">
			<b>請輸入四位數字(3-9)：</b><input type="text" name="num1">
			<input type="submit" value="送出" name="send">
			<input type="submit" value="再玩一次" name="retry">
		</form>
		<span style="margin:20px 0 6px;font-size:20px;">
			<?php
			if (!empty($arrNumber)) {
				echo '<b>正確答案:</b>' . $arrNumber[0] . $arrNumber[1]. '<br>';
				if (!empty($yGuess) && $Legal == true) {
				echo '<b>你猜的數字:</b>' . $yGuess[0] . $yGuess[1]. '<br>';
				$time++;
				$answer = ABCompare($arrNumber, $yGuess);
				if ($answer == "2V0X") echo '<b style="color:red;">你答對了</b>';
				else {
					echo '<b style="color:blue;">';
					print_r($answer);
					echo '</b>';
				}
				echo '<br>';
			} else if ($Legal == False) {
				if (isset($_SESSION['wrongLog'])) echo '<b style="color:red;">'.$_SESSION['wrongLog'].'</b><br>';
			}
			if(!isset($_SESSION['history']))$_SESSION['history']=array();
			if(!isset($_SESSION['times']))$_SESSION['times']=array();
			if(!empty($answer))array_push($_SESSION['times'],$yGuess[0],$yGuess[1],$answer,$_SESSION['wrongLog']);
			else array_push($_SESSION['times'],$yGuess[0],$yGuess[1],$_SESSION['wrongLog']);
			array_push($_SESSION['history'], $_SESSION['times']);
			if(isset($_SESSION['history'])){
				echo "歷史紀錄：<br>";
				for($i=0;$i<count($_SESSION['history']);$i++){
					for($j = 0 ; $j < count($_SESSION['history'][$i]) ; $j++) {
						echo $_SESSION['history'][$i][$j];
						if($j>0)echo ' ';
				   }
				   echo '<br>';
				}
			}
			}
			if (isset($_SESSION['time'])) echo '<br><b style="color:black;">猜測次數:' . $_SESSION['time'] . '</b>';
			?>
		</span>
	</div>
</body>
<footer style="text-align:center;margin:30px 0 6px;"><a href="index.php">回目錄</a><br /></footer>

</html>