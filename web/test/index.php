<html>

<head>
    <title>I4010首頁</title>
</head>
<?php
$PassVars = array();
if (isset($_POST) && count($_POST) > 0) $PassVars = $_POST;
$Rad1 = $Rad2 = $T1 = $T2 = '';
$Check1 = array();
if (count($PassVars) > 0) extract($PassVars, EXTR_OVERWRITE);

?>

<body>
    <div style="text-align:center;margin-top:50px;font-size:30px;font-weight:bold;">
        I4010 網頁程式設計與安全實務
    </div>
    <?php if (count($PassVars) > 0) { ?>
        <div style="margin:10px auto;width:600px;">
            <?php print_r($PassVars); ?>
        </div>
    <?php } ?>
    <p>This is a sample HTML page. This is a test paragraph.</p>
    Even though in
    the source file,
    the line is in &amp;
    the next line,<br />
    it will append to the&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;back of the previous line. HAHA
    <h1>標題</h1>

    <div style="text-align:center;margin-top:20px;font-size:20px;font-family:標楷體;font-weight:bold;">
        標題
    </div>
    <div style="text-align:center;font-size:20px;font-family:標楷體;">
        比較組<?php echo date('Y-m-d'); ?>
    </div>
    <table border="1" align="center" width="600">
        <tr>
            <th width="20%">欄位1</th>
            <th width="250">欄位2</th>
            <th>欄位3</th>
        </tr>
        <tr align="right">
            <td align="center" rowspan="2">aaa</td>
            <td>bbb</td>
            <td align="left">Left aligned</td>
        </tr>
        <tr align="right">
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    <form method="POST">
        <input type="text" name="T1" value="<?php echo $T1; ?>">
        <input type="text" name="T2" value="<?php echo $T2; ?>"><br />
        <input type="submit" name="Send" value="Send">&nbsp;&nbsp;
        <input type="submit" name="Abort" value="Abort"><br />
        <input type="radio" name="Rad1" value="1" <?php if ($Rad1 == '1') echo ' checked'; ?>>1
        <input type="radio" name="Rad1" value="2" <?php if ($Rad1 == '2') echo ' checked'; ?>>2<br />
        <input type="radio" name="Rad2" value="1" <?php if ($Rad2 == '1') echo ' checked'; ?>>1
        <input type="radio" name="Rad2" value="2" <?php if ($Rad2 == '2') echo ' checked'; ?>>2<br />
        <input type="checkbox" name="Check1[]" value="A">A
        <input type="checkbox" name="Check1[]" value="B">B
        <input type="checkbox" name="Check1[]" value="C">C
        <input type="checkbox" name="Check1[]" value="D">D
    </form>
</body>

</html>