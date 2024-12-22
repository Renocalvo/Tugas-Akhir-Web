-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 04:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webtaskcompany`
--

-- --------------------------------------------------------

--
-- Table structure for table `psychologists`
--

CREATE TABLE `psychologists` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `psychologists`
--

INSERT INTO `psychologists` (`id`, `name`, `specialization`, `bio`, `contact`) VALUES
(1, 'Indira Tandiono, M.Psi.', 'Konselor Anak & Remaja', 'Berpengalaman lebih dari 10 tahun dalam menangani kasus anak dan remaja, termasuk gangguan kecemasan dan masalah perilaku.', '081234567890'),
(2, 'Rendra Wijaya, S.Psi.', 'Psikologi Keluarga', 'Fokus pada membantu pasangan dan keluarga menemukan solusi konflik dan meningkatkan komunikasi.', '081234567891'),
(3, 'Citra Anggita, M.Psi.', 'Psikologi Klinis', 'Ahli dalam menangani gangguan mental berat seperti depresi, bipolar, dan OCD.', '081234567892'),
(4, 'Rahmat Purnama, M.Psi.', 'Psikologi Pendidikan', 'Membantu anak dan remaja dalam proses pembelajaran serta mengatasi tantangan akademik.', '081234567893'),
(5, 'Amalia Hartanto, M.Psi.', 'Psikoterapis Kognitif', 'Spesialis terapi kognitif untuk membantu individu mengatasi stres, kecemasan, dan trauma.', '081234567894'),
(6, 'Dewi Sari, S.Psi.', 'Psikolog Industri & Organisasi', 'Membantu perusahaan dalam pengembangan SDM, peningkatan produktivitas, dan kesejahteraan karyawan.', '081234567895'),
(7, 'Budi Santoso, M.Psi.', 'Konselor Pernikahan', 'Menangani pasangan dalam menyelesaikan konflik dan membangun hubungan yang sehat.', '081234567896'),
(8, 'Nadya Paramita, S.Psi.', 'Psikologi Remaja', 'Spesialis dalam mengatasi masalah perilaku remaja dan membangun kepercayaan diri mereka.', '081234567897'),
(9, 'Yudi Pratama, M.Psi.', 'Psikologi Trauma', 'Mengatasi dan membantu pemulihan individu dari trauma masa lalu.', '081234567898'),
(10, 'Rini Kusuma, M.Psi.', 'Psikologi Perkembangan', 'Fokus pada tahapan perkembangan manusia dari anak hingga dewasa, serta mengatasi hambatan dalam proses tersebut.', '081234567899');

-- --------------------------------------------------------

--
-- Table structure for table `psychologist_images`
--

CREATE TABLE `psychologist_images` (
  `id` int(11) NOT NULL,
  `psychologist_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `psychologist_images`
--

INSERT INTO `psychologist_images` (`id`, `psychologist_id`, `image_path`, `uploaded_at`) VALUES
(11, 1, 'assets/images/indira_tandiono.jpg', '2024-11-06 20:58:44'),
(12, 2, 'assets/images/rendra_wijaya.jpg', '2024-11-06 20:58:44'),
(13, 3, 'assets/images/citra_anggita.jpg', '2024-11-06 20:58:44'),
(14, 4, 'assets/images/rahmat_purnama.jpg', '2024-11-06 20:58:44'),
(15, 5, 'assets/images/amalia_hartanto.jpg', '2024-11-06 20:58:44'),
(16, 6, 'assets/images/dewi_sari.jpg', '2024-11-06 20:58:44'),
(17, 7, 'assets/images/budi_santoso.jpg', '2024-11-06 20:58:44'),
(18, 8, 'assets/images/nadya_paramita.jpg', '2024-11-06 20:58:44'),
(19, 9, 'assets/images/yudi_pratama.jpg', '2024-11-06 20:58:44'),
(20, 10, 'assets/images/rini_kusuma.jpg', '2024-11-06 20:58:44');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `answer1` varchar(255) NOT NULL,
  `answer2` varchar(255) NOT NULL,
  `answer3` varchar(255) NOT NULL,
  `answer4` varchar(255) NOT NULL,
  `answer5` varchar(255) NOT NULL,
  `answer6` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `answer6`) VALUES
