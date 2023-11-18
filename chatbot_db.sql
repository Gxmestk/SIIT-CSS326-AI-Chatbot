-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2023 at 02:02 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatbot_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SoftDeleteFeedback` (IN `messageId` INT)   BEGIN
    UPDATE ModelFeedback
    SET deleted_at = CURRENT_TIMESTAMP
    WHERE message_id = messageId;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `GetAge` (`userId` INT) RETURNS INT(11)  BEGIN
    DECLARE age INT;
    SELECT TIMESTAMPDIFF(YEAR, date_birth, CURDATE()) INTO age
    FROM Users WHERE id = userId;
    RETURN age;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `sender` enum('user','bot') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_question_message_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `session_id`, `content`, `sender`, `timestamp`, `deleted_at`, `user_question_message_id`) VALUES
(1, 2, 'Hello my name is Games', 'user', '2023-11-18 13:36:25', NULL, NULL),
(2, 2, ' Hi Games is a great name for a game. What kind of games do you like?', 'bot', '2023-11-18 13:36:25', NULL, 1);

--
-- Triggers `messages`
--
DELIMITER $$
CREATE TRIGGER `UpdateSessionLastUse` AFTER INSERT ON `messages` FOR EACH ROW BEGIN
    UPDATE Sessions 
    SET last_use = CURRENT_TIMESTAMP
    WHERE id = NEW.session_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `modelfeedback`
--

CREATE TABLE `modelfeedback` (
  `message_id` int(11) NOT NULL,
  `feedback` enum('upvote','downvote') NOT NULL,
  `comment` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `modelmetadata`
--

CREATE TABLE `modelmetadata` (
  `id` int(11) NOT NULL,
  `model_name` varchar(255) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modelmetadata`
--

INSERT INTO `modelmetadata` (`id`, `model_name`, `version`, `description`, `date_added`, `deleted_at`) VALUES
(2, 'facebook-blenderbot-400M-distill', '1', 'Building open-domain chatbots is a challenging area for machine learning research. While prior work has shown that scaling neural models in the number of parameters and the size of the data they are trained on gives improved results, we show that other ingredients are important for a high-performing chatbot. Good conversation requires a number of skills that an expert conversationalist blends in a seamless way: providing engaging talking points and listening to their partners, both asking and answering questions, and displaying knowledge, empathy and personality appropriately, depending on the situation. We show that large scale models can learn these skills when given appropriate training data and choice of generation strategy. We build variants of these recipes with 90M, 2.7B and 9.4B parameter neural models, and make our models and code publicly available. Human evaluations show our best models are superior to existing approaches in multi-turn dialogue in terms of engagingness and humanness measurements. We then discuss the limitations of this work by analyzing failure cases of our models.', '2023-11-17 11:39:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `savedresponses`
--

CREATE TABLE `savedresponses` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `saved_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `model_metadata_id` int(11) NOT NULL DEFAULT '2',
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_use` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `model_metadata_id`, `start_time`, `last_use`, `deleted_at`, `name`) VALUES
(1, 10, 2, '2023-11-18 02:13:31', '2023-11-18 02:13:31', NULL, 'Hello World'),
(2, 10, 2, '2023-11-18 13:35:39', '2023-11-18 13:36:25', NULL, 'Muk');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `country_code` varchar(5) DEFAULT '+66',
  `phone_number` varchar(15) NOT NULL,
  `date_birth` date NOT NULL,
  `password_hash` varchar(512) NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `country_code`, `phone_number`, `date_birth`, `password_hash`, `date_joined`, `last_login`, `deleted_at`) VALUES
(10, 'Thanaphat', 'Khemniwat', 'g.khemniwat@gmail.com', '+66', '0935789539', '2001-06-19', '$2y$10$zFM3qPoEz2uglhAlPMi43ONE8SsR.RHDzZggMPXbgzHqJRSTVecOq', '2023-11-17 11:33:14', '2023-11-17 11:33:14', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `usersessionmessages`
-- (See below for the actual view)
--
CREATE TABLE `usersessionmessages` (
`user_id` int(11)
,`session_id` int(11)
,`model_name` varchar(255)
,`content` text
);

-- --------------------------------------------------------

--
-- Structure for view `usersessionmessages`
--
DROP TABLE IF EXISTS `usersessionmessages`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usersessionmessages`  AS SELECT `u`.`id` AS `user_id`, `s`.`id` AS `session_id`, `m`.`model_name` AS `model_name`, `msg`.`content` AS `content` FROM (((`users` `u` join `sessions` `s` on((`u`.`id` = `s`.`user_id`))) join `modelmetadata` `m` on((`s`.`model_metadata_id` = `m`.`id`))) join `messages` `msg` on((`s`.`id` = `msg`.`session_id`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `idx_messages_session_deleted_at` (`deleted_at`),
  ADD KEY `fk_user_question_message` (`user_question_message_id`);

--
-- Indexes for table `modelfeedback`
--
ALTER TABLE `modelfeedback`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `idx_model_feedback_deleted_at` (`deleted_at`,`feedback`);

--
-- Indexes for table `modelmetadata`
--
ALTER TABLE `modelmetadata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_model_metadata_deleted_at` (`deleted_at`,`model_name`);

--
-- Indexes for table `savedresponses`
--
ALTER TABLE `savedresponses`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `model_metadata_id` (`model_metadata_id`),
  ADD KEY `idx_sessions_deleted_at` (`deleted_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD KEY `idx_users_deleted_at` (`deleted_at`,`last_login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modelmetadata`
--
ALTER TABLE `modelmetadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_user_question_message` FOREIGN KEY (`user_question_message_id`) REFERENCES `messages` (`id`),
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `modelfeedback`
--
ALTER TABLE `modelfeedback`
  ADD CONSTRAINT `modelfeedback_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `savedresponses`
--
ALTER TABLE `savedresponses`
  ADD CONSTRAINT `savedresponses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `savedresponses_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`model_metadata_id`) REFERENCES `modelmetadata` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
