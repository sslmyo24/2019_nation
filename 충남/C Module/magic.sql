-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 19-09-19 08:19
-- 서버 버전: 10.4.6-MariaDB
-- PHP 버전: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `magic`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `member`
--

CREATE TABLE `member` (
  `idx` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id` varchar(255) NOT NULL,
  `pw` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `member`
--

INSERT INTO `member` (`idx`, `name`, `id`, `pw`, `email`) VALUES
(1, '회원1', 'admin', 'ac9689e2272427085e35b9d3e3e8bed88cb3434828b43b86fc0596cad4c6e270', 'a@a.a');

-- --------------------------------------------------------

--
-- 테이블 구조 `page`
--

CREATE TABLE `page` (
  `idx` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `html` varchar(255) NOT NULL,
  `add_date` date NOT NULL,
  `mod_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `page`
--

INSERT INTO `page` (`idx`, `code`, `name`, `title`, `description`, `keyword`, `html`, `add_date`, `mod_date`) VALUES
(1, '012', 'Page1', 'page1', 'page1 layout', 'MAGIC', 'teaser_012.php', '2019-09-19', '2019-09-19 00:00:00'),
(2, '013', 'Page2', '', '', '', 'teaser_013.php', '2019-09-19', '2019-09-19 11:38:05');

-- --------------------------------------------------------

--
-- 테이블 구조 `statistic`
--

CREATE TABLE `statistic` (
  `idx` int(11) NOT NULL,
  `referer` varchar(255) NOT NULL,
  `os` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `device` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `statistic`
--

INSERT INTO `statistic` (`idx`, `referer`, `os`, `browser`, `version`, `device`, `date`) VALUES
(1, 'http://localhost/012', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(2, 'http://localhost/012', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(3, 'http://localhost/012', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(4, 'http://localhost/admin', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(5, 'http://localhost/admin/logout', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(6, 'http://localhost/013', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(7, 'http://localhost/builder', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(8, 'http://localhost/admin', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(9, 'http://localhost/admin', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(10, 'http://localhost/013', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(11, 'http://localhost/builder', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(12, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(13, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(14, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(15, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(16, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(17, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(18, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(19, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(20, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(21, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(22, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(23, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(24, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(25, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(26, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(27, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(28, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(29, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(30, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(31, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(32, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(33, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(34, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(35, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(36, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(37, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(38, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(39, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(40, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(41, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(42, 'http://localhost/builder/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(43, 'http://localhost/admin', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(44, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(45, 'http://localhost/builder/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(46, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(47, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(48, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(49, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(50, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(51, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(52, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(53, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(54, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(55, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(56, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(57, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(58, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(59, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(60, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(61, 'http://localhost/style.css', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(62, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(63, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(64, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(65, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(66, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(67, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(68, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(69, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(70, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(71, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(72, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(73, 'http://localhost/img/graph/stick2.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(74, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(75, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(76, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(77, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(78, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(79, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(80, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(81, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(82, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(83, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(84, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(85, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(86, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(87, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(88, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(89, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(90, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(91, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(92, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(93, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(94, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(95, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(96, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(97, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(98, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(99, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(100, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(101, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(102, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(103, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(104, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(105, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(106, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(107, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(108, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(109, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(110, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(111, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(112, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(113, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(114, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(115, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(116, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(117, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(118, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(119, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(120, 'http://localhost/builder/statistic', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19'),
(121, 'http://localhost/img/graph/stick1.php', 'Window', 'Google Chrome', '76.0.3809.132', 'PC', '2019-09-19');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `statistic`
--
ALTER TABLE `statistic`
  ADD PRIMARY KEY (`idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `page`
--
ALTER TABLE `page`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `statistic`
--
ALTER TABLE `statistic`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
