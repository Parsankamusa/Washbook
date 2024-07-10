-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 15, 2023 at 11:46 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `company` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `company`, `name`, `phone`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, 'Headquarters', '+254720000000', 'Nairobi, Kenya', '2020-12-08 10:54:25', '2023-04-15 09:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `branchservices`
--

CREATE TABLE `branchservices` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `message` text NOT NULL,
  `sendto` varchar(256) NOT NULL,
  `status` enum('Queued','Completed') NOT NULL DEFAULT 'Queued',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `fullname` varchar(256) DEFAULT NULL,
  `phonenumber` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `status` enum('Active','Expired','Inactive') NOT NULL DEFAULT 'Active',
  `city` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `timezone` varchar(256) DEFAULT 'Africa/Nairobi',
  `currency` varchar(32) DEFAULT 'KES',
  `logo` varchar(256) DEFAULT NULL,
  `sms_balance` float(11,2) NOT NULL DEFAULT 5.00,
  `thankyou_message` longtext DEFAULT NULL,
  `send_thankyou` enum('Enabled','Disabled') NOT NULL DEFAULT 'Enabled',
  `subscription_plan` enum('Free Trial','Premium Monthly','Premium Biannually','Premium Annually') NOT NULL DEFAULT 'Free Trial',
  `subscription_status` enum('Active','Cancelled','Expired') NOT NULL DEFAULT 'Active',
  `subscription_start` date DEFAULT NULL,
  `subscription_end` date DEFAULT NULL,
  `subscription_id` int(11) DEFAULT NULL,
  `subscription_planid` int(11) DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `email`, `phone`, `status`, `city`, `address`, `country`, `timezone`, `currency`, `logo`, `sms_balance`, `thankyou_message`, `send_thankyou`, `subscription_plan`, `subscription_status`, `subscription_start`, `subscription_end`, `subscription_id`, `subscription_planid`, `last_activity`, `created_at`) VALUES
