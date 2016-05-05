-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2016 at 07:57 PM
-- Server version: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sia_mardisiswa`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `DAMLEV`(`s1` VARCHAR(255), `s2` VARCHAR(255)) RETURNS int(11)
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
  DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
DECLARE s1_char CHAR;
DECLARE cv0, cv1 VARBINARY(256);
SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;
IF s1 = s2 THEN
    RETURN 0;
ELSEIF s1_len = 0 THEN
    RETURN s2_len;
ELSEIF s2_len = 0 THEN
    RETURN s1_len;
ELSE
    WHILE j <= s2_len DO
      SET cv1 = CONCAT(cv1, UNHEX(HEX(j)));
SET j = j + 1;
END WHILE;
WHILE i <= s1_len DO
      SET s1_char = SUBSTRING(s1, i, 1);
SET c = i;
SET cv0 = UNHEX(HEX(i));
SET j = 1;
WHILE j <= s2_len DO
          SET c = c + 1;
IF s1_char = SUBSTRING(s2, j, 1) THEN
			 	SET cost = 0;
ELSE
				SET cost = 1;
END IF;
SET c_temp = CONV (HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
IF c > c_temp THEN
			 	SET c = c_temp;
END IF;
SET c_temp = CONV (HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
IF c > c_temp THEN
				 SET c = c_temp;
END IF;
IF i > 1 AND j > 1 AND (s1_char = SUBSTRING(s2, j - 1, 1)) AND (SUBSTRING(s1, i - 1, 1) = SUBSTRING(s2, j, 1)) THEN


						SET c_temp = CONV(HEX(SUBSTRING(cv1, j + 1, 1)), 16, 10);
END IF;
IF c > c_temp THEN
						SET c = c_temp;
END IF;
SET cv0 = CONCAT(cv0, UNHEX(HEX(c)));
SET j = j + 1;
END WHILE;
SET cv1 = cv0;
SET i = i + 1;
END WHILE;
END IF;
RETURN c;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('08f11497abfd3870f6c6ff0e1c7f2d76', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36', 1453421113, 'a:5:{s:9:"user_data";s:0:"";s:4:"user";s:5:"admin";s:5:"level";s:1:"9";s:12:"kd_transaksi";N;s:9:"nama_akun";N;}'),
('557164b91844c29817374d0ee0d93822', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36', 1456976922, ''),
('6a2233475605f73db3527f129d47c6db', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36', 1458271806, '');

-- --------------------------------------------------------

--
-- Table structure for table `statistik`
--

CREATE TABLE IF NOT EXISTS `statistik` (
  `kd_statistik` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL,
  `level` int(2) NOT NULL,
  `section` varchar(32) NOT NULL,
  `action` varchar(32) NOT NULL,
  `when` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uri` varchar(255) NOT NULL,
  PRIMARY KEY (`kd_statistik`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=130 ;

--
-- Dumping data for table `statistik`
--

INSERT INTO `statistik` (`kd_statistik`, `user`, `level`, `section`, `action`, `when`, `uri`) VALUES
(1, '0', 0, 'siswas', 'manageSiswa', '2016-01-20 07:58:28', 'siswas/manageSiswa'),
(2, '0', 0, 'siswas', 'manageSiswa', '2016-01-20 08:00:42', 'siswas/manageSiswa'),
(3, '0', 0, 'users', 'login', '2016-01-20 08:00:42', 'users/login'),
(4, '0', 0, 'siswas', 'manageSiswa', '2016-01-20 08:01:20', 'siswas/manageSiswa'),
(5, '0', 0, 'users', 'login', '2016-01-20 08:01:20', 'users/login'),
(6, '0', 0, 'users', 'login', '2016-01-20 08:01:48', 'users/login'),
(7, '0', 0, 'users', 'login', '2016-01-20 08:03:53', 'users/login'),
(8, '0', 0, 'users', 'login', '2016-01-20 08:03:55', 'users/login'),
(9, '0', 0, 'users', 'login', '2016-01-20 08:05:01', 'users/login'),
(10, 'admin', 9, 'users', 'home', '2016-01-20 08:05:01', 'users/home'),
(11, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:05:10', 'siswas/manageSiswa'),
(12, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:05:13', 'siswas/manageSiswa/add'),
(13, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:07:22', 'siswas/manageSiswa/add'),
(14, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:07:39', 'siswas/manageSiswa/add'),
(15, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:07:40', 'siswas/manageSiswa/add'),
(16, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:07:41', 'siswas/manageSiswa/add'),
(17, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:07:42', 'siswas/manageSiswa/add'),
(18, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:07:43', 'siswas/manageSiswa/add'),
(19, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:08:56', 'siswas/manageSiswa/add'),
(20, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:09:17', 'siswas/manageSiswa/add'),
(21, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:12:57', 'siswas/manageSiswa/add'),
(22, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:14:39', 'siswas/manageSiswa/add'),
(23, '0', 0, 'siswas', 'manageSiswa', '2016-01-20 08:28:37', 'siswas/manageSiswa/add'),
(24, '0', 0, 'users', 'login', '2016-01-20 08:28:47', 'users/login'),
(25, '0', 0, 'users', 'login', '2016-01-20 08:28:48', 'users/login'),
(26, 'admin', 9, 'users', 'home', '2016-01-20 08:28:48', 'users/home'),
(27, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:28:53', 'siswas/manageSiswa'),
(28, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:28:55', 'siswas/manageSiswa/add'),
(29, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:29:41', 'siswas/manageSiswa/insert_validation'),
(30, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:29:41', 'siswas/manageSiswa/insert'),
(31, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:29:50', 'siswas/manageSiswa'),
(32, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:30:42', 'siswas/manageSiswa/delete/1'),
(33, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:30:42', 'siswas/manageSiswa/ajax_list_info'),
(34, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:30:42', 'siswas/manageSiswa/ajax_list'),
(35, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:30:43', 'siswas/manageSiswa/add'),
(36, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:31:00', 'siswas/manageSiswa/insert_validation'),
(37, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:31:00', 'siswas/manageSiswa/insert'),
(38, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:31:06', 'siswas/manageSiswa'),
(39, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:31:07', 'siswas/manageSiswa/ajax_list_info'),
(40, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:31:07', 'siswas/manageSiswa/ajax_list'),
(41, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:33:47', 'siswas/manageSiswa/delete/2'),
(42, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:33:47', 'siswas/manageSiswa/ajax_list_info'),
(43, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:33:47', 'siswas/manageSiswa/ajax_list'),
(44, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:33:51', 'siswas/manageSiswa/insert_validation'),
(45, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:33:51', 'siswas/manageSiswa/insert'),
(46, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:33:51', 'siswas/manageSiswa/success/3'),
(47, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:33:52', 'siswas/manageSiswa/ajax_list_info'),
(48, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:33:52', 'siswas/manageSiswa/ajax_list'),
(49, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:39:30', 'siswas/manageSiswa/delete/3'),
(50, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:39:30', 'siswas/manageSiswa/ajax_list_info'),
(51, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 08:39:31', 'siswas/manageSiswa/ajax_list'),
(52, '0', 0, 'gurus', 'index', '2016-01-20 16:38:33', 'gurus'),
(53, '0', 0, 'gurus', 'manageGuru', '2016-01-20 16:38:33', 'gurus/manageGuru'),
(54, '0', 0, 'users', 'login', '2016-01-20 16:38:34', 'users/login'),
(55, '0', 0, 'users', 'login', '2016-01-20 16:38:35', 'users/login'),
(56, 'admin', 9, 'users', 'home', '2016-01-20 16:38:35', 'users/home'),
(57, 'admin', 9, 'gurus', 'index', '2016-01-20 16:38:40', 'gurus'),
(58, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:38:40', 'gurus/manageGuru'),
(59, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:38:42', 'gurus/manageGuru/add'),
(60, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:39:37', 'gurus/manageGuru/insert_validation'),
(61, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:39:37', 'gurus/manageGuru/insert'),
(62, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:39:37', 'gurus/manageGuru/success'),
(63, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:40:01', 'gurus/manageGuru'),
(64, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:42:06', 'gurus/manageGuru'),
(65, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:42:08', 'gurus/manageGuru/add'),
(66, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:42:16', 'gurus/manageGuru/insert_validation'),
(67, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:42:17', 'gurus/manageGuru/insert'),
(68, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:42:22', 'gurus/manageGuru'),
(69, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:42:29', 'gurus/manageGuru/delete/2'),
(70, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:42:36', 'gurus/manageGuru'),
(71, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:43:45', 'gurus/manageGuru'),
(72, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:43:47', 'gurus/manageGuru/add'),
(73, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:43:58', 'gurus/manageGuru/insert_validation'),
(74, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:43:58', 'gurus/manageGuru/insert'),
(75, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:44:03', 'gurus/manageGuru'),
(76, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 16:46:21', 'siswas/manageSiswa/success/3'),
(77, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 16:46:22', 'siswas/manageSiswa/ajax_list_info'),
(78, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-20 16:46:22', 'siswas/manageSiswa/ajax_list'),
(79, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:46:30', 'gurus/manageGuru'),
(80, 'admin', 9, 'gurus', 'manageGuru', '2016-01-20 16:47:24', 'gurus/manageGuru/add'),
(81, '0', 0, 'siswas', 'manageSiswa', '2016-01-21 23:25:13', 'siswas/manageSiswa'),
(82, '0', 0, 'users', 'login', '2016-01-21 23:25:13', 'users/login'),
(83, '0', 0, 'users', 'login', '2016-01-21 23:25:14', 'users/login'),
(84, 'admin', 9, 'users', 'home', '2016-01-21 23:25:15', 'users/home'),
(85, 'admin', 9, 'siswas', 'manageSiswa', '2016-01-21 23:25:20', 'siswas/manageSiswa'),
(86, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:26:16', 'gurus/manageGuru'),
(87, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:26:21', 'gurus/manageGuru/add'),
(88, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:26:41', 'gurus/manageGuru/insert_validation'),
(89, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:26:41', 'gurus/manageGuru/insert'),
(90, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:26:41', 'gurus/manageGuru/success/4'),
(91, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:36:06', 'gurus/manageGuru/delete/3'),
(92, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:36:11', 'gurus/manageGuru/delete/3'),
(93, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:36:18', 'gurus/manageGuru'),
(94, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:36:21', 'gurus/manageGuru/edit/3'),
(95, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:36:24', 'gurus/manageGuru'),
(96, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:36:27', 'gurus/manageGuru/delete/3'),
(97, 'admin', 9, 'gurus', 'manageGuru', '2016-01-21 23:50:54', 'gurus/manageGuru/delete/3'),
(98, 'admin', 9, 'siswas', 'index', '2016-01-21 23:51:00', 'siswas'),
(99, 'admin', 9, 'siswas', 'managesiswa', '2016-01-21 23:51:00', 'siswas/managesiswa'),
(100, 'admin', 9, 'siswas', 'managesiswa', '2016-01-21 23:51:07', 'siswas/managesiswa/add'),
(101, 'admin', 9, 'siswas', 'managesiswa', '2016-01-21 23:51:23', 'siswas/managesiswa/insert_validation'),
(102, 'admin', 9, 'siswas', 'managesiswa', '2016-01-21 23:51:23', 'siswas/managesiswa/insert'),
(103, 'admin', 9, 'siswas', 'managesiswa', '2016-01-21 23:51:23', 'siswas/managesiswa/success/4'),
(104, 'admin', 9, 'siswas', 'managesiswa', '2016-01-21 23:51:37', 'siswas/managesiswa/delete/4'),
(105, 'admin', 9, 'siswas', 'managesiswa', '2016-01-21 23:51:38', 'siswas/managesiswa/ajax_list_info'),
(106, 'admin', 9, 'siswas', 'managesiswa', '2016-01-21 23:51:38', 'siswas/managesiswa/ajax_list'),
(107, 'admin', 9, 'gurus', 'index', '2016-01-22 00:05:13', 'gurus'),
(108, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:05:13', 'gurus/manageGuru'),
(109, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:05:17', 'gurus/manageGuru/delete/4'),
(110, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:05:20', 'gurus/manageGuru'),
(111, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:05:25', 'gurus/manageGuru/delete/4'),
(112, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:06:05', 'gurus/manageGuru'),
(113, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:06:12', 'gurus/manageGuru/delete/4'),
(114, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:06:44', 'gurus/manageGuru'),
(115, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:06:49', 'gurus/manageGuru/delete/4'),
(116, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:06:52', 'gurus/manageGuru/edit/4'),
(117, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:06:55', 'gurus/manageGuru/update_validation/4'),
(118, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:06:56', 'gurus/manageGuru/update/4'),
(119, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:06:56', 'gurus/manageGuru/success/4'),
(120, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:07:00', 'gurus/manageGuru/delete/4'),
(121, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:07:20', 'gurus/manageGuru/success/4'),
(122, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:07:23', 'gurus/manageGuru/ajax_list_info'),
(123, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:07:23', 'gurus/manageGuru/ajax_list'),
(124, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:07:26', 'gurus/manageGuru/delete/4'),
(125, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:07:26', 'gurus/manageGuru/ajax_list_info'),
(126, 'admin', 9, 'gurus', 'manageGuru', '2016-01-22 00:07:26', 'gurus/manageGuru/ajax_list'),
(127, '0', 0, 'users', 'index', '2016-03-03 03:48:42', ''),
(128, '0', 0, 'siswas', 'manageSiswa', '2016-03-18 03:30:06', 'siswas/manageSiswa'),
(129, '0', 0, 'users', 'login', '2016-03-18 03:30:06', 'users/login');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_absensi`
--

CREATE TABLE IF NOT EXISTS `tabel_absensi` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `id_siswa` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  `semester` int(1) NOT NULL,
  `tanggal` date NOT NULL,
  `status` int(3) NOT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_berita`
--

CREATE TABLE IF NOT EXISTS `tabel_berita` (
  `newsId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL DEFAULT '1',
  `newsTitle` text NOT NULL,
  `newsThumbnail` varchar(128) DEFAULT NULL,
  `newsDate` datetime NOT NULL,
  `newsContent` longtext NOT NULL,
  `newsStatus` enum('Publish','Draft') NOT NULL DEFAULT 'Draft',
  `newsName` varchar(200) NOT NULL,
  `newsModified` datetime NOT NULL,
  `newsUrl` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_berita`
--

INSERT INTO `tabel_berita` (`newsId`, `categoryId`, `newsTitle`, `newsThumbnail`, `newsDate`, `newsContent`, `newsStatus`, `newsName`, `newsModified`, `newsUrl`) VALUES
(10, 3, 'Berita', NULL, '2016-04-01 05:44:05', '<p>\r\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vestibulum pellentesque urna. Phasellus adipiscing et massa et aliquam. Ut odio magna, interdum quis dolor non, tristique vestibulum nisi. Nam accumsan convallis venenatis. Nullam posuere risus odio, in interdum felis venenatis sagittis. Integer malesuada porta fermentum. Sed luctus nibh sed mi auctor imperdiet. Cras et sapien rhoncus, pulvinar dolor sed, tincidunt massa. Nullam fringilla mauris non risus ultricies viverra. Donec a turpis non lorem pulvinar posuere.</p>\r\n', 'Publish', 'berita', '2016-04-01 05:45:42', 'http://localhost/aismardi/berita/umum/berita'),
(11, 4, 'Berita 2', NULL, '2016-04-01 08:53:36', '<p>\r\n ini berita kedua</p>\r\n', 'Publish', 'berita-2', '2016-04-01 08:53:36', 'http://localhost/aismardi/berita/coba-coba/berita-2'),
(12, 3, 'Berita Ketiga', '684d2-peta-tegalarum.png', '2016-04-03 14:23:58', '<p>\r\n berita ketiga</p>\r\n', 'Publish', 'berita-ketiga', '2016-04-03 14:23:58', 'http://localhost/aismardi/berita/umum/berita-ketiga');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_event`
--

CREATE TABLE IF NOT EXISTS `tabel_event` (
  `eventId` int(11) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `eventTitle` varchar(64) NOT NULL,
  `eventContent` text NOT NULL,
  `locationName` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_event`
--

INSERT INTO `tabel_event` (`eventId`, `startDate`, `endDate`, `eventTitle`, `eventContent`, `locationName`) VALUES
(1, '2016-04-05 10:17:52', '2016-04-13 10:18:07', 'Coba Event', '<p>\r\n	deskripsi konten</p>\r\n', 'Hall'),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'coba', '', ''),
(3, '2016-04-03 10:22:11', '2016-04-04 00:00:00', 'Event lebih dari sehari', '', 'Di sini');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_galeri`
--

CREATE TABLE IF NOT EXISTS `tabel_galeri` (
  `imageId` int(11) NOT NULL,
  `imageUrl` varchar(128) NOT NULL,
  `imageTitle` varchar(32) NOT NULL,
  `imagePriority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_guru`
--

CREATE TABLE IF NOT EXISTS `tabel_guru` (
  `id_guru` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(40) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `alamat` varchar(80) NOT NULL,
  PRIMARY KEY (`id_guru`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tabel_guru`
--

INSERT INTO `tabel_guru` (`id_guru`, `nip`, `nama`, `alamat`) VALUES
(5, 'gr.bayu', 'Bayu', 'Boyolali'),
(6, 'gr.aji', 'Aji', 'Boyolali');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_jurusan`
--

CREATE TABLE IF NOT EXISTS `tabel_jurusan` (
  `id_jurusan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jurusan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jurusan`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tabel_jurusan`
--

INSERT INTO `tabel_jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(1, 'Belum Ada Penjurusan'),
(2, 'IPA'),
(3, 'IPS');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kartu`
--

CREATE TABLE IF NOT EXISTS `tabel_kartu` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `id_siswa` int(11) NOT NULL,
  `jenis_kartu` varchar(10) NOT NULL,
  `nomor_peserta` varchar(50) NOT NULL,
  `ruang` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tabel_kartu`
--

INSERT INTO `tabel_kartu` (`id_entry`, `id_siswa`, `jenis_kartu`, `nomor_peserta`, `ruang`) VALUES
(1, 46, 'uas', '9980933564', '5'),
(2, 47, 'uas', '0000715806', '5'),
(3, 48, 'uas', '9991093726', '5'),
(4, 49, 'uas', '0009983386', '5'),
(5, 50, 'uas', '0002230980', '5'),
(6, 51, 'uas', '0000716025', '5'),
(7, 52, 'uas', '9991093213', '5'),
(8, 53, 'uas', '0000715680', '5'),
(9, 54, 'uas', '0000715644', '5'),
(10, 55, 'uas', '0004992533', '5');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kategori`
--

CREATE TABLE IF NOT EXISTS `tabel_kategori` (
  `categoryId` int(11) NOT NULL,
  `categoryPid` varchar(64) NOT NULL,
  `categoryName` varchar(128) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_kategori`
--

INSERT INTO `tabel_kategori` (`categoryId`, `categoryPid`, `categoryName`, `count`) VALUES
(0, 'uncategorized', 'Uncategorized', 0),
(3, 'umum', 'Umum', 2),
(4, 'coba-coba', 'Coba coba', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kelas`
--

CREATE TABLE IF NOT EXISTS `tabel_kelas` (
  `tahun_ajaran` varchar(10) NOT NULL,
  `id_kelas` int(5) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(10) NOT NULL,
  `id_guru` varchar(5) NOT NULL,
  `tingkat` int(1) NOT NULL,
  `jurusan` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kelas_siswa`
--

CREATE TABLE IF NOT EXISTS `tabel_kelas_siswa` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran` varchar(10) NOT NULL,
  `id_siswa` varchar(20) NOT NULL,
  `id_kelas` varchar(5) NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_laman`
--

CREATE TABLE IF NOT EXISTS `tabel_laman` (
  `pageId` int(11) NOT NULL,
  `pageTitle` text NOT NULL,
  `pageDate` datetime NOT NULL,
  `pageContent` longtext NOT NULL,
  `pageStatus` enum('Publish','Draft') NOT NULL DEFAULT 'Draft',
  `pageName` varchar(200) NOT NULL,
  `pageModified` datetime NOT NULL,
  `pageUrl` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_laman`
--

INSERT INTO `tabel_laman` (`pageId`, `pageTitle`, `pageDate`, `pageContent`, `pageStatus`, `pageName`, `pageModified`, `pageUrl`) VALUES
(1, 'Profil', '2016-03-18 05:22:25', '<p>\r\n Laman untuk profil</p>\r\n', 'Publish', 'profil', '2016-03-18 05:22:25', 'http://localhost/aismardi/page/profil'),
(4, 'Fasilitas', '2016-03-18 05:30:43', '', 'Draft', 'fasilitas', '2016-03-18 05:30:43', 'http://localhost/aismardi/page/fasilitas');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_level`
--

CREATE TABLE IF NOT EXISTS `tabel_level` (
  `jenis_user` varchar(20) NOT NULL,
  `level` int(2) NOT NULL,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tabel_level`
--

INSERT INTO `tabel_level` (`jenis_user`, `level`) VALUES
('Guru', 1),
('Guru BP', 2),
('Wali Kelas', 4),
('Siswa', 5),
('Admin', 9);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mapel`
--

CREATE TABLE IF NOT EXISTS `tabel_mapel` (
  `id_mapel` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(50) NOT NULL,
  `kkm` float DEFAULT NULL,
  PRIMARY KEY (`id_mapel`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tabel_mapel`
--

INSERT INTO `tabel_mapel` (`id_mapel`, `nama_mapel`, `kkm`) VALUES
(7, 'Bahasa Inggris', 75),
(6, 'Bahasa Indonesia', 75),
(5, 'Matematika', 75),
(4, 'Bimbingan dan Pengembangan', NULL),
(8, 'Fisika', 75),
(9, 'Kimia', 75),
(10, 'Biologi', 75),
(11, 'Ekonomi', 75),
(12, 'Sosiologi', 75),
(13, 'Geografi', 75);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mapel_jurusan`
--

CREATE TABLE IF NOT EXISTS `tabel_mapel_jurusan` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `id_jurusan` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  PRIMARY KEY (`id_entry`),
  UNIQUE KEY `id_jurusan` (`id_jurusan`,`id_mapel`,`tahun_ajaran`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `tabel_mapel_jurusan`
--

INSERT INTO `tabel_mapel_jurusan` (`id_entry`, `id_jurusan`, `id_mapel`, `tahun_ajaran`) VALUES
(79, 1, 13, 2016),
(78, 1, 12, 2016),
(77, 1, 11, 2016),
(76, 1, 10, 2016),
(75, 1, 9, 2016),
(74, 1, 8, 2016),
(73, 1, 4, 2016),
(72, 1, 5, 2016),
(71, 1, 6, 2016),
(70, 1, 7, 2016),
(80, 2, 7, 2016),
(81, 2, 6, 2016),
(82, 2, 5, 2016),
(83, 2, 4, 2016),
(84, 2, 8, 2016),
(85, 2, 9, 2016),
(86, 2, 10, 2016),
(87, 3, 7, 2016),
(88, 3, 6, 2016),
(89, 3, 5, 2016),
(90, 3, 4, 2016),
(91, 3, 11, 2016),
(92, 3, 12, 2016),
(93, 3, 13, 2016);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mapel_un`
--

CREATE TABLE IF NOT EXISTS `tabel_mapel_un` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran` year(4) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `tabel_mapel_un`
--

INSERT INTO `tabel_mapel_un` (`id_entry`, `tahun_ajaran`, `id_jurusan`, `id_mapel`) VALUES
(24, 2016, 3, 13),
(23, 2016, 3, 12),
(22, 2016, 3, 11),
(21, 2016, 3, 5),
(20, 2016, 3, 6),
(19, 2016, 3, 7),
(18, 2016, 2, 10),
(17, 2016, 2, 9),
(16, 2016, 2, 8),
(15, 2016, 2, 5),
(14, 2016, 2, 6),
(13, 2016, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_menu`
--

CREATE TABLE IF NOT EXISTS `tabel_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `customSelect` int(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tabel_menu`
--

INSERT INTO `tabel_menu` (`id`, `title`, `customSelect`) VALUES
(1, 'Parent 1', 0),
(2, 'Parent 2', 2),
(3, 'title 3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_menu_children`
--

CREATE TABLE IF NOT EXISTS `tabel_menu_children` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `customSelect` varchar(32) NOT NULL,
  `idParent` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tabel_menu_children`
--

INSERT INTO `tabel_menu_children` (`id`, `title`, `customSelect`, `idParent`) VALUES
(10, 'Child 1', '3', 1),
(11, 'Child 2', '4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_nilai_ekstrakurikuler`
--

CREATE TABLE IF NOT EXISTS `tabel_nilai_ekstrakurikuler` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `id_siswa` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  `semester` int(11) NOT NULL,
  `nama_kegiatan` varchar(50) NOT NULL,
  `nilai_kegiatan` varchar(5) NOT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_nilai_organisasi`
--

CREATE TABLE IF NOT EXISTS `tabel_nilai_organisasi` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `id_siswa` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  `semester` int(11) NOT NULL,
  `nama_organisasi` varchar(50) NOT NULL,
  `nilai_organisasi` varchar(5) NOT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_nilai_rapor`
--

CREATE TABLE IF NOT EXISTS `tabel_nilai_rapor` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `id_siswa` varchar(50) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  `semester` int(1) NOT NULL,
  `nilai_pengetahuan` float NOT NULL,
  `nilai_praktek` float DEFAULT NULL,
  `nilai_sikap` char(1) NOT NULL,
  `keterangan` char(1) NOT NULL,
  `ketercapaian_kompetensi` text NOT NULL,
  `id_mapel` int(11) NOT NULL,
  PRIMARY KEY (`id_entry`),
  UNIQUE KEY `id_siswa` (`id_siswa`,`tahun_ajaran`,`semester`,`id_mapel`),
  UNIQUE KEY `id_siswa_2` (`id_siswa`,`tahun_ajaran`,`semester`,`id_mapel`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_nilai_un`
--

CREATE TABLE IF NOT EXISTS `tabel_nilai_un` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `id_siswa` int(11) NOT NULL,
  `tahun_ajaran` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `nilai` float NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pengampu`
--

CREATE TABLE IF NOT EXISTS `tabel_pengampu` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran` year(4) NOT NULL,
  `id_guru` varchar(5) NOT NULL,
  `id_mapel` varchar(5) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  PRIMARY KEY (`id_entry`),
  UNIQUE KEY `tahun_ajaran` (`tahun_ajaran`,`id_mapel`,`id_kelas`,`id_guru`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_peserta_un`
--

CREATE TABLE IF NOT EXISTS `tabel_peserta_un` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `no_peserta_un` varchar(50) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_sambutan`
--

CREATE TABLE IF NOT EXISTS `tabel_sambutan` (
  `sambutanId` int(11) NOT NULL,
  `imageUrl` varchar(64) NOT NULL,
  `sambutanKonten` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_siswa`
--

CREATE TABLE IF NOT EXISTS `tabel_siswa` (
  `id_siswa` int(11) NOT NULL AUTO_INCREMENT,
  `nisn` varchar(50) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `jurusan` int(11) DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `tingkat` int(1) NOT NULL DEFAULT '1',
  `flag_tunggakan` int(1) DEFAULT '0',
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  PRIMARY KEY (`id_siswa`),
  UNIQUE KEY `nis` (`nisn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=344 ;

--
-- Dumping data for table `tabel_siswa`
--

INSERT INTO `tabel_siswa` (`id_siswa`, `nisn`, `nama`, `tahun_masuk`, `jurusan`, `status`, `tingkat`, `flag_tunggakan`, `tanggal_lahir`, `tempat_lahir`) VALUES
(19, '213', 'hae', 2016, 1, 1, 1, 0, '2016-05-14', ''),
(18, '122', 'Helaa', 2016, 1, 1, 1, 1, '0000-00-00', ''),
(20, '111', 'hoi', 2016, 1, 1, 1, 0, '0000-00-00', ''),
(21, '233', 'Bayu', 2016, 1, 1, 1, 1, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_slider`
--

CREATE TABLE IF NOT EXISTS `tabel_slider` (
  `sliderId` int(11) NOT NULL,
  `sliderUrl` varchar(128) NOT NULL,
  `sliderTitle` varchar(32) NOT NULL,
  `sliderPriority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_slider`
--

INSERT INTO `tabel_slider` (`sliderId`, `sliderUrl`, `sliderTitle`, `sliderPriority`) VALUES
(1, '72578-peta-tegalarum.png', 'Judul 1', 1),
(2, '02e71-IMG_20141220_201405.jpg', 'Judul 2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_status_absensi`
--

CREATE TABLE IF NOT EXISTS `tabel_status_absensi` (
  `id_status` int(11) NOT NULL,
  `nama_status` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tabel_status_absensi`
--

INSERT INTO `tabel_status_absensi` (`id_status`, `nama_status`) VALUES
(1, 'sakit'),
(2, 'izin'),
(3, 'alfa');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_tanggal`
--

CREATE TABLE IF NOT EXISTS `tabel_tanggal` (
  `id_entry` int(11) NOT NULL,
  `keterangan` enum('uts','uas') NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tabel_tanggal`
--

INSERT INTO `tabel_tanggal` (`id_entry`, `keterangan`, `tanggal_mulai`, `tanggal_akhir`) VALUES
(1, 'uts', '2016-04-22', '2016-04-30');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_tautan`
--

CREATE TABLE IF NOT EXISTS `tabel_tautan` (
  `linkId` int(11) NOT NULL,
  `linkName` varchar(32) NOT NULL,
  `linkUrl` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_testi`
--

CREATE TABLE IF NOT EXISTS `tabel_testi` (
  `testiId` int(11) NOT NULL,
  `testiImage` varchar(128) NOT NULL,
  `testiName` varchar(64) NOT NULL,
  `testiAngkatan` varchar(8) NOT NULL,
  `testiContent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_testi`
--

INSERT INTO `tabel_testi` (`testiId`, `testiImage`, `testiName`, `testiAngkatan`, `testiContent`) VALUES
(3, '79b81-24010312130052.jpg', 'Saptanto', '2012', '\r\n	Saya sekolah disini\r\n'),
(4, '7f948-peta-tegalarum.png', 'Sindu', '2016', '\r\n	Saya kuliah disini\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_users`
--

CREATE TABLE IF NOT EXISTS `tabel_users` (
  `user` varchar(20) NOT NULL,
  `pass` varchar(80) NOT NULL,
  `level` int(2) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tabel_users`
--

INSERT INTO `tabel_users` (`user`, `pass`, `level`, `id_transaksi`) VALUES
('111', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 5, 20),
('122', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 5, 18),
('213', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 5, 19),
('233', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 4, 21),
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 9, 0),
('gr.aji', 'f42e1b5c16d4f64e98aba7b255c16009dfd87d27', 1, 6),
('gr.bayu', '2080988f5ac23ef8acc98c5afa76be8f6db58ee2', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE IF NOT EXISTS `tahun_ajaran` (
  `id_tahun_ajaran` year(4) NOT NULL,
  `tahun_ajaran` varchar(30) NOT NULL,
  `kepala_sekolah` varchar(50) NOT NULL,
  `nomor_peraturan` varchar(10) NOT NULL,
  `tahun_peraturan` varchar(10) NOT NULL,
  `buka_skhu` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tahun_ajaran`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id_tahun_ajaran`, `tahun_ajaran`, `kepala_sekolah`, `nomor_peraturan`, `tahun_peraturan`, `buka_skhu`) VALUES
(2014, '2014 / 2015', '0', '', '', '0000-00-00 00:00:00'),
(2015, '2015 / 2016', '0', '', '', NULL),
(2016, '2016', '', '', '6', '2016-05-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `u_tabel_mapel_tahunan`
--

CREATE TABLE IF NOT EXISTS `u_tabel_mapel_tahunan` (
  `id_mapel_ta` int(11) NOT NULL AUTO_INCREMENT,
  `id_mapel` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  `semester` int(1) NOT NULL,
  `tingkat` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_mapel_ta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `AutoDeleteOldNotifications` ON SCHEDULE EVERY 1 DAY STARTS '2015-10-29 00:20:56' ON COMPLETION PRESERVE ENABLE DO DELETE FROM `statistik` WHERE `when` < DATE_SUB(NOW(), INTERVAL 3 DAY)$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
