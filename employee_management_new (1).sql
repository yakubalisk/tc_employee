-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 06, 2025 at 06:00 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_management_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `apar_gradings`
--

DROP TABLE IF EXISTS `apar_gradings`;
CREATE TABLE IF NOT EXISTS `apar_gradings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` bigint UNSIGNED NOT NULL,
  `from_month` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_year` int NOT NULL,
  `to_month` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_year` int NOT NULL,
  `grading_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discrepancy_remarks` text COLLATE utf8mb4_unicode_ci,
  `reporting_marks` decimal(3,1) DEFAULT NULL,
  `reviewing_marks` decimal(3,1) DEFAULT NULL,
  `reporting_grade` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviewing_grade` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consideration` tinyint(1) NOT NULL DEFAULT '0',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apar_gradings_employee_id_from_year_to_year_index` (`employee_id`,`from_year`,`to_year`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `apar_gradings`
--

INSERT INTO `apar_gradings` (`id`, `employee_id`, `from_month`, `from_year`, `to_month`, `to_year`, `grading_type`, `discrepancy_remarks`, `reporting_marks`, `reviewing_marks`, `reporting_grade`, `reviewing_grade`, `consideration`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 'January', 2025, 'January', 2026, 'APAR', 'none', 5.5, 5.5, 'A', 'A', 1, 'Yes', '2025-10-05 08:23:34', '2025-10-05 08:23:34'),
(2, 2, 'February', 2023, 'September', 2026, 'Performance Review', 'remark', 6.5, 7.1, 'A+', 'A+', 1, 'None', '2025-10-05 08:26:26', '2025-10-05 08:26:26'),
(5, 4, 'March', 2017, 'March', 2018, 'APAR', NULL, 9.4, 9.4, 'A', 'A+', 0, NULL, '2025-10-05 10:33:07', '2025-10-05 10:33:07'),
(4, 4, 'April', 2016, 'March', 2017, 'APAR', 'none', 8.4, 8.4, 'A', 'A+', 0, 'No', '2025-10-05 10:27:22', '2025-10-05 10:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `empCode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('MALE','FEMALE','OTHER') COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('General','OBC','SC','ST') COLLATE utf8mb4_unicode_ci NOT NULL,
  `education` text COLLATE utf8mb4_unicode_ci,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateOfAppointment` date NOT NULL,
  `designationAtAppointment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designationAtPresent` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presentPosting` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personalFileNo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `officeLandline` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateOfBirth` date NOT NULL,
  `dateOfRetirement` date NOT NULL,
  `homeTown` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residentialAddress` text COLLATE utf8mb4_unicode_ci,
  `status` enum('EXISTING','RETIRED','TRANSFERRED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EXISTING',
  `current_designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_posting` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_transfer_date` date DEFAULT NULL,
  `current_transfer_id` bigint UNSIGNED DEFAULT NULL,
  `last_promotion_date` date DEFAULT NULL,
  `current_promotion_id` bigint UNSIGNED DEFAULT NULL,
  `promoted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_in_charge` tinyint(1) NOT NULL DEFAULT '0',
  `promotee_transferee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pension_file_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nps` tinyint(1) NOT NULL DEFAULT '0',
  `increment_month` int DEFAULT NULL,
  `probation_period` tinyint(1) NOT NULL DEFAULT '0',
  `status_of_post` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` tinyint(1) NOT NULL DEFAULT '0',
  `seniority_sequence_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sddlsection_incharge` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `2021_2022` tinyint(1) NOT NULL DEFAULT '0',
  `benevolent_member` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `2022_2023` tinyint(1) NOT NULL DEFAULT '0',
  `increment_individual_selc` tinyint(1) NOT NULL DEFAULT '0',
  `office_landline_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `increment_withheld` tinyint(1) NOT NULL DEFAULT '0',
  `FR56J_2nd_batch` tinyint(1) NOT NULL DEFAULT '0',
  `apar_hod` tinyint(1) NOT NULL DEFAULT '0',
  `2023_2024` tinyint(1) NOT NULL DEFAULT '0',
  `2024_2025` tinyint(1) NOT NULL DEFAULT '0',
  `karmayogi_certificate_completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_empcode_unique` (`empCode`),
  UNIQUE KEY `employees_empid_unique` (`empId`),
  UNIQUE KEY `employees_email_unique` (`email`),
  KEY `employees_current_promotion_id_foreign` (`current_promotion_id`),
  KEY `employees_current_transfer_id_foreign` (`current_transfer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `empCode`, `empId`, `name`, `gender`, `category`, `education`, `mobile`, `email`, `dateOfAppointment`, `designationAtAppointment`, `designationAtPresent`, `presentPosting`, `personalFileNo`, `officeLandline`, `dateOfBirth`, `dateOfRetirement`, `homeTown`, `residentialAddress`, `status`, `current_designation`, `current_posting`, `last_transfer_date`, `current_transfer_id`, `last_promotion_date`, `current_promotion_id`, `promoted`, `created_at`, `updated_at`, `profile_image`, `office_in_charge`, `promotee_transferee`, `pension_file_no`, `nps`, `increment_month`, `probation_period`, `status_of_post`, `department`, `seniority_sequence_no`, `sddlsection_incharge`, `2021_2022`, `benevolent_member`, `2022_2023`, `increment_individual_selc`, `office_landline_number`, `increment_withheld`, `FR56J_2nd_batch`, `apar_hod`, `2023_2024`, `2024_2025`, `karmayogi_certificate_completed`) VALUES
