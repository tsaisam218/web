<?php
class Lunar
{
    const MIN_YEAR = 1891;
    const MAX_YEAR = 2100;

    const LUNAR_INFO = [
        [0, 2, 9, 21936], [6, 1, 30, 9656], [0, 2, 17, 9584], [0, 2, 6, 21168], [5, 1, 26, 43344], [0, 2, 13, 59728],
        [0, 2, 2, 27296], [3, 1, 22, 44368], [0, 2, 10, 43856], [8, 1, 30, 19304], [0, 2, 19, 19168], [0, 2, 8, 42352],
        [5, 1, 29, 21096], [0, 2, 16, 53856], [0, 2, 4, 55632], [4, 1, 25, 27304], [0, 2, 13, 22176], [0, 2, 2, 39632],
        [2, 1, 22, 19176], [0, 2, 10, 19168], [6, 1, 30, 42200], [0, 2, 18, 42192], [0, 2, 6, 53840], [5, 1, 26, 54568],
        [0, 2, 14, 46400], [0, 2, 3, 54944], [2, 1, 23, 38608], [0, 2, 11, 38320], [7, 2, 1, 18872], [0, 2, 20, 18800],
        [0, 2, 8, 42160], [5, 1, 28, 45656], [0, 2, 16, 27216], [0, 2, 5, 27968], [4, 1, 24, 44456], [0, 2, 13, 11104],
        [0, 2, 2, 38256], [2, 1, 23, 18808], [0, 2, 10, 18800], [6, 1, 30, 25776], [0, 2, 17, 54432], [0, 2, 6, 59984],
        [5, 1, 26, 27976], [0, 2, 14, 23248], [0, 2, 4, 11104], [3, 1, 24, 37744], [0, 2, 11, 37600], [7, 1, 31, 51560],
        [0, 2, 19, 51536], [0, 2, 8, 54432], [6, 1, 27, 55888], [0, 2, 15, 46416], [0, 2, 5, 22176], [4, 1, 25, 43736],
        [0, 2, 13, 9680], [0, 2, 2, 37584], [2, 1, 22, 51544], [0, 2, 10, 43344], [7, 1, 29, 46248], [0, 2, 17, 27808],
        [0, 2, 6, 46416], [5, 1, 27, 21928], [0, 2, 14, 19872], [0, 2, 3, 42416], [3, 1, 24, 21176], [0, 2, 12, 21168],
        [8, 1, 31, 43344], [0, 2, 18, 59728], [0, 2, 8, 27296], [6, 1, 28, 44368], [0, 2, 15, 43856], [0, 2, 5, 19296],
        [4, 1, 25, 42352], [0, 2, 13, 42352], [0, 2, 2, 21088], [3, 1, 21, 59696], [0, 2, 9, 55632], [7, 1, 30, 23208],
        [0, 2, 17, 22176], [0, 2, 6, 38608], [5, 1, 27, 19176], [0, 2, 15, 19152], [0, 2, 3, 42192], [4, 1, 23, 53864],
        [0, 2, 11, 53840], [8, 1, 31, 54568], [0, 2, 18, 46400], [0, 2, 7, 46752], [6, 1, 28, 38608], [0, 2, 16, 38320],
        [0, 2, 5, 18864], [4, 1, 25, 42168], [0, 2, 13, 42160], [10, 2, 2, 45656], [0, 2, 20, 27216], [0, 2, 9, 27968],
        [6, 1, 29, 44448], [0, 2, 17, 43872], [0, 2, 6, 38256], [5, 1, 27, 18808], [0, 2, 15, 18800], [0, 2, 4, 25776],
        [3, 1, 23, 27216], [0, 2, 10, 59984], [8, 1, 31, 27432], [0, 2, 19, 23232], [0, 2, 7, 43872], [5, 1, 28, 37736],
        [0, 2, 16, 37600], [0, 2, 5, 51552], [4, 1, 24, 54440], [0, 2, 12, 54432], [0, 2, 1, 55888], [2, 1, 22, 23208],
        [0, 2, 9, 22176], [7, 1, 29, 43736], [0, 2, 18, 9680], [0, 2, 7, 37584], [5, 1, 26, 51544], [0, 2, 14, 43344],
        [0, 2, 3, 46240], [4, 1, 23, 46416], [0, 2, 10, 44368], [9, 1, 31, 21928], [0, 2, 19, 19360], [0, 2, 8, 42416],
        [6, 1, 28, 21176], [0, 2, 16, 21168], [0, 2, 5, 43312], [4, 1, 25, 29864], [0, 2, 12, 27296], [0, 2, 1, 44368],
        [2, 1, 22, 19880], [0, 2, 10, 19296], [6, 1, 29, 42352], [0, 2, 17, 42208], [0, 2, 6, 53856], [5, 1, 26, 59696],
        [0, 2, 13, 54576], [0, 2, 3, 23200], [3, 1, 23, 27472], [0, 2, 11, 38608], [11, 1, 31, 19176], [0, 2, 19, 19152],
        [0, 2, 8, 42192], [6, 1, 28, 53848], [0, 2, 15, 53840], [0, 2, 4, 54560], [5, 1, 24, 55968], [0, 2, 12, 46496],
        [0, 2, 1, 22224], [2, 1, 22, 19160], [0, 2, 10, 18864], [7, 1, 30, 42168], [0, 2, 17, 42160], [0, 2, 6, 43600],
        [5, 1, 26, 46376], [0, 2, 14, 27936], [0, 2, 2, 44448], [3, 1, 23, 21936], [0, 2, 11, 37744], [8, 2, 1, 18808],
        [0, 2, 19, 18800], [0, 2, 8, 25776], [6, 1, 28, 27216], [0, 2, 15, 59984], [0, 2, 4, 27424], [4, 1, 24, 43872],
        [0, 2, 12, 43744], [0, 2, 2, 37600], [3, 1, 21, 51568], [0, 2, 9, 51552], [7, 1, 29, 54440], [0, 2, 17, 54432],
        [0, 2, 5, 55888], [5, 1, 26, 23208], [0, 2, 14, 22176], [0, 2, 3, 42704], [4, 1, 23, 21224], [0, 2, 11, 21200],
        [8, 1, 31, 43352], [0, 2, 19, 43344], [0, 2, 7, 46240], [6, 1, 27, 46416], [0, 2, 15, 44368], [0, 2, 5, 21920],
        [4, 1, 24, 42448], [0, 2, 12, 42416], [0, 2, 2, 21168], [3, 1, 22, 43320], [0, 2, 9, 26928], [7, 1, 29, 29336],
        [0, 2, 17, 27296], [0, 2, 6, 44368], [5, 1, 26, 19880], [0, 2, 14, 19296], [0, 2, 3, 42352], [4, 1, 24, 21104],
        [0, 2, 10, 53856], [8, 1, 30, 59696], [0, 2, 18, 54560], [0, 2, 7, 55968], [6, 1, 27, 27472], [0, 2, 15, 22224],
        [0, 2, 5, 19168], [4, 1, 25, 42216], [0, 2, 12, 42192], [0, 2, 1, 53584], [2, 1, 21, 55592], [0, 2, 9, 54560],
    ];

