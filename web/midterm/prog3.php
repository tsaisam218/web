<?php
$curYear = date('Y');
$minYear = $curYear - 11;
$maxYear = $curYear + 9;
if (
    isset($_GET['Y']) && is_numeric($_GET['Y'])
    && $_GET['Y'] >= $minYear && $_GET['Y'] <= $maxYear
) {
    $Y = $_GET['Y'];
} else {
    $Y = date('Y');
}
if (isset($_POST['year'])) {
    $Y = $_POST['year'];
}
if (!isset($_GET['M']) || !is_numeric($M)) $M = date('n');
else $M = $_GET['M'];
if ($M < 1 || $M > 12) $M = date('n');
if (isset($_POST['mon'])) {
    $M = $_POST['mon'];
}
$FirstDate = 1;
$LastDate = date('j', mktime(0, 0, 0, $M + 1, 0, $Y));
$ShowDate = array();
for ($i = 0; $i < 6; $i++)
    for ($j = 0; $j < 7; $j++)
        $ShowDate[$i][$j] = '';
$r = 0;
for ($d = 1; $d <= $LastDate; $d++) {
    $w = date('w', mktime(0, 1, 0, $M, $d, $Y));
    $ShowDate[$r][$w] = $d;
    if ($w == 6) $r++;
}
$Month = date('F', mktime(0, 1, 0, $M, 1, $Y));
$LastRow = 5;
if (empty($ShowDate[5][0])) $LastRow = 4;
if (empty($ShowDate[4][0])) $LastRow = 3;
?>
<html>

<head>
    <title>Prog3</title>
</head>

<body>
    <div style="text-align:center;margin-top:20px;font-size:30px;font-weight:bold;">
        I3A43 Prog3
    </div>
    <div style="text-align:center;margin-top:20px;font-size:24px;">
        <form method="POST" action="">
            <select onchange="" name="mon">
                <?php
                for ($num = 1; $num <= 12; $num++) {
                    echo '<option value="' . $num . '"';
                    if ($num == $M) echo 'selected';
                    echo ">" . $num . "月</options>";
                }
                echo '<input type="submit" value="送出">';
                echo "<br>";
                ?>
            </select>
        </form>
    </div>
    <div style="text-align:center;margin-top:20px;">
        <?php echo $Month . ' ' . $Y; ?>
        <table border="1" align="center">
            <tr align="center">
                <td width="25">Sun</td>
                <td width="25">Mon</td>
                <td width="25">Tue</td>
                <td width="25">Wed</td>
                <td width="25">Thu</td>
                <td width="25">Fri</td>
                <td width="25">Sat</td>
            </tr>
            <?php
            for ($r = 0; $r <= $LastRow; $r++) {
            ?>
                <tr align="center">
                    <?php
                    for ($i = 0; $i < 7; $i++) {
                        $Date = $ShowDate[$r][$i];
                        $BgColor = '';
                        $month='';
                        if (!empty($Date)) {
                            date_default_timezone_set('Asia/Taipei');
                            $xDate = date('Ymd', mktime(0, 1, 0, $M, $Date, $Y));
                            if ($xDate == date('Ymd'))
                                $BgColor = ' bgcolor="#AAAAEE"';
							if($M==1&&$Date==5)$month='小寒';
							if($M==1&&$Date==20)$month='大寒';
							if($M==2&&$Date==3)$month='立春';
							if($M==2&&$Date==18)$month='雨水';
							if($M==3&&$Date==5)$month='驚蟄';
							if($M==3&&$Date==20)$month='春分';
							if($M==4&&$Date==4)$month='清明';
							if($M==4&&$Date==20)$month='穀雨';
							if($M==5&&$Date==5)$month='立夏';
							if($M==5&&$Date==21)$month='小滿';
							if($M==6&&$Date==5)$month='芒種';
							if($M==6&&$Date==21)$month='夏至';
							if($M==7&&$Date==7)$month='小暑';
							if($M==7&&$Date==22)$month='大暑';
							if($M==8&&$Date==7)$month='立秋';
							if($M==8&&$Date==23)$month='處暑';
							if($M==9&&$Date==7)$month='白露';
							if($M==9&&$Date==23)$month='秋分';
							if($M==10&&$Date==8)$month='寒露';
							if($M==10&$Date==23)$month='霜降';
							if($M==11&$Date==7)$month='立冬';
							if($M==11&$Date==22)$month='小雪';
							if($M==12&$Date==7)$month='大雪';
							if($M==12&$Date==21)$month='冬至';
                        }
                        if ($i == 0)
                            $Date = '<span style="color:red">' . $Date . '<br>' .$month.'</span>';
                        if ($i == 6)
                            $Date = '<span style="color:orange">' . $Date . '<br>' .$month.  '</span>';
                        if($i<6&&$i>0)
                            $Date = '<span style="color:black">' . $Date . '<br>' .$month.  '</span>';

                    ?>
                        <td<?php echo $BgColor; ?>><?php echo $Date;?>
                            </td>
                        <?php } ?>
                </tr>

            <?php } ?>
        </table>
    </div>
</body>
<footer style="text-align:center;margin:30px 0 6px;"><a href="index.php">回目錄</a><br /></footer>

</html>