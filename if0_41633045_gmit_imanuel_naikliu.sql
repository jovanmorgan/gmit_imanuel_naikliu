-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql201.infinityfree.com
-- Generation Time: Jul 23, 2026 at 11:47 AM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41633045_gmit_imanuel_naikliu`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(12) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_lengkap`, `username`, `password`, `fp`) VALUES
(1, 'Admin Gereja', 'Admin', '1', '692fda8b963d6.png'),
(2, 'Sekretaris Gereja', 'Sekretaris', 'Sekretaris123', '');

-- --------------------------------------------------------

--
-- Table structure for table `babtis`
--

CREATE TABLE `babtis` (
  `id_babtis` int(12) NOT NULL,
  `id_jemaat` int(12) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `surat_nikah_orang_tua` text NOT NULL,
  `akta_kelahiran` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `babtis`
--

INSERT INTO `babtis` (`id_babtis`, `id_jemaat`, `tempat_lahir`, `tanggal_lahir`, `surat_nikah_orang_tua`, `akta_kelahiran`) VALUES
(1, 1, 'asdsa', '2025-12-03', '1764730270_692fa59e659d8.pdf', '1764730270_692fa59e65eaa.pdf'),
(3, 5, 'kupang', '1998-06-17', '1780415205_6a1efae57365b.png', '1780415205_6a1efae5737eb.png'),
(6, 6, 'Kupang', '2026-06-17', '1781108676_6a298fc442f66.jpg', '1781108676_6a298fc4430d2.jpg'),
(7, 5, 'naikliu', '2026-06-19', '1782192303_6a3a18afd0943.png', '1782192303_6a3a18afd0a4e.png');

-- --------------------------------------------------------

--
-- Table structure for table `jemaat`
--

CREATE TABLE `jemaat` (
  `id_jemaat` int(12) NOT NULL,
  `id_rayon` int(12) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL,
  `status_keluarga` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `fp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jemaat`
--

INSERT INTO `jemaat` (`id_jemaat`, `id_rayon`, `nama_lengkap`, `username`, `password`, `jenis_kelamin`, `status_keluarga`, `tempat_lahir`, `tanggal_lahir`, `fp`) VALUES
(5, 4, 'adelia kollo', 'adel', 'adel1234', 'wanita', 'istri', 'naikliu', '1998-06-17', ''),
(6, 6, 'rianus', 'rian  ', '1234', 'pria', 'anak', 'kolabe', '2018-11-15', ''),
(7, 6, 'agnes liu', 'agnes', '1313', 'pria', 'anak', 'naikliu', '2010-03-08', ''),
(8, 8, 'adelia kollo', 'adel', '1234', 'wanita', 'istri', 'naikliu', '2026-07-10', ''),
(9, 8, 'tonchi', 'tony', 'tony15', 'pria', 'anak', 'naikliu', '2026-07-17', '');

-- --------------------------------------------------------

--
-- Table structure for table `majelis`
--

CREATE TABLE `majelis` (
  `id_majelis` int(12) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL,
  `fp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `majelis`
--

INSERT INTO `majelis` (`id_majelis`, `nama_lengkap`, `username`, `password`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `fp`) VALUES
(4, 'herman kollo', 'herman', 'herman123', 'kupang', '1998-10-22', 'pria', ''),
(5, 'serlianan b', 'serli', '1212', 'naikliu', '2016-03-02', 'wanita', ''),
(6, 'adriana', 'rina', '123', 'kupang', '2019-04-19', 'wanita', '');

-- --------------------------------------------------------

--
-- Table structure for table `nikah`
--

CREATE TABLE `nikah` (
  `id_nikah` int(12) NOT NULL,
  `id_jemaat` int(12) NOT NULL,
  `surat_sidi_pengantin` text NOT NULL,
  `surat_babtis_pengantin` text NOT NULL,
  `surat_nikah_saksi` text NOT NULL,
  `akta_kelahiran_saksi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nikah`
--

INSERT INTO `nikah` (`id_nikah`, `id_jemaat`, `surat_sidi_pengantin`, `surat_babtis_pengantin`, `surat_nikah_saksi`, `akta_kelahiran_saksi`) VALUES
(7, 5, '1781753032_6a3364c8a8aba.pdf', '1781753032_6a3364c8a8d54.pdf', '1781753032_6a3364c8a8e25.pdf', '1781753032_6a3364c8a8efa.pdf'),
(9, 7, '1781753114_6a33651a1168f.pdf', '1781753114_6a33651a1179a.pdf', '1781753114_6a33651a11882.pdf', '1781753114_6a33651a1195f.pdf'),
(10, 5, '1781756464_6a3372307b376.pdf', '1781756464_6a3372307b4f8.pdf', '1781756464_6a3372307b634.pdf', '1781756464_6a3372307b77a.pdf'),
(12, 6, '1782707939_6a41f6e334949.png', '1782707939_6a41f6e334ac5.png', '1782707939_6a41f6e334c0c.png', '1782707939_6a41f6e334d70.png');

-- --------------------------------------------------------

--
-- Table structure for table `pelayanan`
--

CREATE TABLE `pelayanan` (
  `id_pelayanan` int(12) NOT NULL,
  `id_rayon` int(12) NOT NULL,
  `id_jemaat` int(12) NOT NULL,
  `hari_tanggal_bulan` date NOT NULL,
  `waktu` varchar(50) NOT NULL,
  `tempat` text NOT NULL,
  `pemimpin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelayanan`
--

INSERT INTO `pelayanan` (`id_pelayanan`, `id_rayon`, `id_jemaat`, `hari_tanggal_bulan`, `waktu`, `tempat`, `pemimpin`) VALUES
(5, 0, 0, '2026-06-02', '04:49', 'rumah ibu adel', 'pnt yonathan'),
(7, 6, 7, '2026-06-12', '15:30', 'rumah bapa herman', 'majelis serli'),
(8, 6, 6, '2026-06-18', '16:12', '123', '123'),
(9, 6, 7, '2026-06-18', '15:21', 'rumah bapa herman', 'majelis serli'),
(10, 8, 8, '2026-06-11', '15:24', 'rumah ibadah', 'ketua majelis '),
(11, 8, 8, '2026-06-10', '16:25', 'rumah ibadah', 'ketua majelis ');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(12) NOT NULL,
  `id_table` int(12) NOT NULL,
  `type_table` enum('sidi','babtis','nikah') NOT NULL,
  `status_pendaftaran` enum('disetujui','tidak_disetujui') NOT NULL,
  `alasan_dibatalkan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendeta`
--

CREATE TABLE `pendeta` (
  `id_pendeta` int(12) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL,
  `tempat_lahir` varchar(150) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `priode_jabatan` varchar(50) NOT NULL,
  `nomor_hp` char(50) NOT NULL,
  `fp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendeta`
--

INSERT INTO `pendeta` (`id_pendeta`, `nama_lengkap`, `username`, `password`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `priode_jabatan`, `nomor_hp`, `fp`) VALUES
(2, 'GERAL', 'Pendeta', 'Pendeta123', 'pria', 'Kupang', '2025-12-02', '2025-2026', '083442458241', ''),
(6, 'tony', 'tony123', 'Tony1234', 'pria', 'kefa', '2003-12-12', 'baru', '083442458241', ''),
(7, 'pdt yesaya fajar', 'yes fajar', 'Yes12345678', 'pria', 'naikliu', '1996-10-24', '2022-2024', '081293764', ''),
(8, 'tonchi lake', 'Tonchi', 'Tonchilake12345', 'pria', 'naikliu', '2013-03-07', '2022-2025', '081370073654', '');

-- --------------------------------------------------------

--
-- Table structure for table `rayon`
--

CREATE TABLE `rayon` (
  `id_rayon` int(12) NOT NULL,
  `id_majelis` int(12) NOT NULL,
  `nama_rayon` char(10) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rayon`
--

INSERT INTO `rayon` (`id_rayon`, `id_majelis`, `nama_rayon`, `alamat`) VALUES
(6, 4, '4', 'naikliu'),
(7, 5, '5', 'naikliu'),
(8, 4, '2', 'dadasas');

-- --------------------------------------------------------

--
-- Table structure for table `sidi`
--

CREATE TABLE `sidi` (
  `id_sidi` int(12) NOT NULL,
  `id_jemaat` int(12) NOT NULL,
  `akta_kelahiran` text NOT NULL,
  `surat_babtis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sidi`
--

INSERT INTO `sidi` (`id_sidi`, `id_jemaat`, `akta_kelahiran`, `surat_babtis`) VALUES
(4, 1, '1764941937_6932e071c84e1.pdf', '1764941937_6932e071c86e2.pdf'),
(5, 1, '1764941958_6932e0868bff2.pdf', '1764941958_6932e0868c1b8.pdf'),
(8, 2, '1778466796_6a013fecbc2a5.jpg', '1778466796_6a013fecbc38c.jpg'),
(12, 6, '1781108628_6a298f9463641.jpg', '1781108628_6a298f94638ca.jpg'),
(13, 5, '1781677944_6a323f783f3f5.png', '1781677944_6a323f783f584.png'),
(14, 7, '1781677945_6a323f79540f8.png', '1781677945_6a323f795426b.png'),
(15, 5, '1782192229_6a3a18654eef8.png', '1782192229_6a3a18654f223.png'),
(16, 5, '1782192229_6a3a1865e1461.png', '1782192229_6a3a1865e15c8.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `babtis`
--
ALTER TABLE `babtis`
  ADD PRIMARY KEY (`id_babtis`);

--
-- Indexes for table `jemaat`
--
ALTER TABLE `jemaat`
  ADD PRIMARY KEY (`id_jemaat`);

--
-- Indexes for table `majelis`
--
ALTER TABLE `majelis`
  ADD PRIMARY KEY (`id_majelis`);

--
-- Indexes for table `nikah`
--
ALTER TABLE `nikah`
  ADD PRIMARY KEY (`id_nikah`);

--
-- Indexes for table `pelayanan`
--
ALTER TABLE `pelayanan`
  ADD PRIMARY KEY (`id_pelayanan`);

--
-- Indexes for table `pendeta`
--
ALTER TABLE `pendeta`
  ADD PRIMARY KEY (`id_pendeta`);

--
-- Indexes for table `rayon`
--
ALTER TABLE `rayon`
  ADD PRIMARY KEY (`id_rayon`);

--
-- Indexes for table `sidi`
--
ALTER TABLE `sidi`
  ADD PRIMARY KEY (`id_sidi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `babtis`
--
ALTER TABLE `babtis`
  MODIFY `id_babtis` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jemaat`
--
ALTER TABLE `jemaat`
  MODIFY `id_jemaat` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `majelis`
--
ALTER TABLE `majelis`
  MODIFY `id_majelis` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nikah`
--
ALTER TABLE `nikah`
  MODIFY `id_nikah` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pelayanan`
--
ALTER TABLE `pelayanan`
  MODIFY `id_pelayanan` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pendeta`
--
ALTER TABLE `pendeta`
  MODIFY `id_pendeta` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rayon`
--
ALTER TABLE `rayon`
  MODIFY `id_rayon` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sidi`
--
ALTER TABLE `sidi`
  MODIFY `id_sidi` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
