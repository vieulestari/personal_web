-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2025 at 08:25 PM
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
-- Database: `devinihbos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_about`
--

CREATE TABLE `tbl_about` (
  `id_about` int(2) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_about`
--

INSERT INTO `tbl_about` (`id_about`, `about`) VALUES
(2, 'Hallo Semuanya!! Saya Devi Lestari yang merupakan seorang mahasiswa aktif Jurusan Sistem Informasi yang memiliki ketertarikan pada bidang teknologi, kreativitas, dan komunikasi. Saya terbiasa bekerja secara mandiri maupun dalam tim, serta memiliki semangat belajar yang tinggi. Selain memiliki kemampuan dalam pengolahan dokumen dan presentasi, saya juga memiliki minat dalam bidang editing konten digital dan hobi dalam dunia baking');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_artikel`
--

CREATE TABLE `tbl_artikel` (
  `id_artikel` int(5) NOT NULL,
  `nama_artikel` text NOT NULL,
  `isi_artikel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_artikel`
--

INSERT INTO `tbl_artikel` (`id_artikel`, `nama_artikel`, `isi_artikel`) VALUES
(1, 'Apa Itu Sistem Informasi dan Mengapa Penting?', 'Sistem informasi adalah kombinasi antara teknologi, data, dan manusia yang digunakan untuk mengumpulkan, menyimpan, mengelola, dan menyampaikan informasi. Dalam kehidupan sehari-hari, kita sering berinteraksi dengan sistem informasi, seperti saat menggunakan aplikasi mobile, mengakses website, atau bahkan saat berbelanja online. Sistem informasi membantu meningkatkan efisiensi, mempercepat pengambilan keputusan, dan memberikan kemudahan dalam mengelola data. Di era digital ini, kemampuan memahami dan membangun sistem informasi menjadi sangat penting, terutama bagi para pelajar dan profesional IT.'),
(2, 'Dasar Pemrograman: Kenapa Harus Belajar dari Sekarang?', 'Pemrograman adalah kemampuan untuk memberikan perintah kepada komputer agar bisa menjalankan tugas tertentu. Dasar pemrograman mencakup logika, variabel, tipe data, percabangan (if), perulangan (loop), dan fungsi. Dengan menguasai dasar-dasar ini, kamu bisa mulai membuat aplikasi, game, bahkan sistem informasi sendiri. Belajar pemrograman sejak dini memberikan bekal untuk memahami teknologi di balik software yang kita gunakan setiap hari. Banyak bahasa pemrograman yang bisa kamu mulai, seperti Python, JavaScript, atau PHP.'),
(3, 'Cara Membuat Animasi Daun dan Bintang di Website', 'Salah satu cara membuat website lebih hidup adalah dengan menambahkan animasi. Contohnya, kamu bisa membuat efek daun jatuh atau bintang berkedip di latar belakang menggunakan elemen <canvas> dan JavaScript. Pertama, siapkan tag <canvas> di HTML dan beri class khusus. Lalu, gunakan JavaScript untuk menggambar elemen seperti ellipse (daun) atau circle (bintang), dan update posisinya terus-menerus agar terlihat seperti bergerak. Kombinasikan dengan Tailwind CSS untuk mengatur responsif dan warna. Animasi seperti ini bisa memperindah tampilan personal web atau portofolio digital.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE `tbl_gallery` (
  `id_gallery` int(5) NOT NULL,
  `judul` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_gallery`
--

INSERT INTO `tbl_gallery` (`id_gallery`, `judul`, `foto`) VALUES
(8, 'me n my friends', 'WhatsApp Image 2025-07-06 at 00.04.08_23da1ecd.jpg'),
(9, 'ini pas ada abis nonton futsal', 'WhatsApp Image 2025-07-05 at 23.59.26_ee2d423e.jpg'),
(10, 'bukber pertama with my college friends', 'WhatsApp Image 2025-07-05 at 23.59.27_e2c227c0.jpg'),
(11, 'ini di mana ya???', 'WhatsApp Image 2025-07-05 at 23.59.27_cf24b012.jpg'),
(19, 'kelompok kbd jaya jaya jaya', 'WhatsApp Image 2025-07-06 at 19.16.14_9444f17a.jpg'),
(20, 'triOOo', 'WhatsApp Image 2025-07-06 at 19.16.15_b1c36b2e.jpg'),
(21, 'This is Devi', 'WhatsApp Image 2025-07-05 at 23.59.20_6c335cf8.jpg'),
(22, 'me with purple hijab', 'webcam-toy-photo90.jpg'),
(25, 'mmmmmm', 'img_686a98ea865561.19237702.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_komentar`
--

CREATE TABLE `tbl_komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_artikel` int(11) DEFAULT NULL,
  `nama_pengunjung` varchar(100) DEFAULT NULL,
  `isi_komentar` text DEFAULT NULL,
  `status` enum('pending','diterima','ditolak') DEFAULT 'pending',
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_komentar`
--

INSERT INTO `tbl_komentar` (`id_komentar`, `id_artikel`, `nama_pengunjung`, `isi_komentar`, `status`, `tanggal`) VALUES
(1, 1, 'Devi', 'oalahh', 'pending', '2025-07-06 17:05:56'),
(2, 3, 'Devi', 'apa', 'pending', '2025-07-06 17:07:28'),
(3, 3, 'Devi', 'apasaja', 'pending', '2025-07-06 17:09:48'),
(4, 2, 'Devi', 'emm okelah\r\n', 'pending', '2025-07-06 17:25:54'),
(5, 2, 'Devi', 'apasaja', 'pending', '2025-07-06 17:28:00'),
(6, 3, 'Devi', 'cekcekkkk', 'pending', '2025-07-06 17:43:37'),
(7, 3, 'Devi', 'ceklagiii', 'pending', '2025-07-06 18:24:33'),
(8, 1, 'Devi', 'yay berhasil', 'diterima', '2025-07-06 18:50:56'),
(9, 3, 'Devi', 'hmm', 'pending', '2025-07-06 18:53:00'),
(10, 3, 'Devi', 'cekcekcek', 'diterima', '2025-07-06 18:56:20'),
(11, 1, 'Devi', 'coba', 'pending', '2025-07-06 21:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`username`, `password`) VALUES
('admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_about`
--
ALTER TABLE `tbl_about`
  ADD PRIMARY KEY (`id_about`);

--
-- Indexes for table `tbl_artikel`
--
ALTER TABLE `tbl_artikel`
  ADD PRIMARY KEY (`id_artikel`);

--
-- Indexes for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`id_gallery`);

--
-- Indexes for table `tbl_komentar`
--
ALTER TABLE `tbl_komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_artikel` (`id_artikel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_about`
--
ALTER TABLE `tbl_about`
  MODIFY `id_about` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_artikel`
--
ALTER TABLE `tbl_artikel`
  MODIFY `id_artikel` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  MODIFY `id_gallery` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_komentar`
--
ALTER TABLE `tbl_komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_komentar`
--
ALTER TABLE `tbl_komentar`
  ADD CONSTRAINT `tbl_komentar_ibfk_1` FOREIGN KEY (`id_artikel`) REFERENCES `tbl_artikel` (`id_artikel`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
