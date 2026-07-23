-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2025 at 12:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gmit_imanuel_naikliu`
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
(1, 1, 'asdsa', '2025-12-03', '1764730270_692fa59e659d8.pdf', '1764730270_692fa59e65eaa.pdf');

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
(1, 1, 'asdasd', 'Das', 'SADasd112312', 'pria', 'anak', 'DSAdas', '2026-01-02', '');

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
(1, '121212', 'asdsad', 'DAsd12312', 'Dasd123', '2025-12-02', 'pria', '');

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
(2, 1, '1764737637_692fc26554c63.pdf', '1764737637_692fc265550ae.pdf', '1764737637_692fc26555652.pdf', '1764737637_692fc2655598c.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `pelayanan`
--

CREATE TABLE `pelayanan` (
  `id_pelayanan` int(12) NOT NULL,
  `hari_tanggal_bulan` date NOT NULL,
  `waktu` varchar(50) NOT NULL,
  `tempat` text NOT NULL,
  `pemimpin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelayanan`
--

INSERT INTO `pelayanan` (`id_pelayanan`, `hari_tanggal_bulan`, `waktu`, `tempat`, `pemimpin`) VALUES
(1, '2025-12-02', '16:52', 'axasxx', 'asxax');

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
(2, 'Tony Ahmad', 'Pendeta', 'Pendeta123', 'pria', 'Kupang', '2025-12-02', '2025-2026', '083442458241', '');

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
(1, 1, '1', 'dadasas');

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
(5, 1, '1764941958_6932e0868bff2.pdf', '1764941958_6932e0868c1b8.pdf');

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
  MODIFY `id_babtis` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jemaat`
--
ALTER TABLE `jemaat`
  MODIFY `id_jemaat` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `majelis`
--
ALTER TABLE `majelis`
  MODIFY `id_majelis` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nikah`
--
ALTER TABLE `nikah`
  MODIFY `id_nikah` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelayanan`
--
ALTER TABLE `pelayanan`
  MODIFY `id_pelayanan` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pendeta`
--
ALTER TABLE `pendeta`
  MODIFY `id_pendeta` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rayon`
--
ALTER TABLE `rayon`
  MODIFY `id_rayon` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sidi`
--
ALTER TABLE `sidi`
  MODIFY `id_sidi` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
