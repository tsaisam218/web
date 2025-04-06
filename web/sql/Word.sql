-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： 140.129.25.226:4010
-- 產生時間： 2021 年 06 月 09 日 00:03
-- 伺服器版本： 10.5.9-MariaDB-1:10.5.9+maria~focal
-- PHP 版本： 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `I4010_9632`
--

-- --------------------------------------------------------

--
-- 資料表結構 `Word`
--

CREATE TABLE `Word` (
  `English` varchar(50) NOT NULL,
  `Chinese` varchar(20) NOT NULL,
  `UserID` int(11) NOT NULL,
  `WrongTime` int(11) NOT NULL DEFAULT 0,
  `WordId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `Word`
--
ALTER TABLE `Word`
  ADD PRIMARY KEY (`WordId`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `Word`
--
ALTER TABLE `Word`
  MODIFY `WordId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
