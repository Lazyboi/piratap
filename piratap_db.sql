-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2017 at 02:18 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `piratap_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `acd_courses`
--

CREATE TABLE IF NOT EXISTS `acd_courses` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `department_id` int(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acd_courses`
--

INSERT INTO `acd_courses` (`id`, `name`, `description`, `department_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'ABComm-Broad', 'Bachelor of Arts in Communication', 12, NULL, NULL, '2017-10-28 01:27:48', 1, NULL, NULL, NULL, NULL),
(2, 'ABEngl', 'Bachelor of Arts in English', 12, NULL, NULL, '2017-07-30 15:02:04', 1, NULL, NULL, NULL, NULL),
(3, 'ABFS', 'Bachelor of Arts in Foreign Service', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'ABLS', 'Bachelor of Arts in Legal Studies', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'ABMMA', 'Bachelor of Arts in Multimedia Arts', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'ADT', 'Arts and Design Track', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'AT-ABM', 'Academic Track - Accountancy, Business and Management', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'AT-GAS', 'Academic Track - General Academic Strand', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'AT-HUMSS', 'Academic Track - Humanities and Social Sciences Strand', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'AT-STEM', 'Academic Track - Science, Technology, Engineering and Mathematics', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'BEEd', 'Bachelor of Elementary Education', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'BS ARCH', 'Bachelor of Science in Architecture', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'BSA', 'Bachelor of Science in Accountancy', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'BSBA-HRDM', 'Bachelor of Science in Business Administration - Major in Human Resource Development Management', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'BSBA-MA', 'Bachelor of Science in Business Administration - Major in Management Accounting', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'BSBA-MM', 'Bachelor of Science in Business Administration - Major in Marketing Management', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'BSBA-OM', 'Bachelor of Science in Business Administration - Major in Operations Management', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'BSBIO', 'Bachelor of Science in Biology', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'BSCA', 'Bachelor of Science in Custom Administration', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'BSCE', 'Bachelor of Science in Civil Engineering', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'BSCpE', 'Bachelor of Science in Computer Engineering', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'BSCS', 'Bachelor of Science in Computer Science', 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'BSE-ENGL', 'Bachelor of Secondary Education-Major in English', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'BSEcE', 'Bachelor of Science in Electronics Engineering', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'BSEE', 'Bachelor of Science in Electrical Engineering', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'BSFS', 'Bachelor of Science in Foreign Service', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'BSHHM (ESP)', 'Bachelor of Science in Hotel and Hospitality Management - ESP Tongmyong University', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'BSHRM', 'Bachelor of Science in Hotel and Restaurant Management', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'BSHRM-CL', 'Bachelor of Science in Hotel and Restaurant Management - Major in Cruise Line', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'BSIE', 'Bachelor of Science in Industrial Engineering', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'BSIHRM-HRA', 'Bachelor of Science in International Hospitality Management - with Specialization in Hotel and Restaurant Administration', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'BSIHRM-HRACAKO', 'Bachelor of Science in International Hospitality Management - with Specialization in Culinary Arts and Kitchen Operations', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'BSIHRM-HRACLOCA', 'Bachelor of Science in International Hospitality Management - with Specialization in Cruise Line Operations in Culinary Arts', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'BSIHRM-HRACLOHS', 'Bachelor of Science in International Hospitality Management - with Specialization in Cruise Line Operations in Hotel Services', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'BSIT', 'Bachelor of Science in Information Technology', 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'BSITTM-HW', 'Bachelor of Science in International Travel and Tourism Management-Health and Wellness', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'BSME', 'Bachelor of Science in Mechanical Engineering', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'BSMT', 'Bachelor of Science in Medical Technology', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'BSND', 'Bachelor of Science in Nutrition and Diatetics', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'BSP', 'Bachelor of Science in Psychology', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'BSPH', 'Bachelor of Science in Pharmacy', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'BSREM', 'Bachelor of Science in Real Estate Management', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'BSRT', 'Bachelor of Science in Radiologic Technology', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'BSTM', 'Bachelor of Science in Tourism Management', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'BSTTM', 'Bachelor of Science in International Travel and Tourism Management', 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'COL', 'Bachelor of Laws', 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'ESP-AE', 'ISEP - BS Automotive Engineering', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'ESP-BSBA', 'ISEP - BS Business Administration', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'ESP-BSIT', 'ISEP - BS Information Technology?', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'ESP-CA', 'ISEP - BS Customs Administration', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'ESP-MIS/CS', 'ISEP - BS Management System Information/Computer Science', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'ESP-TM', 'ISEP - BS Tourism', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'HS', 'International High School', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'HS1', 'International High School (Basic)', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'LC-CMH', 'Lifestyle-Makeup & Hairstyling (Combined)', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'LC-HS', 'Lifestyle-Hairstyling (Men & Women)', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'LC-MU', 'Lifestyle-Makeup', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'LC-MU(AVM)', 'Lifestyle-Makeup (Advanced Makeup w/ Airbrush)', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'LC-MU(PFM)', 'Lifestyle-Makeup (Professional Makeup)', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'LC-MU(PLM)', 'Lifestyle-Makeup (Personal Makeup)', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'MAED-EM', 'Master of Arts in Education-Major in Educational Management', 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'MAED-GC', 'Master of Arts in Education-Major in Guidance and Counseling', 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'MBA', 'Master in Business Administration', 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'MIHM', 'Master in International Hospitality Management', 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'MITTM', 'Master in International Travel and Tourism Management', 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'MPA', 'Master in Public Administration', 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'NC', 'No Course', 49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'SPT', 'Sports Track', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'SPTA', 'Taekwondo', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'TESDA-BC', 'TESDA-Beauty Care', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'TESDA-HD', 'TESDA-Hairdressing', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'TVL-HEBW', 'Technical-Vocational Livelihood Track - Home Economics with Specialization in Beauty and Wellness', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'TVL-HECA', 'Technical-Vocational Livelihood Track - Home Economics with Specialization in Culinary Arts', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'TVL-HEH', 'Technical-Vocational Livelihood Track - Home Economics with Specialization in Hospitality', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'TVL-HET', 'Technical-Vocational Livelihood Track - Home Economics with Specialization in Tourism', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'TVL-ICT', 'Technical-Vocational Livelihood Track - Information and Communication Technology', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'testsss', 'tests', 7, '2017-07-26 09:28:54', 1, '2017-07-26 09:29:38', 1, NULL, NULL, NULL, NULL),
(78, 'test', 'test', 3, '2017-10-14 08:54:23', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(79, '123', '1234', 3, '2017-10-28 01:36:50', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `acd_sections`
--

CREATE TABLE IF NOT EXISTS `acd_sections` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `academic_year_id` int(10) NOT NULL,
  `semester_id` int(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acd_sections`
--

INSERT INTO `acd_sections` (`id`, `name`, `description`, `academic_year_id`, `semester_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'IT 201', 'Adviser: Test', 1, 1, '2017-07-22 08:26:58', 1, '2017-10-27 21:49:44', 1, NULL, NULL, NULL, NULL),
(2, 'IT 401', NULL, 1, 1, '2017-07-22 08:26:58', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'IT-403', NULL, 0, 0, '2017-10-06 11:54:44', 1, NULL, NULL, NULL, NULL, '2017-10-06 11:54:57', 1),
(4, 'te', 'te', 0, 0, '2017-10-28 01:38:38', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'tes', 'test', 0, 0, '2017-10-28 01:38:46', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `acd_subjects`
--

CREATE TABLE IF NOT EXISTS `acd_subjects` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acd_subjects`
--

INSERT INTO `acd_subjects` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'BLDL02E', 'Building Design 2', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'CADS02E', 'CAD and Drafting for Architecture 2', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'CADS04E', 'Advance 3D CAD Presentation', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'COEL62E', 'Object Oriented Programming (ENG)', '2017-07-22 08:33:54', 1, '2017-07-03 08:25:51', 63, NULL, NULL, NULL, NULL),
(5, 'CSCN04C', 'Programming Languages', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'CSCN08C', 'Network Technology', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'DCSN03C', 'Computer Programming 2', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'ELEC02C', 'ICT Elective w/ Laboratory 2', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'ELECL4C', 'ICT Elective w/ Laboratory 4', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'ELEN02B', 'Elective 2 (Acctg. Software Application)', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'ELFRN2C', 'ICT Elective w/ Lab 1', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'ELFRN3C', 'Gen. Program Elective 2', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'ENGN03G', 'Speech Communication', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'HRAL04H', 'Computer System for Front Office Operations', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'ICTL01H', 'ICT in the Workplace', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'IFTL01E', 'Information Technology', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'ITEL08C', 'Database Management Systems 1', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'ITEL10C', 'Systems Analysis and Design', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'ITEL11C', 'Network Management', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'ITEL12C', 'Database Management Systems (Advanced)', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'ITEL13C', 'Web Programming & Development', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'ITEN01C', 'Introduction to Human Computer Interaction', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'ITEN17C', 'Multimedia Systems', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'ITFL01G', 'IT Fundamentals with Intro to Basic PC Operation', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'ITFL02G', 'Advanced Office Productivity Tools', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'ITFL06C', 'Object Oriented Programming (IT)', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'MMAN03A', 'Computer Graphics', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'MMAN11A', '2-Dimension Animation I', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'MMAN12A', 'Interactive Media', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'MMAN17A', '3-Dimension Animation I', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'MMAN18A', 'Video Production in Multimedia', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'MMAN19A', 'Sound & Design Production for Multimedia', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'MMAN20A', 'Web Design & Development I', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'OPSL42E', 'Operating Systems', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'PWSL01E', 'Power System Anal. & Design', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'THEL02E', 'Thesis 2', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'DSAL32E', 'Data Structure and Algorithm Analysis', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'AMNS02C', 'Animation (NCII) 2', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'COPS02C', 'Computer Programming (NC IV) 2', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'EMS01G', 'Empowerment Technologies (for ABM)', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'NMTL04X', 'Numerical Methods', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'ETS01G', 'Empowerment Technology', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'ICTN01H', 'ICT in the Workplace', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'ITEN22B', 'Accounting and Auditing Software', '2017-07-22 08:33:54', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'testt', 'testtt', '2017-10-28 09:22:17', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `acd_subject_legend`
--

CREATE TABLE IF NOT EXISTS `acd_subject_legend` (
`id` int(11) NOT NULL,
  `subject_type` varchar(11) NOT NULL,
  `name` varchar(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acd_subject_legend`
--

INSERT INTO `acd_subject_legend` (`id`, `subject_type`, `name`) VALUES
(1, 'Lec', 'Lecture'),
(2, 'Lab', 'Laboratory');

-- --------------------------------------------------------

--
-- Table structure for table `atd_nfc_tag`
--

CREATE TABLE IF NOT EXISTS `atd_nfc_tag` (
`id` int(11) NOT NULL,
  `NFC_Tag_` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atd_nfc_tag`
--

INSERT INTO `atd_nfc_tag` (`id`, `NFC_Tag_`) VALUES
(1, '03ce3ae3');

-- --------------------------------------------------------

--
-- Table structure for table `atd_users_attendance`
--

CREATE TABLE IF NOT EXISTS `atd_users_attendance` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `is_late` bit(1) NOT NULL,
  `is_absent` bit(1) NOT NULL,
  `is_cutting` bit(1) NOT NULL,
  `remarks` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atd_users_attendance`
--

INSERT INTO `atd_users_attendance` (`id`, `user_id`, `class_id`, `time_in`, `time_out`, `is_late`, `is_absent`, `is_cutting`, `remarks`) VALUES
(4, 29, 2, '2017-10-19 12:32:23', '2017-10-19 20:51:46', b'0', b'0', b'0', ''),
(5, 214, 3, '2017-10-27 07:20:00', NULL, b'0', b'0', b'0', ''),
(6, 213, 7, '1899-12-31 00:00:00', '1899-12-31 23:15:00', b'0', b'0', b'0', ''),
(7, 214, 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', b'0', b'0', b'0', ''),
(19, 1, 1, '2017-11-10 16:49:01', NULL, b'0', b'0', b'0', ''),
(20, 1, 1, '2017-11-10 20:32:44', NULL, b'0', b'0', b'0', ''),
(21, 1, 1, '2017-11-10 20:38:05', NULL, b'0', b'0', b'0', '');

-- --------------------------------------------------------

--
-- Table structure for table `atd_users_nfc`
--

CREATE TABLE IF NOT EXISTS `atd_users_nfc` (
`id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `nfc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atd_users_nfc`
--

INSERT INTO `atd_users_nfc` (`id`, `user_id`, `nfc_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clm_classes`
--

CREATE TABLE IF NOT EXISTS `clm_classes` (
`id` int(11) NOT NULL,
  `subject_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  `assigned_professor` int(10) NOT NULL,
  `academic_year_id` int(10) NOT NULL,
  `semester_id` int(10) NOT NULL,
  `imported_at` datetime DEFAULT NULL,
  `imported_by` int(10) DEFAULT NULL,
  `finalized_at` datetime DEFAULT NULL,
  `finalized_by` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clm_classes`
--

INSERT INTO `clm_classes` (`id`, `subject_id`, `section_id`, `assigned_professor`, `academic_year_id`, `semester_id`, `imported_at`, `imported_by`, `finalized_at`, `finalized_by`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-20 17:15:18', 1),
(2, 1, 2, 30, 0, 0, NULL, NULL, NULL, NULL, '2017-10-20 16:24:08', 1, NULL, NULL, NULL, NULL, '2017-10-20 16:35:22', 1),
(3, 1, 1, 31, 0, 0, NULL, NULL, NULL, NULL, '2017-10-20 16:33:57', 1, '2017-10-20 16:41:25', 1, NULL, NULL, NULL, NULL),
(4, 1, 1, 1, 0, 0, NULL, NULL, NULL, NULL, '2017-10-20 17:15:45', 1, '2017-10-28 01:27:35', 1, NULL, NULL, NULL, NULL),
(5, 1, 1, 31, 0, 0, NULL, NULL, NULL, NULL, '2017-10-20 17:16:18', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2, 1, 119, 0, 0, NULL, NULL, NULL, NULL, '2017-10-20 17:17:45', 1, NULL, NULL, NULL, NULL, '2017-10-28 01:10:55', 1),
(7, 2, 1, 119, 0, 0, NULL, NULL, NULL, NULL, '2017-10-20 17:18:23', 1, NULL, NULL, NULL, NULL, '2017-10-28 01:10:58', 1),
(8, 5, 1, 214, 0, 0, NULL, NULL, NULL, NULL, '2017-10-28 01:09:08', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 4, 1, 30, 0, 0, NULL, NULL, NULL, NULL, '2017-10-28 01:10:48', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 2, 31, 0, 0, NULL, NULL, NULL, NULL, '2017-10-28 14:05:39', 1, '2017-10-28 14:06:12', 1, NULL, NULL, '2017-10-28 14:06:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clm_classes_schedules`
--

CREATE TABLE IF NOT EXISTS `clm_classes_schedules` (
`id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_legend_id` int(11) NOT NULL,
  `day_id` int(10) NOT NULL,
  `started_at` time NOT NULL,
  `ended_at` time NOT NULL,
  `room_id` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clm_classes_schedules`
--

INSERT INTO `clm_classes_schedules` (`id`, `class_id`, `subject_legend_id`, `day_id`, `started_at`, `ended_at`, `room_id`) VALUES
(3, 1, 1, 1, '16:30:00', '17:30:00', 8),
(5, 1, 2, 4, '11:00:00', '13:00:00', 1),
(6, 2, 2, 1, '16:30:00', '17:00:00', 1),
(7, 3, 1, 7, '16:30:00', '18:45:00', 8),
(8, 4, 2, 1, '17:00:00', '18:00:00', 11),
(9, 5, 2, 2, '17:30:00', '18:00:00', 3),
(10, 6, 1, 6, '17:15:00', '18:00:00', 1),
(11, 7, 1, 6, '17:15:00', '18:00:00', 1),
(12, 8, 1, 1, '01:15:00', '01:45:00', 8),
(13, 9, 2, 4, '15:00:00', '17:00:00', 1),
(14, 10, 1, 1, '14:00:00', '15:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clm_classes_seat_plans`
--

CREATE TABLE IF NOT EXISTS `clm_classes_seat_plans` (
`id` int(10) NOT NULL,
  `class_id` int(10) NOT NULL,
  `computer_id` int(10) NOT NULL,
  `student_number` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `course_id` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clm_classes_seat_plans`
--

INSERT INTO `clm_classes_seat_plans` (`id`, `class_id`, `computer_id`, `student_number`, `first_name`, `last_name`, `course_id`) VALUES
(43, 1, 1, '2015-2-00026', ' Cyrine Perez', 'Alagao', 45),
(44, 1, 2, '2015-2-01637', ' Johanna Marie Santos', 'Amodente', 45),
(45, 1, 3, '2015-2-00049', ' Shahana Socoro Angcao', 'Bay', 45),
(46, 1, 4, '2015-2-00237', ' Queenleth Riego De Dios', 'Bello', 45),
(47, 1, 5, '2014-03083', ' Sahil ', 'Bhopal', 45),
(48, 1, 6, '2015-2-00055', ' Donnie Rose  Casillano', 'Bumagat', 45),
(49, 1, 7, '2015-2-00307', ' Faustine Xandel  Bendo', 'Caba??a', 45),
(50, 1, 8, '2015-2-00144', ' Zarrah Khalifa Ison', 'Cordova', 45),
(51, 1, 9, '2015-2-01738', ' Kristin Parcon', 'Damaso', 45),
(52, 1, 10, '2016-2-01606', ' Mary Grace Arellano', 'De Veas ', 45),
(53, 1, 11, '2015-2-00303', ' Remel Generillo', 'Del Rosario', 45),
(54, 1, 12, '2013-12442', ' Palileo Costa', 'Dela Cruz', 45),
(55, 1, 13, '2015-2-00863', ' Carmela Yasmin Miciano', 'Dimapilis', 45),
(56, 1, 14, '2015-2-00620', ' Shaira Mae Punzalan', 'Dumalasa', 45),
(57, 1, 15, '2015-2-00199', ' Joanna Mae Argete', 'Escalante', 45),
(58, 1, 16, '2015-2-00524', ' Wilfredo Jr Patricio', 'Espinosa', 45),
(59, 1, 17, '2015-2-03111', ' Hannah Lim', 'Gundao', 45),
(60, 1, 18, '2015-2-01618', ' Chang Hoon .', 'Joung', 45),
(61, 1, 19, '2015-2-00441', ' Louie Jay  Dacudag', 'Kailing', 45),
(62, 1, 20, '2015-2-00234', ' Clarrise Mae Madlangbayan', 'Labiran', 45),
(63, 1, 21, '2015-2-00204', ' Princess Sampilo', 'Lales', 45),
(64, 1, 22, '2015-2-00132', ' Lisa Marie De Luna', 'Lozada', 45),
(65, 1, 23, '2015-2-01426', ' Jaszha Eunice Blan', 'Lubang', 45),
(66, 1, 24, '2014-00255', ' Emielyn Duane ', 'Lumandog', 45),
(67, 1, 25, '2015-2-00185', ' Nicole Mikaela  Mayor', 'Matias', 45),
(68, 1, 26, '2015-2-00101', ' Jessallie Hernandez', 'Morena', 45),
(69, 1, 27, '2015-2-00549', ' Ma. Patricia Nicole Bolivar', 'Navarette', 45),
(70, 1, 28, '2015-2-00186', ' Jazmine Rose Delos Reyes', 'Pacheco', 45),
(71, 1, 29, '2015-2-02175', ' Ghidel Pareja', 'Paderes', 45),
(72, 1, 30, '2015-2-00316', ' Mark Francis Dequit', 'Pardilla', 45),
(73, 1, 31, '2015-2-00200', ' Franchesca Izzabelle Dela Cruz ', 'Ramirez', 45),
(74, 1, 32, '2015-2-01282', ' Jamaeca Lei Paredes', 'Ramos', 45),
(75, 1, 33, '2015-2-00540', ' Angelica Russane Cajiles', 'Rillera', 45),
(76, 1, 34, '2015-2-01122', ' Jasper Basa', 'Sabale', 45),
(77, 1, 35, '2015-2-00222', ' Catherine Conde', 'Sajol', 45),
(78, 1, 36, '2015-2-01723', ' Samantha Joyce Abando', 'Salcedo', 45),
(79, 1, 37, '2016-2-01220', ' Jewel Rheign  ', 'Santera', 45),
(80, 1, 38, '2016-2-02272', ' Beatriz Revilla', 'Sumague', 45),
(81, 1, 39, '2015-2-01405', ' Elaiza Caballes', 'Urmeneta', 45),
(82, 1, 40, '2015-2-01328', ' Cyra Joyce Obsuna', 'Valenciano', 45),
(83, 1, 41, '2015-2-00133', ' Jay Ar Moreno', 'Villeza', 45),
(84, 1, 42, '2015-2-01739', ' Jasmine Aizel Alvarez', 'Vivar', 45);

-- --------------------------------------------------------

--
-- Table structure for table `clm_days`
--

CREATE TABLE IF NOT EXISTS `clm_days` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clm_days`
--

INSERT INTO `clm_days` (`id`, `name`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday'),
(7, 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `clm_rooms`
--

CREATE TABLE IF NOT EXISTS `clm_rooms` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clm_rooms`
--

INSERT INTO `clm_rooms` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'S201', NULL, '2017-07-22 08:15:28', 1, '2017-07-24 12:26:45', 1, NULL, NULL, NULL, NULL),
(2, 'S202', NULL, '2017-07-22 08:15:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'S203', NULL, '2017-07-22 08:15:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'S204', NULL, '2017-07-22 08:15:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'S206', NULL, '2017-07-22 08:15:28', 1, '2017-07-20 11:54:46', 1, NULL, NULL, NULL, NULL),
(6, 'S207', NULL, '2017-07-22 08:15:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'S209', NULL, '2017-07-22 08:15:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'S210', NULL, '2017-07-22 08:15:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'S211', NULL, '2017-07-22 08:15:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'S213', NULL, '2017-07-22 08:15:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'J308', NULL, '2017-07-22 08:15:28', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prf_academic_years`
--

CREATE TABLE IF NOT EXISTS `prf_academic_years` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prf_academic_years`
--

INSERT INTO `prf_academic_years` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, '2017-2018', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prf_charsets`
--

CREATE TABLE IF NOT EXISTS `prf_charsets` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prf_charsets`
--

INSERT INTO `prf_charsets` (`id`, `name`, `code`) VALUES
(1, 'Unicode UTF-8', 'utf-8'),
(2, 'Unicode UTF-16', 'utf-16'),
(3, 'Unicode UTF-32', 'utf-32');

-- --------------------------------------------------------

--
-- Table structure for table `prf_events`
--

CREATE TABLE IF NOT EXISTS `prf_events` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `started_at` date NOT NULL,
  `ended_at` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prf_events`
--

INSERT INTO `prf_events` (`id`, `name`, `description`, `started_at`, `ended_at`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'National Heroes Day', NULL, '2017-08-28', '2017-08-28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prf_layouts`
--

CREATE TABLE IF NOT EXISTS `prf_layouts` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prf_layouts`
--

INSERT INTO `prf_layouts` (`id`, `name`, `code`) VALUES
(1, 'Fixed', 'fixed'),
(2, 'Layout Boxed', 'layout-boxed');

-- --------------------------------------------------------

--
-- Table structure for table `prf_semesters`
--

CREATE TABLE IF NOT EXISTS `prf_semesters` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prf_semesters`
--

INSERT INTO `prf_semesters` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'First', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Second', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Third', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Summer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prf_skin_colors`
--

CREATE TABLE IF NOT EXISTS `prf_skin_colors` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prf_skin_colors`
--

INSERT INTO `prf_skin_colors` (`id`, `name`, `code`) VALUES
(1, 'Skin Blue', 'skin-blue'),
(3, 'Skin Harvard Red', 'skin-harvard-red'),
(6, 'Skin Red', 'skin-red'),
(7, 'Skin University Grey', 'skin-university-grey'),
(9, 'Skin Maroon', 'skin-maroon');

-- --------------------------------------------------------

--
-- Table structure for table `prf_system_preferences`
--

CREATE TABLE IF NOT EXISTS `prf_system_preferences` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prf_system_preferences`
--

INSERT INTO `prf_system_preferences` (`id`, `name`, `description`, `code`, `value`, `updated_at`, `updated_by`) VALUES
(1, 'HTML Content Language', 'Specifies the language of the element''s content', 'html_content_language', '43', '2017-10-21 14:06:59', 1),
(2, 'Meta Charset', 'Specifies the character encoding for the HTML document', 'meta_charset', '1', '2017-10-21 14:06:59', 1),
(3, 'Meta Application Name', 'Specifies the name of the web application that the page represents', 'meta_application_name', 'PiraTAP', '2017-10-21 14:07:00', 1),
(4, 'Meta Description', 'Specifies the description of the web application that the page represents', 'meta_description', 'PiraTAP - Attendance Monitoring System ', '2017-10-21 14:07:00', 1),
(5, 'Meta Keywords', 'Specifies list of keywords - relevant to the page (Informs search engines what the page is about)', 'meta_keywords', 'LPU,Philippines,University', '2017-10-21 14:07:00', 1),
(6, 'Meta Author', 'Specifies the name of the author of the document', 'meta_author', 'Vince Crudo', '2017-10-21 14:07:00', 1),
(7, 'Application Name', 'Specifies the name of the web application', 'application_name', 'PiraTAP', '2017-10-21 14:07:00', 1),
(8, 'Skin Color', 'Specifies what color the web application used', 'skin_color', '3', '2017-10-28 01:15:04', 1),
(9, 'Layout', 'Specifies what layout should the web application used', 'layout', '2', '2017-10-28 01:15:04', 1),
(10, 'Footer Copyright', 'Specifies the content of the footer', 'footer_copyright', 'Copyright © 2017 TeamOctago. All rights reserved.', '2017-10-21 14:07:00', 1),
(11, 'Academic Year', 'Specifies what academic year should the system adapts to. This may have effect on other data that relies on academic periods', 'academic_year', '1', '2017-08-06 17:47:48', 1),
(12, 'Semester', 'Specifies what semester should the system adapts to. This may have effect on other data that relies on academic periods', 'semester', '1', '2017-08-06 17:47:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `umg_departments`
--

CREATE TABLE IF NOT EXISTS `umg_departments` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `acronym` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_departments`
--

INSERT INTO `umg_departments` (`id`, `name`, `acronym`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Academic Resource Center', 'ARC', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Accounting Department', 'ACCT', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Alumni Office', 'AO', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Arts and Cultural Affairs Department', 'ARTCAD', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Athletics', 'ATH', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Audio Visual Theater', 'AVT', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Auditorium', 'AUD', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Beauty and Design', 'BND', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Bookstore', 'BS', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Canteen', 'CAN', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'College of Allied Medical Sciences', 'CAMS', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'College of Arts and Sciences', 'CAS', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'College of Business Administration', 'CBA', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'College of International Tourism and Hospitality Management', 'CITHM', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'College of Law ', 'COL', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Communication and Public Affairs Department', 'CPAD', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Community Outreach and Service Learning ', 'COSEL', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Culinary Institute', 'CI', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Department of Architecture', 'DOA', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Department of Computer Studies', 'DCS', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Department of Engineering', 'DOE', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Executive Dean''s Office', 'EDO', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'Executive Office', 'EO', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Graduate School', 'GS', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'Guidance and Testing Center', 'GTC', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'Health Services Department', 'HSD', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'House Office', 'HO', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'Human Resource Department', 'HRD', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'Information and Communication Technology Department', 'ICTD', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'Internal Audit', 'IA', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'International School', 'IS', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'Kitchen', 'KIT', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'Le Cafe', 'LC', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'Leaf Hotel', 'LH', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'Maintenance', 'MAI', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'Multi-Purpose Hall', 'MPH', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'Others', 'OTH', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'PE Department', 'PED', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'Physical Plant and Facilities', 'PPF', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'Property Office', 'PRO', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'Purchasing Office', 'PUR', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'Quality Assurance Office', 'QAO', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'Research and Technical Skills Department', 'RTD', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'Security Office', 'SO', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'Strategic Communication Office', 'SCO', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'Student Affairs Office', 'SAO', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'Student Records Management Department', 'SRMD', NULL, '2017-07-22 03:44:07', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `umg_genders`
--

CREATE TABLE IF NOT EXISTS `umg_genders` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_genders`
--

INSERT INTO `umg_genders` (`id`, `name`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `umg_permissions`
--

CREATE TABLE IF NOT EXISTS `umg_permissions` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_permissions`
--

INSERT INTO `umg_permissions` (`id`, `name`, `slug`, `disabled_at`, `disabled_by`) VALUES
(1, 'Manage System Preferences', 'manage-system-preferences', NULL, NULL),
(2, 'View Permission', 'view-permission', NULL, NULL),
(3, 'Disable Permission', 'disable-permission', NULL, NULL),
(4, 'Enable Permission', 'enable-permission', NULL, NULL),
(5, 'View Role', 'view-role', NULL, NULL),
(6, 'Add New Role', 'add-new-role', NULL, NULL),
(7, 'Edit Role', 'edit-role', NULL, NULL),
(8, 'Disable Role', 'disable-role', NULL, NULL),
(9, 'Delete Role', 'delete-role', NULL, NULL),
(10, 'Enable Role', 'enable-role', NULL, NULL),
(11, 'Restore Role', 'restore-role', NULL, NULL),
(12, 'Purge Role', 'purge-role', NULL, NULL),
(13, 'View Department', 'view-department', NULL, NULL),
(14, 'Add New Department', 'add-new-department', NULL, NULL),
(15, 'Edit Department', 'edit-department', NULL, NULL),
(16, 'Disable Department', 'disable-department', NULL, NULL),
(17, 'Delete Department', 'delete-department', NULL, NULL),
(18, 'Enable Department', 'enable-department', NULL, NULL),
(19, 'Restore Department', 'restore-department', NULL, NULL),
(20, 'Purge Department', 'purge-department', NULL, NULL),
(21, 'View User', 'view-user', NULL, NULL),
(22, 'Add New User', 'add-new-user', NULL, NULL),
(23, 'Edit User', 'edit-user', NULL, NULL),
(24, 'Reset User Password', 'reset-user-password', NULL, NULL),
(25, 'Disable User', 'disable-user', NULL, NULL),
(26, 'Delete User', 'delete-user', NULL, NULL),
(27, 'Enable User', 'enable-user', NULL, NULL),
(28, 'Restore User', 'restore-user', NULL, NULL),
(29, 'Purge User', 'purge-user', NULL, NULL),
(30, 'View Course', 'view-course', NULL, NULL),
(31, 'Add New Course', 'add-new-course', NULL, NULL),
(32, 'Edit Course', 'edit-course', NULL, NULL),
(33, 'Disable Course', 'disable-course', NULL, NULL),
(34, 'Delete Course', 'delete-course', NULL, NULL),
(35, 'Enable Course', 'enable-course', NULL, NULL),
(36, 'Restore Course', 'restore-course', NULL, NULL),
(37, 'Purge Course', 'purge-course', NULL, NULL),
(38, 'View Subject', 'view-subject', NULL, NULL),
(39, 'Add New Subject', 'add-new-subject', NULL, NULL),
(40, 'Edit Subject', 'edit-subject', NULL, NULL),
(41, 'Disable Subject', 'disable-subject', NULL, NULL),
(42, 'Delete Subject', 'delete-subject', NULL, NULL),
(43, 'Enable Subject', 'enable-subject', NULL, NULL),
(44, 'Restore Subject', 'restore-subject', NULL, NULL),
(45, 'Purge Subject', 'purge-subject', NULL, NULL),
(46, 'View Section', 'view-section', NULL, NULL),
(47, 'Add New Section', 'add-new-section', NULL, NULL),
(48, 'Edit Section', 'edit-section', NULL, NULL),
(49, 'Disable Section', 'disable-section', NULL, NULL),
(50, 'Delete Section', 'delete-section', NULL, NULL),
(51, 'Enable Section', 'enable-section', NULL, NULL),
(52, 'Restore Section', 'restore-section', NULL, NULL),
(53, 'Purge Section', 'purge-section', NULL, NULL),
(70, 'View Unit', 'view-unit', NULL, NULL),
(71, 'Add New Unit', 'add-new-unit', NULL, NULL),
(72, 'Edit Unit', 'edit-unit', NULL, NULL),
(73, 'Disable Unit', 'disable-unit', NULL, NULL),
(74, 'Delete Unit', 'delete-unit', NULL, NULL),
(75, 'Enable Unit', 'enable-unit', NULL, NULL),
(76, 'Restore Unit', 'restore-unit', NULL, NULL),
(77, 'Purge Unit', 'purge-unit', NULL, NULL),
(104, 'View Computer', 'view-computer', NULL, NULL),
(121, 'View Class', 'view-class', NULL, NULL),
(122, 'Add New Class', 'add-new-class', NULL, NULL),
(123, 'Edit Class', 'edit-class', NULL, NULL),
(124, 'Import Class', 'import-class', NULL, NULL),
(125, 'Clear Class', 'clear-class', NULL, NULL),
(126, 'Edit Class Seat Plan', 'edit-class-seat-plan', NULL, NULL),
(127, 'Finalize Class', 'finalize-class', NULL, NULL),
(128, 'Unfinalize Class', 'unfinalize-class', NULL, NULL),
(130, 'Print Class Seat Plan', 'print-class-seat-plan', NULL, NULL),
(131, 'Disable Class', 'disable-class', NULL, NULL),
(132, 'Delete Class', 'delete-class', NULL, NULL),
(133, 'Enable Class', 'enable-class', NULL, NULL),
(134, 'Restore Class', 'restore-class', NULL, NULL),
(135, 'Purge Class', 'purge-class', NULL, NULL),
(186, 'Add New Permission', 'add-permission', NULL, NULL),
(187, 'View Attendance', 'view-attendance', NULL, NULL),
(188, 'Add New Attendance', 'add-new-attendance', NULL, NULL),
(193, 'Import User', 'import-user', NULL, NULL),
(194, 'Edit Attendance', 'edit-attendance', NULL, NULL),
(195, 'Delete Attendance', 'delete-attendance', NULL, NULL),
(196, 'View Class List', 'view-classlist', NULL, NULL),
(197, 'Add New Class List', 'add-new-classlist', NULL, NULL),
(198, 'Edit Class List', 'edit-classlist', NULL, NULL),
(199, 'Delete Class List', 'delete-classlist', NULL, NULL),
(200, 'Import Class List', 'import-classlist', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `umg_roles`
--

CREATE TABLE IF NOT EXISTS `umg_roles` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_roles`
--

INSERT INTO `umg_roles` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Administrator', 'System Administrator', NULL, NULL, '2017-11-10 21:09:00', 1, NULL, NULL, NULL, NULL),
(2, 'Faculty', 'Professors', NULL, NULL, '2017-11-04 15:39:27', 1, NULL, NULL, NULL, NULL),
(3, 'College Coordinator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Checker', 'House office staff', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Student', NULL, NULL, NULL, '2017-10-10 10:28:42', 1, NULL, NULL, NULL, NULL),
(6, 'Test', 'test', '2017-10-14 01:16:01', 1, NULL, NULL, NULL, NULL, '2017-10-14 10:01:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `umg_roles_permissions`
--

CREATE TABLE IF NOT EXISTS `umg_roles_permissions` (
`id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `permission_id` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3292 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_roles_permissions`
--

INSERT INTO `umg_roles_permissions` (`id`, `role_id`, `permission_id`) VALUES
(381, 15, 1),
(1680, 5, 184),
(1681, 6, 184),
(1682, 6, 182),
(1683, 6, 181),
(1684, 6, 180),
(1685, 6, 179),
(1686, 6, 178),
(1687, 6, 177),
(1688, 6, 176),
(1689, 6, 175),
(1690, 6, 174),
(1691, 6, 173),
(1692, 6, 172),
(1693, 6, 171),
(1694, 6, 170),
(1695, 6, 169),
(1696, 6, 168),
(1697, 6, 167),
(1698, 6, 166),
(1699, 6, 165),
(1700, 6, 164),
(1701, 6, 163),
(1702, 6, 162),
(1703, 6, 161),
(1704, 6, 160),
(1705, 6, 159),
(1706, 6, 158),
(1707, 6, 157),
(1708, 6, 156),
(1709, 6, 155),
(1710, 6, 154),
(1711, 6, 153),
(1712, 6, 152),
(1713, 6, 151),
(1714, 6, 150),
(1715, 6, 149),
(1716, 6, 148),
(1717, 6, 147),
(1718, 6, 146),
(1719, 6, 145),
(1720, 6, 144),
(1721, 6, 143),
(1722, 6, 142),
(1723, 6, 141),
(1724, 6, 140),
(1725, 6, 139),
(1726, 6, 138),
(1727, 6, 137),
(1728, 6, 136),
(1729, 6, 135),
(1730, 6, 134),
(1731, 6, 133),
(1732, 6, 132),
(1733, 6, 131),
(1734, 6, 130),
(1735, 6, 129),
(1736, 6, 128),
(1737, 6, 127),
(1738, 6, 126),
(1739, 6, 125),
(1740, 6, 124),
(1741, 6, 123),
(1742, 6, 122),
(1743, 6, 121),
(1744, 6, 120),
(1745, 6, 119),
(1746, 6, 118),
(1747, 6, 117),
(1748, 6, 116),
(1749, 6, 115),
(1750, 6, 114),
(1751, 6, 113),
(1752, 6, 112),
(1753, 6, 111),
(1754, 6, 110),
(1755, 6, 109),
(1756, 6, 108),
(1757, 6, 107),
(1758, 6, 106),
(1759, 6, 105),
(1760, 6, 104),
(1761, 6, 103),
(1762, 6, 102),
(1763, 6, 101),
(1764, 6, 100),
(1765, 6, 99),
(1766, 6, 98),
(1767, 6, 97),
(1768, 6, 96),
(1769, 6, 95),
(1770, 6, 94),
(1771, 6, 93),
(1772, 6, 92),
(1773, 6, 91),
(1774, 6, 90),
(1775, 6, 89),
(1776, 6, 88),
(1777, 6, 87),
(1778, 6, 86),
(1779, 6, 85),
(1780, 6, 84),
(1781, 6, 83),
(1782, 6, 82),
(1783, 6, 81),
(1784, 6, 80),
(1785, 6, 79),
(1786, 6, 78),
(1787, 6, 77),
(1788, 6, 76),
(1789, 6, 75),
(1790, 6, 74),
(1791, 6, 73),
(1792, 6, 72),
(1793, 6, 71),
(1794, 6, 70),
(1795, 6, 69),
(1796, 6, 68),
(1797, 6, 67),
(1798, 6, 66),
(1799, 6, 65),
(1800, 6, 64),
(1801, 6, 63),
(1802, 6, 62),
(1803, 6, 61),
(1804, 6, 60),
(1805, 6, 59),
(1806, 6, 58),
(1807, 6, 57),
(1808, 6, 56),
(1809, 6, 55),
(1810, 6, 54),
(1811, 6, 53),
(1812, 6, 52),
(1813, 6, 51),
(1814, 6, 50),
(1815, 6, 49),
(1816, 6, 48),
(1817, 6, 47),
(1818, 6, 46),
(1819, 6, 45),
(1820, 6, 44),
(1821, 6, 43),
(1822, 6, 42),
(1823, 6, 41),
(1824, 6, 40),
(1825, 6, 39),
(1826, 6, 38),
(1827, 6, 37),
(1828, 6, 36),
(1829, 6, 35),
(1830, 6, 34),
(1831, 6, 33),
(1832, 6, 32),
(1833, 6, 31),
(1834, 6, 30),
(1835, 6, 29),
(1836, 6, 28),
(1837, 6, 27),
(1838, 6, 26),
(1839, 6, 25),
(1840, 6, 24),
(1841, 6, 23),
(1842, 6, 22),
(1843, 6, 21),
(1844, 6, 20),
(1845, 6, 19),
(1846, 6, 18),
(1847, 6, 17),
(1848, 6, 16),
(1849, 6, 15),
(1850, 6, 14),
(1851, 6, 13),
(1852, 6, 12),
(1853, 6, 11),
(1854, 6, 10),
(1855, 6, 9),
(1856, 6, 8),
(1857, 6, 7),
(1858, 6, 6),
(1859, 6, 5),
(1860, 6, 4),
(1861, 6, 3),
(1862, 6, 2),
(1863, 6, 1),
(3197, 2, 45),
(3198, 2, 44),
(3199, 2, 43),
(3200, 2, 42),
(3201, 2, 41),
(3202, 2, 40),
(3203, 2, 39),
(3204, 2, 38),
(3205, 1, 200),
(3206, 1, 199),
(3207, 1, 198),
(3208, 1, 197),
(3209, 1, 196),
(3210, 1, 195),
(3211, 1, 194),
(3212, 1, 193),
(3213, 1, 188),
(3214, 1, 187),
(3215, 1, 186),
(3216, 1, 135),
(3217, 1, 134),
(3218, 1, 133),
(3219, 1, 132),
(3220, 1, 131),
(3221, 1, 130),
(3222, 1, 128),
(3223, 1, 127),
(3224, 1, 126),
(3225, 1, 125),
(3226, 1, 124),
(3227, 1, 123),
(3228, 1, 122),
(3229, 1, 121),
(3230, 1, 104),
(3231, 1, 77),
(3232, 1, 76),
(3233, 1, 75),
(3234, 1, 74),
(3235, 1, 73),
(3236, 1, 72),
(3237, 1, 71),
(3238, 1, 70),
(3239, 1, 53),
(3240, 1, 52),
(3241, 1, 51),
(3242, 1, 50),
(3243, 1, 49),
(3244, 1, 48),
(3245, 1, 47),
(3246, 1, 46),
(3247, 1, 45),
(3248, 1, 44),
(3249, 1, 43),
(3250, 1, 42),
(3251, 1, 41),
(3252, 1, 40),
(3253, 1, 39),
(3254, 1, 38),
(3255, 1, 37),
(3256, 1, 36),
(3257, 1, 35),
(3258, 1, 34),
(3259, 1, 33),
(3260, 1, 32),
(3261, 1, 31),
(3262, 1, 30),
(3263, 1, 29),
(3264, 1, 28),
(3265, 1, 27),
(3266, 1, 26),
(3267, 1, 25),
(3268, 1, 24),
(3269, 1, 23),
(3270, 1, 22),
(3271, 1, 21),
(3272, 1, 20),
(3273, 1, 19),
(3274, 1, 18),
(3275, 1, 17),
(3276, 1, 16),
(3277, 1, 15),
(3278, 1, 14),
(3279, 1, 13),
(3280, 1, 12),
(3281, 1, 11),
(3282, 1, 10),
(3283, 1, 9),
(3284, 1, 8),
(3285, 1, 7),
(3286, 1, 6),
(3287, 1, 5),
(3288, 1, 4),
(3289, 1, 3),
(3290, 1, 2),
(3291, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `umg_users`
--

CREATE TABLE IF NOT EXISTS `umg_users` (
`id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `gender_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `disabled_at` datetime DEFAULT NULL,
  `disabled_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_users`
--

INSERT INTO `umg_users` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `birthdate`, `gender_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disabled_at`, `disabled_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'administrator', '$2y$10$ZZpVBqc8lh/0n.BHyYvVC.y8PAOnMzVqe5Vza0yRRD/kEqaJGqzne', 'System', NULL, 'Administrator', '2017-08-28', 1, '2017-07-22 03:55:15', 1, '2017-10-28 01:36:08', 1, NULL, NULL, NULL, NULL),
(29, 'vince', '$2y$10$ZZpVBqc8lh/0n.BHyYvVC.y8PAOnMzVqe5Vza0yRRD/kEqaJGqzne', 'vince', NULL, 'vince', NULL, NULL, NULL, NULL, '2017-10-10 10:28:03', 1, NULL, NULL, '2017-10-21 14:21:02', 1),
(30, 'herchel.aquines', '$2y$10$ZZpVBqc8lh/0n.BHyYvVC.y8PAOnMzVqe5Vza0yRRD/kEqaJGqzne', 'Herchel', NULL, 'Aquines', NULL, NULL, '2017-10-10 13:10:48', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'Prof', '$2y$10$56F9UnXioDF2/4fjtbsmy.okP6ByX7lahdJLlur5kBOdO4//vXT9G', 'Professor', NULL, 'X', NULL, 1, '2017-10-14 09:09:46', 1, '2017-10-28 14:13:23', 1, NULL, NULL, NULL, NULL),
(213, 'test', '1234', 'tae', NULL, 'tae', NULL, 1, '2017-10-21 14:22:17', 1, '2017-10-21 14:23:09', 1, NULL, NULL, NULL, NULL),
(214, '2014-03087', '12345', 'Reymar', NULL, 'Crudo', '1996-10-05', 1, '2017-10-27 18:01:40', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(256, '2015-2-00026', '$2y$10$TGtzCc9JhpdkK9PbJYMz2.KM0hm1I3V.2B8CQ.K.KtLiG5HHfgTNq', ' Cyrine Perez', NULL, 'Alagao', NULL, NULL, '2017-10-28 14:10:19', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(257, '2015-2-01637', '$2y$10$HHLlEpdLb.CMLyxtU0B1buOCm8yyR983nPLDfIq1WIHs/ek3rB65K', ' Johanna Marie Santos', NULL, 'Amodente', NULL, NULL, '2017-10-28 14:10:20', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(258, '2014-01122', '$2y$10$Ou7UJtSceuOz0Fgj8//DUO6i/PhswNr/1ryWHgGFTZBPUdTNkX2D2', ' Luis Emmanuel  Granada', NULL, 'Basa', NULL, NULL, '2017-10-28 14:10:20', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(259, '2015-2-00049', '$2y$10$LZPKNXeg21iyF04dIqjsSOTAWI/9dgn5Bu89OAH2ix3HdFOktgwo6', ' Shahana Socoro Angcao', NULL, 'Bay', NULL, NULL, '2017-10-28 14:10:20', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(260, '2015-2-00237', '$2y$10$mU/WYDAW6ZEE.mxiviq6/uLjBFOT1F9O/ZjYtXF.cUN1SL6ggjlc.', ' Queenleth Riego De Dios', NULL, 'Bello', NULL, NULL, '2017-10-28 14:10:20', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(261, '2015-2-02024', '$2y$10$.WqzsvOdjZwsYhpi8OzfiOYY4./AjIwZyxLEBhIcmyhcHMTYStcRy', ' Ralph Jhayson ', NULL, 'Bulda', NULL, NULL, '2017-10-28 14:10:21', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(262, '2015-2-00055', '$2y$10$6L1p2pfKzl.pXTHWD4XW4OQYTMA0FrtgO0Wr3ODi9OSCeiRc97W5y', ' Donnie Rose  Casillano', NULL, 'Bumagat', NULL, NULL, '2017-10-28 14:10:21', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(263, '2015-2-00307', '$2y$10$PfVb4ylpp.9XFhyrvswTsO3yTt8ZI8F1vGOM6KI6buB3Dc78XkPUi', ' Faustine Xandel  Bendo', NULL, 'Caba??a', NULL, NULL, '2017-10-28 14:10:21', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(264, '2014-00903', '$2y$10$zESFF4jHj5kXNjXXPGWVMeo9Tevbv8.KOJ.TN2Oxg/zp96pQrkd9q', ' Lanze Angue', NULL, 'Caguiat', NULL, NULL, '2017-10-28 14:10:21', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(265, '2015-2-00144', '$2y$10$cq/trbi0PCMU99CXqk/t3ezBIfIuvDD5EBZd.RGKRpUEjIRYHyE/C', ' Zarrah Khalifa Ison', NULL, 'Cordova', NULL, NULL, '2017-10-28 14:10:22', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(266, '2015-2-01738', '$2y$10$GAzZ3O1Kqw.s4PUEDyHPSu.FjJnSOrt8ZcZwn3Y.Agnx1hygZonZe', ' Kristin Parcon', NULL, 'Damaso', NULL, NULL, '2017-10-28 14:10:22', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(267, '2015-2-00303', '$2y$10$e43OksjTCEEfoR9NGAZ1MOONyJ91jg1qDNasodVu56iDSW897MhZ.', ' Remel Generillo', NULL, 'Del Rosario', NULL, NULL, '2017-10-28 14:10:22', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(268, '2015-2-00863', '$2y$10$RjofNzSr.lgF.Et7gth27Oo8wqIxJbfbjHr9ptxtkMH5HHA5TFzT.', ' Carmela Yasmin Miciano', NULL, 'Dimapilis', NULL, NULL, '2017-10-28 14:10:22', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(269, '2015-2-01567', '$2y$10$ImB7ApwTCqE.Tz5bB.JQCutcszpsioMyX9OLoK6D1cSg8YJHWAgDq', ' Ladynel Pancho', NULL, 'Dimaunahan', NULL, NULL, '2017-10-28 14:10:23', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(270, '2015-2-00620', '$2y$10$M4r1kw3zpsXEJxMQ6F8TmeVHywGrCQRXqHr33EAkWnqTNRoYN3jjy', ' Shaira Mae Punzalan', NULL, 'Dumalasa', NULL, NULL, '2017-10-28 14:10:23', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(271, '2015-2-00199', '$2y$10$Jjivz9XSct30f3FJrNT02OiGC9TCJ044AISLJgRYeUErzYAg6.rje', ' Joanna Mae Argete', NULL, 'Escalante', NULL, NULL, '2017-10-28 14:10:23', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(272, '2015-2-00524', '$2y$10$W4XlrLM53So4IqsKsaVqQu707KaYmzCYdMfxO7QkbJSQDun4djf8q', ' Wilfredo Jr Patricio', NULL, 'Espinosa', NULL, NULL, '2017-10-28 14:10:24', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(273, '2016-2-01917', '$2y$10$DzmL0W/nqkAzZ0tYqyB3lOHzVr/QkSEddyZ.jZJcJrHE4Ckz6dCTK', ' Mirriam Alopoop', NULL, 'Flores', NULL, NULL, '2017-10-28 14:10:24', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(274, '2014-00334', '$2y$10$OifGwJEi5tUyx0760a.YvOtTqlmXqEBC4mujBTrc59CtoS2JZK6NC', ' Maricar Sanpablo', NULL, 'Ilagan', NULL, NULL, '2017-10-28 14:10:24', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(275, '2015-2-00441', '$2y$10$kNT3HGvme8UxpcRpu4ttaeJ/VMxoBZV/d/zszlmxtPEgjGrCmnYZq', ' Louie Jay  Dacudag', NULL, 'Kailing', NULL, NULL, '2017-10-28 14:10:24', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(276, '2015-2-00234', '$2y$10$JdgVtw3rnU7OXA.Y4SgYvuJ5KksGtFn3SXLkLu4sbY3mOFLppSGDu', ' Clarrise Mae Madlangbayan', NULL, 'Labiran', NULL, NULL, '2017-10-28 14:10:25', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(277, '2015-2-00204', '$2y$10$BjbQ7TM7LiFnxE12yC5VjOg818IwFG1Do.8KYnPrVxeIZ1nA7I0M6', ' Princess Sampilo', NULL, 'Lales', NULL, NULL, '2017-10-28 14:10:25', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(278, '2015-2-00132', '$2y$10$TRknHVRzq4AKQ5LRe.41Y.7DQk.ZLUPdXNgrwHoe0jwrbW1D6NYBm', ' Lisa Marie De Luna', NULL, 'Lozada', NULL, NULL, '2017-10-28 14:10:25', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(279, '2015-2-01426', '$2y$10$lF/gesD81vNvJRYFw7Lwsu4EgfDLkr0kMNgYWnG8grdOQbh99wZcC', ' Jaszha Eunice Blan', NULL, 'Lubang', NULL, NULL, '2017-10-28 14:10:25', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(280, '2014-00255', '$2y$10$kjWTvYX2rFV7XN2a6YQpDeabhjW1BvHOKJpSKyPPwslChViFMukda', ' Emielyn Duane ', NULL, 'Lumandog', NULL, NULL, '2017-10-28 14:10:25', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(281, '2015-2-00185', '$2y$10$cp4URhRmrTSZebyaKoivmu0RgGMf9IFVPJ.tPYSrPaCNeF.52ExjK', ' Nicole Mikaela  Mayor', NULL, 'Matias', NULL, NULL, '2017-10-28 14:10:26', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(282, '2015-2-00101', '$2y$10$s6r4Pbmjx/pLriH4NNI1y.IGVRQd3K9DMlsIUk9xSvai2PeYjdb8.', ' Jessallie Hernandez', NULL, 'Morena', NULL, NULL, '2017-10-28 14:10:26', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(283, '2015-2-00549', '$2y$10$JK2hKOV4eq4tAKNsmqMpEu9aWbG1Yq5dn8brPAz9RsO/dAgCVQ3ny', ' Ma. Patricia Nicole Bolivar', NULL, 'Navarette', NULL, NULL, '2017-10-28 14:10:26', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(284, '2015-2-00186', '$2y$10$cCxKsV3WyY./Dl8vnLeDGOE9X6tP2Ths0c6ILkAbSWGtImXmo91gS', ' Jazmine Rose Delos Reyes', NULL, 'Pacheco', NULL, NULL, '2017-10-28 14:10:26', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(285, '2015-2-00316', '$2y$10$MQ9PAhipcnkaWainCxJqm.D/H/wfufWLUY44hobhxdlN83QoR6vNy', ' Mark Francis Dequit', NULL, 'Pardilla', NULL, NULL, '2017-10-28 14:10:26', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(286, '2015-2-03088', '$2y$10$v2STu5uwSypBn8xOGMaEl.lEzoZ9tFlVBHcRvChfY9Q.rsVWfm.Ma', ' Nikka Villacruzes', NULL, 'Paulite', NULL, NULL, '2017-10-28 14:10:27', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(287, '2015-2-00200', '$2y$10$yYa8RWySfM4GSrd3oFI5leq7.hUoety19yslwMbA7m.dl.UIK35iC', ' Franchesca Izzabelle Dela Cruz ', NULL, 'Ramirez', NULL, NULL, '2017-10-28 14:10:27', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(288, '2015-2-01282', '$2y$10$xiK98cD05iQmxlOpj4xmG.NmXLzluE1HWyybrX/2L8xudUEMqdwte', ' Jamaeca Lei Paredes', NULL, 'Ramos', NULL, NULL, '2017-10-28 14:10:27', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(289, '2015-2-00540', '$2y$10$gT2WBZW2JIgdgJD.WN/JN.WPz6k6XFTUHhxvPWcHm6HgROwoi85T.', ' Angelica Russane Cajiles', NULL, 'Rillera', NULL, NULL, '2017-10-28 14:10:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(290, '2015-2-00222', '$2y$10$i0CbBY8KJeXBrP30BcqgSem/g5.fxXHQP/qIZura/xwXvTxHEq.H2', ' Catherine Conde', NULL, 'Sajol', NULL, NULL, '2017-10-28 14:10:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(291, '2015-2-01723', '$2y$10$EmYT1u0/Kgr8n9i58pB1ZuMeLGJEXu/.MIk4C1.qMAO.lg7TMK.pW', ' Samantha Joyce Abando', NULL, 'Salcedo', NULL, NULL, '2017-10-28 14:10:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(292, '2015-2-03173', '$2y$10$pID0AUw/TtY2.e/F5.1K4uybHdMwuSzW5oem0SGS2Aiq5OhQ76Kzq', ' Geofrey Eser', NULL, 'Saulog', NULL, NULL, '2017-10-28 14:10:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(293, '2015-2-00817', '$2y$10$cccL5B9N7E5g84Bo8MxebeAgTQdR1WNLkWpELX3HyeQhUokN0c9ni', ' Kathlyn Manahan', NULL, 'Torrea', NULL, NULL, '2017-10-28 14:10:28', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(294, '2015-2-01405', '$2y$10$ciFcfyc6GVLQlR0F13phweKj/uUi.z03djWHFdG2GbCo8mbgztenW', ' Elaiza Caballes', NULL, 'Urmeneta', NULL, NULL, '2017-10-28 14:10:29', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(295, '2015-2-01328', '$2y$10$tJKOVd.vXHYHOWSf47cZROQrDvxfp3msRySZPQU5Xg2MahEb8s1ii', ' Cyra Joyce Obsuna', NULL, 'Valenciano', NULL, NULL, '2017-10-28 14:10:29', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(296, '2015-2-01739', '$2y$10$8SDObduf3pUIsZsV9ZBTxehWGWegx0jmRo00gMDYYylPr3xgVLdyS', ' Jasmine Aizel Alvarez', NULL, 'Vivar', NULL, NULL, '2017-10-28 14:10:30', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `umg_users_activities`
--

CREATE TABLE IF NOT EXISTS `umg_users_activities` (
`id` int(10) NOT NULL,
  `details` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_users_activities`
--

INSERT INTO `umg_users_activities` (`id`, `details`, `created_at`, `created_by`) VALUES
(1, 'Attempted to log in at <i>July 16, 2017 19:16:33 PM</i> and was successful.', '2017-07-16 19:16:33', 1),
(2, 'Attempted to log in at <i>July 17, 2017 19:08:55 PM</i> and was successful.', '2017-07-17 19:08:56', 1),
(3, 'Attempted to log in at <i>July 18, 2017 07:21:52 AM</i> and was successful.', '2017-07-18 07:21:52', 1),
(4, 'Attempted to log in at <i>July 18, 2017 18:11:13 PM</i> and was successful.', '2017-07-18 18:11:13', 1),
(5, 'Attempted to log in at <i>July 19, 2017 06:34:23 AM</i> and was successful.', '2017-07-19 06:34:23', 1),
(6, 'Attempted to log out at <i>July 19, 2017 08:24:25 AM</i> and was successful.', '2017-07-19 08:24:25', 1),
(7, 'Attempted to log in at <i>July 19, 2017 08:24:35 AM</i> and was successful.', '2017-07-19 08:24:35', 1),
(8, 'Attempted to log out at <i>July 19, 2017 10:34:21 AM</i> and was successful.', '2017-07-19 10:34:21', 1),
(9, 'Attempted to log in at <i>July 19, 2017 10:42:40 AM</i> and was successful.', '2017-07-19 10:42:40', 1),
(10, 'Attempted to log in at <i>July 19, 2017 12:58:40 PM</i> and was successful.', '2017-07-19 12:58:40', 1),
(11, 'Attempted to log in at <i>July 19, 2017 16:17:52 PM</i> and was successful.', '2017-07-19 16:17:52', 1),
(12, 'Attempted to log in at <i>July 20, 2017 07:03:04 AM</i> and was successful.', '2017-07-20 07:03:04', 1),
(13, 'Attempted to log out at <i>July 20, 2017 09:42:35 AM</i> and was successful.', '2017-07-20 09:42:35', 1),
(14, 'Attempted to log in at <i>July 20, 2017 10:43:10 AM</i> and was successful.', '2017-07-20 10:43:10', 1),
(15, 'Attempted to log in at <i>July 20, 2017 13:23:06 PM</i> and was successful.', '2017-07-20 13:23:06', 1),
(16, 'Attempted to log in at <i>July 20, 2017 19:55:23 PM</i> and was successful.', '2017-07-20 19:55:23', 1),
(17, 'Attempted to log in at <i>July 22, 2017 02:37:17 AM</i> and was successful.', '2017-07-22 02:37:18', 1),
(18, 'Attempted to log in at <i>July 22, 2017 06:56:15 AM</i> and was successful.', '2017-07-22 06:56:15', 1),
(19, 'Attempted to log in at <i>July 22, 2017 13:37:23 PM</i> and was successful.', '2017-07-22 13:37:25', 1),
(20, 'Attempted to log out at <i>July 22, 2017 19:19:48 PM</i> and was successful.', '2017-07-22 19:19:48', 1),
(21, 'Attempted to log in at <i>July 22, 2017 19:19:54 PM</i> and was successful.', '2017-07-22 19:19:54', 1),
(22, 'Attempted to log out at <i>July 22, 2017 20:00:03 PM</i> and was successful.', '2017-07-22 20:00:03', 1),
(23, 'Attempted to log in at <i>July 22, 2017 20:00:10 PM</i> and was successful.', '2017-07-22 20:00:10', 1),
(24, 'Attempted to log in at <i>July 23, 2017 04:35:10 AM</i> and was successful.', '2017-07-23 04:35:10', 1),
(25, 'Attempted to log in at <i>July 23, 2017 08:16:12 AM</i> and was successful.', '2017-07-23 08:16:12', 1),
(26, 'Attempted to log in at <i>July 23, 2017 09:31:57 AM</i> and was successful.', '2017-07-23 09:31:57', 1),
(27, 'Attempted to log in at <i>July 23, 2017 15:14:45 PM</i> and was successful.', '2017-07-23 15:14:45', 1),
(28, 'Attempted to log in at <i>July 24, 2017 06:53:11 AM</i> and was successful.', '2017-07-24 06:53:11', 1),
(29, 'Attempted to log out at <i>July 24, 2017 07:11:09 AM</i> and was successful.', '2017-07-24 07:11:09', 1),
(30, 'Attempted to log in at <i>July 24, 2017 07:12:15 AM</i> and was successful.', '2017-07-24 07:12:15', 1),
(31, 'Attempted to log in at <i>July 24, 2017 09:13:56 AM</i> and was successful.', '2017-07-24 09:13:56', 1),
(32, 'Attempted to log in at <i>July 24, 2017 12:48:48 PM</i> and was successful.', '2017-07-24 12:48:48', 1),
(33, 'Attempted to log in at <i>July 24, 2017 17:22:24 PM</i> and was successful.', '2017-07-24 17:22:24', 1),
(34, 'Attempted to log in at <i>July 25, 2017 06:52:11 AM</i> and was successful.', '2017-07-25 06:52:11', 1),
(35, 'Attempted to log in at <i>July 25, 2017 15:41:17 PM</i> and was successful.', '2017-07-25 15:41:17', 1),
(36, 'Attempted to log out at <i>July 25, 2017 15:44:45 PM</i> and was successful.', '2017-07-25 15:44:45', 1),
(37, 'Attempted to log in at <i>July 26, 2017 08:29:23 AM</i> and was successful.', '2017-07-26 08:29:23', 1),
(38, 'Attempted to log in at <i>July 26, 2017 17:57:45 PM</i> and was successful.', '2017-07-26 17:57:45', 1),
(39, 'Attempted to log in at <i>July 26, 2017 21:00:30 PM</i> and was successful.', '2017-07-26 21:00:30', 1),
(40, 'Attempted to log in at <i>July 27, 2017 18:17:47 PM</i> and was successful.', '2017-07-27 18:17:48', 1),
(41, 'Attempted to log out at <i>July 27, 2017 18:18:01 PM</i> and was successful.', '2017-07-27 18:18:01', 1),
(42, 'Attempted to log in at <i>July 27, 2017 18:18:25 PM</i> and was successful.', '2017-07-27 18:18:25', 1),
(43, 'Attempted to log in at <i>July 28, 2017 06:16:35 AM</i> and was successful.', '2017-07-28 06:16:35', 1),
(44, 'Attempted to log in at <i>July 28, 2017 10:17:33 AM</i> and was successful.', '2017-07-28 10:17:33', 1),
(45, 'Attempted to log in at <i>July 28, 2017 10:19:31 AM</i> and was successful.', '2017-07-28 10:19:31', 1),
(46, 'Attempted to log in at <i>July 28, 2017 11:28:03 AM</i> and was successful.', '2017-07-28 11:28:04', 1),
(47, 'Attempted to log out at <i>July 28, 2017 12:50:04 PM</i> and was successful.', '2017-07-28 12:50:04', 1),
(48, 'Attempted to log in at <i>July 28, 2017 12:52:25 PM</i> and was successful.', '2017-07-28 12:52:25', 1),
(49, 'Attempted to log in at <i>July 28, 2017 20:27:39 PM</i> and was successful.', '2017-07-28 20:27:39', 1),
(50, 'Attempted to log in at <i>July 29, 2017 13:33:10 PM</i> and was successful.', '2017-07-29 13:33:10', 1),
(51, 'Attempted to log in at <i>July 30, 2017 03:38:28 AM</i> and was successful.', '2017-07-30 03:38:28', 1),
(52, 'Attempted to log in at <i>July 30, 2017 12:38:47 PM</i> and was successful.', '2017-07-30 12:38:47', 1),
(53, 'Attempted to log in at <i>July 30, 2017 15:53:11 PM</i> and was successful.', '2017-07-30 15:53:11', 1),
(54, 'Attempted to log out at <i>July 30, 2017 16:11:08 PM</i> and was successful.', '2017-07-30 16:11:08', 1),
(55, 'Attempted to log in at <i>July 30, 2017 16:11:21 PM</i> and was successful.', '2017-07-30 16:11:21', 1),
(56, 'Attempted to log in at <i>July 31, 2017 04:32:54 AM</i> and was successful.', '2017-07-31 04:32:54', 1),
(57, 'Attempted to log in at <i>July 31, 2017 07:28:07 AM</i> and was successful.', '2017-07-31 07:28:07', 1),
(58, 'Attempted to log in at <i>August 01, 2017 06:58:57 AM</i> and was successful.', '2017-08-01 06:58:57', 1),
(59, 'Attempted to log in at <i>August 02, 2017 06:47:22 AM</i> and was successful.', '2017-08-02 06:47:22', 1),
(60, 'Attempted to log in at <i>August 03, 2017 06:49:49 AM</i> and was successful.', '2017-08-03 06:49:49', 1),
(61, 'Attempted to log in at <i>August 03, 2017 12:50:55 PM</i> and was successful.', '2017-08-03 12:50:55', 1),
(62, 'Attempted to log in at <i>August 04, 2017 06:27:41 AM</i> and was successful.', '2017-08-04 06:27:41', 1),
(63, 'Attempted to log in at <i>August 05, 2017 06:51:33 AM</i> and was successful.', '2017-08-05 06:51:33', 1),
(64, 'Attempted to log in at <i>August 05, 2017 16:25:32 PM</i> and was successful.', '2017-08-05 16:25:32', 1),
(65, 'Attempted to log in at <i>August 06, 2017 16:35:19 PM</i> and was successful.', '2017-08-06 16:35:19', 1),
(66, 'Attempted to log in at <i>August 07, 2017 07:22:04 AM</i> and was successful.', '2017-08-07 07:22:04', 1),
(67, 'Attempted to log in at <i>August 08, 2017 07:06:28 AM</i> and was successful.', '2017-08-08 07:06:28', 1),
(68, 'Attempted to log in at <i>August 08, 2017 14:41:39 PM</i> and was successful.', '2017-08-08 14:41:39', 1),
(69, 'Attempted to log in at <i>August 10, 2017 14:39:43 PM</i> and was successful.', '2017-08-10 14:39:43', 1),
(70, 'Attempted to log out at <i>August 10, 2017 14:40:18 PM</i> and was successful.', '2017-08-10 14:40:18', 1),
(71, 'Attempted to log in at <i>August 12, 2017 08:36:03 AM</i> and was successful.', '2017-08-12 08:36:03', 1),
(72, 'Attempted to log in at <i>August 12, 2017 08:53:39 AM</i> and was successful.', '2017-08-12 08:53:39', 1),
(73, 'Attempted to log in at <i>August 14, 2017 13:17:56 PM</i> and was successful.', '2017-08-14 13:17:56', 1),
(74, 'Attempted to log in at <i>August 16, 2017 06:55:43 AM</i> and was successful.', '2017-08-16 06:55:43', 1),
(75, 'Attempted to log in at <i>August 17, 2017 08:05:44 AM</i> and was successful.', '2017-08-17 08:05:44', 1),
(76, 'Attempted to log in at <i>August 18, 2017 13:46:55 PM</i> and was successful.', '2017-08-18 13:46:55', 1),
(77, 'Attempted to log out at <i>August 18, 2017 13:47:08 PM</i> and was successful.', '2017-08-18 13:47:08', 1),
(78, 'Attempted to log out at <i>August 18, 2017 13:47:21 PM</i> and was successful.', '2017-08-18 13:47:21', 1),
(79, 'Attempted to log in at <i>August 28, 2017 10:14:10 AM</i> and was successful.', '2017-08-28 10:14:10', 1),
(80, 'Attempted to log out at <i>August 28, 2017 10:14:16 AM</i> and was successful.', '2017-08-28 10:14:16', 1),
(81, 'Attempted to log in at <i>August 31, 2017 12:40:13 PM</i> and was successful.', '2017-08-31 12:40:13', 1),
(82, 'Attempted to log out at <i>August 31, 2017 12:42:34 PM</i> and was successful.', '2017-08-31 12:42:34', 1),
(83, 'Attempted to log in at <i>September 08, 2017 07:12:47 AM</i> and was successful.', '2017-09-08 07:12:47', 1),
(84, 'Attempted to log out at <i>September 08, 2017 10:26:58 AM</i> and was successful.', '2017-09-08 10:26:58', 1),
(85, 'Attempted to log in at <i>September 19, 2017 08:26:54 AM</i> and was successful.', '2017-09-19 08:26:54', 1),
(86, 'Attempted to log in at <i>October 04, 2017 15:16:03 PM</i> and was successful.', '2017-10-04 15:16:03', 1),
(87, 'Attempted to log in at <i>October 04, 2017 16:27:15 PM</i> and was successful.', '2017-10-04 16:27:15', 1),
(88, 'Attempted to log in at <i>October 06, 2017 10:47:56 AM</i> and was successful.', '2017-10-06 10:47:56', 1),
(89, 'Attempted to log out at <i>October 06, 2017 11:40:49 AM</i> and was successful.', '2017-10-06 11:40:49', 1),
(90, 'Attempted to log in at <i>October 06, 2017 11:40:52 AM</i> and was successful.', '2017-10-06 11:40:53', 1),
(91, 'Attempted to log in at <i>October 10, 2017 09:13:13 AM</i> and was successful.', '2017-10-10 09:13:16', 1),
(92, 'Attempted to log in at <i>October 10, 2017 10:06:08 AM</i> and was successful.', '2017-10-10 10:06:08', 1),
(93, 'Attempted to log out at <i>October 10, 2017 10:14:16 AM</i> and was successful.', '2017-10-10 10:14:16', 1),
(94, 'Attempted to log in at <i>October 10, 2017 10:14:28 AM</i> and was successful.', '2017-10-10 10:14:28', 1),
(95, 'Attempted to log out at <i>October 10, 2017 10:18:17 AM</i> and was successful.', '2017-10-10 10:18:17', 1),
(96, 'Attempted to log in at <i>October 10, 2017 10:20:22 AM</i> and was successful.', '2017-10-10 10:20:22', 29),
(97, 'Attempted to log out at <i>October 10, 2017 10:20:42 AM</i> and was successful.', '2017-10-10 10:20:42', 29),
(98, 'Attempted to log in at <i>October 10, 2017 10:26:43 AM</i> and was successful.', '2017-10-10 10:26:43', 29),
(99, 'Attempted to log in at <i>October 10, 2017 10:27:29 AM</i> and was successful.', '2017-10-10 10:27:29', 1),
(100, 'Attempted to log out at <i>October 10, 2017 15:50:32 PM</i> and was successful.', '2017-10-10 15:50:33', 1),
(101, 'Attempted to log in at <i>October 11, 2017 09:09:39 AM</i> and was successful.', '2017-10-11 09:09:39', 29),
(102, 'Attempted to log in at <i>October 11, 2017 09:10:39 AM</i> and was successful.', '2017-10-11 09:10:39', 1),
(103, 'Attempted to log out at <i>October 11, 2017 10:24:41 AM</i> and was successful.', '2017-10-11 10:24:41', 29),
(104, 'Attempted to log in at <i>October 11, 2017 14:36:47 PM</i> and was successful.', '2017-10-11 14:36:47', 29),
(105, 'Attempted to log out at <i>October 11, 2017 14:36:55 PM</i> and was successful.', '2017-10-11 14:36:55', 29),
(106, 'Attempted to log in at <i>October 11, 2017 14:37:01 PM</i> and was successful.', '2017-10-11 14:37:01', 1),
(107, 'Attempted to log in at <i>October 13, 2017 12:49:49 PM</i> and was successful.', '2017-10-13 12:49:49', 1),
(108, 'Attempted to log out at <i>October 13, 2017 12:50:01 PM</i> and was successful.', '2017-10-13 12:50:01', 1),
(109, 'Attempted to log in at <i>October 13, 2017 13:34:52 PM</i> and was successful.', '2017-10-13 13:34:52', 1),
(110, 'Attempted to log out at <i>October 13, 2017 13:49:24 PM</i> and was successful.', '2017-10-13 13:49:24', 1),
(111, 'Attempted to log in at <i>October 13, 2017 13:50:15 PM</i> and was successful.', '2017-10-13 13:50:15', 1),
(112, 'Attempted to log in at <i>October 13, 2017 23:58:03 PM</i> and was successful.', '2017-10-13 23:58:04', 1),
(113, 'Attempted to log out at <i>October 14, 2017 00:13:32 AM</i> and was successful.', '2017-10-14 00:13:32', 1),
(114, 'Attempted to log in at <i>October 14, 2017 00:18:24 AM</i> and was successful.', '2017-10-14 00:18:24', 1),
(115, 'Attempted to log out at <i>October 14, 2017 00:40:08 AM</i> and was successful.', '2017-10-14 00:40:09', 1),
(116, 'Attempted to log in at <i>October 14, 2017 00:40:12 AM</i> and was successful.', '2017-10-14 00:40:12', 1),
(117, 'Attempted to log out at <i>October 14, 2017 01:15:19 AM</i> and was successful.', '2017-10-14 01:15:19', 1),
(118, 'Attempted to log in at <i>October 14, 2017 01:15:21 AM</i> and was successful.', '2017-10-14 01:15:21', 1),
(119, 'Attempted to log in at <i>October 14, 2017 01:23:46 AM</i> and was successful.', '2017-10-14 01:23:46', 1),
(120, 'Attempted to log out at <i>October 14, 2017 01:30:32 AM</i> and was successful.', '2017-10-14 01:30:32', 1),
(121, 'Attempted to log in at <i>October 14, 2017 08:28:34 AM</i> and was successful.', '2017-10-14 08:28:34', 1),
(122, 'Attempted to log in at <i>October 14, 2017 08:50:45 AM</i> and was successful.', '2017-10-14 08:50:46', 1),
(123, 'Attempted to log out at <i>October 14, 2017 09:07:56 AM</i> and was successful.', '2017-10-14 09:07:56', 1),
(124, 'Attempted to log in at <i>October 14, 2017 09:08:04 AM</i> and was successful.', '2017-10-14 09:08:04', 29),
(125, 'Attempted to log out at <i>October 14, 2017 09:08:36 AM</i> and was successful.', '2017-10-14 09:08:36', 29),
(126, 'Attempted to log in at <i>October 14, 2017 09:08:43 AM</i> and was successful.', '2017-10-14 09:08:43', 1),
(127, 'Attempted to log out at <i>October 14, 2017 09:09:52 AM</i> and was successful.', '2017-10-14 09:09:52', 1),
(128, 'Attempted to log in at <i>October 14, 2017 09:10:16 AM</i> and was successful.', '2017-10-14 09:10:16', 1),
(129, 'Attempted to log out at <i>October 14, 2017 09:11:01 AM</i> and was successful.', '2017-10-14 09:11:01', 1),
(130, 'Attempted to log in at <i>October 14, 2017 09:11:08 AM</i> and was successful.', '2017-10-14 09:11:08', 31),
(131, 'Attempted to log out at <i>October 14, 2017 09:11:22 AM</i> and was successful.', '2017-10-14 09:11:22', 31),
(132, 'Attempted to log in at <i>October 14, 2017 09:11:25 AM</i> and was successful.', '2017-10-14 09:11:27', 31),
(133, 'Attempted to log out at <i>October 14, 2017 09:11:30 AM</i> and was successful.', '2017-10-14 09:11:30', 31),
(134, 'Attempted to log in at <i>October 14, 2017 09:11:34 AM</i> and was successful.', '2017-10-14 09:11:34', 1),
(135, 'Attempted to log out at <i>October 14, 2017 09:46:23 AM</i> and was successful.', '2017-10-14 09:46:23', 1),
(136, 'Attempted to log in at <i>October 14, 2017 09:46:29 AM</i> and was successful.', '2017-10-14 09:46:29', 1),
(137, 'Attempted to log out at <i>October 14, 2017 10:04:20 AM</i> and was successful.', '2017-10-14 10:04:20', 1),
(138, 'Attempted to log in at <i>October 14, 2017 10:04:25 AM</i> and was successful.', '2017-10-14 10:04:25', 1),
(139, 'Attempted to log in at <i>October 18, 2017 09:57:00 AM</i> and was successful.', '2017-10-18 09:57:00', 1),
(140, 'Attempted to log in at <i>October 18, 2017 21:17:44 PM</i> and was successful.', '2017-10-18 21:17:44', 1),
(141, 'Attempted to log in at <i>October 19, 2017 13:21:39 PM</i> and was successful.', '2017-10-19 13:21:41', 1),
(142, 'Attempted to log in at <i>October 19, 2017 15:46:52 PM</i> and was successful.', '2017-10-19 15:46:52', 1),
(143, 'Attempted to log in at <i>October 20, 2017 09:30:43 AM</i> and was successful.', '2017-10-20 09:30:46', 1),
(144, 'Attempted to log in at <i>October 20, 2017 22:23:45 PM</i> and was successful.', '2017-10-20 22:23:45', 1),
(145, 'Attempted to log out at <i>October 20, 2017 23:37:20 PM</i> and was successful.', '2017-10-20 23:37:20', 1),
(146, 'Attempted to log in at <i>October 20, 2017 23:37:22 PM</i> and was successful.', '2017-10-20 23:37:22', 1),
(147, 'Attempted to log out at <i>October 20, 2017 23:47:22 PM</i> and was successful.', '2017-10-20 23:47:23', 1),
(148, 'Attempted to log in at <i>October 20, 2017 23:47:25 PM</i> and was successful.', '2017-10-20 23:47:25', 1),
(149, 'Attempted to log in at <i>October 21, 2017 09:18:44 AM</i> and was successful.', '2017-10-21 09:18:44', 1),
(150, 'Attempted to log in at <i>October 21, 2017 11:57:00 AM</i> and was successful.', '2017-10-21 11:57:01', 1),
(151, 'Attempted to log out at <i>October 21, 2017 12:55:19 PM</i> and was successful.', '2017-10-21 12:55:20', 1),
(152, 'Attempted to log in at <i>October 21, 2017 13:04:51 PM</i> and was successful.', '2017-10-21 13:04:51', 1),
(153, 'Attempted to log out at <i>October 21, 2017 13:11:54 PM</i> and was successful.', '2017-10-21 13:11:54', 1),
(154, 'Attempted to log in at <i>October 21, 2017 13:24:11 PM</i> and was successful.', '2017-10-21 13:24:11', 1),
(155, 'Attempted to log out at <i>October 21, 2017 13:30:34 PM</i> and was successful.', '2017-10-21 13:30:34', 1),
(156, 'Attempted to log in at <i>October 21, 2017 13:39:31 PM</i> and was successful.', '2017-10-21 13:39:31', 1),
(157, 'Attempted to log out at <i>October 21, 2017 13:59:14 PM</i> and was successful.', '2017-10-21 13:59:14', 1),
(158, 'Attempted to log in at <i>October 21, 2017 14:00:14 PM</i> and was successful.', '2017-10-21 14:00:14', 1),
(159, 'Attempted to log out at <i>October 21, 2017 14:06:28 PM</i> and was successful.', '2017-10-21 14:06:28', 1),
(160, 'Attempted to log in at <i>October 21, 2017 14:06:31 PM</i> and was successful.', '2017-10-21 14:06:31', 1),
(161, 'Attempted to log out at <i>October 21, 2017 14:13:59 PM</i> and was successful.', '2017-10-21 14:14:00', 1),
(162, 'Attempted to log in at <i>October 21, 2017 14:14:36 PM</i> and was successful.', '2017-10-21 14:14:36', 1),
(163, 'Attempted to log out at <i>October 21, 2017 14:22:28 PM</i> and was successful.', '2017-10-21 14:22:28', 1),
(164, 'Attempted to log in at <i>October 21, 2017 14:22:54 PM</i> and was successful.', '2017-10-21 14:22:54', 1),
(165, 'Attempted to log out at <i>October 21, 2017 14:23:47 PM</i> and was successful.', '2017-10-21 14:23:47', 1),
(166, 'Attempted to log in at <i>October 21, 2017 14:24:23 PM</i> and was successful.', '2017-10-21 14:24:23', 1),
(167, 'Attempted to log in at <i>October 21, 2017 14:42:06 PM</i> and was successful.', '2017-10-21 14:42:07', 1),
(168, 'Attempted to log in at <i>October 23, 2017 13:38:11 PM</i> and was successful.', '2017-10-23 13:38:12', 1),
(169, 'Attempted to log in at <i>October 26, 2017 20:40:58 PM</i> and was successful.', '2017-10-26 20:40:58', 1),
(170, 'Attempted to log in at <i>October 26, 2017 21:30:12 PM</i> and was successful.', '2017-10-26 21:30:12', 1),
(171, 'Attempted to log in at <i>October 27, 2017 12:19:53 PM</i> and was successful.', '2017-10-27 12:19:53', 1),
(172, 'Attempted to log in at <i>October 27, 2017 13:09:36 PM</i> and was successful.', '2017-10-27 13:09:36', 1),
(173, 'Attempted to log out at <i>October 27, 2017 15:06:32 PM</i> and was successful.', '2017-10-27 15:06:32', 1),
(174, 'Attempted to log in at <i>October 27, 2017 15:06:37 PM</i> and was successful.', '2017-10-27 15:06:37', 1),
(175, 'Attempted to log in at <i>October 27, 2017 17:38:27 PM</i> and was successful.', '2017-10-27 17:38:27', 1),
(176, 'Attempted to log in at <i>October 27, 2017 19:18:51 PM</i> and was successful.', '2017-10-27 19:18:51', 1),
(177, 'Attempted to log out at <i>October 27, 2017 23:20:58 PM</i> and was successful.', '2017-10-27 23:20:58', 1),
(178, 'Attempted to log in at <i>October 27, 2017 23:23:13 PM</i> and was successful.', '2017-10-27 23:23:13', 1),
(179, 'Attempted to log in at <i>October 28, 2017 08:55:03 AM</i> and was successful.', '2017-10-28 08:55:04', 1),
(180, 'Attempted to log out at <i>October 28, 2017 08:55:13 AM</i> and was successful.', '2017-10-28 08:55:13', 1),
(181, 'Attempted to log in at <i>October 28, 2017 09:16:06 AM</i> and was successful.', '2017-10-28 09:16:06', 1),
(182, 'Attempted to log out at <i>October 28, 2017 10:51:58 AM</i> and was successful.', '2017-10-28 10:51:58', 1),
(183, 'Attempted to log in at <i>October 28, 2017 10:52:13 AM</i> and was successful.', '2017-10-28 10:52:13', 215),
(184, 'Attempted to log out at <i>October 28, 2017 10:52:30 AM</i> and was successful.', '2017-10-28 10:52:30', 215),
(185, 'Attempted to log in at <i>October 28, 2017 10:55:02 AM</i> and was successful.', '2017-10-28 10:55:02', 215),
(186, 'Attempted to log out at <i>October 28, 2017 10:55:33 AM</i> and was successful.', '2017-10-28 10:55:33', 215),
(187, 'Attempted to log in at <i>October 28, 2017 11:05:15 AM</i> and was successful.', '2017-10-28 11:05:15', 215),
(188, 'Attempted to log out at <i>October 28, 2017 11:05:18 AM</i> and was successful.', '2017-10-28 11:05:18', 215),
(189, 'Attempted to log in at <i>October 28, 2017 11:05:31 AM</i> and was successful.', '2017-10-28 11:05:31', 1),
(190, 'Attempted to log out at <i>October 28, 2017 13:30:29 PM</i> and was successful.', '2017-10-28 13:30:29', 1),
(191, 'Attempted to log in at <i>October 28, 2017 14:04:57 PM</i> and was successful.', '2017-10-28 14:04:57', 1),
(192, 'Attempted to log out at <i>October 28, 2017 14:13:30 PM</i> and was successful.', '2017-10-28 14:13:30', 1),
(193, 'Attempted to log in at <i>October 28, 2017 14:13:36 PM</i> and was successful.', '2017-10-28 14:13:36', 30),
(194, 'Attempted to log out at <i>October 28, 2017 14:19:17 PM</i> and was successful.', '2017-10-28 14:19:17', 30),
(195, 'Attempted to log in at <i>October 28, 2017 14:19:20 PM</i> and was successful.', '2017-10-28 14:19:21', 1),
(196, 'Attempted to log out at <i>October 28, 2017 15:08:12 PM</i> and was successful.', '2017-10-28 15:08:12', 1),
(197, 'Attempted to log in at <i>October 28, 2017 15:08:30 PM</i> and was successful.', '2017-10-28 15:08:30', 1),
(198, 'Attempted to log out at <i>October 28, 2017 15:15:26 PM</i> and was successful.', '2017-10-28 15:15:26', 1),
(199, 'Attempted to log in at <i>October 29, 2017 23:11:30 PM</i> and was successful.', '2017-10-29 23:11:30', 1),
(200, 'Attempted to log in at <i>November 03, 2017 22:44:00 PM</i> and was successful.', '2017-11-03 22:44:00', 1),
(201, 'Attempted to log in at <i>November 04, 2017 08:09:35 AM</i> and was successful.', '2017-11-04 08:09:35', 1),
(202, 'Attempted to log out at <i>November 04, 2017 11:46:31 AM</i> and was successful.', '2017-11-04 11:46:31', 1),
(203, 'Attempted to log in at <i>November 04, 2017 11:46:37 AM</i> and was successful.', '2017-11-04 11:46:37', 1),
(204, 'Attempted to log out at <i>November 04, 2017 14:48:44 PM</i> and was successful.', '2017-11-04 14:48:44', 1),
(205, 'Attempted to log in at <i>November 04, 2017 14:49:02 PM</i> and was successful.', '2017-11-04 14:49:02', 1),
(206, 'Attempted to log out at <i>November 04, 2017 14:49:13 PM</i> and was successful.', '2017-11-04 14:49:13', 1),
(207, 'Attempted to log in at <i>November 04, 2017 15:34:54 PM</i> and was successful.', '2017-11-04 15:34:54', 256),
(208, 'Attempted to log out at <i>November 04, 2017 15:35:20 PM</i> and was successful.', '2017-11-04 15:35:20', 256),
(209, 'Attempted to log in at <i>November 04, 2017 15:35:23 PM</i> and was successful.', '2017-11-04 15:35:23', 30),
(210, 'Attempted to log out at <i>November 04, 2017 15:35:29 PM</i> and was successful.', '2017-11-04 15:35:29', 30),
(211, 'Attempted to log in at <i>November 04, 2017 15:35:32 PM</i> and was successful.', '2017-11-04 15:35:32', 1),
(212, 'Attempted to log out at <i>November 04, 2017 15:38:11 PM</i> and was successful.', '2017-11-04 15:38:11', 1),
(213, 'Attempted to log in at <i>November 04, 2017 15:38:16 PM</i> and was successful.', '2017-11-04 15:38:16', 1),
(214, 'Attempted to log out at <i>November 04, 2017 15:39:32 PM</i> and was successful.', '2017-11-04 15:39:32', 1),
(215, 'Attempted to log in at <i>November 04, 2017 15:39:37 PM</i> and was successful.', '2017-11-04 15:39:37', 30),
(216, 'Attempted to log out at <i>November 04, 2017 15:39:56 PM</i> and was successful.', '2017-11-04 15:39:56', 30),
(217, 'Attempted to log in at <i>November 04, 2017 15:40:40 PM</i> and was successful.', '2017-11-04 15:40:40', 1),
(218, 'Attempted to log in at <i>November 04, 2017 16:30:07 PM</i> and was successful.', '2017-11-04 16:30:08', 1),
(219, 'Attempted to log in at <i>November 04, 2017 16:49:05 PM</i> and was successful.', '2017-11-04 16:49:05', 1),
(220, 'Attempted to log in at <i>November 10, 2017 16:44:37 PM</i> and was successful.', '2017-11-10 16:44:37', 1),
(221, 'Attempted to log in at <i>November 10, 2017 20:33:56 PM</i> and was successful.', '2017-11-10 20:33:56', 1),
(222, 'Attempted to log in at <i>November 11, 2017 20:02:48 PM</i> and was successful.', '2017-11-11 20:02:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `umg_users_classes`
--

CREATE TABLE IF NOT EXISTS `umg_users_classes` (
`id` int(10) NOT NULL,
  `class_id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_users_classes`
--

INSERT INTO `umg_users_classes` (`id`, `class_id`, `user_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `umg_users_departments`
--

CREATE TABLE IF NOT EXISTS `umg_users_departments` (
`id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `department_id` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_users_departments`
--

INSERT INTO `umg_users_departments` (`id`, `user_id`, `department_id`) VALUES
(1, 1, 29),
(2, 2, 29),
(3, 3, 29),
(4, 4, 29),
(5, 5, 29),
(6, 6, 29),
(7, 7, 29),
(8, 8, 29),
(9, 9, 29),
(10, 10, 29),
(11, 11, 29),
(12, 12, 29),
(13, 13, 29),
(14, 14, 29),
(15, 15, 29),
(16, 16, 29),
(17, 17, 40),
(18, 17, 45),
(20, 18, 20),
(21, 29, 14),
(22, 30, 20),
(23, 31, 11),
(24, 74, 14),
(25, 75, 14),
(26, 76, 20),
(27, 77, 14),
(28, 78, 14),
(29, 79, 14),
(30, 80, 14),
(31, 81, 14),
(32, 82, 14),
(33, 83, 14),
(34, 84, 14),
(35, 85, 14),
(36, 86, 14),
(37, 87, 14),
(38, 88, 14),
(39, 89, 14),
(40, 90, 14),
(41, 91, 14),
(42, 92, 14),
(43, 93, 14),
(44, 94, 14),
(45, 95, 14),
(46, 96, 14),
(47, 97, 14),
(48, 98, 14),
(49, 99, 14),
(50, 100, 14),
(51, 101, 14),
(52, 102, 14),
(53, 103, 14),
(54, 104, 14),
(55, 105, 14),
(56, 106, 14),
(57, 107, 14),
(58, 108, 14),
(59, 109, 14),
(60, 110, 14),
(61, 111, 14),
(62, 112, 14),
(63, 113, 14),
(64, 114, 14),
(65, 115, 14),
(66, 116, 14),
(67, 117, 20),
(68, 118, 14),
(69, 119, 14),
(70, 120, 14),
(71, 121, 14),
(72, 122, 14),
(73, 123, 14),
(74, 124, 14),
(75, 125, 14),
(76, 126, 14),
(77, 127, 14),
(78, 128, 14),
(79, 129, 14),
(80, 130, 14),
(81, 131, 14),
(82, 132, 14),
(83, 133, 14),
(84, 134, 14),
(85, 135, 14),
(86, 136, 14),
(87, 137, 14),
(88, 138, 14),
(89, 139, 14),
(90, 140, 14),
(91, 141, 14),
(92, 142, 14),
(93, 143, 14),
(94, 144, 14),
(95, 145, 14),
(96, 146, 14),
(97, 147, 14),
(98, 148, 14),
(99, 149, 14),
(100, 150, 14),
(101, 151, 14),
(102, 152, 14),
(103, 153, 14),
(104, 154, 14),
(105, 155, 14),
(106, 156, 14),
(107, 157, 14),
(108, 158, 20),
(109, 159, 14),
(110, 160, 14),
(111, 161, 14),
(112, 162, 14),
(113, 163, 14),
(114, 164, 14),
(115, 165, 14),
(116, 166, 14),
(117, 167, 14),
(118, 168, 14),
(119, 169, 14),
(120, 170, 14),
(121, 171, 14),
(122, 172, 14),
(123, 173, 14),
(124, 174, 14),
(125, 175, 14),
(126, 176, 14),
(127, 177, 14),
(128, 178, 14),
(129, 179, 14),
(130, 180, 14),
(131, 181, 14),
(132, 182, 14),
(133, 183, 14),
(134, 184, 14),
(135, 185, 14),
(136, 186, 14),
(137, 187, 14),
(138, 188, 14),
(139, 189, 14),
(140, 190, 14),
(141, 191, 14),
(142, 192, 14),
(143, 193, 14),
(144, 194, 14),
(145, 195, 14),
(146, 196, 14),
(147, 211, 8),
(149, 213, 5),
(150, 214, 20),
(151, 215, 14),
(152, 216, 14),
(153, 217, 20),
(154, 218, 14),
(155, 219, 14),
(156, 220, 14),
(157, 221, 14),
(158, 222, 14),
(159, 223, 14),
(160, 224, 14),
(161, 225, 14),
(162, 226, 14),
(163, 227, 14),
(164, 228, 14),
(165, 229, 14),
(166, 230, 14),
(167, 231, 14),
(168, 232, 14),
(169, 233, 14),
(170, 234, 14),
(171, 235, 14),
(172, 236, 14),
(173, 237, 14),
(174, 238, 14),
(175, 239, 14),
(176, 240, 14),
(177, 241, 14),
(178, 242, 14),
(179, 243, 14),
(180, 244, 14),
(181, 245, 14),
(182, 246, 14),
(183, 247, 14),
(184, 248, 14),
(185, 249, 14),
(186, 250, 14),
(187, 251, 14),
(188, 252, 14),
(189, 253, 14),
(190, 254, 14),
(191, 255, 14),
(192, 256, 14),
(193, 257, 14),
(194, 258, 20),
(195, 259, 14),
(196, 260, 14),
(197, 261, 14),
(198, 262, 14),
(199, 263, 14),
(200, 264, 14),
(201, 265, 14),
(202, 266, 14),
(203, 267, 14),
(204, 268, 14),
(205, 269, 14),
(206, 270, 14),
(207, 271, 14),
(208, 272, 14),
(209, 273, 14),
(210, 274, 14),
(211, 275, 14),
(212, 276, 14),
(213, 277, 14),
(214, 278, 14),
(215, 279, 14),
(216, 280, 14),
(217, 281, 14),
(218, 282, 14),
(219, 283, 14),
(220, 284, 14),
(221, 285, 14),
(222, 286, 14),
(223, 287, 14),
(224, 288, 14),
(225, 289, 14),
(226, 290, 14),
(227, 291, 14),
(228, 292, 14),
(229, 293, 14),
(230, 294, 14),
(231, 295, 14),
(232, 296, 14);

-- --------------------------------------------------------

--
-- Table structure for table `umg_users_email_addresses`
--

CREATE TABLE IF NOT EXISTS `umg_users_email_addresses` (
`id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `is_primary` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_users_email_addresses`
--

INSERT INTO `umg_users_email_addresses` (`id`, `user_id`, `email_address`, `is_primary`) VALUES
(19, 17, 'fdsfds@fdfd', 0),
(34, 18, 'vinz.crudo@gmail.com', 0),
(38, 29, 'fdfd@fdfd', 0),
(39, 30, '123@123', 0),
(40, 31, '123@22', 0),
(55, 211, 'tatt@tat', 0),
(58, 213, 'lawrence_sto.domingo@yahoo.com.ph', 0),
(59, 214, '123@2323', 0),
(60, 1, 'system.administrator@lpu.edu.ph', 0),
(61, 1, 'system.administrator2@lpu.edu.ph', 0);

-- --------------------------------------------------------

--
-- Table structure for table `umg_users_roles`
--

CREATE TABLE IF NOT EXISTS `umg_users_roles` (
`id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `umg_users_roles`
--

INSERT INTO `umg_users_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 3, 2),
(3, 4, 3),
(4, 5, 4),
(5, 6, 5),
(6, 7, 5),
(7, 8, 5),
(8, 9, 6),
(9, 10, 7),
(10, 11, 7),
(11, 12, 8),
(12, 13, 9),
(13, 2, 10),
(14, 14, 11),
(15, 16, 11),
(16, 15, 13),
(17, 16, 14),
(18, 17, 15),
(20, 18, 5),
(21, 29, 5),
(22, 30, 2),
(23, 31, 2),
(24, 115, 5),
(25, 116, 5),
(26, 117, 5),
(27, 118, 5),
(28, 119, 5),
(29, 120, 5),
(30, 121, 5),
(31, 122, 5),
(32, 123, 5),
(33, 124, 5),
(34, 125, 5),
(35, 126, 5),
(36, 127, 5),
(37, 128, 5),
(38, 129, 5),
(39, 130, 5),
(40, 131, 5),
(41, 132, 5),
(42, 133, 5),
(43, 134, 5),
(44, 135, 5),
(45, 136, 5),
(46, 137, 5),
(47, 138, 5),
(48, 139, 5),
(49, 140, 5),
(50, 141, 5),
(51, 142, 5),
(52, 143, 5),
(53, 144, 5),
(54, 145, 5),
(55, 146, 5),
(56, 147, 5),
(57, 148, 5),
(58, 149, 5),
(59, 150, 5),
(60, 151, 5),
(61, 152, 5),
(62, 153, 5),
(63, 154, 5),
(64, 155, 5),
(65, 156, 5),
(66, 157, 5),
(67, 158, 5),
(68, 159, 5),
(69, 160, 5),
(70, 161, 5),
(71, 162, 5),
(72, 163, 5),
(73, 164, 5),
(74, 165, 5),
(75, 166, 5),
(76, 167, 5),
(77, 168, 5),
(78, 169, 5),
(79, 170, 5),
(80, 171, 5),
(81, 172, 5),
(82, 173, 5),
(83, 174, 5),
(84, 175, 5),
(85, 176, 5),
(86, 177, 5),
(87, 178, 5),
(88, 179, 5),
(89, 180, 5),
(90, 181, 5),
(91, 182, 5),
(92, 183, 5),
(93, 184, 5),
(94, 185, 5),
(95, 186, 5),
(96, 187, 5),
(97, 188, 5),
(98, 189, 5),
(99, 190, 5),
(100, 191, 5),
(101, 192, 5),
(102, 193, 5),
(103, 194, 5),
(104, 195, 5),
(105, 196, 5),
(106, 211, 1),
(108, 213, 1),
(109, 214, 5),
(110, 215, 5),
(111, 216, 5),
(112, 217, 5),
(113, 218, 5),
(114, 219, 5),
(115, 220, 5),
(116, 221, 5),
(117, 222, 5),
(118, 223, 5),
(119, 224, 5),
(120, 225, 5),
(121, 226, 5),
(122, 227, 5),
(123, 228, 5),
(124, 229, 5),
(125, 230, 5),
(126, 231, 5),
(127, 232, 5),
(128, 233, 5),
(129, 234, 5),
(130, 235, 5),
(131, 236, 5),
(132, 237, 5),
(133, 238, 5),
(134, 239, 5),
(135, 240, 5),
(136, 241, 5),
(137, 242, 5),
(138, 243, 5),
(139, 244, 5),
(140, 245, 5),
(141, 246, 5),
(142, 247, 5),
(143, 248, 5),
(144, 249, 5),
(145, 250, 5),
(146, 251, 5),
(147, 252, 5),
(148, 253, 5),
(149, 254, 5),
(150, 255, 5),
(151, 256, 5),
(152, 257, 5),
(153, 258, 5),
(154, 259, 5),
(155, 260, 5),
(156, 261, 5),
(157, 262, 5),
(158, 263, 5),
(159, 264, 5),
(160, 265, 5),
(161, 266, 5),
(162, 267, 5),
(163, 268, 5),
(164, 269, 5),
(165, 270, 5),
(166, 271, 5),
(167, 272, 5),
(168, 273, 5),
(169, 274, 5),
(170, 275, 5),
(171, 276, 5),
(172, 277, 5),
(173, 278, 5),
(174, 279, 5),
(175, 280, 5),
(176, 281, 5),
(177, 282, 5),
(178, 283, 5),
(179, 284, 5),
(180, 285, 5),
(181, 286, 5),
(182, 287, 5),
(183, 288, 5),
(184, 289, 5),
(185, 290, 5),
(186, 291, 5),
(187, 292, 5),
(188, 293, 5),
(189, 294, 5),
(190, 295, 5),
(191, 296, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acd_courses`
--
ALTER TABLE `acd_courses`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `acd_sections`
--
ALTER TABLE `acd_sections`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acd_subjects`
--
ALTER TABLE `acd_subjects`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `acd_subject_legend`
--
ALTER TABLE `acd_subject_legend`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atd_nfc_tag`
--
ALTER TABLE `atd_nfc_tag`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atd_users_attendance`
--
ALTER TABLE `atd_users_attendance`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `atd_users_nfc`
--
ALTER TABLE `atd_users_nfc`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`,`nfc_id`), ADD KEY `nfc_id` (`nfc_id`);

--
-- Indexes for table `clm_classes`
--
ALTER TABLE `clm_classes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clm_classes_schedules`
--
ALTER TABLE `clm_classes_schedules`
 ADD PRIMARY KEY (`id`), ADD KEY `day_id` (`day_id`), ADD KEY `subject_legend_id` (`subject_legend_id`), ADD KEY `class_id` (`class_id`), ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `clm_classes_seat_plans`
--
ALTER TABLE `clm_classes_seat_plans`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clm_days`
--
ALTER TABLE `clm_days`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clm_rooms`
--
ALTER TABLE `clm_rooms`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `prf_academic_years`
--
ALTER TABLE `prf_academic_years`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `prf_charsets`
--
ALTER TABLE `prf_charsets`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prf_events`
--
ALTER TABLE `prf_events`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prf_layouts`
--
ALTER TABLE `prf_layouts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prf_semesters`
--
ALTER TABLE `prf_semesters`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `prf_skin_colors`
--
ALTER TABLE `prf_skin_colors`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prf_system_preferences`
--
ALTER TABLE `prf_system_preferences`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `umg_departments`
--
ALTER TABLE `umg_departments`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`), ADD UNIQUE KEY `acronym` (`acronym`);

--
-- Indexes for table `umg_genders`
--
ALTER TABLE `umg_genders`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `umg_permissions`
--
ALTER TABLE `umg_permissions`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `slug` (`slug`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `umg_roles`
--
ALTER TABLE `umg_roles`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `umg_roles_permissions`
--
ALTER TABLE `umg_roles_permissions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `umg_users`
--
ALTER TABLE `umg_users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `umg_users_activities`
--
ALTER TABLE `umg_users_activities`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `umg_users_classes`
--
ALTER TABLE `umg_users_classes`
 ADD PRIMARY KEY (`id`), ADD KEY `class_id` (`class_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `umg_users_departments`
--
ALTER TABLE `umg_users_departments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `umg_users_email_addresses`
--
ALTER TABLE `umg_users_email_addresses`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `umg_users_roles`
--
ALTER TABLE `umg_users_roles`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acd_courses`
--
ALTER TABLE `acd_courses`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `acd_sections`
--
ALTER TABLE `acd_sections`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `acd_subjects`
--
ALTER TABLE `acd_subjects`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `acd_subject_legend`
--
ALTER TABLE `acd_subject_legend`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `atd_nfc_tag`
--
ALTER TABLE `atd_nfc_tag`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `atd_users_attendance`
--
ALTER TABLE `atd_users_attendance`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `atd_users_nfc`
--
ALTER TABLE `atd_users_nfc`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clm_classes`
--
ALTER TABLE `clm_classes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `clm_classes_schedules`
--
ALTER TABLE `clm_classes_schedules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `clm_classes_seat_plans`
--
ALTER TABLE `clm_classes_seat_plans`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `clm_days`
--
ALTER TABLE `clm_days`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `clm_rooms`
--
ALTER TABLE `clm_rooms`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `prf_academic_years`
--
ALTER TABLE `prf_academic_years`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `prf_charsets`
--
ALTER TABLE `prf_charsets`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `prf_events`
--
ALTER TABLE `prf_events`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `prf_layouts`
--
ALTER TABLE `prf_layouts`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `prf_semesters`
--
ALTER TABLE `prf_semesters`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `prf_skin_colors`
--
ALTER TABLE `prf_skin_colors`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `prf_system_preferences`
--
ALTER TABLE `prf_system_preferences`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `umg_departments`
--
ALTER TABLE `umg_departments`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `umg_genders`
--
ALTER TABLE `umg_genders`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `umg_permissions`
--
ALTER TABLE `umg_permissions`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=201;
--
-- AUTO_INCREMENT for table `umg_roles`
--
ALTER TABLE `umg_roles`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `umg_roles_permissions`
--
ALTER TABLE `umg_roles_permissions`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3292;
--
-- AUTO_INCREMENT for table `umg_users`
--
ALTER TABLE `umg_users`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=297;
--
-- AUTO_INCREMENT for table `umg_users_activities`
--
ALTER TABLE `umg_users_activities`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=223;
--
-- AUTO_INCREMENT for table `umg_users_classes`
--
ALTER TABLE `umg_users_classes`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `umg_users_departments`
--
ALTER TABLE `umg_users_departments`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=233;
--
-- AUTO_INCREMENT for table `umg_users_email_addresses`
--
ALTER TABLE `umg_users_email_addresses`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `umg_users_roles`
--
ALTER TABLE `umg_users_roles`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=192;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `clm_classes_schedules`
--
ALTER TABLE `clm_classes_schedules`
ADD CONSTRAINT `clm_classes_schedules_ibfk_1` FOREIGN KEY (`day_id`) REFERENCES `clm_days` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
