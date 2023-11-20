-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2023 at 07:04 AM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `Restorefeedback` (IN `MessageId` INT)   BEGIN
    UPDATE `modelfeedback` SET `deleted_at` = NULL WHERE `message_id` = MessageId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RestoreMessage` (IN `MessageId` INT)   BEGIN
    UPDATE `Messages` SET `deleted_at` = NULL WHERE `id` = MessageId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RestoreModel` (IN `ModelId` INT)   BEGIN
    UPDATE `modelmetadata` SET `deleted_at` = NULL WHERE `id` = ModelId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RestoreSession` (IN `SessionId` INT)   BEGIN
    UPDATE `Sessions` SET `deleted_at` = NULL WHERE `id` = SessionId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RestoreUser` (IN `userId` INT)   BEGIN
    UPDATE `users` SET `deleted_at` = NULL WHERE `id` = userId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SoftDeleteFeedback` (IN `messageId` INT)   BEGIN
    UPDATE ModelFeedback
    SET deleted_at = CURRENT_TIMESTAMP
    WHERE message_id = messageId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SoftDeleteMessage` (IN `msg_id` INT)   BEGIN
    UPDATE messages
    SET deleted_at = CURRENT_TIMESTAMP
    WHERE id = msg_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SoftDeleteModelMetadata` (IN `model_id` INT)   BEGIN
    UPDATE modelmetadata
    SET deleted_at = CURRENT_TIMESTAMP
    WHERE id = model_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SoftDeleteSession` (IN `session_id` INT)   BEGIN
    UPDATE sessions
    SET deleted_at = CURRENT_TIMESTAMP
    WHERE id = session_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SoftDeleteUser` (IN `user_id` INT)   BEGIN
    UPDATE users
    SET deleted_at = CURRENT_TIMESTAMP
    WHERE id = user_id;
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
  `user_question_message_id` int(11) DEFAULT NULL,
  `saved_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `session_id`, `content`, `sender`, `timestamp`, `deleted_at`, `user_question_message_id`, `saved_timestamp`) VALUES
(1, 2, 'Hello my name is Games', 'user', '2023-11-18 13:36:25', NULL, NULL, '2023-11-18 14:56:42'),
(2, 2, ' Hi Games is a great name for a game. What kind of games do you like?', 'bot', '2023-11-18 13:36:25', NULL, 1, '2023-11-19 12:39:56'),
(5, 2, 'I like League of Legend\r\n', 'user', '2023-11-19 13:59:32', NULL, NULL, '2023-11-19 13:59:32'),
(6, 2, ' League of legends is a multiplayer online battle arena video game developed and published by Riot Games', 'bot', '2023-11-19 13:59:32', NULL, 5, '2023-11-19 13:59:32'),
(7, 1, 'Hello World', 'user', '2023-11-19 15:17:59', NULL, NULL, '2023-11-19 15:17:59'),
(8, 1, ' Hello, how are you? I just got back from a walk in the park with my dog.', 'bot', '2023-11-19 15:17:59', NULL, 7, '2023-11-19 15:17:59'),
(9, 1, 'Oh that is great how was it !', 'user', '2023-11-19 15:18:23', NULL, NULL, '2023-11-19 15:18:23'),
(10, 1, ' It was great!  I was so happy to see him.  It was so nice of him to do that for me.', 'bot', '2023-11-19 15:18:23', NULL, 9, '2023-11-19 15:18:23'),
(11, 1, 'how old is him', 'user', '2023-11-19 15:18:42', NULL, NULL, '2023-11-19 15:18:42'),
(12, 1, ' He is 8 years old.  He is a great kid.  I am so proud of him.', 'bot', '2023-11-19 15:18:42', NULL, 11, '2023-11-19 15:18:48'),
(17, 1, 'what is his name ? ', 'user', '2023-11-20 01:39:36', NULL, NULL, '2023-11-20 01:39:36'),
(18, 1, ' His name is Roscoe. He\'s a rescue dog. I\'ve had him since he was a puppy.', 'bot', '2023-11-20 01:39:36', NULL, 17, '2023-11-20 01:39:36'),
(19, 3, 'Hello, how are you ?', 'user', '2023-11-20 03:10:08', NULL, NULL, '2023-11-20 03:10:08'),
(20, 3, ' I am doing well, thank you. How are you doing? I hope you are well.', 'bot', '2023-11-20 03:10:08', NULL, 19, '2023-11-20 03:10:08'),
(21, 3, 'Yeah', 'user', '2023-11-20 03:11:42', NULL, NULL, '2023-11-20 03:11:42'),
(22, 3, ' Do you have any plans for the weekend? I\'m thinking of going to the beach.', 'bot', '2023-11-20 03:11:42', NULL, 21, '2023-11-20 03:11:42'),
(23, 4, 'Chill', 'user', '2023-11-20 03:16:36', NULL, NULL, '2023-11-20 03:16:36'),
(24, 4, ' Chill is the state of being relaxed and having a good time. Do you like it?', 'bot', '2023-11-20 03:16:36', NULL, 23, '2023-11-20 03:16:36'),
(25, 5, 'What is the biggest planet ?', 'user', '2023-11-20 04:50:38', NULL, NULL, '2023-11-20 04:50:38'),
(26, 5, ' I\'m not sure, but I know it\'s the largest planet in the Solar System.', 'bot', '2023-11-20 04:50:38', NULL, 25, '2023-11-20 04:50:38'),
(27, 5, 'Tell me what is it ?', 'user', '2023-11-20 04:50:53', NULL, NULL, '2023-11-20 04:50:53'),
(28, 5, ' It\'s a new video game.  I can\'t wait for it to come out!', 'bot', '2023-11-20 04:50:53', NULL, 27, '2023-11-20 04:50:53'),
(29, 5, 'what is the biggest planet in the Solar System ?', 'user', '2023-11-20 04:53:14', NULL, NULL, '2023-11-20 04:53:14'),
(30, 5, ' I\'m not sure, but I know it\'s the largest planet in our solar system.', 'bot', '2023-11-20 04:53:14', NULL, 29, '2023-11-20 04:53:14'),
(31, 5, 'Yes,  what is the biggest planet in our solar system?', 'user', '2023-11-20 04:53:45', NULL, NULL, '2023-11-20 04:53:45'),
(32, 5, ' I\'m not sure, but I know it\'s the largest planet in the Solar System.', 'bot', '2023-11-20 04:53:45', NULL, 31, '2023-11-20 04:53:45'),
(39, 5, '/help', 'user', '2023-11-20 06:54:22', NULL, NULL, '2023-11-20 06:54:22'),
(40, 5, ' Do you like to help people? I like to volunteer at the animal shelter.', 'bot', '2023-11-20 06:54:22', NULL, 39, '2023-11-20 06:54:22');

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

