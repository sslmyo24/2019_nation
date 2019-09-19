-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 19-09-19 14:31
-- 서버 버전: 10.1.38-MariaDB
-- PHP 버전: 7.3.3

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
  `device` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `statistic`
--

INSERT INTO `statistic` (`idx`, `referer`, `os`, `browser`, `device`, `date`) VALUES
(1, '/admin', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(2, '/http:localhost:88013', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(3, '/admin', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(4, '/admin', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(5, '/013', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(6, '', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(7, '', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(8, '/012', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(9, '/builder', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(10, '/builderstatistic', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(11, '/builderstatistic', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(12, '/builderstatistic', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(13, '/builderstatistic', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(14, '/builderstatistic', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(15, '/builderstatistic', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(16, '/imggraphstick3.php', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(17, '/imggraphstick3.php', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(18, '/builderstatistic', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19'),
(19, '/builderstatistic', 'Window', 'Google Chrome 76.0.3809.132', 'Mobile', '2019-09-19');

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
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
