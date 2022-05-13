-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 22, 2022 at 02:27 AM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mediclab`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_sample`
--

CREATE TABLE `category_sample` (
  `kd_category` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category_sample`
--

INSERT INTO `category_sample` (`kd_category`, `name`) VALUES
('hematologi', 'Hematologi');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `nota` varchar(13) NOT NULL,
  `nolab` varchar(11) NOT NULL,
  `norm` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_report` datetime NOT NULL,
  `date_finish` datetime DEFAULT NULL,
  `date_acc` datetime DEFAULT NULL,
  `transmit` tinyint(1) NOT NULL,
  `nik` char(17) NOT NULL,
  `name_patient` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `address` varchar(255) NOT NULL,
  `room` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `class` enum('A','B','C') NOT NULL,
  `status` enum('bpjs','reguler') NOT NULL,
  `desc_clinic` varchar(255) NOT NULL,
  `phone` varchar(18) NOT NULL,
  `reqdoc` varchar(255) NOT NULL,
  `accdoc` varchar(50) NOT NULL,
  `petugas` varchar(50) NOT NULL,
  `kesan` varchar(255) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `sample` enum('normal','ikterik','lisis','lipemik') NOT NULL,
  `sample_category` enum('hematologi') NOT NULL,
  `notes` varchar(255) NOT NULL,
  `paket` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`nota`, `nolab`, `norm`, `date_report`, `date_finish`, `date_acc`, `transmit`, `nik`, `name_patient`, `birthdate`, `gender`, `address`, `room`, `class`, `status`, `desc_clinic`, `phone`, `reqdoc`, `accdoc`, `petugas`, `kesan`, `pesan`, `sample`, `sample_category`, `notes`, `paket`) VALUES