(1, 'Saya merasakan emosi saya terkuras karena pekerjaan.', 'Tidak pernah', 'Setidaknya beberapa kali dalam setahun', 'Setidaknya sebulan sekali', 'Beberapa kali dalam sebulan', 'Seminggu sekali', 'Beberapa kali seminggu'),
(2, 'Saya merasa kelelahan fisik yang amat sangat di akhir hari kerja.', 'Tidak pernah', 'Setidaknya beberapa kali dalam setahun', 'Setidaknya sebulan sekali', 'Beberapa kali dalam sebulan', 'Seminggu sekali', 'Beberapa kali seminggu'),
(3, 'Saya merasa lesu ketika bangun pagi karena harus menjalani hari di tempat kerja.', 'Tidak pernah', 'Setidaknya beberapa kali dalam setahun', 'Setidaknya sebulan sekali', 'Beberapa kali dalam sebulan', 'Seminggu sekali', 'Beberapa kali seminggu'),
(4, 'Saya merasa kesulitan untuk fokus atau berkonsentrasi selama bekerja.', 'Tidak pernah', 'Setidaknya beberapa kali dalam setahun', 'Setidaknya sebulan sekali', 'Beberapa kali dalam sebulan', 'Seminggu sekali', 'Beberapa kali seminggu'),
(5, 'Saya merasa tidak memiliki energi atau motivasi untuk menyelesaikan tugas-tugas kerja saya.', 'Tidak pernah', 'Setidaknya beberapa kali dalam setahun', 'Setidaknya sebulan sekali', 'Beberapa kali dalam sebulan', 'Seminggu sekali', 'Beberapa kali seminggu'),
(6, 'Saya merasa terisolasi atau tidak terhubung dengan rekan kerja saya.', 'Tidak pernah', 'Setidaknya beberapa kali dalam setahun', 'Setidaknya sebulan sekali', 'Beberapa kali dalam sebulan', 'Seminggu sekali', 'Beberapa kali seminggu'),
(7, 'Saya merasa tidak dihargai atau diakui atas upaya saya di tempat kerja.', 'Tidak pernah', 'Setidaknya beberapa kali dalam setahun', 'Setidaknya sebulan sekali', 'Beberapa kali dalam sebulan', 'Seminggu sekali', 'Beberapa kali seminggu'),
(8, 'Saya merasa cemas atau stres tentang pekerjaan saya, bahkan ketika sedang tidak bekerja.', 'Tidak pernah', 'Setidaknya beberapa kali dalam setahun', 'Setidaknya sebulan sekali', 'Beberapa kali dalam sebulan', 'Seminggu sekali', 'Beberapa kali seminggu'),
(9, 'Saya merasa semakin sulit untuk menjaga keseimbangan antara pekerjaan dan kehidupan pribadi.', 'Tidak pernah', 'Setidaknya beberapa kali dalam setahun', 'Setidaknya sebulan sekali', 'Beberapa kali dalam sebulan', 'Seminggu sekali', 'Beberapa kali seminggu'),
(10, 'Saya merasa pekerjaan saya tidak bermakna atau tidak memberikan kepuasan pribadi.', 'Tidak pernah', 'Setidaknya beberapa kali dalam setahun', 'Setidaknya sebulan sekali', 'Beberapa kali dalam sebulan', 'Seminggu sekali', 'Beberapa kali seminggu');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `user_id`, `score`, `created_at`) VALUES
(1, 3, 32, '2024-11-07 03:35:28'),
(2, 3, 32, '2024-11-07 03:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$uMLIk6xmZV9RHnIljSd5e.L7T1m6kHHVvwLwde1SMkizCW0DyaJTu'),
(2, 'Indra Bayu', 'indrabayu123@gmail.com', '$2y$10$9Cj9a9UdriEtJF3fSGu/ueJGB6.QnrzELhAVV79QmEGtQtmmYvW/i'),
(3, 'Rezarudin yusuf', 'mukhre123@gmail.com', '$2y$10$iEm7VePjVCt3pDtUsjEwE.d6ETd6nHUHSizp3.K47wjGNh5oofBUe'),
(4, 'Tretan Muslim', 'tretan123@gmail.com', '$2y$10$Kt0ePHeRGXSugoqWsgH5O.kGd0N9crGydAsO8oUuEe2OrhLa6Hq2u'),
(5, 'Intan Pertiwi', 'intan123@gmail.com', '$2y$10$K1f73FXYxgBckPc78Oudx.Axf0Kf1GGomYYFKybZmT6Jr7KW4UGri');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `job` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `age`, `gender`, `location`, `job`) VALUES
(1, 3, 21, 'Laki-laki', 'Malang', 'Mahasiswa'),
(2, 2, 17, 'Laki-laki', 'Malang', 'Mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `psychologists`
--
ALTER TABLE `psychologists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `psychologist_images`
--
ALTER TABLE `psychologist_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psychologist_id` (`psychologist_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `psychologists`
--
ALTER TABLE `psychologists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `psychologist_images`
--
ALTER TABLE `psychologist_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `psychologist_images`
--
ALTER TABLE `psychologist_images`
  ADD CONSTRAINT `psychologist_images_ibfk_1` FOREIGN KEY (`psychologist_id`) REFERENCES `psychologists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
