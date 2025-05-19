-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 06, 2025 at 10:22 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

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
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unique_identifier` varchar(255) NOT NULL,
  `version` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `about` longtext,
  `purchase_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `addon_hooks`
--

CREATE TABLE `addon_hooks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `addon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `app_route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addon_route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dom` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `symbol` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_supported` int(11) NOT NULL DEFAULT '0',
  `stripe_supported` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `paypal_supported`, `stripe_supported`) VALUES
(1, 'Leke', 'ALL', 'Lek', 0, 1),
(2, 'Dollars', 'USD', '$', 1, 1),
(3, 'Afghanis', 'AFN', '؋', 0, 1),
(4, 'Pesos', 'ARS', '$', 0, 1),
(5, 'Guilders', 'AWG', 'ƒ', 0, 1),
(6, 'Dollars', 'AUD', '$', 1, 1),
(7, 'New Manats', 'AZN', 'ман', 0, 1),
(8, 'Dollars', 'BSD', '$', 0, 1),
(9, 'Dollars', 'BBD', '$', 0, 1),
(10, 'Rubles', 'BYR', 'p.', 0, 0),
(11, 'Euro', 'EUR', '€', 1, 1),
(12, 'Dollars', 'BZD', 'BZ$', 0, 1),
(13, 'Dollars', 'BMD', '$', 0, 1),
(14, 'Bolivianos', 'BOB', '$b', 0, 1),
(15, 'Convertible Marka', 'BAM', 'KM', 0, 1),
(16, 'Pula', 'BWP', 'P', 0, 1),
(17, 'Leva', 'BGN', 'лв', 0, 1),
(18, 'Reais', 'BRL', 'R$', 1, 1),
(19, 'Pounds', 'GBP', '£', 1, 1),
(20, 'Dollars', 'BND', '$', 0, 1),
(21, 'Riels', 'KHR', '៛', 0, 1),
(22, 'Dollars', 'CAD', '$', 1, 1),
(23, 'Dollars', 'KYD', '$', 0, 1),
(24, 'Pesos', 'CLP', '$', 0, 1),
(25, 'Yuan Renminbi', 'CNY', '¥', 0, 1),
(26, 'Pesos', 'COP', '$', 0, 1),
(27, 'Colón', 'CRC', '₡', 0, 1),
(28, 'Kuna', 'HRK', 'kn', 0, 1),
(29, 'Pesos', 'CUP', '₱', 0, 0),
(30, 'Koruny', 'CZK', 'Kč', 1, 1),
(31, 'Kroner', 'DKK', 'kr', 1, 1),
(32, 'Pesos', 'DOP ', 'RD$', 0, 1),
(33, 'Dollars', 'XCD', '$', 0, 1),
(34, 'Pounds', 'EGP', '£', 0, 1),
(35, 'Colones', 'SVC', '$', 0, 0),
(36, 'Pounds', 'FKP', '£', 0, 1),
(37, 'Dollars', 'FJD', '$', 0, 1),
(38, 'Cedis', 'GHC', '¢', 0, 0),
(39, 'Pounds', 'GIP', '£', 0, 1),
(40, 'Quetzales', 'GTQ', 'Q', 0, 1),
(41, 'Pounds', 'GGP', '£', 0, 0),
(42, 'Dollars', 'GYD', '$', 0, 1),
(43, 'Lempiras', 'HNL', 'L', 0, 1),
(44, 'Dollars', 'HKD', '$', 1, 1),
(45, 'Forint', 'HUF', 'Ft', 1, 1),
(46, 'Kronur', 'ISK', 'kr', 0, 1),
(47, 'Rupees', 'INR', 'Rp', 1, 1),
(48, 'Rupiahs', 'IDR', 'Rp', 0, 1),
(49, 'Rials', 'IRR', '﷼', 0, 0),
(50, 'Pounds', 'IMP', '£', 0, 0),
(51, 'New Shekels', 'ILS', '₪', 1, 1),
(52, 'Dollars', 'JMD', 'J$', 0, 1),
(53, 'Yen', 'JPY', '¥', 1, 1),
(54, 'Pounds', 'JEP', '£', 0, 0),
(55, 'Tenge', 'KZT', 'лв', 0, 1),
(56, 'Won', 'KPW', '₩', 0, 0),
(57, 'Won', 'KRW', '₩', 0, 1),
(58, 'Soms', 'KGS', 'лв', 0, 1),
(59, 'Kips', 'LAK', '₭', 0, 1),
(60, 'Lati', 'LVL', 'Ls', 0, 0),
(61, 'Pounds', 'LBP', '£', 0, 1),
(62, 'Dollars', 'LRD', '$', 0, 1),
(63, 'Switzerland Francs', 'CHF', 'CHF', 1, 1),
(64, 'Litai', 'LTL', 'Lt', 0, 0),
(65, 'Denars', 'MKD', 'ден', 0, 1),
(66, 'Ringgits', 'MYR', 'RM', 1, 1),
(67, 'Rupees', 'MUR', '₨', 0, 1),
(68, 'Pesos', 'MXN', '$', 1, 1),
(69, 'Tugriks', 'MNT', '₮', 0, 1),
(70, 'Meticais', 'MZN', 'MT', 0, 1),
(71, 'Dollars', 'NAD', '$', 0, 1),
(72, 'Rupees', 'NPR', '₨', 0, 1),
(73, 'Guilders', 'ANG', 'ƒ', 0, 1),
(74, 'Dollars', 'NZD', '$', 1, 1),
(75, 'Cordobas', 'NIO', 'C$', 0, 1),
(76, 'Nairas', 'NGN', '₦', 0, 1),
(77, 'Krone', 'NOK', 'kr', 1, 1),
(78, 'Rials', 'OMR', '﷼', 0, 0),
(79, 'Rupees', 'PKR', '₨', 0, 1),
(80, 'Balboa', 'PAB', 'B/.', 0, 1),
(81, 'Guarani', 'PYG', 'Gs', 0, 1),
(82, 'Nuevos Soles', 'PEN', 'S/.', 0, 1),
(83, 'Pesos', 'PHP', 'Php', 1, 1),
(84, 'Zlotych', 'PLN', 'zł', 1, 1),
(85, 'Rials', 'QAR', '﷼', 0, 1),
(86, 'New Lei', 'RON', 'lei', 0, 1),
(87, 'Rubles', 'RUB', 'руб', 0, 1),
(88, 'Pounds', 'SHP', '£', 0, 1),
(89, 'Riyals', 'SAR', '﷼', 0, 1),
(90, 'Dinars', 'RSD', 'Дин.', 0, 1),
(91, 'Rupees', 'SCR', '₨', 0, 1),
(92, 'Dollars', 'SGD', '$', 1, 1),
(93, 'Dollars', 'SBD', '$', 0, 1),
(94, 'Shillings', 'SOS', 'S', 0, 1),
(95, 'Rand', 'ZAR', 'R', 0, 1),
(96, 'Rupees', 'LKR', '₨', 0, 1),
(97, 'Kronor', 'SEK', 'kr', 1, 1),
(98, 'Dollars', 'SRD', '$', 0, 1),
(99, 'Pounds', 'SYP', '£', 0, 0),
(100, 'New Dollars', 'TWD', 'NT$', 1, 1),
(101, 'Baht', 'THB', '฿', 1, 1),
(102, 'Dollars', 'TTD', 'TT$', 0, 1),
(103, 'Lira', 'TRY', 'TL', 0, 1),
(104, 'Liras', 'TRL', '£', 0, 0),
(105, 'Dollars', 'TVD', '$', 0, 0),
(106, 'Hryvnia', 'UAH', '₴', 0, 1),
(107, 'Pesos', 'UYU', '$U', 0, 1),
(108, 'Sums', 'UZS', 'лв', 0, 1),
(109, 'Bolivares Fuertes', 'VEF', 'Bs', 0, 0),
(110, 'Dong', 'VND', '₫', 0, 1),
(111, 'Rials', 'YER', '﷼', 0, 1),
(112, 'Zimbabwe Dollars', 'ZWD', 'Z$', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci,
  `answer` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `direction`, `created_at`, `updated_at`) VALUES
(3, 'English', 'ltr', '2024-04-08 10:42:26', '2025-03-09 05:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `language_phrases`
--

CREATE TABLE `language_phrases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phrase` text COLLATE utf8mb4_unicode_ci,
  `translated` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `read` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_threads`
