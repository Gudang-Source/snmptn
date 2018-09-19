-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2018 at 04:38 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `porto_snmptn`
--

-- --------------------------------------------------------

--
-- Table structure for table `evaluasi_kelulusan`
--

CREATE TABLE `evaluasi_kelulusan` (
  `id_evaluasi` int(11) NOT NULL,
  `tahun` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `hasil_evaluasi` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nip` char(21) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jurusan_ptn`
--

CREATE TABLE `jurusan_ptn` (
  `id_jurusan_ptn` int(11) NOT NULL,
  `nama_jurusan_ptn` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `tahun_ajaran` varchar(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Triggers `kelas`
--
DELIMITER $$
CREATE TRIGGER `hapus_siswa` BEFORE DELETE ON `kelas` FOR EACH ROW BEGIN
        delete from siswa where id_kelas=OLD.id_kelas;
	END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `kd_mp` char(6) NOT NULL,
  `nama_mp` varchar(100) NOT NULL,
  `kkm` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `jurusan` int(11) NOT NULL,
  `ket_mp_un` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `memilih`
--

CREATE TABLE `memilih` (
  `nis` varchar(20) NOT NULL,
  `kd_ptn_jur` char(6) NOT NULL,
  `status` varchar(20) NOT NULL,
  `tahun_pilih` int(11) NOT NULL,
  `peringkat` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mengambil_mp`
--

CREATE TABLE `mengambil_mp` (
  `nis` varchar(20) NOT NULL,
  `kd_mp` char(6) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mengerjakan_un`
--

CREATE TABLE `mengerjakan_un` (
  `nis` varchar(20) NOT NULL,
  `kd_mp_un` char(5) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nilai_akhir`
--

CREATE TABLE `nilai_akhir` (
  `id_na` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `semester` int(11) NOT NULL,
  `jml_nilai_mp_un` int(11) NOT NULL,
  `jml_nilai_mp` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ptn`
--

CREATE TABLE `ptn` (
  `id_ptn` int(11) NOT NULL,
  `nama_ptn` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ptn_terdiri_dari_jurusan`
--

CREATE TABLE `ptn_terdiri_dari_jurusan` (
  `kd_ptn_jur` char(6) NOT NULL,
  `id_ptn` int(11) NOT NULL,
  `id_jurusan_ptn` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tahun_masuk` int(11) NOT NULL,
  `no_un` char(20) NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Triggers `siswa`
--
DELIMITER $$
CREATE TRIGGER `trg_hapus_nilai_siswa` BEFORE DELETE ON `siswa` FOR EACH ROW BEGIN
DELETE FROM nilai_akhir where nis=OLD.nis;
DELETE FROM mengambil_mp WHERE nis=OLD.nis;
DELETE FROM mengerjakan_un WHERE nis=OLD.nis;
DELETE FROM memilih where nis=OLD.nis;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_siswa_ambil_mp` AFTER INSERT ON `siswa` FOR EACH ROW BEGIN
DECLARE v_jur INTEGER;
DECLARE v_jur_tmb INTEGER;

SELECT id_jurusan INTO v_jur FROM siswa s JOIN kelas k ON (s.id_kelas=k.id_kelas) where nis=NEW.nis;

IF (v_jur=2) THEN
SET v_jur_tmb = 3;
ELSE
SET v_jur_tmb = 2;
END IF;

call proc_siswa_ambil_mp(NEW.nis, v_jur_tmb);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ujian_nasional`
--

CREATE TABLE `ujian_nasional` (
  `kd_mp_un` char(5) NOT NULL,
  `nama_mp` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evaluasi_kelulusan`
--
ALTER TABLE `evaluasi_kelulusan`
  ADD PRIMARY KEY (`id_evaluasi`),
  ADD UNIQUE KEY `tahun` (`tahun`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `jurusan_ptn`
--
ALTER TABLE `jurusan_ptn`
  ADD PRIMARY KEY (`id_jurusan_ptn`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `fk_kelas_jurusan` (`id_jurusan`),
  ADD KEY `fk_kelas_guru` (`id_guru`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`kd_mp`),
  ADD KEY `fk_mp_jurusan` (`jurusan`);

--
-- Indexes for table `memilih`
--
ALTER TABLE `memilih`
  ADD PRIMARY KEY (`nis`,`kd_ptn_jur`),
  ADD KEY `fk_siswa_memilih` (`nis`),
  ADD KEY `fk_memilih_ptn_jur` (`kd_ptn_jur`);

--
-- Indexes for table `mengambil_mp`
--
ALTER TABLE `mengambil_mp`
  ADD PRIMARY KEY (`nis`,`kd_mp`),
  ADD KEY `fk_ambil_mp_siswa` (`nis`),
  ADD KEY `fk_ambil_mp` (`kd_mp`);

--
-- Indexes for table `mengerjakan_un`
--
ALTER TABLE `mengerjakan_un`
  ADD PRIMARY KEY (`nis`,`kd_mp_un`),
  ADD KEY `fk_nilai_un_siswa` (`nis`),
  ADD KEY `fk_nilai_un_mp` (`kd_mp_un`);

--
-- Indexes for table `nilai_akhir`
--
ALTER TABLE `nilai_akhir`
  ADD PRIMARY KEY (`id_na`),
  ADD KEY `fk_na_siswa` (`nis`);

--
-- Indexes for table `ptn`
--
ALTER TABLE `ptn`
  ADD PRIMARY KEY (`id_ptn`);

--
-- Indexes for table `ptn_terdiri_dari_jurusan`
--
ALTER TABLE `ptn_terdiri_dari_jurusan`
  ADD PRIMARY KEY (`kd_ptn_jur`),
  ADD KEY `fk_ptn` (`id_ptn`),
  ADD KEY `fk_jurusan_ptn` (`id_jurusan_ptn`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `fk_siswa_kelas` (`id_kelas`);

--
-- Indexes for table `ujian_nasional`
--
ALTER TABLE `ujian_nasional`
  ADD PRIMARY KEY (`kd_mp_un`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evaluasi_kelulusan`
--
ALTER TABLE `evaluasi_kelulusan`
  MODIFY `id_evaluasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `jurusan_ptn`
--
ALTER TABLE `jurusan_ptn`
  MODIFY `id_jurusan_ptn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `nilai_akhir`
--
ALTER TABLE `nilai_akhir`
  MODIFY `id_na` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18156;
--
-- AUTO_INCREMENT for table `ptn`
--
ALTER TABLE `ptn`
  MODIFY `id_ptn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
