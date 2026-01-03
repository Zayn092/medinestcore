-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2025 at 11:20 PM
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
-- Database: `qrmedic`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$jRO9/MG4za1woZv55WQvjOlihJrvLRrplm.kdvLjisbAnggmPNP7G', 'admin', '2025-10-01 13:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `allergies_list`
--

CREATE TABLE `allergies_list` (
  `Allergy_ID` int(11) NOT NULL,
  `Allergy_Name` varchar(100) NOT NULL,
  `Category` enum('Food','Environmental','Drug','Skin Contact','Insect Sting','Other') NOT NULL,
  `Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allergies_list`
--

INSERT INTO `allergies_list` (`Allergy_ID`, `Allergy_Name`, `Category`, `Notes`) VALUES
(1, 'Peanuts', 'Food', 'Common in children; can cause anaphylaxis'),
(2, 'Tree Nuts', 'Food', 'Includes almonds, walnuts, cashews, etc.'),
(3, 'Milk (Dairy)', 'Food', 'Usually in young children; lactose intolerance is different'),
(4, 'Eggs', 'Food', 'Often outgrown by adulthood'),
(5, 'Wheat (Gluten)', 'Food', 'May cause gluten sensitivity or celiac symptoms'),
(6, 'Soy', 'Food', 'Common in infant formulas and processed food'),
(7, 'Fish', 'Food', 'Includes tuna, cod, salmon, etc.'),
(8, 'Shellfish', 'Food', 'Includes shrimp, crab, lobster; lifelong allergy'),
(9, 'Pollen', 'Environmental', 'Tree, grass, and weed pollen cause seasonal allergies'),
(10, 'Dust Mites', 'Environmental', 'Microscopic bugs in bedding and carpets'),
(11, 'Mold', 'Environmental', 'Grows in damp environments like bathrooms'),
(12, 'Animal Dander', 'Environmental', 'Common with cats and dogs'),
(13, 'Cockroach Droppings', 'Environmental', 'Found in infested homes'),
(14, 'Penicillin', 'Drug', 'One of the most reported drug allergies'),
(15, 'Sulfa Drugs', 'Drug', 'Used in antibiotics and some diuretics'),
(16, 'Aspirin', 'Drug', 'Can cause breathing issues in sensitive people'),
(17, 'Ibuprofen', 'Drug', 'May trigger asthma or hives'),
(18, 'Anticonvulsants', 'Drug', 'Includes phenytoin and carbamazepine'),
(19, 'Anesthesia Drugs', 'Drug', 'Includes propofol and local anesthetics'),
(20, 'Nickel', 'Skin Contact', 'Found in jewelry, coins, belt buckles'),
(21, 'Latex', 'Skin Contact', 'Used in gloves, balloons, condoms'),
(22, 'Fragrances', 'Skin Contact', 'In perfumes, lotions, soaps'),
(23, 'Hair Dye (PPD)', 'Skin Contact', 'Found in dark permanent dyes'),
(24, 'Detergents and Soaps', 'Skin Contact', 'Harsh chemicals may trigger eczema'),
(25, 'Bee Stings', 'Insect Sting', 'Can cause life-threatening anaphylaxis'),
(26, 'Wasp Stings', 'Insect Sting', 'Immediate swelling and shock possible'),
(27, 'Fire Ants', 'Insect Sting', 'Common in tropical/subtropical areas'),
(28, 'Sunlight (Photosensitivity)', 'Other', 'Skin reaction to UV exposure'),
(29, 'Cold (Cold Urticaria)', 'Other', 'Hives triggered by cold temperatures'),
(30, 'Water (Aquagenic Urticaria)', 'Other', 'Extremely rare allergy to water'),
(31, 'Red Meat (Alpha-gal Syndrome)', 'Other', 'Triggered by a tick bite'),
(32, 'Exercise-induced Anaphylaxis', 'Other', 'Severe reaction to physical activity');

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE `family` (
  `id` int(20) NOT NULL,
  `Family_Username` varchar(100) NOT NULL,
  `Pin` varchar(100) NOT NULL,
  `Creator` varchar(100) NOT NULL,
  `Time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `family`
--

INSERT INTO `family` (`id`, `Family_Username`, `Pin`, `Creator`, `Time`) VALUES
(1, 'Uzumaki', '25364258', 'mzan', '2025-09-11 03:19:55');

-- --------------------------------------------------------

--
-- Table structure for table `health_tips`
--

CREATE TABLE `health_tips` (
  `id` int(20) NOT NULL,
  `tips` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_tips`
--

INSERT INTO `health_tips` (`id`, `tips`) VALUES
(1, 'Drink at least 8 glasses of water daily to stay hydrated.'),
(2, 'Sleep for 7–9 hours every night for proper rest and recovery.'),
(3, 'Eat a balanced diet with fruits, vegetables, and whole grains.'),
(4, 'Avoid skipping breakfast—it boosts energy and metabolism.'),
(5, 'Limit your sugar intake to reduce the risk of diabetes.'),
(6, 'Walk at least 30 minutes a day to keep your heart healthy.'),
(7, 'Stretch every morning to improve flexibility and circulation.'),
(8, 'Wash your hands regularly to prevent infections.'),
(9, 'Take short screen breaks to protect your eyes and mind.'),
(10, 'Practice deep breathing or meditation to reduce stress.'),
(11, 'Don’t overeat—stop when you\'re about 80% full.'),
(12, 'Replace soft drinks with water or herbal tea.'),
(13, 'Avoid eating too late at night to improve digestion.'),
(14, 'Keep your posture straight to prevent back and neck pain.'),
(15, 'Use stairs instead of the elevator for daily cardio.'),
(16, 'Wear sunscreen when going outdoors to protect your skin.'),
(17, 'Avoid smoking and limit alcohol for better long-term health.'),
(18, 'Spend time in nature to boost mental well-being.'),
(19, 'Brush and floss your teeth twice a day for oral hygiene.'),
(20, 'Get regular checkups to catch health issues early.');

-- --------------------------------------------------------

--
-- Table structure for table `individual`
--

CREATE TABLE `individual` (
  `id` int(20) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `F_name` varchar(50) NOT NULL,
  `Birth_Date` date NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `CNIC` varchar(13) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` varchar(11) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Blood_Type` varchar(10) NOT NULL,
  `Height` varchar(10) NOT NULL,
  `Weight` varchar(10) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Family_Username` varchar(50) NOT NULL,
  `Record_limit` int(5) NOT NULL,
  `h_Password` varchar(250) NOT NULL,
  `Pin` varchar(4) NOT NULL,
  `Filter_code` varchar(100) NOT NULL,
  `Medical_Conditions` varchar(550) NOT NULL,
  `Allergies` varchar(550) NOT NULL,
  `Time` datetime NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `individual`
--

INSERT INTO `individual` (`id`, `Name`, `F_name`, `Birth_Date`, `Gender`, `CNIC`, `Email`, `Phone`, `City`, `Blood_Type`, `Height`, `Weight`, `Username`, `Family_Username`, `Record_limit`, `h_Password`, `Pin`, `Filter_code`, `Medical_Conditions`, `Allergies`, `Time`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'Sufiyan', 'Ali', '2025-02-13', 'Male', '2222222222222', 'sufiyan@gmail.com', '02121111111', 'Karachi', 'A+', '120', '60', 'zainamm', '', 5, '$2y$10$IG9sP5NWMOlHJSaohlhZp.jB.4sjTNugdlCKtfQYwL2vj2hM5fW56', '', '', '', '', '2025-06-24 04:06:41', '864eeb68ea54e1330589b3b5874bbd948e2eb890e953fb0241d2d41792ef7c1f', '2025-09-27 15:08:25'),
(2, 'Ahmar', 'Arshad', '2025-06-08', 'Male', '2147483647', 'bbb@gmail.com', '2147483647', 'Karachi', 'O+', '190', '56', 'zainamman', '', 3, '$2y$10$RRtup0xK.h0WfaG4IyEdGu.L1o4Y0TrnJHGnoROUYtj9wghLSoqAW', '', '', '', '', '2025-06-27 09:30:27', '864eeb68ea54e1330589b3b5874bbd948e2eb890e953fb0241d2d41792ef7c1f', '2025-09-27 15:08:25'),
(3, 'Zain', 'amjad', '2025-06-17', 'Male', '2147483647', 'ccc@gmail.com', '01234455', 'Lahore', 'O+', '160', '58', 'zan', 'Uchiha', 1, '$2y$10$nIYJQKEv3MayPKeO1wTwdO4RHrVsG53VqJ0J.swnvyaUyVBoHKu2C', '', 'L3sA91qZUTNbjKeG4VtfzRgWmXEdMLCaFQ58w2DpYvhnr7JZaintixskudRYPlOW\n', 'back pain', 'Garlic', '2025-06-27 10:37:28', '864eeb68ea54e1330589b3b5874bbd948e2eb890e953fb0241d2d41792ef7c1f', '2025-09-27 15:08:25'),
(4, 'Naruto', 'Minato', '2005-06-15', 'Male', '2147483647', 'naruto@gamil.com', '2147483647', 'Peshawar', 'O+', '159', '45', 'naruto', 'Uzumaki', 0, '$2y$10$ToM59ovfjiH/skjX5hIKY.S78Ktx7vknZyOXaI.IxAQjYAZnmgS8y', '', 'ddb742a42713d4a135a306d68674ef9bec80f9001963047ef64fa8ca0694838a', '', '', '2025-07-15 11:08:31', NULL, NULL),
(5, 'Zan', 'Minato', '2025-07-25', 'Male', '4444444444444', 'ddd@gmail.com', '11111111111', 'Lahore', 'B+', '180', '42', 'gone', 'go', 3, '$2y$10$NQ81E8f0ob9pWNj/TFipUeWE/phrp90py71hMye.ZrKlG2mIGKFVK', '', '81e7a532a746adb2617c1c93649140b8c553f90eb1c051b94ad1114b672f7cf6', '', '', '2025-07-17 10:59:24', '864eeb68ea54e1330589b3b5874bbd948e2eb890e953fb0241d2d41792ef7c1f', '2025-09-27 15:08:25'),
(6, 'Muhammad Zain', 'Amjad Pervaz', '2013-02-12', 'Male', '3052142028012', 'eee@gmail.com', '03096619879', 'Karachi', 'A+', '158', '58', 'zain002', 'amjad002', 1, '$2y$10$yAUMIoFwCgT5K7jHKOhpg.tOqDPUesEZfvsGA758sosKuBPQ6Ndea', '', 'a05362b24dbb6e416f38de2f87108e60ad98b8249079e7a88311369e2c5a4fbb', 'neckpain', 'tomato', '2025-07-21 09:58:09', NULL, NULL),
(7, 'M. Zain', 'Amjad', '2003-03-15', 'Male', '0356252515421', 'Zainamman70@gmail.com', '03096619879', 'Lahore', 'A+', '155', '50', 'mzan', 'Uzumaki', 3, '$2y$10$82i1kUbNrlN6OXFi1rzQD.0AALEctCPoOnc6vGl6dlNOg1vvWeGhC', 'FEWB', '1d13e1df9790aa2c3f07b1359015907d1017ba742d6da28f789d0c5927d8d3ce', '', 'garlic', '2025-09-04 11:53:36', 'b61bc0ee13f4b6636a94b8ee4987bbb902fc6b8a19dce48fe2bddd289eaf41c2', '2025-09-27 14:44:18'),
(8, 'Senku', 'Ishigami', '2020-08-06', 'Male', '0000000000000', 'stone@gmail.com', '01000000000', 'Chichawatni', 'A+', '150', '38', 'stone', 'Uzumaki', 0, '$2y$10$Nm6aBN05tfn.TGEtpMCHPeA2bcRTc7qVqh7hGjKr7OqMkCf0Oqv.a', '2VOO', 'c48578d7a0be422947da70b9e96aa04b946b3e44444c84b459c271f6aa45c7f3', '', '', '2025-09-25 20:54:47', 'e25747506e8fed16fc5c3c3f47fbd531cebbcef9bfa89d1a9d672acc3ec51e7b', '2025-09-27 14:44:18'),
(9, 'Saturo', 'Gojo', '2024-12-10', 'Male', '0000000000000', 'gojo@gmail.com', '11111111111', 'Chichawatni', 'B+', '190', '60', 'gojo', '', 0, '$2y$10$Z8yrim/Jp0ZOk/g6QRcY2OIDAG93rUXE7.69DQ9N2.VqgeKkL0OZO', '5581', '77ac95dcf70529b5f3b3fd27dc5a6dcdb55a40712cbced33260ddbfd6cadd167', '', '', '2025-09-30 15:08:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ind_prescription`
--

CREATE TABLE `ind_prescription` (
  `id` int(20) NOT NULL,
  `Doctor_Name` varchar(50) NOT NULL,
  `Pateint_Username` varchar(50) NOT NULL,
  `Pateint_id` int(20) NOT NULL,
  `Medicine_Name` varchar(100) NOT NULL,
  `Dosage` varchar(100) NOT NULL,
  `Frequency` varchar(100) NOT NULL,
  `Duration` varchar(100) NOT NULL,
  `Notes` varchar(1000) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Family_Status` varchar(10) NOT NULL,
  `Emergency_Status` varchar(10) NOT NULL,
  `Next_visit` date DEFAULT NULL,
  `Doctor_Contact` varchar(11) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Time` datetime NOT NULL DEFAULT current_timestamp(),
  `Medicine_Name01` varchar(100) DEFAULT NULL,
  `Dosage01` varchar(100) DEFAULT NULL,
  `Frequency01` varchar(100) DEFAULT NULL,
  `Duration01` varchar(100) DEFAULT NULL,
  `Medicine_Name02` varchar(100) DEFAULT NULL,
  `Dosage02` varchar(100) DEFAULT NULL,
  `Frequency02` varchar(100) DEFAULT NULL,
  `Duration02` varchar(100) DEFAULT NULL,
  `Medicine_Name03` varchar(100) DEFAULT NULL,
  `Dosage03` varchar(100) DEFAULT NULL,
  `Frequency03` varchar(100) DEFAULT NULL,
  `Duration03` varchar(100) DEFAULT NULL,
  `Medicine_Name04` varchar(100) DEFAULT NULL,
  `Dosage04` varchar(100) DEFAULT NULL,
  `Frequency04` varchar(100) DEFAULT NULL,
  `Duration04` varchar(100) DEFAULT NULL,
  `Medicine_Name05` varchar(100) DEFAULT NULL,
  `Dosage05` varchar(100) DEFAULT NULL,
  `Frequency05` varchar(100) DEFAULT NULL,
  `Duration05` varchar(100) DEFAULT NULL,
  `Medicine_Name06` varchar(100) DEFAULT NULL,
  `Dosage06` varchar(100) DEFAULT NULL,
  `Frequency06` varchar(100) DEFAULT NULL,
  `Duration06` varchar(100) DEFAULT NULL,
  `Medicine_Name07` varchar(100) DEFAULT NULL,
  `Dosage07` varchar(100) DEFAULT NULL,
  `Frequency07` varchar(100) DEFAULT NULL,
  `Duration07` varchar(100) DEFAULT NULL,
  `Medicine_Name08` varchar(100) DEFAULT NULL,
  `Dosage08` varchar(100) DEFAULT NULL,
  `Frequency08` varchar(100) DEFAULT NULL,
  `Duration08` varchar(100) DEFAULT NULL,
  `Medicine_Name09` varchar(100) DEFAULT NULL,
  `Dosage09` varchar(100) DEFAULT NULL,
  `Frequency09` varchar(100) DEFAULT NULL,
  `Duration09` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ind_prescription`
--

INSERT INTO `ind_prescription` (`id`, `Doctor_Name`, `Pateint_Username`, `Pateint_id`, `Medicine_Name`, `Dosage`, `Frequency`, `Duration`, `Notes`, `Status`, `Family_Status`, `Emergency_Status`, `Next_visit`, `Doctor_Contact`, `Image`, `Time`, `Medicine_Name01`, `Dosage01`, `Frequency01`, `Duration01`, `Medicine_Name02`, `Dosage02`, `Frequency02`, `Duration02`, `Medicine_Name03`, `Dosage03`, `Frequency03`, `Duration03`, `Medicine_Name04`, `Dosage04`, `Frequency04`, `Duration04`, `Medicine_Name05`, `Dosage05`, `Frequency05`, `Duration05`, `Medicine_Name06`, `Dosage06`, `Frequency06`, `Duration06`, `Medicine_Name07`, `Dosage07`, `Frequency07`, `Duration07`, `Medicine_Name08`, `Dosage08`, `Frequency08`, `Duration08`, `Medicine_Name09`, `Dosage09`, `Frequency09`, `Duration09`) VALUES
(1, 'amman', 'zan', 3, 'panadol', '1 pill', 'daily', '3 days from now', 'daily after breakfast', 'Completed', '', '', '2025-09-18', '11111', '', '2025-06-27 11:44:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'amman', 'zan', 3, 'Brufine', '1 pill', 'daily', '4 days from now', 'daily after breakfast', 'Completed', '', '', '2025-07-30', '11111', '', '2025-07-24 13:22:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Amman', 'Muhammad Zain', 6, 'Panadol', '1 pill', 'daily', '2 days', 'after dinner', 'Active', '', '', '2025-08-06', '1111111', '', '2025-07-21 12:20:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Amman', 'mzan', 7, 'Panadol', '01 pill', 'daily', '2 days', 'before sleep', 'Active', '', '', '2025-09-11', '30955555', '', '2025-09-04 12:07:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Amman', 'mzan', 7, 'Brufeine', '01 pill', 'daily', '2 days', 'before sleep', 'Active', '', '', '2025-09-12', '30955555', '', '2025-09-04 12:07:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'mzan', 'mzan', 7, 'coffee', '500mg', 'Twice daily', '7 days', 'morning', 'Active', '', '', '0000-00-00', '1234567', 'uploads/prescriptions/prescription_1757281952_68bdfea05e816.png', '2025-09-07 23:52:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Monkey', 'mzan', 7, 'try 01', '500mg', 'Every 8 hours', '7 days', 'bbb', 'Active', '', '', '0000-00-00', '1234567', 'uploads/prescriptions/prescription_1757281952_68bdfea05e816.png', '2025-09-10 00:55:24', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, 'duoble', 'mzan', 7, 'try 02', '500mg', 'Twice daily', '7 days', 'ff', 'Completed', 'hide', 'show', '2025-09-16', '1234567', '', '2025-09-10 00:56:49', '02', 'fff', 'Once daily', 'fff', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, 'pc', 'mzan', 0, 'coffee', '500mg', 'Twice daily', '7 days', '', 'Active', 'hide', 'hide', '2025-10-04', '1234567890', '', '2025-09-27 13:39:05', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `reset_mails`
--

CREATE TABLE `reset_mails` (
  `id` int(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reset_mails`
--

INSERT INTO `reset_mails` (`id`, `Email`, `Status`, `Time`) VALUES
(4, 'zainamman70@gmail.com', 'Complete', '2025-10-29 13:54:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `allergies_list`
--
ALTER TABLE `allergies_list`
  ADD PRIMARY KEY (`Allergy_ID`);

--
-- Indexes for table `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `health_tips`
--
ALTER TABLE `health_tips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `individual`
--
ALTER TABLE `individual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reset_token` (`reset_token`),
  ADD KEY `idx_reset_token_expiry` (`reset_token_expiry`);

--
-- Indexes for table `ind_prescription`
--
ALTER TABLE `ind_prescription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_mails`
--
ALTER TABLE `reset_mails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `allergies_list`
--
ALTER TABLE `allergies_list`
  MODIFY `Allergy_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `family`
--
ALTER TABLE `family`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `health_tips`
--
ALTER TABLE `health_tips`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `individual`
--
ALTER TABLE `individual`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ind_prescription`
--
ALTER TABLE `ind_prescription`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reset_mails`
--
ALTER TABLE `reset_mails`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