    const DATE_HASH = [
        '',
        '一', '二', '三', '四', '五',
        '六', '七', '八', '九', '十',
    ];

    const MONTH_HASH = [
        '',
        '正月', '二月', '三月', '四月', '五月', '六月',
        '七月', '八月', '九月', '十月', '十一月', '十二月',
    ];

    const MONTH_DAYS = [
        31, -1, 31, 30, 31, 30,
        31, 31, 30, 31, 30, 31,
    ];

    /**
     * 將陽曆轉換為陰曆.
     *
     * @param int $year  公曆-年
     * @param int $month 公曆-月
     * @param int $date  公曆-日
     *
     * @return array
     */
    public function convertSolarToLunar(int $year, int $month, int $date): array
    {
        //debugger;
        $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
        if ($year === static::MIN_YEAR && $month <= 2 && $date <= 9) {
            return [1891, '正月', '初一', '辛卯', 1, 1, '兔'];
        }

        return $this->getLunarByBetween(
            $year,
            $this->getDaysBetweenSolar($year, $month, $date, $yearData[1], $yearData[2])
        );
    }

    public function convertSolarMonthToLunar(int $year, int $month): array
    {
        $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
        if ($year === static::MIN_YEAR && $month <= 2) {
            return [1891, '正月', '初一', '辛卯', 1, 1, '兔'];
        }

        $dd = $this->getSolarMonthDays($year, $month);
        if ($this->isLeapYear($year) && $month === 2) {
            ++$dd;
        }

        $lunar_ary = [];
        for ($i = 1; $i < $dd; ++$i) {
            $array = $this->getLunarByBetween(
                $year,
                $this->getDaysBetweenSolar($year, $month, $i, $yearData[1], $yearData[2])
            );
            $array[] = $year . '-' . $month . '-' . $i;
            $lunar_ary[$i] = $array;
        }

        return $lunar_ary;
    }

