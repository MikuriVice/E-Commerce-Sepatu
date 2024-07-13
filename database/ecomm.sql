-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 13, 2024 at 06:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecomm`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(51, 13, 57, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cat_slug` varchar(150) NOT NULL,
  `step` int(4) NOT NULL,
  `flag_end` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `cat_slug`, `step`, `flag_end`) VALUES
(7, 'Adidas', '', 0, 0),
(8, 'Nike', '', 0, 0),
(9, 'Puma', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `proof` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(200) NOT NULL,
  `price` double NOT NULL,
  `photo` varchar(200) NOT NULL,
  `date_view` date NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `slug`, `price`, `photo`, `date_view`, `counter`) VALUES
(56, 7, 'ADIDAS RUNNING Sepatu EQ21 Run Pria Abu-abu GY2194', '<p>Saat lari menjadi olahraga pilihanmu, kamu akan lebih menyukai aktivitas lari sehari-harimu. Lakukan aktivitas larimu dengan sangat nyaman menggunakan sepatu adidas ini. Upper breathable membuat kaki tetap sejuk dan fresh dalam cuaca yang panas. Bantalan yang ringan membuat setiap langkah terasa lebih menyenangkan.<br />\r\n<br />\r\nProduk ini dibuat dengan konten hasil daur ulang sebagai bagian dari ambisi kami untuk mengurangi pencemaran limbah plastik. 20% dari material yang digunakan dalam upper dibuat dengan minimum 50% konten hasil daur ulang.Fit regulerMenggunakan tali sepatuUpper berbahan engineered meshKerah dengan bantalanPenstabil TPU di bagian quarter dan tumitMidsole Bounce</p>\r\n', 'adidas-running-sepatu-eq21-run-pria-abu-abu-gy2194', 1040000, 'adidas-running-sepatu-eq21-run-pria-abu-abu-gy2194.jpg', '2024-07-13', 24),
(57, 7, 'ADIDAS ORIGINALS Sepatu Nizza Pria Hijau HQ6763', '<p>Berdasarkan sepatu basket ikonis tahun 1974, Sepatu adidas Nizza ini tetap menjadi juara style. Versi low-cut ini memiliki upper berbahan kanvas yang nyaman dan outsole tahan lama yang unggul dalam setiap langkah. 3-Stripes yang khas menunjukkan keunggulanmu pada semua orang.<br />\r\n<br />\r\nProduk berbahan katun kami mendukung metode budi daya kapas yang lebih berkelanjutan.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ul>\r\n	<li>Fit reguler</li>\r\n	<li>Menggunakan tali sepatu</li>\r\n	<li>Upper berbahan kanvas dan detail kulit sintetis</li>\r\n	<li>&nbsp;</li>\r\n	<li>Lining dari bahan tekstil</li>\r\n	<li>Outsole berbahan karet</li>\r\n</ul>\r\n', 'adidas-originals-sepatu-nizza-pria-hijau-hq6763', 1020000, 'adidas-originals-sepatu-nizza-pria-hijau-hq6763.jpg', '2024-07-13', 18),
(58, 8, 'Air Force 1 Low White Gum', '<p>100% Original Authentic<br />\r\n100% Trusted since 2016<br />\r\nBrand New with Tag / Box<br />\r\n<br />\r\nUkuran : Lengkap<br />\r\n(silahkan tulis dicatatan ukuran yang di pesan)<br />\r\n<br />\r\nBergaransi Tukar Ukuran, selama sesuai dengan ketentuan penukaran produk.<br />\r\n<br />\r\nTeam ahli kami memastikan keaslian semua produk yang dijual dan sudah melalui pengecekan kondisi fisik secara detail.</p>\r\n', 'air-force-1-low-white-gum', 2099000, 'air-force-1-low-white-gum.jpg', '2024-07-11', 2),
(59, 9, '100% Original Authentic 100% Trusted since 2016 Brand New with Tag / Box  Ukuran : Lengkap (silahkan tulis dicatatan ukuran yang di pesan)  Bergaransi Tukar Ukuran, selama sesuai dengan ketentuan penukaran produk.  Team ahli kami memastikan keaslian semua produk yang dijual dan sudah melalui pengecekan kondisi fisik secara detail.', '<p>Brand New In Box - Fullset<br />\r\nOriginal Guarantee 100%<br />\r\n<br />\r\nSize<br />\r\n(Tertera di variant product)<br />\r\n<br />\r\nUntuk menjaga agar dus sepatumu tetap aman, silahkan gunakan Additional Double Box dari Sneakersdept. Cuman 10rb!</p>\r\n', '100-original-authentic-100-trusted-since-2016-brand-new-tag-box-ukuran-lengkap-silahkan-tulis-dicatatan-ukuran-yang-di-pesan-bergaransi-tukar-ukuran-selama-sesuai-dengan-ketentuan-penukaran-produk-tea', 799000, '100-original-authentic-100-trusted-since-2016-brand-new-tag-box-ukuran-lengkap-silahkan-tulis-dicatatan-ukuran-yang-di-pesan-bergaransi-tukar-ukuran-selama-sesuai-dengan-ketentuan-penukaran-produk-tea', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `sales_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `transaction_id`, `amount`, `status`, `sales_date`) VALUES
(15, 14, '17', 0.00, 'Pemesanan', '2024-07-12 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(60) NOT NULL,
  `type` int(1) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `activate_code` varchar(15) NOT NULL,
  `reset_code` varchar(15) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `type`, `firstname`, `lastname`, `address`, `contact_info`, `photo`, `status`, `activate_code`, `reset_code`, `created_on`) VALUES
(1, 'admin@admin.com', '$2y$10$0SHFfoWzz8WZpdu9Qw//E.tWamILbiNCX7bqhy3od0gvK5.kSJ8N2', 1, 'aji', 'poespo', '', '', '270x270-male-avatar.png', 1, '', '', '2020-12-30'),
(14, 'ajihp@gmail.com', '$2y$10$kkyHVN18T1HKYwp1kHagiOjOkBye/3cPaYUhMa27.tZoofaSWNZ.a', 0, 'Aji', 'poespo', '', '', '', 1, '', '', '2024-07-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
