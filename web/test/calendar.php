<?php
$curYear = date('Y');
$minYear = $curYear - 10;
$maxYear = $curYear + 10;
if (isset($_GET['Y']) && is_numeric($_GET['Y']) 
        && $_GET['Y']>=$minYear && $_GET['Y']<=$maxYear) {
    $Y = $_GET['Y'];
} else {
    $Y = date('Y');
}

if (!isset($_GET['M']) || !is_numeric($M)) $M = date('n');
else $M = $_GET['M'];
if ($M<1 || $M>12) $M = date('n');
$FirstDate = 1;
$LastDate = date('j', mktime(0,0,0,$M+1,0,$Y));
$ShowDate = array();
for ($i=0; $i<6; $i++)
    for ($j=0; $j<7; $j++)
        $ShowDate[$i][$j] = '';
$r = 0;
for ($d=1; $d<=$LastDate; $d++) {
    $w = date('w',mktime(0,1,0,$M,$d,$Y));
    $ShowDate[$r][$w] = $d;
    if ($w==6) $r++;
}
$Month = date('F',mktime(0,1,0,$M,1,$Y));
$LastRow = 5;
if (empty($ShowDate[5][0])) $LastRow = 4;
if (empty($ShowDate[4][0])) $LastRow = 3;
?>
<html>
<head>
	  <title>網頁程式月曆範例</title>
</head>
<body>
<div style="text-align:center;margin-top:20px;font-size:30px;font-weight:bold;">
	I4010 網頁程式設計與安全實務 - 月曆
</div>
<div style="text-align:center;margin-top:20px;font-size:24px;">
Instructor
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
for ($r=0; $r<=$LastRow; $r++) {
?>
<tr align="center">
<?php
    for($i=0; $i<7; $i++) {
	$Date = $ShowDate[$r][$i];
	$BgColor = '';
	if (!empty($Date)) {
	    $xDate = date('Ymd', mktime(0,1,0,$M,$Date,$Y));
	    if ($xDate==date('Ymd')) 
	        $BgColor = ' bgcolor="#AAAAEE"';
	}
        if ($i==0) 
	    $Date = '<span style="color:red">' . $Date . '</span>'; 
        if ($i==6) 
	    $Date = '<span style="color:orange">' . $Date . '</span>'; 


?>
  <td<?php echo $BgColor; ?>><?php echo $Date; ?></td>
<?php } ?>
</tr>

<?php } ?>
</table>
</div>
</body>
</html>