    /**
     * 判斷是否是閏年.
     *
     * @param int $year The year
     *
     * @return bool true if leap year, False otherwise
     */
    public function isLeapYear(int $year): bool
    {
        return ($year & 3 === 0 && $year % 100 !== 0) || ($year % 400 === 0);
    }

    /**
     * 獲取陽曆月份的天數.
     *
     * @param int $year  陽曆-年
     * @param int $month 陽曆-月
     *
     * @return int the solar month days
     */
    public function getSolarMonthDays(int $year, int $month): int
    {
        return $month === 2
            ? ($this->isLeapYear($year) ? 29 : 28)
            : static::MONTH_DAYS[$month];
    }

    /**
     * 獲取陰曆月份的天數.
     *
     * @param int $year  陰曆-年
     * @param int $month 陰曆-月，從一月開始
     *
     * @return int the lunar month days
     */
    public function getLunarMonthDays(int $year, int $month): int
    {
        return $this->getLunarMonths($year)[$month - 1];
    }

    /**
     * 獲取陰曆每月的天數的數組.
     *
     * @param int $year The year
     *
     * @return array the lunar months
     */
    public function getLunarMonths(int $year): array
    {
        $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
        $leapMonth = $yearData[0];
        $bit = decbin($yearData[3]);

        for ($i = 0; $i < strlen($bit); ++$i) {
            $bitArray[$i] = substr($bit, $i, 1);
        }

        for ($k = 0, $klen = 16 - count($bitArray); $k < $klen; ++$k) {
            array_unshift($bitArray, '0');
        }

        $bitArray = array_slice($bitArray, 0, ($leapMonth === 0 ? 12 : 13));
        for ($i = 0; $i < count($bitArray); ++$i) {
            $bitArray[$i] = $bitArray[$i] + 29;
        }

        return $bitArray;
    }

    /**
     * 獲取農曆每年的天數.
     *
     * @param int $year 農曆年份
     *
     * @return int the lunar year days
     */
    public function getLunarYearDays(int $year): int
    {
        $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
        $monthArray = $this->getLunarYearMonths($year);
        $len = count($monthArray);

        return $monthArray[$len - 1] === 0 ? $monthArray[$len - 2] : $monthArray[$len - 1];
    }

    /**
     * 獲取農曆每年的月數.
     *
     * @param int $year The year
     *
     * @return array the lunar year months
     */
    public function getLunarYearMonths(int $year): array
    {
        //debugger
        $monthData = $this->getLunarMonths($year);
        $res = [];
        $temp = 0;
        $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
        $len = ($yearData[0] === 0 ? 12 : 13);

        for ($i = 0; $i < $len; ++$i) {
            $temp = 0;
            for ($j = 0; $j <= $i; ++$j) {
                $temp += $monthData[$j];
            }
            $res[] = $temp;
        }

        return $res;
    }

    /**
     * 獲取閏月.
     *
     * @param int $year 陰曆年份
     *
     * @return int the leap month
     */
    public function getLeapMonth(int $year): int
    {
        return static::LUNAR_INFO[$year - static::MIN_YEAR][0];
    }

    /**
     * 計算陰曆日期與正月初一相隔的天數.
     *
     * @param int $year  The year
     * @param int $month The month
     * @param int $date  The date
     *
     * @return int the days between lunar
     */
    public function getDaysBetweenLunar(int $year, int $month, int $date): int
    {
        $yearMonth = $this->getLunarMonths($year);

        $res = 0;
        for ($i = 1; $i < $month; ++$i) {
            $res += $yearMonth[$i - 1];
        }
        $res += $date - 1;

        return $res;
    }

