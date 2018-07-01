-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2018 at 08:07 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instagram`
--

-- --------------------------------------------------------

--
-- Table structure for table `likes_table`
--

CREATE TABLE `likes_table` (
  `like_id` int(8) NOT NULL,
  `post_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `caption` varchar(10000) NOT NULL,
  `filename` varchar(1000) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `caption`, `filename`, `Time`) VALUES
(1, 1, 'Panda Heart <3', '1_codepanda.png', '2018-06-07 03:53:34'),
(2, 1, 'Love', '1_dp.jpg', '2018-06-08 03:53:34'),
(3, 1, 'Pink Flower', '1_829571-new-computer-backgrounds-flowers-2880x1800-laptop.jpg', '2018-06-09 03:53:34'),
(4, 1, 'Pink Sunflower', '1_gerbera-daisies-16.jpg', '2018-06-10 03:53:34'),
(5, 1, 'Sweet Cartoon', '1_cute-love-hd-wallpaper-wide-screen.jpg', '2018-06-11 03:53:34'),
(6, 1, 'Wedding', '1_IMG_6641.JPG', '2018-06-12 03:53:34'),
(7, 2, 'Vintage', '2_sample.jpg', '2018-06-13 03:53:34'),
(8, 2, 'Toy Car', '2_toycar.jpg', '2018-06-14 03:53:34'),
(9, 2, 'Sunrise', '2_Beautiful-Sunrise-Wallpaper.jpg', '2018-06-14 23:53:34'),
(10, 2, 'Beautiful <3 <3 <3', '2_IMG_6056.JPG', '2018-06-15 00:53:34'),
(11, 3, 'ATE', '3_WIN_20180228_21_06_03_Pro.jpg', '2018-06-15 01:53:34'),
(12, 3, 'Kuya', '3_IMG_5533.jpg', '2018-06-15 06:53:34'),
(13, 3, 'Very Good', '3_aja.jpg', '2018-06-15 08:53:34'),
(14, 3, 'Pogi', '3_aja3.jpg', '2018-06-15 20:53:34'),
(15, 4, 'loools', '4_a.jpg', '2018-06-16 03:53:34'),
(16, 2, 'pixelated', '2_pixelated.png', '2018-06-16 04:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(8) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(16) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_picture` varchar(500) NOT NULL,
  `privacy` varchar(10) NOT NULL DEFAULT 'public'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `middlename`, `lastname`, `email`, `profile_picture`, `privacy`) VALUES
(1, 'chescasison_', 'chesca', 'Francesca Louise', 'Chu', 'Sison', 'sisonfrancescalouise@gmail.com', '1_IMG_6056.JPG', 'private'),
(2, 'kimhowel_', 'kimhowel', 'Kim Howel', 'Dimaano', 'Delos Reyes', 'dr.kimhowel@gmail.com', '2_IMG_5533.jpg', 'public'),
(3, 'elijahgray_', 'elijah', 'Elijah Gray', 'Sison', 'Pascua', 'elijahgray@gmail.com', '3_aja2.jpg', 'public'),
(4, 'hellonatnat', 'bbexo2ne1', 'Natalie Jane', 'Chu', 'Sison', 'sisonnataliejane28@gmail.com', '4_a.jpg', 'private');

-- --------------------------------------------------------

--
-- Table structure for table `users_relationship`
--

CREATE TABLE `users_relationship` (
  `relationship_id` int(8) NOT NULL,
  `user_who_follow` int(8) NOT NULL,
  `user_being_followed` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_relationship`
--

INSERT INTO `users_relationship` (`relationship_id`, `user_who_follow`, `user_being_followed`) VALUES
(1, 2, 1),
(3, 1, 2),
(4, 3, 1),
(5, 4, 3),
(6, 3, 4),
(7, 2, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `likes_table`
--
ALTER TABLE `likes_table`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_relationship`
--
ALTER TABLE `users_relationship`
  ADD PRIMARY KEY (`relationship_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `likes_table`
--
ALTER TABLE `likes_table`
  MODIFY `like_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_relationship`
--
ALTER TABLE `users_relationship`
  MODIFY `relationship_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