--
-- Dumping data for table `modelfeedback`
--

INSERT INTO `modelfeedback` (`message_id`, `feedback`, `comment`, `timestamp`, `deleted_at`) VALUES
(12, 'downvote', 'bad answer', '2023-11-19 15:51:54', NULL),
(28, 'downvote', 'weird', '2023-11-20 04:51:23', NULL),
(32, 'upvote', 'it\'s was fun !!!', '2023-11-20 04:54:20', NULL);

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
-- Stand-in structure for view `model_feedback_summary`
-- (See below for the actual view)
--
CREATE TABLE `model_feedback_summary` (
`id` int(11)
,`model_name` varchar(255)
,`version` varchar(50)
,`description` text
,`date_added` timestamp
,`upvote_count` bigint(21)
,`downvote_count` bigint(21)
,`latest_comments` varchar(341)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `saved_bot_messages`
-- (See below for the actual view)
--
CREATE TABLE `saved_bot_messages` (
`bot_message_content` text
,`bot_message_timestamp` timestamp
,`user_message_content` text
,`user_message_timestamp` timestamp
,`user_id` int(11)
);

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
(1, 10, 2, '2023-11-18 02:13:31', '2023-11-20 01:39:36', NULL, 'Hello World'),
(2, 10, 2, '2023-11-18 13:35:39', '2023-11-19 13:59:32', '2023-11-20 03:07:57', 'Muk'),
(3, 10, 2, '2023-11-20 03:09:44', '2023-11-20 03:11:42', '2023-11-20 03:13:41', 'June'),
(4, 10, 2, '2023-11-20 03:16:06', '2023-11-20 03:16:36', '2023-11-20 03:16:43', 'Games'),
(5, 10, 2, '2023-11-20 04:50:13', '2023-11-20 06:54:22', NULL, 'Soon');

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
-- Structure for view `model_feedback_summary`
--
DROP TABLE IF EXISTS `model_feedback_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `model_feedback_summary`  AS SELECT `mm`.`id` AS `id`, `mm`.`model_name` AS `model_name`, `mm`.`version` AS `version`, `mm`.`description` AS `description`, `mm`.`date_added` AS `date_added`, count((case when (`mf`.`feedback` = 'upvote') then 1 end)) AS `upvote_count`, count((case when (`mf`.`feedback` = 'downvote') then 1 end)) AS `downvote_count`, substring_index(group_concat(`mf`.`comment` order by `mf`.`timestamp` DESC separator '||'),'||',3) AS `latest_comments` FROM (((`modelmetadata` `mm` join `sessions` `s` on((`mm`.`id` = `s`.`model_metadata_id`))) join `messages` `m` on((`s`.`id` = `m`.`session_id`))) left join `modelfeedback` `mf` on((`m`.`id` = `mf`.`message_id`))) GROUP BY `mm`.`id``id`  ;

-- --------------------------------------------------------

--
-- Structure for view `saved_bot_messages`
--
DROP TABLE IF EXISTS `saved_bot_messages`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `saved_bot_messages`  AS SELECT `m1`.`content` AS `bot_message_content`, `m1`.`timestamp` AS `bot_message_timestamp`, `m2`.`content` AS `user_message_content`, `m2`.`timestamp` AS `user_message_timestamp`, `s`.`user_id` AS `user_id` FROM ((`messages` `m1` left join `messages` `m2` on((`m1`.`user_question_message_id` = `m2`.`id`))) join `sessions` `s` on((`m1`.`session_id` = `s`.`id`))) WHERE ((`m1`.`sender` = 'bot') AND (`m1`.`saved_timestamp` is not null) AND (`m1`.`saved_timestamp` <> `m1`.`timestamp`))  ;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `modelmetadata`
--
ALTER TABLE `modelmetadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`model_metadata_id`) REFERENCES `modelmetadata` (`id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `event_permanent_delete_soft_deleted_users` ON SCHEDULE EVERY 1 DAY STARTS '2023-11-20 09:24:51' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM chat_db.users
  WHERE deleted_at IS NOT NULL AND deleted_at <= NOW() - INTERVAL 30 DAY$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