--

CREATE TABLE `message_threads` (
  `id` int(11) NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_one` int(11) DEFAULT NULL,
  `contact_two` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_editable` int(11) DEFAULT NULL,
  `addon_identifier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_types` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `system_notification` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_notification` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template` longtext COLLATE utf8_unicode_ci,
  `setting_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `setting_sub_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_updated` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notification_settings`
--

INSERT INTO `notification_settings` (`id`, `type`, `is_editable`, `addon_identifier`, `user_types`, `system_notification`, `email_notification`, `subject`, `template`, `setting_title`, `setting_sub_title`, `date_updated`, `created_at`, `updated_at`) VALUES
(2, 'payment-conformation', 0, NULL, '[\"user\"]', '{\"user\":\"0\"}', '{\"user\":\"1\"}', '{\"user\":\"Payment Completed.\"}', '{\"user\":\"<main style=\\\"background: #fafafa;\\\">\\r\\n        <div style=\\\"max-width: 640px; width: 100%; margin: 0 auto; background: #ffffff;\\\">\\r\\n            <div style=\\\"padding: 40px 48px;\\\">\\r\\n                <div style=\\\"margin-bottom: 30px;\\\">\\r\\n                    <span>\\r\\n                        <img src=\\\"{{get_image(get_settings(\'logo\'))}}\\\" alt=\\\"\\\">\\r\\n                    <\\/span>\\r\\n                <\\/div>\\r\\n                <div style=\\\"margin: 30px 0; border-top: 1px solid #dbdfeb;\\\">\\r\\n                    <h1 style=\\\"margin: 30px 0 24px 0; font-weight: 600; font-size: 24px; line-height: 24px; color: #212534;\\\">Thank You for Your Payment<\\/h1>\\r\\n                    <div style=\\\"font-weight: 400; font-size: 16px; line-height: 24px; color: #6d718c;\\\">\\r\\n                        <p>Hi [client_name],<\\/p>\\r\\n                        <p style=\\\"margin: 0;\\\">Thank you for your payment! We are thrilled to have you as a valued customer and appreciate your trust in us.<\\/p>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <div style=\\\"font-weight: 500; font-size: 16px; line-height: 24px; color: #212534; \\\">\\r\\n                    <p style=\\\"margin-bottom: 24px;\\\">This email was sent to <a href=\\\"mailto:[admin_email]\\\" style=\\\"color: #1b84ff;\\\">[admin_email]<\\/a>.If you rather not receive this kind of email. Do not want any more emails from Notable?\\r\\n                        <a href=\\\"#\\\" style=\\\"color: #1b84ff;\\\">Unsubscribe<\\/a>.\\r\\n                    <\\/p>\\r\\n                    <p style=\\\"margin: 0;\\\">\\r\\n                        [address]\\r\\n                    <\\/p>\\r\\n                    <div style=\\\"display: flex; align-items: center; justify-content: space-between;\\\">\\r\\n                        <span>[footer_text]<\\/span>\\r\\n                        <div style=\\\"display: flex; align-items: center; gap: 16px;\\\">\\r\\n                            <a href=\\\"#\\\">\\r\\n                                <span>\\r\\n                                    <svg width=\\\"19\\\" height=\\\"18\\\" viewBox=\\\"0 0 19 18\\\" fill=\\\"none\\\" xmlns=\\\"http:\\/\\/www.w3.org\\/2000\\/svg\\\">\\r\\n                                        <g clip-path=\\\"url(#clip0_1429_7943)\\\">\\r\\n                                            <path d=\\\"M18.902 8.99994C18.902 4.02941 14.6706 0 9.45099 0C4.23135 0 0 4.02941 0 8.99994C0 13.492 3.45607 17.2154 7.97427 17.8905V11.6015H5.57461V8.99994H7.97427V7.01714C7.97427 4.76153 9.38528 3.5156 11.5441 3.5156C12.5778 3.5156 13.6596 3.69138 13.6596 3.69138V5.90621H12.4679C11.2939 5.90621 10.9277 6.60001 10.9277 7.31245V8.99994H13.5489L13.1299 11.6015H10.9277V17.8905C15.4459 17.2154 18.902 13.492 18.902 8.99994Z\\\" fill=\\\"#99A1B7\\\"><\\/path>\\r\\n                                        <\\/g>\\r\\n                                        <defs>\\r\\n                                            <clipPath id=\\\"clip0_1429_7943\\\">\\r\\n                                                <rect width=\\\"18.902\\\" height=\\\"17.9999\\\" fill=\\\"white\\\"><\\/rect>\\r\\n                                            <\\/clipPath>\\r\\n                                        <\\/defs>\\r\\n                                    <\\/svg>\\r\\n                                <\\/span>\\r\\n                            <\\/a>\\r\\n                            <a href=\\\"#\\\" style=\\\"display: flex; align-items: center; gap: 16px;\\\">\\r\\n                                <span>\\r\\n                                    <svg width=\\\"20\\\" height=\\\"18\\\" viewBox=\\\"0 0 20 18\\\" fill=\\\"none\\\" xmlns=\\\"http:\\/\\/www.w3.org\\/2000\\/svg\\\">\\r\\n                                        <g clip-path=\\\"url(#clip0_1429_7963)\\\">\\r\\n                                            <path d=\\\"M12.1865 7.62924L19.1179 0.0491333H17.4754L11.4568 6.63083L6.6498 0.0491333H1.10547L8.37463 10.0018L1.10547 17.9507H2.7481L9.10387 11.0002L14.1804 17.9507H19.7248L12.1861 7.62924H12.1865ZM9.93668 10.0895L9.20017 9.09845L3.33996 1.21244H5.86293L10.5922 7.5767L11.3287 8.56776L17.4762 16.8403H14.9532L9.93668 10.0899V10.0895Z\\\" fill=\\\"#99A1B7\\\"><\\/path>\\r\\n                                        <\\/g>\\r\\n                                        <defs>\\r\\n                                            <clipPath id=\\\"clip0_1429_7963\\\">\\r\\n                                                <rect width=\\\"19.0285\\\" height=\\\"17.9016\\\" fill=\\\"white\\\" transform=\\\"translate(0.902344 0.0491333)\\\"><\\/rect>\\r\\n                                            <\\/clipPath>\\r\\n                                        <\\/defs>\\r\\n                                    <\\/svg>\\r\\n                                <\\/span>\\r\\n                            <\\/a>\\r\\n                            <a href=\\\"#\\\">\\r\\n                                <span>\\r\\n                                    <svg width=\\\"20\\\" height=\\\"18\\\" viewBox=\\\"0 0 20 18\\\" fill=\\\"none\\\" xmlns=\\\"http:\\/\\/www.w3.org\\/2000\\/svg\\\">\\r\\n                                        <g clip-path=\\\"url(#clip0_1429_7965)\\\">\\r\\n                                            <path d=\\\"M9.96977 1.62069C12.3852 1.62069 12.6712 1.63124 13.6211 1.67343C14.5039 1.7121 14.9807 1.85975 15.2985 1.9828C15.7187 2.14452 16.0224 2.34139 16.3367 2.65428C16.6545 2.97068 16.8487 3.26951 17.0111 3.68787C17.1347 4.00427 17.283 4.48239 17.3219 5.35778C17.3643 6.30699 17.3749 6.59175 17.3749 8.99291C17.3749 11.3976 17.3643 11.6823 17.3219 12.628C17.283 13.5069 17.1347 13.9815 17.0111 14.298C16.8487 14.7163 16.6509 15.0186 16.3367 15.3315C16.0188 15.6479 15.7187 15.8413 15.2985 16.003C14.9807 16.1261 14.5004 16.2737 13.6211 16.3124C12.6677 16.3546 12.3816 16.3651 9.96977 16.3651C7.55437 16.3651 7.26834 16.3546 6.31842 16.3124C5.4356 16.2737 4.95888 16.1261 4.64106 16.003C4.22084 15.8413 3.91715 15.6444 3.60287 15.3315C3.28505 15.0151 3.09083 14.7163 2.92839 14.298C2.8048 13.9815 2.65648 13.5034 2.61764 12.628C2.57526 11.6788 2.56467 11.3941 2.56467 8.99291C2.56467 6.58824 2.57526 6.30347 2.61764 5.35778C2.65648 4.47888 2.8048 4.00427 2.92839 3.68787C3.09083 3.26951 3.28858 2.96717 3.60287 2.65428C3.92068 2.33787 4.22084 2.14452 4.64106 1.9828C4.95888 1.85975 5.43913 1.7121 6.31842 1.67343C7.26834 1.63124 7.55437 1.62069 9.96977 1.62069ZM9.96977 0C7.51553 0 7.2083 0.0105468 6.24427 0.052734C5.28376 0.0949212 4.62341 0.249608 4.05134 0.471091C3.45455 0.70312 2.94958 1.00898 2.44814 1.51171C1.94317 2.01092 1.63594 2.51366 1.40288 3.10428C1.18041 3.67732 1.02503 4.33122 0.982657 5.28746C0.940281 6.25074 0.929688 6.5566 0.929688 8.99994C0.929688 11.4433 0.940281 11.7491 0.982657 12.7089C1.02503 13.6651 1.18041 14.3226 1.40288 14.8921C1.63594 15.4862 1.94317 15.989 2.44814 16.4882C2.94958 16.9874 3.45455 17.2968 4.04781 17.5253C4.62341 17.7468 5.28023 17.9014 6.24073 17.9436C7.20477 17.9858 7.51199 17.9964 9.96623 17.9964C12.4205 17.9964 12.7277 17.9858 13.6917 17.9436C14.6522 17.9014 15.3126 17.7468 15.8847 17.5253C16.4779 17.2968 16.9829 16.9874 17.4843 16.4882C17.9858 15.989 18.2965 15.4862 18.5261 14.8956C18.7485 14.3226 18.9039 13.6687 18.9463 12.7124C18.9887 11.7527 18.9993 11.4468 18.9993 9.00346C18.9993 6.56011 18.9887 6.25425 18.9463 5.2945C18.9039 4.33825 18.7485 3.68083 18.5261 3.11131C18.3036 2.51365 17.9964 2.01092 17.4914 1.51171C16.99 1.01249 16.485 0.70312 15.8917 0.474606C15.3161 0.253123 14.6593 0.0984368 13.6988 0.0562496C12.7312 0.0105468 12.424 0 9.96977 0Z\\\" fill=\\\"#99A1B7\\\"><\\/path>\\r\\n                                            <path d=\\\"M9.97176 4.37683C7.40805 4.37683 5.32812 6.44752 5.32812 8.99985C5.32812 11.5522 7.40805 13.6229 9.97176 13.6229C12.5355 13.6229 14.6154 11.5522 14.6154 8.99985C14.6154 6.44752 12.5355 4.37683 9.97176 4.37683ZM9.97176 11.9987C8.30853 11.9987 6.95958 10.6557 6.95958 8.99985C6.95958 7.344 8.30853 6.00104 9.97176 6.00104C11.635 6.00104 12.9839 7.344 12.9839 8.99985C12.9839 10.6557 11.635 11.9987 9.97176 11.9987Z\\\" fill=\\\"#99A1B7\\\"><\\/path>\\r\\n                                            <path d=\\\"M15.883 4.19401C15.883 4.79166 15.3957 5.2733 14.7989 5.2733C14.1986 5.2733 13.7148 4.78814 13.7148 4.19401C13.7148 3.59635 14.2022 3.11472 14.7989 3.11472C15.3957 3.11472 15.883 3.59987 15.883 4.19401Z\\\" fill=\\\"#99A1B7\\\"><\\/path>\\r\\n                                        <\\/g>\\r\\n                                        <defs>\\r\\n                                            <clipPath id=\\\"clip0_1429_7965\\\">\\r\\n                                                <rect width=\\\"18.0802\\\" height=\\\"17.9999\\\" fill=\\\"white\\\" transform=\\\"translate(0.929688)\\\"><\\/rect>\\r\\n                                            <\\/clipPath>\\r\\n                                        <\\/defs>\\r\\n                                    <\\/svg>\\r\\n                                <\\/span>\\r\\n                            <\\/a>\\r\\n                        <\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n    <\\/main>\"}', 'Payment Conformation', 'Payment Completed.', '1684135777', '2024-09-21 07:30:35', '2025-03-25 02:01:20'),
(3, 'forget-password', 0, NULL, '[\"user\"]', '{\"user\":\"0\"}', '{\"user\":\"1\"}', '{\"user\":\"Forgot password verification code\"}', '{\"user\":\"<main style=\\\"background: #fafafa;\\\">\\r\\n        <div style=\\\"max-width: 640px; width: 100%; margin: 0 auto; background: #ffffff;\\\" bis_skin_checked=\\\"1\\\">\\r\\n            <div style=\\\"padding: 40px 48px;\\\" bis_skin_checked=\\\"1\\\">\\r\\n                <div style=\\\"margin-bottom: 30px;\\\" bis_skin_checked=\\\"1\\\">\\r\\n                    <img src=\\\"{{get_image(get_settings(\'logo\'))}}\\\" alt=\\\"\\\">\\r\\n                <\\/div>\\r\\n                <div style=\\\"margin: 30px 0; border-top: 1px solid #dbdfeb;\\\" bis_skin_checked=\\\"1\\\">\\r\\n                    <h1 style=\\\"margin: 30px 0 24px 0; font-weight: 600; font-size: 24px; line-height: 24px; color: #212534;\\\">Confirm your email address<\\/h1>\\r\\n                    <div style=\\\"font-weight: 400; font-size: 16px; line-height: 24px; color: #6d718c;\\\" bis_skin_checked=\\\"1\\\">\\r\\n                        <p>Hi [client_name],<\\/p>\\r\\n                        <p style=\\\"margin-bottom: 24px;\\\">We are glad to have you onboard! You are already on your way to creating beautiful visual products.<\\/p>\\r\\n                        <p style=\\\"margin: 0;\\\">Whether you are here for your brand, for a cause, or just for fun welcome! If there is anything you need, we will be here every step of the way.<\\/p>\\r\\n                    <\\/div>\\r\\n                    <a href=\\\"[forget_password_link]\\\" style=\\\"display: inline-block; background: #1b84ff; text-decoration: none; font-weight: 600; border-radius: 6px; color: #ffffff; font-size: 14px; padding: 19px 45px; margin-top: 24px;\\\">Confirm Email Address<\\/a>\\r\\n                <\\/div>\\r\\n                <div style=\\\"font-weight: 500; font-size: 16px; line-height: 24px; color: #212534; \\\" bis_skin_checked=\\\"1\\\">\\r\\n                    <p style=\\\"margin-bottom: 24px;\\\">This email was sent to <a href=\\\"mainto:[admin_email]\\\" style=\\\"color: #1b84ff;\\\">[admin_email]<\\/a>. If you did rather not receive this kind of email. Do not want any more emails from Notable?<a href=\\\"#\\\" style=\\\"color: #1b84ff;\\\">Unsubscribe<\\/a>.\\r\\n                    <\\/p>\\r\\n                    <p style=\\\"margin: 0;\\\">\\r\\n                        [address]\\r\\n                    <\\/p>\\r\\n                    <div style=\\\"display: flex; align-items: center; justify-content: space-between;\\\" bis_skin_checked=\\\"1\\\">\\r\\n                        <span>[footer_text]<\\/span>\\r\\n                        <div style=\\\"display: flex; align-items: center; gap: 16px;\\\" bis_skin_checked=\\\"1\\\">\\r\\n                            <a href=\\\"#\\\">\\r\\n                                <span>\\r\\n                                    <svg width=\\\"19\\\" height=\\\"18\\\" viewBox=\\\"0 0 19 18\\\" fill=\\\"none\\\" xmlns=\\\"http:\\/\\/www.w3.org\\/2000\\/svg\\\">\\r\\n                                        <g clip-path=\\\"url(#clip0_1429_7943)\\\">\\r\\n                                            <path d=\\\"M18.902 8.99994C18.902 4.02941 14.6706 0 9.45099 0C4.23135 0 0 4.02941 0 8.99994C0 13.492 3.45607 17.2154 7.97427 17.8905V11.6015H5.57461V8.99994H7.97427V7.01714C7.97427 4.76153 9.38528 3.5156 11.5441 3.5156C12.5778 3.5156 13.6596 3.69138 13.6596 3.69138V5.90621H12.4679C11.2939 5.90621 10.9277 6.60001 10.9277 7.31245V8.99994H13.5489L13.1299 11.6015H10.9277V17.8905C15.4459 17.2154 18.902 13.492 18.902 8.99994Z\\\" fill=\\\"#99A1B7\\\"><\\/path>\\r\\n                                        <\\/g>\\r\\n                                        <defs>\\r\\n                                            <clipPath id=\\\"clip0_1429_7943\\\">\\r\\n                                                <rect width=\\\"18.902\\\" height=\\\"17.9999\\\" fill=\\\"white\\\"><\\/rect>\\r\\n                                            <\\/clipPath>\\r\\n                                        <\\/defs>\\r\\n                                    <\\/svg>\\r\\n                                <\\/span>\\r\\n                            <\\/a>\\r\\n                            <a href=\\\"#\\\" style=\\\"display: flex; align-items: center; gap: 16px;\\\">\\r\\n                                <span>\\r\\n                                    <svg width=\\\"20\\\" height=\\\"18\\\" viewBox=\\\"0 0 20 18\\\" fill=\\\"none\\\" xmlns=\\\"http:\\/\\/www.w3.org\\/2000\\/svg\\\">\\r\\n                                        <g clip-path=\\\"url(#clip0_1429_7963)\\\">\\r\\n                                            <path d=\\\"M12.1865 7.62924L19.1179 0.0491333H17.4754L11.4568 6.63083L6.6498 0.0491333H1.10547L8.37463 10.0018L1.10547 17.9507H2.7481L9.10387 11.0002L14.1804 17.9507H19.7248L12.1861 7.62924H12.1865ZM9.93668 10.0895L9.20017 9.09845L3.33996 1.21244H5.86293L10.5922 7.5767L11.3287 8.56776L17.4762 16.8403H14.9532L9.93668 10.0899V10.0895Z\\\" fill=\\\"#99A1B7\\\"><\\/path>\\r\\n                                        <\\/g>\\r\\n                                        <defs>\\r\\n                                            <clipPath id=\\\"clip0_1429_7963\\\">\\r\\n                                                <rect width=\\\"19.0285\\\" height=\\\"17.9016\\\" fill=\\\"white\\\" transform=\\\"translate(0.902344 0.0491333)\\\"><\\/rect>\\r\\n                                            <\\/clipPath>\\r\\n                                        <\\/defs>\\r\\n                                    <\\/svg>\\r\\n                                <\\/span>\\r\\n                            <\\/a>\\r\\n                            <a href=\\\"#\\\">\\r\\n                                <span>\\r\\n                                    <svg width=\\\"20\\\" height=\\\"18\\\" viewBox=\\\"0 0 20 18\\\" fill=\\\"none\\\" xmlns=\\\"http:\\/\\/www.w3.org\\/2000\\/svg\\\">\\r\\n                                        <g clip-path=\\\"url(#clip0_1429_7965)\\\">\\r\\n                                            <path d=\\\"M9.96977 1.62069C12.3852 1.62069 12.6712 1.63124 13.6211 1.67343C14.5039 1.7121 14.9807 1.85975 15.2985 1.9828C15.7187 2.14452 16.0224 2.34139 16.3367 2.65428C16.6545 2.97068 16.8487 3.26951 17.0111 3.68787C17.1347 4.00427 17.283 4.48239 17.3219 5.35778C17.3643 6.30699 17.3749 6.59175 17.3749 8.99291C17.3749 11.3976 17.3643 11.6823 17.3219 12.628C17.283 13.5069 17.1347 13.9815 17.0111 14.298C16.8487 14.7163 16.6509 15.0186 16.3367 15.3315C16.0188 15.6479 15.7187 15.8413 15.2985 16.003C14.9807 16.1261 14.5004 16.2737 13.6211 16.3124C12.6677 16.3546 12.3816 16.3651 9.96977 16.3651C7.55437 16.3651 7.26834 16.3546 6.31842 16.3124C5.4356 16.2737 4.95888 16.1261 4.64106 16.003C4.22084 15.8413 3.91715 15.6444 3.60287 15.3315C3.28505 15.0151 3.09083 14.7163 2.92839 14.298C2.8048 13.9815 2.65648 13.5034 2.61764 12.628C2.57526 11.6788 2.56467 11.3941 2.56467 8.99291C2.56467 6.58824 2.57526 6.30347 2.61764 5.35778C2.65648 4.47888 2.8048 4.00427 2.92839 3.68787C3.09083 3.26951 3.28858 2.96717 3.60287 2.65428C3.92068 2.33787 4.22084 2.14452 4.64106 1.9828C4.95888 1.85975 5.43913 1.7121 6.31842 1.67343C7.26834 1.63124 7.55437 1.62069 9.96977 1.62069ZM9.96977 0C7.51553 0 7.2083 0.0105468 6.24427 0.052734C5.28376 0.0949212 4.62341 0.249608 4.05134 0.471091C3.45455 0.70312 2.94958 1.00898 2.44814 1.51171C1.94317 2.01092 1.63594 2.51366 1.40288 3.10428C1.18041 3.67732 1.02503 4.33122 0.982657 5.28746C0.940281 6.25074 0.929688 6.5566 0.929688 8.99994C0.929688 11.4433 0.940281 11.7491 0.982657 12.7089C1.02503 13.6651 1.18041 14.3226 1.40288 14.8921C1.63594 15.4862 1.94317 15.989 2.44814 16.4882C2.94958 16.9874 3.45455 17.2968 4.04781 17.5253C4.62341 17.7468 5.28023 17.9014 6.24073 17.9436C7.20477 17.9858 7.51199 17.9964 9.96623 17.9964C12.4205 17.9964 12.7277 17.9858 13.6917 17.9436C14.6522 17.9014 15.3126 17.7468 15.8847 17.5253C16.4779 17.2968 16.9829 16.9874 17.4843 16.4882C17.9858 15.989 18.2965 15.4862 18.5261 14.8956C18.7485 14.3226 18.9039 13.6687 18.9463 12.7124C18.9887 11.7527 18.9993 11.4468 18.9993 9.00346C18.9993 6.56011 18.9887 6.25425 18.9463 5.2945C18.9039 4.33825 18.7485 3.68083 18.5261 3.11131C18.3036 2.51365 17.9964 2.01092 17.4914 1.51171C16.99 1.01249 16.485 0.70312 15.8917 0.474606C15.3161 0.253123 14.6593 0.0984368 13.6988 0.0562496C12.7312 0.0105468 12.424 0 9.96977 0Z\\\" fill=\\\"#99A1B7\\\"><\\/path>\\r\\n                                            <path d=\\\"M9.97176 4.37683C7.40805 4.37683 5.32812 6.44752 5.32812 8.99985C5.32812 11.5522 7.40805 13.6229 9.97176 13.6229C12.5355 13.6229 14.6154 11.5522 14.6154 8.99985C14.6154 6.44752 12.5355 4.37683 9.97176 4.37683ZM9.97176 11.9987C8.30853 11.9987 6.95958 10.6557 6.95958 8.99985C6.95958 7.344 8.30853 6.00104 9.97176 6.00104C11.635 6.00104 12.9839 7.344 12.9839 8.99985C12.9839 10.6557 11.635 11.9987 9.97176 11.9987Z\\\" fill=\\\"#99A1B7\\\"><\\/path>\\r\\n                                            <path d=\\\"M15.883 4.19401C15.883 4.79166 15.3957 5.2733 14.7989 5.2733C14.1986 5.2733 13.7148 4.78814 13.7148 4.19401C13.7148 3.59635 14.2022 3.11472 14.7989 3.11472C15.3957 3.11472 15.883 3.59987 15.883 4.19401Z\\\" fill=\\\"#99A1B7\\\"><\\/path>\\r\\n                                        <\\/g>\\r\\n                                        <defs>\\r\\n                                            <clipPath id=\\\"clip0_1429_7965\\\">\\r\\n                                                <rect width=\\\"18.0802\\\" height=\\\"17.9999\\\" fill=\\\"white\\\" transform=\\\"translate(0.929688)\\\"><\\/rect>\\r\\n                                            <\\/clipPath>\\r\\n                                        <\\/defs>\\r\\n                                    <\\/svg>\\r\\n                                <\\/span>\\r\\n                            <\\/a>\\r\\n                        <\\/div>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n    <\\/main><br>\"}', 'Forgot password mail', 'It is permanently enabled for student email verification.', '1684145383', '2024-09-21 07:30:35', '2025-04-24 04:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `offline_payments`
--

CREATE TABLE `offline_payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `payment_purpose` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `keys` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `test_mode` int(11) DEFAULT NULL,
  `is_addon` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `identifier`, `currency`, `title`, `model_name`, `description`, `keys`, `status`, `test_mode`, `is_addon`, `created_at`, `updated_at`) VALUES
(1, 'paypal', 'DKK', 'Paypal', 'Paypal', '', '{\"sandbox_client_id\":\"AfGaziKslex-scLAyYdDYXNFaz2aL5qGau-SbDgE_D2E80D3AFauLagP8e0kCq9au7W4IasmFbirUUYc\",\"sandbox_secret_key\":\"EMa5pCTuOpmHkhHaCGibGhVUcKg0yt5-C3CzJw-OWJCzaXXzTlyD17SICob_BkfM_0Nlk7TWnN42cbGz\",\"production_client_id\":\"12345\",\"production_secret_key\":\"12345\"}', 1, 0, 0, '2024-09-21 02:30:23', '2025-03-09 05:40:42'),
(2, 'stripe', 'USD', 'Stripe', 'StripePay', '', '{\"public_key\":\"pk_test_c6VvBEbwHFdulFZ62q1IQrar\",\"secret_key\":\"sk_test_9IMkiM6Ykxr1LCe2dJ3PgaxS\",\"public_live_key\":\"pk_live_xxxxxxxxxxxxxxxxxxxxxxxx\",\"secret_live_key\":\"sk_live_xxxxxxxxxxxxxxxxxxxxxxxx\"}', 1, 1, 0, '2024-09-21 02:30:23', '2025-01-19 01:39:07'),
(3, 'razorpay', 'USD', 'Razorpay', 'Razorpay', '', '{\"public_key\":\"rzp_test_J60bqBOi1z1aF5\",\"secret_key\":\"uk935K7p4j96UCJgHK8kAU4q\"}', 0, 0, 0, '2024-09-21 02:30:23', '2025-03-09 05:40:48'),
(4, 'flutterwave', 'USD', 'Flutterwave', 'Flutterwave', '', '{\"public_key\":\"FLWPUBK_TEST-48dfbeb50344ecd8bc075b4ffe9ba266-X\",\"secret_key\":\"FLWSECK_TEST-1691582e23bd6ee4fb04213ec0b862dd-X\"}', 1, 1, 0, '2024-09-21 02:30:23', '2024-11-18 05:42:16'),
(5, 'paytm', 'USD', 'Paytm', 'Paytm', '', '{\"public_key\":\"ApLWOX88722132489587\",\"secret_key\":\"#iFa7&W_C50VL@aT\"}', 1, 1, 0, '2024-09-21 02:30:23', '2024-11-18 05:42:22'),
(6, 'offline', 'USD', 'Offline Payment', 'OfflinePayment', NULL, '{\"bank_information\":\"Write your bank information and instructions here\"}', 1, 0, 0, '2024-09-25 05:50:15', '2024-11-18 05:59:46'),
(7, 'paystack', 'USD', 'Paystack', 'Paystack', NULL, '{\"secret_test_key\":\"sk_test_c746060e693dd50c6f397dffc6c3b2f655217c94\",\"public_test_key\":\"pk_test_0816abbed3c339b8473ff22f970c7da1c78cbe1b\",\"secret_live_key\":\"sk_live_xxxxxxxxxxxxxxxxxxxxxxxxx\",\"public_live_key\":\"pk_live_xxxxxxxxxxxxxxxxxxxxxxxxx\"}', 1, 1, 0, '2024-10-22 05:57:14', '2024-11-18 05:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `payment_histories`
--

CREATE TABLE `payment_histories` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `project_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `date_added` int(11) DEFAULT NULL,
  `last_modified` int(11) DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_purpose` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_purposes`
--

CREATE TABLE `payment_purposes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_for` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `function_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_purposes`
--

INSERT INTO `payment_purposes` (`id`, `title`, `model`, `pay_for`, `function_name`, `created_at`, `updated_at`) VALUES
(1, 'invoice', 'Invoice', 'Invoice Payment', 'payment_invoice', '2024-12-25 07:30:46', '2024-12-25 07:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `route`, `created_at`, `updated_at`) VALUES
(2, 'project list', 'projects', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(3, 'project create', 'project.create', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(4, 'project store', 'project.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(5, 'project delete', 'project.delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(6, 'project edit', 'project.edit', '2025-01-09 12:15:21', '2025-01-09 12:15:21'),
(8, 'project details dashboard', 'project.details', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(9, 'project multi-delete', 'project.multi-delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(10, 'project category list', 'project.categories', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(11, 'project category create', 'project.category.create', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(12, 'project category store', 'staff.project.category.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(13, 'project category delete', 'project.category.delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(14, 'project category edit', 'project.category.edit', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(15, 'project milestone list', 'milestones', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(16, 'project milestone create', 'milestone.create', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(17, 'project milestone store', 'milestone.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(18, 'project milestone delete', 'milestone.delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(19, 'project milestone edit', 'milestone.edit', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(21, 'project milestone multi-delete', 'milestone.multi-delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(23, 'project task list', 'tasks', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(24, 'project task create', 'task.create', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(25, 'project task store', 'task.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(26, 'project task delete', 'task.delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(27, 'project task edit', 'task.edit', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(29, 'project task multi-delete', 'task.multi-delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(31, 'project gantt_chart', 'gantt_chart', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(32, 'project file list', 'files', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(33, 'project file create', 'file.create', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(34, 'project file store', 'file.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(35, 'project file delete', 'file.delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(36, 'project file edit', 'file.edit', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(38, 'project file multi-delete', 'file.multi-delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(39, 'project file download', 'file.download', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(49, 'project meeting list', 'meetings', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(50, 'project meeting create', 'meeting.create', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(51, 'project meeting store', 'meeting.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(52, 'project meeting delete', 'meeting.delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(53, 'project meeting edit', 'meeting.edit', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(55, 'project meeting multi-delete', 'meeting.multi-delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(57, 'project invoice list', 'invoice', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(58, 'project invoice create', 'invoice.create', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(59, 'project invoice store', 'invoice.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(60, 'project invoice delete', 'invoice.delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(61, 'project invoice edit', 'invoice.edit', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(63, 'project invoice multi-delete', 'invoice.multi-delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(64, 'project timesheet list', 'timesheets', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(65, 'project timesheet create', 'timesheet.create', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(66, 'project timesheet store', 'timesheet.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(67, 'project timesheet delete', 'timesheet.delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(68, 'project timesheet edit', 'timesheet.edit', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(70, 'project timesheet multi-delete', 'timesheet.multi-delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(76, 'event calendar', 'events', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(77, 'event create', 'event.create', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(78, 'event store', 'event.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(79, 'event delete', 'event.delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(80, 'event update', 'event.edit', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(82, 'message send', 'message.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(83, 'new message', 'message.thread.store', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(84, 'messages', 'message', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(338, 'project report', 'report.project', '2025-01-09 05:17:12', '2025-01-09 05:17:12'),
(339, 'client report', 'report.client', '2025-01-09 05:17:12', '2025-01-09 05:17:12'),
(340, 'system_settings.update', 'system_settings.update', '2025-01-09 05:21:26', '2025-01-09 05:21:26'),
(341, 'system_settings', 'system_settings', '2025-01-09 05:21:26', '2025-01-09 05:21:26'),
(342, 'payment_settings.update', 'payment_settings.update', '2025-01-09 05:22:15', '2025-01-09 05:22:15'),
(343, 'payment_settings', 'payment_settings', '2025-01-09 05:22:15', '2025-01-09 05:22:15'),
(344, 'notification_settings.store', 'notification_settings.store', '2025-01-09 05:23:19', '2025-01-09 05:23:19'),
(345, 'notification_settings', 'notification_settings', '2025-01-09 05:23:19', '2025-01-09 05:23:19'),
(346, 'manage_language', 'manage_language', '2025-01-09 05:24:45', '2025-01-09 05:24:45'),
(347, 'language.store', 'language.store', '2025-01-09 05:24:45', '2025-01-09 05:24:45'),
(348, 'language.import', 'language.import', '2025-01-09 05:25:41', '2025-01-09 05:25:41'),
(349, 'language.delete', 'language.delete', '2025-01-09 05:25:41', '2025-01-09 05:25:41'),
(350, 'language.direction.update', 'language.direction.update', '2025-01-09 05:26:28', '2025-01-09 05:26:28'),
(351, 'language phrase edit', 'language.phrase.edit', '2025-01-09 05:28:06', '2025-01-09 05:28:06'),
(352, 'language phrase update', 'language.phrase.update', '2025-01-09 05:28:06', '2025-01-09 05:28:06'),
(353, 'language phrase import', 'language.phrase.import', '2025-01-09 05:28:40', '2025-01-09 05:28:40'),
(354, 'offline payments', 'offline.payments', '2025-01-09 05:33:09', '2025-01-09 05:33:09'),
(355, 'offline payment doc', 'offline.payment.doc', '2025-01-09 05:33:09', '2025-01-09 05:33:09'),
(356, 'offline payment accept', 'offline.payment.accept', '2025-01-09 05:33:09', '2025-01-09 05:33:09'),
(357, 'offline payment decline', 'offline.payment.decline', '2025-01-09 05:33:09', '2025-01-09 05:33:09'),
(358, 'payment offline store', 'payment.offline.store', '2025-01-09 05:33:09', '2025-01-09 05:33:09'),
(359, 'select language', 'select.language', '2025-01-09 05:33:09', '2025-01-09 05:33:09'),
(360, 'manage profile', 'manage.profile', '2025-01-19 12:21:43', '2025-01-19 12:21:43'),
(361, 'profile update', 'manage.profile.update', '2025-01-19 12:21:43', '2025-01-19 12:21:43'),
(362, 'offline payment', 'report.offline.payment', '2025-01-19 12:27:19', '2025-01-19 12:27:19'),
(363, 'project category delete', 'project.category.multi-delete', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(364, 'project milestone update', 'milestone.update', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(365, 'project task Update', 'task.update', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(366, 'project file update', 'file.update', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(367, 'project meeting Update', 'meeting.update', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(368, 'project invoice update', 'invoice.update', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(369, 'event update', 'event.update', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(370, 'project timesheet update', 'timesheet.update', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(372, 'payment history', 'report.payment.history', '2025-01-19 12:27:19', '2025-01-19 12:27:19'),
(373, 'project category Update', 'project.category.update', '2024-12-21 04:21:55', '2024-12-21 04:21:55'),
(374, 'project Update', 'project.update', '2025-01-09 12:15:21', '2025-01-09 12:15:21'),
(375, 'project task duplication', 'task.duplicate', '2024-12-21 04:21:55', '2024-12-21 04:21:55');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `category_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staffs` json DEFAULT NULL,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress` float(10,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `privacy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp_start` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `timestamp_end` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

CREATE TABLE `project_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` float(10,2) DEFAULT NULL,
  `timestamp_start` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `timestamp_end` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_invoices`
--

CREATE TABLE `project_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `due_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` longtext COLLATE utf8mb4_unicode_ci,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp_start` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `timestamp_end` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_meetings`
--

CREATE TABLE `project_meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agenda` text COLLATE utf8mb4_unicode_ci,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_data` text COLLATE utf8mb4_unicode_ci,
  `timestamp_meeting` timestamp NULL DEFAULT NULL,
  `timestamp_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_milestones`
--

CREATE TABLE `project_milestones` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `tasks` json DEFAULT NULL,
  `progress` int(11) DEFAULT NULL,
  `timestamp_start` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `timestamp_end` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_payments`
--

CREATE TABLE `project_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp_start` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `timestamp_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_tasks`
--

CREATE TABLE `project_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress` float(10,2) DEFAULT NULL,
  `team` json DEFAULT NULL,
  `start_date` int(11) DEFAULT NULL,
  `end_date` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_timesheets`
--

CREATE TABLE `project_timesheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `staff` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp_start` timestamp NULL DEFAULT NULL,
  `timestamp_end` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2024-08-24 11:11:01', '2024-08-24 11:11:01'),
(2, 'client', '2024-08-26 05:09:30', '2024-08-26 05:09:30'),
(3, 'staff', '2024-08-27 04:53:35', '2024-08-27 04:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, '3', '10', '2025-02-27 01:36:32', '2025-02-27 01:36:32'),
(5, '3', '2', '2025-02-27 01:36:44', '2025-02-27 01:36:44'),
(6, '3', '3', '2025-02-27 01:36:46', '2025-02-27 01:36:46'),
(8, '3', '8', '2025-02-27 01:36:51', '2025-02-27 01:36:51'),
(10, '3', '374', '2025-02-27 01:36:53', '2025-02-27 01:36:53'),
(11, '3', '15', '2025-02-27 01:36:55', '2025-02-27 01:36:55'),
(12, '3', '16', '2025-02-27 01:36:56', '2025-02-27 01:36:56'),
(13, '3', '364', '2025-02-27 01:36:59', '2025-02-27 01:36:59'),
(14, '3', '23', '2025-02-27 01:37:00', '2025-02-27 01:37:00'),
(15, '3', '24', '2025-02-27 01:37:00', '2025-02-27 01:37:00'),
(16, '3', '365', '2025-02-27 01:37:01', '2025-02-27 01:37:01'),
(17, '3', '32', '2025-02-27 01:37:03', '2025-02-27 01:37:03'),
(18, '3', '33', '2025-02-27 01:37:04', '2025-02-27 01:37:04'),
(21, '3', '49', '2025-02-27 01:37:07', '2025-02-27 01:37:07'),
(22, '3', '50', '2025-02-27 01:37:09', '2025-02-27 01:37:09'),
(23, '3', '367', '2025-02-27 01:37:10', '2025-02-27 01:37:10'),
(24, '3', '57', '2025-02-27 01:37:11', '2025-02-27 01:37:11'),
(25, '3', '58', '2025-02-27 01:37:11', '2025-02-27 01:37:11'),
(26, '3', '368', '2025-02-27 01:37:12', '2025-02-27 01:37:12'),
(30, '3', '64', '2025-02-27 01:37:20', '2025-02-27 01:37:20'),
(31, '3', '65', '2025-02-27 01:37:21', '2025-02-27 01:37:21'),
(32, '3', '370', '2025-02-27 01:37:21', '2025-02-27 01:37:21'),
(41, '3', '360', '2025-02-27 01:37:38', '2025-02-27 01:37:38'),
(42, '3', '361', '2025-02-27 01:37:39', '2025-02-27 01:37:39'),
(43, '2', '2', '2025-02-27 01:40:05', '2025-02-27 01:40:05'),
(44, '2', '8', '2025-02-27 01:40:08', '2025-02-27 01:40:08'),
(46, '2', '15', '2025-02-27 01:40:12', '2025-02-27 01:40:12'),
(47, '2', '23', '2025-02-27 01:40:16', '2025-02-27 01:40:16'),
(48, '2', '32', '2025-02-27 01:40:17', '2025-02-27 01:40:17'),
(49, '2', '33', '2025-02-27 01:40:21', '2025-02-27 01:40:21'),
(50, '2', '35', '2025-02-27 01:40:21', '2025-02-27 01:40:21'),
(51, '2', '366', '2025-02-27 01:40:22', '2025-02-27 01:40:22'),
(52, '2', '39', '2025-02-27 01:40:23', '2025-02-27 01:40:23'),
(53, '2', '49', '2025-02-27 01:40:24', '2025-02-27 01:40:24'),
(54, '2', '57', '2025-02-27 01:40:29', '2025-02-27 01:40:29'),
(55, '2', '76', '2025-02-27 01:40:32', '2025-02-27 01:40:32'),
(56, '2', '64', '2025-02-27 01:40:38', '2025-02-27 01:40:38'),
(57, '2', '82', '2025-02-27 01:40:39', '2025-02-27 01:40:39'),
(58, '2', '83', '2025-02-27 01:40:40', '2025-02-27 01:40:40'),
(59, '2', '84', '2025-02-27 01:40:40', '2025-02-27 01:40:40'),
(61, '2', '339', '2025-02-27 01:40:45', '2025-02-27 01:40:45'),
(62, '2', '362', '2025-02-27 01:40:48', '2025-02-27 01:40:48'),
(63, '2', '372', '2025-02-27 01:40:49', '2025-02-27 01:40:49'),
(64, '2', '360', '2025-02-27 01:40:50', '2025-02-27 01:40:50'),
(65, '2', '361', '2025-02-27 01:40:51', '2025-02-27 01:40:51'),
(70, '2', '367', '2025-03-09 01:16:09', '2025-03-09 01:16:09'),
(71, '2', '52', '2025-03-09 01:16:10', '2025-03-09 01:16:10'),
(72, '1', '2', '2025-03-10 23:34:44', '2025-03-10 23:34:44'),
(73, '1', '10', '2025-03-10 23:34:49', '2025-03-10 23:34:49'),
(74, '1', '23', '2025-03-10 23:35:07', '2025-03-10 23:35:07'),
(76, '1', '375', '2025-03-23 05:10:32', '2025-03-23 05:10:32'),
(78, '3', '11', '2025-05-05 03:32:28', '2025-05-05 03:32:28'),
(80, '3', '373', '2025-05-05 03:33:00', '2025-05-05 03:33:00'),
(86, '3', '375', '2025-05-05 03:56:37', '2025-05-05 03:56:37'),
(98, '3', '82', '2025-05-05 04:12:20', '2025-05-05 04:12:20'),
(99, '3', '83', '2025-05-05 04:12:20', '2025-05-05 04:12:20'),
(100, '3', '84', '2025-05-05 04:12:26', '2025-05-05 04:12:26'),
(102, '3', '76', '2025-05-05 04:12:58', '2025-05-05 04:12:58'),
(107, '3', '79', '2025-05-05 04:18:20', '2025-05-05 04:18:20'),
(111, '3', '339', '2025-05-05 04:19:24', '2025-05-05 04:19:24'),
(112, '3', '362', '2025-05-05 04:19:25', '2025-05-05 04:19:25'),
(113, '3', '372', '2025-05-05 04:19:26', '2025-05-05 04:19:26'),
(114, '3', '369', '2025-05-05 04:19:32', '2025-05-05 04:19:32'),
(115, '3', '77', '2025-05-05 04:19:34', '2025-05-05 04:19:34'),
(116, '3', '60', '2025-05-05 04:19:34', '2025-05-05 04:19:34'),
(117, '3', '67', '2025-05-05 04:19:37', '2025-05-05 04:19:37'),
(118, '3', '35', '2025-05-05 04:19:39', '2025-05-05 04:19:39'),
(119, '3', '39', '2025-05-05 04:19:40', '2025-05-05 04:19:40'),
(120, '3', '366', '2025-05-05 04:19:41', '2025-05-05 04:19:41'),
(122, '3', '26', '2025-05-05 04:19:45', '2025-05-05 04:19:45'),
(123, '3', '18', '2025-05-05 04:19:47', '2025-05-05 04:19:47');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'language', 'english', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(2, 'system_name', 'Insight CRM', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(3, 'system_title', 'Project Manager', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(4, 'system_email', 'academy@example.com', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(5, 'address', 'Sydney, dfsdf', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(6, 'phone', '+143-52-9933631', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(7, 'purchase_code', 'enter-your-valid-purchase-code', '2024-09-20 13:28:19', '2025-03-09 05:48:50'),
(8, 'paypal', '[{\"active\":\"1\",\"mode\":\"sandbox\",\"sandbox_client_id\":\"AfGaziKslex-scLAyYdDYXNFaz2aL5qGau-SbDgE_D2E80D3AFauLagP8e0kCq9au7W4IasmFbirUUYc\",\"sandbox_secret_key\":\"EMa5pCTuOpmHkhHaCGibGhVUcKg0yt5-C3CzJw-OWJCzaXXzTlyD17SICob_BkfM_0Nlk7TWnN42cbGz\",\"production_client_id\":\"1234\",\"production_secret_key\":\"12345\"}]', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(9, 'stripe_keys', '[{\"active\":\"1\",\"testmode\":\"on\",\"public_key\":\"pk_test_CAC3cB1mhgkJqXtypYBTGb4f\",\"secret_key\":\"sk_test_iatnshcHhQVRXdygXw3L2Pp2\",\"public_live_key\":\"pk_live_xxxxxxxxxxxxxxxxxxxxxxxx\",\"secret_live_key\":\"sk_live_xxxxxxxxxxxxxxxxxxxxxxxx\"}]', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(10, 'youtube_api_key', 'AIzaSyDthDJK7F5kKCDIcZeSFxU4rx9s3DSaBAU', '2024-09-20 13:28:19', '2024-10-29 23:31:19'),
(11, 'vimeo_api_key', '39258384b69994dba483c10286825b5c', '2024-09-20 13:28:19', '2024-10-29 23:31:19'),
(12, 'slogan', 'A course based video CMS', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(13, 'text_align', NULL, '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(14, 'allow_instructor', '1', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(15, 'instructor_revenue', '70', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(16, 'system_currency', 'USD', '2024-09-20 13:28:19', '2025-03-09 05:40:35'),
(17, 'paypal_currency', 'USD', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(18, 'stripe_currency', 'USD', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(19, 'author', 'Creativeitem', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(20, 'currency_position', 'right', '2024-09-20 13:28:19', '2025-03-09 05:40:35'),
(21, 'website_description', 'Talemy is your ideal education the WordPress theme for sharing and selling your knowledge online. Teach what you love. Talemy gives you the tools.', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(22, 'website_keywords', 'CRM,Project Managem', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(23, 'footer_text', '2022 @ By Creativeitem', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(24, 'footer_link', 'https://creativeitem.com/', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(25, 'protocol', 'smtp', '2024-09-20 13:28:19', '2025-03-09 05:41:23'),
(26, 'smtp_host', 'smtp.gmail.com', '2024-09-20 13:28:19', '2025-03-09 05:41:24'),
(27, 'smtp_port', '587', '2024-09-20 13:28:19', '2025-03-09 05:41:24'),
(28, 'smtp_user', 'roky.creativeitem@gmail.com', '2024-09-20 13:28:19', '2025-03-09 05:41:24'),
(29, 'smtp_pass', 'wegqskvpctybwvqm', '2024-09-20 13:28:19', '2025-03-09 05:41:24'),
(30, 'version', '1.1', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(31, 'student_email_verification', '0', '2024-09-20 13:28:19', '2024-10-29 23:31:19'),
(32, 'instructor_application_note', 'Fill all the fields carefully and share if you want to share any document with us it will help us to evaluate you as an instructor. dfdfs', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(33, 'razorpay_keys', '[{\"active\":\"1\",\"key\":\"rzp_test_J60bqBOi1z1aF5\",\"secret_key\":\"uk935K7p4j96UCJgHK8kAU4q\",\"theme_color\":\"#c7a600\"}]', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(34, 'razorpay_currency', 'USD', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(35, 'fb_app_id', 'fb-app-id', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(36, 'fb_app_secret', 'fb-app-secret', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(37, 'fb_social_login', '0', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(38, 'drip_content_settings', '{\"lesson_completion_role\":\"duration\",\"minimum_duration\":\"15:30:00\",\"minimum_percentage\":\"60\",\"locked_lesson_message\":\"<h3 xss=\\\"removed\\\" style=\\\"text-align: center; \\\"><span xss=\\\"removed\\\" style=\\\"\\\">Permission denied!<\\/span><\\/h3><p xss=\\\"removed\\\" style=\\\"text-align: center; \\\"><span xss=\\\"removed\\\">This course supports drip content, so you must complete the previous lessons.<\\/span><\\/p>\",\"files\":null}', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(41, 'course_accessibility', 'publicly', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(42, 'smtp_crypto', 'tls', '2024-09-20 13:28:19', '2025-03-09 05:41:23'),
(43, 'allowed_device_number_of_loging', '5', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(47, 'academy_cloud_access_token', 'jdfghasdfasdfasdfasdfasdf', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(48, 'course_selling_tax', '4', '2024-09-20 13:28:19', '2024-10-29 23:31:19'),
(49, 'ccavenue_keys', '[{\"active\":\"1\",\"ccavenue_merchant_id\":\"cmi_xxxxxx\",\"ccavenue_working_key\":\"cwk_xxxxxxxxxxxx\",\"ccavenue_access_code\":\"ccc_xxxxxxxxxxxxx\"}]', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(50, 'ccavenue_currency', 'INR', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(51, 'iyzico_keys', '[{\"active\":\"1\",\"testmode\":\"on\",\"iyzico_currency\":\"TRY\",\"api_test_key\":\"atk_xxxxxxxx\",\"secret_test_key\":\"stk_xxxxxxxx\",\"api_live_key\":\"alk_xxxxxxxx\",\"secret_live_key\":\"slk_xxxxxxxx\"}]', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(52, 'iyzico_currency', 'TRY', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(53, 'paystack_keys', '[{\"active\":\"1\",\"testmode\":\"on\",\"secret_test_key\":\"sk_test_c746060e693dd50c6f397dffc6c3b2f655217c94\",\"public_test_key\":\"pk_test_0816abbed3c339b8473ff22f970c7da1c78cbe1b\",\"secret_live_key\":\"sk_live_xxxxxxxxxxxxxxxxxxxxx\",\"public_live_key\":\"pk_live_xxxxxxxxxxxxxxxxxxxxx\"}]', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(54, 'paystack_currency', 'NGN', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(55, 'paytm_keys', '[{\"PAYTM_MERCHANT_KEY\":\"PAYTM_MERCHANT_KEY\",\"PAYTM_MERCHANT_MID\":\"PAYTM_MERCHANT_MID\",\"PAYTM_MERCHANT_WEBSITE\":\"DEFAULT\",\"INDUSTRY_TYPE_ID\":\"Retail\",\"CHANNEL_ID\":\"WEB\"}]', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(57, 'google_analytics_id', NULL, '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(58, 'meta_pixel_id', NULL, '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(59, 'smtp_from_email', 'roky.creativeitem@gmail.com', '2024-09-20 13:28:19', '2025-03-09 05:41:24'),
(61, 'language_dirs', '{\"english\":\"ltr\",\"hindi\":\"rtl\",\"arabic\":\"rtl\"}', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(62, 'certificate_template', 'uploads/certificate-template/1717241880-uzmHnwZb0gfTpOIP7WFaSl4BKqRMo1.png', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(63, 'certificate_builder_content', '<style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style>\n        \n\n                    <style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style>\n        \n\n                    <style>\n            @import url(\'https://fonts.googleapis.com/css2?family=Italianno&display=swap\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27\');\n            @import url(\'https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27\');\n        </style>\n        \n\n                    \n        \n\n                    \n        \n\n                    \n        \n\n                    \n        \n\n                    <div id=\"certificate-layout-module\" class=\"certificate-layout-module resizeable-canvas draggable ui-draggable ui-draggable-handle ui-resizable hidden-position\" style=\"position: relative; width: 1069.2px; height: 755.055px; left: 0px; top: -1px;\">\n                <img class=\"certificate-template\" style=\"width: 100%; height: 100%;\" src=\"https://demo.creativeitem.com/academy-laravel/public/uploads/certificate-template/1717241880-uzmHnwZb0gfTpOIP7WFaSl4BKqRMo1.png\">\n            <div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\"></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 16px; top: 125px; left: 102px; width: 84.8906px; font-family: &quot;default&quot;; height: 80px; padding: 5px !important;\">\n                {qr_code}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 18px; top: 546px; left: 125px; width: 210.031px; font-family: &quot;Pinyon Script&quot;; padding: 5px !important; height: 37px;\">\n                {instructor_name}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 18px; top: 546px; left: 724px; width: 210.188px; font-family: &quot;Pinyon Script&quot;; padding: 5px !important; height: 39px;\">\n                {student_name}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 16px; top: 545px; left: 442px; width: min-content; font-family: &quot;default&quot;; padding: 5px !important;\">\n                {course_completion_date}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 12px; top: 665px; left: 457px; width: min-content; font-family: &quot;default&quot;; padding: 5px !important;\">\n                {certificate_download_date}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 30px; top: 136px; left: 264px; width: 534.336px; font-family: &quot;default&quot;; padding: 5px !important; height: 62px;\">\n                COURSE COMPLETION CERTIFICATE\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 18px; top: 211px; left: 205px; width: 664.5px; font-family: &quot;Pinyon Script&quot;; padding: 5px !important; height: 98px;\">\n                This certificate is awarded to {student_name} in recognition of their successful completion of Course on {course_completion_date}. Your hard work, dedication, and commitment to learning have enabled you to achieve this milestone, and we are proud to recognize your accomplishment.\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\"></div></div><div class=\"draggable resizeable-canvas ui-draggable ui-draggable-handle ui-resizable\" style=\"position: absolute; font-size: 18px; top: 332px; left: 311px; width: 414.25px; font-family: &quot;default&quot;; height: 37px; padding: 5px !important;\">\n                {course_title}\n                <i class=\"remove-item fi-rr-cross-circle cursor-pointer\">\n            </i><div class=\"ui-resizable-handle ui-resizable-e\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-s\" style=\"z-index: 90;\"></div><div class=\"ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se\" style=\"z-index: 90;\"></div></div></div>', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(64, '_token', 'oCweKhYOOnY7H57Eqtan4qRnqFgW3yDEpAIMlba6', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(65, 'zoom_account_email', 'ponkojr1998@gmail.com', '2024-09-20 13:28:19', '2025-03-09 05:48:33'),
(66, 'zoom_account_id', 'RG4XYUQ3RKqu8NetilQ9UA', '2024-09-20 13:28:19', '2025-03-09 05:48:33'),
(67, 'zoom_client_id', 'mFgJ4QB0S_ue5YhRrbQ7yg', '2024-09-20 13:28:19', '2025-03-09 05:48:33'),
(68, 'zoom_client_secret', 'OZ6m9dwejrFoWywAKDGQK1mh3yRyhyl3', '2024-09-20 13:28:19', '2025-03-09 05:48:33'),
(69, 'zoom_web_sdk', 'active', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(70, 'zoom_sdk_client_id', '7M6Wg3sxRP6fRudLqqskYQ', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(71, 'zoom_sdk_client_secret', 'z1NzSPndVwGqmquWnoJgza2i2R4GJOai', '2024-09-20 13:28:19', '2024-09-20 13:28:19'),
(75, 'device_limitation', '1000000', '2024-09-20 13:28:19', '2024-10-29 23:31:19'),
(76, 'list_view_type', 'list', '2024-09-20 13:28:19', '2025-04-24 05:25:12'),
(77, 'timezone', 'Asia/Dhaka', '2025-01-02 04:32:00', '2025-01-02 10:32:00'),
(78, 'logo', 'uploads/setting/wMLqmAT4OCdlVBI5EVdt.png', '2025-01-22 04:39:15', '2025-04-29 01:22:47'),
(79, 'favicon', 'uploads/setting/R5gNcjuHwAsHdMAUmOyI.png', '2025-01-22 04:39:15', '2025-04-29 01:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skills` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biography` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addon_hooks`
--
ALTER TABLE `addon_hooks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addon_hooks_addon_id_foreign` (`addon_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_phrases`
--
ALTER TABLE `language_phrases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_phrases_language_id_index` (`language_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_threads`
--
ALTER TABLE `message_threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_thread_sender_foreign` (`contact_one`),
  ADD KEY `message_thread_receiver_foreign` (`contact_two`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offline_payments`
--
ALTER TABLE `offline_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_purposes`
--
ALTER TABLE `payment_purposes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_invoices`
--
ALTER TABLE `project_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_meetings`
--
ALTER TABLE `project_meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_milestones`
--
ALTER TABLE `project_milestones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_payments`
--
ALTER TABLE `project_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_tasks`
--
ALTER TABLE `project_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_timesheets`
--
ALTER TABLE `project_timesheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `addon_hooks`
--
ALTER TABLE `addon_hooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `language_phrases`
--
ALTER TABLE `language_phrases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_threads`
--
ALTER TABLE `message_threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `offline_payments`
--
ALTER TABLE `offline_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_purposes`
--
ALTER TABLE `payment_purposes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_invoices`
--
ALTER TABLE `project_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_meetings`
--
ALTER TABLE `project_meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_milestones`
--
ALTER TABLE `project_milestones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_payments`
--
ALTER TABLE `project_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_tasks`
--
ALTER TABLE `project_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_timesheets`
--
ALTER TABLE `project_timesheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
