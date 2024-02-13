-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 21, 2020 at 11:00 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bma-member-management-software`
--

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `symbol_native` varchar(20) DEFAULT NULL,
  `decimal_digits` int(11) DEFAULT NULL,
  `rounding` int(11) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name_plural` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `symbol`, `name`, `symbol_native`, `decimal_digits`, `rounding`, `code`, `name_plural`) VALUES
(1, '$', 'US Dollar', '$', 2, 0, 'USD', 'US dollars'),
(2, 'CA$', 'Canadian Dollar', '$', 2, 0, 'CAD', 'Canadian dollars'),
(3, '€', 'Euro', '€', 2, 0, 'EUR', 'euros'),
(4, 'AED', 'United Arab Emirates Dirham', 'د.إ.‏', 2, 0, 'AED', 'UAE dirhams'),
(5, 'Af', 'Afghan Afghani', '؋', 0, 0, 'AFN', 'Afghan Afghanis'),
(6, 'ALL', 'Albanian Lek', 'Lek', 0, 0, 'ALL', 'Albanian lekë'),
(7, 'AMD', 'Armenian Dram', 'դր.', 0, 0, 'AMD', 'Armenian drams'),
(8, 'AR$', 'Argentine Peso', '$', 2, 0, 'ARS', 'Argentine pesos'),
(9, 'AU$', 'Australian Dollar', '$', 2, 0, 'AUD', 'Australian dollars'),
(10, 'man.', 'Azerbaijani Manat', 'ман.', 2, 0, 'AZN', 'Azerbaijani manats'),
(11, 'KM', 'Bosnia-Herzegovina Convertible Mark', 'KM', 2, 0, 'BAM', 'Bosnia-Herzegovina convertible marks'),
(12, 'Tk', 'Bangladeshi Taka', '৳', 2, 0, 'BDT', 'Bangladeshi takas'),
(13, 'BGN', 'Bulgarian Lev', 'лв.', 2, 0, 'BGN', 'Bulgarian leva'),
(14, 'BD', 'Bahraini Dinar', 'د.ب.‏', 3, 0, 'BHD', 'Bahraini dinars'),
(15, 'FBu', 'Burundian Franc', 'FBu', 0, 0, 'BIF', 'Burundian francs'),
(16, 'BN$', 'Brunei Dollar', '$', 2, 0, 'BND', 'Brunei dollars'),
(17, 'Bs', 'Bolivian Boliviano', 'Bs', 2, 0, 'BOB', 'Bolivian bolivianos'),
(18, 'R$', 'Brazilian Real', 'R$', 2, 0, 'BRL', 'Brazilian reals'),
(19, 'BWP', 'Botswanan Pula', 'P', 2, 0, 'BWP', 'Botswanan pulas'),
(20, 'BYR', 'Belarusian Ruble', 'BYR', 0, 0, 'BYR', 'Belarusian rubles'),
(21, 'BZ$', 'Belize Dollar', '$', 2, 0, 'BZD', 'Belize dollars'),
(22, 'CDF', 'Congolese Franc', 'FrCD', 2, 0, 'CDF', 'Congolese francs'),
(23, 'CHF', 'Swiss Franc', 'CHF', 2, 0, 'CHF', 'Swiss francs'),
(24, 'CL$', 'Chilean Peso', '$', 0, 0, 'CLP', 'Chilean pesos'),
(25, 'CN¥', 'Chinese Yuan', 'CN¥', 2, 0, 'CNY', 'Chinese yuan'),
(26, 'CO$', 'Colombian Peso', '$', 0, 0, 'COP', 'Colombian pesos'),
(27, '₡', 'Costa Rican Colón', '₡', 0, 0, 'CRC', 'Costa Rican colóns'),
(28, 'CV$', 'Cape Verdean Escudo', 'CV$', 2, 0, 'CVE', 'Cape Verdean escudos'),
(29, 'Kč', 'Czech Republic Koruna', 'Kč', 2, 0, 'CZK', 'Czech Republic korunas'),
(30, 'Fdj', 'Djiboutian Franc', 'Fdj', 0, 0, 'DJF', 'Djiboutian francs'),
(31, 'Dkr', 'Danish Krone', 'kr', 2, 0, 'DKK', 'Danish kroner'),
(32, 'RD$', 'Dominican Peso', 'RD$', 2, 0, 'DOP', 'Dominican pesos'),
(33, 'DA', 'Algerian Dinar', 'د.ج.‏', 2, 0, 'DZD', 'Algerian dinars'),
(34, 'Ekr', 'Estonian Kroon', 'kr', 2, 0, 'EEK', 'Estonian kroons'),
(35, 'EGP', 'Egyptian Pound', 'ج.م.‏', 2, 0, 'EGP', 'Egyptian pounds'),
(36, 'Nfk', 'Eritrean Nakfa', 'Nfk', 2, 0, 'ERN', 'Eritrean nakfas'),
(37, 'Br', 'Ethiopian Birr', 'Br', 2, 0, 'ETB', 'Ethiopian birrs'),
(38, '£', 'British Pound Sterling', '£', 2, 0, 'GBP', 'British pounds sterling'),
(39, 'GEL', 'Georgian Lari', 'GEL', 2, 0, 'GEL', 'Georgian laris'),
(40, 'GH₵', 'Ghanaian Cedi', 'GH₵', 2, 0, 'GHS', 'Ghanaian cedis'),
(41, 'FG', 'Guinean Franc', 'FG', 0, 0, 'GNF', 'Guinean francs'),
(42, 'GTQ', 'Guatemalan Quetzal', 'Q', 2, 0, 'GTQ', 'Guatemalan quetzals'),
(43, 'HK$', 'Hong Kong Dollar', '$', 2, 0, 'HKD', 'Hong Kong dollars'),
(44, 'HNL', 'Honduran Lempira', 'L', 2, 0, 'HNL', 'Honduran lempiras'),
(45, 'kn', 'Croatian Kuna', 'kn', 2, 0, 'HRK', 'Croatian kunas'),
(46, 'Ft', 'Hungarian Forint', 'Ft', 0, 0, 'HUF', 'Hungarian forints'),
(47, 'Rp', 'Indonesian Rupiah', 'Rp', 0, 0, 'IDR', 'Indonesian rupiahs'),
(48, '₪', 'Israeli New Sheqel', '₪', 2, 0, 'ILS', 'Israeli new sheqels'),
(49, 'Rs', 'Indian Rupee', 'টকা', 2, 0, 'INR', 'Indian rupees'),
(50, 'IQD', 'Iraqi Dinar', 'د.ع.‏', 0, 0, 'IQD', 'Iraqi dinars'),
(51, 'IRR', 'Iranian Rial', '﷼', 0, 0, 'IRR', 'Iranian rials'),
(52, 'Ikr', 'Icelandic Króna', 'kr', 0, 0, 'ISK', 'Icelandic krónur'),
(53, 'J$', 'Jamaican Dollar', '$', 2, 0, 'JMD', 'Jamaican dollars'),
(54, 'JD', 'Jordanian Dinar', 'د.أ.‏', 3, 0, 'JOD', 'Jordanian dinars'),
(55, '¥', 'Japanese Yen', '￥', 0, 0, 'JPY', 'Japanese yen'),
(56, 'Ksh', 'Kenyan Shilling', 'Ksh', 2, 0, 'KES', 'Kenyan shillings'),
(57, 'KHR', 'Cambodian Riel', '៛', 2, 0, 'KHR', 'Cambodian riels'),
(58, 'CF', 'Comorian Franc', 'FC', 0, 0, 'KMF', 'Comorian francs'),
(59, '₩', 'South Korean Won', '₩', 0, 0, 'KRW', 'South Korean won'),
(60, 'KD', 'Kuwaiti Dinar', 'د.ك.‏', 3, 0, 'KWD', 'Kuwaiti dinars'),
(61, 'KZT', 'Kazakhstani Tenge', 'тңг.', 2, 0, 'KZT', 'Kazakhstani tenges'),
(62, 'LB£', 'Lebanese Pound', 'ل.ل.‏', 0, 0, 'LBP', 'Lebanese pounds'),
(63, 'SLRs', 'Sri Lankan Rupee', 'SL Re', 2, 0, 'LKR', 'Sri Lankan rupees'),
(64, 'Lt', 'Lithuanian Litas', 'Lt', 2, 0, 'LTL', 'Lithuanian litai'),
(65, 'Ls', 'Latvian Lats', 'Ls', 2, 0, 'LVL', 'Latvian lati'),
(66, 'LD', 'Libyan Dinar', 'د.ل.‏', 3, 0, 'LYD', 'Libyan dinars'),
(67, 'MAD', 'Moroccan Dirham', 'د.م.‏', 2, 0, 'MAD', 'Moroccan dirhams'),
(68, 'MDL', 'Moldovan Leu', 'MDL', 2, 0, 'MDL', 'Moldovan lei'),
(69, 'MGA', 'Malagasy Ariary', 'MGA', 0, 0, 'MGA', 'Malagasy Ariaries'),
(70, 'MKD', 'Macedonian Denar', 'MKD', 2, 0, 'MKD', 'Macedonian denari'),
(71, 'MMK', 'Myanma Kyat', 'K', 0, 0, 'MMK', 'Myanma kyats'),
(72, 'MOP$', 'Macanese Pataca', 'MOP$', 2, 0, 'MOP', 'Macanese patacas'),
(73, 'MURs', 'Mauritian Rupee', 'MURs', 0, 0, 'MUR', 'Mauritian rupees'),
(74, 'MX$', 'Mexican Peso', '$', 2, 0, 'MXN', 'Mexican pesos'),
(75, 'RM', 'Malaysian Ringgit', 'RM', 2, 0, 'MYR', 'Malaysian ringgits'),
(76, 'MTn', 'Mozambican Metical', 'MTn', 2, 0, 'MZN', 'Mozambican meticals'),
(77, 'N$', 'Namibian Dollar', 'N$', 2, 0, 'NAD', 'Namibian dollars'),
(78, '₦', 'Nigerian Naira', '₦', 2, 0, 'NGN', 'Nigerian nairas'),
(79, 'C$', 'Nicaraguan Córdoba', 'C$', 2, 0, 'NIO', 'Nicaraguan córdobas'),
(80, 'Nkr', 'Norwegian Krone', 'kr', 2, 0, 'NOK', 'Norwegian kroner'),
(81, 'NPRs', 'Nepalese Rupee', 'नेरू', 2, 0, 'NPR', 'Nepalese rupees'),
(82, 'NZ$', 'New Zealand Dollar', '$', 2, 0, 'NZD', 'New Zealand dollars'),
(83, 'OMR', 'Omani Rial', 'ر.ع.‏', 3, 0, 'OMR', 'Omani rials'),
(84, 'B/.', 'Panamanian Balboa', 'B/.', 2, 0, 'PAB', 'Panamanian balboas'),
(85, 'S/.', 'Peruvian Nuevo Sol', 'S/.', 2, 0, 'PEN', 'Peruvian nuevos soles'),
(86, '₱', 'Philippine Peso', '₱', 2, 0, 'PHP', 'Philippine pesos'),
(87, 'PKRs', 'Pakistani Rupee', '₨', 0, 0, 'PKR', 'Pakistani rupees'),
(88, 'zł', 'Polish Zloty', 'zł', 2, 0, 'PLN', 'Polish zlotys'),
(89, '₲', 'Paraguayan Guarani', '₲', 0, 0, 'PYG', 'Paraguayan guaranis'),
(90, 'QR', 'Qatari Rial', 'ر.ق.‏', 2, 0, 'QAR', 'Qatari rials'),
(91, 'RON', 'Romanian Leu', 'RON', 2, 0, 'RON', 'Romanian lei'),
(92, 'din.', 'Serbian Dinar', 'дин.', 0, 0, 'RSD', 'Serbian dinars'),
(93, 'RUB', 'Russian Ruble', 'руб.', 2, 0, 'RUB', 'Russian rubles'),
(94, 'RWF', 'Rwandan Franc', 'FR', 0, 0, 'RWF', 'Rwandan francs'),
(95, 'SR', 'Saudi Riyal', 'ر.س.‏', 2, 0, 'SAR', 'Saudi riyals'),
(96, 'SDG', 'Sudanese Pound', 'SDG', 2, 0, 'SDG', 'Sudanese pounds'),
(97, 'Skr', 'Swedish Krona', 'kr', 2, 0, 'SEK', 'Swedish kronor'),
(98, 'S$', 'Singapore Dollar', '$', 2, 0, 'SGD', 'Singapore dollars'),
(99, 'Ssh', 'Somali Shilling', 'Ssh', 0, 0, 'SOS', 'Somali shillings'),
(100, 'SY£', 'Syrian Pound', 'ل.س.‏', 0, 0, 'SYP', 'Syrian pounds'),
(101, '฿', 'Thai Baht', '฿', 2, 0, 'THB', 'Thai baht'),
(102, 'DT', 'Tunisian Dinar', 'د.ت.‏', 3, 0, 'TND', 'Tunisian dinars'),
(103, 'T$', 'Tongan Paʻanga', 'T$', 2, 0, 'TOP', 'Tongan paʻanga'),
(104, 'TL', 'Turkish Lira', 'TL', 2, 0, 'TRY', 'Turkish Lira'),
(105, 'TT$', 'Trinidad and Tobago Dollar', '$', 2, 0, 'TTD', 'Trinidad and Tobago dollars'),
(106, 'NT$', 'New Taiwan Dollar', 'NT$', 2, 0, 'TWD', 'New Taiwan dollars'),
(107, 'TSh', 'Tanzanian Shilling', 'TSh', 0, 0, 'TZS', 'Tanzanian shillings'),
(108, '₴', 'Ukrainian Hryvnia', '₴', 2, 0, 'UAH', 'Ukrainian hryvnias'),
(109, 'USh', 'Ugandan Shilling', 'USh', 0, 0, 'UGX', 'Ugandan shillings'),
(110, '$U', 'Uruguayan Peso', '$', 2, 0, 'UYU', 'Uruguayan pesos'),
(111, 'UZS', 'Uzbekistan Som', 'UZS', 0, 0, 'UZS', 'Uzbekistan som'),
(112, 'Bs.F.', 'Venezuelan Bolívar', 'Bs.F.', 2, 0, 'VEF', 'Venezuelan bolívars'),
(113, '₫', 'Vietnamese Dong', '₫', 0, 0, 'VND', 'Vietnamese dong'),
(114, 'FCFA', 'CFA Franc BEAC', 'FCFA', 0, 0, 'XAF', 'CFA francs BEAC'),
(115, 'CFA', 'CFA Franc BCEAO', 'CFA', 0, 0, 'XOF', 'CFA francs BCEAO'),
(116, 'YR', 'Yemeni Rial', 'ر.ي.‏', 0, 0, 'YER', 'Yemeni rials'),
(117, 'R', 'South African Rand', 'R', 2, 0, 'ZAR', 'South African rand'),
(118, 'ZK', 'Zambian Kwacha', 'ZK', 0, 0, 'ZMK', 'Zambian kwachas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
