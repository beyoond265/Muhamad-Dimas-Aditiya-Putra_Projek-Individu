-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2025 at 07:20 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`, `created_at`) VALUES
(1, 'admin', '25d55ad283aa400af464c76d713c07ad', 'Administrator', '2025-12-07 04:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text,
  `tanggal_daftar` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `nama`, `email`, `password`, `telepon`, `alamat`, `tanggal_daftar`) VALUES
(1, 'muhamad sumbul', 'sumbul@gmail.com', '$2y$10$xUnmkvVbtNgEUMwd.Bc39ehTZEuR7T46/o0svL95SY48/01nY6Pz.', '088591202345', 'JL.Sarua indah', '2025-12-07 00:00:00'),
(3, 'Ryo', 'ryo@gmail.com', '$2y$10$RBcOH8PQGC6ipSjp/X/8g.kjTkKEVmpJl5QxOX0ggIjvy9vP2QB7C', '087944556677', 'pamulang', '2025-12-09 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `nama` varchar(150) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text,
  `harga` int NOT NULL,
  `gambar` varchar(255) DEFAULT 'default.png',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `deskripsi`, `harga`, `gambar`, `created_at`) VALUES
(1, 'PlayStation 5', 'Console', 'Konsol PlayStation 5 versi standar', 9500000, 'ps5.jpg', '2025-11-16 05:21:25'),
(2, 'Nintendo Switch', 'Console', 'Nintendo Switch versi OLED', 6500000, 'switch.jpg', '2025-11-16 05:21:25'),
(3, 'Controller PS5', 'Aksesoris', 'Controller DualSense original', 1500000, 'controller.jpg', '2025-11-16 05:21:25'),
(4, 'Game FIFA 24', 'Game', 'FIFA 24 untuk PS5', 700000, 'fifa24.jpg', '2025-11-16 05:21:25'),
(5, 'Honkai Star Rail', 'Game', 'Game turnbase ', 100000, '1763270805_1762693458111.jpg', '2025-11-16 05:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `produk_id` int NOT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `total_harga` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `invoice_id` varchar(50) DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'pending',
  `canceled_by` varchar(20) DEFAULT NULL,
  `tanggal_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `produk_id`, `qty`, `total_harga`, `created_at`, `updated_at`, `invoice_id`, `status`, `canceled_by`, `tanggal_update`) VALUES
(1, 1, 5, 1, 100000, '2025-12-08 14:56:07', '2025-12-09 00:01:27', NULL, 'selesai', NULL, NULL),
(2, 1, 5, 1, 100000, '2025-12-08 14:56:27', '2025-12-09 06:14:01', NULL, 'pending', NULL, NULL),
(3, 1, 5, 1, 100000, '2025-12-08 14:57:33', '2025-12-09 06:14:05', NULL, 'pending', NULL, NULL),
(4, 1, 5, 1, 100000, '2025-12-08 15:10:31', '2025-12-09 06:14:11', NULL, 'pending', NULL, NULL),
(5, 1, 5, 1, 100000, '2025-12-08 15:15:25', '2025-12-09 06:14:14', NULL, 'pending', NULL, NULL),
(6, 1, 1, 1, 9500000, '2025-12-08 15:15:49', '2025-12-09 06:14:09', NULL, 'pending', NULL, NULL),
(7, 1, 6, 1, 2000000, '2025-12-08 15:16:05', '2025-12-09 06:14:03', NULL, 'pending', NULL, NULL),
(8, 1, 6, 1, 2000000, '2025-12-08 15:27:06', '2025-12-09 00:33:46', NULL, 'selesai', NULL, NULL),
(9, 1, 5, 1, 100000, '2025-12-08 16:41:31', '2025-12-09 09:30:36', NULL, 'diproses', NULL, NULL),
(10, 1, 5, 1, 100000, '2025-12-08 16:46:12', '2025-12-09 00:33:54', NULL, 'selesai', NULL, NULL),
(11, 1, 5, 1, 100000, '2025-12-08 16:47:29', '2025-12-09 07:53:32', NULL, 'selesai', NULL, NULL),
(12, 1, 4, 1, 700000, '2025-12-08 17:35:12', '2025-12-09 07:53:49', NULL, 'selesai', NULL, NULL),
(13, 1, 5, 1, 100000, '2025-12-08 17:51:21', '2025-12-09 07:53:40', NULL, 'selesai', NULL, NULL),
(14, 1, 4, 1, 700000, '2025-12-08 17:53:03', '2025-12-09 06:14:23', NULL, 'Batal oleh member', 'member', '2025-12-09 01:23:48'),
(15, 1, 3, 1, 1500000, '2025-12-08 18:02:57', '2025-12-09 01:03:06', NULL, 'selesai', NULL, NULL),
(16, 1, 6, 1, 2000000, '2025-12-08 18:22:39', '2025-12-09 05:59:28', NULL, 'Batal oleh member', 'member', '2025-12-09 05:52:17'),
(17, 1, 3, 1, 1500000, '2025-12-08 22:51:49', '2025-12-09 05:58:50', NULL, 'Batal oleh member', NULL, NULL),
(18, 1, 4, 1, 700000, '2025-12-09 00:51:35', '2025-12-09 07:52:49', NULL, 'Batal oleh member', NULL, NULL),
(19, 3, 5, 1, 100000, '2025-12-09 01:35:38', '2025-12-09 08:36:12', NULL, 'selesai', NULL, NULL),
(20, 3, 3, 1, 1500000, '2025-12-09 01:36:33', '2025-12-09 08:36:46', NULL, 'Batal oleh member', NULL, NULL),
(21, 3, 6, 1, 2000000, '2025-12-09 01:36:39', '2025-12-09 08:37:24', NULL, 'selesai', NULL, NULL),
(22, 1, 4, 1, 700000, '2025-12-09 03:22:47', '2025-12-09 10:24:14', NULL, 'selesai', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
