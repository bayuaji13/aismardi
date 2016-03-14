-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2016 at 10:31 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sia_mardisiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('08f11497abfd3870f6c6ff0e1c7f2d76', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36', 1453421113, 'a:5:{s:9:"user_data";s:0:"";s:4:"user";s:5:"admin";s:5:"level";s:1:"9";s:12:"kd_transaksi";N;s:9:"nama_akun";N;}'),
('557164b91844c29817374d0ee0d93822', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36', 1456976922, ''),
('e690c17238534d75aadedb0d3a37c991', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0', 1457935966, '');

-- --------------------------------------------------------

--
-- Table structure for table `statistik`
--

CREATE TABLE IF NOT EXISTS `statistik` (
  `kd_statistik` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `level` int(2) NOT NULL,
  `section` varchar(32) NOT NULL,
  `action` varchar(32) NOT NULL,
  `when` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uri` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8;

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
(128, '0', 0, 'users', 'index', '2016-03-14 06:12:46', ''),
(129, '0', 0, 'users', 'index', '2016-03-14 06:14:32', ''),
(130, '0', 0, 'users', 'login', '2016-03-14 06:14:32', 'users/login'),
(131, '0', 0, 'users', 'login', '2016-03-14 06:14:40', 'users/login');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_banyaknya_kd`
--

CREATE TABLE IF NOT EXISTS `tabel_banyaknya_kd` (
  `id_kd` int(11) NOT NULL,
  `id_sk` int(11) NOT NULL,
  `kd` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_banyaknya_nilai_harian`
--

CREATE TABLE IF NOT EXISTS `tabel_banyaknya_nilai_harian` (
  `id_nilai_harian` int(11) NOT NULL,
  `id_mapel_ta` int(11) NOT NULL,
  `ulangan` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_banyaknya_sk`
--

CREATE TABLE IF NOT EXISTS `tabel_banyaknya_sk` (
  `id_sk` int(11) NOT NULL,
  `id_mapel_ta` int(11) NOT NULL,
  `sk` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_berita`
--

CREATE TABLE IF NOT EXISTS `tabel_berita` (
  `newsId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL DEFAULT '1',
  `newsTitle` text NOT NULL,
  `newsDate` datetime NOT NULL,
  `newsContent` longtext NOT NULL,
  `newsStatus` enum('Publish','Draft') NOT NULL,
  `newsName` varchar(200) NOT NULL,
  `newsModified` datetime NOT NULL,
  `newsUrl` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_berita`
--

INSERT INTO `tabel_berita` (`newsId`, `categoryId`, `newsTitle`, `newsDate`, `newsContent`, `newsStatus`, `newsName`, `newsModified`, `newsUrl`) VALUES
(1, 1, 'Coba Berita', '0000-00-00 00:00:00', '<p>\r\n	ini adalah contoh konten berita pertama</p>\r\n', 'Publish', 'Coba-Berita', '2016-03-14 08:29:17', 'http://localhost/aismardi/news/UmumCoba-Berita'),
(2, 0, 'Coba Berita 2', '2016-03-14 08:30:35', '<p>\r\n	coba berita redundan</p>\r\n', 'Publish', 'coba-berita-2', '2016-03-14 08:30:35', 'http://localhost/aismardi/news//coba-berita-2'),
(4, 1, 'Coba ketiga', '2016-03-14 10:27:33', '<p>\r\n	Berita ketiga</p>\r\n', 'Publish', 'coba-ketiga', '2016-03-14 10:27:33', 'http://localhost/aismardi/news/umum/coba-ketiga');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_guru`
--

CREATE TABLE IF NOT EXISTS `tabel_guru` (
  `id_guru` int(11) NOT NULL,
  `nip` varchar(40) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `alamat` varchar(80) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_jurusan`
--

CREATE TABLE IF NOT EXISTS `tabel_jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tabel_jurusan`
--

INSERT INTO `tabel_jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(1, 'Belum Ada Penjurusan'),
(2, 'IPA'),
(3, 'IPS');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kategori`
--

CREATE TABLE IF NOT EXISTS `tabel_kategori` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(128) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_kategori`
--

INSERT INTO `tabel_kategori` (`categoryId`, `categoryName`, `count`) VALUES
(0, 'Uncategorized', 1),
(1, 'Umum', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kelas`
--

CREATE TABLE IF NOT EXISTS `tabel_kelas` (
  `tahun_ajaran` varchar(10) NOT NULL,
  `id_kelas` int(5) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `kd_guru` varchar(5) NOT NULL,
  `tingkat` enum('','1','2','3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kelas_siswa`
--

CREATE TABLE IF NOT EXISTS `tabel_kelas_siswa` (
  `id_entry` int(11) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `kd_siswa` varchar(20) NOT NULL,
  `kd_kelas` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_level`
--

CREATE TABLE IF NOT EXISTS `tabel_level` (
  `jenis_user` varchar(20) NOT NULL,
  `level` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tabel_level`
--

INSERT INTO `tabel_level` (`jenis_user`, `level`) VALUES
('Guru', 1),
('Kepala Sekolah', 2),
('Wali Kelas', 3),
('Siswa', 4),
('Admin', 9);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mapel`
--

CREATE TABLE IF NOT EXISTS `tabel_mapel` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tabel_mapel`
--

INSERT INTO `tabel_mapel` (`id_mapel`, `nama_mapel`) VALUES
(1, 'Ilmu Pengetahuan Alam'),
(2, 'Ilmu Pengetahuan Sosial'),
(3, 'Pendidikan Agam');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mapel_jurusan`
--

CREATE TABLE IF NOT EXISTS `tabel_mapel_jurusan` (
  `id_entry` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mapel_tahunan`
--

CREATE TABLE IF NOT EXISTS `tabel_mapel_tahunan` (
  `id_mapel_ta` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  `semester` int(1) NOT NULL,
  `tingkat` int(1) DEFAULT NULL,
  `kkm_uts` float NOT NULL,
  `kkm_uas` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_nilai_harian`
--

CREATE TABLE IF NOT EXISTS `tabel_nilai_harian` (
  `id_nilai_harian` int(11) NOT NULL,
  `id_mapel_ta` int(11) NOT NULL,
  `ulangan` int(11) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_nilai_penugasan`
--

CREATE TABLE IF NOT EXISTS `tabel_nilai_penugasan` (
  `id_nilai_penugasan` int(11) NOT NULL,
  `id_mapel_ta` int(11) NOT NULL,
  `sk` int(11) NOT NULL,
  `dk` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_siswa`
--

CREATE TABLE IF NOT EXISTS `tabel_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `nisn` varchar(30) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `jurusan` int(11) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `tingkat` int(1) NOT NULL DEFAULT '1',
  `tahun_lulus` year(4) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_users`
--

CREATE TABLE IF NOT EXISTS `tabel_users` (
  `user` varchar(20) NOT NULL,
  `pass` varchar(80) NOT NULL,
  `level` int(2) NOT NULL,
  `id_transaksi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tabel_users`
--

INSERT INTO `tabel_users` (`user`, `pass`, `level`, `id_transaksi`) VALUES
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE IF NOT EXISTS `tahun_ajaran` (
  `id_tahun_ajaran` year(4) NOT NULL,
  `tahun_ajaran` varchar(30) NOT NULL,
  `kepala_sekolah` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id_tahun_ajaran`, `tahun_ajaran`, `kepala_sekolah`) VALUES
(2014, '2014 / 2015', 0),
(2015, '2015 / 2016', 0),
(2016, '2016 / 2017', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`), ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `statistik`
--
ALTER TABLE `statistik`
  ADD PRIMARY KEY (`kd_statistik`);

--
-- Indexes for table `tabel_berita`
--
ALTER TABLE `tabel_berita`
  ADD PRIMARY KEY (`newsId`), ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `tabel_guru`
--
ALTER TABLE `tabel_guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `tabel_jurusan`
--
ALTER TABLE `tabel_jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `tabel_kategori`
--
ALTER TABLE `tabel_kategori`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `tabel_kelas`
--
ALTER TABLE `tabel_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tabel_kelas_siswa`
--
ALTER TABLE `tabel_kelas_siswa`
  ADD PRIMARY KEY (`id_entry`);

--
-- Indexes for table `tabel_level`
--
ALTER TABLE `tabel_level`
  ADD PRIMARY KEY (`level`);

--
-- Indexes for table `tabel_mapel`
--
ALTER TABLE `tabel_mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `tabel_mapel_jurusan`
--
ALTER TABLE `tabel_mapel_jurusan`
  ADD PRIMARY KEY (`id_entry`);

--
-- Indexes for table `tabel_mapel_tahunan`
--
ALTER TABLE `tabel_mapel_tahunan`
  ADD PRIMARY KEY (`id_mapel_ta`);

--
-- Indexes for table `tabel_siswa`
--
ALTER TABLE `tabel_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `tabel_users`
--
ALTER TABLE `tabel_users`
  ADD PRIMARY KEY (`user`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id_tahun_ajaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `statistik`
--
ALTER TABLE `statistik`
  MODIFY `kd_statistik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT for table `tabel_berita`
--
ALTER TABLE `tabel_berita`
  MODIFY `newsId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tabel_guru`
--
ALTER TABLE `tabel_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tabel_jurusan`
--
ALTER TABLE `tabel_jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tabel_kategori`
--
ALTER TABLE `tabel_kategori`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tabel_kelas`
--
ALTER TABLE `tabel_kelas`
  MODIFY `id_kelas` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tabel_kelas_siswa`
--
ALTER TABLE `tabel_kelas_siswa`
  MODIFY `id_entry` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tabel_mapel`
--
ALTER TABLE `tabel_mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tabel_mapel_jurusan`
--
ALTER TABLE `tabel_mapel_jurusan`
  MODIFY `id_entry` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tabel_mapel_tahunan`
--
ALTER TABLE `tabel_mapel_tahunan`
  MODIFY `id_mapel_ta` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tabel_siswa`
--
ALTER TABLE `tabel_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `AutoDeleteOldNotifications` ON SCHEDULE EVERY 1 DAY STARTS '2015-10-29 00:20:56' ON COMPLETION PRESERVE ENABLE DO DELETE FROM `statistik` WHERE `when` < DATE_SUB(NOW(), INTERVAL 3 DAY)$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
