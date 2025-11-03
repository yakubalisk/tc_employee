-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 03, 2025 at 05:52 PM
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_code_unique` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'LAB', 'LAB', 'Laboratory Department', '2025-10-29 11:11:34', '2025-10-29 11:11:34'),
(2, 'EP&QA', 'EPQA', 'Engineering Production & Quality Assurance', '2025-10-29 11:11:34', '2025-10-29 11:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

DROP TABLE IF EXISTS `designations`;
CREATE TABLE IF NOT EXISTS `designations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `group` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpc_level` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `description`, `group`, `cpc_level`, `code`, `grade`, `created_at`, `updated_at`) VALUES
(5, 'QAO (LAB)', 'Quality Assurance Officer  (Lab)', 'B', 'Level 6', NULL, NULL, NULL, NULL),
(6, 'JQAO (LAB)', 'Jr. Quality Assurance Officer  (Lab)', 'C', 'Level 5', NULL, NULL, NULL, NULL),
(7, 'SECRETARY', 'Secretary', 'A', 'Level 13', NULL, NULL, NULL, NULL),
(8, 'FIELD OFFICER', 'Field Officer', 'B', 'Level 6', NULL, NULL, NULL, NULL),
(9, 'SSA', 'Senior Statistical Assistant', 'C', 'Level 5', NULL, NULL, NULL, NULL),
(10, 'ASST. SECRETARY', 'Assistant Secretary', 'A', 'Level 10', NULL, NULL, NULL, NULL),
(11, 'QAO (EP&QA)', 'Quality Assurance Officer (EP&QA)', 'B', 'Level 6', NULL, NULL, NULL, NULL),
(12, 'PUNCH OPERATOR', 'Punch Operator', 'C', 'Level 4', NULL, NULL, NULL, NULL),
(13, 'VIGILANCE OFFICER', 'Vigilance Officer', 'A', 'Level 10', NULL, NULL, NULL, NULL),
(14, 'JSA', 'Junior Statistical Assistant', 'C', 'Level 4', NULL, NULL, NULL, NULL),
(15, 'CHIEF ACCOUNT OFFICER', 'Chief Account Officer', 'A', 'Level 11', NULL, NULL, NULL, NULL),
(16, 'ACCOUNTANT', 'Accountant', 'B', 'Level 6', NULL, NULL, NULL, NULL),
(17, 'JR.INVESTIGATOR', 'Jr. Investigator', 'C', 'Level 5', NULL, NULL, NULL, NULL),
(18, 'ACCOUNTS OFFICER', 'Accounts Officer', 'A', 'Level 10', NULL, NULL, NULL, NULL),
(19, 'SUPERINTENDENT', 'Superintendent', 'B', 'Level 6', NULL, NULL, NULL, NULL),
(20, 'DIRECTOR (EP&QA)', 'Director (EP&QA)', 'A', 'Level 12', NULL, NULL, NULL, NULL),
(21, 'ASST. DIRECTOR (OL)', 'Assistant Director (OL)', 'B', 'Level 6', NULL, NULL, NULL, NULL),
(22, 'ASSISTANT', 'Assistant', 'C', 'Level 6', NULL, NULL, NULL, NULL),
(23, 'JT. DIRECTOR (EP&QA)', 'Joint Director (EP&QA)', 'A', 'Level 11', NULL, NULL, NULL, NULL),
(24, 'SR.TRANSLATOR', 'Senior Translator', 'B', 'Level 6', NULL, NULL, NULL, NULL),
(25, 'JR.TRANSLATOR', 'Jr. Translator', 'C', 'Level 6', NULL, NULL, NULL, NULL),
(26, 'DY. DIRECTOR (EP&QA)', 'Deputy Director (EP&QA)', 'A', 'Level 11', NULL, NULL, NULL, NULL),
(27, 'SR.STENO', 'Senior Stenographer', 'C', 'Level 6', NULL, NULL, NULL, NULL),
(28, 'LIBRARIAN', 'Librarian', 'B', 'Level 6', NULL, NULL, NULL, NULL),
(29, 'ASST. DIRECTOR (EP&QA)', 'Assistant Director (EP&QA)', 'A', 'Level 10', NULL, NULL, NULL, NULL),
(30, 'JR.STENO', 'Stenographer', 'C', 'Level 4', NULL, NULL, NULL, NULL),
(31, 'DIRECTOR (CDP)', 'Director (CDP)', 'A', 'Level 12', NULL, NULL, NULL, NULL),
(32, 'UDC', 'Upper Division Clerk', 'C', 'Level 4', NULL, NULL, NULL, NULL),
(33, 'DIRECTOR (TQM)', 'Director (TQM)', 'A', 'Level 12', NULL, NULL, NULL, NULL),
(34, 'MAINTENANCE MECHANIC', 'Maintenance Mechanic', 'C', 'Level 4', NULL, NULL, NULL, NULL),
(35, 'DIRECTOR (LAB)', 'Director (Lab)', 'A', 'Level 12', NULL, NULL, NULL, NULL),
(36, 'LDC', 'Lower Division Clerk', 'C', 'Level 2', NULL, NULL, NULL, NULL),
(37, 'JT. DIRECTOR (LAB)', 'Joint Director (Lab)', 'A', 'Level 11', NULL, NULL, NULL, NULL),
(38, 'STAFF CAR DRIVER I', 'Staff Car Driver I', 'C', 'Level 5', NULL, NULL, NULL, NULL),
(39, 'DY. DIRECTOR (LAB)', 'Deputy Director (Lab)', 'A', 'Level 11', NULL, NULL, NULL, NULL),
(40, 'STAFF CAR DRIVER II', 'Staff Car Driver II', 'C', 'Level 4', NULL, NULL, NULL, NULL),
(41, 'ASST. DIRECTOR (LAB)', 'Assistant Director (Lab)', 'A', 'Level 10', NULL, NULL, NULL, NULL),
(42, 'STAFF CAR DRIVER III', 'Staff Car Driver III', 'C', 'Level 2', NULL, NULL, NULL, NULL),
(43, 'DIRECTOR (MR)', 'Director (MR)', 'A', 'Level 12', NULL, NULL, NULL, NULL),
(44, 'SR. ATTENDANT', 'Senior Attendant', 'C', 'Level 1', NULL, NULL, NULL, NULL),
(45, 'DEPUTY DIRECTOR (MR)', 'Deputy Director (MR)', 'A', 'Level 11', NULL, NULL, NULL, NULL),
(46, 'ATTENDANT', 'Attendant', 'C', 'Level 1', NULL, NULL, NULL, NULL),
(47, 'MARKET RESEARCH OFFICER', 'Market Research Officer', 'A', 'Level 10', NULL, NULL, NULL, NULL),
(48, 'STATISTICAL OFFICER', 'Statistical Officer', 'A', 'Level 10', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_of_doctor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `qualification` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ama_remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `doctors_name_of_doctor_index` (`name_of_doctor`),
  KEY `doctors_registration_no_index` (`registration_no`),
  KEY `doctors_employee_id_foreign` (`employee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `empCode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('MALE','FEMALE','OTHER') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('General','OBC','SC','ST') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `education` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mobile` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateOfAppointment` date NOT NULL,
  `designationAtAppointment` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `designationAtPresent` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `presentPosting` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personalFileNo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `officeLandline` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateOfBirth` date NOT NULL,
  `dateOfRetirement` date NOT NULL,
  `homeTown` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residentialAddress` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('EXISTING','RETIRED','TRANSFERRED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EXISTING',
  `current_designation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_posting` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_transfer_date` date DEFAULT NULL,
  `current_transfer_id` bigint UNSIGNED DEFAULT NULL,
  `last_promotion_date` date DEFAULT NULL,
  `current_promotion_id` bigint UNSIGNED DEFAULT NULL,
  `promoted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_in_charge` tinyint(1) NOT NULL DEFAULT '0',
  `promotee_transferee` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pension_file_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nps` tinyint(1) NOT NULL DEFAULT '0',
  `increment_month` int DEFAULT NULL,
  `probation_period` tinyint(1) NOT NULL DEFAULT '0',
  `status_of_post` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` tinyint(1) NOT NULL DEFAULT '0',
  `seniority_sequence_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sddlsection_incharge` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `2021_2022` tinyint(1) NOT NULL DEFAULT '0',
  `benevolent_member` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `2022_2023` tinyint(1) NOT NULL DEFAULT '0',
  `increment_individual_selc` tinyint(1) NOT NULL DEFAULT '0',
  `office_landline_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `increment_withheld` tinyint(1) NOT NULL DEFAULT '0',
  `FR56J_2nd_batch` tinyint(1) NOT NULL DEFAULT '0',
  `apar_hod` tinyint(1) NOT NULL DEFAULT '0',
  `2023_2024` tinyint(1) NOT NULL DEFAULT '0',
  `2024_2025` tinyint(1) NOT NULL DEFAULT '0',
  `karmayogi_certificate_completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_empcode_unique` (`empCode`),
  UNIQUE KEY `employees_email_unique` (`email`),
  KEY `employees_current_promotion_id_foreign` (`current_promotion_id`),
  KEY `employees_current_transfer_id_foreign` (`current_transfer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `families`
