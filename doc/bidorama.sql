-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 05:52 AM
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
-- Database: `bidorama`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

CREATE TABLE `auction` (
  `auction_id` bigint(20) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `starting_bid` int(11) DEFAULT NULL,
  `highest_bid` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `owner_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auction`
--

INSERT INTO `auction` (`auction_id`, `title`, `description`, `starting_bid`, `highest_bid`, `start_date`, `end_date`, `owner_id`) VALUES
(1, 'Antique Watch', 'A vintage watch from the 1920s.', 100, 156, '2023-01-01', '2023-01-10', 1),
(2, 'Rare Painting', 'An original painting by a renowned artist.', 500, 800, '2023-02-01', '2023-02-15', 2),
(3, 'Classic Car', '1950s convertible in pristine condition.', 10000, 12000, '2023-03-01', '2023-03-20', 3),
(4, 'car', 'test', 4, 4, '2023-12-13', '2023-12-28', 13);

-- --------------------------------------------------------

--
-- Table structure for table `auctionbid`
--

CREATE TABLE `auctionbid` (
  `bid_id` bigint(20) NOT NULL,
  `auction_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `bid_amount` int(11) DEFAULT NULL,
  `bid_date` date DEFAULT NULL,
  `winning_flag` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auctionbid`
--

INSERT INTO `auctionbid` (`bid_id`, `auction_id`, `user_id`, `bid_amount`, `bid_date`, `winning_flag`) VALUES
(1, 1, 2, 120, '2023-01-05', 'N'),
(2, 2, 3, 750, '2023-02-05', 'Y'),
(3, 3, 1, 11000, '2023-03-10', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `auctionimagerelationship`
--

CREATE TABLE `auctionimagerelationship` (
  `auction_id` bigint(20) NOT NULL,
  `image_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auctionimagerelationship`
--

INSERT INTO `auctionimagerelationship` (`auction_id`, `image_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1),
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bidoramauser`
--

CREATE TABLE `bidoramauser` (
  `user_id` bigint(20) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `street` varchar(128) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `state` varchar(64) DEFAULT NULL,
  `bio` varchar(512) DEFAULT NULL,
  `image_id` bigint(20) DEFAULT NULL,
  `permission` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bidoramauser`
--

INSERT INTO `bidoramauser` (`user_id`, `username`, `password`, `firstname`, `lastname`, `email`, `street`, `city`, `state`, `bio`, `image_id`, `permission`) VALUES
(11, 'test', '$2y$10$VybYwAtq2r5KLxhHiGRkSutsY/triYFzWnc8yLMIh8j0ZsfurBFJ.', 'Brandon', 'Cooper', 'brandoncooper859@gmail.com', '53 Showalter Trace', 'Walton', '...', '', 1, 1),
(12, 'e', '$2y$10$pPBLGER39a.9..lLJL4WsezfUuM2DpAXXM.cOXBc65Xu8qdonZj8C', 'e', 'e', 'e@gmail.com', 'e', 'e', '...', '', 1, 0),
(13, 't', '$2y$10$4Yz6DLo5J6swZ5eXKEZ.POv5tRORLbsVwD8DwuF3unzL9.j19Rdji', 't', 't', 'test@gmail.com', 't', 't', '...', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contactsection`
--

CREATE TABLE `contactsection` (
  `contact_id` bigint(20) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `message` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactsection`
--

INSERT INTO `contactsection` (`contact_id`, `name`, `email`, `message`) VALUES
(1, 'John Doe', 'john@example.com', 'I have a question about an ongoing auction.'),
(2, 'Jane Smith', 'jane@example.com', 'I need assistance with my account.'),
(3, 'Customer Support', 'support@bidorama.com', 'We appreciate your feedback. Reach out to us anytime.');

-- --------------------------------------------------------

--
-- Table structure for table `faqsection`
--

CREATE TABLE `faqsection` (
  `faq_id` bigint(20) NOT NULL,
  `question` varchar(256) DEFAULT NULL,
  `response` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqsection`
--

INSERT INTO `faqsection` (`faq_id`, `question`, `response`) VALUES
(1, 'How do I place a bid?', 'To place a bid, navigate to the auction page and enter your bid amount.'),
(2, 'What happens if I win an auction?', 'If you win, you will be notified, and the auction details will be provided.'),
(3, 'Can I cancel a bid?', 'No, bids are final and cannot be canceled. Please bid responsibly.'),
(4, 'How do I place a bid????', 'To place a bid, navigate to the auction page and enter your bid amount.???');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `image_id` bigint(20) NOT NULL,
  `image_name` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`image_id`, `image_name`) VALUES
(1, '385704.jpg'),
(2, '671388.jpg'),
(3, '09.jpg'),
(12, '168157.jpg'),
(13, NULL),
(14, NULL),
(15, '190845.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `landingsection`
--

CREATE TABLE `landingsection` (
  `landing_id` bigint(20) NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `content` varchar(512) DEFAULT NULL,
  `image_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `landingsection`
--

INSERT INTO `landingsection` (`landing_id`, `title`, `content`, `image_id`) VALUES
(4, 'Get Bidding!', '\"Embrace the thrill of the auction, seize the moment, and bid boldly to make that coveted item yours!\"', 1),
(5, 'Bid... Laugh... Love!', '\"Bid, laugh, and love the excitement of auctions as you uncover treasures and create memorable moments on our platform!\" - Jesus, 5 B.C.\r\n', 2),
(13, 'Meet Your Princess!', 'Lord Farquaad, in his grandiose castle, believed not in fate but in the certainty of his magic mirror. \"Mirror, mirror, on the wall,\" he\'d command, seeking not just any love, but the perfect fairy-tale ending.', 11),
(14, 'Available at any time of the day!', 'Explore our platform\'s offerings, available at any time of the day, ensuring you can indulge in the thrill of auctions whenever it suits you!', 12),
(15, 'test', 'test2', 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`auction_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `auctionbid`
--
ALTER TABLE `auctionbid`
  ADD PRIMARY KEY (`bid_id`),
  ADD KEY `auction_id` (`auction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auctionimagerelationship`
--
ALTER TABLE `auctionimagerelationship`
  ADD PRIMARY KEY (`auction_id`,`image_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `bidoramauser`
--
ALTER TABLE `bidoramauser`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `contactsection`
--
ALTER TABLE `contactsection`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `faqsection`
--
ALTER TABLE `faqsection`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `landingsection`
--
ALTER TABLE `landingsection`
  ADD PRIMARY KEY (`landing_id`),
  ADD KEY `image_id` (`image_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auction`
--
ALTER TABLE `auction`
  MODIFY `auction_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `auctionbid`
--
ALTER TABLE `auctionbid`
  MODIFY `bid_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bidoramauser`
--
ALTER TABLE `bidoramauser`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contactsection`
--
ALTER TABLE `contactsection`
  MODIFY `contact_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `faqsection`
--
ALTER TABLE `faqsection`
  MODIFY `faq_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `image_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `landingsection`
--
ALTER TABLE `landingsection`
  MODIFY `landing_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
