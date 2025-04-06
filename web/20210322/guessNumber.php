<html>

<head>
    <meta HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
    <meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.6">
    <title>PHP 四則運算</title>
    <style>
        input {
            margin: 10px 0 6px;
            text-align: center;
        }
    </style>
</head>

<?php
$PassVars = array();
if (isset($_POST) && count($_POST) > 0) $PassVars = $_POST;
$num1 = $num2 = '';
$Check1 = array();
if (count($PassVars) > 0) extract($PassVars, EXTR_OVERWRITE);
?>

<body style="background-color:#fff7f7;">
    <div style="text-align:center;width:100%;border: 5px double white;font-size:33px;margin:10px auto;background-color:#204969;padding:10px;color:#dadada;">
        PHP 四則運算
    </div>
    <div style="text-align:center;margin:20px 0 6px;border: 5px dotted black;background-color:#09ffc8;color:black">
        <span>
            <form method="POST" action="" method="POST">
                <b>數字一：</b><input type="text" name="num1" max="100" min="0" value="<?php echo $num1; ?>">
                <b>數字二：</b><input type="text" name="num2" max="100" min="0" value="<?php echo $num2; ?>">
                <input type="submit" value="送出">
            </form>
        </span>
        <?php if (count($_POST) > 0) { ?>
            <span style="margin:20px 0 6px;font-size:20px;">
                <?php
                $num1 = $_POST['num1'];
                $num2 = $_POST['num2'];
                if (!is_numeric($num1) || !is_numeric($num2)) {
                    echo "※請輸入0~100間的數字※";
                } else if ($num1 > 100 || $num2 > 100) {
                    echo "※請輸入0~100間的數字※";
                } else {
                    $plus = $num1 + $num2;
                    $minus = $num1 - $num2;
                    $divide = $num1 / $num2;
                    $product = $num1 * $num2;
                    echo $num1 . " + " . $num2 . " = " . $plus . "<br>";
                    echo $num1 . " - " . $num2 . " = " . $minus . "<br>";
                    echo $num1 . " * " . $num2 . " = " . $product . "<br>";
                    if ($num2 == 0) echo $num1 . " / " . $num2 . " = undefined<br>";
                    else echo $num1 . " / " . $num2 . " = " . round($divide, 1) . "<br>";
                }
                ?>
            </span>
        <?php } ?>
    </div>
</body>
<footer style="text-align:center;margin:30px 0 6px;"><a href="index.php">回目錄</a><br /></footer>

</html>