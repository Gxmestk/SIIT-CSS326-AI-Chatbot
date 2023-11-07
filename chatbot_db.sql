-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 02, 2023 at 01:15 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddNewUser` (`in_first_name` VARCHAR(50), `in_last_name` VARCHAR(50), `in_email` VARCHAR(100), `in_country_code` VARCHAR(5), `in_phone_number` VARCHAR(15), `in_date_birth` DATE, `in_password_hash` VARCHAR(512))   BEGIN
    INSERT INTO Users(first_name, last_name, email, country_code, phone_number, date_birth, password_hash) 
    VALUES (in_first_name, in_last_name, in_email, in_country_code, in_phone_number, in_date_birth, in_password_hash);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllSessionsAndMessagesForUser` (IN `userId` INT)   BEGIN
    SELECT u.id AS user_id, 
           u.email AS user_email, 
           s.id AS session_id, 
           m.model_name, 
           m.version, 
           msg.id AS message_id, 
           msg.content
    FROM Users u
    JOIN Sessions s ON u.id = s.user_id
    JOIN ModelMetadata m ON s.model_metadata_id = m.id
    JOIN Messages msg ON s.id = msg.session_id
    WHERE u.id = userId;
END$$

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
  `session_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `response_time` decimal(5,2) DEFAULT NULL,
  `sender` enum('user','bot') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `session_id`, `content`, `response_time`, `sender`, `timestamp`, `deleted_at`) VALUES
(1, 1, 'Hey there!', '0.56', 'user', '2023-10-24 02:27:42', NULL),
(2, 1, 'Holaa !', '3.14', 'user', '2023-10-24 02:29:10', NULL);

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
(1, 'ChatBotModel', 'v1.0', 'Initial version of our chatbot model.', '2023-10-24 02:27:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `non_default_usersettings`
--

CREATE TABLE `non_default_usersettings` (
  `user_id` int(11) NOT NULL,
  `theme` enum('dark','light') DEFAULT 'dark',
  `language` enum('en','th') DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `savedresponses`
--

CREATE TABLE `savedresponses` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `saved_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `model_metadata_id` int(11) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_use` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `model_metadata_id`, `start_time`, `last_use`, `deleted_at`) VALUES
(1, 1, 1, '2023-10-24 02:27:42', '2023-10-24 02:29:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL CHECK (first_name <> ''),
  `last_name` varchar(50) NOT NULL CHECK (last_name <> ''),
  `email` varchar(100) NOT NULL CHECK (email <> ''),
  `country_code` varchar(5) DEFAULT '+66',
  `phone_number` varchar(15) NOT NULL CHECK (phone_number <> ''),
  `date_birth` date NOT NULL,
  `password_hash` varchar(512) NOT NULL CHECK (password_hash <> ''),
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `country_code`, `phone_number`, `date_birth`, `password_hash`, `date_joined`, `last_login`, `deleted_at`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', '+66', '1234567890', '1990-05-05', 'hashedpassword123', '2023-10-24 02:12:14', '2023-10-24 02:12:14', NULL),
(2, 'Jane', 'Smith', 'jane.smith@example.com', '+66', '0987654321', '1992-08-08', 'anotherhashedpassword', '2023-10-24 02:13:19', '2023-10-24 02:13:19', NULL);

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
  ADD KEY `idx_messages_session_deleted_at` (`deleted_at`);

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
-- Indexes for table `non_default_usersettings`
--
ALTER TABLE `non_default_usersettings`
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `modelfeedback`
--
ALTER TABLE `modelfeedback`
  ADD CONSTRAINT `modelfeedback_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `non_default_usersettings`
--
ALTER TABLE `non_default_usersettings`
  ADD CONSTRAINT `non_default_usersettings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
