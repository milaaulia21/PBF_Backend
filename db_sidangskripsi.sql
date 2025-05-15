-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 15, 2025 at 02:24 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sidangskripsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int NOT NULL,
  `nama_dosen` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nip` int NOT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `nama_dosen`, `nip`, `id_user`) VALUES
(15, 'dendi dosen', 230302006, 39),
(19, 'Tes Dosen 3', 123123123, 40);

-- --------------------------------------------------------

--
-- Table structure for table `dosen_penguji`
--

CREATE TABLE `dosen_penguji` (
  `id_penguji` int NOT NULL,
  `id_sidang` int NOT NULL,
  `id_dosen` int NOT NULL,
  `peran` enum('PENGUJI 1','PENGUJI 2') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `dosen_penguji`
--

INSERT INTO `dosen_penguji` (`id_penguji`, `id_sidang`, `id_dosen`, `peran`) VALUES
(17, 10, 15, ''),
(18, 10, 19, ''),
(21, 12, 15, ''),
(22, 12, 19, ''),
(23, 13, 15, ''),
(24, 13, 19, ''),
(25, 14, 15, 'PENGUJI 1'),
(26, 14, 19, 'PENGUJI 2'),
(27, 15, 15, 'PENGUJI 1'),
(28, 15, 19, 'PENGUJI 2');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mhs` int NOT NULL,
  `nama_mhs` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nim` int NOT NULL,
  `prodi_mhs` enum('D3 TI','D4 RKS','D4 ALKS','D4 TRM','D4 RPL') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `thn_akademik` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `judul_skripsi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mhs`, `nama_mhs`, `nim`, `prodi_mhs`, `thn_akademik`, `judul_skripsi`, `id_user`) VALUES
(49, 'Bikra Admin', 12345678, 'D4 RPL', '2022/2023', 'dqwd', 20),
(72, 'mahasiswa oke', 765432, 'D4 ALKS', '2018/2017', 'qdfasdasdas', 41),
(73, 'Eval Putra Parasdika', 230202009, 'D3 TI', '2025/2026', 'Membuat Nasi Padang Terkental Sedunia', 42),
(74, 'MasBik', 23232323, 'D3 TI', '2025/2026', 'Sinergi paling OP di GOkGOk', 43);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-05-15-040927', 'App\\Database\\Migrations\\CreateUserNotificationsTable', 'default', 'App', 1747282226, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int NOT NULL,
  `kode_ruangan` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_ruangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `kode_ruangan`, `nama_ruangan`) VALUES
(16, '1234', 'test edit ruangan'),
(17, '242342', 'ruangan gweh'),
(18, '23423', 'teees'),
(19, '233', 'test ruangan'),
(20, '787', 'dingin');

-- --------------------------------------------------------

--
-- Table structure for table `sidang`
--

CREATE TABLE `sidang` (
  `id_sidang` int NOT NULL,
  `id_mhs` int NOT NULL,
  `id_ruangan` int NOT NULL,
  `tanggal_sidang` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `status` enum('DITUNDA','DIJADWALKAN','DIBATALKAN') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `sidang`
--

INSERT INTO `sidang` (`id_sidang`, `id_mhs`, `id_ruangan`, `tanggal_sidang`, `waktu_mulai`, `waktu_selesai`, `status`) VALUES
(10, 49, 16, '2026-01-01', '08:00:00', '09:00:00', 'DIJADWALKAN'),
(12, 72, 16, '2026-01-01', '12:00:00', '13:00:00', 'DIJADWALKAN'),
(13, 49, 16, '2026-01-01', '14:00:00', '15:00:00', 'DIJADWALKAN'),
(14, 73, 17, '2026-01-02', '08:00:00', '09:00:00', 'DIJADWALKAN'),
(15, 74, 18, '2026-01-02', '10:00:00', '11:00:00', 'DIJADWALKAN');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('mahasiswa','dosen') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'mahasiswa',
  `isAdmin` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`, `isAdmin`) VALUES
(20, 'admin', '$2y$12$IR52JItzENPXzNJ9YRaenuuNskB.OPMg7EGUP541rNEyIwSzk8vY6', 'mahasiswa', 'Y'),
(37, 'admin1', '$2y$12$XQaZW3If13MKFEhM1XFeUOnK1xUTedoeH5FmfgokLntTnD0jL82T6', 'mahasiswa', 'N'),
(38, 'testdosen1', '$2y$12$Tv/y.G/yXsUgFaOEmqZFCe.ZTtGCy4gNpQdrSL.mxVuXApwDfgMXG', 'dosen', 'N'),
(39, 'dosen2', '$2y$12$W9DeC7P.srGbkFaebgdfP.4CxSJnPJSdHV2uuymPFYKqzh/oUiSwm', 'dosen', 'N'),
(40, 'dosen3', '$2y$12$IR.x26ZODRqT/B5zTtKHmOBzf87C8GBVbFVdvfrQPbw2FsEVu18HG', 'dosen', 'N'),
(41, 'mahasiswa1', '$2y$12$GOMx8F8gyS49apu/OolzAezFooV34Jmqbst3.1zVMBsVC7k1VB5la', 'mahasiswa', 'N'),
(42, 'adminhalo', '$2y$12$cG/TTuznR4VejRbR7y3anu19CIntw04c9j.fIYAo5Nt80w7aW5oo.', 'mahasiswa', 'N'),
(43, 'testing1', '$2y$12$IlXIjuqWtUuFHlMlk7TCkOaGOlFuO8H9aML1x6fuLThKKehnTlo7S', 'mahasiswa', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('unread','read') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unread',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`) USING BTREE,
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `dosen_penguji`
--
ALTER TABLE `dosen_penguji`
  ADD PRIMARY KEY (`id_penguji`) USING BTREE,
  ADD UNIQUE KEY `unique_sidang_dosen` (`id_sidang`,`id_dosen`) USING BTREE,
  ADD KEY `fk_dosen` (`id_dosen`) USING BTREE;

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mhs`) USING BTREE,
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`) USING BTREE;

--
-- Indexes for table `sidang`
--
ALTER TABLE `sidang`
  ADD PRIMARY KEY (`id_sidang`) USING BTREE,
  ADD KEY `fk_mhs` (`id_mhs`) USING BTREE,
  ADD KEY `fk_ruangan` (`id_ruangan`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `dosen_penguji`
--
ALTER TABLE `dosen_penguji`
  MODIFY `id_penguji` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mhs` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sidang`
--
ALTER TABLE `sidang`
  MODIFY `id_sidang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `FK_dosen_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dosen_penguji`
--
ALTER TABLE `dosen_penguji`
  ADD CONSTRAINT `fk_dosen` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sidang` FOREIGN KEY (`id_sidang`) REFERENCES `sidang` (`id_sidang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `FK_mahasiswa_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sidang`
--
ALTER TABLE `sidang`
  ADD CONSTRAINT `fk_mhs` FOREIGN KEY (`id_mhs`) REFERENCES `mahasiswa` (`id_mhs`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ruangan` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
