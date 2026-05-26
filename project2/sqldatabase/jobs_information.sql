-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2026 at 02:05 PM
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
-- Table structure for table `jobs_information`
--

CREATE TABLE `jobs_information` (
  `job_id` int(11) NOT NULL,
  `ref_num` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `salary_min` int(11) NOT NULL,
  `salary_max` int(11) NOT NULL,
  `description` text NOT NULL,
  `reporting_line` text NOT NULL,
  `key_responsibilities` text NOT NULL,
  `essential_requirements` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs_information`
--

INSERT INTO `jobs_information` (`job_id`, `ref_num`, `title`, `salary_min`, `salary_max`, `description`, `reporting_line`, `key_responsibilities`, `essential_requirements`) VALUES
(1, 'XcZ35', 'Chief Web Designer', 100000, 120000, 'This job involves managing our Web design operations and tasks. Including our day to day operations in TechHive and the handling of customer orders. TechHive requires a chief web designer with technical expertise and experience as this job will require coordinating and leading a team of other web designers and technical staff in order to deliver the best experience for our users.', 'Chief Financial Officer; Chief Operating Officer; Chief Executive Officer', 'Oversee the day-to-day operations of our educational platform TechHive.; Coordinate and lead the team of web designers to ensure products are well advertised and delivered at the highest quality.; Manage implementation of new features into TechHive.; Oversee site performance and encourage continuous improvement.', '3-5+ years of experience in Web design.; Strong leadership and communication skills.; Proficiency in EdTech platforms and tools such as Inkscape and Piktochart'),
(2, 'KMp35', 'Web Designer', 80000, 90000, 'This job involves organising our EdTech online educational services including designing and redesigning useful online educational tools. TechHive requires a Web Designer with experience in past educational tools as this job will require the candidate to have a good eye for detail and be able to innovate off past designs and be able to work with the Chief Web Designer to ensure that our products are well advertised and are delivered at our highest quality.', 'Chief Web Designer; Chief Operating Officer; Chief Executive Officer', 'Organise educational product listings and manage the development of these products.; Coordinate with the Chief Web Designer to ensure products are well developed.; Research market data to identify which products are in demand and organise accordingly.', '1+ year of experience in Web design or related fields such as web development.; Technical experience in website development with HTML and CSS.; Proficiency in EdTech platforms and tools such as Inkscape'),
(3, 'YpT35', 'Digital Learning Content Specialist', 50000, 60000, 'An opportunity to shape engaging, accessible digital learning experiences for a leading EdTech company. This role focuses on creating, curating, and optimising educational content that supports inclusive online learning for diverse audiences.', 'Head of Learning Experience Design; Chief Web Designer; Chief Operating Officer; Chief Executive Officer', 'Analyse learner feedback and platform data to inform continuous content improvement.; Review and refine existing learning modules to improve clarity, engagement, and learning outcomes.; Collaborate with subject-matter experts to translate complex concepts into clear, learner-friendly materials.', '5+ years of previous experience in learning experience design or a similar role.; Good social skills and the ability to communicate effectively with designers and developers.; Experience creating digital learning content, curriculum materials, or instructional resources.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs_information`
--
ALTER TABLE `jobs_information`
  ADD PRIMARY KEY (`job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs_information`
--
ALTER TABLE `jobs_information`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
