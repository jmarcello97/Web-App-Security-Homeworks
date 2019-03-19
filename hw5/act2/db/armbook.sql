-- phpMyAdmin SQL Dump
-- version 4.1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2016 at 12:15 PM
-- Server version: 5.6.15
-- PHP Version: 5.6.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `armbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `from`, `to`, `message`, `sent`, `recd`) VALUES
(1, 'everybody', 'everybody', 'test', '2011-03-31 01:20:49', 0),
(2, 'everybody', 'everybody', 'hi', '2011-03-31 01:20:54', 0),
(3, 'everybody', 'everybody', 'hi', '2011-03-31 01:21:07', 0),
(4, 'everybody', 'everybody', 'hi', '2011-03-31 01:21:12', 0),
(5, 'everybody', 'everybody', 'hi', '2011-03-31 01:21:52', 0),
(6, 'everybody', 'everybody', 'Shit', '2011-03-31 01:23:55', 0),
(7, 'everybody', 'everybody', 'test', '2011-03-31 01:24:12', 0),
(8, 'everybody', 'everybody', 'hey', '2011-03-31 01:27:37', 0),
(9, 'everybody', 'everybody', 'Way to go slow refreash', '2011-03-31 01:27:48', 0),
(10, 'everybody', 'everybody', '<script>alert(''test'');</script>', '2011-03-31 01:28:34', 0),
(11, 'everybody', 'everybody', 'test2', '2011-03-31 01:30:01', 0),
(12, 'everybody', 'everybody', 'test2', '2011-03-31 01:30:07', 0),
(13, 'everybody', 'everybody', 'test3', '2011-03-31 01:30:34', 0),
(14, 'everybody', 'everybody', 'test', '2011-03-31 10:46:33', 0),
(15, 'everybody', 'everybody', 'hey', '2011-03-31 10:50:34', 0),
(16, 'everybody', 'everybody', 'jamie', '2011-03-31 10:50:36', 0),
(17, 'everybody', 'everybody', 'jamie', '2011-03-31 10:50:52', 0),
(18, 'everybody', 'everybody', 'wow', '2011-03-31 10:50:56', 0),
(19, 'everybody', 'everybody', 'yeah', '2011-03-31 10:50:58', 0),
(20, 'everybody', 'everybody', 'i still have to fix names', '2011-03-31 10:51:01', 0),
(21, 'everybody', 'everybody', 'but that is it', '2011-03-31 10:51:03', 0),
(22, 'everybody', 'everybody', 'yeah you do', '2011-03-31 10:51:05', 0),
(23, 'everybody', 'everybody', ':)', '2011-03-31 10:51:08', 0),
(24, 'everybody', 'everybody', 'boo', '2011-03-31 10:52:24', 0),
(25, 'everybody', 'everybody', 'hey', '2011-03-31 11:03:13', 0),
(26, 'everybody', 'everybody', 'hey', '2011-03-31 11:21:04', 0),
(27, 'everybody', 'everybody', 'meow', '2011-03-31 12:03:26', 0),
(28, 'everybody', 'everybody', 'hi', '2011-03-31 12:03:28', 0),
(29, 'everybody', 'everybody', 'hi', '2011-03-31 12:03:29', 0),
(30, 'everybody', 'everybody', 'hey rusty', '2011-03-31 12:03:47', 0),
(31, 'everybody', 'everybody', 'hi', '2011-03-31 12:04:32', 0),
(32, 'everybody', 'everybody', 'talk to me', '2011-03-31 12:04:36', 0),
(33, 'everybody', 'everybody', 'everrrrrybody', '2011-03-31 12:04:39', 0),
(34, 'everybody', 'everybody', 'whatsup?', '2011-03-31 12:04:42', 0),
(35, 'everybody', 'everybody', 'i hate this class :D', '2011-03-31 12:04:46', 0),
(36, 'everybody', 'everybody', 'me too', '2011-03-31 12:04:50', 0),
(37, 'everybody', 'everybody', ':)', '2011-03-31 12:04:50', 0),
(38, 'everybody', 'everybody', 'shmooooooo group', '2011-03-31 12:05:06', 0),
(39, 'everybody', 'everybody', 'ok', '2011-03-31 12:05:23', 0),
(40, 'everybody', 'everybody', 'hey', '2011-03-31 14:03:47', 0),
(41, 'everybody', 'everybody', 'hey', '2011-03-31 22:57:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `chathist`
--

CREATE TABLE IF NOT EXISTS `chathist` (
  `chat_id` int(11) NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  `user3` int(11) NOT NULL,
  `user4` int(11) NOT NULL,
  `user5` int(11) NOT NULL,
  `user6` int(11) NOT NULL,
  `user7` int(11) NOT NULL,
  `user8` int(11) NOT NULL,
  `user9` int(11) NOT NULL,
  `user10` int(11) NOT NULL,
  `user11` int(11) NOT NULL,
  `user12` int(11) NOT NULL,
  `user13` int(11) NOT NULL,
  `user14` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chathist`
