-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2020 at 09:06 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beasiswa_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `beasiswa`
--

CREATE TABLE `beasiswa` (
  `kd_beasiswa` int(11) NOT NULL,
  `nama_bsw` varchar(50) DEFAULT NULL,
  `kuota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beasiswa`
--

INSERT INTO `beasiswa` (`kd_beasiswa`, `nama_bsw`, `kuota`) VALUES
(1, 'Beasiswa PPA', 10),
(3, 'Beasiswa BIDIKMISI', 10);

-- --------------------------------------------------------

--
-- Table structure for table `hasil`
--

CREATE TABLE `hasil` (
  `kd_hasil` int(11) NOT NULL,
  `kd_beasiswa` int(11) NOT NULL,
  `nim` char(10) NOT NULL,
  `nilai` float DEFAULT NULL,
  `tahun` char(4) DEFAULT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil`
--

INSERT INTO `hasil` (`kd_hasil`, `kd_beasiswa`, `nim`, `nilai`, `tahun`, `status`) VALUES
(1, 1, '1671100038', 0.9125, '2020', 'Diterima'),
(2, 1, '1671100002', 0.925, '2020', 'Diterima'),
(3, 1, '1713100013', 0.7, '2020', 'Diterima'),
(4, 3, '1613100013', 0.675, '2020', 'Diterima'),
(5, 3, '1671100054', 0.7125, '2020', 'Diterima'),
(6, 3, '1621100057', 0.591667, '2020', 'Diterima'),
(7, 1, '1621100023', 0.725, '2020', 'Diterima'),
(9, 1, '1811300004', 0.65, '2020', 'Diterima'),
(10, 3, '1813100016', 0.7875, '2020', 'Diterima'),
(11, 3, '1911200016', 0.725, '2020', 'Diterima'),
(12, 1, '171100054', 0.725, '2020', 'Diterima'),
(13, 3, '1713100015', 0.6125, '2020', 'Diterima'),
(15, 3, '7867878686', 0.804167, '2018', 'Diterima'),
(16, 3, '7867878686', 0.804167, '2017', 'Diterima'),
(17, 3, '7867878686', 0.804167, '', 'Diterima'),
(18, 3, '3245352624', 0.591667, '', 'Diterima'),
(19, 3, '9827439876', 0.9, '', 'Diterima');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `kd_kriteria` int(11) NOT NULL,
  `kd_beasiswa` int(11) NOT NULL,
  `nama_ktra` varchar(50) DEFAULT NULL,
  `sifat` enum('min','max') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`kd_kriteria`, `kd_beasiswa`, `nama_ktra`, `sifat`) VALUES
(2, 1, 'ORMAWA yang diikuti', 'max'),
(3, 1, 'Jabatan di ORMAWA', 'max'),
(4, 1, 'Pembuatan PKM', 'max'),
(9, 1, 'IPK', 'max'),
(10, 3, 'Pendidikan Orang Tua', 'min'),
(11, 3, 'Penghasilan Orang Tua', 'min'),
(12, 3, 'Tanggungan Orang Tua', 'max'),
(13, 3, 'Piagam Penghargaan', 'max'),
(16, 1, 'Jumlah SKS', 'max'),
(17, 1, 'Penghasilan Orang Tua', 'min'),
(18, 1, 'Prestasi', 'max');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` char(10) NOT NULL,
  `nama_mhs` varchar(30) NOT NULL,
  `semester` varchar(5) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tahun_mengajukan` char(4) NOT NULL,
  `jurusan` varchar(30) NOT NULL,
  `kd_pengguna` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama_mhs`, `semester`, `alamat`, `jenis_kelamin`, `tahun_mengajukan`, `jurusan`, `kd_pengguna`) VALUES
('1613100013', 'Ika Umi Sholikhah', '8', 'Klaten', 'Perempuan', '2020', 'Pend. Matematika', 4),
('1621100023', 'Ilham Rifky Rahmana', '8', 'Klaten', 'Laki-laki', '2020', 'Manajemen Ekonomi', 5),
('1621100057', 'Fitriana Wulandari', '6', 'Boyolali', 'Perempuan', '2020', 'THP', 6),
('1671100002', 'Intan Agustina', '8', 'Klaten', 'Perempuan', '2020', 'Teknik Informatika', 7),
('1671100038', 'Antok Purwanto', '8', 'Klaten', 'Laki-laki', '2020', 'Teknik Informatika', 8),
('1671100054', 'Afredo Ade Putra', '8', 'Yogyakarta', 'Laki-laki', '2020', 'Teknik Informatika', 9),
('171100054', 'Hendrik Joko', '6', 'Klaten', 'Laki-laki', '2020', 'PGSD', 10),
('1713100013', 'Eginia Dhea Nadilla', '6', 'Klaten', 'Perempuan', '2020', 'PGSD', 11),
('1713100015', 'Kuni Musliha', '6', 'Yogyakarta', 'Perempuan', '2020', 'PGSD', 12),
('1715100014', 'Fitriana Wulandari', '6', 'Klaten', 'Perempuan', '2020', 'Pend. Matematika', 13),
('1811300004', 'Muhammad Iqbal Saifudin', '4', 'Batang', 'Laki-laki', '2020', 'Teknik Sipil', 14),
('1813100016', 'Umar Khodir ', '4', 'Klaten', 'Laki-laki', '2020', 'Teknik Sipil', 15),
('1911200016', 'Galuh Prastiwi', '2', 'Klaten', 'Perempuan', '2020', 'Pend. Geografi', 16),
('3245352624', 'yayayaay', '6', 'Klaten', 'Perempuan', '2018', 'Fisika', 34),
('7867878686', 'tes', '78', 'klaten', 'Laki-laki', '2017', 'fisika', 37),
('9827439876', 'mahasiswi', '12', 'Semarang', 'Perempuan', '2017', 'Teknik Informatika', 38);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `kd_nilai` int(11) NOT NULL,
  `kd_beasiswa` int(11) DEFAULT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `nim` char(10) NOT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`kd_nilai`, `kd_beasiswa`, `kd_kriteria`, `nim`, `nilai`) VALUES