('624C8C6F77F02', '20220406001', '231313', '2022-04-06 01:37:35', '2022-04-06 02:17:54', '2022-04-06 02:27:00', 1, '3302230705000004', 'Bambang Sukarjo', '1999-12-30', 'L', '-', 'kalibiru1', 'A', 'reguler', '-', '0846546546', 'dr. Hariyadi', 'dr_hendrawan', 'triagungj', '-', '-', 'lisis', 'hematologi', '-', 'Paket 1'),
('624CB1AC84AF0', '20220406002', '123644', '2022-04-06 04:16:28', '2022-04-06 04:20:14', '2022-04-06 04:20:57', 1, '3302230705000021', 'Saritem', '2000-02-06', 'L', 'KULONPROGO', 'kalibiru1', 'A', 'bpjs', '-', '0846546546', 'dr. Hariyadi', 'dr_hendrawan', 'triagungj', '-', '-', 'ikterik', 'hematologi', '-', 'Paket 1'),
('624CB372D4271', '20220406003', '123522', '2022-04-06 04:24:02', '2022-04-06 04:25:28', '2022-04-06 21:36:12', 1, '3302230705000009', 'Bambang', '2001-05-07', 'L', 'KULONPROGO', 'edelwis1', 'A', 'bpjs', '-', '0846546546', 'dr. Hariyadi', 'dr_hendrawan', 'triagungj', '-', '-', 'normal', 'hematologi', '-', 'Paket 1'),
('62503E76D70A5', '20220408001', '123599', '2022-04-08 20:53:58', '2022-04-08 22:08:07', NULL, 1, '3302230705000004', 'Bambang Sukarjo', '1987-04-05', 'L', '-', 'edelwis1', 'A', 'bpjs', '231dsadsa', '0846546546', 'dr. Hariyadi', 'validator_user', 'triagungj', 'Lemas', '-', 'normal', 'hematologi', '', 'Paket 1'),
('62503E9A998EF', '20220408002', '923828', '2022-04-08 20:54:34', '2022-04-08 22:08:18', NULL, 1, '3302230705000022', 'Rizal', '1995-12-31', 'L', 'KULONPROGO', 'edelwis1', 'B', 'bpjs', '-', '0846546546', 'dr. Hariyadi', 'dr_hendrawan', 'triagungj', '-', 'Rawait Inap', 'ikterik', 'hematologi', '-', 'Paket 1'),
('62503ECAA49F2', '20220408003', '848123', '2022-04-08 20:55:22', NULL, NULL, 0, '3302230401345004', 'Ninda', '1996-11-30', 'P', 'KULONPROGO', 'edelwis1', 'A', 'bpjs', '-', '0846546546', 'dr. Hariyadi', 'dr_hendrawan', 'user', '-', '-', 'ikterik', 'hematologi', '-', 'Paket 1'),
('62503F4ACEE27', '20220408004', '999234', '2022-04-08 20:57:30', NULL, NULL, 0, '33022304013451234', 'Bagyo', '2000-09-30', 'L', '-', 'edelwis1', 'A', 'bpjs', '-', '0846546546', 'dr. Hariyadi Subagyo', 'dr_hendrawan', 'triagungj', '-', 'Rawait Inap', 'ikterik', 'hematologi', '-', 'Paket 1'),
('625055F465998', '20220408005', '321332', '2022-04-08 22:34:12', NULL, NULL, 0, '3302230705000004', 'Farah', '2021-12-31', 'L', 'KULONPROGO', 'edelwis1', 'B', 'bpjs', '-', '08464646446', 'dr. Hariyadi', 'dr_hendrawan', 'user', '-', '-', 'ikterik', 'hematologi', '-', 'Paket 1'),
('62505633F196B', '20220408006', '993282', '2022-04-08 22:35:15', NULL, NULL, 0, 'wqeqweqw', 'Bambang Sukarjo', '2021-12-31', 'L', 'KULONPROGO', 'kalibiru1', 'A', 'reguler', '-', '0846546546', 'dr. Hariyadi Subagyo', 'dr_hendrawan', 'triagungj', '-', '-', 'ikterik', 'hematologi', '-', 'Paket 1'),
('62505897DEA61', '20220408007', '123123', '2022-04-08 22:45:27', NULL, NULL, 0, '3302230705000022', 'Scooty', '2001-10-31', 'L', 'KULONPROGO', 'kalibiru1', 'A', 'bpjs', '-', '0846546546', 'dr. Hariyadi', 'dr_hendrawan', 'triagungj', '-', '-', 'ikterik', 'hematologi', '', 'Paket 1'),
('625058C5C2B87', '20220408008', '123125', '2022-04-08 22:46:13', NULL, NULL, 0, '3302230705000099', 'Bagus', '1987-12-31', 'P', '-', 'edelwis1', 'A', 'reguler', '-', '0846546546', 'dr. Hariyadi Subagyo', 'validator_user', 'user', '-', 'Rawait Inap', 'ikterik', 'hematologi', '-', 'Paket 2'),
('6252C057B7BC7', '20220410001', '152323', '2022-04-10 18:32:39', NULL, NULL, 0, '3302230705000022', 'Farah', '1999-04-10', 'L', 'KULONPROGO', 'kalibiru1', 'A', 'bpjs', '-', '0846546546', 'dr. Hariyadi Subagyo', 'dr_hendrawan', 'user', '', '-', 'lisis', 'hematologi', '-', 'Paket 1');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_kd` varchar(10) NOT NULL,
  `room_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_kd`, `room_name`) VALUES
('edelwis1', 'Edelwis 1'),
('kalibiru1', 'Kalibiru 1'),
('kalibiru2', 'Kalibiru 2'),
('mawar1', 'Mawar 1');

-- --------------------------------------------------------

--
-- Table structure for table `sample`
--

CREATE TABLE `sample` (
  `kd_sample` int NOT NULL,
  `nota` char(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sample`
--