    /**
     * 計算2個陽曆日期之間的天數.
     *
     * @param int $year   陽曆年
     * @param int $cmonth The cmonth
     * @param int $cdate  The cdate
     * @param int $dmonth 陰曆正月對應的陽曆月份
     * @param int $ddate  陰曆初一對應的陽曆天數
     *
     * @return int the days between solar
     */
    public function getDaysBetweenSolar(int $year, int $cmonth, int $cdate, int $dmonth, int $ddate): int
    {
        $a = mktime(0, 0, 0, $cmonth, $cdate, $year);
        $b = mktime(0, 0, 0, $dmonth, $ddate, $year);

        return ceil(($a - $b) / 24 / 3600);
    }

    /**
     * 根據距離正月初一的天數計算陰曆日期
     *
     * @param int $year    陽曆年
     * @param int $between 天數
     *
     * @return array the lunar by between
     */
    public function getLunarByBetween(int $year, int $between): array
    {
        // debugger
        $lunarArray = [];
        $yearMonth = [];
        $t = 0;
        $e = 0;
        $leapMonth = 0;
        $m = '';

        if ($between === 0) {
            array_push($lunarArray, $year, '正月', '初一');
            $t = 1;
            $e = 1;
        } else {
            $year = $between > 0 ? $year : ($year - 1);
            $yearMonth = $this->getLunarYearMonths($year);
            $leapMonth = $this->getLeapMonth($year);
            $between = $between > 0 ? $between : ($this->getLunarYearDays($year) + $between);

            for ($i = 0; $i < 13; ++$i) {
                if ($between === $yearMonth[$i]) {
                    $t = $i + 2;
                    $e = 1;
                    break;
                }
                if ($between < $yearMonth[$i]) {
                    $t = $i + 1;
                    $e = $between - (empty($yearMonth[$i - 1]) ? 0 : $yearMonth[$i - 1]) + 1;
                    break;
                }
            }

            $m = ($leapMonth !== 0 && $t === $leapMonth + 1)
                ? ('閏' . $this->getCapitalNum($t - 1, true))
                : $this->getCapitalNum(($leapMonth !== 0 && $leapMonth + 1 < $t ? ($t - 1) : $t), true);

            array_push($lunarArray, $year, $m, $this->getCapitalNum($e, false));
        }

        array_push(
            $lunarArray,
            $t,
            $e,
            $leapMonth // 閏幾月
        );

        return $lunarArray;
    }

    /**
     * 獲取數字的陰曆叫法.
     *
     * @param int  $num     數字
     * @param bool $isMonth 是否是月份的數字
     *
     * @return string the capital number
     */
    public function getCapitalNum(int $num, bool $isMonth = false): string
    {
        if ($isMonth) {
            return static::MONTH_HASH[$num];
        }

        if ($num <= 10) {
            $res = '初' . static::DATE_HASH[$num];
        } elseif ($num < 20) {
            $res = '十' . static::DATE_HASH[$num - 10];
        } elseif ($num === 20) {
            $res = '二十';
        } elseif ($num < 30) {
            $res = '廿' . static::DATE_HASH[$num - 20];
        } elseif ($num === 30) {
            $res = '三十';
        } else {
            $res = '';
        }

        return $res;
    }
}

//
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
    <title>網頁程式月曆範例</title>
</head>

<body>
    <div style="text-align:center;margin-top:20px;font-size:30px;font-weight:bold;">
        I4010 網頁程式設計與安全實務 - 月曆
    </div>
    <div style="text-align:center;margin-top:20px;font-size:24px;">
        I3A43
        <form method="POST" action="">
            <select onchange="" name="year">
                <?php
                for ($num = 2010; $num <= 2030; $num++) {
                    echo '<option value="' . $num . '"';
                    if (empty($Y)) {
                        if ($num == $curYear) echo 'selected';
                    } else if ($num == $Y) echo 'selected';
                    echo ">" . $num . "</options>";
                }
                ?>
            </select>
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
                            $lunar = new Lunar();
                            $month = $lunar->convertSolarToLunar($Y, $M, $Date);
                        }
                        if ($i == 0)
                            $Date = '<span style="color:red">' . $Date . '<br>' . $month[1] . $month[2] . '</span>';
                        if ($i == 6)
                            $Date = '<span style="color:orange">' . $Date . '<br>' . $month[1] . $month[2] . '</span>';
                        if($i<6&&$i>0)
                            $Date = '<span style="color:black">' . $Date . '<br>' . $month[1] . $month[2] . '</span>';

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