--

INSERT INTO `chathist` (`chat_id`, `user1`, `user2`, `user3`, `user4`, `user5`, `user6`, `user7`, `user8`, `user9`, `user10`, `user11`, `user12`, `user13`, `user14`) VALUES
(1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(3, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(6, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(7, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(8, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(9, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(10, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(11, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(12, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(13, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
(14, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(15, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(16, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(17, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(18, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(19, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(20, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(21, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(22, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(23, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(24, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1),
(25, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(26, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(27, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(28, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(29, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(31, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(32, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(33, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(34, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(35, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(36, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(37, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(38, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(39, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(40, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(41, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `Workplace` varchar(255) NOT NULL,
  `School` varchar(255) NOT NULL,
  `Phone` varchar(64) NOT NULL,
  `Interest` varchar(64) NOT NULL,
  `Relationship` int(11) NOT NULL,
  `Interested_In` varchar(64) NOT NULL,
  `ScreenName` varchar(64) NOT NULL,
  PRIMARY KEY (`info_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`info_id`, `user_id`, `Workplace`, `School`, `Phone`, `Interest`, `Relationship`, `Interested_In`, `ScreenName`) VALUES
(1, 1, 'None', 'RIT', '585-201-8080', 'Computers, Information Security', -1, 'Aliens', 'Slashgames'),
(2, 2, 'None', 'None', 'None', 'None', -1, 'None', 'None'),
(3, 8, 'None', 'None', 'None', 'None', -1, 'None', 'None'),
(4, 9, 'None', 'None', 'None', 'None', -1, 'None', 'None'),
(5, 10, 'None', 'None', 'None', 'None', -1, 'None', 'None'),
(6, 11, 'None', 'None', 'None', 'None', -1, 'None', 'None'),
(8, 3, 'te', 'te2', 'te3', 'te4', 2, 'te5', 'te6'),
(10, 12, 'None', 'Rochester institute of technology', 'None', 'None', -1, 'Women', 'None'),
(11, 4, 'test', 'test2', 'test3', 'Computers', -1, 'Aliens', 'Slashgames'),
(12, 13, 'None', 'None', 'None', 'None', -1, 'None', 'None'),
(13, 14, 'None', 'None', 'None', 'None', -1, 'None', 'None');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_from` int(11) NOT NULL,
  `user_id_to` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id_from`, `user_id_to`, `text`) VALUES
(1, 1, 2, 'Hey Neil'),
(2, 2, 1, 'Hey Chaim'),
(3, 1, 2, 'You suck'),
(4, 2, 1, 'No, you suck'),
(5, 1, 5, 'Jacob is stupid'),
(6, 1, 7, 'hey baby'),
(7, 1, 2, 'your a bitch'),
(8, 9, 7, 'Hello'),
(9, 1, 2, '<?sc<x>ript>'),
(10, 1, 2, 'hey'),
(11, 1, 2, ';;'),
(12, 10, 1, 'YOU R WEIRD'),
(13, 1, 2, 'hey'),
(15, 12, 1, 'Post'),
(17, 1, 13, 'hey jamie you suck'),
(19, 13, 1, 'i love you'),
(20, 12, 12, 'test'),
(21, 12, 12, 'hello'),
(22, 12, 12, 'another test'),
(23, 12, 9, 'hi test'),
(24, 12, 12, 'nothing right now'),
(25, 12, 12, 'test'),
(26, 12, 12, 'new post'),
(27, 12, 12, 'testing');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `picture_url` varchar(255) NOT NULL,
  `Friends` text NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profile_id`, `user_id`, `picture_url`, `Friends`) VALUES
(1, 1, 'images/arm_stock.jpg', '2,1,9,5,10,12,13'),
(2, 2, 'images/arm_stock.jpg', '1,2,7'),
(4, 4, 'images/arm_stock.jpg', '4'),
(3, 5, 'images/arm_stock.jpg', '5,1'),
(5, 6, 'images/arm_stock.jpg', '6'),
(6, 7, 'images/arm_stock.jpg', '7,2'),
(7, 8, 'images/arm_stock.jpg', '8'),
(8, 9, 'images/arm_stock.jpg', '9,1'),
(9, 10, 'images/arm_stock.jpg', '10,1'),
(10, 11, 'images/arm_stock.jpg', '11'),
(11, 12, 'http://www.timeslive.co.za/incoming/2015/10/20/arm.jpg/ALTERNATES/crop_630x400/arm.jpg', '12,1,9,12'),
(12, 13, 'images/arm_stock.jpg', '13,1'),
(13, 14, 'images/arm_stock.jpg', '14'),
(14, 3, 'images/arm_stock.jpg', '1,2');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`status_id`, `user_id`, `text`) VALUES
(1, 1, 'hey'),
(2, 2, 'Going fishing'),
(3, 6, ''),
(4, 7, 'loving'),
(5, 8, ''),
(6, 9, 'test'),
(7, 10, ''),
(8, 11, 'nothing'),
(9, 12, 'Post3'),
(10, 13, 'boo'),
(11, 14, 'Feeling crazy :D');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `sex` int(1) NOT NULL,
  `birthday_month` int(2) NOT NULL,
  `birthday_day` int(2) NOT NULL,
  `birthday_year` int(4) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `firstname`, `lastname`, `sex`, `birthday_month`, `birthday_day`, `birthday_year`) VALUES
(1, 'ces1509@rit.edu', 'password', 'Jon', 'Doe', 1, 10, 2, 1988),
(2, 'neil@neil.com', 'password', 'neil', 'zimmerman', 1, 10, 2, 1988),
(6, 'csanders@sparsa.org', 'password', 'Grant', 'Batchlor', 2, -1, -1, -1),
(4, 'chaim.sanders@gmail.com', 'password', 'Jon', 'Mccall', 2, -1, -1, -1),
(5, 'jruppal@gmail.com', 'password', 'Jacob', 'Ruppal', 2, -1, -1, -1),
(7, 'griffith.chaffee@gmail.com', 'password', 'griffith', 'chaffee', 2, 1, 2, 1982),
(8, 'andy@culler.com', 'password', 'Andy', 'Culler', 2, -1, -1, -1),
(9, 'test@test.com', 'password', 'test', 'test', 2, -1, -1, -1),
(10, 'bsmith@gmail.com', 'password', 'Bob', 'Smith', 1, 1, 1, 1950),
(11, 'test2@test.com', 'password', 'test2', 'test2', 2, -1, -1, -1),
(13, 'jrr@foobar.com', 'password', 'Jamie', 'Richard', 2, 3, 28, 1987),
(14, 'rbower@sparsa.org', 'password', 'Rusty', 'Bower', 2, 1, 1, 1950),
(12, 'chaim@chaim.com', 'password', 'chaim', 'sanders', 1, 3, 2, 1988);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
