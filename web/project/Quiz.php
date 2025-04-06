<?php
session_start();

// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$UserId = $_SESSION['UserId'];

if (isset($_POST['send'])) {
    $correct = 0;
    $wrong = 0;
    for ($i = 0; $i < count($_SESSION['ans']); $i++) {
        if ($_POST[$i] == $_SESSION['ans'][$i]) {
            $correct++;
        } else {
            $wrong++;
        }
    }
    //新增主資料
    $sqlcmd = 'INSERT INTO Quiz_master (UserId, Correct, Wrong) VALUES ('
        . "'$UserId','$correct','$wrong')";
    $rs = querydb($sqlcmd, $db_conn);

    //新增附資料
    $sqlcmd = 'select * from Quiz_master order by QuizNo desc limit 1';
    $rs = querydb($sqlcmd, $db_conn);

    $quizNo = $rs[0]['QuizNo'];

    $wordId = $_SESSION['que'];
    $userAns = $_SESSION['ans'];
    $detail = $_SESSION['detail'];
    $type = $_SESSION['type'];

    for ($i = 0; $i < count($_SESSION['ans']); $i++) {
        $user_Ans = $detail[$i][$_POST[$i]];
        $word = $wordId[$i];
        if ($_POST[$i] == $_SESSION['ans'][$i]) {
            $sqlcmd = 'INSERT INTO Quiz_detail (QuizNo, WordId, IsCorrect, UserAns, Type) VALUES ('
                . "'$quizNo','$word', true,'$user_Ans', '$type[$i]')";
            $rs = querydb($sqlcmd, $db_conn);
        } else {
            $sqlcmd = 'INSERT INTO Quiz_detail (QuizNo, WordId, IsCorrect, UserAns, Type) VALUES ('
                . "'$quizNo','$word', false,'$user_Ans', '$type[$i]')";
            $rs = querydb($sqlcmd, $db_conn);
            $sqlcmd = "UPDATE Word SET WrongTime=WrongTime+1 WHERE WordId='$word'";
            $rs = querydb($sqlcmd, $db_conn);
        }
    }
    header ("Location: showQuiz.php");
}

unset($_SESSION['que']);
unset($_SESSION['ans']);
unset($_SESSION['detail']);
unset($_SESSION['type']);
$sqlcmd = "SELECT * FROM Word WHERE UserID='$UserId'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die('Unknown or invalid user!');
$wordSize = count($rs);

$wordAarr=array();
for($i=0;$i<$wordSize;$i++){
    $wordArr[$i] =  $rs[$i]['WordId'];
}

if ($wordSize < 5) {
    $quizSize = $wordSize;
} else {
    $quizSize = 5;
}
require_once("css.html");
require_once("../include/header.php");
?>

<html>

<body>
<?php require_once("header.html"); ?>
    <div>
        <div id="logo">單字測驗</div>
        <div id="quiz" style="text-align:center;">
            <?php
            //question
            $quesAlready = array();
            echo '<form action="" method="post">';
            $ansArray = array();
            $typeArray = array();
            $detailArray = array();
            for ($i = 0; $i < $quizSize; $i++) {
                $typeRandom = (bool)rand(0, 1);
                $quesRandom = (int)rand(0, $wordSize - 1);
                $option = array("A", "B", "C");
                echo '<div id="number" style="text-align:center;font-size:20px;color:blue;">';
                echo '第' . ($i + 1) . '題';
                echo '</div>';
                //中轉英
                if ($typeRandom === true) {
                    $typeArray[$i] = '1';
                    while (in_array($quesRandom, $quesAlready)) {
                        $quesRandom = (int)rand(0, $wordSize - 1);
                    }
                    $quesAlready[$i] = $wordArr[$quesRandom];
                    echo $rs[$quesRandom]['Chinese'];
                    //option
                    $ansAlready = array();
                    echo '<div id="option" style="text-align:center;">';
                    $posRandom = (int)rand(0, 2);
                    for ($j = 0; $j < 3; $j++) {
                        if ($j == $posRandom) {
                            $ansArray[$i] = $j;
                            $detailArray[$i][$j] = $rs[$quesRandom]['English'];
                            echo '<input type="radio" name="' . $i . '" value="' . $j . '">';
                            echo $option[$j] . '.' . $rs[$quesRandom]['English'] . "\t";
                        } else {
                            $optionRandom = (int)rand(0, $wordSize - 1);
                            while (in_array($optionRandom, $ansAlready) || $optionRandom == $quesRandom) {
                                $optionRandom = (int)rand(0, $wordSize - 1);
                            }
                            $ansAlready[$j] = $optionRandom;
                            $detailArray[$i][$j] = $rs[$optionRandom]['English'];
                            echo '<input type="radio" name="' . $i . '" value="' . $j . '">';
                            echo $option[$j] . '.' . $rs[$optionRandom]['English'] . "\t";
                        }
                    }
                    echo '</div>';
                }
                //英轉中
                else {
                    $typeArray[$i] = '0';
                    while (in_array($quesRandom, $quesAlready)) {
                        $quesRandom = (int)rand(0, $wordSize - 1);
                    }
                    $quesAlready[$i] = $wordArr[$quesRandom];
                    echo $rs[$quesRandom]['English'];
                    //option
                    $ansAlready = array();
                    echo '<div id="option" style="text-align:center;">';
                    $posRandom = (int)rand(0, 2);
                    for ($j = 0; $j < 3; $j++) {
                        if ($j == $posRandom) {
                            $ansArray[$i] = $j;
                            $detailArray[$i][$j] = $rs[$quesRandom]['Chinese'];
                            echo '<input type="radio" name="' . $i . '" value="' . $j . '">';
                            echo $option[$j] . '.' . $rs[$quesRandom]['Chinese'] . "\t";
                        } else {
                            $optionRandom = (int)rand(0, $wordSize - 1);
                            while (in_array($optionRandom, $ansAlready) || $optionRandom == $quesRandom) {
                                $optionRandom = (int)rand(0, $wordSize - 1);
                            }
                            $ansAlready[$j] = $optionRandom;
                            $detailArray[$i][$j] = $rs[$optionRandom]['Chinese'];
                            echo '<input type="radio" name="' . $i . '" value="' . $j . '">';
                            echo $option[$j] . '.' . $rs[$optionRandom]['Chinese'] . "\t";
                        }
                    }
                    echo '</div>';
                }
            }
            $_SESSION['ans'] = $ansArray;
            $_SESSION['type'] = $typeArray;
            $_SESSION['que'] = $quesAlready;
            $_SESSION['detail'] = $detailArray;
            echo '<input type="submit" value="交卷" name="send">';
            echo '</form>';
            ?>
        </div>
    </div>
</body>

</html>

<!--footer-->
<?php if (isset($ErrMsg) && !empty($ErrMsg)) { ?>
    <script type="text/javascript">
        alert('<?php echo $ErrMsg; ?>');
    </script>
<?php } ?>
<?php if (!isset($Program)) $Program = '網頁程設'; ?>
<div style="width:100%;text-align:center;background:#ffe6e6;margin-top:8px;
font-weight:bold;font-size:18px;color:#5e595c;padding:2px 0;">
    <?php echo $Program; ?> 期末專題
</div>