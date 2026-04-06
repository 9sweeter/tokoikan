-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2026 at 06:41 AM
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
-- Database: `toko_ikan`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('pending','accepted','cancelled') DEFAULT 'pending',
  `alamat` text NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `alamat`, `bukti_pembayaran`, `created_at`) VALUES
(3, 1, 90000, 'cancelled', 'Gw bayar lu nggak', '1769610244_3x4.jpeg', '2026-01-28 07:24:04'),
(4, 1, 430000, 'pending', 'Hello saya ada di South Mampang Residence. No 13', '1769673819_Walmart-Style-Receipt-019870d43b9f09365107e41308e23162.png', '2026-01-29 01:03:39');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `nama_produk`, `harga`, `qty`) VALUES
(3, 3, 'Ikan Tongkol', 90000, 1),
(4, 4, 'Ikan Tongkol', 90000, 3),
(5, 4, 'Ikan Tenggiri', 160000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama_produk`, `harga`, `stok`, `deskripsi`, `gambar`) VALUES
(1, 'Ikan Tuna', 120000, 50, 'Ikan tuna segar berkualitas tinggi, kaya protein dan omega-3', '1775437059_images (2).jpg'),
(2, 'Ikan Salmon', 150000, 30, 'Salmon premium impor, cocok untuk sushi dan grill', '1775437090_079c5e9a-2bf7-4f9c-851d-b05c4fb06580.jpg~tplv-aphluv4xwc-resize-jpeg_700_0.jpg'),
(3, 'Ikan Tongkol', 90000, 40, 'Ikan tongkol segar untuk sup dan pepes', '1775437136_4167d4c2-900d-42ae-b661-c94e4ba29f5c.jpg~tplv-aphluv4xwc-resize-jpeg_700_0.jpg'),
(4, 'Ikan Emas', 150000, 20, 'Ikan koi hias warna-warni', '1775437181_c0af4b69-a75d-4164-9fbb-43400abe5c27.jpg~tplv-aphluv4xwc-white-pad-v1_250_250.jpg'),
(5, 'Ikan Tenggiri', 160000, 25, 'Ikan tenggiri segar untuk berbagai masakan', '1775437225_238eb2d3-cd92-4514-b8b2-3b6f70410436.jpg.jpg'),
(6, 'Ikan Lele', 100000, 67, 'Lele, Kaya akan Vitamin', '1775437357_f91478e5afbebe146970d391de3659ce.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','petugas','admin','') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Bud', 'Bud101@gmail.com', '$2y$12$yOWN7lIiINEMK7Sr/xUNU.5QU628s0Ekcsdkjb1biwNIYCOxYocu2', 'user'),
(2, 'Boro', 'Prime@gmail.com', '$2y$12$mLWtZ/kjHLoTOYbr1LMOue/qFp0zq1WkOuucfwkTb5Grh8h4QfvFy', 'user'),
(3, 'Staff Toko', 'petugas@tokoikan.com', '$2y$12$yOWN7lIiINEMK7Sr/xUNU.5QU628s0Ekcsdkjb1biwNIYCOxYocu2', 'petugas'),
(4, 'Admin Toko', 'admin@tokoikan.com', '$2y$12$yOWN7lIiINEMK7Sr/xUNU.5QU628s0Ekcsdkjb1biwNIYCOxYocu2', 'admin'),
(5, 'Joe', 'joe@gmail.com', '$2y$12$9hkAMm1hgM/nQvL.lWqN9.omGTJvYligT/btdSHSXIf2NFN3m.qu6', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
