-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2021 at 03:58 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iwd_security_examples`
--
CREATE DATABASE IF NOT EXISTS `iwd_security_examples` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `iwd_security_examples`;

-- --------------------------------------------------------

--
-- Table structure for table `csrf_account`
--

CREATE TABLE `csrf_account` (
  `acc_num` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `csrf_account`:
--

--
-- Dumping data for table `csrf_account`
--

INSERT INTO `csrf_account` (`acc_num`, `username`, `balance`) VALUES
(111111111, 'victim1', '10000.00'),
(111111112, 'victim2', '25000.00'),
(123456789, 'hackerman', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `csrf_transaction`
--

CREATE TABLE `csrf_transaction` (
  `transaction_id` int(11) NOT NULL,
  `from_acc` int(11) NOT NULL,
  `to_acc` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `transfer_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `csrf_transaction`:
--   `from_acc`
--       `csrf_account` -> `acc_num`
--   `to_acc`
--       `csrf_account` -> `acc_num`
--

-- --------------------------------------------------------

--
-- Table structure for table `sqli_transaction`
--

CREATE TABLE `sqli_transaction` (
  `id` int(11) NOT NULL,
  `pay_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(13,2) NOT NULL,
  `description` varchar(100) NOT NULL,
  `sent_by` varchar(20) NOT NULL,
  `sent_to` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `sqli_transaction`:
--

--
-- Dumping data for table `sqli_transaction`
--

INSERT INTO `sqli_transaction` (`id`, `pay_date`, `amount`, `description`, `sent_by`, `sent_to`) VALUES
(1, '2021-01-11 16:32:19', '25.00', 'tennis', 'jbloggs', 'bsmith'),
(2, '2021-02-15 17:17:23', '47.00', 'dinner', 'bsmith', 'lwoods'),
(3, '2021-01-23 19:11:39', '100.00', 'netflix', 'bsmith', 'jbloggs'),
(4, '2021-01-29 19:23:44', '41.00', 'wine', 'jbloggs', 'mjones'),
(5, '2021-02-15 17:16:11', '25.00', 'tennis', 'mjones', 'bsmith'),
(6, '2021-02-15 16:27:35', '25.00', 'tennis', 'jbloggs', 'bsmith');

-- --------------------------------------------------------

--
-- Table structure for table `xss_article`
--

CREATE TABLE `xss_article` (
  `article_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `xss_article`:
--

--
-- Dumping data for table `xss_article`
--

INSERT INTO `xss_article` (`article_id`, `title`, `content`, `post_date`) VALUES
(1, 'Important News About Dogs', 'They\'re pretty great.', '2021-07-17 03:58:58'),
(2, 'Important News About Cats', 'They\'re also pretty great.', '2021-07-19 09:25:58');

-- --------------------------------------------------------

--
-- Table structure for table `xss_comment`
--

CREATE TABLE `xss_comment` (
  `comment_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `name` varchar(50) NOT NULL,
  `article_id` int(11) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `xss_comment`:
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `csrf_account`
--
ALTER TABLE `csrf_account`
  ADD PRIMARY KEY (`acc_num`);

--
-- Indexes for table `csrf_transaction`
--
ALTER TABLE `csrf_transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `to_acc_fk` (`to_acc`),
  ADD KEY `from_acc_fk` (`from_acc`);

--
-- Indexes for table `sqli_transaction`
--
ALTER TABLE `sqli_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xss_article`
--
ALTER TABLE `xss_article`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `xss_comment`
--
ALTER TABLE `xss_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `csrf_transaction`
--
ALTER TABLE `csrf_transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sqli_transaction`
--
ALTER TABLE `sqli_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `xss_article`
--
ALTER TABLE `xss_article`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `xss_comment`
--
ALTER TABLE `xss_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `csrf_transaction`
--
ALTER TABLE `csrf_transaction`
  ADD CONSTRAINT `from_acc_fk` FOREIGN KEY (`from_acc`) REFERENCES `csrf_account` (`acc_num`),
  ADD CONSTRAINT `to_acc_fk` FOREIGN KEY (`to_acc`) REFERENCES `csrf_account` (`acc_num`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