(1, 'Dotted Craft Limited', 'hello@dottedcraft.com', '+254720000000', 'Active', 'Nairobi', 'Ongata Rongai', 'Kenya', 'Africa/Nairobi', 'KES', 'kdB9KZJ3iOJH0OTlqhiGuUjQED3TBJS4.png', 0.00, 'Hello {customer_name}, thank you for visiting {company_name}. We sincerely appreciate your business and hope you come back soon!', 'Disabled', 'Premium Biannually', 'Active', '2020-09-17', '2021-03-16', 7020, 7181, '2023-04-14 13:17:33', '2020-08-11 18:03:58');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `code` varchar(8) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AL', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'AS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua And Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia And Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'BN', 'Brunei Darussalam'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CA', 'Canada'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CG', 'Congo'),
(50, 'CD', 'Congo, The Democratic Republic O'),
(51, 'CK', 'Cook Islands'),
(52, 'CR', 'Costa Rica'),
(53, 'CI', 'Cote D\'ivoire'),
(54, 'HR', 'Croatia'),
(55, 'CU', 'Cuba'),
(56, 'CY', 'Cyprus'),
(57, 'CZ', 'Czech Republic'),
(58, 'DK', 'Denmark'),
(59, 'DJ', 'Djibouti'),
(60, 'DM', 'Dominica'),
(61, 'DO', 'Dominican Republic'),
(62, 'TP', 'East Timor'),
(63, 'EC', 'Ecuador'),
(64, 'EG', 'Egypt'),
(65, 'SV', 'El Salvador'),
(66, 'GQ', 'Equatorial Guinea'),
(67, 'ER', 'Eritrea'),
(68, 'EE', 'Estonia'),
(69, 'ET', 'Ethiopia'),
(70, 'FK', 'Falkland Islands (malvinas)'),
(71, 'FO', 'Faroe Islands'),
(72, 'FJ', 'Fiji'),
(73, 'FI', 'Finland'),
(74, 'FR', 'France'),
(75, 'GF', 'French Guiana'),
(76, 'PF', 'French Polynesia'),
(77, 'TF', 'French Southern Territories'),
(78, 'GA', 'Gabon'),
(79, 'GM', 'Gambia'),
(80, 'GE', 'Georgia'),
(81, 'DE', 'Germany'),
(82, 'GH', 'Ghana'),
(83, 'GI', 'Gibraltar'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard Island And Mcdonald Island'),
(95, 'VA', 'Holy See (vatican City State)'),
(96, 'HN', 'Honduras'),
(97, 'HK', 'Hong Kong'),
(98, 'HU', 'Hungary'),
(99, 'IS', 'Iceland'),
(100, 'IN', 'India'),
(101, 'ID', 'Indonesia'),
(102, 'IR', 'Iran, Islamic Republic Of'),
(103, 'IQ', 'Iraq'),
(104, 'IE', 'Ireland'),
(105, 'IL', 'Israel'),
(106, 'IT', 'Italy'),
(107, 'JM', 'Jamaica'),
(108, 'JP', 'Japan'),
(109, 'JO', 'Jordan'),
(110, 'KZ', 'Kazakstan'),
(111, 'KE', 'Kenya'),
(112, 'KI', 'Kiribati'),
(113, 'KP', 'Korea, Democratic People\'s Repub'),
(114, 'KR', 'Korea, Republic Of'),
(115, 'KV', 'Kosovo'),
(116, 'KW', 'Kuwait'),
(117, 'KG', 'Kyrgyzstan'),
(118, 'LA', 'Lao People\'s Democratic Republic'),
(119, 'LV', 'Latvia'),
(120, 'LB', 'Lebanon'),
(121, 'LS', 'Lesotho'),
(122, 'LR', 'Liberia'),
(123, 'LY', 'Libyan Arab Jamahiriya'),
(124, 'LI', 'Liechtenstein'),
(125, 'LT', 'Lithuania'),
(126, 'LU', 'Luxembourg'),
(127, 'MO', 'Macau'),
(128, 'MK', 'Macedonia, The Former Yugoslav R'),
(129, 'MG', 'Madagascar'),
(130, 'MW', 'Malawi'),
(131, 'MY', 'Malaysia'),
(132, 'MV', 'Maldives'),
(133, 'ML', 'Mali'),
(134, 'MT', 'Malta'),
(135, 'MH', 'Marshall Islands'),
(136, 'MQ', 'Martinique'),
(137, 'MR', 'Mauritania'),
(138, 'MU', 'Mauritius'),
(139, 'YT', 'Mayotte'),
(140, 'MX', 'Mexico'),
(141, 'FM', 'Micronesia, Federated States Of'),
(142, 'MD', 'Moldova, Republic Of'),
(143, 'MC', 'Monaco'),
(144, 'MN', 'Mongolia'),
(145, 'MS', 'Montserrat'),
(146, 'ME', 'Montenegro'),
(147, 'MA', 'Morocco'),
(148, 'MZ', 'Mozambique'),
(149, 'MM', 'Myanmar'),
(150, 'NA', 'Namibia'),
(151, 'NR', 'Nauru'),
(152, 'NP', 'Nepal'),
(153, 'NL', 'Netherlands'),
(154, 'AN', 'Netherlands Antilles'),
(155, 'NC', 'New Caledonia'),
(156, 'NZ', 'New Zealand'),
(157, 'NI', 'Nicaragua'),
(158, 'NE', 'Niger'),
(159, 'NG', 'Nigeria'),
(160, 'NU', 'Niue'),
(161, 'NF', 'Norfolk Island'),
(162, 'MP', 'Northern Mariana Islands'),
(163, 'NO', 'Norway'),
(164, 'OM', 'Oman'),
(165, 'PK', 'Pakistan'),
(166, 'PW', 'Palau'),
(167, 'PS', 'Palestinian Territory, Occupied'),
(168, 'PA', 'Panama'),
(169, 'PG', 'Papua New Guinea'),
(170, 'PY', 'Paraguay'),
(171, 'PE', 'Peru'),
(172, 'PH', 'Philippines'),
(173, 'PN', 'Pitcairn'),
(174, 'PL', 'Poland'),
(175, 'PT', 'Portugal'),
(176, 'PR', 'Puerto Rico'),
(177, 'QA', 'Qatar'),
(178, 'RE', 'Reunion'),
(179, 'RO', 'Romania'),
(180, 'RU', 'Russian Federation'),
(181, 'RW', 'Rwanda'),
(182, 'SH', 'Saint Helena'),
(183, 'KN', 'Saint Kitts And Nevis'),
(184, 'LC', 'Saint Lucia'),
(185, 'PM', 'Saint Pierre And Miquelon'),
(186, 'VC', 'Saint Vincent And The Grenadines'),
(187, 'WS', 'Samoa'),
(188, 'SM', 'San Marino'),
(189, 'ST', 'Sao Tome And Principe'),
(190, 'SA', 'Saudi Arabia'),
(191, 'SN', 'Senegal'),
(192, 'RS', 'Serbia'),
(193, 'SC', 'Seychelles'),
(194, 'SL', 'Sierra Leone'),
(195, 'SG', 'Singapore'),
(196, 'SK', 'Slovakia'),
(197, 'SI', 'Slovenia'),
(198, 'SB', 'Solomon Islands'),
(199, 'SO', 'Somalia'),
(200, 'ZA', 'South Africa'),
(201, 'GS', 'South Georgia And The South Sand'),
(202, 'ES', 'Spain'),
(203, 'LK', 'Sri Lanka'),
(204, 'SD', 'Sudan'),
(205, 'SR', 'Suriname'),
(206, 'SJ', 'Svalbard And Jan Mayen'),
(207, 'SZ', 'Swaziland'),
(208, 'SE', 'Sweden'),
(209, 'CH', 'Switzerland'),
(210, 'SY', 'Syrian Arab Republic'),
(211, 'TW', 'Taiwan, Province Of China'),
(212, 'TJ', 'Tajikistan'),
(213, 'TZ', 'Tanzania, United Republic Of'),
(214, 'TH', 'Thailand'),
(215, 'TG', 'Togo'),
(216, 'TK', 'Tokelau'),
(217, 'TO', 'Tonga'),
(218, 'TT', 'Trinidad And Tobago'),
(219, 'TN', 'Tunisia'),
(220, 'TR', 'Turkey'),
(221, 'TM', 'Turkmenistan'),
(222, 'TC', 'Turks And Caicos Islands'),
(223, 'TV', 'Tuvalu'),
(224, 'UG', 'Uganda'),
(225, 'UA', 'Ukraine'),
(226, 'AE', 'United Arab Emirates'),
(227, 'GB', 'United Kingdom'),
(228, 'US', 'United States'),
(229, 'UM', 'United States Minor Outlying Isl'),
(230, 'UY', 'Uruguay'),
(231, 'UZ', 'Uzbekistan'),
(232, 'VU', 'Vanuatu'),
(233, 'VE', 'Venezuela'),
(234, 'VN', 'Viet Nam'),
(235, 'VG', 'Virgin Islands, British'),
(236, 'VI', 'Virgin Islands, U.s.'),
(237, 'WF', 'Wallis And Futuna'),
(238, 'EH', 'Western Sahara'),
(239, 'YE', 'Yemen'),
(240, 'ZM', 'Zambia'),
(241, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(56) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`) VALUES
(1, 'United Arab Emirates Dirham', 'AED'),
(4, 'Armenia Dram', 'AMD'),
(5, 'Netherlands Antilles Guilder', 'ANG'),
(7, 'Argentina Peso', 'ARS'),
(8, 'Australia Dollar', 'AUD'),
(9, 'Aruba Guilder', 'AWG'),
(11, 'Bosnia and Herzegovina Convertible Marka', 'BAM'),
(13, 'Bangladesh Taka', 'BDT'),
(15, 'Bahrain Dinar', 'BHD'),
(17, 'Bermuda Dollar', 'BMD'),
(18, 'Brunei Darussalam Dollar', 'BND'),
(19, 'Bolivia Boliviano', 'BOB'),
(20, 'Brazil Real', 'BRL'),
(21, 'Bahamas Dollar', 'BSD'),
(24, 'Botswana Pula', 'BWP'),
(26, 'Belize Dollar', 'BZD'),
(27, 'Canada Dollar', 'CAD'),
(29, 'Switzerland Franc', 'CHF'),
(30, 'Chile Peso', 'CLP'),
(31, 'China Yuan Renminbi', 'CNY'),
(32, 'Colombia Peso', 'COP'),
(33, 'Costa Rica Colon', 'CRC'),
(34, 'Cuba Convertible Peso', 'CUC'),
(35, 'Cuba Peso', 'CUP'),
(37, 'Czech ReKoruna', 'CZK'),
(39, 'Denmark Krone', 'DKK'),
(40, 'Dominican RePeso', 'DOP'),
(42, 'Egypt Pound', 'EGP'),
(45, 'Euro Member Countries', 'EUR'),
(48, 'United Kingdom Pound', 'GBP'),
(52, 'Gibraltar Pound', 'GIP'),
(55, 'Guatemala Quetzal', 'GTQ'),
(57, 'Hong Kong Dollar', 'HKD'),
(58, 'Honduras Lempira', 'HNL'),
(59, 'Croatia Kuna', 'HRK'),
(61, 'Hungary Forint', 'HUF'),
(62, 'Indonesia Rupiah', 'IDR'),
(63, 'Israel Shekel', 'ILS'),
(65, 'India Rupee', 'INR'),
(67, 'Iran Rial', 'IRR'),
(68, 'Iceland Krona', 'ISK'),
(70, 'Jamaica Dollar', 'JMD'),
(71, 'Jordan Dinar', 'JOD'),
(72, 'Japan Yen', 'JPY'),
(73, 'Kenya Shilling', 'KES'),
(78, 'Korea (South) Won', 'KRW'),
(79, 'Kuwait Dinar', 'KWD'),
(80, 'Cayman Islands Dollar', 'KYD'),
(83, 'Lebanon Pound', 'LBP'),
(87, 'Lithuania Litas', 'LTL'),
(88, 'Latvia Lat', 'LVL'),
(93, 'Macedonia Denar', 'MKD'),
(98, 'Mauritius Rupee', 'MUR'),
(101, 'Mexico Peso', 'MXN'),
(102, 'Malaysia Ringgit', 'MYR'),
(107, 'Norway Krone', 'NOK'),
(108, 'Nepal Rupee', 'NPR'),
(109, 'New Zealand Dollar', 'NZD'),
(110, 'Oman Rial', 'OMR'),
(112, 'Peru Nuevo Sol', 'PEN'),
(114, 'Philippines Peso', 'PHP'),
(115, 'Pakistan Rupee', 'PKR'),
(116, 'Poland Zloty', 'PLN'),
(119, 'Romania New Leu', 'RON'),
(121, 'Russia Ruble', 'RUB'),
(123, 'Saudi Arabia Riyal', 'SAR'),
(127, 'Sweden Krona', 'SEK'),
(128, 'Singapore Dollar', 'SGD'),
(135, 'El Salvador Colon', 'SVC'),
(137, 'Swaziland Lilangeni', 'SZL'),
(138, 'Thailand Baht', 'THB'),
(142, 'Tonga Paanga', 'TOP'),
(143, 'Turkey Lira', 'TRY'),
(147, 'Tanzania Shilling', 'TZS'),
(148, 'Ukraine Hryvna', 'UAH'),
(150, 'United States Dollar', 'USD'),
(151, 'Uruguay Peso', 'UYU'),
(153, 'Venezuela Bolivar', 'VEF'),
(154, 'Viet Nam Dong', 'VND'),
(155, 'Vanuatu Vatu', 'VUV'),
(158, 'East Caribbean Dollar', 'XCD'),
(163, 'South Africa Rand', 'ZAR'),
(164, 'Zimbabwe Dollar', 'ZWD');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `phonenumber` varchar(256) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('Queued','Sent','Failed') NOT NULL DEFAULT 'Queued',
  `campaign` int(11) DEFAULT NULL,
  `cost` float(11,4) DEFAULT 0.0000,
  `messageParts` int(11) NOT NULL DEFAULT 1,
  `messageId` varchar(256) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `item` int(11) DEFAULT NULL,
  `type` enum('Client','Project','Team','Company','Branch') NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `reference` varchar(64) DEFAULT NULL,
  `total` decimal(11,2) NOT NULL DEFAULT 0.00,
  `commission` decimal(11,2) NOT NULL DEFAULT 0.00,
  `item` text NOT NULL,
  `paid` enum('Yes','No') NOT NULL DEFAULT 'No',
  `payment_method` varchar(256) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cost` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `company` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `cost` float(11,2) NOT NULL,
  `commission` float(11,2) NOT NULL,
  `status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `servicesales`
--

CREATE TABLE `servicesales` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `sale` int(11) DEFAULT NULL,
  `amount` decimal(11,2) NOT NULL,
  `commission` decimal(11,2) NOT NULL,
  `provided_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teampayments`
--

CREATE TABLE `teampayments` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `member` int(11) NOT NULL,
  `amount` float(11,2) NOT NULL,
  `note` text NOT NULL,
  `mode` enum('Cash','Bank','Mobile Payment','Online Payment','Other') NOT NULL,
  `deduct_balance` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `payment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` int(11) NOT NULL,
  `name` varchar(31) NOT NULL,
  `zone` varchar(272) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `name`, `zone`) VALUES
(1, '(UTC-11:00) Pacific/Pago_Pago', 'Pacific/Pago_Pago'),
(2, '(UTC-11:00) Pacific/Niue', 'Pacific/Niue'),
(3, '(UTC-11:00) Pacific/Midway', 'Pacific/Midway'),
(4, '(UTC-10:00) Pacific/Tahiti', 'Pacific/Tahiti'),
(5, '(UTC-10:00) America/Adak', 'America/Adak'),
(6, '(UTC-10:00) Pacific/Rarotonga', 'Pacific/Rarotonga'),
(7, '(UTC-10:00) Pacific/Honolulu', 'Pacific/Honolulu'),
(8, '(UTC-09:30) Pacific/Marquesas', 'Pacific/Marquesas'),
(9, '(UTC-09:00) Pacific/Gambier', 'Pacific/Gambier'),
(10, '(UTC-09:00) America/Sitka', 'America/Sitka'),
(11, '(UTC-09:00) America/Anchorage', 'America/Anchorage'),
(12, '(UTC-09:00) America/Yakutat', 'America/Yakutat'),
(13, '(UTC-09:00) America/Metlakatla', 'America/Metlakatla'),
(14, '(UTC-09:00) America/Juneau', 'America/Juneau'),
(15, '(UTC-09:00) America/Nome', 'America/Nome'),
(16, '(UTC-08:00) Pacific/Pitcairn', 'Pacific/Pitcairn'),
(17, '(UTC-08:00) America/Tijuana', 'America/Tijuana'),
(18, '(UTC-08:00) America/Vancouver', 'America/Vancouver'),
(19, '(UTC-08:00) America/Los_Angeles', 'America/Los_Angeles'),
(20, '(UTC-08:00) America/Whitehorse', 'America/Whitehorse'),
(21, '(UTC-08:00) America/Dawson', 'America/Dawson'),
(22, '(UTC-07:00) America/Cambridge_B', 'America/Cambridge_Bay'),
(23, '(UTC-07:00) America/Mazatlan', 'America/Mazatlan'),
(24, '(UTC-07:00) America/Boise', 'America/Boise'),
(25, '(UTC-07:00) America/Creston', 'America/Creston'),
(26, '(UTC-07:00) America/Yellowknife', 'America/Yellowknife'),
(27, '(UTC-07:00) America/Phoenix', 'America/Phoenix'),
(28, '(UTC-07:00) America/Chihuahua', 'America/Chihuahua'),
(29, '(UTC-07:00) America/Dawson_Cree', 'America/Dawson_Creek'),
(30, '(UTC-07:00) America/Inuvik', 'America/Inuvik'),
(31, '(UTC-07:00) America/Ojinaga', 'America/Ojinaga'),
(32, '(UTC-07:00) America/Denver', 'America/Denver'),
(33, '(UTC-07:00) America/Edmonton', 'America/Edmonton'),
(34, '(UTC-07:00) America/Hermosillo', 'America/Hermosillo'),
(35, '(UTC-07:00) America/Fort_Nelson', 'America/Fort_Nelson'),
(36, '(UTC-06:00) America/El_Salvador', 'America/El_Salvador'),
(37, '(UTC-06:00) America/Indiana/Tel', 'America/Indiana/Tell_City'),
(38, '(UTC-06:00) America/Costa_Rica', 'America/Costa_Rica'),
(39, '(UTC-06:00) America/Indiana/Kno', 'America/Indiana/Knox'),
(40, '(UTC-06:00) America/Bahia_Bande', 'America/Bahia_Banderas'),
(41, '(UTC-06:00) America/Guatemala', 'America/Guatemala'),
(42, '(UTC-06:00) America/Belize', 'America/Belize'),
(43, '(UTC-06:00) America/Managua', 'America/Managua'),
(44, '(UTC-06:00) America/Swift_Curre', 'America/Swift_Current'),
(45, '(UTC-06:00) America/Mexico_City', 'America/Mexico_City'),
(46, '(UTC-06:00) America/Resolute', 'America/Resolute'),
(47, '(UTC-06:00) America/Regina', 'America/Regina'),
(48, '(UTC-06:00) America/Rankin_Inle', 'America/Rankin_Inlet'),
(49, '(UTC-06:00) America/Rainy_River', 'America/Rainy_River'),
(50, '(UTC-06:00) America/North_Dakot', 'America/North_Dakota/New_Salem'),
(51, '(UTC-06:00) America/North_Dakot', 'America/North_Dakota/Center'),
(52, '(UTC-06:00) America/North_Dakot', 'America/North_Dakota/Beulah'),
(53, '(UTC-06:00) America/Tegucigalpa', 'America/Tegucigalpa'),
(54, '(UTC-06:00) America/Monterrey', 'America/Monterrey'),
(55, '(UTC-06:00) Pacific/Galapagos', 'Pacific/Galapagos'),
(56, '(UTC-06:00) America/Chicago', 'America/Chicago'),
(57, '(UTC-06:00) America/Merida', 'America/Merida'),
(58, '(UTC-06:00) America/Winnipeg', 'America/Winnipeg'),
(59, '(UTC-06:00) America/Menominee', 'America/Menominee'),
(60, '(UTC-06:00) America/Matamoros', 'America/Matamoros'),
(61, '(UTC-05:00) America/Iqaluit', 'America/Iqaluit'),
(62, '(UTC-05:00) America/Rio_Branco', 'America/Rio_Branco'),
(63, '(UTC-05:00) America/Lima', 'America/Lima'),
(64, '(UTC-05:00) America/Kentucky/Mo', 'America/Kentucky/Monticello'),
(65, '(UTC-05:00) America/Kentucky/Lo', 'America/Kentucky/Louisville'),
(66, '(UTC-05:00) America/Cayman', 'America/Cayman'),
(67, '(UTC-05:00) America/Pangnirtung', 'America/Pangnirtung'),
(68, '(UTC-05:00) America/Panama', 'America/Panama'),
(69, '(UTC-05:00) America/Jamaica', 'America/Jamaica'),
(70, '(UTC-05:00) America/Detroit', 'America/Detroit'),
(71, '(UTC-05:00) America/Indiana/Win', 'America/Indiana/Winamac'),
(72, '(UTC-05:00) America/Eirunepe', 'America/Eirunepe'),
(73, '(UTC-05:00) America/Indiana/Vin', 'America/Indiana/Vincennes'),
(74, '(UTC-05:00) America/New_York', 'America/New_York'),
(75, '(UTC-05:00) America/Grand_Turk', 'America/Grand_Turk'),
(76, '(UTC-05:00) America/Nassau', 'America/Nassau'),
(77, '(UTC-05:00) America/Guayaquil', 'America/Guayaquil'),
(78, '(UTC-05:00) America/Havana', 'America/Havana'),
(79, '(UTC-05:00) America/Indiana/Ind', 'America/Indiana/Indianapolis'),
(80, '(UTC-05:00) America/Indiana/Mar', 'America/Indiana/Marengo'),
(81, '(UTC-05:00) America/Indiana/Pet', 'America/Indiana/Petersburg'),
(82, '(UTC-05:00) America/Indiana/Vev', 'America/Indiana/Vevay'),
(83, '(UTC-05:00) America/Nipigon', 'America/Nipigon'),
(84, '(UTC-05:00) America/Port-au-Pri', 'America/Port-au-Prince'),
(85, '(UTC-05:00) America/Thunder_Bay', 'America/Thunder_Bay'),
(86, '(UTC-05:00) America/Cancun', 'America/Cancun'),
(87, '(UTC-05:00) America/Bogota', 'America/Bogota'),
(88, '(UTC-05:00) Pacific/Easter', 'Pacific/Easter'),
(89, '(UTC-05:00) America/Toronto', 'America/Toronto'),
(90, '(UTC-05:00) America/Atikokan', 'America/Atikokan'),
(91, '(UTC-04:00) America/Marigot', 'America/Marigot'),
(92, '(UTC-04:00) America/St_Barthele', 'America/St_Barthelemy'),
(93, '(UTC-04:00) America/St_Kitts', 'America/St_Kitts'),
(94, '(UTC-04:00) America/St_Lucia', 'America/St_Lucia'),
(95, '(UTC-04:00) America/La_Paz', 'America/La_Paz'),
(96, '(UTC-04:00) America/St_Thomas', 'America/St_Thomas'),
(97, '(UTC-04:00) America/St_Vincent', 'America/St_Vincent'),
(98, '(UTC-04:00) America/Lower_Princ', 'America/Lower_Princes'),
(99, '(UTC-04:00) America/Thule', 'America/Thule'),
(100, '(UTC-04:00) America/Manaus', 'America/Manaus'),
(101, '(UTC-04:00) America/Caracas', 'America/Caracas'),
(102, '(UTC-04:00) America/Martinique', 'America/Martinique'),
(103, '(UTC-04:00) America/Antigua', 'America/Antigua'),
(104, '(UTC-04:00) America/Tortola', 'America/Tortola'),
(105, '(UTC-04:00) America/Moncton', 'America/Moncton'),
(106, '(UTC-04:00) America/Montserrat', 'America/Montserrat'),
(107, '(UTC-04:00) Atlantic/Bermuda', 'Atlantic/Bermuda'),
(108, '(UTC-04:00) America/Santo_Domin', 'America/Santo_Domingo'),
(109, '(UTC-04:00) America/Port_of_Spa', 'America/Port_of_Spain'),
(110, '(UTC-04:00) America/Porto_Velho', 'America/Porto_Velho'),
(111, '(UTC-04:00) America/Puerto_Rico', 'America/Puerto_Rico'),
(112, '(UTC-04:00) America/Anguilla', 'America/Anguilla'),
(113, '(UTC-04:00) America/Kralendijk', 'America/Kralendijk'),
(114, '(UTC-04:00) America/Halifax', 'America/Halifax'),
(115, '(UTC-04:00) America/Curacao', 'America/Curacao'),
(116, '(UTC-04:00) America/Barbados', 'America/Barbados'),
(117, '(UTC-04:00) America/Glace_Bay', 'America/Glace_Bay'),
(118, '(UTC-04:00) America/Goose_Bay', 'America/Goose_Bay'),
(119, '(UTC-04:00) America/Grenada', 'America/Grenada'),
(120, '(UTC-04:00) America/Guadeloupe', 'America/Guadeloupe'),
(121, '(UTC-04:00) America/Dominica', 'America/Dominica'),
(122, '(UTC-04:00) America/Blanc-Sablo', 'America/Blanc-Sablon'),
(123, '(UTC-04:00) America/Aruba', 'America/Aruba'),
(124, '(UTC-04:00) America/Guyana', 'America/Guyana'),
(125, '(UTC-04:00) America/Boa_Vista', 'America/Boa_Vista'),
(126, '(UTC-03:30) America/St_Johns', 'America/St_Johns'),
(127, '(UTC-03:00) America/Paramaribo', 'America/Paramaribo'),
(128, '(UTC-03:00) Atlantic/Stanley', 'Atlantic/Stanley'),
(129, '(UTC-03:00) America/Cuiaba', 'America/Cuiaba'),
(130, '(UTC-03:00) America/Santiago', 'America/Santiago'),
(131, '(UTC-03:00) America/Belem', 'America/Belem'),
(132, '(UTC-03:00) America/Miquelon', 'America/Miquelon'),
(133, '(UTC-03:00) America/Campo_Grand', 'America/Campo_Grande'),
(134, '(UTC-03:00) America/Argentina/S', 'America/Argentina/Salta'),
(135, '(UTC-03:00) America/Punta_Arena', 'America/Punta_Arenas'),
(136, '(UTC-03:00) Antarctica/Palmer', 'Antarctica/Palmer'),
(137, '(UTC-03:00) America/Recife', 'America/Recife'),
(138, '(UTC-03:00) America/Bahia', 'America/Bahia'),
(139, '(UTC-03:00) America/Montevideo', 'America/Montevideo'),
(140, '(UTC-03:00) Antarctica/Rothera', 'Antarctica/Rothera'),
(141, '(UTC-03:00) America/Asuncion', 'America/Asuncion'),
(142, '(UTC-03:00) America/Argentina/S', 'America/Argentina/San_Juan'),
(143, '(UTC-03:00) America/Argentina/R', 'America/Argentina/Rio_Gallegos'),
(144, '(UTC-03:00) America/Argentina/M', 'America/Argentina/Mendoza'),
(145, '(UTC-03:00) America/Argentina/L', 'America/Argentina/La_Rioja'),
(146, '(UTC-03:00) America/Argentina/J', 'America/Argentina/Jujuy'),
(147, '(UTC-03:00) America/Argentina/C', 'America/Argentina/Cordoba'),
(148, '(UTC-03:00) America/Argentina/C', 'America/Argentina/Catamarca'),
(149, '(UTC-03:00) America/Argentina/B', 'America/Argentina/Buenos_Aires'),
(150, '(UTC-03:00) America/Araguaina', 'America/Araguaina'),
(151, '(UTC-03:00) America/Argentina/U', 'America/Argentina/Ushuaia'),
(152, '(UTC-03:00) America/Santarem', 'America/Santarem'),
(153, '(UTC-03:00) America/Cayenne', 'America/Cayenne'),
(154, '(UTC-03:00) America/Argentina/S', 'America/Argentina/San_Luis'),
(155, '(UTC-03:00) America/Fortaleza', 'America/Fortaleza'),
(156, '(UTC-03:00) America/Maceio', 'America/Maceio'),
(157, '(UTC-03:00) America/Godthab', 'America/Godthab'),
(158, '(UTC-03:00) America/Argentina/T', 'America/Argentina/Tucuman'),
(159, '(UTC-02:00) America/Noronha', 'America/Noronha'),
(160, '(UTC-02:00) America/Sao_Paulo', 'America/Sao_Paulo'),
(161, '(UTC-02:00) Atlantic/South_Geor', 'Atlantic/South_Georgia'),
(162, '(UTC-01:00) Atlantic/Azores', 'Atlantic/Azores'),
(163, '(UTC-01:00) Atlantic/Cape_Verde', 'Atlantic/Cape_Verde'),
(164, '(UTC-01:00) America/Scoresbysun', 'America/Scoresbysund'),
(165, '(UTC+00:00) Atlantic/St_Helena', 'Atlantic/St_Helena'),
(166, '(UTC+00:00) Africa/Accra', 'Africa/Accra'),
(167, '(UTC+00:00) Atlantic/Reykjavik', 'Atlantic/Reykjavik'),
(168, '(UTC+00:00) Antarctica/Troll', 'Antarctica/Troll'),
(169, '(UTC+00:00) Atlantic/Faroe', 'Atlantic/Faroe'),
(170, '(UTC+00:00) Europe/London', 'Europe/London'),
(171, '(UTC+00:00) Europe/Lisbon', 'Europe/Lisbon'),
(172, '(UTC+00:00) Atlantic/Canary', 'Atlantic/Canary'),
(173, '(UTC+00:00) Europe/Jersey', 'Europe/Jersey'),
(174, '(UTC+00:00) Europe/Isle_of_Man', 'Europe/Isle_of_Man'),
(175, '(UTC+00:00) Europe/Guernsey', 'Europe/Guernsey'),
(176, '(UTC+00:00) Atlantic/Madeira', 'Atlantic/Madeira'),
(177, '(UTC+00:00) Africa/Abidjan', 'Africa/Abidjan'),
(178, '(UTC+00:00) Europe/Dublin', 'Europe/Dublin'),
(179, '(UTC+00:00) Africa/Monrovia', 'Africa/Monrovia'),
(180, '(UTC+00:00) America/Danmarkshav', 'America/Danmarkshavn'),
(181, '(UTC+00:00) Africa/El_Aaiun', 'Africa/El_Aaiun'),
(182, '(UTC+00:00) Africa/Freetown', 'Africa/Freetown'),
(183, '(UTC+00:00) Africa/Dakar', 'Africa/Dakar'),
(184, '(UTC+00:00) Africa/Conakry', 'Africa/Conakry'),
(185, '(UTC+00:00) Africa/Bissau', 'Africa/Bissau'),
(186, '(UTC+00:00) Africa/Lome', 'Africa/Lome'),
(187, '(UTC+00:00) Africa/Banjul', 'Africa/Banjul'),
(188, '(UTC+00:00) Africa/Bamako', 'Africa/Bamako'),
(189, '(UTC+00:00) Africa/Casablanca', 'Africa/Casablanca'),
(190, '(UTC+00:00) Africa/Nouakchott', 'Africa/Nouakchott'),
(191, '(UTC+00:00) Africa/Ouagadougou', 'Africa/Ouagadougou'),
(192, '(UTC+00:00) Africa/Sao_Tome', 'Africa/Sao_Tome'),
(193, '(UTC+01:00) Europe/Rome', 'Europe/Rome'),
(194, '(UTC+01:00) Europe/Budapest', 'Europe/Budapest'),
(195, '(UTC+01:00) Europe/San_Marino', 'Europe/San_Marino'),
(196, '(UTC+01:00) Europe/Sarajevo', 'Europe/Sarajevo'),
(197, '(UTC+01:00) Europe/Skopje', 'Europe/Skopje'),
(198, '(UTC+01:00) Europe/Stockholm', 'Europe/Stockholm'),
(199, '(UTC+01:00) Europe/Belgrade', 'Europe/Belgrade'),
(200, '(UTC+01:00) Europe/Podgorica', 'Europe/Podgorica'),
(201, '(UTC+01:00) Europe/Tirane', 'Europe/Tirane'),
(202, '(UTC+01:00) Europe/Vaduz', 'Europe/Vaduz'),
(203, '(UTC+01:00) Europe/Vatican', 'Europe/Vatican'),
(204, '(UTC+01:00) Europe/Busingen', 'Europe/Busingen'),
(205, '(UTC+01:00) Europe/Vienna', 'Europe/Vienna'),
(206, '(UTC+01:00) Europe/Copenhagen', 'Europe/Copenhagen'),
(207, '(UTC+01:00) Europe/Warsaw', 'Europe/Warsaw'),
(208, '(UTC+01:00) Europe/Prague', 'Europe/Prague'),
(209, '(UTC+01:00) Europe/Monaco', 'Europe/Monaco'),
(210, '(UTC+01:00) Europe/Paris', 'Europe/Paris'),
(211, '(UTC+01:00) Europe/Bratislava', 'Europe/Bratislava'),
(212, '(UTC+01:00) Europe/Amsterdam', 'Europe/Amsterdam'),
(213, '(UTC+01:00) Africa/Algiers', 'Africa/Algiers'),
(214, '(UTC+01:00) Europe/Berlin', 'Europe/Berlin'),
(215, '(UTC+01:00) Europe/Ljubljana', 'Europe/Ljubljana'),
(216, '(UTC+01:00) Africa/Bangui', 'Africa/Bangui'),
(217, '(UTC+01:00) Europe/Luxembourg', 'Europe/Luxembourg'),
(218, '(UTC+01:00) Africa/Brazzaville', 'Africa/Brazzaville'),
(219, '(UTC+01:00) Europe/Oslo', 'Europe/Oslo'),
(220, '(UTC+01:00) Europe/Zurich', 'Europe/Zurich'),
(221, '(UTC+01:00) Africa/Ceuta', 'Africa/Ceuta'),
(222, '(UTC+01:00) Europe/Brussels', 'Europe/Brussels'),
(223, '(UTC+01:00) Europe/Madrid', 'Europe/Madrid'),
(224, '(UTC+01:00) Europe/Malta', 'Europe/Malta'),
(225, '(UTC+01:00) Europe/Andorra', 'Europe/Andorra'),
(226, '(UTC+01:00) Europe/Zagreb', 'Europe/Zagreb'),
(227, '(UTC+01:00) Europe/Gibraltar', 'Europe/Gibraltar'),
(228, '(UTC+01:00) Africa/Ndjamena', 'Africa/Ndjamena'),
(229, '(UTC+01:00) Africa/Libreville', 'Africa/Libreville'),
(230, '(UTC+01:00) Africa/Malabo', 'Africa/Malabo'),
(231, '(UTC+01:00) Africa/Tunis', 'Africa/Tunis'),
(232, '(UTC+01:00) Africa/Kinshasa', 'Africa/Kinshasa'),
(233, '(UTC+01:00) Africa/Luanda', 'Africa/Luanda'),
(234, '(UTC+01:00) Africa/Porto-Novo', 'Africa/Porto-Novo'),
(235, '(UTC+01:00) Africa/Niamey', 'Africa/Niamey'),
(236, '(UTC+01:00) Africa/Douala', 'Africa/Douala'),
(237, '(UTC+01:00) Africa/Lagos', 'Africa/Lagos'),
(238, '(UTC+02:00) Africa/Maputo', 'Africa/Maputo'),
(239, '(UTC+02:00) Asia/Nicosia', 'Asia/Nicosia'),
(240, '(UTC+02:00) Africa/Lusaka', 'Africa/Lusaka'),
(241, '(UTC+02:00) Europe/Tallinn', 'Europe/Tallinn'),
(242, '(UTC+02:00) Africa/Lubumbashi', 'Africa/Lubumbashi'),
(243, '(UTC+02:00) Europe/Sofia', 'Europe/Sofia'),
(244, '(UTC+02:00) Europe/Vilnius', 'Europe/Vilnius'),
(245, '(UTC+02:00) Africa/Blantyre', 'Africa/Blantyre'),
(246, '(UTC+02:00) Africa/Bujumbura', 'Africa/Bujumbura'),
(247, '(UTC+02:00) Africa/Cairo', 'Africa/Cairo'),
(248, '(UTC+02:00) Africa/Kigali', 'Africa/Kigali'),
(249, '(UTC+02:00) Africa/Khartoum', 'Africa/Khartoum'),
(250, '(UTC+02:00) Asia/Amman', 'Asia/Amman'),
(251, '(UTC+02:00) Europe/Riga', 'Europe/Riga'),
(252, '(UTC+02:00) Europe/Mariehamn', 'Europe/Mariehamn'),
(253, '(UTC+02:00) Africa/Gaborone', 'Africa/Gaborone'),
(254, '(UTC+02:00) Europe/Uzhgorod', 'Europe/Uzhgorod'),
(255, '(UTC+02:00) Europe/Kiev', 'Europe/Kiev'),
(256, '(UTC+02:00) Africa/Johannesburg', 'Africa/Johannesburg'),
(257, '(UTC+02:00) Asia/Jerusalem', 'Asia/Jerusalem'),
(258, '(UTC+02:00) Asia/Damascus', 'Asia/Damascus'),
(259, '(UTC+02:00) Africa/Windhoek', 'Africa/Windhoek'),
(260, '(UTC+02:00) Europe/Chisinau', 'Europe/Chisinau'),
(261, '(UTC+02:00) Africa/Tripoli', 'Africa/Tripoli'),
(262, '(UTC+02:00) Asia/Famagusta', 'Asia/Famagusta'),
(263, '(UTC+02:00) Asia/Gaza', 'Asia/Gaza'),
(264, '(UTC+02:00) Asia/Hebron', 'Asia/Hebron'),
(265, '(UTC+02:00) Europe/Bucharest', 'Europe/Bucharest'),
(266, '(UTC+02:00) Europe/Athens', 'Europe/Athens'),
(267, '(UTC+02:00) Africa/Harare', 'Africa/Harare'),
(268, '(UTC+02:00) Europe/Zaporozhye', 'Europe/Zaporozhye'),
(269, '(UTC+02:00) Africa/Mbabane', 'Africa/Mbabane'),
(270, '(UTC+02:00) Europe/Helsinki', 'Europe/Helsinki'),
(271, '(UTC+02:00) Africa/Maseru', 'Africa/Maseru'),
(272, '(UTC+02:00) Asia/Beirut', 'Asia/Beirut'),
(273, '(UTC+02:00) Europe/Kaliningrad', 'Europe/Kaliningrad'),
(274, '(UTC+03:00) Africa/Mogadishu', 'Africa/Mogadishu'),
(275, '(UTC+03:00) Europe/Kirov', 'Europe/Kirov'),
(276, '(UTC+03:00) Africa/Addis_Ababa', 'Africa/Addis_Ababa'),
(277, '(UTC+03:00) Africa/Kampala', 'Africa/Kampala'),
(278, '(UTC+03:00) Europe/Istanbul', 'Europe/Istanbul'),
(279, '(UTC+03:00) Africa/Asmara', 'Africa/Asmara'),
(280, '(UTC+03:00) Africa/Juba', 'Africa/Juba'),
(281, '(UTC+03:00) Europe/Minsk', 'Europe/Minsk'),
(282, '(UTC+03:00) Antarctica/Syowa', 'Antarctica/Syowa'),
(283, '(UTC+03:00) Africa/Nairobi', 'Africa/Nairobi'),
(284, '(UTC+03:00) Indian/Mayotte', 'Indian/Mayotte'),
(285, '(UTC+03:00) Europe/Moscow', 'Europe/Moscow'),
(286, '(UTC+03:00) Asia/Riyadh', 'Asia/Riyadh'),
(287, '(UTC+03:00) Indian/Comoro', 'Indian/Comoro'),
(288, '(UTC+03:00) Indian/Antananarivo', 'Indian/Antananarivo'),
(289, '(UTC+03:00) Africa/Dar_es_Salaa', 'Africa/Dar_es_Salaam'),
(290, '(UTC+03:00) Africa/Djibouti', 'Africa/Djibouti'),
(291, '(UTC+03:00) Europe/Volgograd', 'Europe/Volgograd'),
(292, '(UTC+03:00) Asia/Kuwait', 'Asia/Kuwait'),
(293, '(UTC+03:00) Asia/Aden', 'Asia/Aden'),
(294, '(UTC+03:00) Asia/Baghdad', 'Asia/Baghdad'),
(295, '(UTC+03:00) Asia/Qatar', 'Asia/Qatar'),
(296, '(UTC+03:00) Europe/Simferopol', 'Europe/Simferopol'),
(297, '(UTC+03:00) Asia/Bahrain', 'Asia/Bahrain'),
(298, '(UTC+03:30) Asia/Tehran', 'Asia/Tehran'),
(299, '(UTC+04:00) Europe/Saratov', 'Europe/Saratov'),
(300, '(UTC+04:00) Asia/Baku', 'Asia/Baku'),
(301, '(UTC+04:00) Indian/Reunion', 'Indian/Reunion'),
(302, '(UTC+04:00) Asia/Tbilisi', 'Asia/Tbilisi'),
(303, '(UTC+04:00) Europe/Samara', 'Europe/Samara'),
(304, '(UTC+04:00) Asia/Yerevan', 'Asia/Yerevan'),
(305, '(UTC+04:00) Asia/Muscat', 'Asia/Muscat'),
(306, '(UTC+04:00) Europe/Ulyanovsk', 'Europe/Ulyanovsk'),
(307, '(UTC+04:00) Indian/Mahe', 'Indian/Mahe'),
(308, '(UTC+04:00) Asia/Dubai', 'Asia/Dubai'),
(309, '(UTC+04:00) Indian/Mauritius', 'Indian/Mauritius'),
(310, '(UTC+04:00) Europe/Astrakhan', 'Europe/Astrakhan'),
(311, '(UTC+04:30) Asia/Kabul', 'Asia/Kabul'),
(312, '(UTC+05:00) Indian/Kerguelen', 'Indian/Kerguelen'),
(313, '(UTC+05:00) Asia/Dushanbe', 'Asia/Dushanbe'),
(314, '(UTC+05:00) Indian/Maldives', 'Indian/Maldives'),
(315, '(UTC+05:00) Asia/Tashkent', 'Asia/Tashkent'),
(316, '(UTC+05:00) Asia/Karachi', 'Asia/Karachi'),
(317, '(UTC+05:00) Asia/Samarkand', 'Asia/Samarkand'),
(318, '(UTC+05:00) Asia/Yekaterinburg', 'Asia/Yekaterinburg'),
(319, '(UTC+05:00) Asia/Aqtau', 'Asia/Aqtau'),
(320, '(UTC+05:00) Antarctica/Mawson', 'Antarctica/Mawson'),
(321, '(UTC+05:00) Asia/Oral', 'Asia/Oral'),
(322, '(UTC+05:00) Asia/Atyrau', 'Asia/Atyrau'),
(323, '(UTC+05:00) Asia/Ashgabat', 'Asia/Ashgabat'),
(324, '(UTC+05:00) Asia/Aqtobe', 'Asia/Aqtobe'),
(325, '(UTC+05:30) Asia/Kolkata', 'Asia/Kolkata'),
(326, '(UTC+05:30) Asia/Colombo', 'Asia/Colombo'),
(327, '(UTC+05:45) Asia/Kathmandu', 'Asia/Kathmandu'),
(328, '(UTC+06:00) Indian/Chagos', 'Indian/Chagos'),
(329, '(UTC+06:00) Asia/Almaty', 'Asia/Almaty'),
(330, '(UTC+06:00) Asia/Urumqi', 'Asia/Urumqi'),
(331, '(UTC+06:00) Asia/Bishkek', 'Asia/Bishkek'),
(332, '(UTC+06:00) Asia/Qyzylorda', 'Asia/Qyzylorda'),
(333, '(UTC+06:00) Antarctica/Vostok', 'Antarctica/Vostok'),
(334, '(UTC+06:00) Asia/Dhaka', 'Asia/Dhaka'),
(335, '(UTC+06:00) Asia/Omsk', 'Asia/Omsk'),
(336, '(UTC+06:00) Asia/Thimphu', 'Asia/Thimphu'),
(337, '(UTC+06:30) Indian/Cocos', 'Indian/Cocos'),
(338, '(UTC+06:30) Asia/Yangon', 'Asia/Yangon'),
(339, '(UTC+07:00) Asia/Pontianak', 'Asia/Pontianak'),
(340, '(UTC+07:00) Asia/Phnom_Penh', 'Asia/Phnom_Penh'),
(341, '(UTC+07:00) Indian/Christmas', 'Indian/Christmas'),
(342, '(UTC+07:00) Asia/Novokuznetsk', 'Asia/Novokuznetsk'),
(343, '(UTC+07:00) Asia/Jakarta', 'Asia/Jakarta'),
(344, '(UTC+07:00) Asia/Hovd', 'Asia/Hovd'),
(345, '(UTC+07:00) Asia/Ho_Chi_Minh', 'Asia/Ho_Chi_Minh'),
(346, '(UTC+07:00) Asia/Bangkok', 'Asia/Bangkok'),
(347, '(UTC+07:00) Asia/Krasnoyarsk', 'Asia/Krasnoyarsk'),
(348, '(UTC+07:00) Asia/Novosibirsk', 'Asia/Novosibirsk'),
(349, '(UTC+07:00) Asia/Tomsk', 'Asia/Tomsk'),
(350, '(UTC+07:00) Asia/Vientiane', 'Asia/Vientiane'),
(351, '(UTC+07:00) Antarctica/Davis', 'Antarctica/Davis'),
(352, '(UTC+07:00) Asia/Barnaul', 'Asia/Barnaul'),
(353, '(UTC+08:00) Asia/Irkutsk', 'Asia/Irkutsk'),
(354, '(UTC+08:00) Asia/Hong_Kong', 'Asia/Hong_Kong'),
(355, '(UTC+08:00) Asia/Kuala_Lumpur', 'Asia/Kuala_Lumpur'),
(356, '(UTC+08:00) Asia/Kuching', 'Asia/Kuching'),
(357, '(UTC+08:00) Asia/Macau', 'Asia/Macau'),
(358, '(UTC+08:00) Australia/Perth', 'Australia/Perth'),
(359, '(UTC+08:00) Asia/Makassar', 'Asia/Makassar'),
(360, '(UTC+08:00) Asia/Manila', 'Asia/Manila'),
(361, '(UTC+08:00) Asia/Ulaanbaatar', 'Asia/Ulaanbaatar'),
(362, '(UTC+08:00) Asia/Singapore', 'Asia/Singapore'),
(363, '(UTC+08:00) Asia/Taipei', 'Asia/Taipei'),
(364, '(UTC+08:00) Asia/Choibalsan', 'Asia/Choibalsan'),
(365, '(UTC+08:00) Asia/Brunei', 'Asia/Brunei'),
(366, '(UTC+08:00) Asia/Shanghai', 'Asia/Shanghai'),
(367, '(UTC+08:30) Asia/Pyongyang', 'Asia/Pyongyang'),
(368, '(UTC+08:45) Australia/Eucla', 'Australia/Eucla'),
(369, '(UTC+09:00) Asia/Dili', 'Asia/Dili'),
(370, '(UTC+09:00) Asia/Chita', 'Asia/Chita'),
(371, '(UTC+09:00) Asia/Khandyga', 'Asia/Khandyga'),
(372, '(UTC+09:00) Asia/Jayapura', 'Asia/Jayapura'),
(373, '(UTC+09:00) Asia/Seoul', 'Asia/Seoul'),
(374, '(UTC+09:00) Pacific/Palau', 'Pacific/Palau'),
(375, '(UTC+09:00) Asia/Tokyo', 'Asia/Tokyo'),
(376, '(UTC+09:00) Asia/Yakutsk', 'Asia/Yakutsk'),
(377, '(UTC+09:30) Australia/Darwin', 'Australia/Darwin'),
(378, '(UTC+10:00) Asia/Ust-Nera', 'Asia/Ust-Nera'),
(379, '(UTC+10:00) Pacific/Saipan', 'Pacific/Saipan'),
(380, '(UTC+10:00) Pacific/Guam', 'Pacific/Guam'),
(381, '(UTC+10:00) Antarctica/DumontDU', 'Antarctica/DumontDUrville'),
(382, '(UTC+10:00) Asia/Vladivostok', 'Asia/Vladivostok'),
(383, '(UTC+10:00) Australia/Lindeman', 'Australia/Lindeman'),
(384, '(UTC+10:00) Australia/Brisbane', 'Australia/Brisbane'),
(385, '(UTC+10:00) Pacific/Port_Moresb', 'Pacific/Port_Moresby'),
(386, '(UTC+10:00) Pacific/Chuuk', 'Pacific/Chuuk'),
(387, '(UTC+10:30) Australia/Adelaide', 'Australia/Adelaide'),
(388, '(UTC+10:30) Australia/Broken_Hi', 'Australia/Broken_Hill'),
(389, '(UTC+11:00) Pacific/Guadalcanal', 'Pacific/Guadalcanal'),
(390, '(UTC+11:00) Antarctica/Casey', 'Antarctica/Casey'),
(391, '(UTC+11:00) Antarctica/Macquari', 'Antarctica/Macquarie'),
(392, '(UTC+11:00) Pacific/Kosrae', 'Pacific/Kosrae'),
(393, '(UTC+11:00) Pacific/Norfolk', 'Pacific/Norfolk'),
(394, '(UTC+11:00) Pacific/Noumea', 'Pacific/Noumea'),
(395, '(UTC+11:00) Pacific/Pohnpei', 'Pacific/Pohnpei'),
(396, '(UTC+11:00) Australia/Sydney', 'Australia/Sydney'),
(397, '(UTC+11:00) Pacific/Efate', 'Pacific/Efate'),
(398, '(UTC+11:00) Australia/Melbourne', 'Australia/Melbourne'),
(399, '(UTC+11:00) Australia/Lord_Howe', 'Australia/Lord_Howe'),
(400, '(UTC+11:00) Australia/Hobart', 'Australia/Hobart'),
(401, '(UTC+11:00) Australia/Currie', 'Australia/Currie'),
(402, '(UTC+11:00) Asia/Srednekolymsk', 'Asia/Srednekolymsk'),
(403, '(UTC+11:00) Pacific/Bougainvill', 'Pacific/Bougainville'),
(404, '(UTC+11:00) Asia/Sakhalin', 'Asia/Sakhalin'),
(405, '(UTC+11:00) Asia/Magadan', 'Asia/Magadan'),
(406, '(UTC+12:00) Pacific/Funafuti', 'Pacific/Funafuti'),
(407, '(UTC+12:00) Asia/Kamchatka', 'Asia/Kamchatka'),
(408, '(UTC+12:00) Pacific/Wake', 'Pacific/Wake'),
(409, '(UTC+12:00) Pacific/Tarawa', 'Pacific/Tarawa'),
(410, '(UTC+12:00) Pacific/Wallis', 'Pacific/Wallis'),
(411, '(UTC+12:00) Pacific/Fiji', 'Pacific/Fiji'),
(412, '(UTC+12:00) Pacific/Nauru', 'Pacific/Nauru'),
(413, '(UTC+12:00) Asia/Anadyr', 'Asia/Anadyr'),
(414, '(UTC+12:00) Pacific/Majuro', 'Pacific/Majuro'),
(415, '(UTC+12:00) Pacific/Kwajalein', 'Pacific/Kwajalein'),
(416, '(UTC+13:00) Antarctica/McMurdo', 'Antarctica/McMurdo'),
(417, '(UTC+13:00) Pacific/Enderbury', 'Pacific/Enderbury'),
(418, '(UTC+13:00) Pacific/Tongatapu', 'Pacific/Tongatapu'),
(419, '(UTC+13:00) Pacific/Fakaofo', 'Pacific/Fakaofo'),
(420, '(UTC+13:00) Pacific/Auckland', 'Pacific/Auckland'),
(421, '(UTC+13:45) Pacific/Chatham', 'Pacific/Chatham'),
(422, '(UTC+14:00) Pacific/Apia', 'Pacific/Apia'),
(423, '(UTC+14:00) Pacific/Kiritimati', 'Pacific/Kiritimati');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `branchid` int(11) DEFAULT NULL,
  `company` int(11) DEFAULT NULL,
  `fname` varchar(16) NOT NULL,
  `lname` varchar(16) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `phonenumber` varchar(16) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `token` varchar(256) DEFAULT NULL,
  `remember_token` varchar(256) DEFAULT NULL,
  `auth_token` varchar(256) DEFAULT NULL,
  `role` enum('Owner','Manager','Staff','Admin') NOT NULL,
  `status` enum('Active','On Leave','Unavailable') NOT NULL DEFAULT 'Active',
  `type` enum('Full Time','Part Time','Subcontractor') NOT NULL DEFAULT 'Full Time',
  `balance` float(11,2) NOT NULL DEFAULT 0.00,
  `lang` varchar(32) NOT NULL DEFAULT 'en_US',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `branchid`, `company`, `fname`, `lname`, `email`, `phonenumber`, `address`, `password`, `avatar`, `token`, `remember_token`, `auth_token`, `role`, `status`, `type`, `balance`, `lang`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Daniel', 'Kimeli', 'kimeli@dottedcraft.com', '+254720783834', 'Adonai Apt, Ongata Rongai', '6b088c33c14af93b512021b4d379d903594b75f00cd8f8a5b169a6a109bb2478', NULL, '', 'fzkWmL2n3sICqa37', NULL, 'Admin', 'Active', 'Full Time', 824.00, 'en_US', '2019-02-07 12:47:21', '2023-04-11 10:45:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`);

--
-- Indexes for table `branchservices`
--
ALTER TABLE `branchservices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id_foreign_branchservices` (`service`),
  ADD KEY `branch_id_foreign_branchservices` (`branch`),
  ADD KEY `company_id` (`company`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`),
  ADD KEY `branch` (`branch`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`),
  ADD KEY `campaign` (`campaign`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id_foreign_sales` (`branch`),
  ADD KEY `client_id_foreign_sales` (`client`),
  ADD KEY `company_id` (`company`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`);

--
-- Indexes for table `servicesales`
--
ALTER TABLE `servicesales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id_foreign_sales` (`branch`),
  ADD KEY `service_id_foreign_sales` (`service`),
  ADD KEY `team_id_foreign_sales` (`provided_by`),
  ADD KEY `client_id_foreign_sales` (`client`),
  ADD KEY `company_id` (`company`),
  ADD KEY `sale_id` (`sale`);

--
-- Indexes for table `teampayments`
--
ALTER TABLE `teampayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`),
  ADD KEY `member` (`member`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `company` (`company`),
  ADD KEY `branchid` (`branchid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branchservices`
--
ALTER TABLE `branchservices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicesales`
--
ALTER TABLE `servicesales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teampayments`
--
ALTER TABLE `teampayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=424;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `branchservices`
--
ALTER TABLE `branchservices`
  ADD CONSTRAINT `branchservices_ibfk_1` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `branchservices_ibfk_2` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `branchservices_ibfk_3` FOREIGN KEY (`service`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`campaign`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`client`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `servicesales`
--
ALTER TABLE `servicesales`
  ADD CONSTRAINT `servicesales_ibfk_1` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicesales_ibfk_2` FOREIGN KEY (`client`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicesales_ibfk_3` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicesales_ibfk_4` FOREIGN KEY (`sale`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicesales_ibfk_5` FOREIGN KEY (`service`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicesales_ibfk_6` FOREIGN KEY (`provided_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `teampayments`
--
ALTER TABLE `teampayments`
  ADD CONSTRAINT `teampayments_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teampayments_ibfk_2` FOREIGN KEY (`member`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`branchid`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
