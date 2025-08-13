-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 13, 2025 at 09:00 PM
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
(5, 'bsmith', 2, 'Perfectly normal thread', 'This not at all a test of whether this forum is vulnerable to XSS attacks.\n<script>alert(\"Hacked!\");</script>\nPlease move along.', '2025-08-05 08:15:44');

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
('bsmith', 'Password1', 'Bob Smith', '1998-05-21', 'member'),
('dave123', 'password', '', '1908-09-03', 'member'),
('jbloggs', 'Abc12345', 'Joe Bloggs', '2000-10-01', 'member'),
('john1234', 'password', '', '1990-05-21', 'member'),
('maggie123', 'password', 'maggie', '1999-08-12', 'admin'),
('marek123', 'password', '', '2000-08-28', 'member'),
('ryan123', 'password', 'ryan', '2010-08-12', 'member');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `forum_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

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