INSERT INTO `sample` (`kd_sample`, `nota`) VALUES
(21, '624C8BF5A8428'),
(22, '624C8C6F77F02'),
(23, '624CB1AC84AF0'),
(24, '624CB372D4271'),
(25, '62503E76D70A5'),
(26, '62503E9A998EF'),
(27, '62503ECAA49F2'),
(28, '62503F4ACEE27'),
(29, '625055F465998'),
(30, '62505633F196B'),
(31, '62505897DEA61'),
(32, '625058C5C2B87'),
(33, '6252C057B7BC7');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category_sample`
--

CREATE TABLE `sub_category_sample` (
  `kd_sub_category` varchar(50) NOT NULL,
  `kd_category` varchar(25) NOT NULL,
  `name` varchar(255) NOT NULL,
  `min_value` double NOT NULL,
  `max_value` double NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `metode` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sub_category_sample`
--

INSERT INTO `sub_category_sample` (`kd_sub_category`, `kd_category`, `name`, `min_value`, `max_value`, `satuan`, `metode`) VALUES
('basofil#', 'hematologi', 'Basofil#', 0, 0.2, 'ribu/ul', NULL),
('basofil%', 'hematologi', 'Basofil%', 1, 2, '%', NULL),
('eosinofil#', 'hematologi', 'Eosinofil#', 0.05, 0.45, 'ribu/ul', NULL),
('eosinofil%', 'hematologi', 'Eosinofil%', 1, 3, '%', NULL),
('eritrosit', 'hematologi', 'Eritrosit', 4, 5.4, 'juta/ul', 'Impedance'),
('hemakotrit', 'hematologi', 'Hemakotrit', 35, 49, 'vol%', 'Analyzer Calculate'),
('hemogoblin', 'hematologi', 'Hemogoblin', 12, 15, 'g/dl', 'Colorimetric'),
('lekosit', 'hematologi', 'Lekosit', 4.5, 11.5, 'ribu/ul', 'Impedance'),
('limfosit#', 'hematologi', 'Limfosit#', 1.6222, 5.37, 'ribu/ul', 'Impedance'),
('limfosit%', 'hematologi', 'Limfosit%', 18, 42, '%', 'Impedance'),
('mch', 'hematologi', 'MCH', 26, 32, 'pg', 'Analyzer Calculates'),
('mcv', 'hematologi', 'MCV', 80, 94, 'fl', 'Analyzer Calculates'),
('monosit#', 'hematologi', 'Monosit#', 0.16, 1, 'ribu/ul', NULL),
('monosit%', 'hematologi', 'Monosit%', 2, 11, '%', NULL),
('mpv', 'hematologi', 'MPV(Mean Platelet Volume)', 7.2, 11.1, 'fL', NULL),
('neurofil%', 'hematologi', 'Neurofil%', 50, 70, '%', NULL),
('neutrofil#', 'hematologi', 'Neutrofil#', 2.3, 8.6, 'uL', NULL),
('pct', 'hematologi', 'PCT(Platelecrit)', 0.17, 0.35, '%', NULL),
('pdw', 'hematologi', 'PDW(Plalelet Distribution Width)', 9, 13, '-', NULL),
('rdw-cv', 'hematologi', 'RDW-CV', 11.5, 14.5, '%', NULL),
('rdw-sd', 'hematologi', 'RDW-sd', 35, 47, 'fL', NULL),
('trombosit', 'hematologi', 'Trombosit', 150, 450, 'ribu/ul', 'Impedance');

-- --------------------------------------------------------

--
-- Table structure for table `sub_sample`
--

