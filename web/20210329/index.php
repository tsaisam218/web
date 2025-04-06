<html>
<head>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
<meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.6">
<title>I4010 網頁程設</title>
</head>

<?php
$PassVars = array();
if (isset($_POST) && count($_POST) > 0) $PassVars = $_POST;
$num1= '';
$Check1 = array();
if (count($PassVars) > 0) extract($PassVars, EXTR_OVERWRITE);
?>

<body>
<div style="text-align:center;width:60%;border: 5px double;font-size:33px;margin:10px auto;background-color:rgb(205, 220, 252);padding:10px;">
I4010 網頁程式設計與安全實務
</div>
<div style="text-align:center;margin:30px 0 6px;">
<form method="POST" action="">
<select name="number" onchange="">
<?php
	for($num=1;$num<=9;$num++){
		echo '<option value="'.$num.'"';
		//if ($num==$number)echo 'seleted';
		echo ">".$num."</options>";
	}
	echo '<input type="submit" value="送出">';
	echo "<br>";
?>
<?php if (count($_POST) > 0) { ?>
            <span style="margin:20px 0 6px;font-size:20px;">
                <?php
                $num1 = $_POST['number'];
                for($i=1;$i<10;$i++){
					echo $num1."*".$i."=".$num1*$i."<br>";
				}
                ?>
            </span>
        <?php } ?>
</select>
</form>
</div>
</body>
<footer style="text-align:center;margin:30px 0 6px;"><a href="../index.php">回目錄</a><br /></footer>
</html>