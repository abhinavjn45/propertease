-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 28, 2025 at 11:41 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u160623252_jagarancghs`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `member_unique_id` varchar(255) NOT NULL,
  `member_salutation` varchar(255) NOT NULL,
  `member_fullname` text NOT NULL,
  `member_flat_number` varchar(255) NOT NULL,
  `member_block` varchar(255) NOT NULL,
  `member_email` varchar(255) NOT NULL,
  `member_password` text DEFAULT NULL,
  `member_phone_number` varchar(15) NOT NULL,
  `member_image` text DEFAULT NULL,
  `member_type` varchar(255) NOT NULL DEFAULT 'owner' COMMENT 'owner, tenant',
  `member_vkey` text NOT NULL,
  `member_status` varchar(255) NOT NULL DEFAULT 'active' COMMENT 'active, inactive, deleted',
  `member_added_by` varchar(255) NOT NULL,
  `member_added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `member_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `member_unique_id`, `member_salutation`, `member_fullname`, `member_flat_number`, `member_block`, `member_email`, `member_password`, `member_phone_number`, `member_image`, `member_type`, `member_vkey`, `member_status`, `member_added_by`, `member_added_on`, `member_updated_on`) VALUES
(1, 'JCGHS101A00302', 'MR.', 'R K MEENA & GANGA MEENA', '101', 'A', 'ramkrishan2022@gmail.com', '$2y$10$hhIKb5qUg.32hVTQLuB4YOvTfGXoX/DjvRMqQxZq5nxbbCKKPxzEe', '+91 99104 87548', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(2, 'JCGHS102A00336', 'SMT.', 'RIDHM BHATIA & JASPAL SINGH', '102', 'A', 'mail2bhatia@gmail.com', '$2y$10$TAhRPb.BnupAOuUmcWvh.OIhrLhoYEJTd19LEg4Y27QuV1xGMoAdO', '+91 84486 69737', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(3, 'JCGHS103A00250', 'SHRI', 'GAUTAM GHOSH', '103', 'A', 'goutamghosh1@rediffmail.co.in', '$2y$10$qkxPOVBqu3LvNUusdjZivO0LssDlfwioLfOKLh1qs28SPGFr/tE5u', '+91 99710 19164', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(4, 'JCGHS201A00266', 'DR.', 'RAKESH ANGNIHOTRI', '201', 'A', 'rakeshagnihotri56@yahoo.co.in', '$2y$10$Ys0e0lwn9dsJz0pHPCbwcO9rTwyQIGpRYKqCUZlsqCGdLJY7/PKv2', '+91 98160 43287', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(5, 'JCGHS202A00337', 'SMT.', 'SHEETAL GUPTA & SACHIN GUPTA', '202', 'A', 'sachinguptaepf@gmail.com', '$2y$10$C2plyo6rTGtj2WhPLTE80eUZl.atoP0BAewS5BJfQw8fkTF23Q7da', '+91 98107 04754', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(6, 'JCGHS203A00304', 'SMT.', 'PADMA C.S. ', '203', 'A', 'padmajacs@aai.aero', '$2y$10$phIrvZQ7GDDLzFYoPNDO8.hNspYLnm6/mzbPF2CMRHw8wmaKlETbe', '+91 98688 20927', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(7, 'JCGHS301A00256', 'Dr.', 'ANUP KUMAR GHOSH', '301', 'A', 'anupkghosh@gmail.com', '$2y$10$5YvE/hrk5WJSEcv8sXoC5uyHu4DxxG5wNH8.Xi.s9Gp.rpZF62kc6', '+91 98104 32622', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(8, 'JCGHS302A00321', 'Dr.', 'SURINDER SINGH DALAL', '302', 'A', 'anantdalal@yahoo.com', '$2y$10$osw8W2rHi/irj2ae2jvj.uYP9bm9h4./PNJzZvQhKP37.I8NlmtRG', '+91 94163 60618', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(9, 'JCGHS303A00291', 'SHRI.', 'P K CHOUDHARY', '303', 'A', 'pkcdwarka1960@gmail.com', '$2y$10$Drj5Dhke.BuYUOMKxyFBrOOckupV4O5g5J0RedU2/I9JUHeilvymG', '+91 81465 91484', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(10, 'JCGHS401A00217', 'SHRI', 'R K VERMA & KUSUM LATA VERMA', '401', 'A', 'ravi2658@yahoo.co.in', '$2y$10$tDVOX5OBASiawBqmPYJtaOfw4NHxtMLnC9bCo.4S.seCl6i3ox3Gu', '+91 98681 67199', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(11, 'JCGHS402A00203', 'DR.', 'RAJ PAL', '402', 'A', 'rajpal340@gmail.com', '$2y$10$N/acxOf4jJN.g3Jz7xNyBehOfHpYwsevVmaihp5k95HIoekPNNpv.', '+91 98105 97697', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(12, 'JCGHS403A00342', 'MRS.', 'SHIKHA YADAV', '403', 'A', 'PawanRao81@gmail.com', '$2y$10$FIihWlWDTkm15oYscGrwMOs/UK/caF0iCu7lbBflLdXirOj6tpEpW', '+91 85271 97867', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(13, 'JCGHS501A00210', 'SHRI', 'Y K PATHAK', '501', 'A', 'yogendra1511@yahoo.in', '$2y$10$EYN5gbI4oRi29E1E/oAoeOnrSB6EjdNDeyH1zig0lcO39tmX1pXNK', '+91 99113 62455', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(14, 'JCGHS502A00257', 'DR.', 'SANJAY AGGARWAL', '502', 'A', 'gagagear@gmail.com', '$2y$10$ezxjHaF/S6b1dSBUjJ5oauHt.DLzduv5kncCakPFsQLC/i07cgUXW', '+91 77018 23537', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(15, 'JCGHS503A00299', 'DR.', 'NEELAM NAG', '503', 'A', 'neelamnag13@yahoo.com', '$2y$10$gp1v/nb4WU8OWXoU9ZZkBuSbYiaKYDhHHLXkhEyv0jPEYd9TRhe0K', '+91 98711 19330', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(16, 'JCGHS601A00328', 'CAPT.', 'NAVEEN SAROHA & JYOTI SAROHA', '601', 'A', 'captsaroha1@yahoo.com', '$2y$10$naXGHRoA9QjhBURcBClIwepFfTL3qy9iK5.tAuyL3JLIV5FgGpWHm', '+91 98682 50520', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(17, 'JCGHS602A00231', 'DR.', 'N R BISWAS', '602', 'A', 'director@igims.org ', '$2y$10$Tuf0AJt0LcDSUUpbSA8FQ.Hr7jv5aKcyrEmihiJCF8Cl7oF1TgTF2', '+91 62026 21449', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(18, 'JCGHS603A00301', 'DR.', 'Y R SHARMA', '603', 'A', 'yograjsharma@yahoo.com', '$2y$10$6Isl8TEhi/3I8rWYLEvw7.Y1ypgA0pW2RlT.5k.vwVWix4A2pKbWa', '+91 99581 14551', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(19, 'JCGHS701A00311', 'SHRI.', 'VINAY ARORA', '701', 'A', 'VINAYARORA@gmail.com', '$2y$10$4hHYlJzORl8Mne6U74iWeepJ2rO9k1GG3MiZtf5kMjUYAU6NeASfO', '+91 99582 85858', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(20, 'JCGHS702A00334', 'SHRI.', 'SIRAJ SINGH SOHAL & HARBINDER KAUR', '702', 'A', 'siraj_singh@yahoo.com ', '$2y$10$zJLggxP8D3qbIp8bIxMKLOgG5ZzoSk8t3WtGozIaQLMASkFVnVmZK', '+91 96503 16627', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:50:25', NULL),
(21, 'JCGHS801A00278', 'SHRI.', 'RAM GOPAL', '801', 'A', 'gopalr1940@gmail.com', '$2y$10$WFK5oP5nCBJiTABbzkICTuRL2p3ye6AViu814BkRWMgTtKfZ.2VHG', '+91 75404 93655', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(22, 'JCGHS802A00117', 'SMT.', 'SMRITI KANA MANDAL', '802', 'A', 'getarnab1@gmail.com ', '$2y$10$f/YJD8EETdo2Ho9xF5QekuoGQqmWVfHgSw3fhIHYDNOzAtIa7xuFq', '+91 98302 27083', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(23, 'JCGHS101B00335', 'SMT.', 'RAMESH YADAV', '101', 'B', 'narender_yadav@hotmail.com ', '$2y$10$7zUyajpMa.ngEASjndqnE.xZCuNUbiFjnYl7H40N9WakdgcAFEQuS', '+91 96546 34000', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(24, 'JCGHS102B00344', 'SMT.', 'LAXMI JASWAL AND VIKAS JASWAL', '102', 'B', 'vikasjaswal2001@yahoo.co.uk', '$2y$10$9mBepkRSYkUKycKn6/6kFO9fWvGVcxHU8Nx3dCLzsAY2suR3hOUnu', '+91 92896 62545', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(25, 'JCGHS201B00327', 'SHRI.', 'HITESH KUMAR ARYA AND ARCHANA GUPTA', '201', 'B', 'drhitesharya74@gmail.com ', '$2y$10$dyiannNtD./YXlmWcV4o8uIp/hsBa1/BEriDOnWgJP6PnJ9q0i7xG', '+91 97172 87770', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(26, 'JCGHS202B00216', 'SHRI.', 'PHOOL SINGH', '202', 'B', 'skmurathia@gmail.com', '$2y$10$vDrOKFt78DslCFTd/XznI.9sc6FWJ5Ry0Dgw8EK69x6DWwSirOv7i', '+91 82797 34390', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(27, 'JCGHS301B00147', 'SMT.', 'NIVADITA BISWAS', '301', 'B', 'niv.biswas@gmail.com', '$2y$10$0brlIcaw3BMIPoX5H9nJNuEumpyLp8TiwL1ao/YgI7k.HgWB64O.u', '+91 98481 72565', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(28, 'JCGHS302B00290', 'SMT.', 'USHA VERMA', '302', 'B', 'ushakavi.verma@gmail.com ', '$2y$10$fq0Epa2LkzINiPhzl4IwqeyZl8W91fL8SFvrtFriREFE67BlBe5QS', '+91 98682 41809', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(29, 'JCGHS401B00267', 'SMT.', 'GARGI GOLDER', '401', 'B', 'gargi_goldar@rediffmail.com', '$2y$10$8BexQgFNlTYxjTo3JoYjEeUHJqpFqb/7/DvsaHfpk4vMtCiHncK5S', '+91 98115 38829', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(30, 'JCGHS402B00190', 'SHRI.', 'H S CHAHAR', '402', 'B', 'chahar1048@yahoo.com', '$2y$10$TXRauxxJ1zPaqNCttxzUTOVabR3Nujr9wD/ccAmcdEFStNXPfHSA2', '+91 98688 92426', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(31, 'JCGHS501B00324', 'SMT.', 'ANSHOOL JOON', '501', 'B', 'joon.anshul@gmail.com', '$2y$10$V3BaG4qj81uqyKsGHYpWoOI48dbd35AG1vKJ5iXiNPHhtfSlfmixS', '+91 98100 44288', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(32, 'JCGHS502B00305', 'SMT.', 'GEETA AGGARWAL', '502', 'B', 'vka1996@gmail.com', '$2y$10$uYFUHw4Gp5wRAwF0q.EMOul2Wl8fK8zomRNoV0rnBuZLunI5dsW9u', '+91 98189 33799', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(33, 'JCGHS601B00178', 'SHRI.', 'KINGSHUKA MANDAL', '601', 'B', 'kingshukmandal@hotmail.com ', '$2y$10$1s7Jh9ddOpuIZBSmpAI9T.NT8mNriBX7Zsv3msfI6kXW6qsTkAuSy', '+91 11268 94854', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(34, 'JCGHS602B00208', 'SMT.', 'SABARI GHOSH AND SHRIKANTA KUMAR GHOSH', '602', 'B', 'sabari.ghosh70@gmail.com', '$2y$10$ntJzDZcIs8WEbzq0wgKB2O6N8Z6Ig0y.0CwRqSqN2qZi6sZLw0UsG', '+91 98104 55118', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(35, 'JCGHS701B00090', 'SHRI.', 'M.K. MANDAL', '701', 'B', 'mkmandal10@gmail.com', '$2y$10$mJSH5/S3g6KPZDCVaE4io.0K.Zfhm5AiJh1.NTa4s1ExcZ1Vh1vaC', '+91 81300 08594', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(36, 'JCGHS702B00229', 'DR.', 'KAUSHAL KUMAR VERMA', '702', 'B', 'prokverma@hotmail.com', '$2y$10$XdC.bZeXsWpe0BQT9HOh3O/Z6RXKaL7E2QOZhtfPMfKFh/YNOFag2', '+91 99990 37354', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(37, 'JCGHS801B00272', 'SHRI.', 'ANAND PRAKASH JAIN', '801', 'B', 'shwetapavni@gmail.com', '$2y$10$QjPi02g6wM4R6UFQ37YQMuMw/IvaIXuIGTBG29gupFuh9bXIPufae', '+91 78388 42013', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(38, 'JCGHS802B00245', 'SHRI.', 'GEETA GARG', '802', 'B', 'Gargsangita1@gmail.com', '$2y$10$PaYFB/g72fJPmaME3L5SS.JOs/ZSeWcDAJ8xhc91tUlopfVNnvE3m', '+91 98992 69445', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(39, 'JCGHS101C00338', 'MR.', 'ANSHUL MALIK & SUNITA MALIK', '101', 'C', 'malikanshul95@gmail.com ', '$2y$10$.ZINb9YAY6wOOsmvpsWxOOH9fT31cepwVqb6EpiW/27WFNeTeNsa6', '+91 88002 42536', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(40, 'JCGHS102C00279', 'SMT. ', 'SANDHYA VARSENEY', '102', 'C', 'dinsanv@gmail.com', '$2y$10$pY9.OMTNKApRD1gqKWgOcOq2vy3AiaM.a6tcFfDw6HPYGeen6HBK.', '+91 98684 53635', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:02', NULL),
(41, 'JCGHS103C00345', 'MR.', 'ABHISHEK VERMA', '103', 'C', '85.abhishek@gmail.com', '$2y$10$214egWTtaFJkajY0nOetJefsGz/KYfn3FZTbbW5w9hv9kHeDvacwy', '+91  ', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(42, 'JCGHS201C00333', 'Mrs.', 'SANTOSH KUBBA', '201', 'C', 's_kubba@yahoo.com ', '$2y$10$bsV4tlXI.NHAx.rswvn3kee0/mitVSFPZ5SBitOCcLj7HhC/j.eNe', '+91 81306 83499', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(43, 'JCGHS202C00230', 'SHRI.', 'SAMAR ABBAS', '202', 'C', 'drafsarabbas@gmail.com', '$2y$10$X00ZurAR7ZHciGVxkgLwTuHDMh5TBlChU6OInUuEGJ9k3IEGa5XCi', '+91 99718 38975', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(44, 'JCGHS203C00269', 'SHRI.', 'C. JENNY RAJ', '203', 'C', 'rohitbenny@yahoo.com', '$2y$10$AQEhZMsDHJGPLpz9hxe11.T.9VaoJv964ur5SG.zvr0FsBQ.svswu', '+91 98710 35959', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(45, 'JCGHS301C00218', 'SHRI.', 'ALOK KUMAR', '301', 'C', 'AIRCMDE.HPSINGH@GMAIL.COM', '$2y$10$CPE8/MmEqOWfv6eaUve06uCD0LeLT0vjv6bt/389ECs429ljUtKQS', '+91 98180 55137', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(46, 'JCGHS302C00271', 'SMT.', 'VANDANA VERMA', '302', 'C', 'verma.vandy@gmail.com ', '$2y$10$vq5ApfPccxL5Y6hRwKGi5.0yhAQ3Nwlt6ipeCyPBdk3E.obbT5Yi.', '+91 98105 97712', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(47, 'JCGHS303C00317', 'SHRI.', 'BHARAT BHUSHAN LOHIA & GAURAV LOHIA', '303', 'C', 'glohia@gmail.com', '$2y$10$xOBu30sqcekVfbRhzy6uv.N.CKWdEqrdOm4xUI7Fp/yoU4Jh73AIG', '+91 98100 96705', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(48, 'JCGHS401C00136', 'SHRI.', 'S K SARKAR', '401', 'C', 'santoshsarkar231@gmail.com ', '$2y$10$nnu/o326.wi/Vqj6Yf.Ude6SFFRisLfwW15IoI9sjkJX1x4Pl8pgW', '+91 90131 79867', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(49, 'JCGHS402C00213', 'SMT.', 'RAJ KUMARI', '402', 'C', 'kcee56@yahoo.co.in', '$2y$10$FsV01f6/jTcG1h2V/uihr.qRBUfKGiCZVVsO1TFJCOfMCA1Kq6t3S', '+91 96500 64145', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(50, 'JCGHS403C00343', 'SHRI.', 'GARGY AND PRASHANT RASTOGI', '403', 'C', 'gargyrastogi94@gmail.com ', '$2y$10$M8SmAgCLaQtwEZvWVhuqmu3MdEXsRK4KzS3KAyrIeCjUMErrB/dUy', '+91 96542 96726', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(51, 'JCGHS501C00258', 'SHRI.', 'PRAMOD KUMAR MISHRA', '501', 'C', 'pkmaai@gmail.com ', '$2y$10$rsm/gV8k/vhhbGohm4f1MOOzj8C8ITPSMqXqjvZrdqScarx4dS4W6', '+91 99102 11770', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(52, 'JCGHS502C00196', 'SMT.', 'SEEMA SHARMA', '502', 'C', 'healingacupoints@gmail.com ', '$2y$10$G6BTGg1ZxONbOlir/1TLKeqoAZPejKxHFhtiFFSpiV4gs/RmSr8lK', '+91 1(832 23306', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(53, 'JCGHS503C00253', 'SMT.', 'LALITA RAWAT', '503', 'C', 'inder.rawat28@gmail.com', '$2y$10$nEmVasRw4vq8BxDtW7PNdeVjEx/yteHViKAfUlniCR/S2npFEDfZu', '+91 99682 60906', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(54, 'JCGHS601C00282', 'SHRI.', 'A.K. SHRIVASTAVA', '601', 'C', 'aks5858@yahoo.in', '$2y$10$fljpeGY0ObS/g/8ISZAjzujlAQ/wuhxacvq/M9MexuaogVFbAJBfa', '+91 98183 14688', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(55, 'JCGHS602C00198', 'SHRI.', 'MICHEL RODRICK', '602', 'C', 'mrodrick@gmail.com', '$2y$10$XRHjeG7aeCiYeKRRfWPF3uUYS5lhkizoiUYHzNyz1Vq1/0nqf7ecW', '+91 98110 92485', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(56, 'JCGHS603C00313', 'SHRI.', 'ABHISHEK KUMAR', '603', 'C', 'abhishek@jkfenner.com', '$2y$10$GuRt4gqYve2QK3x9u.MZkuiQ1mF60/WmmQqd3oAAXKWX0fa5FCOpm', '+91 95662 33577', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(57, 'JCGHS701C00219', 'SHRI.', 'R K JAIN', '701', 'C', 'r_k_jain@yahoo.com', '$2y$10$br/FunTBapRd0Pzlactrgu1boqQ5N7088HG2sP.QjaQ99oFcIHi5a', '+91 98189 99220', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(58, 'JCGHS702C00212', 'SMT.', 'HIMANI MAJUMDAR', '702', 'C', 'majumdar_himani@rediffmail.com ', '$2y$10$D6K9HqtvXvPogwZ/G.krHOD7GixkTXtFHkbDdLWUrDdaaWrFWN6zi', '+91 98683 84597', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(59, 'JCGHS801C00259', 'SHRI.', 'B P N SINGH & GK SINGH', '801', 'C', 'kumar_bpn@hotmail.com', '$2y$10$iYDzRjwYvPnAnu8bBfRB..OnPmvsmAecgzh5p5httw0BrBgXbAWFe', '+91 98108 04765', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(60, 'JCGHS802C00347', 'SMT.', 'SUSHMA RASTOGI', '802', 'C', 'academy.sargam@gmail.com', '$2y$10$bVmNrGb8ToDWwzElcSA2ZODoO2OB2DmO0WGsTjtwNszIjf02IzyUW', '+91  ', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
(61, 'JCGHS101D00252', 'SHRI.', 'RAJENDRA PRASHAD', '101', 'D', 'rpparashar54@gmail.com', '$2y$10$eXp1C6tM4u29sKeYONboxehC/XWlQqdaPAjwTRO798D8Q8eW2/1UG', '+91 98183 18070', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(62, 'JCGHS102D00206', 'SHRI.', 'SUSHEEL KUMAR', '102', 'D', 'pathak_susheel@yahoo.com', '$2y$10$cuBN6nwjipr94.1ceiZrbe.XA6GbfCpJEyyqRzdrlEP4XnP2OswtO', '+91 97117 19262', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(63, 'JCGHS103D00310', 'SHRI.', 'CHANDER MOHAN KALER', '103', 'D', 'chander.kaler@gmail.com', '$2y$10$vKHQwG4n8EYXW5zdqa2Dh.c5WSMxdKkrPGAGna0IvuHjhqRbchwcS', '+91 99903 83518', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(64, 'JCGHS201D00326', 'SMT.', 'BABITA PRADHAN', '201', 'D', 'ravi.ts.int@gmail.com', '$2y$10$yp/GDGm5vgL4tqheaixj/.NIOpRPvhAP1SZCT879BbvqUT1zAd3J.', '+91 98100 01719', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(65, 'JCGHS202D00202', 'SHRI.', 'RAM DULARE SHARMA', '202', 'D', 'ramdsharma@rediffmail.com', '$2y$10$16NRCJMqgZumzCsf2tDlbuwAOg0Zvd4T4h6KZXD4Vltsa4tAHbO.y', '+91 99715 80271', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(66, 'JCGHS203D00287', 'DR.', 'DULAL GOLDAR', '203', 'D', 'dulalgoldar@gmail.com', '$2y$10$VnwJOKv1GNXhjjzTA8E8TOrdgjl6rjNF9rGRF6wb2gw1deEuWD0VW', '+91 98104 89441', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(67, 'JCGHS301D00308', 'SHRI.', 'AKASH LOHIA & VIKAS LOHIA ', '301', 'D', 'vikas@citytecsolution.com', '$2y$10$BI5oXoC6LUpQDJWbv.CTmO5JDm8E8VPsFxu3pUpa9UQPLtw7SO6Zq', '+91 98112 74022', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(68, 'JCGHS302D00234', 'SMT.', 'ANURADHA JOSHI DUGRA PAL', '302', 'D', 'durgapal2002@yahoo.co.in', '$2y$10$TSQz9DEYw6N4GQTncCLffOR3JEgRDBtneOxZ5HeuV1hBk6mb.xk12', '+91 98681 37535', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(69, 'JCGHS303D00189', 'SHRI.', 'AMITAYUDAS', '303', 'D', 'das.amitayu@gmail.com', '$2y$10$.f9YcoKTQFfa3FnS2AqGzuIi3xdC0GVD/meRl50brtYwmzdDoIhN.', '+91 99686 05331', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(70, 'JCGHS401D00240', 'SHRI.', 'HARJEET SINGH &  SARITA  SABHARWAL', '401', 'D', 'confidence.saksham@gmail.com ', '$2y$10$uzSW3r3sd3CGDDIdEQoY2.O6wB8J49NxLRxn30pYI6k2f.xNMkWDS', '+91 93122 89028', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(71, 'JCGHS402D00270', 'SHRI.', 'HARPREET SINGH ANAND', '402', 'D', 'hsanand@gmail.com', '$2y$10$yn.LL7OWPQDmnXRxTeGzce6rQ8lHwIlAwLo47hG/ZLXTky61Zbo92', '+91 98182 10032', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(72, 'JCGHS403D00329', 'SHRI.', 'GAURAV SHARMA AND PAYAL BHATT', '403', 'D', 'gauravsharma2078@gmail.com ', '$2y$10$R1JVP11MUHS8MgiwQw0QE.KjBHZVqP4/aCS3QFfiYLSM7258UMeNi', '+91 98710 34442', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(73, 'JCGHS501D00194', 'SMT.', 'RITA GUHA', '501', 'D', 'bkguha@gmail.com', '$2y$10$zaS6V4PK8sUG1xPuP4as4.96I9Q.LRBvHPBuGI89FVs4FNDHOae6.', '+91 98736 32507', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(74, 'JCGHS502D00276', 'SHRI.', 'RAJESH KUMAR YADHUVANSI', '502', 'D', 'r.yaduvanshi@hotmail.com', '$2y$10$ylXd3qTodR11Y61E3PR3j.p5mZfiQs4WlOdGviwxShlEmBuFjdODK', '+91 95992 24078', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(75, 'JCGHS503D00191', 'SHRI.', 'JAYANTO CHAKRBORTHY', '503', 'D', 'jayanta.bank1@gmail.com', '$2y$10$SXk4CcAu8tsGi1TgnMPz9.1MiBjaxNJrkJFF4ipbq.KDkpij0IFY6', '+91 81783 90806', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(76, 'JCGHS601D00340', 'SMT.', 'PRACHEE MOHANTI & SUDHIR KUMAR SATPATHY & SUBRAT KUMAR SATPATHY', '601', 'D', 'pracheeinfy2@gmail.com ', '$2y$10$INeUvFmlpk/mPi6366SvOuUNYx6lVWNlWvW4.AxpkgQwasTyrl7jC', '+91 98112 13159', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(77, 'JCGHS602D00315', 'SMT.', 'BINA AGGARWAL', '602', 'D', 'kbagarwal2806@gmail.com', '$2y$10$6uOriu95wFxFXM9ghbILEOdLR/uo04WIPxGk6RmkHqkqa2Zmh4Gci', '+91 94126 43658', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(78, 'JCGHS603D00320', 'MR.', 'RAKESH MEHTA & SEEMA MEHTA', '603', 'D', 'mehtar65@gmail.com', '$2y$10$jDKuZVO2dBwsJmpVlRxzhuUNXlU9m3VyrX7sdElOTlMY7FnSyeBom', '+91 97177 82925', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(79, 'JCGHS701D00268', 'SMT.', 'NANDITA GHATAYAT', '701', 'D', 'subhendu_g1@yahoo.com', '$2y$10$xIZm8P5raR6mSZ8BuI2L5eGOLy2AyIlNxwy8h8iEwNNfRK0Lk5cje', '+91 94372 05970', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(80, 'JCGHS702D00263', 'DR.', 'S.K. SIKDAR & DEVELINA SIKDAR', '702', 'D', 'sikdarsk@gmail.com ', '$2y$10$ahIC8yhGVUxjtXiUeBRTJuedhgQ2BIe8m4Vq5ouunSJ7wjBxNhDWW', '+91 99114 22499', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:51', NULL),
(81, 'JCGHS801D00331', 'SHRI.', 'VIVEK YADAV AND ADITI YADAV', '801', 'D', 'by17137@gmail.com ', '$2y$10$QOV2lG6lOoK1etDBuZNtaecaETsI5WK7Tgb8Du//X68gtqzKFiRPi', '+91 96544 25118', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(82, 'JCGHS802D00138', 'DR.', 'H N MISHRA', '802', 'D', 'mmknyrim@gmail.com ', '$2y$10$NZjOhKtBrofqYerQJKvUSeFIwEzyIVar6E4oyPBF8fiq4xwzrXk.C', '+91 15120 23540', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(83, 'JCGHS101E00233', 'SHRI.', 'SAIN DITTA', '101', 'E', 'sainditta10@gmail.com', '$2y$10$wrz6LSgCedfKcAUt8w0fyew7JhI5fTayrH00LSUy5xrt8UtlNOqoC', '+91 98996 54315', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(84, 'JCGHS102E00286', 'SHRI.', 'MANOJ SIKDAR', '102', 'E', 'sikdar.manoj@gmail.com', '$2y$10$bDlLFBtDkZQZ67Wdx7deKeSbLFDRU.L0xWf6Vcz0A23vcRuisIbta', '+91 98184 24368', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(85, 'JCGHS201E00284', 'SHRI.', 'R K PANDEY', '201', 'E', 'rkpandey57@hotmail.com', '$2y$10$MlOH31lFXIAXkNooIHfQHe3OOBTAGmUCDTHU/hFcSeASp8O7ibGSO', '+91 83769 00509', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(86, 'JCGHS202E00292', 'SHRI.', 'VISHAL SOOD', '202', 'E', 'vishalsood14@gmail.com', '$2y$10$.lwU8AIfnoHojOCy/lV.4O1n9Y58hrJeHThmLpGfL0eYqmgyJ/1lq', '+91 90080 27647', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(87, 'JCGHS301E00232', 'SHRI.', 'RAVINESH KUMAR', '301', 'E', 'ravineshkumar1957@gmail.com ', '$2y$10$vkE5wN.Y7nbde8sDd/4zHutLWMvcT3jrqRZjOAbS06GckH/WGw/RS', '+91 93117 85107', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(88, 'JCGHS302E00281', 'SHRI.', 'SURESH KUMAR', '302', 'E', 'bansalaman7@gmail.com', '$2y$10$yjYcVx/RNJ9ddeMYA.WTueC2ral8J1ZCWJcAat8rfGegKjKi66eyK', '+91 98111 01739', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(89, 'JCGHS401E00332', 'SHRI.', 'ROOPAK JAIN AND NEETU JAIN', '401', 'E', 'jainroopak@gmail.com ', '$2y$10$0tn00Hi7piefB4KlcAbs..sQ8JYeW0imWHo7ByhrosI3UwMERxW8O', '+91 99113 88297', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(90, 'JCGHS402E00339', 'SHRI.', 'VARUN BHATIA & KANIKA', '402', 'E', 'varun.bhatia03@gmail.com ', '$2y$10$zBpoq6e2txtBUZQRxSrVSu2H.uA9BoSR0T0Uagj2Fsky5akRvan2e', '+91 98733 82342', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(91, 'JCGHS501E00204', 'SMT.', 'KRISHNA TANWAR', '501', 'E', 'sachintan1121@gmail.com ', '$2y$10$sWxZ3kVdIVCNXZfWLpjBEe0gZDXxI25mn1XbFjPn6LY66qEgG2kE.', '+91 93119 64480', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(92, 'JCGHS502E00221', 'SHRI', 'B K ARYA', '502', 'E', 'bkarya1664@gmail.com', '$2y$10$.GrPUJz8fjKnaaIZX5dyveehyxLECAOSkC8/5PssjY2tvV/t8xM76', '+91 98684 38594', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(93, 'JCGHS601E00306', 'SHRI', 'P K CHUG', '601', 'E', 'chugpk@gmail.com', '$2y$10$gEStg7LbFuNFKCvC9noj.efVgnCIdIgGjyFqt.wunm37QZpUJWYBO', '+91 98185 62642', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(94, 'JCGHS602E00249', 'SMT.', 'RITA MISRA & KAMLESH SETH', '602', 'E', 'ritamisra1@hotmail.com ', '$2y$10$r0MV16FtxJNG7pz7cDu27eMrCrUCe5tiNB0TgOpbyEvBepKm05GKm', '+91 99719 95619', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(95, 'JCGHS701E00319', 'SHRI.', 'RAJESH KUMAR SOLANKI & REKHA SOLANKI', '701', 'E', 'rajeshkumar.solanki@yahoo.in', '$2y$10$7MrvZjNzsV6DV2DLJaPrkO3bCVWX1M/vsJ9sDsocR3KzzIV0GWc2C', '+91 98110 63190', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(96, 'JCGHS702E00237', 'SHRI.', 'RAJENDER KUMAR', '702', 'E', 'rathirk702@gmail.com', '$2y$10$YPEv7tp6zecWI.EOWVtFk.ww15tWfOMqEgcKWNfbYKQ4j8U/XtM2m', '+91 99993 43227', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(97, 'JCGHS801E00214', 'SHRI.', 'BRAHMA PRAKASH', '801', 'E', 'bpnahar51@gmail.com', '$2y$10$ejDljtY6y75pILKToJHKg.ZKrmskHxuELlFAfBQ7IS5zwJSndR8RO', '+91 98681 54420', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(98, 'JCGHS802E00223', 'SHRI.', 'D K BEHERA', '802', 'E', 'b.littledilip@rediffmail.com', '$2y$10$ZaqP.1Sv90SLte6qYhbfpOd.K.Sc.1oRPdBrn5RHcDplozBfeQJzK', '+91 94370 42865', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(99, 'JCGHS101F00238', 'SHRI.', 'GHANSHYAM PRASAD', '101', 'F', 'ghanshyam_prasad@yahoo.com', '$2y$10$nCqUUhXTsBhFt/z6ytgndOjca9XwHLmsIai.le8rcmKCGMQ7oaGZO', '+91 99683 01928', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(100, 'JCGHS102F00288', 'SHRI.', 'PABITRA  SARKAR', '102', 'F', 'pk.sarkar1959@gmail.com', '$2y$10$w.ztPNQVtNZzL9NJF85.g.CBDVwK5saLCAJzBudlZrS/HUM4yxGBS', '+91 98113 10642', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:52:11', NULL),
(101, 'JCGHS103F00163', 'SMT.', 'KAKALI MANDAL', '103', 'F', 'sbm1959@gmail.com', '$2y$10$4mElQb8pzcCNwd21nHO.QO0.sgW5a1GXQtzy4/8HWtaHdEKh7Wmdm', '+91 98117 13298', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(102, 'JCGHS201F00273', 'SHRI.', 'A. K. JAIN', '201', 'F', '', '', '+91 98183 77678', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(103, 'JCGHS202F00341', 'SHRI.', 'RAJAT MATHUR AND SMITA MATHUR', '202', 'F', 'aryavir.vir@gmail.com', '$2y$10$2gCdtkgG0cgWujdHloUWMuAK1e7u2fCBKeVz7Vqo2LpiKlv0RX7Ei', '+91 98890 03203', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(104, 'JCGHS203F00298', 'SHRI.', 'PANNI LAL', '203', 'F', 'pnirbhik@gmail.com ', '$2y$10$qe4.FheCQcjt0QZgdwS6Qu/FGMv1PUXtl.soPYCQR3BmmuymsE5Za', '+91 88009 92909', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(105, 'JCGHS301F00235', 'SHRI.', 'RATAN LAL ROHILLA', '301', 'F', 'rattanlalrohilla1938@gmail.com', '$2y$10$iOxU73Co6WRwLXfrAemFIuwaii6SQ8YaP0y9Evan5IS1WpmkzD1W.', '+91 90132 21798', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(106, 'JCGHS302F00241', 'GEN.', 'COL V. K. SAXENA', '302', 'F', 'vk31014@yahoo.com', '$2y$10$xloqa2MzuB1kZfp9nVYyV.naYeaTlWVt5tvWxJ.ZtQmuo0ZYUa9FW', '+91 88002 64144', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(107, 'JCGHS303F00226', 'SMT.', 'SUBHAGA PAL', '303', 'F', 'mady150@gmail.com', '$2y$10$g5IEJQS4qnp6LWgPuycW3OFc1pswVmxie81PsFkHXY3krP6Uv8sA2', '+91 99681 57870', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(108, 'JCGHS401F00067', 'SHRI.', 'A. K. TALUKDAR', '401', 'F', 'amit.talukdar@gmail.com ', '$2y$10$hzJXTpXY5fcrgV0CseGQZeFPmJy.9H/oL78hBGS7hYtdgexTlj6/S', '+91 98111 84687', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(109, 'JCGHS402F00228', 'DR.', 'O P MURTY', '402', 'F', 'rdmurty2008@yahoo.co.in', '$2y$10$e8HQa1NIjcn7jI3Rnj4QBOTZBmL0TnSe7YGyuo1FxoQ6oV7xj0yBa', '+91 98683 97155', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(110, 'JCGHS403F00303', 'SMT.', 'MEERA BANARJEE', '403', 'F', 'banerjee.meera@gmail.com', '$2y$10$kfYhkXi//lPThMTN2kes9.h.SVl2O0guWxcfEYM5vKxnDpfgtdFqa', '+91 98187 80260', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(111, 'JCGHS501F00289', 'SMT.', 'MEETA SARKAR', '501', 'F', 'drmeetasarkar@gmail.com', '$2y$10$lz8zcO0FXD1NGrF6RYk85uj360TE6GzTQ9ulLI7CFvTg7w0VeTqrG', '+91 98102 47381', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(112, 'JCGHS502F00261', 'SHRI.', 'ABADHESH PRASAD', '502', 'F', 'abdeshprsd@gmail.com', '$2y$10$WeES9CU.ouvfkcRdQwiFQe3nR6Q7kNQwAlr0yIEbbMH7vprVe.3G6', '+91 99701 78584', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(113, 'JCGHS503F00293', 'SHRI.', 'HAWA SINGH', '503', 'F', 'hawasinghp@gmail.com', '$2y$10$rkPC.GhFxhlEOPNrZLFPfuM3mdvw44Dcpnt04WOH4sCFnv7Rxyhue', '+91 98101 55698', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(114, 'JCGHS601F00346', 'SHRI.', 'DHIRAJ KUMAR SINGHAL AND ANITA SINGHAL', '601', 'F', 'singhal_dhiraj@yahoo.co.in', '$2y$10$DJ3fImjcLHISNJXBzu1.5eK/zrhPL/fXj11HqcjLbaltqMB4Gwmwe', '+91 93129 33731', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(115, 'JCGHS602F00260', 'SHRI.', 'H S VIRDHI', '602', 'F', '1958hsv@gmail.com', '$2y$10$ovcC.CGU627RLnkJcexXNO7VJ9EFBEDPB.ZLlGfp5AGNBYzkh70US', '+91 96509 88722', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(116, 'JCGHS603F00330', 'MRS.', 'NIRMALA AND RAJIV LAL', '603', 'F', 'rajiv.lal@esic.in', '$2y$10$tQZU6lneE7yo.Jwu9tBJo./83CkbjZnLYemUHK2L.ms4gHw4z2g7K', '+91 93126 31980', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(117, 'JCGHS701F00285', 'SHRI.', 'V V SINGH', '701', 'F', 'anuradha.lhmc@gmail.com', '$2y$10$KY3bIWvWCnx1QvBhJYEGVu20WHrev6CD7x3LLbpRqCGliHj5psm6C', '+91 98682 56696', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(118, 'JCGHS702F00227', 'DR.', 'SUBHASIS RAY CHOUDHARY', '702', 'F', 'roychouin@yahoo.co.in', '$2y$10$.XZu8CaWH9yOLmBmt9rbLe0yKB3tXY5M34HtJsD/dfiPbVow6XdZS', '+91 98103 86626', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(119, 'JCGHS801F00312', 'SHRI.', 'SUSHEEL KUMAR SOONEE & ALKA SOONEE', '801', 'F', 'sksoonee@hotmail.com', '$2y$10$iu06q6tSrAzaF7KdUBo.QOViRjMaBtGud5ejvPIDVxxkES4hbTvs.', '+91 98990 91115', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(120, 'JCGHS802F00248', 'SMT.', 'PROMILA MALIK', '802', 'F', 'Promila.malik09@gmail.com', '$2y$10$.zArHSA5yEMLqsxIiNFjuuR57dVRMO8OdEJIFWO3L7ekmtA0bFn2S', '+91 98104 57310', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
(121, 'JCGHS999Z00001', 'Mr.', 'Abhinav Jain', '999', 'Z', 'demo.member@gmail.com', '$2y$10$2E4RQBOasOQYTqZ4y6lTi.1/ozYb6UwwmKvVOT2S7/irasuwaMVKy', '+91 92145 44078', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-25 18:13:10', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
