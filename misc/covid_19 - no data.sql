-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Nov 11, 2020 at 12:33 PM
-- Server version: 8.0.22
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `covid_19`
--

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `covid_report`
--

CREATE TABLE `covid_report` (
  `id` int NOT NULL,
  `fk_location_id` int NOT NULL,
  `last_update` datetime NOT NULL,
  `confirmed` int NOT NULL,
  `deaths` int NOT NULL,
  `recovered` int NOT NULL,
  `incidence_rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int NOT NULL,
  `fk_us_county_id` int DEFAULT NULL,
  `fk_province_state_id` int DEFAULT NULL,
  `fk_country_id` int NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `province_state`
--

CREATE TABLE `province_state` (
  `id` int NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `us_county`
--

CREATE TABLE `us_county` (
  `id` int NOT NULL,
  `fips` int DEFAULT NULL,
  `admin2` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `covid_report`
--
ALTER TABLE `covid_report`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_location_id` (`fk_location_id`) USING BTREE;

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_us_county_id` (`fk_us_county_id`) USING BTREE,
  ADD KEY `fk_country_id` (`fk_country_id`),
  ADD KEY `fk_province_state_id` (`fk_province_state_id`);

--
-- Indexes for table `province_state`
--
ALTER TABLE `province_state`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `us_county`
--
ALTER TABLE `us_county`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fips` (`fips`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `covid_report`
--
ALTER TABLE `covid_report`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `province_state`
--
ALTER TABLE `province_state`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `us_county`
--
ALTER TABLE `us_county`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `covid_report`
--
ALTER TABLE `covid_report`
  ADD CONSTRAINT `covid_report_ibfk_1` FOREIGN KEY (`fk_location_id`) REFERENCES `location` (`id`);

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`fk_country_id`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `location_ibfk_2` FOREIGN KEY (`fk_us_county_id`) REFERENCES `us_county` (`id`),
  ADD CONSTRAINT `location_ibfk_3` FOREIGN KEY (`fk_province_state_id`) REFERENCES `province_state` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
