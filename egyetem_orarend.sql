-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 03, 2021 at 02:59 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `egyetem_orarend`
--

-- --------------------------------------------------------

--
-- Table structure for table `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int(10) UNSIGNED NOT NULL,
  `nev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `jelszo` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `szerep` enum('tanár','diák') COLLATE utf8_hungarian_ci NOT NULL DEFAULT 'diák',
  `tantargy` varchar(50) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `szin` char(6) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `nev`, `email`, `jelszo`, `szerep`, `tantargy`, `szin`) VALUES
(1, 'Tóth Árpád', 'totharpad@testmail.sze', '$2y$10$/F73MUnTGLqIxutmL/tz5OajLpW1CKAkkZrQ9znc7J3JxBTs/Rgqy', 'tanár', 'PHP', 'b326b5'),
(23, 'Nagy Gábor', 'ng123@fakeemail.f', '$2y$10$FNTISjrJ69Ak34O6a47xV.ooXS.P8qIlXztAmPF7j6tkQ3G.V6pOW', 'tanár', 'Anyagismeretek', '69e658'),
(21, 'Nagy Lajos', 'nagylajos@fakemail.fak', '$2y$10$H/GVQ/ib5Urap7Ho6ewLAuGKpWp0PXgOtGwXzAwk3erncGswJzAwO', 'tanár', 'C++', '0724f2'),
(25, 'Csizi Szabsztián Márk', 'cssz@mail.hu', '$2y$10$1BsX8RxsltRfV9gcMKb8tuNuB49OD2O/6SkCOpR9dOvJc1LvyUZUm', 'diák', NULL, NULL),
(26, 'wsgfwg', 'wegweg@gr.efe', '$2y$10$04g16k2s3yUeBe/QOk3jpe3eA.032YpGF1JL1RpLQNmkNTfGeLX7y', 'diák', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `idopontok`
--

CREATE TABLE `idopontok` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanar_id` int(10) UNSIGNED NOT NULL,
  `idopont` datetime NOT NULL,
  `leiras` text COLLATE utf8_hungarian_ci DEFAULT NULL,
  `csatolmany` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`,`jelszo`);

--
-- Indexes for table `idopontok`
--
ALTER TABLE `idopontok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanar_id` (`tanar_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `idopontok`
--
ALTER TABLE `idopontok`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
