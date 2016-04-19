-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2016 at 03:58 AM
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
  `user_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
  `id_guru` int(11) NOT NULL,
  `nip` varchar(40) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `alamat` varchar(80) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_jurusan`
--

CREATE TABLE IF NOT EXISTS `tabel_jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
  `id_kelas` int(5) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `id_guru` varchar(5) NOT NULL,
  `tingkat` int(1) NOT NULL,
  `jurusan` int(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kelas_siswa`
--

CREATE TABLE IF NOT EXISTS `tabel_kelas_siswa` (
  `id_entry` int(11) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `id_siswa` varchar(20) NOT NULL,
  `id_kelas` varchar(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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
  `level` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mapel`
--

CREATE TABLE IF NOT EXISTS `tabel_mapel` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mapel_jurusan`
--

CREATE TABLE IF NOT EXISTS `tabel_mapel_jurusan` (
  `id_entry` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

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
  `id_entry` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  `id_guru` varchar(5) NOT NULL,
  `id_mapel` varchar(5) NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

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
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `jurusan` int(11) DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `tingkat` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_slider`
--

CREATE TABLE IF NOT EXISTS `tabel_slider` (
  `sliderId` int(11) NOT NULL,
  `sliderUrl` varchar(128) NOT NULL,
  `sliderTitle` varchar(32) NOT NULL,
  `sliderPriority` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_slider`
--

INSERT INTO `tabel_slider` (`sliderId`, `sliderUrl`, `sliderTitle`, `sliderPriority`) VALUES
(1, '72578-peta-tegalarum.png', 'Judul 1', 1),
(2, '02e71-IMG_20141220_201405.jpg', 'Judul 2', 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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
  `id_transaksi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE IF NOT EXISTS `tahun_ajaran` (
  `id_tahun_ajaran` year(4) NOT NULL,
  `tahun_ajaran` varchar(30) NOT NULL,
  `kepala_sekolah` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `u_tabel_mapel_tahunan`
--

CREATE TABLE IF NOT EXISTS `u_tabel_mapel_tahunan` (
  `id_mapel_ta` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `tahun_ajaran` year(4) NOT NULL,
  `semester` int(1) NOT NULL,
  `tingkat` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
-- Indexes for table `tabel_event`
--
ALTER TABLE `tabel_event`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `tabel_galeri`
--
ALTER TABLE `tabel_galeri`
  ADD PRIMARY KEY (`imageId`);

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
-- Indexes for table `tabel_laman`
--
ALTER TABLE `tabel_laman`
  ADD PRIMARY KEY (`pageId`);

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
-- Indexes for table `tabel_pengampu`
--
ALTER TABLE `tabel_pengampu`
  ADD PRIMARY KEY (`id_entry`), ADD UNIQUE KEY `tahun_ajaran` (`tahun_ajaran`,`id_mapel`,`id_kelas`,`id_guru`);

--
-- Indexes for table `tabel_sambutan`
--
ALTER TABLE `tabel_sambutan`
  ADD PRIMARY KEY (`sambutanId`);

--
-- Indexes for table `tabel_siswa`
--
ALTER TABLE `tabel_siswa`
  ADD PRIMARY KEY (`id_siswa`), ADD UNIQUE KEY `nis` (`nis`);

--
-- Indexes for table `tabel_slider`
--
ALTER TABLE `tabel_slider`
  ADD PRIMARY KEY (`sliderId`);

--
-- Indexes for table `tabel_tautan`
--
ALTER TABLE `tabel_tautan`
  ADD PRIMARY KEY (`linkId`);

--
-- Indexes for table `tabel_testi`
--
ALTER TABLE `tabel_testi`
  ADD PRIMARY KEY (`testiId`);

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
-- Indexes for table `u_tabel_mapel_tahunan`
--
ALTER TABLE `u_tabel_mapel_tahunan`
  ADD PRIMARY KEY (`id_mapel_ta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `statistik`
--
ALTER TABLE `statistik`
  MODIFY `kd_statistik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT for table `tabel_berita`
--
ALTER TABLE `tabel_berita`
  MODIFY `newsId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tabel_event`
--
ALTER TABLE `tabel_event`
  MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tabel_galeri`
--
ALTER TABLE `tabel_galeri`
  MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tabel_guru`
--
ALTER TABLE `tabel_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tabel_jurusan`
--
ALTER TABLE `tabel_jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tabel_kelas`
--
ALTER TABLE `tabel_kelas`
  MODIFY `id_kelas` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tabel_kelas_siswa`
--
ALTER TABLE `tabel_kelas_siswa`
  MODIFY `id_entry` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tabel_laman`
--
ALTER TABLE `tabel_laman`
  MODIFY `pageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tabel_mapel`
--
ALTER TABLE `tabel_mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tabel_mapel_jurusan`
--
ALTER TABLE `tabel_mapel_jurusan`
  MODIFY `id_entry` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tabel_pengampu`
--
ALTER TABLE `tabel_pengampu`
  MODIFY `id_entry` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=113;
--
-- AUTO_INCREMENT for table `tabel_sambutan`
--
ALTER TABLE `tabel_sambutan`
  MODIFY `sambutanId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tabel_siswa`
--
ALTER TABLE `tabel_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `tabel_slider`
--
ALTER TABLE `tabel_slider`
  MODIFY `sliderId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tabel_tautan`
--
ALTER TABLE `tabel_tautan`
  MODIFY `linkId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tabel_testi`
--
ALTER TABLE `tabel_testi`
  MODIFY `testiId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `u_tabel_mapel_tahunan`
--
ALTER TABLE `u_tabel_mapel_tahunan`
  MODIFY `id_mapel_ta` int(11) NOT NULL AUTO_INCREMENT;
DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `AutoDeleteOldNotifications` ON SCHEDULE EVERY 1 DAY STARTS '2015-10-29 00:20:56' ON COMPLETION PRESERVE ENABLE DO DELETE FROM `statistik` WHERE `when` < DATE_SUB(NOW(), INTERVAL 3 DAY)$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
