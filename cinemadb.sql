-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 21 Φεβ 2023 στις 18:10:38
-- Έκδοση διακομιστή: 10.4.27-MariaDB
-- Έκδοση PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `cinemadb`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `movie`
--

CREATE TABLE `movie` (
  `movie_id` varchar(100) NOT NULL,
  `movie_name` varchar(100) DEFAULT NULL,
  `movie_director` varchar(100) DEFAULT NULL,
  `movie_desc` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `movie`
--

INSERT INTO `movie` (`movie_id`, `movie_name`, `movie_director`, `movie_desc`) VALUES
('403153886', 'Casino', ' Martin Scorsese', 'A tale of greed, deception, money, power, and murder occur between two best friends: a mafia enforcer and a casino executive compete against each other over a gambling empire, and over a fast-living and fast-loving socialite'),
('46712103', 'Avatar', 'James Cameron', 'A paraplegic Marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home'),
('483511031', 'The Handmaiden', 'Park Chan-wook', 'A woman is hired as a handmaiden to a Japanese heiress, but secretly she is involved in a plot to defraud her'),
('574996815', 'Interstellar', 'Christopher Nolan', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity survival.'),
('702332633', 'Sound of Metal', 'Darius Marder', 'A heavy-metal drummers life is thrown into freefall when he begins to lose his hearing'),
('703787480', 'One Flew Over the Cuckoos Nest', 'Milos Forman', 'In the Fall of 1963, a Korean War veteran and criminal pleads insanity and is admitted to a mental institution, where he rallies up the scared patients against the tyrannical nurse'),
('92983997', 'Oldboy', 'Park Chan-wook', 'After being kidnapped and imprisoned for fifteen years, Oh Dae-Su is released, only to find that he must find his captor in five days');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` varchar(100) NOT NULL,
  `screening_screening_id` varchar(100) NOT NULL,
  `ticket_amount` int(11) DEFAULT NULL,
  `movie_movie_id` varchar(100) NOT NULL,
  `user_user_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `screening`
--

CREATE TABLE `screening` (
  `screening_id` varchar(100) NOT NULL,
  `screening_tickets` int(11) NOT NULL,
  `movie_movie_id` varchar(100) NOT NULL,
  `screening_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `screening`
--

INSERT INTO `screening` (`screening_id`, `screening_tickets`, `movie_movie_id`, `screening_time`) VALUES
('202486227', 50, '574996815', '23:15:00'),
('348139822', 50, '403153886', '18:15:00'),
('354562074', 100, '92983997', '00:15:00'),
('374006910', 50, '574996815', '18:15:00'),
('395911998', 50, '483511031', '00:15:00'),
('515917026', 50, '403153886', '23:15:00'),
('776544066', 50, '46712103', '18:15:00'),
('785690901', 50, '703787480', '23:15:00'),
('785772625', 50, '703787480', '21:15:00'),
('837780922', 50, '46712103', '21:15:00'),
('986871374', 50, '702332633', '23:15:00');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user`
--

CREATE TABLE `user` (
  `user_id` varchar(200) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_surname` varchar(100) NOT NULL,
  `user_country` varchar(100) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_username` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_role` varchar(100) DEFAULT NULL,
  `user_city` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_surname`, `user_country`, `user_address`, `user_email`, `user_username`, `user_password`, `user_role`, `user_city`) VALUES
('1', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'Admin', 'admin'),
('63f4f5709e3f6', 'test', 'test', 'New Zealand', 'test', 'test@test.test', 'test', 'test', 'User', 'WELLINGTON');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movie_id`);

--
-- Ευρετήρια για πίνακα `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `reservation_movie_fk` (`movie_movie_id`),
  ADD KEY `reservation_screening_fk` (`screening_screening_id`),
  ADD KEY `reservation_user_fk` (`user_user_id`);

--
-- Ευρετήρια για πίνακα `screening`
--
ALTER TABLE `screening`
  ADD PRIMARY KEY (`screening_id`),
  ADD KEY `screening_movie_fk` (`movie_movie_id`);

--
-- Ευρετήρια για πίνακα `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_movie_fk` FOREIGN KEY (`movie_movie_id`) REFERENCES `movie` (`movie_id`),
  ADD CONSTRAINT `reservation_screening_fk` FOREIGN KEY (`screening_screening_id`) REFERENCES `screening` (`screening_id`),
  ADD CONSTRAINT `reservation_user_fk` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`);

--
-- Περιορισμοί για πίνακα `screening`
--
ALTER TABLE `screening`
  ADD CONSTRAINT `screening_movie_fk` FOREIGN KEY (`movie_movie_id`) REFERENCES `movie` (`movie_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
