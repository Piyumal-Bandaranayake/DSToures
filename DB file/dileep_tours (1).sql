-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2026 at 01:19 PM
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
-- Database: `dileep_tours`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$OaDxHVPgM9BXXiRlqQc92.E5N/S2RcagFyqX4ot81OkUHPiSZ73Nm', '2026-07-13 16:41:14');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` varchar(150) NOT NULL,
  `category` varchar(50) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image_path`, `title`, `category`, `alt_text`, `created_at`) VALUES
(9, 'uploads/gallery/img_6a4cdd0d75e721.18951452.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.25 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.25 AM (1)', '2026-07-07 16:33:41'),
(18, 'uploads/gallery/img_6a4cdeff6a7144.65634107.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.27 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.27 AM', '2026-07-07 16:41:59'),
(20, 'uploads/gallery/img_6a4f2af72aaac3.65903120.jpeg', 'WhatsApp Image 2026 07 06 At 11.14.45 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.14.45 AM (1)', '2026-07-09 10:30:39'),
(21, 'uploads/gallery/img_6a4f3073a3f890.86767927.jpeg', 'WhatsApp Image 2026 07 06 At 11.14.45 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.14.45 AM (1)', '2026-07-09 10:54:03'),
(22, 'uploads/gallery/img_6a4f308b9f02b4.98672702.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.28 AM (2)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.28 AM (2)', '2026-07-09 10:54:27'),
(23, 'uploads/gallery/img_6a4f308ba823e7.45039541.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.28 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.28 AM (1)', '2026-07-09 10:54:27'),
(24, 'uploads/gallery/img_6a4f308bb39044.95458641.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.28 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.28 AM', '2026-07-09 10:54:27'),
(25, 'uploads/gallery/img_6a4f308bba99c1.67062690.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.29 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.29 AM (1)', '2026-07-09 10:54:27'),
(26, 'uploads/gallery/img_6a4f308bd26fe4.61924773.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.27 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.27 AM', '2026-07-09 10:54:27'),
(27, 'uploads/gallery/img_6a4f308bd72617.58212870.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.30 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.30 AM', '2026-07-09 10:54:27'),
(28, 'uploads/gallery/img_6a4f308bdc7d45.12255314.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.29 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.29 AM', '2026-07-09 10:54:27'),
(29, 'uploads/gallery/img_6a4f308be57d54.97252000.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.30 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.30 AM (1)', '2026-07-09 10:54:27'),
(30, 'uploads/gallery/img_6a4f308bf0d3c7.75190816.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.24 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.24 AM', '2026-07-09 10:54:27'),
(31, 'uploads/gallery/img_6a4f308c042212.20536648.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.23 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.23 AM', '2026-07-09 10:54:28'),
(32, 'uploads/gallery/img_6a4f308c0aaca3.37767127.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.28 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.28 AM', '2026-07-09 10:54:28'),
(33, 'uploads/gallery/img_6a4f308c16d784.30157606.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.29 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.29 AM (1)', '2026-07-09 10:54:28'),
(34, 'uploads/gallery/img_6a4f308c1e6fc9.09264097.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.29 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.29 AM', '2026-07-09 10:54:28'),
(35, 'uploads/gallery/img_6a4f308c2645f6.71960898.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.30 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.30 AM', '2026-07-09 10:54:28'),
(36, 'uploads/gallery/img_6a4f308c2bec64.79368056.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.31 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.31 AM (1)', '2026-07-09 10:54:28'),
(37, 'uploads/gallery/img_6a4f308c3187e0.93279307.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.31 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.31 AM', '2026-07-09 10:54:28'),
(38, 'uploads/gallery/img_6a4f308c3601b6.78595012.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.31 AM (2)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.31 AM (2)', '2026-07-09 10:54:28'),
(39, 'uploads/gallery/img_6a4f308c3d41d7.68298245.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.33 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.33 AM', '2026-07-09 10:54:28'),
(40, 'uploads/gallery/img_6a4f308c41db51.97825286.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.34 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.34 AM (1)', '2026-07-09 10:54:28'),
(41, 'uploads/gallery/img_6a4f308c462954.31897551.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.34 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.34 AM', '2026-07-09 10:54:28'),
(42, 'uploads/gallery/img_6a4f308c4c4136.08415959.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.35 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.35 AM (1)', '2026-07-09 10:54:28'),
(43, 'uploads/gallery/img_6a4f308c51c3b5.54363206.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.32 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.32 AM', '2026-07-09 10:54:28'),
(44, 'uploads/gallery/img_6a4f308c56c744.87699663.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.57 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.57 AM (1)', '2026-07-09 10:54:28'),
(45, 'uploads/gallery/img_6a4f308c5b67f0.65056477.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.35 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.35 AM', '2026-07-09 10:54:28'),
(46, 'uploads/gallery/img_6a4f308c605cf4.78674540.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.58 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.58 AM', '2026-07-09 10:54:28'),
(47, 'uploads/gallery/img_6a4f308c64ccf6.74199246.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.58 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.58 AM (1)', '2026-07-09 10:54:28'),
(48, 'uploads/gallery/img_6a4f308c6aa0c3.03268543.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.59 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.59 AM (1)', '2026-07-09 10:54:28'),
(49, 'uploads/gallery/img_6a4f308c7015c9.26337003.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.00 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.00 AM (1)', '2026-07-09 10:54:28'),
(50, 'uploads/gallery/img_6a4f308c749a95.97081382.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.59 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.59 AM', '2026-07-09 10:54:28'),
(51, 'uploads/gallery/img_6a4f308c7b6404.53998599.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.00 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.00 AM', '2026-07-09 10:54:28'),
(52, 'uploads/gallery/img_6a4f308c85e591.73475195.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.01 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.01 AM', '2026-07-09 10:54:28'),
(53, 'uploads/gallery/img_6a4f308c8c9048.56743454.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.03 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.03 AM (1)', '2026-07-09 10:54:28'),
(54, 'uploads/gallery/img_6a4f308c94b700.40868998.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.02 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.02 AM (1)', '2026-07-09 10:54:28'),
(55, 'uploads/gallery/img_6a4f308c9a0bb9.87129177.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.02 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.02 AM', '2026-07-09 10:54:28'),
(56, 'uploads/gallery/img_6a4f308c9f5572.03471278.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.03 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.03 AM', '2026-07-09 10:54:28'),
(57, 'uploads/gallery/img_6a4f308ca80dc4.09226527.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.04 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.04 AM', '2026-07-09 10:54:28'),
(58, 'uploads/gallery/img_6a4f308cb20b45.06399179.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.05 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.05 AM', '2026-07-09 10:54:28'),
(59, 'uploads/gallery/img_6a4f308cbae699.66226373.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.06 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.06 AM (1)', '2026-07-09 10:54:28'),
(60, 'uploads/gallery/img_6a4f308cc1d9b6.45772616.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.07 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.07 AM (1)', '2026-07-09 10:54:28'),
(61, 'uploads/gallery/img_6a4f308ccae991.84588965.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.06 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.06 AM', '2026-07-09 10:54:28'),
(62, 'uploads/gallery/img_6a4f308cd0d921.54778722.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.07 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.07 AM', '2026-07-09 10:54:28'),
(63, 'uploads/gallery/img_6a4f308cd62a76.10650388.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.08 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.08 AM (1)', '2026-07-09 10:54:28'),
(64, 'uploads/gallery/img_6a4f308cdc54c2.60810223.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.08 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.08 AM', '2026-07-09 10:54:28'),
(65, 'uploads/gallery/img_6a4f308ce21d43.63353922.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.09 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.09 AM', '2026-07-09 10:54:28'),
(66, 'uploads/gallery/img_6a4f308ce94713.83758446.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.26 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.26 AM (1)', '2026-07-09 10:54:28'),
(67, 'uploads/gallery/img_6a4f308cf2e317.36123985.jpeg', 'WhatsApp Image 2026 07 06 At 11.13.26 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.13.26 AM', '2026-07-09 10:54:29'),
(68, 'uploads/gallery/img_6a4f308d08e6c4.26596221.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.45 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.45 AM (1)', '2026-07-09 10:54:29'),
(69, 'uploads/gallery/img_6a4f308d1279f1.96019769.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.45 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.45 AM', '2026-07-09 10:54:29'),
(70, 'uploads/gallery/img_6a4f308d196210.20185100.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.46 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.46 AM (1)', '2026-07-09 10:54:29'),
(71, 'uploads/gallery/img_6a4f308d1feed3.27243968.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.46 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.46 AM', '2026-07-09 10:54:29'),
(72, 'uploads/gallery/img_6a4f308d255898.51204945.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.47 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.47 AM', '2026-07-09 10:54:29'),
(73, 'uploads/gallery/img_6a4f308d387245.03522831.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.48 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.48 AM', '2026-07-09 10:54:29'),
(74, 'uploads/gallery/img_6a4f308d405227.61231464.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.49 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.49 AM (1)', '2026-07-09 10:54:29'),
(75, 'uploads/gallery/img_6a4f308d5af1f6.97048089.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.49 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.49 AM', '2026-07-09 10:54:29'),
(76, 'uploads/gallery/img_6a4f308d6ac386.55728978.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.50 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.50 AM', '2026-07-09 10:54:29'),
(77, 'uploads/gallery/img_6a4f308d7bd0b4.73001812.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.51 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.51 AM (1)', '2026-07-09 10:54:29'),
(78, 'uploads/gallery/img_6a4f308d8ed256.32897657.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.51 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.51 AM', '2026-07-09 10:54:29'),
(79, 'uploads/gallery/img_6a4f308d999296.37497146.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.52 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.52 AM (1)', '2026-07-09 10:54:29'),
(80, 'uploads/gallery/img_6a4f308db39e29.98902726.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.52 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.52 AM', '2026-07-09 10:54:29'),
(81, 'uploads/gallery/img_6a4f308dc22c71.28939639.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.53 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.53 AM (1)', '2026-07-09 10:54:29'),
(82, 'uploads/gallery/img_6a4f308dc9a011.56968783.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.53 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.53 AM', '2026-07-09 10:54:29'),
(83, 'uploads/gallery/img_6a4f308ddd4db5.28342651.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.54 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.54 AM', '2026-07-09 10:54:29'),
(84, 'uploads/gallery/img_6a4f308de560f7.05540735.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.55 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.55 AM (1)', '2026-07-09 10:54:29'),
(85, 'uploads/gallery/img_6a4f308e264596.49477339.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.55 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.55 AM', '2026-07-09 10:54:30'),
(86, 'uploads/gallery/img_6a4f308e2f6952.00581466.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.56 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.56 AM (1)', '2026-07-09 10:54:30'),
(87, 'uploads/gallery/img_6a4f308e6a7465.36501381.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.57 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.57 AM', '2026-07-09 10:54:30'),
(88, 'uploads/gallery/img_6a4f308e850535.96389139.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.56 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.56 AM', '2026-07-09 10:54:30'),
(89, 'uploads/gallery/img_6a4f308e9fd0d8.98287661.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.30 AM (2)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.30 AM (2)', '2026-07-09 10:54:30'),
(90, 'uploads/gallery/img_6a4f308f3f80e8.40797921.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.31 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.31 AM (1)', '2026-07-09 10:54:31'),
(91, 'uploads/gallery/img_6a4f308f5c2f88.28930947.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.32 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.32 AM (1)', '2026-07-09 10:54:31'),
(92, 'uploads/gallery/img_6a4f308f6c0074.79731373.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.31 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.31 AM', '2026-07-09 10:54:31'),
(93, 'uploads/gallery/img_6a4f308f7d8b87.91116527.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.32 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.32 AM', '2026-07-09 10:54:31'),
(94, 'uploads/gallery/img_6a4f308f88ac77.69900001.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.32 AM (2)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.32 AM (2)', '2026-07-09 10:54:31'),
(95, 'uploads/gallery/img_6a4f308fc86626.71533589.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.33 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.33 AM (1)', '2026-07-09 10:54:31'),
(96, 'uploads/gallery/img_6a4f308fda4cf5.04530830.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.33 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.33 AM', '2026-07-09 10:54:31'),
(97, 'uploads/gallery/img_6a4f308fe327f0.53259654.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.41 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.41 AM', '2026-07-09 10:54:31'),
(98, 'uploads/gallery/img_6a4f308fe9c889.78587213.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.34 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.34 AM', '2026-07-09 10:54:31'),
(99, 'uploads/gallery/img_6a4f3090012b25.13320583.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.41 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.41 AM (1)', '2026-07-09 10:54:32'),
(100, 'uploads/gallery/img_6a4f30900ba016.18837776.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.42 AM (2)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.42 AM (2)', '2026-07-09 10:54:32'),
(101, 'uploads/gallery/img_6a4f30902f5660.24842309.jpeg', 'WhatsApp Image 2026 07 06 At 11.14.45 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.14.45 AM (1)', '2026-07-09 10:54:32'),
(102, 'uploads/gallery/img_6a4f309045d414.33710627.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.42 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.42 AM', '2026-07-09 10:54:32'),
(103, 'uploads/gallery/img_6a4f309056e6d8.39534023.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.42 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.42 AM (1)', '2026-07-09 10:54:32'),
(104, 'uploads/gallery/img_6a4f3090623fd9.64337868.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.43 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.43 AM (1)', '2026-07-09 10:54:32'),
(105, 'uploads/gallery/img_6a4f309069ded6.68111410.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.43 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.43 AM', '2026-07-09 10:54:32'),
(106, 'uploads/gallery/img_6a4f30906eee27.73699668.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.44 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.44 AM (1)', '2026-07-09 10:54:32'),
(107, 'uploads/gallery/img_6a4f3090778f05.38348663.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.44 AM (2)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.44 AM (2)', '2026-07-09 10:54:32'),
(108, 'uploads/gallery/img_6a4f3090837978.51793053.jpeg', 'WhatsApp Image 2026 07 06 At 11.14.45 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.14.45 AM (1)', '2026-07-09 10:54:32'),
(109, 'uploads/gallery/img_6a4f30908bce02.51168615.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.44 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.44 AM', '2026-07-09 10:54:32'),
(110, 'uploads/gallery/img_6a4f309098c6d1.50678747.jpeg', 'WhatsApp Image 2026 07 06 At 11.12.24 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.12.24 AM (1)', '2026-07-09 10:54:32'),
(112, 'uploads/gallery/img_6a4f30b14f39e7.39242153.jpeg', 'WhatsApp Image 2026 07 06 At 11.14.45 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.14.45 AM', '2026-07-09 10:55:05'),
(113, 'uploads/gallery/img_6a4f30b1677365.28910231.jpeg', 'WhatsApp Image 2026 07 06 At 11.14.44 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.14.44 AM (1)', '2026-07-09 10:55:05'),
(114, 'uploads/gallery/img_6a4f30b17913c8.48730589.jpeg', 'WhatsApp Image 2026 07 06 At 11.14.46 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.14.46 AM', '2026-07-09 10:55:05'),
(115, 'uploads/gallery/img_6a4f30b1910472.54040746.jpeg', 'WhatsApp Image 2026 07 06 At 11.14.44 AM', 'nature', 'WhatsApp Image 2026 07 06 At 11.14.44 AM', '2026-07-09 10:55:05'),
(116, 'uploads/gallery/img_6a4f30b25f8798.51142813.jpeg', 'WhatsApp Image 2026 07 06 At 11.14.45 AM (1)', 'nature', 'WhatsApp Image 2026 07 06 At 11.14.45 AM (1)', '2026-07-09 10:55:06');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `package_name` varchar(150) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `response_text` text DEFAULT NULL,
  `responded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
