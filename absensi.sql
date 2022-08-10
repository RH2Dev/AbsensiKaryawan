-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 10 Agu 2022 pada 08.29
-- Versi server: 5.7.36
-- Versi PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth`
--

DROP TABLE IF EXISTS `auth`;
CREATE TABLE IF NOT EXISTS `auth` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nik` decimal(11,0) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `auth`
--

INSERT INTO `auth` (`admin_id`, `username`, `email`, `password`, `nik`, `created_at`, `updated_at`) VALUES
(7, 'sujakcingur', 'sujak@email.com', '$2y$10$8SYAp.kj3V4EimNrqvx4s.hZn6g7MO/6xWZJtTeg3VWke7fyGpaNi', '12345677', '2022-08-05 10:48:18', '2022-08-05 15:22:46'),
(4, 'denydeny', 'deny@gmail.com', '$2y$10$/35.tGFcjXK6MrEL5uhPne3U/wK7xiOVycXHpnXxcF22zA8EPSGmi', '12345678', '2022-08-04 14:36:13', '2022-08-04 14:36:13'),
(6, 'bayuskak', 'bayu@email.com', '$2y$10$PYD0ScwUmDS1g07ybyZRgO4pKJI/8DXbWmCiiWSeOe1J5yVO2.uyi', '12345679', '2022-08-05 10:47:48', '2022-08-05 10:47:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_absen`
--

DROP TABLE IF EXISTS `data_absen`;
CREATE TABLE IF NOT EXISTS `data_absen` (
  `absen_id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` decimal(11,0) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `photoCheckout` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `latCheckout` varchar(255) NOT NULL,
  `longCheckout` varchar(255) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `checkout` datetime DEFAULT NULL,
  PRIMARY KEY (`absen_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_absen`
--

INSERT INTO `data_absen` (`absen_id`, `nik`, `photo`, `photoCheckout`, `latitude`, `longitude`, `latCheckout`, `longCheckout`, `tanggal`, `checkout`) VALUES
(1, '19990510', 'romihaidar.jpg', '', '-7.8156507', '110.416324', '', '', '2022-08-04 10:45:36', NULL),
(6, '19990510', '62eb42f2611680.81296207-19990510.jpg', '', '-7.8156507', '110.416324', '', '', '2022-08-04 10:54:26', NULL),
(7, '19990510', '62eb47ed62fa52.05866918-19990510.jpg', '', '-7.8156558', '110.416323', '', '', '2022-08-04 11:15:41', NULL),
(8, '1234567810', '62f0af933da741.92121144-1234567810.jpg', '', '-7.8156571', '110.4163295', '', '', '2022-08-08 13:39:15', NULL),
(9, '12345678911', '62f0afafab7606.98235392-12345678911.jpg', '', '-7.815662', '110.416327', '', '', '2022-08-08 13:39:43', NULL),
(10, '19990510', '62f0afc2965606.24309418-19990510.jpg', '', '-7.815662', '110.416327', '', '', '2022-08-08 13:40:02', NULL),
(11, '19990510', '62f1c794189a85.45167819-19990510.jpg', '', '-7.8245119', '110.414304', '', '', '2022-08-09 09:33:56', NULL),
(12, '19990510', '62f202de71b577.53251020-19990510.jpg', '', '-7.8245119', '110.414304', '', '', '2022-08-09 13:46:54', NULL),
(13, '1234567810', '62f20368699467.19907999-1234567810.jpg', '', '-7.8156497', '110.4163074', '', '', '2022-08-09 13:49:12', NULL),
(14, '12345678911', '62f203cae73771.49514414-12345678911.jpg', '', '-7.815647', '110.4162911', '', '', '2022-08-09 13:50:50', NULL),
(15, '19990510', '62f20634c2f6e8.61022867-19990510.jpg', '', '-7.8245119', '110.414304', '', '', '2022-08-09 14:01:08', NULL),
(21, '19990510', '62f328688d9079.31023325-19990510.jpg', '62f328797930f6.96721475-19990510.jpg', '-7.8156567', '110.4163364', '-7.8156545', '110.4163125', '2022-08-10 10:39:20', '2022-08-10 10:39:37'),
(22, '1234567810', '62f33b5aeaa1a7.08093842-1234567810.jpg', '62f33b6a6e8621.12525135-1234567810.jpg', '-7.8156557', '110.4163145', '-7.8156557', '110.4163145', '2022-08-10 12:00:10', '2022-08-10 12:00:26'),
(23, '12345678911', '62f368f0012ff9.77480558-12345678911.jpg', '62f368f6124704.61539685-12345678911.jpg', '-7.8245119', '110.414304', '-7.8245119', '110.414304', '2022-08-10 15:14:40', '2022-08-10 15:14:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE IF NOT EXISTS `jabatan` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`uid`, `nama_jabatan`) VALUES
(2, 'Manager'),
(3, 'Human Resource'),
(4, 'Karyawan'),
(1, 'CEO');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `jabatan_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `name`, `slug`, `nik`, `jenis_kelamin`, `jabatan_id`, `created_at`, `updated_at`) VALUES
(3, 'Romi Haidar', 'romi-haidar', '19990510', 'Pria', 4, NULL, NULL),
(15, 'Bayu Skak', 'bayu-skak', '12345679', 'Pria', 3, '2022-08-04 13:32:44', '2022-08-04 13:32:44'),
(14, 'Michael Deny', 'michael-deny', '12345678', 'Pria', 1, '2022-08-04 13:32:22', '2022-08-04 13:32:22'),
(17, 'Mister Yus', 'mister-yus', '1234567810', 'Pria', 4, '2022-08-08 13:23:00', '2022-08-08 13:23:00'),
(16, 'Sujak Cingur', 'sujak-cingur', '12345677', 'Pria', 2, '2022-08-04 13:33:02', '2022-08-04 13:33:02'),
(18, 'La Lisa', 'la-lisa', '12345678911', 'Wanita', 4, '2022-08-08 13:24:01', '2022-08-08 13:24:01'),
(19, 'John Wick', 'john-wick', '12345678999', 'Pria', 4, '2022-08-08 14:38:43', '2022-08-08 14:38:43');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
