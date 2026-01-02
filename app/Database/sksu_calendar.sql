-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2025 at 12:19 PM
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
-- Database: `sksu_calendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_details`
--

CREATE TABLE `attendance_details` (
  `id` int(11) NOT NULL,
  `attendance_record_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `status` enum('present','absent','late') NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `fine_amount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_details`
--

INSERT INTO `attendance_details` (`id`, `attendance_record_id`, `student_id`, `student_name`, `status`, `time_in`, `time_out`, `fine_amount`) VALUES
(120, 15, '28781', 'hanna dela cruz', 'present', '08:01:00', '17:01:00', 25.00),
(121, 16, '28818', 'hannah lagdamen', 'absent', '00:00:00', '00:00:00', 25.00),
(122, 20, '28813', 'Hanna Dela Cruz', '', '04:00:00', '05:00:00', 0.00),
(123, 20, '29775', 'Sofia Lorraine Diyo', 'present', '05:00:00', '06:00:00', 0.00),
(124, 20, '284613	Vannessa Kaye Dela Cruz', 'present', '', '06:00:00', '00:00:00', 0.00),
(125, 21, '28813', 'Hanna Dela Cruz', '', '04:00:00', '05:00:00', 0.00),
(126, 21, '29775', 'Sofia Lorraine Diyo', 'present', '05:00:00', '06:00:00', 0.00),
(127, 21, '284613	Vannessa Kaye Dela Cruz', 'present', '', '06:00:00', '00:00:00', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `recorded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_records`
--

INSERT INTO `attendance_records` (`id`, `event_id`, `created_at`, `recorded_at`) VALUES
(1, 1, '2025-12-03 00:10:16', '2025-12-02 16:10:16'),
(2, 1, '2025-12-03 03:17:01', '2025-12-02 19:17:01'),
(3, 2, '2025-12-03 03:29:46', '2025-12-02 19:29:46'),
(4, 12, '2025-12-06 22:17:58', '2025-12-06 14:17:58'),
(5, 12, '2025-12-06 22:20:45', '2025-12-06 14:20:45'),
(6, 12, '2025-12-06 22:37:12', '2025-12-06 14:37:12'),
(7, 10, '2025-12-09 14:02:39', '2025-12-09 06:02:39'),
(8, 11, '2025-12-10 09:00:09', '2025-12-10 01:00:09'),
(9, 14, '2025-12-15 22:38:03', '2025-12-15 14:38:03'),
(10, 12, '2025-12-17 11:55:23', '2025-12-17 03:55:23'),
(11, 15, '2025-12-17 12:45:25', '2025-12-17 04:45:25'),
(12, 15, '2025-12-17 13:12:06', '2025-12-17 05:12:06'),
(13, 13, '2025-12-17 13:26:55', '2025-12-17 05:26:55'),
(14, 13, '2025-12-17 20:57:05', '2025-12-17 12:57:05'),
(15, 16, '2025-12-18 14:07:58', '2025-12-18 06:07:58'),
(16, 16, '2025-12-18 14:10:19', '2025-12-18 06:10:19'),
(17, 18, '2025-12-18 14:23:43', '2025-12-18 06:23:43'),
(18, 18, '2025-12-18 14:27:44', '2025-12-18 06:27:44'),
(19, 18, '2025-12-18 14:31:35', '2025-12-18 06:31:35'),
(20, 18, '2025-12-18 14:35:05', '2025-12-18 06:35:05'),
(21, 16, '2025-12-18 17:39:51', '2025-12-18 09:39:51');

-- --------------------------------------------------------

--
-- Table structure for table `campuses`
--

CREATE TABLE `campuses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campuses`
--

INSERT INTO `campuses` (`id`, `name`) VALUES
(1, 'Isulan'),
(2, 'Tacurong'),
(3, 'Kalamansig'),
(4, 'Palimbang'),
(5, 'Lutayan'),
(6, 'Access'),
(7, 'Bagumbayan');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `org_name` varchar(100) NOT NULL,
  `title` text NOT NULL,
  `description` text DEFAULT NULL,
  `date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `campus_id`, `created_by`, `org_name`, `title`, `description`, `date`, `location`, `poster`, `time_in`, `time_out`) VALUES
(16, 1, 'Campus Org User', 'sbo isulan', 'Aquintance', 'happy', '2025-11-18', 'Isulan Gym', NULL, '13:30:00', '18:30:00'),
(17, 1, 'Campus Org User', 'Csso', 'Css Day', 'preperation  for ccs day and budgetrary', '2025-10-16', 'Css Building', NULL, '07:00:00', '12:00:00'),
(18, 1, 'Campus Org User', 'SBO', 'Fun run', 'REQUIRED', '2025-11-12', 'School', NULL, '04:00:00', '06:00:00'),
(19, 1, 'Campus Org User', 'MSO', 'Kanduli Fest', 'festival', '2025-09-12', 'Isulan School', NULL, '08:00:00', '19:00:00'),
(20, 2, 'USG Admin', 'sbo tacurong', 'sports day', 'ww', '2025-12-31', 'tacurong gym', NULL, '06:41:00', '18:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `year_level` varchar(20) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `full_name`, `course`, `year_level`, `campus_id`) VALUES
(13, '28818', 'Hannah Lagdamen', 'BSIT', '3rd Year', 1),
(14, '29775', 'Sofia Lorraine Diyo', 'BSIT', '2nd Year', 1),
(15, '28813', 'Hanna Dela Cruz', 'BSIT', '4th Year', 1),
(16, '284613', 'Vannessa Kaye Dela Cruz', 'BSIT', '1st Year', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `campus_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('usg','org','handler') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `campus_id`, `name`, `email`, `password`, `role`) VALUES
(1, NULL, 'USG Admin', 'usg@sksu.edu.ph', '$2y$10$rI.b.9hgT8F0rNIMUc0WNuA1mPMFgUcn0BSDL7p.2OWlN7YhfBdQa', 'usg'),
(2, 1, 'Campus Org User', 'org@isulan.edu.ph', '$2y$10$YBKbMjjPAuUNiMZLuXF4v.UsYR5LiSJ8CU7aNMOubylFzAL0ihuLy', 'org'),
(3, 1, 'Event Handler', 'handler@isulan.edu.ph', '$2y$10$qWhIEwFgrbSYWa23nUJBGO1mx0EQx0fl7T.IuvzVoxd.B66xsGYbu', 'handler'),
(4, 2, 'Tacurong', 'org@tacurong.edu.ph', '$2y$10$eF8785GE.u9AoYgYdAVeb.EJa94l6cBRnuJxZpQOghZ21cZGxy8cC', 'org');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_details`
--
ALTER TABLE `attendance_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campuses`
--
ALTER TABLE `campuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_details`
--
ALTER TABLE `attendance_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `campuses`
--
ALTER TABLE `campuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