(1, 1, 2, '1671100038', 4),
(2, 1, 3, '1671100038', 4),
(3, 1, 4, '1671100038', 4),
(4, 1, 9, '1671100038', 3),
(5, 1, 16, '1671100038', 4),
(6, 1, 17, '1671100038', 3),
(7, 1, 18, '1671100038', 4),
(8, 1, 2, '1671100002', 3),
(9, 1, 3, '1671100002', 4),
(10, 1, 4, '1671100002', 4),
(11, 1, 9, '1671100002', 4),
(12, 1, 16, '1671100002', 4),
(13, 1, 17, '1671100002', 2),
(14, 1, 18, '1671100002', 3),
(15, 1, 2, '1713100013', 2),
(16, 1, 3, '1713100013', 3),
(17, 1, 4, '1713100013', 4),
(18, 1, 9, '1713100013', 4),
(19, 1, 16, '1713100013', 1),
(20, 1, 17, '1713100013', 3),
(21, 1, 18, '1713100013', 3),
(22, 3, 10, '1613100013', 2),
(23, 3, 11, '1613100013', 3),
(24, 3, 12, '1613100013', 2),
(25, 3, 13, '1613100013', 2),
(26, 3, 10, '1671100054', 2),
(27, 3, 11, '1671100054', 3),
(28, 3, 12, '1671100054', 1),
(29, 3, 13, '1671100054', 4),
(30, 3, 10, '1621100057', 3),
(31, 3, 11, '1621100057', 4),
(32, 3, 12, '1621100057', 2),
(33, 3, 13, '1621100057', 3),
(34, 1, 2, '1621100023', 3),
(35, 1, 3, '1621100023', 4),
(36, 1, 4, '1621100023', 4),
(37, 1, 9, '1621100023', 3),
(38, 1, 16, '1621100023', 1),
(39, 1, 17, '1621100023', 3),
(40, 1, 18, '1621100023', 3),
(48, 1, 2, '1811300004', 3),
(49, 1, 3, '1811300004', 1),
(50, 1, 4, '1811300004', 4),
(51, 1, 9, '1811300004', 3),
(52, 1, 16, '1811300004', 1),
(53, 1, 17, '1811300004', 3),
(54, 1, 18, '1811300004', 3),
(55, 3, 10, '1813100016', 2),
(56, 3, 11, '1813100016', 3),
(57, 3, 12, '1813100016', 3),
(58, 3, 13, '1813100016', 3),
(59, 3, 10, '1911200016', 2),
(60, 3, 11, '1911200016', 3),
(61, 3, 12, '1911200016', 2),
(62, 3, 13, '1911200016', 3),
(63, 1, 2, '171100054', 3),
(64, 1, 3, '171100054', 4),
(65, 1, 4, '171100054', 4),
(66, 1, 9, '171100054', 2),
(67, 1, 16, '171100054', 2),
(68, 1, 17, '171100054', 3),
(69, 1, 18, '171100054', 3),
(70, 3, 10, '1713100015', 4),
(71, 3, 11, '1713100015', 4),
(72, 3, 12, '1713100015', 3),
(73, 3, 13, '1713100015', 3),
(97, 3, 10, '3245352624', 3),
(98, 3, 11, '3245352624', 3),
(99, 3, 12, '3245352624', 2),
(100, 3, 13, '3245352624', 2),
(101, 3, 10, '7867878686', 3),
(102, 3, 11, '7867878686', 2),
(103, 3, 12, '7867878686', 3),
(104, 3, 13, '7867878686', 3),
(105, 3, 10, '9827439876', 2),
(106, 3, 11, '9827439876', 3),
(107, 3, 12, '9827439876', 4),
(108, 3, 13, '9827439876', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pembagian_nilai`
--

CREATE TABLE `pembagian_nilai` (
  `kd_model` int(11) NOT NULL,
  `kd_beasiswa` int(11) NOT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `bobot_model` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembagian_nilai`
--

INSERT INTO `pembagian_nilai` (`kd_model`, `kd_beasiswa`, `kd_kriteria`, `bobot_model`) VALUES
(2, 1, 2, '0.15'),
(3, 1, 3, '0.10'),
(12, 1, 4, '0.15'),
(15, 1, 9, '0.15'),
(16, 3, 10, '0.25'),
(17, 3, 11, '0.30'),
(18, 3, 12, '0.25'),
(20, 3, 13, '0.20'),
(21, 1, 16, '0.15'),
(22, 1, 17, '0.15'),
(23, 1, 18, '0.15');

-- --------------------------------------------------------

--
-- Table structure for table `pembobotan`
--

CREATE TABLE `pembobotan` (
  `kd_pembobotan` int(11) NOT NULL,
  `kd_beasiswa` int(11) DEFAULT NULL,
  `kd_kriteria` int(11) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `bobot_nilai` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembobotan`
--

INSERT INTO `pembobotan` (`kd_pembobotan`, `kd_beasiswa`, `kd_kriteria`, `keterangan`, `bobot_nilai`) VALUES
(40, 1, 2, '3 ORMAWA atau lebih', 4),
(41, 1, 2, '2 ORMAWA', 3),
(42, 1, 2, '1 ORMAWA', 2),
(43, 1, 2, 'Tidak Ikut ORMAWA', 1),
(44, 1, 3, 'Ketua & Wakil', 4),
(45, 1, 3, 'Sekretaris', 3),
(46, 1, 3, 'Bendahara', 2),
(47, 1, 3, 'Staf', 1),
(48, 1, 4, 'Iya', 4),
(49, 1, 4, 'Tidak', 0),
(54, 1, 9, '3.76 - 4.00', 4),
(55, 1, 9, '3.51 - 3.75', 3),
(56, 1, 9, '3.26 - 3.50', 2),
(57, 1, 9, '3.00 - 3.25', 1),
(58, 3, 10, 'SD', 4),
(59, 3, 10, 'SMP', 3),
(60, 3, 10, 'SMA/SMK', 2),
(61, 3, 10, 'S1-S3', 1),
(62, 3, 11, '<500.000 per bulan', 4),
(63, 3, 11, '600.000 - 1.500.000 ', 3),
(64, 3, 11, '1.600.000-2.500.000', 2),
(65, 3, 11, 'â‰¥2.600.000', 1),
(66, 3, 12, '>7 orang', 4),
(67, 3, 12, '5 - 6 orang', 3),
(68, 3, 12, '3 - 4 orang', 2),
(69, 3, 12, '1 - 2 orang', 1),
(70, 3, 13, '3 piagam atau lebih', 4),
(71, 3, 13, '2 piagam', 3),
(72, 3, 13, '1 piagam', 2),
(73, 3, 13, 'Tidak punya piagam', 1),
(78, 1, 17, '<500.000 per bulan', 4),
(79, 1, 17, '600.000-1.500.000', 3),
(80, 1, 17, '1.600.000-2.500.000', 2),
(81, 1, 17, 'â‰¥2.600.000', 1),
(82, 1, 18, '3 piagam atau lebih', 4),
(83, 1, 18, '2 piagam', 3),
(84, 1, 18, '1 piagam', 2),
(85, 1, 18, 'Tidak ada', 1),
(87, 1, 16, '2:42/ 4:90/ 6:138SKS', 3),
(88, 1, 16, '2:40/ 4:88/ 6:134SKS', 2),
(91, 1, 16, '2:38/ 4:86/ 6:130SKS', 1),
(94, 1, 16, '2:44/ 4:92/ 6:140SKS', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `kd_pengguna` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `status` enum('admin','pimpinan','mahasiswa') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`kd_pengguna`, `username`, `password`, `status`) VALUES
(1, 'admin', 'd948aaa56650bd41f6add6f2fe7d2dbd', 'admin'),
(2, 'pimpinan', '7d3207a13dc221ac13c2f3dac3011f50', 'pimpinan'),
(3, 'Mahasiswa', 'b398b8a18ef4f69811a32cf169946bac', 'mahasiswa'),
(4, 'ika', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(5, 'ilham', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(6, 'fitriana', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(7, 'intan', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(8, 'antok', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(9, 'afredo', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(10, 'hendrik', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(11, 'eginia', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(12, 'kuni', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(13, 'fitriana_w', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(14, 'iqbal', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(15, 'umar', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(16, 'galuh', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa'),
(34, 'ya', '97c4389697098d2d13ad3f9c1a3382f8', 'mahasiswa'),
(35, 'yaya', '866c79485e52c27aec9556129b274a27', 'mahasiswa'),
(36, 'qwerty', '3fc0a7acf087f549ac2b266baf94b8b1', 'mahasiswa'),
(37, 'tes', 'b93939873fd4923043b9dec975811f66', 'mahasiswa'),
(38, 'mahasiswi', 'e10adc3949ba59abbe56e057f20f883e', 'mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD PRIMARY KEY (`kd_beasiswa`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`kd_hasil`),
  ADD KEY `fk_beasiswa` (`kd_beasiswa`),
  ADD KEY `nim` (`nim`),
  ADD KEY `fk_mahasiswa` (`nim`) USING BTREE;

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`kd_kriteria`),
  ADD KEY `kd_beasiswa` (`kd_beasiswa`),
  ADD KEY `kd_beasiswa_2` (`kd_beasiswa`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`kd_nilai`),
  ADD KEY `fk_kriteria` (`kd_kriteria`),
  ADD KEY `fk_mahasiswa` (`nim`),
  ADD KEY `fk_beasiswa` (`kd_beasiswa`);

--
-- Indexes for table `pembagian_nilai`
--
ALTER TABLE `pembagian_nilai`
  ADD PRIMARY KEY (`kd_model`),
  ADD KEY `fk_kriteria` (`kd_kriteria`),
  ADD KEY `fk_beasiswa` (`kd_beasiswa`);

--
-- Indexes for table `pembobotan`
--
ALTER TABLE `pembobotan`
  ADD PRIMARY KEY (`kd_pembobotan`),
  ADD KEY `fk_kriteria` (`kd_kriteria`),
  ADD KEY `fk_beasiswa` (`kd_beasiswa`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`kd_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beasiswa`
--
ALTER TABLE `beasiswa`
  MODIFY `kd_beasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `kd_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `kd_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `kd_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `pembagian_nilai`
--
ALTER TABLE `pembagian_nilai`
  MODIFY `kd_model` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pembobotan`
--
ALTER TABLE `pembobotan`
  MODIFY `kd_pembobotan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `kd_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_2` FOREIGN KEY (`kd_beasiswa`) REFERENCES `beasiswa` (`kd_beasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_ibfk_3` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD CONSTRAINT `fk_beasiswa` FOREIGN KEY (`kd_beasiswa`) REFERENCES `beasiswa` (`kd_beasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`kd_beasiswa`) REFERENCES `beasiswa` (`kd_beasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_4` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_5` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembagian_nilai`
--
ALTER TABLE `pembagian_nilai`
  ADD CONSTRAINT `pembagian_nilai_ibfk_2` FOREIGN KEY (`kd_beasiswa`) REFERENCES `beasiswa` (`kd_beasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembagian_nilai_ibfk_3` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembobotan`
--
ALTER TABLE `pembobotan`
  ADD CONSTRAINT `pembobotan_ibfk_2` FOREIGN KEY (`kd_beasiswa`) REFERENCES `beasiswa` (`kd_beasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembobotan_ibfk_3` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
