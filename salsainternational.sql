-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10 Jun 2014 pada 13.28
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `absen`
--

INSERT INTO `absen` (`id_absen`, `bulan`, `jumlah_absen`, `id_pengajar`, `hadir_pengajar`, `id_siswa`, `hadir_siswa`) VALUES
(1, '2014-06-01', 4, 2, 4, 1, 4),
(2, '2014-06-01', 4, 4, 3, 2, 4),
(3, '2014-06-01', 4, 3, 4, 3, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data untuk tabel `instrument`
--

INSERT INTO `instrument` (`id_instrument`, `nama_instrument`, `biaya_instrument`) VALUES
(1, 'Guitar Electric', 200000),
(2, 'Piano Pop', 250000),
(3, 'Drum', 300000),
(4, 'Violin', 200000),
(5, 'Cello', 300000),
(6, 'Contrabass', 200000),
(7, 'Piano Jazz', 250000),
(8, 'Piano Classic', 300000),
(9, 'Keyboard', 340000),
(10, 'Saxophone', 400000),
(11, 'Guitar Bass', 320000);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_shift`, `id_pengajar`, `id_siswa`) VALUES
(1, 1, 2, 1),
(3, 4, 3, 3),
(2, 13, 4, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `pembagian`
--

INSERT INTO `pembagian` (`id_bagi`, `id_absen`, `jumlah_pengajar`, `jumlah_management`) VALUES
(1, 1, 144000, 176000),
(2, 2, 101250, 198750),
(3, 3, 90000, 110000);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `bulan`, `id_siswa`, `jumlah`) VALUES
(1, '2014-06-01', 1, 320000),
(2, '2014-06-01', 2, 300000),
(3, '2014-06-01', 3, 200000);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `pengajar`
--

INSERT INTO `pengajar` (`id_pengajar`, `nama_pengajar`, `tempat_lahir`, `tanggal_lahir`, `pendidikan`, `alamat`, `telepon`) VALUES
(1, 'Juan A. Mayon', 'Jakarta', '1980-04-21', 'Sarjana', 'Jl.Patimura No 2, Padang', '083180247283'),
(2, 'Jason Holmes', 'Bandung', '1984-08-24', 'Sarjana', 'Jl.Adiyawarman No 3 Padang', '083616228383'),
(3, 'Ernest Gaskill', 'Padang', '1988-02-10', 'Sarjana', 'Jl.CahLontong 23 Padang Panjang', '08292824123'),
(4, 'Pierre Swift', 'Bukittinggi', '1989-10-03', 'Sarjana', 'Jl.Hihihihihihi 3 Padang', '0927312334');

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
('alamat', 'Jl.Adinegoro, Perum Indah Pratama Blok C8 Simp Rum'),
('judul', 'Penggajian Pengajar'),
('kota', 'Padang'),
('nama', 'Salsha International Music School'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data untuk tabel `shift`
--

INSERT INTO `shift` (`id_shift`, `id_hari`, `jam_mulai`, `jam_akhir`) VALUES
(1, 2, '07:00:00', '08:00:00'),
(2, 2, '08:00:00', '09:00:00'),
(3, 3, '07:00:00', '08:00:00'),
(4, 3, '08:00:00', '09:00:00'),
(5, 4, '07:00:00', '08:00:00'),
(6, 4, '08:00:00', '09:00:00'),
(7, 5, '07:00:00', '08:00:00'),
(8, 5, '08:00:00', '09:00:00'),
(9, 6, '08:00:00', '09:00:00'),
(10, 6, '07:00:00', '08:00:00'),
(11, 7, '07:00:00', '08:00:00'),
(12, 7, '08:00:00', '09:00:00'),
(13, 3, '09:00:00', '10:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `telepon`, `tanggal_masuk`, `uang_masuk`, `id_tingkat`, `id_instrument`) VALUES
(1, 'Andre Triandi Putra', 'Bukittinggi', '1993-05-02', 'Sungai Cubadak, Kecamatan Baso, Agam', '083182501923', '2014-06-10', 300000, 1, 11),
(2, 'Hafiz Fajrin', 'Padang', '1993-06-10', 'Padang', '082929292929', '2014-06-10', 300000, 2, 8),
(3, 'Nisa Dwi Angresti', 'Padang', '1994-03-11', 'Padang', '020932332', '2014-06-10', 300000, 1, 4);

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
