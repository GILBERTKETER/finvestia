-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 14, 2024 at 09:46 AM
-- Server version: 5.7.41
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finvesti_profitedge`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance_account_users_profitedge`
--

CREATE TABLE `balance_account_users_profitedge` (
  `Email_Address` varchar(100) NOT NULL,
  `User_Name` varchar(100) NOT NULL,
  `Phone_No` int(20) NOT NULL,
  `Balance_Available` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `balance_account_users_profitedge`
--

INSERT INTO `balance_account_users_profitedge` (`Email_Address`, `User_Name`, `Phone_No`, `Balance_Available`) VALUES
('gilbertketer759@gmail.com', 'superadministrator', 759104865, 0),
('osoropaul5@gmail.com', 'Osoro', 743065891, 51681),
('finvestiateam@gmail.com', 'finvestia', 721149302, 0),
('venessaawuor22@gmail.com', 'Veegilbert', 704808499, 1010),
('iankmax003@gmail.com', 'lildoggy', 790768475, 0),
('dankibettech@gmail.com', 'Dantech', 758931224, 0),
('dorcaswambui2006@gmail.com', 'Lynne', 796649443, 0),
('harankamau@gmail.com', 'Kare._haran', 790795579, 0),
('godwinbrightkipngetich@gmail.com', 'BrightG', 701887655, 0),
('brightgodwin6941@gmail.com', 'BrightG254', 724597844, 0),
('kipkorirketer71@gmail.com', 'Keter1', 795724371, 0),
('kipngenocollins710@gmail.com', 'richie betsy&#039;s', 758598360, 0),
('akipkoech58@gmail.com', 'Amoskirui', 724505809, 0),
('georgerashford8@gmail.com', 'Jor', 711578589, 0),
('33iconcyprian@gmail.com', 'badman', 799186277, 0),
('kibetchesaina@gmail.com', 'Khabett', 758079472, 0),
('kylianhassan69@gmail.com', 'kylian', 708552804, 0),
('moraamarcellah@gmail.com', 'Moraa', 708887406, 0),
('moraamarcellah11@gmail.com', 'Marcellah', 708887405, 0),
('nahashonnjugush2001@gmail.com', 'Nahashon', 746825997, 0),
('kahuyadickson@gmail.com', 'Kahuya96', 719195076, 0),
('kipkemeibrian825@gmail.com', 'Brian kipkemei', 758381591, 0),
('georgejom6@gmail.com', 'georgejom6', 743426749, 0),
('michaelodoyo99@gmail.com', 'Makutesa', 711178355, 0),
('asongaann@gmail.com', 'Viola', 758856249, 0);

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `Email_Address` varchar(100) NOT NULL,
  `User_Name` varchar(100) NOT NULL,
  `Phone_No` int(20) NOT NULL,
  `TransactionID` varchar(20) NOT NULL,
  `Transactor` text NOT NULL,
  `Amount` int(100) NOT NULL,
  `Balance` int(200) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invested_amount`
--

CREATE TABLE `invested_amount` (
  `Email_Address` varchar(100) NOT NULL,
  `Phone_No` int(50) NOT NULL,
  `Amount` int(30) NOT NULL,
  `Date_invested` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `Email_Address` varchar(100) NOT NULL,
  `User_Name` varchar(100) NOT NULL,
  `Phone_No` int(20) NOT NULL,
  `Amount` int(100) NOT NULL,
  `Days` int(100) NOT NULL,
  `Accumulative_Amount` int(100) NOT NULL,
  `Total_Amount_To_Earn` int(100) NOT NULL,
  `Status` text NOT NULL,
  `Package` text NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `End_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profitedge_users`
--

CREATE TABLE `profitedge_users` (
  `Email_Address` varchar(100) NOT NULL,
  `First_Name` text NOT NULL,
  `Last_Name` text NOT NULL,
  `User_Name` varchar(50) NOT NULL,
  `Phone_No` int(20) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Refferer` varchar(100) NOT NULL,
  `AdminOTP` int(50) NOT NULL DEFAULT '768020',
  `Joining_Day` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Joiner_Account_Type` varchar(100) NOT NULL DEFAULT 'user_account_type_joiner',
  `Status` varchar(20) NOT NULL,
  `OTPCODE` int(20) NOT NULL,
  `Verified` text NOT NULL,
  `ResetToken` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profitedge_users`
--

INSERT INTO `profitedge_users` (`Email_Address`, `First_Name`, `Last_Name`, `User_Name`, `Phone_No`, `Password`, `Refferer`, `AdminOTP`, `Joining_Day`, `Joiner_Account_Type`, `Status`, `OTPCODE`, `Verified`, `ResetToken`) VALUES
('gilbertketer759@gmail.com', 'GILBERT', 'KIPLANGAT', 'ADMIN', 759104865, '$2y$10$xt8ovwDcOExeeL9zTmU2releow2NnIkRt2LPHKgy7wIj8Biz5ubPe', 'ADMIN', 768020, '2023-08-11 12:37:39', 'finVestAdminLoggedInAccept', 'Active', 0, '1', ''),
('osoropaul5@gmail.com', 'Paul', 'Osoro', 'Osoro', 743065891, '$2y$10$qHEW8bESVkJkdPacGwpuq.u0TCoUZS/FyeicRxcA.yXAoi2UBRLAy', 'ADMIN', 768020, '2023-08-13 12:37:20', 'finVestAdminLoggedInAccept', 'Active', 0, '1', ''),
('finvestiateam@gmail.com', 'fin', 'vestia', 'finvestia', 721149302, '$2y$10$0vTuXcYDsPAKh/QjZGd0JeFkxYdQCJU3nq3bBFXOVOXpXZWRoEFVG', 'ADMIN', 768020, '2023-08-19 09:49:20', 'user_account_type_joiner', 'Active', 0, '1', 'a8d4f7a3224cc136c3a8d907f264ea0a9c86fb0baf7711a0d3445b19718c9d5e'),
('venessaawuor22@gmail.com', 'Venessa', 'Awuor', 'Veegilbert', 712345678, '$2y$10$z3Qb2.eT.LGbaY1OEasjSeoFHfqpb5EAtk0GXZ8nZ66lX03ag2/4O', 'ADMIN', 768020, '2023-08-20 11:14:32', 'user_account_type_joiner', 'Active', 0, '1', ''),
('iankmax003@gmail.com', 'Ian', 'Kipyegon', 'lildoggy', 790768475, '$2y$10$/q4b4BQ49XUro8PixEOSuOiRue4qCedgyzxjXJJCrfIuRXISOFx2i', 'ADMIN', 768020, '2023-08-20 15:34:38', 'user_account_type_joiner', 'Active', 0, '1', ''),
('dankibettech@gmail.com', 'Dan', 'Kibet', 'Dantech', 758931224, '$2y$10$RHcGq1IL4pJWNdACLsfJFeIEL73aDGWzcTdBVCnSNa9CatcjSJA06', 'ADMIN', 768020, '2023-08-21 15:05:08', 'user_account_type_joiner', 'Active', 0, '1', ''),
('dorcaswambui2006@gmail.com', 'Lynne', 'Irongi', 'Lynne', 796649443, '$2y$10$R09/nuk8yWK9bX2iWV/L8.EM8AH8X2H.hmsOpYnjEZTerYpodykL.', 'ADMIN', 768020, '2023-08-21 17:24:56', 'user_account_type_joiner', 'Active', 0, '1', ''),
('harankamau@gmail.com', 'Haran', 'K', 'Kare._haran', 790795579, '$2y$10$9y00k2PQET3WtzKtAoA1qOC7Py9ZB1dpGI1NX68ERWuGQelo8.eZG', 'Dantech', 768020, '2023-08-21 18:13:37', 'user_account_type_joiner', 'Active', 0, '1', ''),
('godwinbrightkipngetich@gmail.com', 'Godwin', 'Bright', 'BrightG', 701887655, '$2y$10$d1EnbveSYJUhYIe9v2WkueBzOQQkh.mLZlUmpmkZTSK6kuk7tQuWC', 'Dantech', 768020, '2023-08-21 18:26:39', 'user_account_type_joiner', 'Active', 456917, '0', ''),
('brightgodwin6941@gmail.com', 'Godwin', 'Bright', 'BrightG254', 724597844, '$2y$10$E7RNwsls2tqSnUsU4WwFaOHQRhnIw0mOFT1jqCyjzZaLWEPRwy112', 'Dantech', 768020, '2023-08-21 18:27:24', 'user_account_type_joiner', 'Active', 0, '1', ''),
('kipkorirketer71@gmail.com', 'Emmanuel', 'Kipkorir', 'Keter1', 795724371, '$2y$10$5N.WWxM.dDRGqqhsFqSO2.i66TZdF4j06EbB3ZymLcrEn1iEXVC/u', 'ADMIN', 768020, '2023-08-23 16:04:32', 'user_account_type_joiner', 'Active', 0, '1', ''),
('kipngenocollins710@gmail.com', 'Collins', 'koskei', 'richie betsy&#039;s', 758598360, '$2y$10$/UX2S0jx1Uii.tcdrwgKqetKhaJesPDWr9dmjAlBrkon/QLjQKvnW', 'ADMIN', 768020, '2023-09-08 09:18:43', 'user_account_type_joiner', 'Active', 0, '1', ''),
('akipkoech58@gmail.com', 'Amos', 'Kirui', 'Amoskirui', 724505809, '$2y$10$PGgksBkjRkjC5iERlCUsKuICURVqrEgdgKjcuAivUyY4yBMToD/KG', 'richie betsy&#039;s', 768020, '2023-09-08 09:45:21', 'user_account_type_joiner', 'Active', 0, '1', ''),
('georgerashford8@gmail.com', 'George', 'Otieno', 'Jor', 711578589, '$2y$10$HL6BoTtEC/O9aE.8wnYWKOndl5291zwuhDKR1kznxQfjSvdQFNp06', 'lildoggy', 768020, '2023-09-09 11:06:05', 'user_account_type_joiner', 'Active', 609904, '0', ''),
('33iconcyprian@gmail.com', 'cyprian', 'NYAKUNDI', 'badman', 799186277, '$2y$10$V4gGh8s4raFFEhrBrYirF.KJlVBShB4o6w.b9s0rxy5EIPwKDst6S', 'lildoggy', 768020, '2023-09-09 14:19:20', 'user_account_type_joiner', 'Active', 135673, '0', ''),
('kibetchesaina@gmail.com', 'Khaby', 'Bett', 'Khabett', 758079472, '$2y$10$l4dXxZGmhltJnljMicDwxuLpYvlJzvf/ZLhOCb7EEVINZiRZZyRVi', 'lildoggy', 768020, '2023-09-09 17:46:47', 'user_account_type_joiner', 'Active', 0, '1', ''),
('kylianhassan69@gmail.com', 'kylian', 'hassan', 'kylian', 708552804, '$2y$10$AYva6hlSdCyMyVzlLb/RPeOxXIFscH4fxMElUCJsncKFvEr/OA5Xy', 'ADMIN', 768020, '2023-09-16 17:59:44', 'user_account_type_joiner', 'Active', 0, '1', ''),
('moraamarcellah11@gmail.com', 'Moraa', 'Marcellah', 'Marcellah', 708887405, '$2y$10$3w4Cc7TAt8mLOUUB29IvBOr1og4TwOOeIkuwqqlOaOBmcVvmj/YZO', 'ADMIN', 768020, '2023-09-17 14:06:31', 'user_account_type_joiner', 'Active', 0, '1', ''),
('nahashonnjugush2001@gmail.com', 'Nahashon', 'Njuguna', 'Nahashon', 746825997, '$2y$10$eo0Qi0f5RP11ccJzKVgxkuFtXdQVgYK5Sp7z7EYPLNQUejWP4jEqu', 'ADMIN', 768020, '2023-09-17 15:37:50', 'user_account_type_joiner', 'Active', 0, '1', ''),
('kahuyadickson@gmail.com', 'DICKSON', 'KAHUYA', 'Kahuya96', 719195076, '$2y$10$Rpjc.sgTs7yZssPYI58XXO350owPWy8NkrT4.9iaKwW8rKjyqAsLy', 'ADMIN', 768020, '2023-09-21 11:39:03', 'user_account_type_joiner', 'Active', 192473, '0', ''),
('kipkemeibrian825@gmail.com', 'Brian', 'Kipkemei', 'Brian kipkemei', 758381591, '$2y$10$.fDfv1mgnTonbSjO65UJjOgR7qY0igOVKthuqaEjdYcntnMc5nUbS', 'richie betsy&#039;s', 768020, '2023-09-21 17:20:44', 'user_account_type_joiner', 'Active', 789554, '0', ''),
('georgejom6@gmail.com', 'George', 'Maroma', 'georgejom6', 743426749, '$2y$10$tAdxBRWftZxXBHTzD24LquV3sX4D4v6Gk6r.ZLtUmnAWiDT/kihZ.', 'ADMIN', 768020, '2023-09-22 07:29:54', 'user_account_type_joiner', 'Active', 0, '1', ''),
('michaelodoyo99@gmail.com', 'Michael', 'Odoyo', 'Makutesa', 711178355, '$2y$10$0aDHALkuvFnEt8yxGpyD1OADSJRY69SR39VKApzfx/mG78oMl6VWe', 'ADMIN', 768020, '2023-09-22 07:51:55', 'user_account_type_joiner', 'Active', 0, '1', ''),
('asongaann@gmail.com', 'Ann', 'Asonga', 'Viola', 758856249, '$2y$10$tvpcv9U4lnlYhbp4j4GuCeJee3giNg9Nr/gxMKi/fp3e.y6EGMA.a', 'ADMIN', 768020, '2023-10-13 03:12:42', 'user_account_type_joiner', 'Active', 0, '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `requestedwithdrawals`
--

CREATE TABLE `requestedwithdrawals` (
  `Email_Address` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `User_Name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `Phone_No` int(30) NOT NULL,
  `Amount` int(255) NOT NULL,
  `Recieve_From` int(30) NOT NULL,
  `TransactionID` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `Transactor` text CHARACTER SET utf8mb4 NOT NULL,
  `Date` date NOT NULL,
  `Time` time(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `set_plan`
--

CREATE TABLE `set_plan` (
  `Email_Address` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `User_Name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `Package` text CHARACTER SET utf8mb4 NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `set_plan`
--

INSERT INTO `set_plan` (`Email_Address`, `User_Name`, `Package`, `Date`) VALUES
('gilbertketer759@gmail.com', 'superadministrator', 'Bronze', '2023-08-11 12:37:39'),
('osoropaul5@gmail.com', 'Osoro', 'Bronze', '2023-08-13 12:37:20'),
('finvestiateam@gmail.com', 'finvestia', 'Bronze', '2023-08-19 09:49:20'),
('venessaawuor22@gmail.com', 'Veegilbert', 'Bronze', '2023-08-20 11:14:32'),
('iankmax003@gmail.com', 'lildoggy', 'Bronze', '2023-08-20 15:34:38'),
('dankibettech@gmail.com', 'Dantech', 'Bronze', '2023-08-21 15:05:08'),
('dorcaswambui2006@gmail.com', 'Lynne', 'Bronze', '2023-08-21 17:24:56'),
('harankamau@gmail.com', 'Kare._haran', 'Bronze', '2023-08-21 18:13:37'),
('godwinbrightkipngetich@gmail.com', 'BrightG', 'Bronze', '2023-08-21 18:26:39'),
('brightgodwin6941@gmail.com', 'BrightG254', 'Bronze', '2023-08-21 18:27:24'),
('kipkorirketer71@gmail.com', 'Keter1', 'Bronze', '2023-08-23 16:04:33'),
('kipngenocollins710@gmail.com', 'richie betsy&#039;s', 'Gold', '2023-09-08 09:18:43'),
('akipkoech58@gmail.com', 'Amoskirui', 'Bronze', '2023-09-08 09:45:21'),
('georgerashford8@gmail.com', 'Jor', 'Bronze', '2023-09-09 11:06:05'),
('33iconcyprian@gmail.com', 'badman', 'Bronze', '2023-09-09 14:19:20'),
('kibetchesaina@gmail.com', 'Khabett', 'Bronze', '2023-09-09 17:46:47'),
('kylianhassan69@gmail.com', 'kylian', 'Bronze', '2023-09-16 17:59:44'),
('moraamarcellah@gmail.com', 'Moraa', 'Bronze', '2023-09-17 14:00:59'),
('moraamarcellah11@gmail.com', 'Marcellah', 'Bronze', '2023-09-17 14:06:31'),
('nahashonnjugush2001@gmail.com', 'Nahashon', 'Bronze', '2023-09-17 15:37:50'),
('kahuyadickson@gmail.com', 'Kahuya96', 'Bronze', '2023-09-21 11:39:03'),
('kipkemeibrian825@gmail.com', 'Brian kipkemei', 'Bronze', '2023-09-21 17:20:44'),
('georgejom6@gmail.com', 'georgejom6', 'Bronze', '2023-09-22 07:29:54'),
('michaelodoyo99@gmail.com', 'Makutesa', 'Bronze', '2023-09-22 07:51:55'),
('asongaann@gmail.com', 'Viola', 'Bronze', '2023-10-13 03:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `transactionsupdate`
--

CREATE TABLE `transactionsupdate` (
  `Email_Address` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `User_Name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `Transactor` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `TransactionID` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `Phone_No` int(30) NOT NULL,
  `Amount` int(100) NOT NULL,
  `Date` date NOT NULL,
  `Time` time(6) NOT NULL,
  `Confirmed` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `PayTo` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `Email_Address` varchar(100) NOT NULL,
  `User_Name` varchar(100) NOT NULL,
  `Phone_No` int(30) NOT NULL,
  `TransactionID` varchar(30) NOT NULL,
  `Transactor` int(30) NOT NULL,
  `Amount` int(100) NOT NULL,
  `Balance` int(100) NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
