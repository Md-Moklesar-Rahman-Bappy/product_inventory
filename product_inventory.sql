-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 12:28 PM
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
-- Database: `product_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `batch_uuid` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model`, `model_id`, `description`, `ip_address`, `user_agent`, `role`, `event`, `created_at`, `updated_at`) VALUES
(1, 1, 'update', 'Product', 22, 'Updated product: HP ProOne 440 G9 23.9 inch All-in-One Desktop', NULL, NULL, NULL, NULL, '2025-08-13 02:41:03', '2025-08-13 02:41:03'),
(2, 1, 'update', 'Product', 31, 'Updated product: Brother Printer MFC-L6710DW', NULL, NULL, NULL, NULL, '2025-08-13 08:50:56', '2025-08-13 08:50:56'),
(3, 1, 'update', 'Product', 29, 'Serial No: WPM42L31DTF062500090 | Changed: User_description: \"উপসচিব ভূমি ভবন\" → \"শফিক স্যার উপসচিব\", Remarks: \"\" → \"সচিবালয়\", Updated_at: \"2025-08-13 03:24:58\" → \"2025-08-13 14:54:22\"', NULL, NULL, NULL, NULL, '2025-08-13 08:54:22', '2025-08-13 08:54:22'),
(4, 1, 'update', 'Product', 23, 'Serial No: <strong>8CN5110N5H</strong><br>Changed: ', NULL, NULL, NULL, NULL, '2025-08-13 09:21:24', '2025-08-13 09:21:24'),
(5, 1, 'update', 'Product', 23, 'Serial No: <strong>8CN5110N5H</strong><br>Changed: <span class=\"badge bg-warning text-dark\">User Description: \"মোঃ মোকলেসার রহমান\r\nঅ্যাসিস্ট্যান্ট মেইনটেনেন্স\" → \"মোঃ মোকলেসার রহমান\r\nঅ্যাসিস্ট্যান্ট মেইনটেনেন্স ইঙ্গিনিয়ার\"</span> <span class=\"badge bg-warning text-dark\">Updated At: \"2025-08-13 15:20:41\" → \"2025-08-13 15:23:57\"</span>', NULL, NULL, NULL, NULL, '2025-08-13 09:23:57', '2025-08-13 09:23:57'),
(6, 1, 'create', 'Product', 42, 'Created product: HP ProBook 440 G11 Notebook PC', NULL, NULL, NULL, NULL, '2025-08-13 09:31:59', '2025-08-13 09:31:59'),
(7, 1, 'delete', 'Product', 42, 'Deleted product: HP ProBook 440 G11 Notebook PC', NULL, NULL, NULL, NULL, '2025-08-13 09:33:19', '2025-08-13 09:33:19'),
(8, 1, 'create', 'Product', 43, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 01 Receiver</strong><br>Serial No: <code>4907761</code>', NULL, NULL, NULL, NULL, '2025-08-19 09:50:19', '2025-08-19 09:50:19'),
(9, 1, 'create', 'Product', 44, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 01 Controller</strong><br>Serial No: <code>4597703</code>', NULL, NULL, NULL, NULL, '2025-08-19 09:52:07', '2025-08-19 09:52:07'),
(10, 1, 'create', 'Product', 45, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 01 Rover A Receiver</strong><br>Serial No: <code>4907738</code>', NULL, NULL, NULL, NULL, '2025-08-19 09:54:46', '2025-08-19 09:54:46'),
(11, 1, 'create', 'Product', 46, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 01 Rover A Controller</strong><br>Serial No: <code>4597687</code>', NULL, NULL, NULL, NULL, '2025-08-19 09:55:44', '2025-08-19 09:55:44'),
(12, 1, 'create', 'Product', 47, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 01 Rover B Receiver</strong><br>Serial No: <code>4907744</code>', NULL, NULL, NULL, NULL, '2025-08-19 09:56:56', '2025-08-19 09:56:56'),
(13, 1, 'create', 'Product', 48, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 01 Rover B Controller</strong><br>Serial No: <code>4597701</code>', NULL, NULL, NULL, NULL, '2025-08-19 09:57:36', '2025-08-19 09:57:36'),
(14, 1, 'create', 'Product', 49, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 02 Receiver</strong><br>Serial No: <code>4907763</code>', NULL, NULL, NULL, NULL, '2025-08-19 09:59:22', '2025-08-19 09:59:22'),
(15, 1, 'create', 'Product', 50, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 02 Controller</strong><br>Serial No: <code>4597691</code>', NULL, NULL, NULL, NULL, '2025-08-19 09:59:52', '2025-08-19 09:59:52'),
(16, 1, 'create', 'Product', 51, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 02 Rover A Receiver</strong><br>Serial No: <code>4907771</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:22:58', '2025-08-19 10:22:58'),
(17, 1, 'create', 'Product', 52, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 02 Rover B Controller</strong><br>Serial No: <code>4597661</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:23:37', '2025-08-19 10:23:37'),
(18, 1, 'update', 'Product', 52, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 02 Rover A Controller</strong><br>Serial No: <code>4597661</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Product Name: \"Base 02 Rover B Controller\" → \"Base 02 Rover A Controller\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-19 16:23:37\" → \"2025-08-19 16:24:12\"</span>', NULL, NULL, NULL, NULL, '2025-08-19 10:24:12', '2025-08-19 10:24:12'),
(19, 1, 'create', 'Product', 53, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 02 Rover B Receiver</strong><br>Serial No: <code>4907772</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:25:29', '2025-08-19 10:25:29'),
(20, 1, 'create', 'Product', 54, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 02 Rover B Controller</strong><br>Serial No: <code>4597685</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:26:09', '2025-08-19 10:26:09'),
(21, 1, 'create', 'Product', 55, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 03 Receiver</strong><br>Serial No: <code>4907770</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:28:39', '2025-08-19 10:28:39'),
(22, 1, 'create', 'Product', 56, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 03 Controller</strong><br>Serial No: <code>4595758</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:29:40', '2025-08-19 10:29:40'),
(23, 1, 'create', 'Product', 57, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 03 Rover A Receiver</strong><br>Serial No: <code>4907755</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:30:50', '2025-08-19 10:30:50'),
(24, 1, 'create', 'Product', 58, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 03 Rover A Controller</strong><br>Serial No: <code>4597688</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:31:52', '2025-08-19 10:31:52'),
(25, 1, 'create', 'Product', 59, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 03 Rover B Receiver</strong><br>Serial No: <code>4907743</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:32:29', '2025-08-19 10:32:29'),
(26, 1, 'create', 'Product', 60, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 03 Rover B Controller</strong><br>Serial No: <code>4597704</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:33:01', '2025-08-19 10:33:01'),
(27, 1, 'create', 'Product', 61, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 04 Receiver</strong><br>Serial No: <code>4907764</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:35:26', '2025-08-19 10:35:26'),
(28, 1, 'create', 'Product', 62, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 04 Controller</strong><br>Serial No: <code>4597658</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:36:01', '2025-08-19 10:36:01'),
(29, 1, 'create', 'Product', 63, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 04 Rover A Receiver</strong><br>Serial No: <code>4907765</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:36:40', '2025-08-19 10:36:40'),
(30, 1, 'create', 'Product', 64, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 04 Rover A Controller</strong><br>Serial No: <code>4597683</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:37:28', '2025-08-19 10:37:28'),
(31, 1, 'create', 'Product', 65, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 04 Rover B Receiver</strong><br>Serial No: <code>4907774</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:38:16', '2025-08-19 10:38:16'),
(32, 1, 'create', 'Product', 66, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 04 Rover B Controller</strong><br>Serial No: <code>4597693</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:38:54', '2025-08-19 10:38:54'),
(33, 1, 'create', 'Product', 67, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 05 Receiver</strong><br>Serial No: <code>4907739</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:40:11', '2025-08-19 10:40:11'),
(34, 1, 'create', 'Product', 68, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 05 Controller</strong><br>Serial No: <code>4597705</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:40:48', '2025-08-19 10:40:48'),
(35, 1, 'create', 'Product', 69, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 05 Rover A Receiver</strong><br>Serial No: <code>4907747</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:41:28', '2025-08-19 10:41:28'),
(36, 1, 'create', 'Product', 70, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 05 Rover A Controller</strong><br>Serial No: <code>4597686</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:41:55', '2025-08-19 10:41:55'),
(37, 1, 'create', 'Product', 71, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 05 Rover B Receiver</strong><br>Serial No: <code>4907760</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:42:30', '2025-08-19 10:42:30'),
(38, 1, 'create', 'Product', 72, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 05 Rover B Controller</strong><br>Serial No: <code>4597694</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:43:07', '2025-08-19 10:43:07'),
(39, 1, 'create', 'Product', 73, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 06 Receiver</strong><br>Serial No: <code>4907754</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:43:40', '2025-08-19 10:43:40'),
(40, 1, 'create', 'Product', 74, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 06 Controller</strong><br>Serial No: <code>4597690</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:44:01', '2025-08-19 10:44:01'),
(41, 1, 'create', 'Product', 75, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 06 Rover A Receiver</strong><br>Serial No: <code>4907769</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:44:32', '2025-08-19 10:44:32'),
(42, 1, 'create', 'Product', 76, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 06 Rover A Controller</strong><br>Serial No: <code>4597659</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:45:14', '2025-08-19 10:45:14'),
(43, 1, 'create', 'Product', 77, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 06 Rover B Receiver</strong><br>Serial No: <code>4907757</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:46:03', '2025-08-19 10:46:03'),
(44, 1, 'create', 'Product', 78, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 06 Rover B Controller</strong><br>Serial No: <code>4596693</code>', NULL, NULL, NULL, NULL, '2025-08-19 10:47:22', '2025-08-19 10:47:22'),
(45, 1, 'update', 'Product', 22, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N6Q</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-08-03 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2025-08-27 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-13 08:37:57\" → \"2025-08-24 09:41:12\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', NULL, NULL, '2025-08-24 03:41:12', '2025-08-24 03:41:12'),
(46, 1, 'update', 'Product', 22, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N6Q</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-08-27 00:00:00\" → \"2025-08-31 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-24 09:41:12\" → \"2025-08-24 09:41:25\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', NULL, NULL, '2025-08-24 03:41:25', '2025-08-24 03:41:25'),
(47, 1, 'update', 'Product', 22, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N6Q</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-08-31 00:00:00\" → \"2025-09-02 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-24 09:41:25\" → \"2025-08-24 09:41:34\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', NULL, NULL, '2025-08-24 03:41:34', '2025-08-24 03:41:34'),
(48, 1, 'update', 'Product', 22, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N6Q</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-09-02 00:00:00\" → \"2025-09-30 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-24 09:41:34\" → \"2025-08-24 09:41:41\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', NULL, NULL, '2025-08-24 03:41:41', '2025-08-24 03:41:41'),
(49, 1, 'update', 'Product', 23, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N5H</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-08-23 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2025-08-30 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-13 15:23:57\" → \"2025-08-24 16:03:58\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-24 10:03:58', '2025-08-24 10:03:58'),
(50, 1, 'update', 'Product', 24, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N7C</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-08-24 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2025-08-31 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-13 03:14:18\" → \"2025-08-25 10:01:41\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-25 04:01:41', '2025-08-25 04:01:41'),
(51, 1, 'create', 'Category', 8, 'Created category: <strong></strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-25 08:55:00', '2025-08-25 08:55:00'),
(52, 1, 'delete', 'Category', 8, 'Deleted category: <strong></strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-25 08:55:23', '2025-08-25 08:55:23'),
(53, 1, 'update', 'Product', 22, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N6Q</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2025-08-03 00:00:00\" → \"2025-01-01 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-24 09:41:41\" → \"2025-08-27 10:32:59\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:32:59', '2025-08-27 04:32:59'),
(54, 1, 'update', 'Product', 25, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProBook 440 G11 Notebook PC</strong><br>Serial No: <code>5CD51172ZC</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-08-01 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2025-08-27 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-13 03:15:05\" → \"2025-08-27 10:33:46\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:33:46', '2025-08-27 04:33:46'),
(55, 1, 'update', 'Product', 25, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProBook 440 G11 Notebook PC</strong><br>Serial No: <code>5CD51172ZC</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-08-27 00:00:00\" → \"2025-08-30 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-27 10:33:46\" → \"2025-08-27 10:33:54\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:33:54', '2025-08-27 04:33:54'),
(56, 1, 'update', 'Product', 22, '<span class=\"text-muted fw-bold\">No changes</span> made to product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N6Q</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:34:00', '2025-08-27 04:34:00'),
(57, 1, 'update', 'Product', 22, '<span class=\"text-muted fw-bold\">No changes</span> made to product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N6Q</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:45:53', '2025-08-27 04:45:53'),
(58, 1, 'update', 'Product', 22, '<span class=\"text-muted fw-bold\">No changes</span> made to product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N6Q</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:48:33', '2025-08-27 04:48:33'),
(59, 1, 'update', 'Product', 25, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProBook 440 G11 Notebook PC</strong><br>Serial No: <code>5CD51172ZC</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2025-08-01 00:00:00\" → \"2025-06-01 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-27 10:33:54\" → \"2025-08-27 10:48:49\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:48:49', '2025-08-27 04:48:49'),
(60, 1, 'update', 'Product', 22, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N6Q</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-09-30 00:00:00\" → \"2026-05-30 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-27 10:32:59\" → \"2025-08-27 10:49:08\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:49:08', '2025-08-27 04:49:08'),
(61, 1, 'update', 'Product', 23, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N5H</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-08-30 00:00:00\" → \"2026-02-26 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-24 16:03:58\" → \"2025-08-27 10:49:22\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:49:22', '2025-08-27 04:49:22'),
(62, 1, 'update', 'Product', 24, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N7C</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-08-31 00:00:00\" → \"2026-01-27 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-25 10:01:41\" → \"2025-08-27 10:49:29\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:49:29', '2025-08-27 04:49:29'),
(63, 1, 'create', 'Product', 79, '<span class=\"text-success fw-bold\">Created</span> product: <strong>HP Printon PMF 42A</strong><br>Serial No: <code>5CD51172ZR5</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 04:51:39', '2025-08-27 04:51:39'),
(64, 1, 'create', 'User', 2, 'Created user: Admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 07:52:22', '2025-08-27 07:52:22'),
(65, 1, 'create', 'User', 3, 'Created user: Md Moklesar Rahman', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 07:54:39', '2025-08-27 07:54:39'),
(66, 3, 'create', 'User', 4, 'Created user: User', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 07:56:03', '2025-08-27 07:56:03'),
(67, 4, 'update', 'Category', 1, 'Updated category: Laptop 01', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:13:18', '2025-08-27 09:13:18'),
(68, 4, 'update', 'Category', 1, 'Updated category: Laptop', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:13:28', '2025-08-27 09:13:28'),
(69, 4, 'update', 'Brand', 6, 'Updated brand: Xerox 01', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:13:48', '2025-08-27 09:13:48'),
(70, 4, 'update', 'Brand', 6, 'Updated brand: Xerox', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:13:58', '2025-08-27 09:13:58'),
(71, 4, 'update', 'Model', 8, 'Updated model: Leica CS20 LTE 01', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:14:11', '2025-08-27 09:14:11'),
(72, 4, 'update', 'Model', 8, 'Updated model: Leica CS20 LTE', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:15:26', '2025-08-27 09:15:26'),
(73, 4, 'create', 'Maintenance', 2, 'Created maintenance for Serial No: 5CD5117331 — Desktop', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:18:26', '2025-08-27 09:18:26'),
(74, 4, 'delete', 'Maintenance', 2, 'Deleted maintenance for Serial No: 5CD5117331', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:18:54', '2025-08-27 09:18:54'),
(75, 4, 'update', 'Product', 22, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N6Q</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2025-01-01 00:00:00\" → \"2025-08-27 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-27 10:49:08\" → \"2025-08-27 15:29:24\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:29:24', '2025-08-27 09:29:24'),
(76, 4, 'update', 'Category', 1, 'Updated category: Laptop 01', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:33:37', '2025-08-27 09:33:37'),
(77, 4, 'update', 'Category', 1, '<span class=\"text-primary fw-bold\">Updated</span> category: <strong>Laptop</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:36:16', '2025-08-27 09:36:16'),
(78, 4, 'update', 'Category', 2, '<span class=\"text-primary fw-bold\">Updated</span> category: <strong>Desktop zdbgxbxcb</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:37:36', '2025-08-27 09:37:36'),
(79, 4, 'update', 'Category', 2, '<span class=\"text-primary fw-bold\">Updated</span> category: <strong>Desktop</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:37:49', '2025-08-27 09:37:49'),
(80, 4, 'create', 'Category', 7, '<span class=\"text-success fw-bold\">Created</span> category: <strong>srgzdh</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:45:43', '2025-08-27 09:45:43'),
(81, 4, 'delete', 'Category', 7, '<span class=\"text-danger fw-bold\">Deleted</span> category: <strong>srgzdh</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:45:48', '2025-08-27 09:45:48'),
(82, 4, 'create', 'Brand', 7, 'Created brand: XCBxCbXDB', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:46:19', '2025-08-27 09:46:19'),
(83, 4, 'delete', 'Brand', 7, 'Deleted brand: XCBxCbXDB', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:46:23', '2025-08-27 09:46:23'),
(84, 4, 'create', 'Brand', 8, '<span class=\"text-success fw-bold\">Created</span> brand: <strong>zdbc</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:48:29', '2025-08-27 09:48:29'),
(85, 4, 'delete', 'Brand', 8, '<span class=\"text-danger fw-bold\">Deleted</span> brand: <strong>zdbc</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:48:32', '2025-08-27 09:48:32'),
(86, 4, 'create', 'Model', 9, '<span class=\"text-success fw-bold\">Created</span> model: <strong>SSDBZXCBxc</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:49:09', '2025-08-27 09:49:09'),
(87, 4, 'delete', 'Model', 9, '<span class=\"text-danger fw-bold\">Deleted</span> model: <strong>SSDBZXCBxc</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-27 09:49:21', '2025-08-27 09:49:21'),
(88, 1, 'update', 'Product', 79, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP Printon PMF 42A</strong><br>Serial No: <code>5CD51172ZR5</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Price: \"0.00\" → \"1000\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2025-07-01 10:51:00\" → \"2025-07-01 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-12-30 10:51:00\" → \"2025-12-30 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-27 10:51:38\" → \"2025-08-28 10:09:48\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:09:48', '2025-08-28 04:09:48'),
(89, 1, 'update', 'Product', 78, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 06 Rover B Controller</strong><br>Serial No: <code>4596693</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Price: \"0.00\" → \"2000\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-08-01 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2025-08-31 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-19 16:47:22\" → \"2025-08-28 10:10:11\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:10:11', '2025-08-28 04:10:11'),
(90, 1, 'create', 'Brand', 7, '<span class=\"text-success fw-bold\">Created</span> brand: <strong>SFBxFB</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:10:37', '2025-08-28 04:10:37'),
(91, 1, 'delete', 'Brand', 7, '<span class=\"text-danger fw-bold\">Deleted</span> brand: <strong>SFBxFB</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:10:41', '2025-08-28 04:10:41'),
(92, 1, 'create', 'Model', 10, '<span class=\"text-success fw-bold\">Created</span> model: <strong>XFbxcb</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:11:17', '2025-08-28 04:11:17'),
(93, 1, 'delete', 'Model', 10, '<span class=\"text-danger fw-bold\">Deleted</span> model: <strong>XFbxcb</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:11:25', '2025-08-28 04:11:25'),
(94, 1, 'create', 'Maintenance', 1, 'Created maintenance for Serial No: 4907757 — Antenna Missing', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:12:25', '2025-08-28 04:12:25'),
(95, 1, 'update', 'Product', 77, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 06 Rover B Receiver</strong><br>Serial No: <code>4907757</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-06-01 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2025-09-30 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-19 16:46:03\" → \"2025-08-28 10:13:20\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:13:20', '2025-08-28 04:13:20'),
(96, 1, 'create', 'Maintenance', 2, 'Created maintenance for Serial No: 4907757 — Missing Iteam', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:14:23', '2025-08-28 04:14:23'),
(97, 1, 'create', 'Product', 80, '<span class=\"text-success fw-bold\">Created</span> product: <strong>HP ProBook 440 G11 Notebook PC</strong><br>Serial No: <code>SZRHSFHBSFB</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:20:48', '2025-08-28 04:20:48'),
(98, 1, 'update', 'Product', 80, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProBook 440 G11 Notebook PC</strong><br>Serial No: <code>SZRHSFHBSFB</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2025-08-01 10:20:00\" → \"2025-08-01 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-08-13 10:20:00\" → \"2025-09-30 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-28 10:20:48\" → \"2025-08-28 10:21:19\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:21:19', '2025-08-28 04:21:19'),
(99, 1, 'delete', 'Product', 80, '<span class=\"text-danger fw-bold\">Deleted</span> product: <strong>HP ProBook 440 G11 Notebook PC</strong><br>Serial No: <code>SZRHSFHBSFB</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:21:22', '2025-08-28 04:21:22'),
(100, 1, 'create', 'Category', 9, '<span class=\"text-success fw-bold\">Created</span> category: <strong>sxdfgzxg</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:45:31', '2025-08-28 04:45:31'),
(101, 1, 'delete', 'Category', 9, '<span class=\"text-danger fw-bold\">Deleted</span> category: <strong>sxdfgzxg</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:45:34', '2025-08-28 04:45:34'),
(102, 1, 'delete', 'Maintenance', 2, '<span class=\"text-danger fw-bold\">Deleted</span> maintenance for <strong>Serial No: 4907757</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:46:23', '2025-08-28 04:46:23'),
(103, 1, 'create', 'User', 4, 'Created user: Admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:47:57', '2025-08-28 04:47:57'),
(104, 4, 'create', 'User', 5, 'Created user: User', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:49:11', '2025-08-28 04:49:11'),
(105, 4, 'delete', 'User', 5, '<span class=\"text-danger fw-bold\">Deleted</span> user: <strong>User</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:50:10', '2025-08-28 04:50:10'),
(106, 4, 'create', 'User', 6, '<span class=\"text-success fw-bold\">Created</span> user: <strong>User</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 04:50:47', '2025-08-28 04:50:47'),
(107, 1, 'create', 'User', 7, '<span class=\"text-success fw-bold\">Created</span> user: <strong>User</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 05:32:03', '2025-08-28 05:32:03'),
(108, 1, 'create', 'Product', 81, '<span class=\"text-success fw-bold\">Created</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N4B</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 05:47:27', '2025-08-28 05:47:27'),
(109, 1, 'update', 'Product', 81, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N4B</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Price: \"120000.00\" → \"120000.95\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2025-06-01 11:47:00\" → \"2025-06-01 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2028-06-30 11:47:00\" → \"2028-06-30 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-28 11:47:27\" → \"2025-08-28 11:53:04\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 05:53:04', '2025-08-28 05:53:04'),
(110, 1, 'update', 'Product', 81, '<span class=\"text-muted fw-bold\">No changes</span> made to product: <strong>HP ProOne 440 G9 23.9 inch All-in-One Desktop</strong><br>Serial No: <code>8CN5110N4B</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-08-28 05:53:49', '2025-08-28 05:53:49'),
(111, 1, 'create', 'Product', 82, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 07 Receiver</strong><br>Serial No: <code>4907762</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:09:24', '2025-09-01 10:09:24'),
(112, 1, 'update', 'Product', 82, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 07 Receiver</strong><br>Serial No: <code>4907762</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2025-05-07 17:00:00\" → \"2025-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2028-05-07 16:02:00\" → \"2028-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-01 16:09:24\" → \"2025-09-01 16:09:51\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:09:51', '2025-09-01 10:09:51'),
(113, 1, 'update', 'Product', 82, '<span class=\"text-muted fw-bold\">No changes</span> made to product: <strong>Base 07 Receiver</strong><br>Serial No: <code>4907762</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:10:03', '2025-09-01 10:10:03'),
(114, 1, 'update', 'Product', 82, '<span class=\"text-muted fw-bold\">No changes</span> made to product: <strong>Base 07 Receiver</strong><br>Serial No: <code>4907762</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:11:23', '2025-09-01 10:11:23'),
(115, 1, 'update', 'Product', 82, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 07 Receiver</strong><br>Serial No: <code>4907762</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Position: \"-\" → \"অফিসের স্টোরে\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-01 16:09:51\" → \"2025-09-01 16:12:29\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:12:29', '2025-09-01 10:12:29'),
(116, 1, 'create', 'Product', 83, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 07 Controller</strong><br>Serial No: <code>4597682</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:15:59', '2025-09-01 10:15:59'),
(117, 1, 'update', 'Product', 83, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 07 Controller</strong><br>Serial No: <code>4597682</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2025-09-01 17:00:00\" → \"2025-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-09-01 17:00:00\" → \"2028-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-01 16:15:59\" → \"2025-09-01 16:16:28\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:16:28', '2025-09-01 10:16:28'),
(118, 1, 'update', 'Product', 83, '<span class=\"text-muted fw-bold\">No changes</span> made to product: <strong>Base 07 Controller</strong><br>Serial No: <code>4597682</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:28:58', '2025-09-01 10:28:58'),
(119, 1, 'create', 'Product', 84, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 07 Rover A Receiver</strong><br>Serial No: <code>4907742</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:32:23', '2025-09-01 10:32:23'),
(120, 1, 'create', 'Product', 85, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 07 Rover A Controller</strong><br>Serial No: <code>4597660</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:34:22', '2025-09-01 10:34:22'),
(121, 1, 'create', 'Product', 86, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 07 Rover B Receiver</strong><br>Serial No: <code>4907741</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:36:45', '2025-09-01 10:36:45'),
(122, 1, 'create', 'Product', 87, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 07 Rover A Controller</strong><br>Serial No: <code>4597780</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:38:31', '2025-09-01 10:38:31'),
(123, 1, 'create', 'Product', 88, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 08 Receiver</strong><br>Serial No: <code>4907751</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:40:53', '2025-09-01 10:40:53'),
(124, 1, 'create', 'Product', 89, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 07 Controller</strong><br>Serial No: <code>4597689</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:42:21', '2025-09-01 10:42:21'),
(125, 1, 'update', 'Product', 89, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 08 Controller</strong><br>Serial No: <code>4597689</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Product Name: \"Base 07 Controller\" → \"Base 08 Controller\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-01 16:42:21\" → \"2025-09-01 16:42:38\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:42:38', '2025-09-01 10:42:38'),
(126, 1, 'update', 'Product', 87, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 07 Rover B Controller</strong><br>Serial No: <code>4597780</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Product Name: \"Base 07 Rover A Controller\" → \"Base 07 Rover B Controller\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-01 16:38:31\" → \"2025-09-01 16:44:05\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:44:05', '2025-09-01 10:44:05'),
(127, 1, 'create', 'Product', 90, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 07 Rover A Receiver</strong><br>Serial No: <code>4907737</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:45:30', '2025-09-01 10:45:30'),
(128, 1, 'update', 'Product', 90, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 08 Rover A Receiver</strong><br>Serial No: <code>4907737</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Product Name: \"Base 07 Rover A Receiver\" → \"Base 08 Rover A Receiver\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-01 16:45:30\" → \"2025-09-01 16:45:37\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:45:37', '2025-09-01 10:45:37'),
(129, 1, 'create', 'Product', 91, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 08 Rover A Controller</strong><br>Serial No: <code>4597676</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:47:03', '2025-09-01 10:47:03'),
(130, 1, 'update', 'Product', 89, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 08 Controller</strong><br>Serial No: <code>4597689</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2028-05-07 00:00:00\" → \"2025-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-01 16:42:38\" → \"2025-09-01 16:48:49\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:48:49', '2025-09-01 10:48:49'),
(131, 1, 'create', 'Product', 92, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 08 Rover B Receiver</strong><br>Serial No: <code>4907735</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(132, 1, 'create', 'Product', 93, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 08 Rover B Controller</strong><br>Serial No: <code>4597695</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-01 10:52:07', '2025-09-01 10:52:07'),
(133, 1, 'create', 'Product', 94, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 08 Receiver</strong><br>Serial No: <code>4907740</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:19:21', '2025-09-02 03:19:21');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model`, `model_id`, `description`, `ip_address`, `user_agent`, `role`, `event`, `created_at`, `updated_at`) VALUES
(134, 1, 'update', 'Product', 94, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 09 Receiver</strong><br>Serial No: <code>4907740</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Product Name: \"Base 08 Receiver\" → \"Base 09 Receiver\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-02 09:19:21\" → \"2025-09-02 09:19:35\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:19:35', '2025-09-02 03:19:35'),
(135, 1, 'create', 'Product', 95, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 09 Controller</strong><br>Serial No: <code>4597678</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:20:31', '2025-09-02 03:20:31'),
(136, 1, 'create', 'Product', 96, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 09 Rover A Receiver</strong><br>Serial No: <code>4907768</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:21:57', '2025-09-02 03:21:57'),
(137, 1, 'create', 'Product', 97, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 08 Rover A Controller</strong><br>Serial No: <code>4597681</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:23:33', '2025-09-02 03:23:33'),
(138, 1, 'create', 'Product', 98, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 09 Rover B Receiver</strong><br>Serial No: <code>4907752</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:24:57', '2025-09-02 03:24:57'),
(139, 1, 'create', 'Product', 99, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 08 Rover B Controller</strong><br>Serial No: <code>4597679</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:25:53', '2025-09-02 03:25:53'),
(140, 1, 'update', 'Product', 99, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 09 Rover B Controller</strong><br>Serial No: <code>4597679</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Product Name: \"Base 08 Rover B Controller\" → \"Base 09 Rover B Controller\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-02 09:25:53\" → \"2025-09-02 09:26:01\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:26:01', '2025-09-02 03:26:01'),
(141, 1, 'update', 'Product', 97, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 09 Rover A Controller</strong><br>Serial No: <code>4597681</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Product Name: \"Base 08 Rover A Controller\" → \"Base 09 Rover A Controller\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-02 09:23:33\" → \"2025-09-02 09:26:14\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:26:14', '2025-09-02 03:26:14'),
(142, 1, 'create', 'Product', 100, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 10 Receiver</strong><br>Serial No: <code>4907758</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:29:33', '2025-09-02 03:29:33'),
(143, 1, 'create', 'Product', 101, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 10 Controller</strong><br>Serial No: <code>4595757</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:30:25', '2025-09-02 03:30:25'),
(144, 1, 'create', 'Product', 102, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 10 Rover A Receiver</strong><br>Serial No: <code>4907773</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:33:26', '2025-09-02 03:33:26'),
(145, 1, 'create', 'Product', 103, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 10 Rover A Controller</strong><br>Serial No: <code>4597657</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:35:26', '2025-09-02 03:35:26'),
(146, 1, 'update', 'Product', 103, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 10 Rover A Controller</strong><br>Serial No: <code>4597657</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-05-07 00:00:00\" → \"2028-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-02 09:35:26\" → \"2025-09-02 09:36:06\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:36:06', '2025-09-02 03:36:06'),
(147, 1, 'create', 'Product', 104, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 10 Rover B Receiver</strong><br>Serial No: <code>4907766</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:39:33', '2025-09-02 03:39:33'),
(148, 1, 'create', 'Product', 105, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 10 Rover B Controller</strong><br>Serial No: <code>4597692</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:40:45', '2025-09-02 03:40:45'),
(149, 1, 'create', 'Product', 106, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 11 Receiver</strong><br>Serial No: <code>4907753</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:42:32', '2025-09-02 03:42:32'),
(150, 1, 'create', 'Product', 107, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 11 Controller</strong><br>Serial No: <code>4597702</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:46:34', '2025-09-02 03:46:34'),
(151, 1, 'create', 'Product', 108, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 11 Rover A Receiver</strong><br>Serial No: <code>4907736</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:51:26', '2025-09-02 03:51:26'),
(152, 1, 'create', 'Product', 109, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 11 Rover A Controller</strong><br>Serial No: <code>4597684</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:53:30', '2025-09-02 03:53:30'),
(153, 1, 'create', 'Product', 110, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 11 Rover B Receiver</strong><br>Serial No: <code>4907767</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:54:35', '2025-09-02 03:54:35'),
(154, 1, 'create', 'Product', 111, '<span class=\"text-success fw-bold\">Created</span> product: <strong>Base 11 Rover B Controller</strong><br>Serial No: <code>4597677</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:55:34', '2025-09-02 03:55:34'),
(155, 1, 'update', 'Product', 77, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 06 Rover B Receiver</strong><br>Serial No: <code>4907757</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Price: \"0.00\" → \"2266666.67\"</span> <span class=\"badge bg-warning text-dark me-1\">User Description: \"-\" → \"অফিসের স্টোরে\"</span> <span class=\"badge bg-warning text-dark me-1\">Remarks: \"-\" → \"BCC lost Radio Antenna while testing\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2025-06-01 00:00:00\" → \"2025-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-09-30 00:00:00\" → \"2028-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-28 10:13:20\" → \"2025-09-02 09:58:19\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 03:58:19', '2025-09-02 03:58:19'),
(156, 1, 'update', 'Product', 77, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 06 Rover B Receiver</strong><br>Serial No: <code>4907757</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Remarks: \"BCC lost Radio Antenna while testing\" → \"অফিসের স্টোরে\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-02 09:58:19\" → \"2025-09-02 10:00:09\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 04:00:09', '2025-09-02 04:00:09'),
(157, 1, 'update', 'Product', 78, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 06 Rover B Controller</strong><br>Serial No: <code>4596693</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Price: \"2000.00\" → \"2266666.67\"</span> <span class=\"badge bg-warning text-dark me-1\">User Description: \"-\" → \"অফিসের স্টোরে\"</span> <span class=\"badge bg-warning text-dark me-1\">Remarks: \"-\" → \"অফিসের স্টোরে\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"2025-08-01 00:00:00\" → \"2025-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2025-08-31 00:00:00\" → \"2028-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-28 10:10:11\" → \"2025-09-02 10:01:29\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 04:01:29', '2025-09-02 04:01:29'),
(158, 1, 'update', 'Product', 55, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 03 Receiver</strong><br>Serial No: <code>4907770</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Price: \"0.00\" → \"2266666.67\"</span> <span class=\"badge bg-warning text-dark me-1\">User Description: \"-\" → \"অফিসের স্টোরে\"</span> <span class=\"badge bg-warning text-dark me-1\">Remarks: \"-\" → \"BCC lost Radio Antenna while testing\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2028-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-19 16:28:39\" → \"2025-09-02 10:02:19\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 04:02:19', '2025-09-02 04:02:19'),
(159, 1, 'update', 'Product', 55, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 03 Receiver</strong><br>Serial No: <code>4907770</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Remarks: \"BCC lost Radio Antenna while testing\" → \"BCC lost Radio Antenna while testing. Radio Antenna-GAT28\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-02 10:02:19\" → \"2025-09-02 10:03:36\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 04:03:36', '2025-09-02 04:03:36'),
(160, 1, 'update', 'Product', 56, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 03 Controller</strong><br>Serial No: <code>4595758</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Price: \"0.00\" → \"2266666.67\"</span> <span class=\"badge bg-warning text-dark me-1\">User Description: \"-\" → \"অফিসের স্টোরে\"</span> <span class=\"badge bg-warning text-dark me-1\">Remarks: \"-\" → \"BCC lost Radio Antenna while testing. Radio Antenna-GAT28\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2028-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-19 16:29:40\" → \"2025-09-02 10:04:31\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 04:04:31', '2025-09-02 04:04:31'),
(161, 1, 'update', 'Product', 28, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProBook 440 G11 Notebook PC</strong><br>Serial No: <code>5CD511733Y</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-09-02 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2025-09-09 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-13 03:16:39\" → \"2025-09-02 15:28:44\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 09:28:44', '2025-09-02 09:28:44'),
(162, 1, 'update', 'Product', 26, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProBook 440 G11 Notebook PC</strong><br>Serial No: <code>5CD5117331</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-09-02 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2025-10-02 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-13 03:15:39\" → \"2025-09-02 15:29:07\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 09:29:07', '2025-09-02 09:29:07'),
(163, 1, 'update', 'Product', 27, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>HP ProBook 440 G11 Notebook PC</strong><br>Serial No: <code>5CD511730G</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty Start: \"-\" → \"2025-09-02 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"-\" → \"2025-10-09 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-08-13 03:16:15\" → \"2025-09-02 15:29:26\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-02 09:29:26', '2025-09-02 09:29:26'),
(164, 1, 'create', 'Product', 112, '<span class=\"text-success fw-bold\">Created</span> product: <strong>HP ProBook 440 G11 Notebook PC</strong><br>Serial No: <code>DCGJCVG</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:04:44', '2025-09-03 03:04:44'),
(165, 1, 'delete', 'Product', 112, '<span class=\'text-danger fw-bold\'>Deleted</span> product: <strong>HP PROBOOK 440 G11 NOTEBOOK PC</strong><br>Serial No: <code>DCGJCVG</code><br>By: <em>Md Moklesar Rahman</em>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:04:48', '2025-09-03 03:04:48'),
(166, 1, 'create', 'Category', 7, '<span class=\"text-success fw-bold\">Created</span> category: <strong>sdfhbXZFb</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:16:25', '2025-09-03 03:16:25'),
(167, 1, 'delete', 'Category', 7, '<span class=\"text-danger fw-bold\">Archived</span> category: <strong>sdfhbXZFb</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:16:29', '2025-09-03 03:16:29'),
(168, 1, 'delete', 'Product', 111, '<span class=\'text-danger fw-bold\'>Deleted</span> product: <strong>BASE 11 ROVER B CONTROLLER</strong><br>Serial No: <code>4597677</code><br>By: <em>Md Moklesar Rahman</em>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:28:35', '2025-09-03 03:28:35'),
(169, 1, 'restore', 'Product', 111, '<span class=\'text-success fw-bold\'>Restored</span> product: <strong>BASE 11 ROVER B CONTROLLER</strong><br>Serial No: <code>4597677</code><br>By: <em>Md Moklesar Rahman</em>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:29:00', '2025-09-03 03:29:00'),
(170, 1, 'create', 'Brand', 7, '<span class=\"text-success fw-bold\">Created</span> brand: <strong>asedgSDjbg</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:42:45', '2025-09-03 03:42:45'),
(171, 1, 'delete', 'Brand', 7, '<span class=\"text-danger fw-bold\">Archived</span> brand: <strong>asedgSDjbg</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:42:50', '2025-09-03 03:42:50'),
(172, 1, 'create', 'Category', 8, '<span class=\"text-success fw-bold\">Created</span> category: <strong>awefasedg</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:55:07', '2025-09-03 03:55:07'),
(173, 1, 'delete', 'Category', 8, '<span class=\"text-danger fw-bold\">Archived</span> category: <strong>awefasedg</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:55:11', '2025-09-03 03:55:11'),
(174, 1, 'create', 'Brand', 8, '<span class=\"text-success fw-bold\">Created</span> brand: <strong>wGSDGsdag</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:55:17', '2025-09-03 03:55:17'),
(175, 1, 'delete', 'Brand', 8, '<span class=\"text-danger fw-bold\">Archived</span> brand: <strong>wGSDGsdag</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 03:55:20', '2025-09-03 03:55:20'),
(176, 1, 'create', 'Model', 9, '<span class=\"text-success fw-bold\">Created</span> model: <strong>ZDbvzcbv</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 04:04:31', '2025-09-03 04:04:31'),
(177, 1, 'delete', 'Model', 9, '<span class=\"text-danger fw-bold\">Archived</span> model: <strong>ZDbvzcbv</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 04:04:35', '2025-09-03 04:04:35'),
(178, 1, 'create', 'Maintenance', 1, '<span class=\"text-success fw-bold\">Created</span> maintenance for <strong>Serial No: 4597677</strong> — Issue found', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 04:07:05', '2025-09-03 04:07:05'),
(179, 1, 'delete', 'Maintenance', 1, '<span class=\"text-danger fw-bold\">Deleted</span> maintenance for <strong>Serial No: 4597677</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 04:07:16', '2025-09-03 04:07:16'),
(180, 1, 'create', 'Maintenance', 2, '<span class=\"text-success fw-bold\">Created</span> maintenance for <strong>Serial No: 4597677</strong> — Antenna', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 04:20:23', '2025-09-03 04:20:23'),
(181, 1, 'delete', 'Product', 111, '<span class=\'text-danger fw-bold\'>Deleted</span> product: <strong>BASE 11 ROVER B CONTROLLER</strong><br>Serial No: <code>4597677</code><br>By: <em>Md Moklesar Rahman</em>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 08:22:55', '2025-09-03 08:22:55'),
(182, 1, 'restore', 'Product', 111, '<span class=\'text-success fw-bold\'>Restored</span> product: <strong>BASE 11 ROVER B CONTROLLER</strong><br>Serial No: <code>4597677</code><br>By: <em>Md Moklesar Rahman</em>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 08:22:58', '2025-09-03 08:22:58'),
(183, 1, 'delete', 'Maintenance', 2, '<span class=\"text-danger fw-bold\">Archived</span> maintenance for <strong>Serial No: 4597677</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 08:26:46', '2025-09-03 08:26:46'),
(184, 1, 'restore', 'Maintenance', 2, '<span class=\"text-success fw-bold\">Restored</span> maintenance for <strong>Serial No: 4597677</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 08:31:46', '2025-09-03 08:31:46'),
(185, 1, 'delete', 'User', 7, '<span class=\"text-danger fw-bold\">Deleted</span> user: <strong>User</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 08:49:53', '2025-09-03 08:49:53'),
(186, 4, 'update', 'Product', 111, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 11 Rover B Controller</strong><br>Serial No: <code>4597677</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2028-05-07 00:00:00\" → \"2028-05-08 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-03 14:22:58\" → \"2025-09-03 15:23:44\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:23:44', '2025-09-03 09:23:44'),
(187, 4, 'update', 'Product', 111, '<span class=\"text-primary fw-bold\">Updated</span> product: <strong>Base 11 Rover B Controller</strong><br>Serial No: <code>4597677</code><br>Changes: <span class=\"badge bg-warning text-dark me-1\">Warranty End: \"2028-05-08 00:00:00\" → \"2028-05-07 00:00:00\"</span> <span class=\"badge bg-warning text-dark me-1\">Updated At: \"2025-09-03 15:23:44\" → \"2025-09-03 15:23:56\"</span>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:23:56', '2025-09-03 09:23:56'),
(188, 4, 'delete', 'Product', 111, '<span class=\'text-danger fw-bold\'>Deleted</span> product: <strong>BASE 11 ROVER B CONTROLLER</strong><br>Serial No: <code>4597677</code><br>By: <em>Admin (Test Admin)</em>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:24:07', '2025-09-03 09:24:07'),
(189, 4, 'restore', 'Product', 111, '<span class=\'text-success fw-bold\'>Restored</span> product: <strong>BASE 11 ROVER B CONTROLLER</strong><br>Serial No: <code>4597677</code><br>By: <em>Admin (Test Admin)</em>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:24:13', '2025-09-03 09:24:13'),
(190, 4, 'create', 'Category', 9, '<span class=\"text-success fw-bold\">Created</span> category: <strong>ZDBZB</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:25:01', '2025-09-03 09:25:01'),
(191, 4, 'update', 'Category', 9, '<span class=\"text-primary fw-bold\">Updated</span> category: <strong>ZDBZBSAvzdv</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:25:08', '2025-09-03 09:25:08'),
(192, 4, 'delete', 'Category', 9, '<span class=\"text-danger fw-bold\">Archived</span> category: <strong>ZDBZBSAvzdv</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:25:13', '2025-09-03 09:25:13'),
(193, 4, 'restore', 'Category', 9, '<span class=\"text-success fw-bold\">Restored</span> category: <strong>ZDBZBSAvzdv</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:25:17', '2025-09-03 09:25:17'),
(194, 4, 'create', 'Brand', 9, '<span class=\"text-success fw-bold\">Created</span> brand: <strong>zdfbzxfbz</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:25:34', '2025-09-03 09:25:34'),
(195, 4, 'update', 'Brand', 9, '<span class=\"text-primary fw-bold\">Updated</span> brand: <strong>zdfbzxfbzSZDbXFB</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:25:44', '2025-09-03 09:25:44'),
(196, 4, 'delete', 'Brand', 9, '<span class=\"text-danger fw-bold\">Archived</span> brand: <strong>zdfbzxfbzSZDbXFB</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:25:48', '2025-09-03 09:25:48'),
(197, 4, 'create', 'Model', 10, '<span class=\"text-success fw-bold\">Created</span> model: <strong>SBxbxcb</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:26:00', '2025-09-03 09:26:00'),
(198, 4, 'update', 'Model', 10, '<span class=\"text-primary fw-bold\">Updated</span> model: <strong>SBxbxcbzdxfbxzc</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:26:07', '2025-09-03 09:26:07'),
(199, 4, 'delete', 'Model', 10, '<span class=\"text-danger fw-bold\">Archived</span> model: <strong>SBxbxcbzdxfbxzc</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:26:12', '2025-09-03 09:26:12'),
(200, 4, 'delete', 'Product', 111, '<span class=\'text-danger fw-bold\'>Deleted</span> product: <strong>BASE 11 ROVER B CONTROLLER</strong><br>Serial No: <code>4597677</code><br>By: <em>Admin (Test Admin)</em>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:26:26', '2025-09-03 09:26:26'),
(201, 4, 'restore', 'Product', 111, '<span class=\'text-success fw-bold\'>Restored</span> product: <strong>BASE 11 ROVER B CONTROLLER</strong><br>Serial No: <code>4597677</code><br>By: <em>Admin (Test Admin)</em>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:26:30', '2025-09-03 09:26:30'),
(202, 4, 'update', 'Maintenance', 2, '<span class=\"text-primary fw-bold\">Updated</span> maintenance for <strong>Serial No: 4597677</strong> — Antenna Missing', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:27:10', '2025-09-03 09:27:10'),
(203, 4, 'delete', 'Maintenance', 2, '<span class=\"text-danger fw-bold\">Archived</span> maintenance for <strong>Serial No: 4597677</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:27:17', '2025-09-03 09:27:17'),
(204, 4, 'restore', 'Maintenance', 2, '<span class=\"text-success fw-bold\">Restored</span> maintenance for <strong>Serial No: 4597677</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-03 09:27:21', '2025-09-03 09:27:21'),
(205, 1, 'delete', 'User', 6, '<span class=\"text-danger fw-bold\">Deleted</span> user: <strong>User</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 03:45:37', '2025-09-04 03:45:37'),
(206, 1, 'update', 'User', 8, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>User</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:04:39', '2025-09-04 05:04:39'),
(207, 1, 'update', 'User', 8, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>User (Test User)</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:07:26', '2025-09-04 05:07:26'),
(208, 1, 'delete', 'Category', 9, '<span class=\"text-danger fw-bold\">Archived</span> category: <strong>ZDBZBSAvzdv</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:07:57', '2025-09-04 05:07:57'),
(209, 1, 'restore', 'Category', 9, '<span class=\"text-success fw-bold\">Restored</span> category: <strong>ZDBZBSAvzdv</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:08:03', '2025-09-04 05:08:03'),
(210, 1, 'update', 'Category', 9, '<span class=\"text-primary fw-bold\">Updated</span> category: <strong>test</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:08:10', '2025-09-04 05:08:10'),
(211, 1, 'restore', 'Brand', 9, '<span class=\"text-success fw-bold\">Restored</span> brand: <strong>zdfbzxfbzSZDbXFB</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:08:16', '2025-09-04 05:08:16'),
(212, 1, 'update', 'Brand', 9, '<span class=\"text-primary fw-bold\">Updated</span> brand: <strong>test</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:08:21', '2025-09-04 05:08:21'),
(213, 1, 'restore', 'Model', 10, '<span class=\"text-success fw-bold\">Restored</span> model: <strong>SBxbxcbzdxfbxzc</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:08:26', '2025-09-04 05:08:26'),
(214, 1, 'update', 'Model', 10, '<span class=\"text-primary fw-bold\">Updated</span> model: <strong>test</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:08:31', '2025-09-04 05:08:31'),
(215, 1, 'create', 'Product', 112, '<span class=\"text-success fw-bold\">Created</span> product: <strong>test test</strong><br>Serial No: <code>TEST</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:09:06', '2025-09-04 05:09:06'),
(216, 1, 'create', 'Maintenance', 3, '<span class=\"text-success fw-bold\">Created</span> maintenance for <strong>Serial No: TEST</strong> — Test', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:09:20', '2025-09-04 05:09:20'),
(217, 8, 'update', 'Maintenance', 3, '<span class=\"text-primary fw-bold\">Updated</span> maintenance for <strong>Serial No: TEST</strong> — Test', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:13:47', '2025-09-04 05:13:47'),
(218, 1, 'create', 'User', 9, '<span class=\"text-success fw-bold\">Created</span> user: <strong>User2</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:55:22', '2025-09-04 05:55:22'),
(219, 1, 'update', 'User', 1, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>Md Moklesar Rahman Bappy</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:56:46', '2025-09-04 05:56:46'),
(220, 1, 'update', 'User', 1, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>Md Moklesar Rahman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 05:56:58', '2025-09-04 05:56:58'),
(221, 1, 'update', 'User', 9, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>User2</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 06:29:40', '2025-09-04 06:29:40'),
(222, 1, 'update', 'User', 1, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>Md Moklesar Rahman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 06:48:02', '2025-09-04 06:48:02'),
(223, 1, 'update', 'User', 9, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>User2</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 07:10:23', '2025-09-04 07:10:23'),
(224, 1, 'update', 'User', 8, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>User (Test User)</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 07:10:51', '2025-09-04 07:10:51'),
(225, 1, 'update', 'User', 9, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>User2</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 07:11:52', '2025-09-04 07:11:52'),
(226, 1, 'update', 'User', 8, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>User (Test User)</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 07:11:56', '2025-09-04 07:11:56'),
(227, 1, 'update', 'User', 4, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>Admin (Test Admin)</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 07:12:00', '2025-09-04 07:12:00'),
(228, 1, 'update', 'User', 1, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>Md Moklesar Rahman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 07:12:05', '2025-09-04 07:12:05'),
(229, 1, 'delete', 'User', 9, '<span class=\"text-danger fw-bold\">Deleted</span> user: <strong>User2</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 07:25:57', '2025-09-04 07:25:57'),
(230, 1, 'update', 'User', 8, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>User (Test User)</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 07:59:28', '2025-09-04 07:59:28'),
(231, 1, 'update', 'User', 8, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>User (Test User)</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 08:09:42', '2025-09-04 08:09:42'),
(232, 1, 'update', 'User', 1, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>Md Moklesar Rahman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 08:47:02', '2025-09-04 08:47:02'),
(233, 1, 'create', 'User', 11, '<span class=\"text-success fw-bold\">Created</span> user: <strong>Md Moklesar Rahman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 09:49:50', '2025-09-04 09:49:50'),
(234, 11, 'update', 'User', 11, '<span class=\"text-primary fw-bold\">Updated</span> user: <strong>Md Moklesar Rahman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 09:50:37', '2025-09-04 09:50:37'),
(235, 1, 'create', 'User', 12, '<span class=\"text-success fw-bold\">Created</span> user: <strong>Arman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:08:09', '2025-09-04 10:08:09'),
(236, 1, 'delete', 'User', 12, '<span class=\"text-danger fw-bold\">Deleted</span> user: <strong>Arman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:14:43', '2025-09-04 10:14:43'),
(237, 1, 'restore', 'User', 12, '<span class=\"text-success fw-bold\">Restored</span> user: <strong>Arman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:24:00', '2025-09-04 10:24:00'),
(238, 1, 'delete', 'User', 12, '<span class=\"text-danger fw-bold\">Deleted</span> user: <strong>Arman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:24:07', '2025-09-04 10:24:07'),
(239, 1, 'restore', 'User', 12, '<span class=\"text-success fw-bold\">Restored</span> user: <strong>Arman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:30:33', '2025-09-04 10:30:33'),
(240, 1, 'delete', 'User', 12, '<span class=\"text-danger fw-bold\">Deleted</span> user: <strong>Arman</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:30:38', '2025-09-04 10:30:38'),
(241, 1, 'delete', 'User', 4, '<span class=\"text-danger fw-bold\">Deleted</span> user: <strong>Admin (Test Admin)</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:36:05', '2025-09-04 10:36:05'),
(242, 1, 'restore', 'User', 4, '<span class=\"text-success fw-bold\">Restored</span> user: <strong>Admin (Test Admin)</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:36:10', '2025-09-04 10:36:10'),
(243, 1, 'delete', 'Category', 9, '<span class=\"text-danger fw-bold\">Archived</span> category: <strong>test</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:44:31', '2025-09-04 10:44:31'),
(244, 1, 'create', 'Category', 10, '<span class=\"text-success fw-bold\">Created</span> category: <strong>abc</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:51:27', '2025-09-04 10:51:27'),
(245, 1, 'restore', 'Category', 9, '<span class=\"text-success fw-bold\">Restored</span> category: <strong>test</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:52:17', '2025-09-04 10:52:17'),
(246, 1, 'create', 'Product', 113, '<span class=\"text-success fw-bold\">Created</span> product: <strong>test test</strong><br>Serial No: <code>KASHGCJH</code>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:52:42', '2025-09-04 10:52:42'),
(247, 1, 'delete', 'Category', 9, '<span class=\"text-danger fw-bold\">Archived</span> category: <strong>test</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:52:54', '2025-09-04 10:52:54'),
(248, 1, 'force_delete', 'Category', 9, '<span class=\"text-danger fw-bold\">Permanently deleted</span> category: <strong>test</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:53:38', '2025-09-04 10:53:38'),
(249, 1, 'delete', 'Category', 10, '<span class=\"text-danger fw-bold\">Archived</span> category: <strong>abc</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:54:20', '2025-09-04 10:54:20'),
(250, 1, 'force_delete', 'Category', 10, '<span class=\"text-danger fw-bold\">Permanently deleted</span> category: <strong>abc</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:54:24', '2025-09-04 10:54:24'),
(251, 1, 'create', 'User', 13, '<span class=\"text-success fw-bold\">Created</span> user: <strong>Alamin</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:56:05', '2025-09-04 10:56:05'),
(252, 1, 'create', 'User', 14, '<span class=\"text-success fw-bold\">Created</span> user: <strong>Alamin</strong>', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'guest', NULL, '2025-09-04 10:57:18', '2025-09-04 10:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `asset_models`
--

CREATE TABLE `asset_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_models`
--

INSERT INTO `asset_models` (`id`, `model_name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'ProBook 440 G11 Notebook PC', NULL, '2025-08-10 04:49:57', '2025-08-10 04:49:57'),
(2, 'ProOne 440 G9 23.9 inch All-in-One Desktop', NULL, '2025-08-10 04:50:01', '2025-08-10 04:50:01'),
(3, 'Printon PMF 42A', NULL, '2025-08-12 21:23:16', '2025-08-12 22:27:19'),
(4, 'MFC-L6710DW', NULL, '2025-08-12 21:29:58', '2025-08-12 21:45:46'),
(5, 'Xerox B1025', NULL, '2025-08-12 21:50:20', '2025-08-19 09:47:28'),
(6, 'Xerox B315', NULL, '2025-08-12 22:12:13', '2025-08-19 09:47:23'),
(7, 'Leica GS18T', NULL, '2025-08-19 09:48:09', '2025-08-19 09:48:09'),
(8, 'Leica CS20 LTE', NULL, '2025-08-19 09:48:17', '2025-08-27 09:15:26'),
(10, 'test', NULL, '2025-09-03 09:26:00', '2025-09-04 05:08:31');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'HP', NULL, '2025-08-10 04:49:33', '2025-08-10 04:49:33'),
(2, 'Walton', NULL, '2025-08-10 04:49:37', '2025-08-10 04:49:37'),
(3, 'Leica', NULL, '2025-08-10 04:49:41', '2025-08-10 04:49:41'),
(4, 'Sokkia', NULL, '2025-08-10 04:49:45', '2025-08-10 04:49:45'),
(5, 'Brother Printer', NULL, '2025-08-12 21:29:36', '2025-08-12 21:29:36'),
(6, 'Xerox', NULL, '2025-08-12 21:50:02', '2025-08-27 09:13:58'),
(9, 'test', NULL, '2025-09-03 09:25:34', '2025-09-04 05:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('productinventory-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:2;', 1756961202),
('productinventory-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1756961202;', 1756961202);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Laptop', 'active', NULL, '2025-08-10 04:49:14', '2025-08-27 09:36:16'),
(2, 'Desktop', 'active', NULL, '2025-08-10 04:49:18', '2025-08-27 09:37:49'),
(4, 'Scanner', 'active', NULL, '2025-08-10 04:49:25', '2025-08-10 04:49:25'),
(5, 'Multi Function Laser Printer', 'active', NULL, '2025-08-12 21:24:03', '2025-08-12 21:24:03'),
(6, 'GPS/GNSS', 'active', NULL, '2025-08-19 09:46:35', '2025-08-19 09:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `performed_at` datetime DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_06_101039_create_categories_table', 1),
(5, '2025_08_07_050019_create_brands_table', 1),
(6, '2025_08_07_054522_create_asset_models_table', 1),
(7, '2025_08_13_051753_create_activity_logs_table', 1),
(8, '2025_08_20_162012_create_products_table', 1),
(9, '2025_08_20_163833_make_role_nullable_in_activity_logs', 1),
(10, '2025_08_24_120407_create_maintenances_table', 1),
(11, '2025_08_24_151744_create_activity_log_table', 1),
(12, '2025_08_24_151745_add_event_column_to_activity_log_table', 1),
(13, '2025_08_24_151746_add_batch_uuid_column_to_activity_log_table', 1),
(14, '2026_08_20_102540_add_metadata_fields_to_activity_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `serial_no` char(100) NOT NULL,
  `project_serial_no` char(100) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `user_description` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `warranty_start` datetime DEFAULT NULL,
  `warranty_end` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `category_id`, `brand_id`, `model_id`, `serial_no`, `project_serial_no`, `position`, `user_description`, `remarks`, `warranty_start`, `warranty_end`, `deleted_at`, `created_at`, `updated_at`) VALUES
(22, 'HP ProOne 440 G9 23.9 inch All-in-One Desktop', 0.00, 2, 1, 2, '8CN5110N6Q', 'DLRS/SOCDSP/DESKTOP/24-25/031', 'উপসচিব ভূমি ভবন', 'শফিক স্যার উপসচিব', 'সচিবালয়', '2025-08-27 00:00:00', '2026-05-30 00:00:00', NULL, '2025-08-12 21:12:39', '2025-08-27 09:29:24'),
(23, 'HP ProOne 440 G9 23.9 inch All-in-One Desktop', 0.00, 2, 1, 2, '8CN5110N5H', 'DLRS/SOCDSP/DESKTOP/24-25/076', 'অফিসে ব্যবহার হচ্ছে', 'মোঃ মোকলেসার রহমান\r\nঅ্যাসিস্ট্যান্ট মেইনটেনেন্স ইঙ্গিনিয়ার', NULL, '2025-08-23 00:00:00', '2026-02-26 00:00:00', NULL, '2025-08-12 21:13:28', '2025-08-27 04:49:22'),
(24, 'HP ProOne 440 G9 23.9 inch All-in-One Desktop', 0.00, 2, 1, 2, '8CN5110N7C', 'DLRS/SOCDSP/DESKTOP/24-25/153', 'অফিসে ব্যবহার হচ্ছে', 'মোঃ আল-আমিন\r\nঅ্যাসিস্ট্যান্ট মেইনটেনেন্স ইঙ্গিনিয়ার', NULL, '2025-08-24 00:00:00', '2026-01-27 00:00:00', NULL, '2025-08-12 21:14:18', '2025-08-27 04:49:29'),
(25, 'HP ProBook 440 G11 Notebook PC', 0.00, 1, 1, 1, '5CD51172ZC', 'DLRS/SOCDSP/LAPTOP/24-25/005', 'অফিসে ব্যবহার হচ্ছে', 'পিডি স্যারের ব্যবহারের জন্য', NULL, '2025-06-01 00:00:00', '2025-08-30 00:00:00', NULL, '2025-08-12 21:15:05', '2025-08-27 04:48:49'),
(26, 'HP ProBook 440 G11 Notebook PC', 0.00, 1, 1, 1, '5CD5117331', 'DLRS/SOCDSP/LAPTOP/24-25/043', 'অফিসে ব্যবহার হচ্ছে', 'ডিপিডি স্যারের ব্যবহারের এর জন্য', NULL, '2025-09-02 00:00:00', '2025-10-02 00:00:00', NULL, '2025-08-12 21:15:39', '2025-09-02 09:29:07'),
(27, 'HP ProBook 440 G11 Notebook PC', 0.00, 1, 1, 1, '5CD511730G', 'DLRS/SOCDSP/LAPTOP/24-25/072', 'অফিসে ব্যবহার হচ্ছে', 'সাইফুর রাসিদ (প্রকিউরমেন কনসালটেন্ট)', NULL, '2025-09-02 00:00:00', '2025-10-09 00:00:00', NULL, '2025-08-12 21:16:15', '2025-09-02 09:29:26'),
(28, 'HP ProBook 440 G11 Notebook PC', 0.00, 1, 1, 1, '5CD511733Y', 'DLRS/SOCDSP/LAPTOP/24-25/108', 'অফিসে ব্যবহার হচ্ছে', 'নাইমুল কবীর (অ্যাসিস্ট্যান্ট প্রোগ্রামার)', NULL, '2025-09-02 00:00:00', '2025-09-09 00:00:00', NULL, '2025-08-12 21:16:39', '2025-09-02 09:28:44'),
(29, 'Walton Multi Function Laser Printer PMF 42A', 0.00, 5, 2, 3, 'WPM42L31DTF062500090', 'DLRS/SOCDSP/M.F.PRINTER/24-25/086', 'উপসচিব ভূমি ভবন', 'শফিক স্যার উপসচিব', 'সচিবালয়', NULL, NULL, NULL, '2025-08-12 21:24:58', '2025-08-13 08:54:22'),
(30, 'Brother Printer MFC-L67100W', 0.00, 5, 5, 4, 'E82264-H3N149646', 'DLRS/SOCDSP/M.F.PRINTER/24-25/229', 'অফিসে ব্যবহার হচ্ছে', '1. Md Moklesar Rahman,\r\n2. Ganesh Chandra Ray\r\n3. Mohammad Mohsin Sarkar', 'Room No: 1218', NULL, NULL, NULL, '2025-08-12 21:36:08', '2025-08-12 21:36:08'),
(31, 'Brother Printer MFC-L6710DW', 0.00, 5, 5, 4, 'E82264-H3N149645', 'DLRS/SOCDSP/M.F.PRINTER/24-25/230', 'অফিসে ব্যবহার হচ্ছে', 'Used by Toha', 'Office', NULL, NULL, NULL, '2025-08-12 21:49:44', '2025-08-13 08:50:56'),
(32, 'Xerox B1025', 0.00, 5, 6, 5, '3430963804', 'SOCDS PROJECT FCM-1-22/23', 'অফিসে ব্যবহার হচ্ছে', 'Used by Sohag', NULL, NULL, NULL, NULL, '2025-08-12 21:51:00', '2025-08-12 21:51:00'),
(33, 'Xerox B315', 0.00, 5, 6, 6, '3027476669', 'SOCDS PROJECT P-5/22-23', 'অফিসে ব্যবহার হচ্ছে', 'Md Akhtar Hossain', 'Room No: 1206', NULL, NULL, NULL, '2025-08-12 22:17:33', '2025-08-12 22:17:33'),
(34, 'Brother Printer MFC-L6710DW', 0.00, 5, 5, 4, 'E82264-H3N149683', 'DLRS/SOCDSP/M.F.PRINTER/24-25/231', 'অফিসে ব্যবহার হচ্ছে', 'Md Abul Kalam Azad', 'Room No: 1208', NULL, NULL, NULL, '2025-08-12 22:20:42', '2025-08-12 22:20:42'),
(35, 'Brother Printer MFC-L6710DW', 0.00, 5, 5, 4, 'E82264-H3N149680', 'DLRS/SOCDSP/M.F.PRINTER/24-25/232', 'অফিসে ব্যবহার হচ্ছে', 'Md Saifur Rahman', 'Room No: 1209', NULL, NULL, NULL, '2025-08-12 22:21:25', '2025-08-12 22:21:25'),
(36, 'Walton Printon PMF 42A', 0.00, 5, 2, 3, 'WPM42L31DTF062500034', 'DLRS/SOCDSP/M.F.PRINTER/24-25/034', 'পিডি স্যারের ব্যবহারের জন্য', 'পিডি স্যার', 'পিডি স্যার', NULL, NULL, NULL, '2025-08-12 23:26:34', '2025-08-12 23:26:34'),
(37, 'Walton Printon PMF 42A', 0.00, 5, 2, 3, 'WPM42L31DTF062500011', 'DLRS/SOCDSP/M.F.PRINTER/24-25/011', 'অফিসে ব্যবহার হচ্ছে', 'মোঃ সোহাগ (কম্পিউটার অপারেটর)', NULL, NULL, NULL, NULL, '2025-08-13 01:31:35', '2025-08-13 01:31:35'),
(38, 'Walton Printon PMF 42A', 0.00, 5, 2, 3, 'WPM42L31DTF062500045', 'DLRS/SOCDSP/M.F.PRINTER/24-25/045', 'ডিপিডি স্যারের ব্যবহারের জন্য', 'ডিপিডি স্যার', NULL, NULL, NULL, NULL, '2025-08-13 01:32:53', '2025-08-13 01:32:53'),
(39, 'Walton Printon PMF 42A', 0.00, 5, 2, 3, 'WPM42L31DTF062500030', 'DLRS/SOCDSP/M.F.PRINTER/24-25/030', 'অফিসে ব্যবহার হচ্ছে', 'নাইমুল কবীর (অ্যাসিস্ট্যান্ট প্রোগ্রামার)', NULL, NULL, NULL, NULL, '2025-08-13 01:33:38', '2025-08-13 01:33:38'),
(40, 'Walton Printon PMF 42A', 0.00, 5, 2, 3, 'WPM42L31DTF062500036', 'DLRS/SOCDSP/M.F.PRINTER/24-25/036', 'অফিসে ব্যবহার হচ্ছে', 'মোহাম্মদ রুকুনুজ্জামান\r\n(কম্পিউটার অপারেটর)', NULL, NULL, NULL, NULL, '2025-08-13 01:35:13', '2025-08-13 01:35:13'),
(41, 'Walton Printon PMF 42A', 0.00, 5, 2, 3, 'WPM42L31DTF062500207', 'DLRS/SOCDSP/M.F.PRINTER/24-25/196', 'এপিডি স্যারের ব্যবহারের জন্য', 'এপিডি স্যার', NULL, NULL, NULL, NULL, '2025-08-13 01:36:08', '2025-08-13 01:36:08'),
(43, 'Base 01 Receiver', 0.00, 6, 3, 7, '4907761', 'DLRS/SOCDS-P/GNSS/24-25/01', 'অফিসের স্টোরে', NULL, 'Each Base has 2 Rover', NULL, NULL, NULL, '2025-08-19 09:50:19', '2025-08-19 09:50:19'),
(44, 'Base 01 Controller', 0.00, 6, 3, 8, '4597703', 'DLRS/SOCDS-P/GNSS/24-25/02', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 09:52:07', '2025-08-19 09:52:07'),
(45, 'Base 01 Rover A Receiver', 0.00, 6, 3, 7, '4907738', 'DLRS/SOCDS-P/GNSS/24-25/03', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 09:54:46', '2025-08-19 09:54:46'),
(46, 'Base 01 Rover A Controller', 0.00, 6, 3, 8, '4597687', 'DLRS/SOCDS-P/GNSS/24-25/04', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 09:55:44', '2025-08-19 09:55:44'),
(47, 'Base 01 Rover B Receiver', 0.00, 6, 3, 7, '4907744', 'DLRS/SOCDS-P/GNSS/24-25/05', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 09:56:56', '2025-08-19 09:56:56'),
(48, 'Base 01 Rover B Controller', 0.00, 6, 3, 8, '4597701', 'DLRS/SOCDS-P/GNSS/24-25/06', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 09:57:36', '2025-08-19 09:57:36'),
(49, 'Base 02 Receiver', 0.00, 6, 3, 7, '4907763', 'DLRS/SOCDS-P/GNSS/24-25/07', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 09:59:22', '2025-08-19 09:59:22'),
(50, 'Base 02 Controller', 0.00, 6, 3, 8, '4597691', 'DLRS/SOCDS-P/GNSS/24-25/08', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 09:59:52', '2025-08-19 09:59:52'),
(51, 'Base 02 Rover A Receiver', 0.00, 6, 3, 7, '4907771', 'DLRS/SOCDS-P/GNSS/24-25/09', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:22:58', '2025-08-19 10:22:58'),
(52, 'Base 02 Rover A Controller', 0.00, 6, 3, 8, '4597661', 'DLRS/SOCDS-P/GNSS/24-25/10', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:23:37', '2025-08-19 10:24:12'),
(53, 'Base 02 Rover B Receiver', 0.00, 6, 3, 7, '4907772', 'DLRS/SOCDS-P/GNSS/24-25/11', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:25:29', '2025-08-19 10:25:29'),
(54, 'Base 02 Rover B Controller', 0.00, 6, 3, 8, '4597685', 'DLRS/SOCDS-P/GNSS/24-25/12', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:26:09', '2025-08-19 10:26:09'),
(55, 'Base 03 Receiver', 2266666.67, 6, 3, 7, '4907770', 'DLRS/SOCDS-P/GNSS/24-25/13', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'BCC lost Radio Antenna while testing. Radio Antenna-GAT28', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-08-19 10:28:39', '2025-09-02 04:03:36'),
(56, 'Base 03 Controller', 2266666.67, 6, 3, 8, '4595758', 'DLRS/SOCDS-P/GNSS/24-25/14', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'BCC lost Radio Antenna while testing. Radio Antenna-GAT28', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-08-19 10:29:40', '2025-09-02 04:04:31'),
(57, 'Base 03 Rover A Receiver', 0.00, 6, 3, 7, '4907755', 'DLRS/SOCDS-P/GNSS/24-25/15', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:30:50', '2025-08-19 10:30:50'),
(58, 'Base 03 Rover A Controller', 0.00, 6, 3, 8, '4597688', 'DLRS/SOCDS-P/GNSS/24-25/16', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:31:52', '2025-08-19 10:31:52'),
(59, 'Base 03 Rover B Receiver', 0.00, 6, 3, 7, '4907743', 'DLRS/SOCDS-P/GNSS/24-25/17', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:32:29', '2025-08-19 10:32:29'),
(60, 'Base 03 Rover B Controller', 0.00, 6, 3, 8, '4597704', 'DLRS/SOCDS-P/GNSS/24-25/18', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:33:01', '2025-08-19 10:33:01'),
(61, 'Base 04 Receiver', 0.00, 6, 3, 7, '4907764', 'DLRS/SOCDS-P/GNSS/24-25/19', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:35:26', '2025-08-19 10:35:26'),
(62, 'Base 04 Controller', 0.00, 6, 3, 8, '4597658', 'DLRS/SOCDS-P/GNSS/24-25/20', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:36:01', '2025-08-19 10:36:01'),
(63, 'Base 04 Rover A Receiver', 0.00, 6, 3, 7, '4907765', 'DLRS/SOCDS-P/GNSS/24-25/21', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:36:40', '2025-08-19 10:36:40'),
(64, 'Base 04 Rover A Controller', 0.00, 6, 3, 8, '4597683', 'DLRS/SOCDS-P/GNSS/24-25/22', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:37:28', '2025-08-19 10:37:28'),
(65, 'Base 04 Rover B Receiver', 0.00, 6, 3, 7, '4907774', 'DLRS/SOCDS-P/GNSS/24-25/23', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:38:16', '2025-08-19 10:38:16'),
(66, 'Base 04 Rover B Controller', 0.00, 6, 3, 8, '4597693', 'DLRS/SOCDS-P/GNSS/24-25/24', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:38:54', '2025-08-19 10:38:54'),
(67, 'Base 05 Receiver', 0.00, 6, 3, 7, '4907739', 'DLRS/SOCDS-P/GNSS/24-25/25', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:40:11', '2025-08-19 10:40:11'),
(68, 'Base 05 Controller', 0.00, 6, 3, 8, '4597705', 'DLRS/SOCDS-P/GNSS/24-25/26', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:40:48', '2025-08-19 10:40:48'),
(69, 'Base 05 Rover A Receiver', 0.00, 6, 3, 7, '4907747', 'DLRS/SOCDS-P/GNSS/24-25/27', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:41:28', '2025-08-19 10:41:28'),
(70, 'Base 05 Rover A Controller', 0.00, 6, 3, 8, '4597686', 'DLRS/SOCDS-P/GNSS/24-25/28', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:41:55', '2025-08-19 10:41:55'),
(71, 'Base 05 Rover B Receiver', 0.00, 6, 3, 7, '4907760', 'DLRS/SOCDS-P/GNSS/24-25/29', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:42:30', '2025-08-19 10:42:30'),
(72, 'Base 05 Rover B Controller', 0.00, 6, 3, 8, '4597694', 'DLRS/SOCDS-P/GNSS/24-25/30', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:43:07', '2025-08-19 10:43:07'),
(73, 'Base 06 Receiver', 0.00, 6, 3, 7, '4907754', 'DLRS/SOCDS-P/GNSS/24-25/31', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:43:40', '2025-08-19 10:43:40'),
(74, 'Base 06 Controller', 0.00, 6, 3, 8, '4597690', 'DLRS/SOCDS-P/GNSS/24-25/32', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:44:01', '2025-08-19 10:44:01'),
(75, 'Base 06 Rover A Receiver', 0.00, 6, 3, 7, '4907769', 'DLRS/SOCDS-P/GNSS/24-25/33', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:44:32', '2025-08-19 10:44:32'),
(76, 'Base 06 Rover A Controller', 0.00, 6, 3, 8, '4597659', 'DLRS/SOCDS-P/GNSS/24-25/34', 'অফিসের স্টোরে', NULL, NULL, NULL, NULL, NULL, '2025-08-19 10:45:14', '2025-08-19 10:45:14'),
(77, 'Base 06 Rover B Receiver', 2266666.67, 6, 3, 7, '4907757', 'DLRS/SOCDS-P/GNSS/24-25/35', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-08-19 10:46:03', '2025-09-02 04:00:09'),
(78, 'Base 06 Rover B Controller', 2266666.67, 6, 3, 8, '4596693', 'DLRS/SOCDS-P/GNSS/24-25/36', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-08-19 10:47:22', '2025-09-02 04:01:29'),
(79, 'HP Printon PMF 42A', 1000.00, 4, 1, 3, '5CD51172ZR5', 'DLRS/SOCDS-P/GNSS/24-25/100', 'অফিসের স্টোরে', NULL, 'Office Use', '2025-07-01 00:00:00', '2025-12-30 00:00:00', NULL, '2025-08-27 04:51:38', '2025-08-28 04:09:48'),
(81, 'HP ProOne 440 G9 23.9 inch All-in-One Desktop', 120000.95, 2, 1, 2, '8CN5110N4B', 'DLRS/SOCDSP/DESKTOP/24-25/064', 'অফিসে ব্যবহার হচ্ছে', 'মোহাম্মাদ মহসিন সরকার\r\nজি আই এস স্পেশালিষ্ট', 'Room 1218', '2025-06-01 00:00:00', '2028-06-30 00:00:00', NULL, '2025-08-28 05:47:27', '2025-08-28 05:53:04'),
(82, 'Base 07 Receiver', 2266666.67, 6, 3, 7, '4907762', 'DLRS/SOCDS-P/GNSS/24-25/37', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:09:24', '2025-09-01 10:12:29'),
(83, 'Base 07 Controller', 2266666.67, 6, 3, 8, '4597682', 'DLRS/SOCDS-P/GNSS/24-25/38', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:15:59', '2025-09-01 10:16:28'),
(84, 'Base 07 Rover A Receiver', 2266666.67, 6, 3, 7, '4907742', 'DLRS/SOCDS-P/GNSS/24-25/39', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:32:23', '2025-09-01 10:32:23'),
(85, 'Base 07 Rover A Controller', 2266666.67, 6, 3, 8, '4597660', 'DLRS/SOCDS-P/GNSS/24-25/40', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:34:22', '2025-09-01 10:34:22'),
(86, 'Base 07 Rover B Receiver', 2266666.67, 6, 3, 7, '4907741', 'DLRS/SOCDS-P/GNSS/24-25/41', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:36:45', '2025-09-01 10:36:45'),
(87, 'Base 07 Rover B Controller', 2266666.67, 6, 3, 8, '4597780', 'DLRS/SOCDS-P/GNSS/24-25/42', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:38:31', '2025-09-01 10:44:05'),
(88, 'Base 08 Receiver', 2266666.67, 6, 3, 7, '4907751', 'DLRS/SOCDS-P/GNSS/24-25/43', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:40:53', '2025-09-01 10:40:53'),
(89, 'Base 08 Controller', 2266666.67, 6, 3, 8, '4597689', 'DLRS/SOCDS-P/GNSS/24-25/44', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:42:21', '2025-09-01 10:48:49'),
(90, 'Base 08 Rover A Receiver', 2266666.67, 6, 3, 7, '4907737', 'DLRS/SOCDS-P/GNSS/24-25/45', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:45:30', '2025-09-01 10:45:37'),
(91, 'Base 08 Rover A Controller', 2266666.67, 6, 3, 8, '4597676', 'DLRS/SOCDS-P/GNSS/24-25/46', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:47:03', '2025-09-01 10:47:03'),
(92, 'Base 08 Rover B Receiver', 2266666.67, 6, 3, 7, '4907735', 'DLRS/SOCDS-P/GNSS/24-25/47', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:50:54', '2025-09-01 10:50:54'),
(93, 'Base 08 Rover B Controller', 2266666.67, 6, 3, 8, '4597695', 'DLRS/SOCDS-P/GNSS/24-25/48', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-01 10:52:07', '2025-09-01 10:52:07'),
(94, 'Base 09 Receiver', 2266666.67, 6, 3, 7, '4907740', 'DLRS/SOCDS-P/GNSS/24-25/49', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:19:21', '2025-09-02 03:19:35'),
(95, 'Base 09 Controller', 2266666.67, 6, 3, 8, '4597678', 'DLRS/SOCDS-P/GNSS/24-25/50', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:20:31', '2025-09-02 03:20:31'),
(96, 'Base 09 Rover A Receiver', 2266666.67, 6, 3, 7, '4907768', 'DLRS/SOCDS-P/GNSS/24-25/51', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:21:57', '2025-09-02 03:21:57'),
(97, 'Base 09 Rover A Controller', 2266666.67, 6, 3, 8, '4597681', 'DLRS/SOCDS-P/GNSS/24-25/52', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:23:33', '2025-09-02 03:26:14'),
(98, 'Base 09 Rover B Receiver', 2266666.67, 6, 3, 7, '4907752', 'DLRS/SOCDS-P/GNSS/24-25/53', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:24:57', '2025-09-02 03:24:57'),
(99, 'Base 09 Rover B Controller', 2266666.67, 6, 3, 8, '4597679', 'DLRS/SOCDS-P/GNSS/24-25/54', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:25:53', '2025-09-02 03:26:01'),
(100, 'Base 10 Receiver', 2266666.67, 6, 3, 7, '4907758', 'DLRS/SOCDS-P/GNSS/24-25/55', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:29:33', '2025-09-02 03:29:33'),
(101, 'Base 10 Controller', 2266666.67, 6, 3, 8, '4595757', 'DLRS/SOCDS-P/GNSS/24-25/56', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:30:25', '2025-09-02 03:30:25'),
(102, 'Base 10 Rover A Receiver', 2266666.67, 6, 3, 7, '4907773', 'DLRS/SOCDS-P/GNSS/24-25/57', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:33:26', '2025-09-02 03:33:26'),
(103, 'Base 10 Rover A Controller', 2266666.67, 6, 3, 8, '4597657', 'DLRS/SOCDS-P/GNSS/24-25/58', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:35:26', '2025-09-02 03:36:06'),
(104, 'Base 10 Rover B Receiver', 2266666.67, 6, 3, 7, '4907766', 'DLRS/SOCDS-P/GNSS/24-25/59', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:39:33', '2025-09-02 03:39:33'),
(105, 'Base 10 Rover B Controller', 2266666.67, 6, 3, 8, '4597692', 'DLRS/SOCDS-P/GNSS/24-25/60', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:40:45', '2025-09-02 03:40:45'),
(106, 'Base 11 Receiver', 2266666.67, 6, 3, 7, '4907753', 'DLRS/SOCDS-P/GNSS/24-25/61', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:42:32', '2025-09-02 03:42:32'),
(107, 'Base 11 Controller', 2266666.67, 6, 3, 8, '4597702', 'DLRS/SOCDS-P/GNSS/24-25/62', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:46:34', '2025-09-02 03:46:34'),
(108, 'Base 11 Rover A Receiver', 2266666.67, 6, 3, 7, '4907736', 'DLRS/SOCDS-P/GNSS/24-25/63', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:51:26', '2025-09-02 03:51:26'),
(109, 'Base 11 Rover A Controller', 2266666.67, 6, 3, 8, '4597684', 'DLRS/SOCDS-P/GNSS/24-25/64', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:53:30', '2025-09-02 03:53:30'),
(110, 'Base 11 Rover B Receiver', 2266666.67, 6, 3, 7, '4907767', 'DLRS/SOCDS-P/GNSS/24-25/65', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:54:35', '2025-09-02 03:54:35'),
(111, 'Base 11 Rover B Controller', 2266666.67, 6, 3, 8, '4597677', 'DLRS/SOCDS-P/GNSS/24-25/66', 'অফিসের স্টোরে', 'অফিসের স্টোরে', 'অফিসের স্টোরে', '2025-05-07 00:00:00', '2028-05-07 00:00:00', NULL, '2025-09-02 03:55:34', '2025-09-03 09:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('FKlfAjQxHl3hWwKZL2aQPNWpcONvZy8ogp4jnOIx', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTkliMXZkTzFhUUVESlp6OU5CaUxCQ0luUzNIR3RHclFDSVNnbHlONCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FjdGl2aXR5LWxvZ3MiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3VzZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1757225578),
('k8B3aVQo7HjLSP0w7TmWBwdsY4Fg1u4tYUYvx51V', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiclFLOHQyWkRlT1ZJRGxNb29CT3ozMGJ2SGt0bnkwTkhBbW9jNUZObCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDt9', 1756983902),
('z84r8J6X8UMfZMp7QUgvosqUqz5dreBm7spVSv9Q', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUVVhRVR4VFJsMTFvQnBXS1loS3pFV0Nick5LQUp6N2s4Y0EwakR5aSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1757327234);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL COMMENT 'Country calling code like 880 for BD',
  `about` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `utype` varchar(255) NOT NULL DEFAULT 'USR' COMMENT 'USR for user, ADM for admin',
  `status` enum('active','deactive') NOT NULL DEFAULT 'active' COMMENT 'User account status',
  `initial_password` varchar(255) DEFAULT NULL COMMENT 'Encrypted password to send after verification',
  `credentials_sent_at` timestamp NULL DEFAULT NULL COMMENT 'Timestamp when credentials were emailed',
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `permission`, `designation`, `mobile`, `country_code`, `about`, `address`, `email_verified_at`, `password`, `utype`, `status`, `initial_password`, `credentials_sent_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Md Moklesar Rahman', 'superadmin@gmail.com', 0, 'Assistant Maintenance Engineer', '1965031371', NULL, 'Maintenance Engineer at DLRS-SOCDS Project', '98 Shaheed Tajuddin Ahmad Sharani Tejgaon, Dhaka-1208', '2025-09-04 09:50:49', '$2y$12$XVPbgK1jEeob1ESHs3eUZ.Ar/VS2G/tYMib7yL1czjT35nUvhVJm6', 'USR', 'active', NULL, NULL, NULL, NULL, 'uploads/users/r5voqk9mM5MeOIRPqHiPbGf0lS5d8drU5Zowcuav.jpg', NULL, '2025-08-28 04:07:38', '2025-09-04 08:47:02'),
(4, 'Admin (Test Admin)', 'admin@gmail.com', 1, 'Admin', '123456789', NULL, 'Admin', 'Admin', '2025-09-04 09:50:49', '$2y$12$OMoZrAmWCsxRt0GopUkLXu7xkVexuItiBtbADeNo6gGNmy5xSkNRu', 'USR', 'active', NULL, NULL, NULL, NULL, 'uploads/users/iyKbtAaEng16gag2PChdPTIlrMu4xCIlAG5EMfNN.png', NULL, '2025-08-28 04:47:57', '2025-09-04 10:36:10'),
(8, 'User (Test User)', 'user@gmail.com', 2, 'User', '123456789', NULL, 'user', 'user', '2025-09-04 09:50:49', '$2y$12$3gPzLm1EMhY2.8ZDI2whg.Q5wiaFnb3tFsx8D0CaIETGNG0dQgZdO', 'USR', 'active', NULL, NULL, NULL, NULL, 'uploads/users/UzTr6mUti16ygkboyBjPAfzA7BZa7CfsqDPaq8XG.png', NULL, '2025-09-04 04:22:29', '2025-09-04 07:59:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_models`
--
ALTER TABLE `asset_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_brand_name_unique` (`brand_name`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_category_name_unique` (`category_name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenances_product_id_foreign` (`product_id`),
  ADD KEY `maintenances_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_serial_no_unique` (`serial_no`),
  ADD UNIQUE KEY `products_project_serial_no_unique` (`project_serial_no`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_model_id_foreign` (`model_id`),
  ADD KEY `products_warranty_end_index` (`warranty_end`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `asset_models`
--
ALTER TABLE `asset_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_model_id_foreign` FOREIGN KEY (`model_id`) REFERENCES `asset_models` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
