-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2016 at 04:04 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `tabel_absensi`
--

CREATE TABLE IF NOT EXISTS `tabel_absensi` (
  `id_siswa` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  `semester` int(1) NOT NULL,
  `tanggal` date NOT NULL,
  `status` int(3) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_jurusan`
--

CREATE TABLE IF NOT EXISTS `tabel_jurusan` (
  `id_jurusan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jurusan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jurusan`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_level`
--

CREATE TABLE IF NOT EXISTS `tabel_level` (
  `jenis_user` varchar(20) NOT NULL,
  `level` int(2) NOT NULL,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mapel`
--

CREATE TABLE IF NOT EXISTS `tabel_mapel` (
  `id_mapel` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(50) NOT NULL,
  PRIMARY KEY (`id_mapel`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mapel_jurusan`
--

CREATE TABLE IF NOT EXISTS `tabel_mapel_jurusan` (
  `id_entry` int(11) NOT NULL AUTO_INCREMENT,
  `id_jurusan` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  PRIMARY KEY (`id_entry`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_nilai_rapor`
--

CREATE TABLE IF NOT EXISTS `tabel_nilai_rapor` (
  `nis` varchar(50) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  `semester` int(1) NOT NULL,
  `nilai_pengetahuan` float NOT NULL,
  `nilai_praktek` float NOT NULL,
  `nilai_sikap` float NOT NULL,
  `keterangan` char(1) NOT NULL,
  `ketercapaian_kompetensi` text NOT NULL,
  `id_mapel` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_siswa`
--

CREATE TABLE IF NOT EXISTS `tabel_siswa` (
  `id_siswa` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(50) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `jurusan` int(11) DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `tingkat` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_siswa`),
  UNIQUE KEY `nis` (`nis`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE IF NOT EXISTS `tahun_ajaran` (
  `id_tahun_ajaran` year(4) NOT NULL,
  `tahun_ajaran` varchar(30) NOT NULL,
  `kepala_sekolah` int(11) NOT NULL,
  PRIMARY KEY (`id_tahun_ajaran`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
