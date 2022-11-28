-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 04:05 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social`
--
CREATE DATABASE IF NOT EXISTS `social` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `social`;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentId` int(11) NOT NULL,
  `commentContent` longtext NOT NULL,
  `postId` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `commentlike`
--

CREATE TABLE `commentlike` (
  `likeId` int(11) NOT NULL,
  `commentId` int(11) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friendId` int(11) NOT NULL,
  `friendUsername` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`friendId`, `friendUsername`, `username`) VALUES
(1, 'Grugg', 'Grugg'),
(2, 'Krugg', 'Krugg'),
(3, 'Goblin_Tom', 'Goblin_Tom'),
(4, 'tripp', 'tripp'),
(5, 'Grugg', 'tripp'),
(6, 'Krugg', 'tripp'),
(7, 'Goblin_Tom', 'tripp'),
(8, 'tripp', 'Grugg'),
(9, 'tripp', 'Krugg'),
(10, 'tripp', 'Goblin_Tom');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postId` int(11) NOT NULL,
  `postContent` longtext NOT NULL,
  `username` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postId`, `postContent`, `username`, `date`) VALUES
(1, 'Goblin do no bad. Goblin only want eat trash and take shiny gold. Why people no like goblin? World make Grugg sad :(', 'Grugg', '2022-11-28 09:03:20'),
(2, 'KRUUUUUUUUUGGGGGG IS DA BEST, OH YEAH BABY!!!!', 'Krugg', '2022-11-28 09:03:20'),
(3, 'Welcome to the den, fellow goblin!', 'Goblin_Tom', '2022-11-28 09:03:20'),
(4, 'who got dat gold?', 'tripp', '2022-11-28 09:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `postlike`
--

CREATE TABLE `postlike` (
  `likeId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `likedBy` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `postlike`
--

INSERT INTO `postlike` (`likeId`, `postId`, `likedBy`) VALUES
(1, 3, 'tripp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(60) NOT NULL,
  `profilePic` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `fName`, `lName`, `email`, `password`, `profilePic`) VALUES
('Goblin_Tom', 'Tommy', 'McGoblin', 'tom@myspace.com', '$2y$10$bzF8EmkA2xY/6Yg2VTSuqOyL8w25nbe51azppUizXBFX8OfWpMyZK', 'goblin4.png'),
('Grugg', 'Grug', 'Gruggerson', 'grug@hotmail.com', '$2y$10$7na2EnNVM.3jckVYm0dcyuwoPAOKL9R/LwWc/e6jzv/9NgZvijR1i', 'goblin5.png'),
('Krugg', 'Kris', 'Gruggerson', 'krug@hotmail.com', '$2y$10$RvhSpji66SiN9up8EfZ5y.D0QSpzrMgVk8w1.ZJJWhdsBuMxrpjpm', 'goblin2.png'),
('tripp', 'james', 'tillman', 'tripp@aol.com', '$2y$10$gcNhc6opJcZvzecrY6onIeIxDICLaYlcE3.L2FLt4GmJ7uHl7U7gi', 'goblin1.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `username` (`username`),
  ADD KEY `postId` (`postId`);

--
-- Indexes for table `commentlike`
--
ALTER TABLE `commentlike`
  ADD PRIMARY KEY (`likeId`),
  ADD KEY `username` (`username`),
  ADD KEY `commentId` (`commentId`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friendId`),
  ADD KEY `username` (`username`),
  ADD KEY `friendUsername` (`friendUsername`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postId`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `postlike`
--
ALTER TABLE `postlike`
  ADD PRIMARY KEY (`likeId`),
  ADD KEY `likedBy` (`likedBy`),
  ADD KEY `postId` (`postId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commentlike`
--
ALTER TABLE `commentlike`
  MODIFY `likeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friendId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `postlike`
--
ALTER TABLE `postlike`
  MODIFY `likeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`postId`) REFERENCES `post` (`postId`);

--
-- Constraints for table `commentlike`
--
ALTER TABLE `commentlike`
  ADD CONSTRAINT `commentlike_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `commentlike_ibfk_2` FOREIGN KEY (`commentId`) REFERENCES `comment` (`commentId`);

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friendUsername`) REFERENCES `users` (`username`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `postlike`
--
ALTER TABLE `postlike`
  ADD CONSTRAINT `postlike_ibfk_1` FOREIGN KEY (`likedBy`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `postlike_ibfk_2` FOREIGN KEY (`postId`) REFERENCES `post` (`postId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