CREATE TABLE `sub_sample` (
  `kd_sub_sample` int NOT NULL,
  `kd_sub_category_sample` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `value` double DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `kd_sample` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sub_sample`
--

INSERT INTO `sub_sample` (`kd_sub_sample`, `kd_sub_category_sample`, `value`, `flag`, `kd_sample`) VALUES
(158, 'basofil#', 0, 'normal', '22'),
(159, 'basofil%', 2, 'normal', '22'),
(160, 'eosinofil#', 0.1, 'normal', '22'),
(161, 'eosinofil%', 3, 'normal', '22'),
(162, 'eritrosit', 4, 'normal', '22'),
(163, 'hemakotrit', 35, 'normal', '22'),
(164, 'hemogoblin', 15, 'normal', '22'),
(165, 'lekosit', 12, 'high', '22'),
(166, 'limfosit#', 6, 'high', '22'),
(167, 'limfosit%', 41, 'normal', '22'),
(168, 'mch', 26, 'normal', '22'),
(169, 'mcv', 94, 'normal', '22'),
(170, 'monosit#', 1, 'normal', '22'),
(171, 'monosit%', 12, 'high', '22'),
(172, 'mpv', 12, 'high', '22'),
(173, 'neurofil%', 60, 'normal', '22'),
(174, 'neutrofil#', 9, 'high', '22'),
(175, 'pct', 3, 'high', '22'),
(176, 'pdw', 12, 'normal', '22'),
(177, 'rdw-cv', 12, 'normal', '22'),
(178, 'rdw-sd', 37, 'normal', '22'),
(179, 'trombosit', 159, 'normal', '22'),
(180, 'basofil#', 2, 'high', '23'),
(181, 'basofil%', 2, 'normal', '23'),
(182, 'eosinofil#', 1, 'high', '23'),
(183, 'eosinofil%', 3, 'normal', '23'),
(184, 'eritrosit', 4, 'normal', '23'),
(185, 'hemakotrit', 36, 'normal', '23'),
(186, 'hemogoblin', 13, 'normal', '23'),
(187, 'lekosit', 12, 'high', '23'),
(188, 'limfosit#', 4, 'normal', '23'),
(189, 'limfosit%', 42, 'normal', '23'),
(190, 'mch', 21, 'low', '23'),
(191, 'mcv', 80, 'normal', '23'),
(192, 'monosit#', 1, 'normal', '23'),
(193, 'monosit%', 12, 'high', '23'),
(194, 'mpv', 11, 'normal', '23'),
(195, 'neurofil%', 50, 'normal', '23'),
(196, 'neutrofil#', 8, 'normal', '23'),
(197, 'pct', 0.3, 'normal', '23'),
(198, 'pdw', 9, 'normal', '23'),
(199, 'rdw-cv', 11, 'low', '23'),
(200, 'rdw-sd', 48, 'high', '23'),
(201, 'trombosit', 150, 'normal', '23'),
(202, 'basofil#', 2, 'high', '24'),
(203, 'basofil%', 2, 'normal', '24'),
(204, 'eosinofil#', 1, 'high', '24'),
(205, 'eosinofil%', 3, 'normal', '24'),
(206, 'eritrosit', 3, 'low', '24'),
(207, 'hemakotrit', 3, 'low', '24'),
(208, 'hemogoblin', 3, 'low', '24'),
(209, 'lekosit', 3, 'low', '24'),
(210, 'limfosit#', 3, 'normal', '24'),
(211, 'limfosit%', 3, 'low', '24'),
(212, 'mch', 3, 'low', '24'),
(213, 'mcv', 3, 'low', '24'),
(214, 'monosit#', 3, 'high', '24'),
(215, 'monosit%', 3, 'normal', '24'),
(216, 'mpv', 3, 'low', '24'),
(217, 'neurofil%', 3, 'low', '24'),
(218, 'neutrofil#', 3, 'normal', '24'),
(219, 'pct', 2, 'high', '24'),
(220, 'pdw', 13, 'normal', '24'),
(221, 'rdw-cv', 13, 'normal', '24'),
(222, 'rdw-sd', 3, 'low', '24'),
(223, 'trombosit', 225, 'normal', '24'),
(224, 'basofil#', NULL, NULL, '25'),
(225, 'basofil%', NULL, NULL, '25'),
(226, 'eosinofil#', NULL, NULL, '25'),
(227, 'eosinofil%', NULL, NULL, '25'),
(228, 'eritrosit', NULL, NULL, '25'),
(229, 'hemakotrit', NULL, NULL, '25'),
(230, 'hemogoblin', NULL, NULL, '25'),
(231, 'lekosit', NULL, NULL, '25'),
(232, 'limfosit#', NULL, NULL, '25'),
(233, 'limfosit%', NULL, NULL, '25'),
(234, 'mch', NULL, NULL, '25'),
(235, 'mcv', NULL, NULL, '25'),
(236, 'monosit#', NULL, NULL, '25'),
(237, 'monosit%', NULL, NULL, '25'),
(238, 'mpv', NULL, NULL, '25'),
(239, 'neurofil%', NULL, NULL, '25'),
(240, 'neutrofil#', NULL, NULL, '25'),
(241, 'pct', NULL, NULL, '25'),
(242, 'pdw', NULL, NULL, '25'),
(243, 'rdw-cv', NULL, NULL, '25'),
(244, 'rdw-sd', NULL, NULL, '25'),
(245, 'trombosit', NULL, NULL, '25'),
(246, 'basofil#', NULL, NULL, '26'),
(247, 'basofil%', NULL, NULL, '26'),
(248, 'eosinofil#', NULL, NULL, '26'),
(249, 'eosinofil%', NULL, NULL, '26'),
(250, 'eritrosit', NULL, NULL, '26'),
(251, 'hemakotrit', NULL, NULL, '26'),
(252, 'hemogoblin', NULL, NULL, '26'),
(253, 'lekosit', NULL, NULL, '26'),
(254, 'limfosit#', NULL, NULL, '26'),
(255, 'limfosit%', NULL, NULL, '26'),
(256, 'mch', NULL, NULL, '26'),
(257, 'mcv', NULL, NULL, '26'),
(258, 'monosit#', NULL, NULL, '26'),
(259, 'monosit%', NULL, NULL, '26'),
(260, 'mpv', NULL, NULL, '26'),
(261, 'neurofil%', NULL, NULL, '26'),
(262, 'neutrofil#', NULL, NULL, '26'),
(263, 'pct', NULL, NULL, '26'),
(264, 'pdw', NULL, NULL, '26'),
(265, 'rdw-cv', NULL, NULL, '26'),
(266, 'rdw-sd', NULL, NULL, '26'),
(267, 'trombosit', NULL, NULL, '26'),
(268, 'basofil#', NULL, NULL, '27'),
(269, 'basofil%', NULL, NULL, '27'),
(270, 'eosinofil#', NULL, NULL, '27'),
(271, 'eosinofil%', NULL, NULL, '27'),
(272, 'eritrosit', NULL, NULL, '27'),
(273, 'hemakotrit', NULL, NULL, '27'),
(274, 'hemogoblin', NULL, NULL, '27'),
(275, 'lekosit', NULL, NULL, '27'),
(276, 'limfosit#', NULL, NULL, '27'),
(277, 'limfosit%', NULL, NULL, '27'),
(278, 'mch', NULL, NULL, '27'),
(279, 'mcv', NULL, NULL, '27'),
(280, 'monosit#', NULL, NULL, '27'),
(281, 'monosit%', NULL, NULL, '27'),
(282, 'mpv', NULL, NULL, '27'),
(283, 'neurofil%', NULL, NULL, '27'),
(284, 'neutrofil#', NULL, NULL, '27'),
(285, 'pct', NULL, NULL, '27'),
(286, 'pdw', NULL, NULL, '27'),
(287, 'rdw-cv', NULL, NULL, '27'),
(288, 'rdw-sd', NULL, NULL, '27'),
(289, 'trombosit', NULL, NULL, '27'),
(290, 'basofil#', NULL, NULL, '28'),
(291, 'basofil%', NULL, NULL, '28'),
(292, 'eosinofil#', NULL, NULL, '28'),
(293, 'eosinofil%', NULL, NULL, '28'),
(294, 'eritrosit', NULL, NULL, '28'),
(295, 'hemakotrit', NULL, NULL, '28'),
(296, 'hemogoblin', NULL, NULL, '28'),
(297, 'lekosit', NULL, NULL, '28'),
(298, 'limfosit#', NULL, NULL, '28'),
(299, 'limfosit%', NULL, NULL, '28'),
(300, 'mch', NULL, NULL, '28'),
(301, 'mcv', NULL, NULL, '28'),
(302, 'monosit#', NULL, NULL, '28'),
(303, 'monosit%', NULL, NULL, '28'),
(304, 'mpv', NULL, NULL, '28'),
(305, 'neurofil%', NULL, NULL, '28'),
(306, 'neutrofil#', NULL, NULL, '28'),
(307, 'pct', NULL, NULL, '28'),
(308, 'pdw', NULL, NULL, '28'),
(309, 'rdw-cv', NULL, NULL, '28'),
(310, 'rdw-sd', NULL, NULL, '28'),
(311, 'trombosit', NULL, NULL, '28'),
(312, 'basofil#', NULL, NULL, '29'),
(313, 'basofil%', NULL, NULL, '29'),
(314, 'eosinofil#', NULL, NULL, '29'),
(315, 'eosinofil%', NULL, NULL, '29'),
(316, 'eritrosit', NULL, NULL, '29'),
(317, 'hemakotrit', NULL, NULL, '29'),
(318, 'hemogoblin', NULL, NULL, '29'),
(319, 'lekosit', NULL, NULL, '29'),
(320, 'limfosit#', NULL, NULL, '29'),
(321, 'limfosit%', NULL, NULL, '29'),
(322, 'mch', NULL, NULL, '29'),
(323, 'mcv', NULL, NULL, '29'),
(324, 'monosit#', NULL, NULL, '29'),
(325, 'monosit%', NULL, NULL, '29'),
(326, 'mpv', NULL, NULL, '29'),
(327, 'neurofil%', NULL, NULL, '29'),
(328, 'neutrofil#', NULL, NULL, '29'),
(329, 'pct', NULL, NULL, '29'),
(330, 'pdw', NULL, NULL, '29'),
(331, 'rdw-cv', NULL, NULL, '29'),
(332, 'rdw-sd', NULL, NULL, '29'),
(333, 'trombosit', NULL, NULL, '29'),
(334, 'basofil#', NULL, NULL, '30'),
(335, 'basofil%', NULL, NULL, '30'),
(336, 'eosinofil#', NULL, NULL, '30'),
(337, 'eosinofil%', NULL, NULL, '30'),
(338, 'eritrosit', NULL, NULL, '30'),
(339, 'hemakotrit', NULL, NULL, '30'),
(340, 'hemogoblin', NULL, NULL, '30'),
(341, 'lekosit', NULL, NULL, '30'),
(342, 'limfosit#', NULL, NULL, '30'),
(343, 'limfosit%', NULL, NULL, '30'),
(344, 'mch', NULL, NULL, '30'),
(345, 'mcv', NULL, NULL, '30'),
(346, 'monosit#', NULL, NULL, '30'),
(347, 'monosit%', NULL, NULL, '30'),
(348, 'mpv', NULL, NULL, '30'),
(349, 'neurofil%', NULL, NULL, '30'),
(350, 'neutrofil#', NULL, NULL, '30'),
(351, 'pct', NULL, NULL, '30'),
(352, 'pdw', NULL, NULL, '30'),
(353, 'rdw-cv', NULL, NULL, '30'),
(354, 'rdw-sd', NULL, NULL, '30'),
(355, 'trombosit', NULL, NULL, '30'),
(356, 'basofil#', NULL, NULL, '31'),
(357, 'basofil%', NULL, NULL, '31'),
(358, 'eosinofil#', NULL, NULL, '31'),
(359, 'eosinofil%', NULL, NULL, '31'),
(360, 'eritrosit', NULL, NULL, '31'),
(361, 'hemakotrit', NULL, NULL, '31'),
(362, 'hemogoblin', NULL, NULL, '31'),
(363, 'lekosit', NULL, NULL, '31'),
(364, 'limfosit#', NULL, NULL, '31'),
(365, 'limfosit%', NULL, NULL, '31'),
(366, 'mch', NULL, NULL, '31'),
(367, 'mcv', NULL, NULL, '31'),
(368, 'monosit#', NULL, NULL, '31'),
(369, 'monosit%', NULL, NULL, '31'),
(370, 'mpv', NULL, NULL, '31'),
(371, 'neurofil%', NULL, NULL, '31'),
(372, 'neutrofil#', NULL, NULL, '31'),
(373, 'pct', NULL, NULL, '31'),
(374, 'pdw', NULL, NULL, '31'),
(375, 'rdw-cv', NULL, NULL, '31'),
(376, 'rdw-sd', NULL, NULL, '31'),
(377, 'trombosit', NULL, NULL, '31'),
(378, 'basofil#', NULL, NULL, '32'),
(379, 'basofil%', NULL, NULL, '32'),
(380, 'eosinofil#', NULL, NULL, '32'),
(381, 'eosinofil%', NULL, NULL, '32'),
(382, 'eritrosit', NULL, NULL, '32'),
(383, 'hemakotrit', NULL, NULL, '32'),
(384, 'hemogoblin', NULL, NULL, '32'),
(385, 'lekosit', NULL, NULL, '32'),
(386, 'limfosit#', NULL, NULL, '32'),
(387, 'limfosit%', NULL, NULL, '32'),
(388, 'mch', NULL, NULL, '32'),
(389, 'mcv', NULL, NULL, '32'),
(390, 'monosit#', NULL, NULL, '32'),
(391, 'monosit%', NULL, NULL, '32'),
(392, 'mpv', NULL, NULL, '32'),
(393, 'neurofil%', NULL, NULL, '32'),
(394, 'neutrofil#', NULL, NULL, '32'),
(395, 'pct', NULL, NULL, '32'),
(396, 'pdw', NULL, NULL, '32'),
(397, 'rdw-cv', NULL, NULL, '32'),
(398, 'rdw-sd', NULL, NULL, '32'),
(399, 'trombosit', NULL, NULL, '32'),
(400, 'basofil#', NULL, NULL, '33'),
(401, 'basofil%', NULL, NULL, '33'),
(402, 'eosinofil#', NULL, NULL, '33'),
(403, 'eosinofil%', NULL, NULL, '33'),
(404, 'eritrosit', NULL, NULL, '33'),
(405, 'hemakotrit', NULL, NULL, '33'),
(406, 'hemogoblin', NULL, NULL, '33'),
(407, 'lekosit', NULL, NULL, '33'),
(408, 'limfosit#', NULL, NULL, '33'),
(409, 'limfosit%', NULL, NULL, '33'),
(410, 'mch', NULL, NULL, '33'),
(411, 'mcv', NULL, NULL, '33'),
(412, 'monosit#', NULL, NULL, '33'),
(413, 'monosit%', NULL, NULL, '33'),
(414, 'mpv', NULL, NULL, '33'),
(415, 'neurofil%', NULL, NULL, '33'),
(416, 'neutrofil#', NULL, NULL, '33'),
(417, 'pct', NULL, NULL, '33'),
(418, 'pdw', NULL, NULL, '33'),
(419, 'rdw-cv', NULL, NULL, '33'),
(420, 'rdw-sd', NULL, NULL, '33'),
(421, 'trombosit', NULL, NULL, '33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jabatan` enum('petugas','validator') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `name`, `jabatan`) VALUES
('dr_hendrawan', 'michael', 'dr. Hendrawan Budiyono', 'validator'),
('triagungj', 'juggernaut', 'Agung Wicaksono', 'petugas'),
('user', '1234', 'Rahman', 'petugas'),
('validator_user', '1234', 'dr. Faradhika MD', 'validator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_sample`
--
ALTER TABLE `category_sample`
  ADD PRIMARY KEY (`kd_category`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`nota`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_kd`);

--
-- Indexes for table `sample`
--
ALTER TABLE `sample`
  ADD PRIMARY KEY (`kd_sample`);

--
-- Indexes for table `sub_category_sample`
--
ALTER TABLE `sub_category_sample`
  ADD PRIMARY KEY (`kd_sub_category`);

--
-- Indexes for table `sub_sample`
--
ALTER TABLE `sub_sample`
  ADD PRIMARY KEY (`kd_sub_sample`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sample`
--
ALTER TABLE `sample`
  MODIFY `kd_sample` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `sub_sample`
--
ALTER TABLE `sub_sample`
  MODIFY `kd_sub_sample` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
