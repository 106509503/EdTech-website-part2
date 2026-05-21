-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2026 at 01:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edtech_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_contributions`
--

CREATE TABLE `about_contributions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `student_id` int(9) NOT NULL,
  `contribution` text NOT NULL,
  `quote` varchar(50) NOT NULL,
  `translation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_contributions`
--

INSERT INTO `about_contributions` (`id`, `name`, `student_id`, `contribution`, `quote`, `translation`) VALUES
(1, 'Ton Hoang Do', 106471563, 'He created and formatted the Home page and ensured that the entire website was up to standards, formatted correctly across the site and did not include plagiarism', '\"Thất bại là mẹ thành công\"', 'Failure is the mother of success'),
(2, 'David Tucker', 105914164, 'He created and formatted the Join Our Team page and was our point of communication to others through the Canvas Discussion Board should we have problems', '\"Carpe diem\"', 'Seize the day'),
(3, 'Myles McCarthy', 106564353, 'He created and formatted the Career page and helped to create and manage Jira, our project management software, for the team, ensuring that the team followed the sprints laid out by Oscar ', '\"Bättre en fågel i handen än tio i skogen\"', 'A bird in the hand is worth two in the bush'),
(4, 'Oscar Hill', 106509503, 'He created and formatted this About Us page and, along with Myles, helped to create and manage Jira for the team, helping to split up the project into manageable \'sprints\' of work', '\"Memento mori, memento vivere\"', 'Remember you will die, remember to live');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_contributions`
--
ALTER TABLE `about_contributions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_contributions`
--
ALTER TABLE `about_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
