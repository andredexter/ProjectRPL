-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09 Jun 2014 pada 14.44
-- Versi Server: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `salsainternational`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen`
--

CREATE TABLE IF NOT EXISTS `absen` (
  `id_absen` int(5) NOT NULL AUTO_INCREMENT,
  `bulan` date NOT NULL,
  `jumlah_absen` int(5) NOT NULL,
  `id_pengajar` int(5) DEFAULT NULL,
  `hadir_pengajar` int(5) NOT NULL,
  `id_siswa` int(5) DEFAULT NULL,
  `hadir_siswa` int(5) NOT NULL,
  PRIMARY KEY (`id_absen`),
  KEY `id_pengajar` (`id_pengajar`),
  KEY `id_siswa` (`id_siswa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `absen`
--

INSERT INTO `absen` (`id_absen`, `bulan`, `jumlah_absen`, `id_pengajar`, `hadir_pengajar`, `id_siswa`, `hadir_siswa`) VALUES
(1, '2014-06-01', 4, 1, 4, 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hari`
--

CREATE TABLE IF NOT EXISTS `hari` (
  `id_hari` int(5) NOT NULL AUTO_INCREMENT,
  `nama_hari` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_hari`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data untuk tabel `hari`
--

INSERT INTO `hari` (`id_hari`, `nama_hari`) VALUES
(1, 'Senin'),
(2, 'Selasa'),
(3, 'Rabu'),
(4, 'Kamis'),
(5, 'Jumat'),
(6, 'Sabtu'),
(7, 'Minggu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `instrument`
--

CREATE TABLE IF NOT EXISTS `instrument` (
  `id_instrument` int(5) NOT NULL AUTO_INCREMENT,
  `nama_instrument` varchar(20) NOT NULL,
  `biaya_instrument` int(15) NOT NULL,
  PRIMARY KEY (`id_instrument`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data untuk tabel `instrument`
--

INSERT INTO `instrument` (`id_instrument`, `nama_instrument`, `biaya_instrument`) VALUES
(7, 'Gitar', 500000),
(9, 'Seriosa', 1200000),
(10, 'Sasando', 1000000),
(11, 'Terompet', 200000),
(12, 'Pluit', 50000),
(13, 'Talempong', 150000),
(14, 'Bass', 240000),
(15, 'Harmonika', 150000),
(16, 'Gong', 100000),
(17, 'Seruling', 150000),
(19, 'Ukulele', 100000),
(20, 'Piano', 1000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE IF NOT EXISTS `jadwal` (
  `id_jadwal` int(5) NOT NULL AUTO_INCREMENT,
  `id_shift` int(5) NOT NULL,
  `id_pengajar` int(5) NOT NULL,
  `id_siswa` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `id_shift` (`id_shift`,`id_pengajar`,`id_siswa`),
  KEY `id_pengajar` (`id_pengajar`),
  KEY `id_siswa` (`id_siswa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_shift`, `id_pengajar`, `id_siswa`) VALUES
(1, 8, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `jenis` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`username`, `password`, `jenis`) VALUES
('admin', '827ccb0eea8a706c4c34a16891f84e7b', 'admin'),
('pemilik', '827ccb0eea8a706c4c34a16891f84e7b', 'pemilik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembagian`
--

CREATE TABLE IF NOT EXISTS `pembagian` (
  `id_bagi` int(5) NOT NULL AUTO_INCREMENT,
  `id_absen` int(5) NOT NULL,
  `jumlah_pengajar` int(15) NOT NULL,
  `jumlah_management` int(15) NOT NULL,
  PRIMARY KEY (`id_bagi`),
  KEY `id_absen` (`id_absen`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `pembagian`
--

INSERT INTO `pembagian` (`id_bagi`, `id_absen`, `jumlah_pengajar`, `jumlah_management`) VALUES
(1, 25, 540000, 660000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE IF NOT EXISTS `pembayaran` (
  `id_pembayaran` int(5) NOT NULL AUTO_INCREMENT,
  `bulan` date NOT NULL,
  `id_siswa` int(5) NOT NULL,
  `jumlah` int(15) NOT NULL,
  PRIMARY KEY (`id_pembayaran`),
  KEY `id_siswa` (`id_siswa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `bulan`, `id_siswa`, `jumlah`) VALUES
(1, '2014-06-01', 2, 500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajar`
--

CREATE TABLE IF NOT EXISTS `pengajar` (
  `id_pengajar` int(5) NOT NULL AUTO_INCREMENT,
  `nama_pengajar` varchar(40) NOT NULL,
  `tempat_lahir` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `pendidikan` varchar(20) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_pengajar`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `pengajar`
--

INSERT INTO `pengajar` (`id_pengajar`, `nama_pengajar`, `tempat_lahir`, `tanggal_lahir`, `pendidikan`, `alamat`, `telepon`) VALUES
(1, 'fajar lazuardi', 'padang', '1992-09-24', 'master', 'padang', '097987987987'),
(2, 'adji', 'padang', '1993-07-24', 'Master1', 'padang', '087895435450');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `nama_setting` varchar(20) NOT NULL DEFAULT '',
  `value` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`nama_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `setting`
--

INSERT INTO `setting` (`nama_setting`, `value`) VALUES
('alamat', 'Jl.Adinegoro, Perum Indah Pratama Blok C 8, Lubuk '),
('judul', 'Aplikasi Penggajian Salsa'),
('kota', 'Padang'),
('nama', 'Salsa International Music School'),
('pemilik', 'Salsa International'),
('telepon', '0751-481635');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shift`
--

CREATE TABLE IF NOT EXISTS `shift` (
  `id_shift` int(5) NOT NULL AUTO_INCREMENT,
  `id_hari` int(5) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_akhir` time DEFAULT NULL,
  PRIMARY KEY (`id_shift`),
  KEY `id_hari` (`id_hari`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `shift`
--

INSERT INTO `shift` (`id_shift`, `id_hari`, `jam_mulai`, `jam_akhir`) VALUES
(2, 2, '07:00:00', '08:00:00'),
(3, 3, '07:00:00', '08:00:00'),
(4, 4, '07:00:00', '08:00:00'),
(5, 5, '07:00:00', '08:00:00'),
(6, 6, '07:00:00', '08:00:00'),
(7, 7, '07:00:00', '08:00:00'),
(8, 2, '08:00:00', '09:00:00'),
(9, 3, '08:00:00', '09:00:00'),
(10, 4, '08:00:00', '09:00:00'),
(11, 6, '08:00:00', '09:00:00'),
(12, 1, '07:00:00', '08:15:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE IF NOT EXISTS `siswa` (
  `id_siswa` int(5) NOT NULL AUTO_INCREMENT,
  `nama_siswa` varchar(40) NOT NULL,
  `tempat_lahir` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `uang_masuk` int(15) NOT NULL,
  `id_tingkat` int(5) DEFAULT NULL,
  `id_instrument` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_siswa`),
  KEY `id_instrument` (`id_instrument`),
  KEY `id_tingkat` (`id_tingkat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `telepon`, `tanggal_masuk`, `uang_masuk`, `id_tingkat`, `id_instrument`) VALUES
(2, 'Andre Triandi Putra', 'Bukittinggi', '2014-05-06', 'Baso Agam', '083182501923', '2014-05-05', 400000, 2, 7),
(7, 'Nisa Dwi Angresti', 'Padang', '2008-04-27', 'Padang', '0912380123', '2014-05-28', 450000, 2, 9),
(8, 'Yudhi Hartadi', 'Padang', '1994-05-28', 'Jakarta', '90812313', '2014-05-28', 400000, 4, 10),
(9, 'Hafiz Fajrin', 'Padang', '1993-05-02', 'Padang', '01390123', '2014-05-28', 400000, 3, 9),
(10, 'Dina Apriana', 'Lubuk Basung', '1993-02-20', 'Lubuk Basuang', '02093', '2014-05-29', 350000, 3, 9),
(15, 'Syaiful Afdhal', 'Padang', '1993-02-20', 'Lubuk Basuang', '02093', '2014-06-25', 400000, 3, 9),
(18, 'M Rizki Darmawan', 'Padang', '2006-06-03', 'Pariaman', '20932380', '2014-06-03', 425000, 1, 11),
(19, 'Fandi Ihsan', 'Bukittinggi', '1998-06-05', 'Lubuk Sikaping', '232931802', '2014-06-05', 560000, 2, 14),
(20, 'Lewat PHPUnit', 'PHP', '2014-05-05', 'XAMPP', '404', '2014-06-06', 4000, 1, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tingkat`
--

CREATE TABLE IF NOT EXISTS `tingkat` (
  `id_tingkat` int(5) NOT NULL AUTO_INCREMENT,
  `class` int(11) NOT NULL,
  `nama_tingkat` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_tingkat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `tingkat`
--

INSERT INTO `tingkat` (`id_tingkat`, `class`, `nama_tingkat`) VALUES
(1, 0, 'Pemula'),
(2, 1, 'Tingkat 1'),
(3, 2, 'Tingkat 2'),
(4, 3, 'Tingkat 3'),
(5, 4, 'Tamat');

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absen`
--
ALTER TABLE `absen`
  ADD CONSTRAINT `absen_ibfk_2` FOREIGN KEY (`id_pengajar`) REFERENCES `pengajar` (`id_pengajar`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `absen_ibfk_3` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_shift`) REFERENCES `shift` (`id_shift`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_pengajar`) REFERENCES `pengajar` (`id_pengajar`),
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembagian`
--
ALTER TABLE `pembagian`
  ADD CONSTRAINT `pembagian_ibfk_1` FOREIGN KEY (`id_absen`) REFERENCES `absen` (`id_absen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `shift_ibfk_1` FOREIGN KEY (`id_hari`) REFERENCES `hari` (`id_hari`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_instrument`) REFERENCES `instrument` (`id_instrument`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`id_tingkat`) REFERENCES `tingkat` (`id_tingkat`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
