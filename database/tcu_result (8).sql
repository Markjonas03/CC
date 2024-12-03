-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 05:13 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tcu_result`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class`
--

CREATE TABLE `tbl_class` (
  `id` int(11) NOT NULL,
  `course` varchar(25) NOT NULL,
  `year` varchar(25) NOT NULL,
  `section` varchar(25) NOT NULL,
  `sem` varchar(25) NOT NULL,
  `sy_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_class`
--

INSERT INTO `tbl_class` (`id`, `course`, `year`, `section`, `sem`, `sy_id`, `date_created`, `date_updated`) VALUES
(15, 'IS', '4', 'B2021', 'First Semester', 4, '2024-11-25 00:00:15', '2024-11-24 16:00:15'),
(16, 'CS', '4', 'B2021', 'First Semester', 4, '2024-11-27 12:13:35', '2024-11-27 04:13:35'),
(17, 'CS', '2', 'B2021', 'First Semester', 4, '2024-11-27 12:31:22', '2024-11-27 04:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class_students`
--

CREATE TABLE `tbl_class_students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `class_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_class_students`
--

INSERT INTO `tbl_class_students` (`id`, `student_id`, `class_id`, `date_created`, `date_updated`) VALUES
(5, '21-00395', 15, '2024-11-30 16:54:33', '2024-11-30 16:54:33'),
(6, '21-00401', 15, '2024-11-30 16:54:37', '2024-11-30 16:54:37'),
(7, '21-00418', 15, '2024-12-02 16:28:12', '2024-12-02 16:28:12'),
(8, '21-00546', 15, '2024-12-02 18:21:51', '2024-12-02 18:21:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notes`
--

CREATE TABLE `tbl_notes` (
  `id` int(11) NOT NULL,
  `prof_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `note` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sender_type` enum('professor','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notes`
--

INSERT INTO `tbl_notes` (`id`, `prof_id`, `student_id`, `note`, `created_at`, `updated_at`, `sender_type`) VALUES
(125, 33, NULL, 'asdasda', '2024-11-03 21:28:16', '2024-11-03 21:28:16', 'professor'),
(126, 33, NULL, 'SADSDADASDSA', '2024-11-03 21:50:43', '2024-11-03 21:50:43', 'professor'),
(138, 2, NULL, 'asdasdsa', '2024-11-13 15:41:23', '2024-11-13 15:41:23', 'professor'),
(139, 2, NULL, 'asdasdsa', '2024-11-13 15:41:32', '2024-11-13 15:41:32', 'professor');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_professor`
--

CREATE TABLE `tbl_professor` (
  `id` int(11) NOT NULL,
  `prof_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_professor`
--

INSERT INTO `tbl_professor` (`id`, `prof_id`, `class_id`, `subject_id`, `date_created`, `date_updated`) VALUES
(22, 34, 7, 11, '2024-11-03 00:46:27', '2024-11-02 16:46:27'),
(24, 34, 7, 17, '2024-11-03 20:24:50', '2024-11-03 12:24:50'),
(25, 33, 7, 18, '2024-11-03 20:24:59', '2024-11-03 12:24:59'),
(26, 35, 7, 16, '2024-11-03 20:25:43', '2024-11-03 12:25:43'),
(27, 37, 7, 15, '2024-11-03 20:26:02', '2024-11-03 12:26:02'),
(28, 36, 7, 20, '2024-11-03 20:26:29', '2024-11-03 12:26:29'),
(30, 32, 7, 19, '2024-11-20 22:16:18', '2024-11-20 14:16:18'),
(31, 32, 11, 19, '2024-11-23 04:24:51', '2024-11-22 20:24:51'),
(32, 35, 11, 16, '2024-11-23 04:25:25', '2024-11-22 20:25:25'),
(33, 32, 13, 19, '2024-11-23 04:27:24', '2024-11-22 20:27:24'),
(34, 33, 13, 18, '2024-11-23 04:27:41', '2024-11-22 20:27:41'),
(35, 34, 13, 17, '2024-11-23 04:27:48', '2024-11-22 20:27:48'),
(36, 35, 13, 16, '2024-11-23 04:27:55', '2024-11-22 20:27:55'),
(37, 36, 13, 20, '2024-11-23 04:28:18', '2024-11-22 20:28:18'),
(38, 37, 13, 15, '2024-11-23 04:28:29', '2024-11-22 20:28:29'),
(40, 33, 15, 18, '2024-11-25 00:00:31', '2024-11-24 16:00:31'),
(41, 34, 15, 17, '2024-11-25 00:00:39', '2024-11-24 16:00:39'),
(42, 35, 15, 16, '2024-11-25 00:00:46', '2024-11-24 16:00:46'),
(43, 36, 15, 20, '2024-11-25 00:00:57', '2024-11-24 16:00:57'),
(44, 37, 15, 15, '2024-11-25 00:01:03', '2024-11-24 16:01:03'),
(47, 0, 18, 0, '2024-11-27 17:16:02', '2024-11-27 09:16:02'),
(49, 0, 15, 19, '2024-11-27 22:24:29', '2024-11-27 14:24:29'),
(50, 0, 15, 19, '2024-11-27 22:25:33', '2024-11-27 14:25:33'),
(51, 0, 15, 19, '2024-11-27 22:25:47', '2024-11-27 14:25:47'),
(62, 32, 0, 19, '2024-12-03 02:06:35', '2024-12-02 18:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_result`
--

CREATE TABLE `tbl_result` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `midterm` decimal(5,2) DEFAULT NULL,
  `finals` decimal(5,2) DEFAULT NULL,
  `result` decimal(5,2) DEFAULT NULL,
  `PostingDate` datetime DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Passed','Failed','INC','UD','OD') NOT NULL DEFAULT 'Passed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_result`
--

INSERT INTO `tbl_result` (`id`, `class_id`, `student_id`, `midterm`, `finals`, `result`, `PostingDate`, `date_updated`, `status`) VALUES
(488, 0, '413', 78.00, 75.00, 2.75, '2024-11-29 15:19:59', '2024-11-29 07:40:02', 'Passed'),
(489, 0, '414', 94.00, 93.00, 1.50, '2024-11-29 15:20:25', '2024-11-29 07:20:25', 'Passed'),
(490, 0, '415', 85.00, 83.00, 2.25, '2024-11-29 15:22:57', '2024-11-29 07:22:57', 'Passed'),
(492, 0, '416', 73.00, 74.00, 5.00, '2024-11-29 16:03:45', '2024-11-29 08:03:45', 'Failed');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `id` int(11) NOT NULL,
  `id_no` varchar(25) NOT NULL,
  `advisory_id` int(11) NOT NULL,
  `student_id` varchar(25) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `id_no`, `advisory_id`, `student_id`, `lname`, `fname`, `mname`, `date_created`, `date_updated`, `class_id`) VALUES
(413, '', 41, '21-00395', 'Acquiat', 'Mark Jonas', 'R', '2024-11-29 15:19:48', '2024-11-29 07:19:48', 0),
(414, '', 40, '21-00395', 'Acquiat', 'Mark Jonas', 'R', '2024-11-29 15:20:19', '2024-11-29 07:20:19', 0),
(415, '', 43, '21-00395', 'Acquiat', 'Mark Jonas', 'R', '2024-11-29 15:22:50', '2024-11-29 07:22:50', 0),
(416, '', 44, '21-00395', 'Acquiat', 'Mark Jonas', 'R', '2024-11-29 16:03:38', '2024-11-29 08:03:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subjects`
--

CREATE TABLE `tbl_subjects` (
  `id` int(11) NOT NULL,
  `subject_code` varchar(25) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `units` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`id`, `subject_code`, `subject_name`, `units`, `date_created`, `date_updated`) VALUES
(15, 'ELEC 5A', 'Business Intelligence', 3, '2024-11-03 20:22:58', '2024-11-03 12:22:58'),
(16, 'HC1 103', 'TECHNOPRENUERSHIP/E-COMMERCE', 3, '2024-11-03 20:23:11', '2024-11-03 12:23:11'),
(17, 'CC 111', 'DATA ANALYTICS', 3, '2024-11-03 20:23:22', '2024-11-24 15:55:37'),
(18, 'ELEC 6', 'IS INNVATION AND TECHNOLOGIES', 3, '2024-11-03 20:23:35', '2024-11-03 12:23:35'),
(19, 'CAP 102', 'Capstone Project 2', 3, '2024-11-03 20:23:48', '2024-11-03 12:23:48'),
(20, 'CC 110', 'CONTENT MANAGEMENT SYSTEM', 3, '2024-11-03 20:23:58', '2024-11-03 12:23:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sy`
--

CREATE TABLE `tbl_sy` (
  `id` int(11) NOT NULL,
  `school_year` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sy`
--

INSERT INTO `tbl_sy` (`id`, `school_year`, `status`) VALUES
(4, '2023-2024', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tasks`
--

CREATE TABLE `tbl_tasks` (
  `id` int(11) NOT NULL,
  `prof_id` int(11) NOT NULL,
  `task_title` varchar(255) NOT NULL,
  `task_description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `task_date` date NOT NULL,
  `task_time` time NOT NULL,
  `task` text NOT NULL,
  `deadline` date DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tasks`
--

INSERT INTO `tbl_tasks` (`id`, `prof_id`, `task_title`, `task_description`, `due_date`, `status`, `assigned_to`, `created_at`, `task_date`, `task_time`, `task`, `deadline`, `subject_id`) VALUES
(31, 34, '', NULL, NULL, 'Pending', NULL, '2024-11-29 21:20:57', '2024-11-30', '23:19:00', 'MIDTERM', '2024-12-01', 17);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `id_no` varchar(25) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('student','professor','admin') NOT NULL DEFAULT 'student',
  `image` varchar(100) NOT NULL DEFAULT 'noprofil.jpg',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `id_no`, `fname`, `mname`, `lname`, `contact`, `email`, `password`, `role`, `image`, `date_created`, `date_updated`) VALUES
(1, '000', 'Heidi Joy', 'D', 'Santos', '11111111111', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', 'noprofil.jpg', '2024-04-14 12:31:08', '2024-10-06 05:19:38'),
(2, '21-00395', 'Mark Jonas', 'R', 'Acquiat', '09152862731', 'mark.rances321@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'student', 'Mark Jonas - 2024.10.26 - 09.51.11am.jpg', '2024-10-04 21:19:19', '2024-10-26 07:51:11'),
(3, '21-00401', 'Merry Mae', 'F', 'Aljas', '1', 'sponge.mimae@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'student', 'noprofil.jpg', '2024-10-04 21:20:16', '2024-10-04 13:20:16'),
(6, '21-00418', 'Madel', '', 'Amarante', '1', 'amarantedamz@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 21:40:16', '2024-10-04 13:40:16'),
(7, '21-00449', 'Lei Benedict', 'M', 'Arzadon', '1', 'leibndctarzadon@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 21:40:59', '2024-10-04 13:40:59'),
(8, '21-00455', 'John Killua', '', 'Baldonza', '1', 'kiluabaldonaza24@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 21:41:37', '2024-10-04 13:41:37'),
(9, '21-00464', 'Russell Shane', 'A', 'Benedito', '1', 'beneditoruzzell22@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 21:43:40', '2024-10-04 13:43:40'),
(10, '21-00474', 'Angelo', 'L', 'Bracer', '1', 'angelobracero35@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 21:44:10', '2024-10-04 13:44:10'),
(12, '21-00482', 'John Carlo', 'G', 'Cabique', '1', 'johncarlocabique@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:09:41', '2024-10-04 14:09:41'),
(13, '21-03299', 'Kimberly Kate', 'B', 'Canero', '1', 'katekat.canero123@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:10:22', '2024-10-04 14:14:34'),
(14, '21-00490', 'Maria Angelica', 'C', 'Carlos', '1', 'mrnglccarlos@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:23:13', '2024-10-04 14:23:13'),
(15, '21-00495', 'Bernadette', 'C', 'Cruz', '1', 'bernadettecruz90@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:23:38', '2024-10-04 14:23:38'),
(16, '21-05875', 'Mark Evan', 'C', 'Daguay', '1', 'markevandaguay@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:24:12', '2024-10-04 14:24:12'),
(17, '21-00521', 'James Kendrick', 'R', 'Decena', '1', 'jameskendrick@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:25:06', '2024-10-04 14:25:06'),
(18, '21-05362', 'Kayla May', 'D', 'De Mariano', '1', 'kaylamaydemariano@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:26:28', '2024-10-04 14:26:28'),
(19, ' 21-00537', 'Marlyn', 'E', 'Dela Cruz', '1', 'marlyndelacruz903@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:27:38', '2024-10-04 14:27:38'),
(20, '21-00546', 'Jan Harold', 'M', 'Dionela', '1', 'dionelajanharoldm@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:28:40', '2024-10-04 14:28:40'),
(21, '21-02880', 'Fabian', 'F', 'Leynard Andre', '1', 'fabianleynard@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:29:14', '2024-10-04 14:29:14'),
(22, '21-00569', 'Jericho Miguel', 'B', 'Fernandez', '1', 'jerichomiguelf@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:35:24', '2024-10-04 14:35:24'),
(23, '21-03581', 'Ralph Julien', 'G', 'Gonzales', '1', 'yenyen09gonzales@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:35:54', '2024-10-04 14:35:54'),
(24, '21-05913', 'Ferdie Jr', '', 'Jorge', '1', 'britishferdie@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:37:31', '2024-10-04 14:37:31'),
(25, '21-00604', 'Jhun Wendell', 'D', 'Laporteza', '1', 'jhunwendelllaporteza@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:37:57', '2024-10-04 14:37:57'),
(26, '21-00607', 'Terrence Jordan', 'S', 'Loteyro', '1', 'bangterrence16@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:38:21', '2024-10-04 14:38:21'),
(27, '21-00621', 'Rizalyn Joy', '', 'Rizalyn Joy', '1', 'rjoy031701@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:42:54', '2024-10-04 14:42:54'),
(28, '21-00627', 'Kristopher', '', 'Oliamot', '1', 'kristopheroliamot53@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:43:15', '2024-10-04 14:43:15'),
(29, '21-00669', 'Alexandra', 'L', 'Ramos', '1', 'alexandralarosaramos@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:43:42', '2024-10-04 14:43:42'),
(30, '21-04456', 'Miggy', 'F', 'Reyes', '1', 'miggyreyes214@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:44:13', '2024-10-04 14:44:13'),
(31, '21-00693', 'Erwin', 'S', 'Serato', '1', 'erwinserato17@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-04 22:44:49', '2024-10-04 14:44:49'),
(32, '111', 'Nina', '', 'Bacolod', '1', 'asdadsa@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'professor', 'noprofil.jpg', '2024-10-04 23:20:02', '2024-10-04 15:20:02'),
(33, '222', 'Mark', '', 'Constantino', '1', 'ssda@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'professor', 'noprofil.jpg', '2024-10-04 23:21:13', '2024-10-04 15:21:13'),
(34, '333', 'TJ', 'M', 'Tejano', '1', 'asdsa@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'professor', 'noprofil.jpg', '2024-10-04 23:21:55', '2024-10-04 15:21:55'),
(35, '444', 'Wilbert', '', 'Sabado', '1', 'wilbersabado@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'professor', 'noprofil.jpg', '2024-10-04 23:22:43', '2024-10-04 15:22:43'),
(36, '555', 'Jinky', 'B', 'Tumasis', '1', 'ASDSAD@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'professor', 'noprofil.jpg', '2024-10-04 23:23:27', '2024-10-04 15:23:27'),
(37, '666', 'Arlene', '', 'Pineda', '1', 'asdasda@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'professor', 'noprofil.jpg', '2024-10-04 23:24:19', '2024-10-04 15:24:19'),
(38, '12333', 'asdada', 'asdasdasda', 'dsadsadasdad', '111', 'asdadadasd@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'student', 'noprofil.jpg', '2024-10-24 20:43:15', '2024-10-24 12:43:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_class`
--
ALTER TABLE `tbl_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_class_students`
--
ALTER TABLE `tbl_class_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `tbl_notes`
--
ALTER TABLE `tbl_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prof_id` (`prof_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `tbl_professor`
--
ALTER TABLE `tbl_professor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_professor_id` (`id`);

--
-- Indexes for table `tbl_result`
--
ALTER TABLE `tbl_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_student_id` (`student_id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_subject_code` (`subject_code`);

--
-- Indexes for table `tbl_sy`
--
ALTER TABLE `tbl_sy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prof_id` (`prof_id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `fk_subject_id` (`subject_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id_no` (`id_no`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_class`
--
ALTER TABLE `tbl_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_class_students`
--
ALTER TABLE `tbl_class_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_notes`
--
ALTER TABLE `tbl_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `tbl_professor`
--
ALTER TABLE `tbl_professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tbl_result`
--
ALTER TABLE `tbl_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=493;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=417;

--
-- AUTO_INCREMENT for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_sy`
--
ALTER TABLE `tbl_sy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_class_students`
--
ALTER TABLE `tbl_class_students`
  ADD CONSTRAINT `tbl_class_students_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tbl_users` (`id_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_class_students_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `tbl_class` (`id`);

--
-- Constraints for table `tbl_notes`
--
ALTER TABLE `tbl_notes`
  ADD CONSTRAINT `tbl_notes_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  ADD CONSTRAINT `fk_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `tbl_subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