--

DROP TABLE IF EXISTS `families`;
CREATE TABLE IF NOT EXISTS `families` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_of_family_member` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relationship` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `dependent_remarks` text COLLATE utf8mb4_unicode_ci,
  `reason_for_dependence` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `ltc` tinyint(1) NOT NULL DEFAULT '0',
  `medical` tinyint(1) NOT NULL DEFAULT '0',
  `gsli` tinyint(1) NOT NULL DEFAULT '0',
  `gpf` tinyint(1) NOT NULL DEFAULT '0',
  `dcrg` tinyint(1) NOT NULL DEFAULT '0',
  `pension_nps` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `families_relationship_index` (`relationship`),
  KEY `families_date_of_birth_index` (`date_of_birth`),
  KEY `families_employee_id_foreign` (`employee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_upgradations`
--

DROP TABLE IF EXISTS `financial_upgradations`;
CREATE TABLE IF NOT EXISTS `financial_upgradations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `employee_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `financial_upgradations_promotion_date_index` (`promotion_date`),
  KEY `financial_upgradations_financial_upgradation_type_index` (`financial_upgradation_type`),
  KEY `financial_upgradations_employee_id_foreign` (`employee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_17_170126_employees_table', 1),
(5, '2025_09_21_114514_create_promotions_table', 1),
(6, '2025_09_21_115830_update_employees_table_for_promotions', 1),
(7, '2025_09_21_125042_create_transfers_table', 1),
(8, '2025_09_21_125113_update_employees_table_for_transfers', 1),
(9, '2025_09_28_103505_employee', 1),
(10, '2025_10_05_133418_create_apar_gradings_table', 1),
(11, '2025_10_05_173627_create_financial_upgradations_table', 1),
(12, '2025_10_06_165035_create_mode_of_recruitments_table', 1),
(13, '2025_10_06_172021_create_pay_fixations_table', 1),
(14, '2025_10_07_161704_create_transfers_table', 2),
(15, '2025_10_07_161925_create_regions_table', 2),
(16, '2025_10_07_161954_create_departments_table', 2),
(17, '2025_10_07_162018_create_designations_table', 2),
(18, '2025_10_08_161841_create_families_table', 2),
(19, '2025_10_08_164732_create_doctors_table', 2),
(20, '2025_10_09_170149_alter_financial_upgradations_table', 2),
(21, '2025_10_10_170946_alter_mode_of_recruitments_updradations', 2),
(22, '2025_10_10_181154_alter_pay_fixations_updradations', 2),
(23, '2025_10_16_173307_alter_mode_of_family_updradations', 2),
(24, '2025_10_16_180626_alter_mode_of_doctors_updradations', 2),
(25, '2025_10_20_161652_alter_mode_of_transfer_updradations', 2),
(26, '2025_10_29_162327_alter_mode_of_designations', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mode_of_recruitments`
--

DROP TABLE IF EXISTS `mode_of_recruitments`;
CREATE TABLE IF NOT EXISTS `mode_of_recruitments` (
  `PromotionID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `employee_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`PromotionID`),
  KEY `mode_of_recruitments_method_of_recruitment_index` (`Method_of_Recruitment`),
  KEY `mode_of_recruitments_date_of_entry_index` (`Date_of_Entry`),
  KEY `mode_of_recruitments_employee_id_foreign` (`employee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `pay_fixation_date` date NOT NULL,
  `basic_pay` decimal(10,2) NOT NULL,
  `grade_pay` decimal(10,2) DEFAULT NULL,
  `cell_no` int NOT NULL,
  `revised_level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_fixation_remarks` text COLLATE utf8mb4_unicode_ci,
  `level_2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pay_fixations_pay_fixation_date_index` (`pay_fixation_date`),
  KEY `pay_fixations_revised_level_index` (`revised_level`),
  KEY `pay_fixations_employee_id_foreign` (`employee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
CREATE TABLE IF NOT EXISTS `regions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `regions_code_unique` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'MUMBAI', 'MUM', 'Mumbai Region', '2025-10-29 11:11:34', '2025-10-29 11:11:34'),
(2, 'BANGALORE', 'BNG', 'Bangalore Region', '2025-10-29 11:11:34', '2025-10-29 11:11:34'),
(3, 'AHMEDABAD', 'AHD', 'Ahmedabad Region', '2025-10-29 11:11:34', '2025-10-29 11:11:34'),
(4, 'JAIPUR', 'JPR', 'Jaipur Region', '2025-10-29 11:11:34', '2025-10-29 11:11:34'),
(5, 'NEW DELHI - NARAINA', 'DEL', 'New Delhi Naraina Region', '2025-10-29 11:11:34', '2025-10-29 11:11:34');

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
('ezGNQsPwHtoFDe8NYXQeaWbd7m4crRpuJ2zp27TL', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU3M2WXpxOE5qS3BEOUxaMjVMRkdTaTNCUFVlallIcDNZeGU2d2JDdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9sb2NhbGhvc3QvdGNfZW1wbG95ZWVfbWFuYWdlbWVudC9lbXBsb3llZXMvdGVtcGxhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1762192204);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
CREATE TABLE IF NOT EXISTS `transfers` (
  `transferId` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_joining` date NOT NULL,
  `date_of_releiving` date NOT NULL,
  `transfer_order_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transfer_remarks` text COLLATE utf8mb4_unicode_ci,
  `region_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_exit` date DEFAULT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_worked_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transferred_region_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`transferId`),
  KEY `transfers_date_of_joining_index` (`date_of_joining`),
  KEY `transfers_region_id_index` (`region_id`),
  KEY `transfers_transferred_region_id_index` (`transferred_region_id`),
  KEY `transfers_employee_id_foreign` (`employee_id`)
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
