-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 31, 2025 at 09:59 AM
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
-- Table structure for table `additional_attachments`
--

CREATE TABLE `additional_attachments` (
  `add_attachment_id` int(11) NOT NULL,
  `add_attachment_notice_id` int(11) NOT NULL,
  `add_attachment_agbm_id` int(11) NOT NULL,
  `add_attachment_title` varchar(255) NOT NULL,
  `add_attachment_material` varchar(255) NOT NULL,
  `add_attachment_status` varchar(255) NOT NULL COMMENT 'active, inactive, deleted',
  `add_attachment_added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `add_attachment_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agbms`
--

CREATE TABLE `agbms` (
  `agbm_id` int(11) NOT NULL,
  `agbm_number` varchar(255) NOT NULL,
  `agbm_title` text NOT NULL,
  `agbm_single_line` text NOT NULL,
  `agbm_excerpt` text NOT NULL,
  `agbm_video_link` text NOT NULL,
  `agbm_content` text NOT NULL,
  `agbm_material_title` varchar(255) NOT NULL,
  `agbm_material` varchar(255) NOT NULL,
  `agbm_status` varchar(255) NOT NULL COMMENT 'draft, published, deleted',
  `agbm_posted_by` varchar(255) NOT NULL,
  `agbm_posted_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `agbm_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agbms`
--

INSERT INTO `agbms` (`agbm_id`, `agbm_number`, `agbm_title`, `agbm_single_line`, `agbm_excerpt`, `agbm_video_link`, `agbm_content`, `agbm_material_title`, `agbm_material`, `agbm_status`, `agbm_posted_by`, `agbm_posted_on`, `agbm_updated_on`) VALUES
(1, 'JCGHS/AGM/2025', 'Annual General Body Meeting held on 14th December, 2025', 'Check all the details of the AGBM 2025', 'The Annual General Body Meeting (AGBM) of Jagaran CGHS Ltd. was held on 14th December 2025 at 11:00 AM in the Central Park of the Society complex.', 'https://drive.google.com/file/d/1gUTRIUQp4NN0BVuk1Fll4I3f2Hq1S7OZ/preview', '<ol>\r\n    <li>\r\n      <p>\r\n        The Annual General Body Meeting (AGBM) of Jagaran CGHS Ltd. was held on\r\n        14<sup>th</sup> December 2025 at 11:00 AM in the Central Park of the Society complex.\r\n      </p>\r\n    </li>\r\n\r\n    <li>\r\n      <p>\r\n        The Honorable President welcomed the members of Jagaran CGHS Ltd.\r\n        Notes on agenda items of AGBM were distributed prior to the commencement\r\n        of the meeting.\r\n      </p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Confirmation of Minutes of Last AGBM</h3>\r\n      <p>\r\n        The Secretary informed that the Minutes of the last AGBM held on\r\n        8<sup>th</sup> December 2024 were circulated to all members on\r\n        30<sup>th</sup> December 2024 by email and no comments were received.\r\n      </p>\r\n      <p>\r\n        The Minutes of the AGBM held on 8<sup>th</sup> December 2024 were confirmed.\r\n      </p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Audited Accounts & Balance Sheet</h3>\r\n      <p>\r\n        The Balance Sheet and Accounts for the financial year 2024-25 were audited\r\n        by the CA empanelled by the RCS and submitted within the prescribed time.\r\n        Copies were emailed to all honorable members.\r\n      </p>\r\n      <p>The General Body adopted and confirmed the same.</p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Ratification of New Members</h3>\r\n\r\n      <table border=\"1\" cellpadding=\"8\" cellspacing=\"0\">\r\n        <thead>\r\n          <tr>\r\n            <th>Sr. No.</th>\r\n            <th>Flat No.</th>\r\n            <th>Membership No.</th>\r\n            <th>Name</th>\r\n            <th>Membership Transferred From</th>\r\n          </tr>\r\n        </thead>\r\n        <tbody>\r\n          <tr>\r\n            <td>1</td>\r\n            <td>B-102</td>\r\n            <td>344</td>\r\n            <td>Smt. Laxmi Jaiswal & Vikas Jaiswal</td>\r\n            <td>Mr. Rajinder Kumar</td>\r\n          </tr>\r\n          <tr>\r\n            <td>2</td>\r\n            <td>C-103</td>\r\n            <td>345</td>\r\n            <td>Mr. Abhishek Verma</td>\r\n            <td>Dr. Prem Nath Dogra</td>\r\n          </tr>\r\n          <tr>\r\n            <td>3</td>\r\n            <td>F-601</td>\r\n            <td>346</td>\r\n            <td>Mr. Dhiraj Kumar Singhal & Mrs. Anita Singhal</td>\r\n            <td>Sh. Praveen Kumar Yadhuvanshi</td>\r\n          </tr>\r\n          <tr>\r\n            <td>4</td>\r\n            <td>C-802</td>\r\n            <td>347</td>\r\n            <td>Smt. Sushma Rastogi</td>\r\n            <td>Mrs. Rajni Ahuja</td>\r\n          </tr>\r\n        </tbody>\r\n      </table>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Recovery of Outstanding Dues</h3>\r\n      <p>\r\n        The General Body was informed that the Management Committee continues to\r\n        pursue defaulting members for clearance of outstanding dues. Members were\r\n        requested to clear their dues without delay.\r\n      </p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Strengthening of Building Columns</h3>\r\n      <p>\r\n        The strengthening of columns as per revised BIS codes was discussed.\r\n        Work for 111 columns has been completed at a cost of Rs. 44,60,000.\r\n        A total of 150 columns have been strengthened so far.\r\n      </p>\r\n      <p>\r\n        The General Body approved raising funds in three monthly installments of\r\n        Rs. 4,200 per member.\r\n      </p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Installation / Replacement of Intercom & CCTV System</h3>\r\n      <p>\r\n        Six new CCTV cameras were installed. An amount of Rs. 74,576 was paid to\r\n        M/s Tanay Infotech under AMC.\r\n      </p>\r\n      <p>No additional demand was raised.</p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Maintenance / Repair of Exterior Building Areas</h3>\r\n      <p>\r\n        Repair of exterior building surfaces was undertaken with funds of\r\n        Rs. 18 lakhs raised from members. Work in D-Block is complete.\r\n      </p>\r\n      <p>\r\n        The General Body approved continuation of maintenance work.\r\n      </p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Installation & Commissioning of 60 KW Rooftop Solar Power Plant</h3>\r\n      <p>\r\n        The Society has saved approximately Rs. 13 lakhs in electricity bills\r\n        and received Rs. 11 lakhs as capital subsidy.\r\n      </p>\r\n      <p>\r\n        The General Body approved installation of additional similar capacity\r\n        solar power plants.\r\n      </p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Hiring of Security Agency</h3>\r\n      <p>\r\n        M/s Truth Solutions Pvt. Ltd. was appointed as the security agency at a\r\n        monthly cost of Rs. 1,32,532.\r\n      </p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Upgradation of Boundary Wall</h3>\r\n      <p>\r\n        Boundary wall was upgraded for safety at an expenditure of Rs. 1.6 lakhs.\r\n      </p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Appointment of Fire-Fighting System AMC Vendor</h3>\r\n      <p>\r\n        AMC awarded to M/s Agni Fire Safety for Rs. 31,860 per annum.\r\n      </p>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>Parking Regulations</h3>\r\n      <ul>\r\n        <li>Open parking on first-come-first basis</li>\r\n        <li>Parking charges for second car increased to Rs. 1500 per month</li>\r\n        <li>Cars without stickers not allowed entry</li>\r\n      </ul>\r\n    </li>\r\n\r\n    <li>\r\n      <h3>EV Charging</h3>\r\n      <p>\r\n        EV charging facility was discussed. Members may charge EVs using their\r\n        own electricity meters.\r\n      </p>\r\n    </li>\r\n  </ol>\r\n\r\n  <p><strong>The meeting concluded with a vote of thanks by the Secretary.</strong></p>', 'Download Minutes of the Meeting', 'MOM%20AGBM%202025%20PDF.pdf', 'published', 'JCGHSOFF00001', '2025-12-21 08:43:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `announcement_content` text NOT NULL,
  `announcement_status` varchar(255) NOT NULL DEFAULT 'active' COMMENT 'active, inactive, deleted',
  `announcement_added_by` varchar(255) NOT NULL,
  `announcement_added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `announcement_expiry_on` timestamp NULL DEFAULT NULL,
  `announcement_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `announcement_content`, `announcement_status`, `announcement_added_by`, `announcement_added_on`, `announcement_expiry_on`, `announcement_updated_on`) VALUES
(1, 'Marking of Parking areas in front of B&C Block Ongoing.', 'active', 'JCGHSOFF00001', '2025-12-26 11:36:26', '2025-12-31 11:36:42', NULL),
(2, 'Minutes of the AGBM held on 14th December, 2025 issued.', 'active', 'JCGHSOFF00001', '2025-12-26 11:36:26', '2025-12-30 18:30:00', NULL),
(3, 'The website is still in development; some features might not work, and it may contain demo content.', 'active', 'JCGHSOFF00001', '2025-12-26 14:15:00', '2025-12-31 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `bill_for_member` varchar(255) NOT NULL,
  `bill_file` varchar(255) NOT NULL,
  `bill_for_month` varchar(255) NOT NULL,
  `bill_due_on` date NOT NULL,
  `bill_status` varchar(255) NOT NULL DEFAULT 'pending' COMMENT 'pending, paid, cancelled, deleted',
  `bill_added_by` varchar(255) NOT NULL,
  `bill_added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `bill_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_queries`
--

CREATE TABLE `contact_queries` (
  `query_id` int(11) NOT NULL,
  `query_unique_number` varchar(10) NOT NULL,
  `query_fullname` varchar(255) NOT NULL,
  `query_flatnumber` varchar(10) NOT NULL,
  `query_email` varchar(255) NOT NULL,
  `query_phone_number` varchar(10) NOT NULL,
  `query_subject` varchar(255) NOT NULL,
  `query_message` text NOT NULL,
  `query_status` varchar(255) NOT NULL DEFAULT 'open' COMMENT 'open, pending, closed, deleted',
  `query_raised_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `query_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `email_log_id` int(11) NOT NULL,
  `email_sent_to` varchar(255) NOT NULL,
  `email_purpose` varchar(255) NOT NULL,
  `email_status` varchar(255) NOT NULL COMMENT 'pending, sent, notsent, failed, deleted',
  `email_logged_by` varchar(255) NOT NULL,
  `email_logged_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `email_sent_on` timestamp NULL DEFAULT NULL,
  `email_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `email_template_id` int(11) NOT NULL,
  `email_template_purpose` varchar(255) NOT NULL COMMENT 'initial_password_send, new_announcement',
  `email_template_file` varchar(255) NOT NULL,
  `email_template_status` varchar(255) NOT NULL DEFAULT 'active' COMMENT 'active, inactive, deleted',
  `email_template_created_by` varchar(255) NOT NULL,
  `email_template_created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `email_template_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`email_template_id`, `email_template_purpose`, `email_template_file`, `email_template_status`, `email_template_created_by`, `email_template_created_on`, `email_template_updated_on`) VALUES
(1, 'initial_password_send', 'initial_password_send.php', 'active', 'JCGHSOFF00001', '2025-12-26 17:16:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hero_section`
--

CREATE TABLE `hero_section` (
  `hero_content_id` int(11) NOT NULL,
  `hero_content_key` varchar(100) NOT NULL,
  `hero_content_value` text NOT NULL,
  `hero_content_description` text NOT NULL,
  `hero_content_updated_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_section`
--

INSERT INTO `hero_section` (`hero_content_id`, `hero_content_key`, `hero_content_value`, `hero_content_description`, `hero_content_updated_on`) VALUES
(1, 'badge_1', 'Government Registered Society', 'Hero Section Badge 1', '2025-12-18 19:28:05'),
(2, 'badge_2', 'Transparent Governance', 'Hero Section Badge 2', '2025-12-18 19:28:05'),
(3, 'main_heading', 'Welcome to {site_fullname}', 'Hero Section Main Heading', '2025-12-18 19:49:30'),
(4, 'hero_paragraph', 'Access official notices, minutes of the meetings, and citizen-centric services related to your housing society, all in one secure and transparent portal.', 'Hero Section Paragraph', '2025-12-18 19:49:30'),
(5, 'primary_button_text', 'View Latest Notices', 'Text on the Primary Button of the hero section', '2025-12-18 19:49:30'),
(6, 'primary_button_link', '#', 'Link for the Primary Button in the Hero Section', '2025-12-18 19:49:30'),
(7, 'sub_paragraph', 'For any urgent matters regarding safety, utilities or emergency services, please contact the society office or nearest ward office immediately.', 'Information Sub Paragraph for hero section that appears after the Buttons', '2025-12-18 19:49:30'),
(8, 'background_image', 'https://jagarancghs.in/assets/images/hero-background.jpeg', 'Link to the Background Image for the Hero Section', '2025-12-18 19:51:32'),
(9, 'secondary_button_text', 'Download Forms & Applications', 'Text on the Secondary Button of the hero section', '2025-12-18 19:49:30'),
(10, 'secondary_button_link', '#', 'Link for the Secondary Button in the Hero Section', '2025-12-18 19:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `managing_committee`
--

CREATE TABLE `managing_committee` (
  `committee_member_id` int(11) NOT NULL,
  `committee_member_salutation` varchar(255) NOT NULL,
  `committee_member_fullname` varchar(255) NOT NULL,
  `committee_member_flat` varchar(255) DEFAULT NULL,
  `committee_member_phone_number` varchar(255) DEFAULT NULL,
  `committee_member_email_address` varchar(255) DEFAULT NULL,
  `committee_member_status` varchar(255) NOT NULL DEFAULT 'active' COMMENT 'active, inactive, deleted',
  `committee_member_role` varchar(255) NOT NULL DEFAULT 'Member',
  `committee_member_term` varchar(255) DEFAULT NULL,
  `committee_member_image` varchar(255) DEFAULT NULL,
  `committee_member_added_by` varchar(255) NOT NULL,
  `committee_member_added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `committee_member_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `managing_committee`
--

INSERT INTO `managing_committee` (`committee_member_id`, `committee_member_salutation`, `committee_member_fullname`, `committee_member_flat`, `committee_member_phone_number`, `committee_member_email_address`, `committee_member_status`, `committee_member_role`, `committee_member_term`, `committee_member_image`, `committee_member_added_by`, `committee_member_added_on`, `committee_member_updated_on`) VALUES
(1, 'Shri', 'Manoj Sikdar', 'E-102', '+91 98184 24368', NULL, 'active', 'President', '2023 - 2026', NULL, 'JCGHSOFF00001', '2025-12-22 11:19:15', NULL),
(2, 'Shri', 'Ravindra Kumar Verma', 'A-401', '+91 98681 67199', NULL, 'active', 'Vice President', '2023 - 2026', NULL, 'JCGHSOFF00001', '2025-12-22 11:24:01', NULL),
(3, 'Shri', 'Brahma Prakash', 'E-801', '+91 98681 54420', NULL, 'active', 'Joint Secretary', '2023 - 2026', NULL, 'JCGHSOFF00001', '2025-12-22 11:24:01', NULL),
(4, 'Shri', 'P K Choudhary', 'A-303', '+91 81465 91484', NULL, 'active', 'Treasurer', '2023 - 2026', NULL, 'JCGHSOFF00001', '2025-12-22 11:24:01', NULL),
(5, 'Shri', 'Ravinesh Kumar', 'E-301', '+91 93117 85107', NULL, 'active', 'Member', '2023 - 2026', NULL, 'JCGHSOFF00001', '2025-12-22 11:24:01', NULL),
(6, 'Shri', 'Micheal Rodrick', 'C-602', '+91 98110 92485', NULL, 'active', 'Member', '2023 - 2026', NULL, 'JCGHSOFF00001', '2025-12-22 11:24:01', NULL),
(7, 'Shri', 'Abadhesh Prasad', 'F-502', '+91 99707 78584', NULL, 'active', 'Member', '2023 - 2026', NULL, 'JCGHSOFF00001', '2025-12-22 11:24:01', NULL),
(8, 'Smt.', 'Gargi Goldar', 'B-401', '+91 98115 38829', NULL, 'active', 'Secretary', '2023 - 2026', NULL, 'JCGHSOFF00001', '2025-12-22 11:24:01', NULL),
(9, 'Smt.', 'Promila Malik', 'F-802', '+91 98104 57310', NULL, 'active', 'Member', '2023 - 2026', NULL, 'JCGHSOFF00001', '2025-12-22 11:24:01', NULL);

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
(47, 'JCGHS303C00317', 'SHRI.', 'BHARAT BHUSHAN LOHIA & GAURAV LOHIA', '303', 'C', 'glohia@gmail.com', '$2y$10$c092FfelucL4lAPXno4PW.LCAhHLYYgn.pclXIqPjHcVNbayewAmy', '+91 98100 96705', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:51:30', NULL),
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
(108, 'JCGHS401F00067', 'SHRI.', 'A. K. TALUKDAR', '401', 'F', 'amit.talukdar@gmail.com ', '$2y$10$XDVx2pyS0eCKQRsLmWhEL.pdqLqxIeuFvHvIsz1/PRCT0bU8f7R4q', '+91 98111 84687', NULL, 'owner', '', 'active', 'JCGHSOFF00001', '2025-12-24 10:53:09', NULL),
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

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `notice_id` int(11) NOT NULL,
  `notice_number` varchar(255) NOT NULL,
  `notice_title` text NOT NULL,
  `notice_single_line` text NOT NULL,
  `notice_category` int(11) NOT NULL,
  `notice_badge` varchar(255) DEFAULT NULL,
  `notice_excerpt` text NOT NULL,
  `notice_content` text NOT NULL,
  `notice_material_title` varchar(255) NOT NULL,
  `notice_material` varchar(255) DEFAULT NULL,
  `notice_status` varchar(255) NOT NULL DEFAULT 'draft' COMMENT 'draft, published, deleted',
  `notice_posted_by` varchar(255) NOT NULL,
  `notice_posted_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `notice_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`notice_id`, `notice_number`, `notice_title`, `notice_single_line`, `notice_category`, `notice_badge`, `notice_excerpt`, `notice_content`, `notice_material_title`, `notice_material`, `notice_status`, `notice_posted_by`, `notice_posted_on`, `notice_updated_on`) VALUES
(1, 'JCGHS/2025/NOTICE/JD/57', 'Marking of the Parking Area in the Complex starting from Monday', 'Marking of Parking areas in front of B&C Block Ongoing', 2, '', 'It is proposed to mark the parking area in the complex starting from Monday. It will begin with the area in front of B&C Blocks.', '<p>Dear Members/Residents,</p>\r\n<p>It is proposed to mark the parking area in the complex starting from Monday. It will begin with the area in front of B&C Blocks.</p>\r\n<p>Members/Residents are requested not to park any vehicle in front of B&C blocks so as to keep the area vacant to enable marking.</p>\r\n<p>Cooperation of members is solicited.</p>\r\n<p>Manager,<br>Jagaran CGHS</p>', 'Download Notice', 'JCGHS-2025-NOTICE-JD-57.pdf', 'published', 'JCGHSOFF00001', '2025-12-07 08:32:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notice_categories`
--

CREATE TABLE `notice_categories` (
  `notice_category_id` int(11) NOT NULL,
  `notice_parent_category_id` int(11) DEFAULT NULL,
  `notice_category_name` varchar(255) NOT NULL,
  `notice_category_slug` varchar(255) NOT NULL,
  `notice_category_status` varchar(255) NOT NULL DEFAULT 'active' COMMENT 'active, inactive, deleted',
  `notice_category_added_by` varchar(255) NOT NULL,
  `notice_category_added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `notice_category_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notice_categories`
--

INSERT INTO `notice_categories` (`notice_category_id`, `notice_parent_category_id`, `notice_category_name`, `notice_category_slug`, `notice_category_status`, `notice_category_added_by`, `notice_category_added_on`, `notice_category_updated_on`) VALUES
(1, NULL, 'Notices', 'notices', 'active', 'JCGHSOFF00001', '2025-12-23 08:58:54', NULL),
(2, 1, 'Advisory', 'advisory', 'active', 'JCGHSOFF00001', '2025-12-23 09:00:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `office_details`
--

CREATE TABLE `office_details` (
  `office_detail_id` int(11) NOT NULL,
  `office_detail_key` varchar(100) NOT NULL,
  `office_detail_value` text NOT NULL,
  `office_detail_description` text NOT NULL,
  `office_detail_updated_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office_details`
--

INSERT INTO `office_details` (`office_detail_id`, `office_detail_key`, `office_detail_value`, `office_detail_description`, `office_detail_updated_on`) VALUES
(1, 'police_number', '100', 'Quick Dial Number for Police Department', '2025-12-18 20:20:48'),
(2, 'fire_number', '101', 'Quick Dial Number for Fire Fighting Department', '2025-12-18 20:20:48'),
(3, 'ambulance_number_1', '102', 'Quick Dial Number for Women/Child Reserved Ambulance', '2025-12-18 20:20:48'),
(4, 'ambulance_number_2', '108', 'Quick Dial Number for General Ambulance', '2025-12-18 20:20:48'),
(5, 'society_security_number', '9999', 'Quick Dial Number for Society Security Office', '2025-12-18 20:20:48'),
(6, 'office_complete_address', 'Jagaran Co-operative Group Housing Society Ltd., Plot No. 17, Sector 22, Dwarka, New Delhi, Delhi, 110077', 'Complete Address of the Office', '2025-12-22 10:18:27'),
(7, 'office_phone_number', '+91 93556 66416', 'Office Contact Number', '2025-12-22 10:18:27'),
(8, 'office_email_address', 'jagarancghsltd1326@gmail.com', 'Office Email Address', '2025-12-22 10:18:27'),
(9, 'office_monday_open_hours', '', 'Office Opening Time on Monday', '2025-12-22 10:18:27'),
(10, 'office_monday_close_hours', '', 'Office Closing Time on Monday', '2025-12-22 10:18:27'),
(11, 'office_tuesday_open_hours', '09:30 AM', 'Office Opening Time on Tuesday', '2025-12-22 10:18:27'),
(12, 'office_tuesday_close_hours', '05:30 PM', 'Office Closing Time on Tuesday', '2025-12-22 10:18:27'),
(13, 'office_wednesday_open_hours', '09:30 AM', 'Office Opening Time on Wednesday', '2025-12-22 10:18:27'),
(14, 'office_wednesday_close_hours', '05:30 PM', 'Office Closing Time on Wednesday', '2025-12-22 10:18:27'),
(15, 'office_thursday_open_hours', '09:30 AM', 'Office Opening Time on Thursday', '2025-12-22 10:18:27'),
(16, 'office_thursday_close_hours', '05:30 PM', 'Office Closing Time on Thursday', '2025-12-22 10:18:27'),
(17, 'office_friday_open_hours', '09:30 AM', 'Office Opening Time on Friday', '2025-12-22 10:18:27'),
(18, 'office_friday_close_hours', '05:30 PM', 'Office Closing Time on Friday', '2025-12-22 10:18:27'),
(19, 'office_saturday_open_hours', '09:30 AM', 'Office Opening Time on Saturday', '2025-12-22 10:18:27'),
(20, 'office_saturday_close_hours', '05:30 PM', 'Office Closing Time on Saturday', '2025-12-22 10:18:27'),
(21, 'office_sunday_open_hours', '09:30 AM', 'Office Opening Time on Sunday', '2025-12-22 10:18:27'),
(22, 'office_sunday_close_hours', '05:30 PM', 'Office Closing Time on Sunday', '2025-12-22 10:18:27'),
(23, 'map_latitude', '28.556918541799913', 'Latitude of the Actual Location on the Map', '2025-12-22 10:58:30'),
(24, 'map_longitude', '77.05666972812207', 'Longitude of the Actual Location on the Map', '2025-12-22 10:58:30'),
(25, 'map_iframe', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d200.20416539171225!2d77.0565751802573!3d28.55689380486212!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d1bab52edeabf%3A0x88f7f355f9689b51!2sJagaran%20Apartments!5e1!3m2!1sen!2sin!4v1766401341817!5m2!1sen!2sin\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe><iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d200.20416539171225!2d77.0565751802573!3d28.55689380486212!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d1bab52edeabf%3A0x88f7f355f9689b51!2sJagaran%20Apartments!5e1!3m2!1sen!2sin!4v1766401341817!5m2!1sen!2sin\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'Exact iframe of the location on Google Maps', '2025-12-22 11:03:16'),
(26, 'current_term', '2023 - 2026', 'Current Term of the Managing Committee / Committee Members', '2025-12-22 12:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `office_members`
--

CREATE TABLE `office_members` (
  `office_member_id` int(11) NOT NULL,
  `office_member_unique_id` varchar(255) NOT NULL,
  `office_member_salutation` varchar(255) NOT NULL,
  `office_member_fullname` text NOT NULL,
  `office_member_email` varchar(255) NOT NULL,
  `office_member_password` text NOT NULL,
  `office_member_phone_number` varchar(15) NOT NULL,
  `office_member_image` varchar(255) NOT NULL,
  `office_member_role` varchar(255) NOT NULL DEFAULT 'admin',
  `office_member_vkey` text NOT NULL,
  `office_member_status` varchar(255) NOT NULL DEFAULT 'active' COMMENT 'active, inactive, deleted',
  `office_member_added_by` varchar(255) DEFAULT NULL,
  `office_member_added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `office_member_updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office_members`
--

INSERT INTO `office_members` (`office_member_id`, `office_member_unique_id`, `office_member_salutation`, `office_member_fullname`, `office_member_email`, `office_member_password`, `office_member_phone_number`, `office_member_image`, `office_member_role`, `office_member_vkey`, `office_member_status`, `office_member_added_by`, `office_member_added_on`, `office_member_updated_on`) VALUES
(1, 'JCGHSOFF00001', 'MR.', 'RAVI NAGAR', 'jagarancghsltd1326@gmail.com', '$2y$10$yLflji5bP4Wrubv.nIbc3Oj.NVXfB0FUFa9uwYH3fsuJBfeEVCVPS', '+91 70116 80504', '', 'admin', '', 'active', 'JCGHSOFF00001', '2025-12-25 11:02:42', NULL),
(2, 'JCGHSOFF00002', 'MR.', 'ABHINAV JAIN', 'demo.office@gmail.com', '$2y$10$wHyjVE1wj6K9npmwS0K4iePzrlaX1Gr9ybDPyfpeCbuw.RGJyzv8O', '+91 92145 44078', '', 'admin', '', 'active', NULL, '2025-12-31 09:59:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_options`
--

CREATE TABLE `site_options` (
  `option_id` int(11) NOT NULL,
  `option_key` varchar(100) NOT NULL,
  `option_value` text NOT NULL,
  `option_description` text DEFAULT NULL,
  `option_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_options`
--

INSERT INTO `site_options` (`option_id`, `option_key`, `option_value`, `option_description`, `option_updated_at`) VALUES
(1, 'site_title', 'Jagaran CGHS', 'The name of the website', '2025-12-18 18:23:27'),
(2, 'site_url', 'https://jagarancghs.in/', 'Website URL', '2025-12-26 14:12:49'),
(3, 'admin_email', 'info@jagarancghs.in', 'Administrator email address', '2025-12-18 18:24:02'),
(4, 'timezone', 'Asia/Kolkata', 'Default timezone', '2025-10-10 16:36:48'),
(5, 'maintenance_mode', 'off', 'On / Off maintenance mode', '2025-12-22 13:48:57'),
(6, 'logo', 'logo.png', 'Main Logo', '2025-12-20 05:41:15'),
(7, 'light_logo', 'gateways-logo-light.png', 'Light Version Logo', '2025-10-09 16:05:24'),
(8, 'logo_icon', 'gateways-logo-icon.png', 'Logo Icon', '2025-10-09 16:05:32'),
(9, 'android_chrome_192x192', 'android-chrome-192x192.png', 'Favicon Android 192 x 192 Icon', '2025-10-09 16:05:43'),
(10, 'android_chrome_512x512', 'android-chrome-512x512.png', 'Favicon Android 512 x 512 Icon', '2025-10-09 16:05:49'),
(11, 'apple_touch_icon', 'apple-touch-icon.png', 'Favicon Apple Touch Icon', '2025-10-09 16:05:53'),
(12, 'favicon', 'favicon.ico', 'Favicon', '2025-10-09 16:06:00'),
(13, 'favicon_16x16', 'favicon-16x16.png', 'Favicon 16 x 16', '2025-10-09 16:06:06'),
(14, 'favicon_32x32', 'favicon-32x32.png', 'Favicon 32 x 32', '2025-10-09 16:06:11'),
(15, 'footer_text', '&copy; {year} {site_fullname} - All Rights Reserved.', 'Footer copyright text', '2025-12-25 14:12:12'),
(16, 'footer_right_text', 'Designed &amp; Developed by <a href=\"https://abhinavjain.site/\" class=\"footer-link\" target=\"_blank\" rel=\"noopener noreferrer\">Abhinav Jain</a>', 'Footer right text', '2025-12-18 19:23:28'),
(17, 'webmail_host', 'smtp.hostinger.com', 'SMTP Server of Webmail', '2025-10-13 08:44:12'),
(18, 'webmail_username', 'info@jagarancghs.in', 'Webmail Email Address', '2025-12-24 11:24:04'),
(19, 'webmail_auth', 'Jagaran@2025', 'Auth code for Webmail Email', '2025-12-24 11:24:10'),
(20, 'webmail_port', '465', 'Port Number for Webmail Server', '2025-10-13 08:16:10'),
(21, 'can_send_mail', 'on', 'On / Off Send Mail Authority', '2025-12-24 16:25:24'),
(22, 'site_fullname', 'Jagaran Co-operative Group Housing Society Ltd.', 'Fullname of the Society', '2025-12-23 06:10:42'),
(23, 'site_topheading', 'Registered Housing Co-operative Society', 'Top heading to be shown with Name and Logo in Header', '2025-12-22 13:48:16'),
(24, 'show_site_topheading', 'off', 'On / Off Top Heading Showing', '2025-12-23 06:12:48'),
(25, 'show_site_tagline', 'on', 'On / Off Tagline Showing', '2025-12-22 13:48:43'),
(26, 'site_tagline', 'Regd. No. 1326', 'Society Tagline to be shown with Name and Logo in Header', '2025-12-23 06:11:20'),
(27, 'dashboard_url', 'https://jagarancghs.in/admin/', 'Website Admin Dashboard URL', '2025-12-26 14:13:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_attachments`
--
ALTER TABLE `additional_attachments`
  ADD PRIMARY KEY (`add_attachment_id`);

--
-- Indexes for table `agbms`
--
ALTER TABLE `agbms`
  ADD PRIMARY KEY (`agbm_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `contact_queries`
--
ALTER TABLE `contact_queries`
  ADD PRIMARY KEY (`query_id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`email_log_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`email_template_id`);

--
-- Indexes for table `hero_section`
--
ALTER TABLE `hero_section`
  ADD PRIMARY KEY (`hero_content_id`);

--
-- Indexes for table `managing_committee`
--
ALTER TABLE `managing_committee`
  ADD PRIMARY KEY (`committee_member_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `notice_categories`
--
ALTER TABLE `notice_categories`
  ADD PRIMARY KEY (`notice_category_id`);

--
-- Indexes for table `office_details`
--
ALTER TABLE `office_details`
  ADD PRIMARY KEY (`office_detail_id`);

--
-- Indexes for table `office_members`
--
ALTER TABLE `office_members`
  ADD PRIMARY KEY (`office_member_id`);

--
-- Indexes for table `site_options`
--
ALTER TABLE `site_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_key` (`option_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_attachments`
--
ALTER TABLE `additional_attachments`
  MODIFY `add_attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agbms`
--
ALTER TABLE `agbms`
  MODIFY `agbm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_queries`
--
ALTER TABLE `contact_queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `email_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `email_template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hero_section`
--
ALTER TABLE `hero_section`
  MODIFY `hero_content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `managing_committee`
--
ALTER TABLE `managing_committee`
  MODIFY `committee_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notice_categories`
--
ALTER TABLE `notice_categories`
  MODIFY `notice_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `office_details`
--
ALTER TABLE `office_details`
  MODIFY `office_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `office_members`
--
ALTER TABLE `office_members`
  MODIFY `office_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_options`
--
ALTER TABLE `site_options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
