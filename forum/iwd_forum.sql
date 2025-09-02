-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 02, 2025 at 06:16 PM
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
-- Database: `iwd_forum`
--
CREATE DATABASE IF NOT EXISTS `iwd_forum` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `iwd_forum`;

-- --------------------------------------------------------

--
-- Table structure for table `event_log`
--

CREATE TABLE `event_log` (
  `log_id` int(11) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_details` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `event_log`:
--   `username`
--       `user` -> `username`
--

--
-- Dumping data for table `event_log`
--

INSERT INTO `event_log` (`log_id`, `event_type`, `username`, `ip_address`, `log_date`, `event_details`) VALUES
(4, 'Register Account', 'lenny123', '::1', '2025-08-15 16:51:26', 'real_name: lenny | dob: 1950-05-09'),
(5, 'Register Account', 'steve123', '::1', '2025-08-15 16:52:08', 'real_name:  | dob: 1960-04-02'),
(6, 'Login (Failed)', NULL, '::1', '2025-08-15 17:06:29', 'username: test123'),
(8, 'Login (Successful)', 'ryan123', '::1', '2025-08-15 17:08:37', NULL),
(9, 'Logout', 'ryan123', '::1', '2025-08-15 17:13:56', NULL),
(10, 'Register Account', 'randy123', '::1', '2025-08-15 17:14:32', 'real_name: randy | dob: 1300-08-14'),
(11, 'Logout', 'randy123', '::1', '2025-08-15 18:15:47', NULL),
(12, 'Login (Successful)', 'maggie123', '::1', '2025-08-15 18:15:55', NULL),
(15, 'Change Access Level', 'maggie123', '::1', '2025-08-15 18:24:44', 'username: ryan123 | access_level: admin'),
(18, 'Logout', 'maggie123', '::1', '2025-08-15 18:25:53', NULL),
(19, 'Login (Successful)', 'ryan123', '::1', '2025-08-15 18:26:01', NULL),
(20, 'Logout', 'ryan123', '::1', '2025-08-15 18:26:04', NULL),
(21, 'Register Account', 'jenny123', '::1', '2025-08-15 18:26:40', 'real_name: jen | dob: 1990-03-03'),
(22, 'Post Thread', 'jenny123', '::1', '2025-08-15 18:26:49', 'thread_id:28'),
(24, 'Logout', 'jenny123', '::1', '2025-08-15 18:27:27', NULL),
(25, 'Login (Failed)', NULL, '::1', '2025-08-15 18:27:34', 'username: rf4'),
(29, 'Login (Successful)', 'steve123', '::1', '2025-08-16 14:59:55', NULL),
(30, 'Logout', 'steve123', '::1', '2025-08-16 15:01:19', NULL),
(41, 'Login (Failed)', NULL, '::1', '2025-09-02 16:08:36', 'username: ryan123'),
(42, 'Login (Successful)', 'ryan123', '::1', '2025-09-02 16:08:44', NULL),
(43, 'Post Thread', 'ryan123', '::1', '2025-09-02 16:08:57', 'thread_id:30'),
(44, 'Delete Thread', 'ryan123', '::1', '2025-09-02 16:09:04', 'thread_id:30'),
(45, 'Post Thread', 'ryan123', '::1', '2025-09-02 16:14:35', 'thread_id:31');

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `forum_id` tinyint(3) UNSIGNED NOT NULL,
  `forum_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `forum`:
--

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `forum_name`) VALUES
(1, 'General Discussion'),
(2, 'News and Events'),
(3, 'Videos and Images');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `reply_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `reply`:
--   `thread_id`
--       `thread` -> `thread_id`
--   `username`
--       `user` -> `username`
--

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`reply_id`, `username`, `thread_id`, `content`, `post_date`) VALUES
(1, 'maggie123', 3, 'erufnietr', '2025-08-06 14:49:02'),
(2, 'maggie123', 3, 'hhhggg', '2025-08-06 14:50:03'),
(3, 'maggie123', 3, 'new comment', '2025-08-06 14:59:34'),
(4, 'maggie123', 3, 'hi there', '2025-08-06 15:07:19'),
(5, 'ryan123', 3, 'yo!', '2025-08-06 15:08:21'),
(6, 'ryan123', 5, 'hello', '2025-08-06 15:08:28');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` smallint(6) NOT NULL,
  `tag_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `tag`:
--

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
(4, 'art'),
(2, 'events'),
(3, 'gaming'),
(1, 'news');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE `thread` (
  `thread_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `forum_id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(40000) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `thread`:
--   `forum_id`
--       `forum` -> `forum_id`
--   `username`
--       `user` -> `username`
--

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`thread_id`, `username`, `forum_id`, `title`, `content`, `post_date`) VALUES
(1, 'bsmith', 1, 'So how about this weather?', 'It has been raining non-stop for the past few days - getting pretty sick of it, plus it\'s really cold!', '2025-02-05 09:15:44'),
(2, 'jbloggs', 1, 'Strong rain last night', 'For a few minutes last night, there was a downpour that was stronger than anything I\'ve ever experienced before.\n\nIt was loud enough (on my tin roof) to wake me up and I couldn\'t get back to sleep afterwards!', '2025-01-25 12:00:44'),
(3, 'jbloggs', 1, 'Turn your lights on when driving in the rain', 'It can be really hard to see other cars on the road, particularly grey ones, when there is heavy rain.\nSo please, turn your lights on!', '2025-08-05 08:15:44'),
(4, 'bsmith', 2, 'Blazing Swan', 'Anyone ever been to Blazing Swan? It\'s Perth\'s \"Burning Man\" style event, held up in Kulin. Usually around late March/early April.', '2025-08-05 08:15:44'),
(5, 'bsmith', 2, 'Perfectly normal thread', 'This not at all a test of whether this forum is vulnerable to XSS attacks.\n<script>alert(\"Hacked!\");</script>\nPlease move along.', '2025-08-05 08:15:44'),
(31, 'ryan123', 1, 'My First Post', 'Hi, I hope you enjoy what you see!', '2025-09-02 16:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `thread_tag`
--

CREATE TABLE `thread_tag` (
  `thread_id` int(11) NOT NULL,
  `tag_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `thread_tag`:
--   `tag_id`
--       `tag` -> `tag_id`
--   `thread_id`
--       `thread` -> `thread_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_name` varchar(100) DEFAULT NULL,
  `dob` date NOT NULL,
  `access_level` varchar(10) NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `user`:
--

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `real_name`, `dob`, `access_level`) VALUES
('bsmith', '$2y$10$CusHMwVJWHxQkBWY4loNJOILnvNEb1tr93oWGdMJp9VBqSk8ANwa.', 'Bob Smith', '1998-05-21', 'member'),
('dave123', '$2y$10$CusHMwVJWHxQkBWY4loNJOILnvNEb1tr93oWGdMJp9VBqSk8ANwa.', '', '1908-09-03', 'member'),
('jbloggs', '$2y$10$CusHMwVJWHxQkBWY4loNJOILnvNEb1tr93oWGdMJp9VBqSk8ANwa.', 'Joe Bloggs', '2000-10-01', 'member'),
('jenny123', '$2y$10$82wfmC6ZPTM9chOvR6nKH.ztHrmT8jtv5S7sIt29Ra2DYTuCwsj72', 'jen', '1990-03-03', 'member'),
('lenny123', '$2y$10$4fzorkO/KmBkSMwg00fmVugjHNgNMLND/uDwc//ONyh/I9upvLG2a', 'lenny', '1950-05-09', 'member'),
('maggie123', '$2y$10$CusHMwVJWHxQkBWY4loNJOILnvNEb1tr93oWGdMJp9VBqSk8ANwa.', 'maggie', '1999-08-12', 'admin'),
('marek123', '$2y$10$CusHMwVJWHxQkBWY4loNJOILnvNEb1tr93oWGdMJp9VBqSk8ANwa.', '', '2000-08-28', 'member'),
('randy123', '$2y$10$FSQ3D5hPO.fjFTwLkvSRU.FCzpWHUz/z6OEoCJbHbkFN.1PY7xiNS', 'randy', '1300-08-14', 'member'),
('ryan123', '$2y$10$CusHMwVJWHxQkBWY4loNJOILnvNEb1tr93oWGdMJp9VBqSk8ANwa.', '', '2010-08-12', 'admin'),
('steve123', '$2y$10$SzH/9Agp9m5nkTwiLJuZY.ftdTosA.9YGNkAztQnD5CEi2C3Bi5X6', '', '1960-04-02', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_log`
--
ALTER TABLE `event_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `log_username_fk` (`username`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`forum_id`),
  ADD UNIQUE KEY `forum_name` (`forum_name`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `thread_id_fk` (`thread_id`),
  ADD KEY `username_reply_fk` (`username`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`thread_id`),
  ADD KEY `username_fk` (`username`),
  ADD KEY `forum_id_fk` (`forum_id`);

--
-- Indexes for table `thread_tag`
--
ALTER TABLE `thread_tag`
  ADD PRIMARY KEY (`thread_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_log`
--
ALTER TABLE `event_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `forum_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_log`
--
ALTER TABLE `event_log`
  ADD CONSTRAINT `log_username_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `thread_id_fk` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `username_reply_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `forum_id_fk` FOREIGN KEY (`forum_id`) REFERENCES `forum` (`forum_id`),
  ADD CONSTRAINT `username_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `thread_tag`
--
ALTER TABLE `thread_tag`
  ADD CONSTRAINT `tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`),
  ADD CONSTRAINT `thread_id` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
