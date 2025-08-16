-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 16, 2025 at 07:27 PM
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
-- Database: `records_data`
--
CREATE DATABASE IF NOT EXISTS `records_data` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `records_data`;

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `album_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `artist` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  `release_year` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `album`:
--

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`album_id`, `title`, `artist`, `label`, `release_year`) VALUES
(1, 'What\'s Going On', 'Marvin Gaye', 'UMG Recordings', 1971),
(2, 'Texas Moon', 'Khruangbin', 'Columbia Records', 2022),
(3, 'Mixtape 1', 'Ryan', 'Garage Recordings', 2025),
(4, 'Mixtape 2', 'Ryan', 'Garage Recordings', 1960);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `username` varchar(50) NOT NULL,
  `album_id` int(11) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `comment`:
--   `album_id`
--       `album` -> `album_id`
--   `username`
--       `user` -> `username`
--

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`username`, `album_id`, `content`, `created_at`, `comment_id`) VALUES
('ryan123', 1, 'testing this comment out', '2025-08-10 12:10:36', 4),
('ryan123', 1, 'hello again!', '2025-08-10 12:11:01', 5),
('ryan123', 1, 'love this album', '2025-08-10 12:14:47', 6),
('ryan123', 3, 'hi', '2025-08-10 12:29:23', 7),
('ryan123', 3, 'its me', '2025-08-10 12:29:30', 8),
('ryan123', 1, 'soi', '2025-08-10 12:49:39', 9),
('testing', 3, '🔥', '2025-08-10 16:11:34', 11),
('ryan123', 3, 'oimerf', '2025-08-11 17:13:01', 16),
('ryan123', 3, 'test', '2025-08-13 15:10:20', 17);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(50) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `event_details` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `log`:
--

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `log_date`, `ip_address`, `event_type`, `event_details`) VALUES
(1, '2025-08-15 16:40:46', '::1', 'Member Registration', 'fred123 registered as a member'),
(2, '2025-08-15 18:49:43', '::1', 'Member Registration', 'nolan123 registered as a member'),
(3, '2025-08-15 18:54:01', '::1', 'Logout', 'nolan123 logged out'),
(5, '2025-08-15 18:55:04', '::1', 'Login Attempt', 'Failed login attempt with username of owienf'),
(6, '2025-08-15 18:55:24', '::1', 'Login', 'ryan123 logged in'),
(7, '2025-08-15 21:25:18', '::1', 'Logout', 'ryan123 logged out'),
(8, '2025-08-15 21:25:38', '::1', 'Login', 'admin123 logged in'),
(11, '2025-08-15 21:29:44', '::1', 'Album Deleted', 'erofp (1999) deleted by admin123'),
(12, '2025-08-16 09:01:30', '::1', 'Album Added', 'test (1950) added by admin123'),
(13, '2025-08-16 09:01:30', '::1', 'Tracks Added', '3 tracks added for test (1950)'),
(14, '2025-08-16 15:37:22', '::1', 'Logout', 'ryan123 logged out'),
(15, '2025-08-16 15:37:54', '::1', 'Login', 'fred123 logged in'),
(16, '2025-08-16 17:10:04', '::1', 'Logout', 'fred123 logged out'),
(17, '2025-08-16 17:10:11', '::1', 'Login', 'ryan123 logged in'),
(18, '2025-08-16 17:17:39', '::1', 'Logout', 'ryan123 logged out'),
(19, '2025-08-16 17:17:49', '::1', 'Login Attempt', 'Failed login attempt with username of testing@gmail.com'),
(20, '2025-08-16 17:17:56', '::1', 'Login', 'testing logged in');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `album_id` int(11) UNSIGNED NOT NULL,
  `value` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `rating`:
--   `album_id`
--       `album` -> `album_id`
--   `username`
--       `user` -> `username`
--

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating_id`, `username`, `album_id`, `value`, `created_at`) VALUES
(4, 'ryan123', 3, 3, '2025-08-13 15:10:16'),
(12, 'ryan123', 1, 3, '2025-08-10 15:54:55'),
(38, 'testing', 1, 1, '2025-08-10 16:10:06'),
(41, 'testing', 3, 5, '2025-08-10 16:10:20'),
(44, 'admin123', 1, 3, '2025-08-11 14:40:56'),
(45, 'admin123', 3, 5, '2025-08-11 14:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE `track` (
  `track_id` int(10) UNSIGNED NOT NULL,
  `album_id` int(10) UNSIGNED NOT NULL,
  `duration_sec` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `track_no` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `track`:
--   `album_id`
--       `album` -> `album_id`
--

--
-- Dumping data for table `track`
--

INSERT INTO `track` (`track_id`, `album_id`, `duration_sec`, `title`, `track_no`) VALUES
(1, 1, 233, 'What\'s Going On', 1),
(2, 1, 197, 'What\'s Happening Brother', 2),
(3, 1, 195, 'Flyin\' High (In the Friendly Sky)', 3),
(4, 1, 200, 'Save the Children', 4),
(5, 1, 213, 'God Is Love', 5),
(6, 1, 234, 'Mercy Mercy Me (The Ecology)', 6),
(7, 1, 211, 'Right On', 7),
(8, 1, 181, 'Wholy Holy', 8),
(9, 1, 229, 'Inner City Blues (Make Me Wanna Holler)', 9),
(10, 2, 214, 'Doris', 1),
(11, 2, 223, 'B-Side', 2),
(12, 2, 225, 'Chocolate Hills', 3),
(13, 2, 190, 'Father Father', 4),
(14, 2, 234, 'Mariella', 5),
(21, 3, 99, 'Untitled 1', 1),
(22, 3, 201, 'Untitled 2', 2),
(23, 3, 149, 'Untitled 3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `profile` text DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `access_level` varchar(10) NOT NULL DEFAULT 'member',
  `favourite_album_id` int(11) UNSIGNED DEFAULT NULL,
  `favourite_track_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `user`:
--   `favourite_album_id`
--       `album` -> `album_id`
--   `favourite_track_id`
--       `track` -> `track_id`
--

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password_hash`, `date_of_birth`, `profile`, `email`, `access_level`, `favourite_album_id`, `favourite_track_id`) VALUES
('admin123', '$2y$10$FHOonII3umtI0qUedsusQeZQ1m03dPvux7PGTZa7SbyP.a84z.Z/u', '1001-01-01', 'I\'m the friendly admin!', 'admin123@gmail.com', 'admin', NULL, NULL),
('fred123', '$2y$10$3b3XihiBCZpu1BnOPlrs/.0Y8Lia1i2NdHsj5RyH08J2ZX.mfRqj6', '1987-04-14', '', 'fred@gmail.com', 'member', 1, 21),
('ryan123', '$2y$10$C20oexl8DjVaMHhn4UM5COhNojLxuQ5v3YMJtZgrA18IBViKPq602', '1909-08-19', 'Hi there, welcome to my profile!', 'ryan@gmail.com', 'member', 4, 14),
('testing', '$2y$10$x4qj8jT5MmX68tvXf4Q9gOd/zmliQsyox/IbRpljadb3cA5wBZXgO', '1909-04-21', 'hello!', 'testing@gmail.com', 'member', 2, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`album_id`),
  ADD UNIQUE KEY `title_year_unique` (`title`,`release_year`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_album_fk` (`album_id`),
  ADD KEY `comment_username_fk` (`username`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD UNIQUE KEY `username_album_id_uni` (`username`,`album_id`),
  ADD KEY `rating_album_fk` (`album_id`);

--
-- Indexes for table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`track_id`),
  ADD UNIQUE KEY `album_title_unique` (`album_id`,`title`),
  ADD UNIQUE KEY `album_track_no_unique` (`album_id`,`track_no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_album_fk` (`favourite_album_id`),
  ADD KEY `user_track_id` (`favourite_track_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `album_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `track`
--
ALTER TABLE `track`
  MODIFY `track_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_album_fk` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_username_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_album_fk` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_username_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `track`
--
ALTER TABLE `track`
  ADD CONSTRAINT `album_track_fk` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_album_fk` FOREIGN KEY (`favourite_album_id`) REFERENCES `album` (`album_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_track_id` FOREIGN KEY (`favourite_track_id`) REFERENCES `track` (`track_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