(1, '1234', '123', 'Yakub Ali Shaikh', 'MALE', 'General', 'B.E', '7738345422', 'test@mailinator.com', '2025-09-27', 'LAB', 'LAB', 'MUMBAI', '106', '000999998888', '2024-09-03', '2025-09-19', 'MUMBAI', 'MUMBAI', 'EXISTING', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-21 07:38:42', '2025-09-21 07:38:42', NULL, 0, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, 0, 0, NULL, 0, 0, 0, 0, 0, 0),
(2, '555', '112', 'Admin', 'MALE', 'ST', 'B.E', '7738345422', 'yakub1@gmail.com', '2025-09-27', 'LAB', 'LAB', 'MUMBAI', '106', '000999998888', '1995-09-27', '2025-09-29', 'MUMBAI', 'jhakjd', 'EXISTING', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-28 07:43:06', '2025-09-28 07:43:06', NULL, 1, 'jh', '667', 1, 5, 1, 'na', 1, 'yas', 'hfk', 1, 'yes', 1, 1, 'yes', 1, 1, 1, 1, 1, 1),
(3, '4231', '432', 'Full Permission 1', 'FEMALE', 'SC', 'B.E', '7738345422', 'yakub3@gmail.com', '2025-09-01', 'EPQA', 'Tester', 'MUMBAI', '55', '520', '1976-09-01', '2025-10-12', 'MUMBAI', '32', 'EXISTING', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-28 08:24:04', '2025-09-28 08:24:04', 'profile-images/FvE0TV4Xe1uBxDhX7jmkU2uteUByAf1hiTj8jbbW.png', 0, NULL, NULL, 0, 5, 0, 'na', 0, 'yas', NULL, 0, NULL, 0, 0, 'yes', 0, 0, 0, 0, 0, 0),
(4, '786', '786', 'Yakub Ali Mohd Hanif Shaikh', 'MALE', 'General', 'B.E', '7738345422', 'yakubalishaikh101@gmail.com', '2024-07-01', 'RSA', 'Technical Officer', 'MUMBAI', '1', '544', '1996-06-28', '2040-06-30', 'Telangana', '506, Mhada Building no 18,mhada colony, bolinj, Virar - W', 'EXISTING', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-28 10:17:19', '2025-09-28 10:17:19', 'profile-images/Tq0ZFEg7uRjw06BTjMVqIRutnydUSDWWTAvjgLn4.jpg', 0, 'Yes', '667', 0, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, 0, 0, NULL, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_upgradations`
--

DROP TABLE IF EXISTS `financial_upgradations`;
CREATE TABLE IF NOT EXISTS `financial_upgradations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sr_no` int NOT NULL,
  `empl_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promotion_date` date NOT NULL,
  `existing_designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upgraded_designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_in_grade` date NOT NULL,
  `existing_scale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upgraded_scale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_fixed` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `existing_pay` decimal(10,2) NOT NULL,
  `existing_grade_pay` decimal(10,2) NOT NULL,
  `upgraded_pay` decimal(10,2) NOT NULL,
  `upgraded_grade_pay` decimal(10,2) NOT NULL,
  `macp_remarks` text COLLATE utf8mb4_unicode_ci,
  `no_of_financial_upgradation` int NOT NULL,
  `financial_upgradation_type` enum('MACP','PROMOTION','ACP') COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `financial_upgradations_empl_id_index` (`empl_id`),
  KEY `financial_upgradations_promotion_date_index` (`promotion_date`),
  KEY `financial_upgradations_financial_upgradation_type_index` (`financial_upgradation_type`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_upgradations`
--

INSERT INTO `financial_upgradations` (`id`, `sr_no`, `empl_id`, `promotion_date`, `existing_designation`, `upgraded_designation`, `date_in_grade`, `existing_scale`, `upgraded_scale`, `pay_fixed`, `existing_pay`, `existing_grade_pay`, `upgraded_pay`, `upgraded_grade_pay`, `macp_remarks`, `no_of_financial_upgradation`, `financial_upgradation_type`, `region`, `department`, `created_at`, `updated_at`) VALUES
(1, 1, '786', '2025-10-04', 'Assistant Manager', 'Manager', '2025-10-23', '5200', '9000', 'YES', 300.00, 5000.00, 7000.00, 5000.00, 'NA', 1, 'PROMOTION', 'north', 'finance', '2025-10-05 12:31:40', '2025-10-05 12:32:34'),
(2, 1, '4231', '2011-11-05', 'JQAO (LAB)', 'QAO (LAB)', '2001-11-05', '5200-20200 GP 2800', '9300-34800 GP 4200', 'YES', 11680.00, 2800.00, 12120.00, 4200.00, NULL, 1, 'MACP', 'north', 'lab', '2025-10-05 12:48:45', '2025-10-05 12:48:45'),
(3, 2, '786', '2013-03-12', 'Assistant Manager', 'Manager', '2008-03-12', '9300-34800 GP 4200', '15600-39100 GP 5400', 'YES', 18500.00, 4200.00, 22500.00, 5400.00, 'Regular promotion', 1, 'PROMOTION', 'south', 'finance', '2025-10-05 12:48:45', '2025-10-05 12:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '0001_01_01_000000_create_users_table', 1),
(5, '0001_01_01_000001_create_cache_table', 1),
(6, '0001_01_01_000002_create_jobs_table', 1),
(7, '2025_09_17_170126_employees_table', 1),
(8, '2025_09_21_114514_create_promotions_table', 2),
(9, '2025_09_21_115830_update_employees_table_for_promotions', 2),
(10, '2025_09_21_125042_create_transfers_table', 2),
(11, '2025_09_21_125113_update_employees_table_for_transfers', 2),
(12, '2025_09_28_103505_employee', 3),
(13, '2025_10_05_133418_create_apar_gradings_table', 4),
(14, '2025_10_05_173627_create_financial_upgradations_table', 5),
(15, '2025_10_06_165035_create_mode_of_recruitments_table', 6),
(16, '2025_10_06_172021_create_pay_fixations_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `mode_of_recruitments`
--

DROP TABLE IF EXISTS `mode_of_recruitments`;
CREATE TABLE IF NOT EXISTS `mode_of_recruitments` (
  `PromotionID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `empID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Designation_` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Seniority_Number` int NOT NULL,
  `Designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_of_Entry` date NOT NULL,
  `Office_Order_No` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Method_of_Recruitment` enum('PR','DIRECT','DEPUTATION','CONTRACT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Promotion_Remarks` text COLLATE utf8mb4_unicode_ci,
  `Pay_Fixation` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_of_Exit` date DEFAULT NULL,
  `GSLI_Policy_No` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `GSLI_Entry_dt` date DEFAULT NULL,
  `GSLI_Exit_dt` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`PromotionID`),
  KEY `mode_of_recruitments_empid_index` (`empID`),
  KEY `mode_of_recruitments_method_of_recruitment_index` (`Method_of_Recruitment`),
  KEY `mode_of_recruitments_date_of_entry_index` (`Date_of_Entry`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mode_of_recruitments`
--

INSERT INTO `mode_of_recruitments` (`PromotionID`, `empID`, `Designation_`, `Seniority_Number`, `Designation`, `Date_of_Entry`, `Office_Order_No`, `Method_of_Recruitment`, `Promotion_Remarks`, `Pay_Fixation`, `Date_of_Exit`, `GSLI_Policy_No`, `GSLI_Entry_dt`, `GSLI_Exit_dt`, `created_at`, `updated_at`) VALUES
(1, '786', 'TO', 2, 'TO-IT', '2025-10-06', '29/74/96/AD dated 24.06.2025', 'PR', 'None', 'Yes', '2025-10-06', '123', '2025-10-09', '2025-10-11', '2025-10-06 11:41:42', '2025-10-06 11:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_fixations`
--

DROP TABLE IF EXISTS `pay_fixations`;
CREATE TABLE IF NOT EXISTS `pay_fixations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `empl_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_fixation_date` date NOT NULL,
  `basic_pay` decimal(10,2) NOT NULL,
  `grade_pay` decimal(10,2) DEFAULT NULL,
  `cell_no` int NOT NULL,
  `revised_level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_fixation_remarks` text COLLATE utf8mb4_unicode_ci,
  `level_2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pay_fixations_empl_id_index` (`empl_id`),
  KEY `pay_fixations_pay_fixation_date_index` (`pay_fixation_date`),
  KEY `pay_fixations_revised_level_index` (`revised_level`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pay_fixations`
--

INSERT INTO `pay_fixations` (`id`, `empl_id`, `pay_fixation_date`, `basic_pay`, `grade_pay`, `cell_no`, `revised_level`, `pay_fixation_remarks`, `level_2`, `created_at`, `updated_at`) VALUES
(1, '786', '2025-10-06', 77700.00, 0.00, 12, 'Level 10', 'na', '10', '2025-10-06 12:02:50', '2025-10-06 12:02:50');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` bigint UNSIGNED NOT NULL,
  `type` enum('Regular Promotion','MACP','ACP','Financial Upgradation') COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `effective_date` date NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `approval_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `financial_details` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promotions_approved_by_foreign` (`approved_by`),
  KEY `promotions_employee_id_index` (`employee_id`),
  KEY `promotions_type_index` (`type`),
  KEY `promotions_effective_date_index` (`effective_date`),
  KEY `promotions_approval_status_index` (`approval_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('PWRUVNYSmSFcV1GzY9Ah61XOBo8mfik1nn7wt1RZ', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnlsRWg4b3BKUVJFYjFkNWRydTI0cWMxcEluS0tVclRXSE5SSHFvVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njg6Imh0dHA6Ly9sb2NhbGhvc3QvdGNfZW1wbG95ZWVfbWFuYWdlbWVudC9maW5hbmNpYWwtdXBncmFkYXRpb24vZXhwb3J0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1759688479),
('fvLzfDeV0NURnOqpHiYuiMcz7atZWOCdcmrrCVKB', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQVYwQlAzaHlmYWxTR2EwNHJUSzlZOTRkUk5IRVZ4cHZManJBaDJRSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly9sb2NhbGhvc3QvdGNfZW1wbG95ZWVfbWFuYWdlbWVudC9wYXktZml4YXRpb24vZXhwb3J0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1759772722);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
CREATE TABLE IF NOT EXISTS `transfers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` bigint UNSIGNED NOT NULL,
  `previous_posting` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_posting` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transfer_date` date NOT NULL,
  `transfer_order_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `status` enum('Pending','Approved','Completed','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `date_of_relieving` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfers_approved_by_foreign` (`approved_by`),
  KEY `transfers_employee_id_index` (`employee_id`),
  KEY `transfers_transfer_date_index` (`transfer_date`),
  KEY `transfers_status_index` (`status`),
  KEY `transfers_new_posting_index` (`new_posting`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
