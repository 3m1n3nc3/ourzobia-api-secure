-- Ourzobia DATABASE
-- version 1.0.0
-- https://ourzobiaphp.cf  

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ourzobia`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `type` varchar(128) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 

--
-- Table structure for table `analytics`
--

CREATE TABLE `analytics` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `uip` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metric` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referrer` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 

--
-- Table structure for table `banks`
--

CREATE TABLE IF NOT EXISTS `banks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longcode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_with_bank` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `is_deleted` int DEFAULT NULL,
  `country` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updatedAt` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `slug`, `code`, `longcode`, `gateway`, `pay_with_bank`, `active`, `is_deleted`, `country`, `currency`, `type`, `createdAt`, `updatedAt`) VALUES
(160, 'Access Bank', 'access-bank', '044', '044150149', 'emandate', '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:21+01:00', '2020-02-18T08:06:44.000Z'),
(161, 'Access Bank (Diamond)', 'access-bank-diamond', '063', '063150162', 'emandate', '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:21+01:00', '2020-02-18T08:06:48.000Z'),
(162, 'ALAT by WEMA', 'alat-by-wema', '035A', '035150103', 'emandate-disabled', '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:21+01:00', '2020-08-18T14:10:01.000Z'),
(163, 'ASO Savings and Loans', 'asosavings', '401', '', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:21+01:00', '2019-01-30T09:38:57.000Z'),
(164, 'Bowen Microfinance Bank', 'bowen-microfinance-bank', '50931', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:22+01:00', '2020-02-11T15:38:57.000Z'),
(165, 'CEMCS Microfinance Bank', 'cemcs-microfinance-bank', '50823', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:22+01:00', '2020-03-23T15:06:28.000Z'),
(166, 'Citibank Nigeria', 'citibank-nigeria', '023', '023150005', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:22+01:00', '2020-02-18T20:24:02.000Z'),
(167, 'Ecobank Nigeria', 'ecobank-nigeria', '050', '050150010', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:22+01:00', '2020-02-18T20:23:53.000Z'),
(168, 'Ekondo Microfinance Bank', 'ekondo-microfinance-bank', '562', '', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:22+01:00', '2018-09-23T05:55:06.000Z'),
(169, 'Fidelity Bank', 'fidelity-bank', '070', '070150003', 'emandate', '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:23+01:00', '2020-02-18T07:25:19.000Z'),
(170, 'First Bank of Nigeria', 'first-bank-of-nigeria', '011', '011151003', 'ibank', '1', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:23+01:00', '2019-11-21T05:09:47.000Z'),
(171, 'First City Monument Bank', 'first-city-monument-bank', '214', '214150018', 'emandate', '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:23+01:00', '2020-02-18T08:06:46.000Z'),
(172, 'FSDH Merchant Bank Limited', 'fsdh-merchant-bank-limited', '501', '', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:23+01:00', '2020-08-20T09:37:04.000Z'),
(173, 'Globus Bank', 'globus-bank', '00103', '103015001', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:23+01:00', '2020-02-11T15:38:57.000Z'),
(174, 'Guaranty Trust Bank', 'guaranty-trust-bank', '058', '058152036', 'ibank', '1', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:24+01:00', '2020-07-17T16:36:24.000Z'),
(175, 'Hackman Microfinance Bank', 'hackman-microfinance-bank', '51251', '', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:24+01:00', '2020-08-20T09:32:48.000Z'),
(176, 'Hasal Microfinance Bank', 'hasal-microfinance-bank', '50383', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:24+01:00', '2020-02-11T15:38:57.000Z'),
(177, 'Heritage Bank', 'heritage-bank', '030', '030159992', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:24+01:00', '2020-02-18T20:24:23.000Z'),
(178, 'Jaiz Bank', 'jaiz-bank', '301', '301080020', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:24+01:00', '2016-10-10T17:26:29.000Z'),
(179, 'Keystone Bank', 'keystone-bank', '082', '082150017', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:24+01:00', '2020-02-18T20:23:45.000Z'),
(180, 'Kuda Bank', 'kuda-bank', '50211', '', 'digitalbankmandate', '1', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:25+01:00', '2020-07-01T15:05:18.000Z'),
(181, 'Lagos Building Investment Company Plc.', 'lbic-plc', '90052', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:25+01:00', '2020-08-10T15:07:44.000Z'),
(182, 'One Finance', 'one-finance', '565', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:25+01:00', '2020-06-16T08:15:31.000Z'),
(183, 'Parallex Bank', 'parallex-bank', '526', '', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:25+01:00', '2019-01-30T09:43:56.000Z'),
(184, 'Parkway - ReadyCash', 'parkway-ready-cash', '311', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:25+01:00', '2020-08-10T15:07:44.000Z'),
(185, 'Polaris Bank', 'polaris-bank', '076', '076151006', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:26+01:00', '2016-07-14T10:04:29.000Z'),
(186, 'Providus Bank', 'providus-bank', '101', '', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:26+01:00', '2019-12-16T10:14:36.000Z'),
(187, 'Rubies MFB', 'rubies-mfb', '125', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:26+01:00', '2020-01-25T09:49:59.000Z'),
(188, 'Sparkle Microfinance Bank', 'sparkle-microfinance-bank', '51310', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:26+01:00', '2020-02-11T18:43:14.000Z'),
(189, 'Stanbic IBTC Bank', 'stanbic-ibtc-bank', '221', '221159522', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:26+01:00', '2020-02-18T20:24:17.000Z'),
(190, 'Standard Chartered Bank', 'standard-chartered-bank', '068', '068150015', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:26+01:00', '2020-02-18T20:23:40.000Z'),
(191, 'Sterling Bank', 'sterling-bank', '232', '232150016', 'emandate', '1', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:26+01:00', '2020-08-05T09:58:23.000Z'),
(192, 'Suntrust Bank', 'suntrust-bank', '100', '', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:26+01:00', '2016-10-10T17:26:29.000Z'),
(193, 'TAJ Bank', 'taj-bank', '302', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:27+01:00', '2020-01-20T11:20:32.000Z'),
(194, 'TCF MFB', 'tcf-mfb', '51211', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:27+01:00', '2020-04-03T09:34:35.000Z'),
(195, 'Titan Bank', 'titan-bank', '102', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:27+01:00', '2020-03-23T15:06:29.000Z'),
(196, 'Union Bank of Nigeria', 'union-bank-of-nigeria', '032', '032080474', 'emandate', '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:27+01:00', '2020-02-18T20:22:54.000Z'),
(197, 'United Bank For Africa', 'united-bank-for-africa', '033', '033153513', 'emandate', '1', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:27+01:00', '2019-05-20T21:23:20.000Z'),
(198, 'Unity Bank', 'unity-bank', '215', '215154097', 'emandate', '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:27+01:00', '2019-07-22T12:44:02.000Z'),
(199, 'VFD', 'vfd', '566', '', NULL, '0', 1, 0, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:27+01:00', '2020-02-11T15:44:11.000Z'),
(200, 'Wema Bank', 'wema-bank', '035', '035150103', NULL, '0', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:27+01:00', '2020-02-18T20:23:58.000Z'),
(201, 'Zenith Bank', 'zenith-bank', '057', '057150013', 'emandate', '1', 1, NULL, 'Nigeria', 'NGN', 'nuban', '2020-09-01T02:32:27+01:00', '2016-07-14T10:04:29.000Z');

--
-- Table structure for table `cashout`
--

CREATE TABLE `cashout` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pledge_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','paired','paid') NOT NULL DEFAULT 'pending',
  `date` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `intro` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `safelink` varchar(255) NOT NULL,
  `button` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `align` varchar(128) DEFAULT NULL,
  `icon` varchar(128) DEFAULT NULL,
  `color` varchar(128) DEFAULT NULL,
  `col` varchar(128) DEFAULT NULL,
  `in_header` int(11) DEFAULT 0,
  `in_footer` int(11) NOT NULL DEFAULT 0,
  `priority` int(11) NOT NULL DEFAULT 0,
  `packages` int(11) NOT NULL DEFAULT 0,
  `calculator` int(11) NOT NULL DEFAULT 0,
  `testimonies` int(11) NOT NULL DEFAULT 0,
  `features` int(11) NOT NULL DEFAULT 0,
  `prospect` int(4) NOT NULL DEFAULT 0,
  `breadcrumb` int(11) NOT NULL DEFAULT 0,
  `parent` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title`, `subtitle`, `intro`, `content`, `banner`, `safelink`, `button`, `video`, `align`, `icon`, `color`, `col`, `in_header`, `in_footer`, `priority`, `packages`, `calculator`, `testimonies`, `features`, `prospect`, `breadcrumb`, `parent`) VALUES
(1, 'Welcome to Ourzobia PHP', 'Discover A brand New way of making profit in Ourzobia.', 'We rise by lifting others!', '&lt;span style=&quot;font-size: 18px;&quot;&gt;NO EXPERIENCE needed, NO TRAINING required, everything made Simple and very Easy with just one click.&lt;br&gt;&lt;br&gt;It’s super simple - Your signup process had been simplified. Earn your first profit of 50% interest in 3 days and subsequently get 50% in 7 days using our quick, Secure and safe peer-to-peer village market structure. &lt;/span&gt;', 'uploads/content/1506482169_1106377099_955348840_p.png', 'homepage', '[link=signup class=primary-btn] Join Now  [/link] [link=home/about class=primary-btn howit-btn] How it Works [/link] ', '', 'right', 'fa fa-align-center', 'text-info', '', 1, 1, 1, 0, 1, 1, 1, 1, 0, ''),
(5, 'About Us', '', 'We rise by lifting others!', '&amp;nbsp; &amp;nbsp;', 'uploads/content/1664559689_715080334_1310969269_p.png', 'about', '[link=signup] Register Now [/link]', '', 'right', 'fa fa-500px', 'text-info', '', 1, 1, 1, 0, 0, 0, 0, 1, 1, ''),
(6, 'We are on a mission', '', 'We are on a mission', 'It no longer matters how bad the effects of the pandemic may have affected your daily life and routine, we believe in a community where everyone who is willing to help lift another, has an equal opportunity at being lifted by another. This follows a simple process of buying and selling like you do everyday when you go offline, only&amp;nbsp;the odds at success becomes greater for you.', NULL, 'we-are-on-a-mission', '[link=home/about]Learn More[/link]', 'https://www.youtube.com/embed/XOipUOJ8Th4?rel=0', 'right', 'fa fa-500px', '', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, 'homepage'),
(7, 'Welcome to Ourzobia PHP', '', 'We rise by lifting others!', 'Ourzobia PHP is a secure and solid online Village, designed to accommodate millions of users with the sole aim of empowering one another financially, &quot;We rise by lifting others&quot;, In Ourzobia we buy and sell &quot;OV Gold&quot; (Ourzobia Gold) to make profit weekly. NO EXPERIENCE needed, NO TRAINING required, everything has been made Simple and very Easy, and with a single click you can buy and sell in our peer-to-peer village market and make 50% weekly profit from your Investments with Ease.', 'uploads/content/349433013_445462364_475095512_p.png', 'welcome-to-ourzobia', '[link=signup class=primary-btn howit-btn] Join Now [/link]', 'https://www.youtube.com/watch?v=XOipUOJ8Th4?rel=0&autoplay=1', 'right', 'fa fa-500px', '', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, 'about'),
(9, 'Welcome to Ourzobia PHP', '', 'There are no delays in Ourzobia...', 'Our market structure ensures that Buyers and Sellers are always available, so you won\'t have to worry about delays in being assigned to a buyer or seller.', NULL, 'welcome', '', 'https://www.youtube.com/embed/XOipUOJ8Th4?rel=0', 'left', 'fa fa-500px', '', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, ''),
(10, 'Ourzobia PHP Market', '', '', '&lt;p&gt;When you register and make an investment in Ourzobia PHP Market, you will receive your money back with an additional 50% interest on all your investments, As soon as a merchant confirms reception of your payment, you will earn your first profit of 50% interest in 3 days and subsequently in 7 days using our Quick, Secure and Safe Peer-to-Peer village market structure.&lt;/p&gt;\r\n&lt;p&gt;We have also provided you with an easy way to withdraw your earnings from the system, after your purchase and sales orders are successfully completed. You will receive the money directly into your existing Bank accounts.&lt;br&gt;&lt;/p&gt;', NULL, 'our-village-market', '', '', 'left', 'fa fa-500px', '', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, 'about'),
(11, 'Features', '', '', '&lt;p&gt;&lt;span style=&quot;font-size: 16px;&quot;&gt;Ourzobia PHP is a brand new initiative with a lot of exciting and beautiful features!&lt;/span&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;Playground&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;Ourzobia PHP has an integrated&amp;nbsp;social network platform&amp;nbsp;called &quot;Playground&quot;,&amp;nbsp;This is where users meet on daily basis to interact and share their buying and selling experiences. It has a crisp and responsive interface that has been carefully crafted for&amp;nbsp;interactivity.&lt;/p&gt;\r\n&lt;p&gt;As a users on the playground, you can share text, images and video posts,&amp;nbsp;you can like,&amp;nbsp;comment,&amp;nbsp;and even share posts of other users.&lt;/p&gt;&lt;p&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;Market&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;This is where buying and selling takes place on daily basis. Users can always visit the market at any time of the day because buyers are always available 24/7.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;Lineage&lt;/span&gt;&lt;/strong&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;The lineage section contains a comprehensive list of all users&amp;nbsp;referred by a users and their direct descendants&amp;nbsp;into Ourzobia PHP using the provided referral&amp;nbsp;referral link. This means,&amp;nbsp;everyone&amp;nbsp;directly or indirectly associated to a users can be seen&amp;nbsp;under Lineage.&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;Buy OV Gold&lt;/span&gt;&lt;/strong&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;This section is a&amp;nbsp;shop equivalent,&amp;nbsp;this is&amp;nbsp;where users can make and purchase new OV Gold&amp;nbsp;(Ourzobia PHP Gold) orders. There is an unlimited supply of OV Gold available for&amp;nbsp;Purchase at any time of the day.&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;Tax accrued&lt;/span&gt;&lt;/strong&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;Users are required to pay community service tax&amp;nbsp;of 0.5%&amp;nbsp;for all completed transactions carried out in the market, to maintain stability in Ourzobia PHP market structure.&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;Family fortune&lt;/span&gt;&lt;/strong&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;This is a sum of all the bonuses earned from partaking in community service&amp;nbsp;tasks&amp;nbsp;like referral activities. A users gets a 10% bonus from&amp;nbsp; all transactions carried out&amp;nbsp;by their&amp;nbsp;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;direct descendants, family fortune can be sold in the market on daily basis when available.&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;Community&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;&lt;b&gt;Hierarchy&lt;/b&gt;&lt;/span&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/p&gt;&lt;p&gt;Ourzobia PHP is an&amp;nbsp;organised social community where&amp;nbsp;users are ranked according to the number of descendant they have in their family. some of the available ranks include.&lt;/p&gt;&lt;ol&gt;&lt;li style=&quot;margin-left: 20px;&quot;&gt;User&lt;/li&gt;&lt;li style=&quot;margin-left: 20px;&quot;&gt;Elder&lt;/li&gt;&lt;li style=&quot;margin-left: 20px;&quot;&gt;Chief&lt;/li&gt;&lt;li style=&quot;margin-left: 20px;&quot;&gt;King&lt;/li&gt;&lt;li style=&quot;margin-left: 20px;&quot;&gt;Royal Highness&lt;/li&gt;&lt;/ol&gt;', NULL, 'features', '', '', 'left', 'fa fa-500px', '', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, 'about'),
(12, 'Contact us', 'We have multiple communication channels.', 'We rise by lifting others!', '&lt;h3&gt;&amp;nbsp;&amp;nbsp;&lt;br&gt;&lt;/h3&gt;', NULL, 'contact-us', '', '', 'left', 'fa fa-500px', '', '', 1, 1, 1, 0, 0, 0, 0, 0, 1, ''),
(13, 'Contact us Now', '', 'We have multiple communication channels.', '&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;\r\n&lt;h4&gt;&lt;strong&gt;Support Line: &lt;a class=&quot;text-dark&quot; href=&quot;tel:+2349028996764&quot;&gt;+2349028996764&lt;/a&gt;&lt;/strong&gt;&lt;strong&gt;&lt;a class=&quot;text-dark&quot; href=&quot;tel:+2349028996764&quot;&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/h4&gt;&lt;h4&gt;&lt;strong&gt;&lt;a class=&quot;text-dark&quot; href=&quot;tel:+2349028996764&quot;&gt;&lt;/a&gt;&lt;/strong&gt;&lt;strong&gt;&lt;a class=&quot;text-dark&quot; href=&quot;tel:+2349028996764&quot;&gt;&lt;/a&gt;&lt;/strong&gt;&lt;strong style=&quot;color: inherit; font-family: inherit; font-size: 1.5rem;&quot;&gt;Whatsapp: &lt;a class=&quot;text-dark&quot; href=&quot;https://wa.link/wmll4w&quot;&gt;+2349010178154&lt;/a&gt;&lt;/strong&gt;&lt;/h4&gt;&lt;h4&gt;&lt;strong style=&quot;color: inherit; font-family: inherit; font-size: 1.5rem;&quot;&gt;&lt;a class=&quot;text-dark&quot; href=&quot;https://wa.link/wmll4w&quot;&gt;&lt;/a&gt;&lt;/strong&gt;&lt;strong&gt;Support Email: &lt;a class=&quot;text-dark&quot; href=&quot;mailto:support@ourzobiaphp.cf&quot;&gt;support@ourzobiaphp.cf&lt;/a&gt;&lt;/strong&gt;&lt;/h4&gt;&lt;h4&gt;&lt;strong&gt;&lt;a class=&quot;text-dark&quot; href=&quot;mailto:support@ourzobiaphp.cf&quot;&gt;&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;Contact Email: &lt;/a&gt;&lt;a class=&quot;text-dark&quot; href=&quot;mailto:ourzobia@gmail.com&quot;&gt;ourzobia@gmail.com&lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;/a&gt;&lt;h4&gt;&lt;a class=&quot;text-dark&quot; href=&quot;mailto:ourzobia@gmail.com&quot;&gt;&lt;/a&gt;&lt;strong&gt;&lt;a class=&quot;text-dark&quot; href=&quot;mailto:support@ourzobiaphp.cf&quot;&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/h4&gt;&lt;h4&gt;&lt;strong&gt;Telegram&lt;a class=&quot;text-dark&quot; href=&quot;mailto:support@ourzobiaphp.cf&quot;&gt;: &lt;/a&gt;&lt;a class=&quot;text-dark&quot; href=&quot;https://t.me/ourzobia&quot;&gt;https://t.me/ourzobia&lt;/a&gt;&lt;/strong&gt;&lt;/h4&gt;&lt;/strong&gt;&lt;/h4&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;\r\n&lt;p&gt;Alternatively, you can quickly reach our Council of Chiefs by using the chat widget at the bottom of the site.&lt;/p&gt;', NULL, 'contact-us-now', '', '', 'left', 'fa fa-500px', '', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, 'contact-us'),
(14, 'FAQ', 'Frequently Asked Questions', 'Frequently Asked Questions', '&lt;p&gt;&lt;a href=&quot;#what&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;WHAT IS Ourzobia PHP ABOUT&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;\r\n    &lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;a href=&quot;#how&quot;&gt;&lt;/a&gt;&lt;a href=&quot;#how&quot;&gt;&lt;/a&gt;&lt;span style=&quot;color: rgb(255, 153, 0);&quot;&gt;&lt;a href=&quot;#how&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;HOW DO I MAKE MONEY IN Ourzobia PHP&lt;/a&gt;&lt;/span&gt;&lt;a href=&quot;#how&quot;&gt;&lt;/a&gt;&lt;a href=&quot;#how&quot;&gt;&lt;/a&gt;&lt;a href=&quot;#how&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;\r\n    &lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;a href=&quot;#when&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;WHEN WAS Ourzobia PHP FOUND&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;a href=&quot;#ponzi&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;\r\n        &lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;IS IT A PONZI SCHEME&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;\r\n    &lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;a href=&quot;#safe&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;HOW SAFE IS Ourzobia PHP&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;\r\n    &lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;a href=&quot;#fee&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;\r\n    &lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;a href=&quot;#register&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;HOW DO I REGISTER&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;a href=&quot;#fee&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;IS THERE A REGISTRATION FEE&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;\r\n    &lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;a href=&quot;#referre&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;DO I ET BONUS FOR REFERRING PEOPLE&lt;/a&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;\r\n    &lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;&lt;a href=&quot;#more&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;CAN I HAVE MORE THAN ONE ACCOUNT&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;a href=&quot;#support&quot; style=&quot;color: rgb(255, 153, 0);&quot;&gt;\r\n        &lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;HOW DO I REACH SUPPORT IF I HAVE ANY ISSUE&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\r\n&lt;h3 id=&quot;what&quot;&gt;WHAT IS Ourzobia PHP ABOUT&lt;/h3&gt;\r\n&lt;p&gt;\r\n    Ourzobia PHP is a micro social marketplace where&amp;nbsp;we buy and sell (trade) OV Gold&amp;nbsp;(Ourzobia Gold) to make&amp;nbsp;weekly profit.&lt;/p&gt;\r\n&lt;br&gt;\r\n&lt;h3 id=&quot;how&quot;&gt;HOW DO I MAKE MONEY IN Ourzobia PHP&lt;/h3&gt;\r\n&lt;p&gt;\r\n    When you register and make an investment in Ourzobia PHP Market, you will receive 50% interest as soon as a merchant confirms reception of your payment, in 3 days and subsequently in 7 days. For example: Let\'s assume you buy OV Gold of &lt;s&gt;N&lt;/s&gt;20,000 from Ourzobia PHP market&amp;nbsp;on the 1st of August, you will sell it at the rate of &lt;s&gt;N&lt;/s&gt;30,000 after it has been processed on the 7th day. but before you sell, you must place a new&amp;nbsp;OV\r\n    Gold order to maintain stability in the market.&lt;/p&gt;\r\n&lt;br&gt;\r\n&lt;h3 id=&quot;when&quot;&gt;WHEN WAS Ourzobia PHP FOUND&lt;/h3&gt;\r\n&lt;p&gt;Ourzobia PHP was launched on the 13th of August 2020.&lt;/p&gt;\r\n&lt;br&gt;\r\n&lt;h3 id=&quot;ponzi&quot;&gt; IS IT A PONZI SCHEME&lt;/h3&gt;\r\n&lt;p&gt;No,&amp;nbsp;\r\n    &lt;meta http-equiv=&quot;content-type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;Ourzobia PHP is a micro social marketplace where&amp;nbsp;we buy and sell (trade) OV Gold&amp;nbsp;(Ourzobia Gold) to make&amp;nbsp;weekly profit.&lt;/p&gt;\r\n&lt;br&gt;\r\n&lt;h3 id=&quot;safe&quot;&gt;HOW SAFE IS Ourzobia PHP&lt;/h3&gt;\r\n&lt;p&gt;\r\n    Ourzobia PHP is a secure and solid online Village, designed to accommodate millions of users with the sole aim of bridging the gap between business and family&amp;nbsp;created by social lock down imposed during the Covid 19 Pandemic and&amp;nbsp; the empowerment of every other users&amp;nbsp;financially, using our Quick, Secure and Safe Peer-to-Peer village market structure and social tools.&lt;/p&gt;\r\n&lt;br&gt;\r\n&lt;h3 id=&quot;register&quot;&gt; HOW DO I REGISTER&lt;/h3&gt;\r\n&lt;p&gt;\r\n    Register at : &lt;a href=&quot;www.ourzobiaphp.cf&quot;&gt;www.ourzobiaphp.cf&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;a href=&quot;www.ourzobiaphp.cf&quot;&gt;&lt;br&gt;&lt;/a&gt;&lt;/p&gt;\r\n&lt;h3 id=&quot;fee&quot;&gt;IS THERE A REGISTRATION FEE&lt;/h3&gt;\r\n&lt;p&gt;\r\n    YES! Registration Fee is N1,000.&lt;/p&gt;\r\n&lt;br&gt;\r\n&lt;h3 id=&quot;referre&quot;&gt; DO I GET BONUS FOR REFERRING PEOPLE&lt;/h3&gt;\r\n&lt;p&gt;\r\n    YES! You get 10% referral bonus for all completed purchase orders made by&amp;nbsp;the users you referred.&lt;/p&gt;\r\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\r\n&lt;h3 id=&quot;more&quot;&gt; CAN I HAVE MORE THAN ONE ACCOUNT&lt;/h3&gt;\r\n&lt;p&gt;\r\n    NO!&lt;/p&gt;\r\n&lt;br&gt;\r\n&lt;h3 id=&quot;support&quot;&gt;HOW DO I REACH SUPPORT IF I HAVE ANY ISSUE&lt;/h3&gt;\r\n&lt;p&gt;\r\n    You can chat support&amp;nbsp;via the chat box on the website &lt;a href=&quot;www.ourzobiaphp.cf&quot;&gt;www.ourzobiaphp.cf&lt;/a&gt; and a nearly instant\r\n    response or call:&lt;br&gt;\r\n    &lt;strong&gt;Support Line: +2349028996764&lt;br&gt;\r\n        Whatsapp: +2349010178154&lt;br&gt;\r\n        Support Email:&amp;nbsp;support@ourzobiaphp.cf&lt;br&gt;\r\n        Contact Email: ourzobia@gmail.com&lt;br&gt;\r\n        Telegram:&amp;nbsp;https://t.me/ourzobia&lt;/strong&gt;&lt;/p&gt;', NULL, 'faq', '', '', 'left', 'fa fa-500px', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 1, ''),
(15, 'Privacy Policy ', 'Privacy Policy for Ourzobia PHP', 'We rise by lifting others!', '', NULL, 'privacy-policy', '', '', 'left', 'fa fa-500px', '', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, ''),
(16, 'Terms  of Use', 'Terms of Use', 'Terms of Use', '&lt;ol&gt;&lt;li&gt;By accessing and/or using this website, using the provided tools&amp;nbsp;and/or purchasing products, you are entering into a binding agreement with the Company and hereby agree to be bound by these Terms and Conditions and any additional Terms and Conditions, guidelines, restrictions, or rules posted on this website or any other related websites and applicable for any other products and or services&lt;/li&gt;&lt;li&gt;OURVILAGE.GOLD hereby reserves the right to make changes to this website and/or Terms and Conditions at any time without prior notice and in lines with what the management of OURVILAGE.GOLD sees serves the interest of the Company and her members.&lt;/li&gt;&lt;li&gt;By using this website and facilities provided, you hereby confirm that you have the possibility and right to review these Terms and Conditions each time you access this website, and thereby also to be bound by them.&lt;/li&gt;&lt;li&gt;By using this website and tools provided, You hereby confirm that you understand that OURVILAGE.GOLD admins will never chat them up on any of her social media platforms that they are assigned to pay money to any account that will not reflect on your market place. This means that you must only make payments to the account details given to you on your market place. You are equally aware of the existence of telegram, Instagram, Whatsapp, and other social media handles used by scammers scammers and how they operate, and that you will not fall prey to them but that if you fall to scam that you indemnify OURVILAGE.GOLD or any of her associate(s) from blame and that you must bear the full brunt of your actions.&lt;/li&gt;&lt;li&gt;In case of non-acceptance of the present Terms and Conditions the Company kindly asks visitors to not use this website and/or the tools provided.&lt;/li&gt;&lt;li&gt;All rights on all logotypes, images, trademarks, informational and other resources, or any other materials are reserved and therefore protected by the relevant legislation. Non authorized use of any of the described is considered and shall be treated as a violation of the stipulated legislation and liability shall be seek in compliance with the relevant and applicable legislation.&lt;/li&gt;&lt;li&gt;Additionally, User preferences and settings (time zone, language, privacy preferences, product preferences, etc.) may be collected to enhance the performance of the present website.&lt;/li&gt;&lt;li&gt;By using this website and/or any of the facilities provided, You hereby agree&amp;nbsp;to not hold OURVILAGE.GOLD or any of her promoters responsible for any loss and/or damage that may occur as a result of delay in the process of executing a transaction or when participating in any of her programs.&lt;/li&gt;&lt;li&gt;By accessing and/or using this website, using any or all the provided facilities, you are entering into a binding agreement with the platform that they are aware and agree that the system is/will-be using the principle of first come first serve in assigning participants either to buy or sell, and they agree and are aware that sometimes as a result of long&amp;nbsp;queue processing it may take longer than&amp;nbsp;expected to be&amp;nbsp;assigned a participant to buy or sell to/from and that they agree to hold OURVILAGE.GOLD or any of her promoters free from blame in the event that such delay leads to their loss of fund(s) and or any other loss that may arise as a result of such delay.&lt;/li&gt;&lt;li&gt;By using this website and tools provided, you hereby confirm that user information including user’s images, banks details, and member’s names will not be posted on any social media which includes but not limited to Facebook, Telegram and Instagram.&lt;/li&gt;&lt;li&gt;You also agree that in the event that you divulge the information of fellow members, that OURVILAGE.GOLD reserves the right to suspend delete and/or take any action it deems necessary against you.&lt;/li&gt;&lt;li&gt;By using this platform, you agree that you must promote and represent the interest of OURVILAGE.GOLD at all time and if ever you’re found guilty of de-marketing OURVILAGE.GOLD, that OURVILAGE.GOLD reserves the right to take whatever action it deems fit against you.&lt;/li&gt;&lt;li&gt;By using this platform, you agree that you&amp;nbsp;may be required to&amp;nbsp;make a testimonial video&amp;nbsp;talking about how OURVILAGE.GOLD has&amp;nbsp;been good to you and how the&amp;nbsp;platform might&amp;nbsp;have positively affected your life, and&amp;nbsp;will post the video on your social media handles. You also agree that if required, on&amp;nbsp;refusal&amp;nbsp;to make such testimonial video after successful transactions,&amp;nbsp;OURVILAGE.GOLD reserves the right to carry out&amp;nbsp;whatever action or actions it deems fit against you including suspending you account&amp;nbsp;or refusing to allow you sell your stock.&lt;/li&gt;&lt;li&gt;You also agree that you must not make any donation/payments with money gotten from nefarious activities which is against the law of the country where you reside.&lt;/li&gt;&lt;li&gt;By using this website and the&amp;nbsp;tools provided, you hereby confirm that you are not a child trafficker, prostitute, Drug pusher, kidnapper, cultist, ritualist, or into any socially unacceptable activities and that whereby you, under guise participates by becoming a member of OURVILAGE.GOLD, any donation or sale&amp;nbsp;you make, is seen as charity and neither OURVILAGE.GOLD nor any of her associates will be held accountable. By using this website and facilities provided, you hereby confirm that you understand that you may experience some delay while trading on the platform either in being assigned to buy or sell.&amp;nbsp;&lt;/li&gt;&lt;li&gt;By accessing and/or using this website, using any or all the provided facilities you are entering into a binding agreement with the platform to&amp;nbsp;honor any/all pledge(s) you make&amp;nbsp;and hereby agree that your accounts should be blocked or suspended in the events failure to honor your pledges.&lt;/li&gt;&lt;li&gt;You hereby agree&amp;nbsp;that should your account&amp;nbsp;be blocked while participating in a OURVILAGE.GOLD program&amp;nbsp;because of defaults in honoring&amp;nbsp;pledges by making payment to your&amp;nbsp;assigned participant, that you agree that upon the reopening of your account(s), that they will make a new order&amp;nbsp;at least double (x2) of their previous pledge or a preset fine before you can have access to any fund/funds you&amp;nbsp;may be having on the system.&amp;nbsp;&lt;/li&gt;&lt;li&gt;Members participating in OURVILAGE.GOLD’s investment program&amp;nbsp;understands that the investment program&amp;nbsp;is participant to participant based market and as such should participate only with spare money since purchasing&amp;nbsp;does not necessarily mean selling immediately, hence participants may have to wait longer time until there are more eligible merchants in the system.&lt;/li&gt;&lt;li&gt;By accessing and/or using this website, using any of the provided facilities, you hereby agree&amp;nbsp;that in the event that you want&amp;nbsp;to terminate your account, that you agree to forfeit any/all money in your account(s) and you agree to hold OURVILAGE.GOLD and any/all her promoters including any/all members that they were assigned to buy/sell&amp;nbsp;free from any damages/losses that this decision may result.&lt;/li&gt;&lt;li&gt;By using this website and the tools provided, you hereby confirm that you are aware that the OURVILAGE.GOLD program&amp;nbsp;is a participant to participant program and as such, there shall be no refund of money after payment since all money paid to participants are money due to the receiving participant. You hereby agree&amp;nbsp;that should your account&amp;nbsp;be blocked because of defaults in honoring your pledge by making payment to your uplines, you agree to lose any money which may be in your account&amp;nbsp;and to also pay any fees which will be determined by the platform in other to gain access to any/all the services provided by the platform.&lt;/li&gt;&lt;li&gt;Your hereby agree&amp;nbsp;that the platform reserves the right to block, suspend&amp;nbsp;and delete&amp;nbsp;your account&amp;nbsp;from the platform for what ever reason that the platform deems necessary without prior notice and you also agree&amp;nbsp;to hold the management of OURVILAGE.GOLD free from any damage/loss that may result from this action.&lt;/li&gt;&lt;li&gt;You agree to hold OURVILAGE.GOLD or any of her partners free from any loss which may arise as a result of any attempt to bribe/induce any of her agent in whatever manner in other to divert due process and members understands that OURVILAGE.GOLD has the rights to take whatever action it deems fit against all culprits involved and you hereby agree&amp;nbsp;to accept in good fate any decision taken.&lt;/li&gt;&lt;li&gt;You hereby agree that any agreements/transactions done outside what is on your market&amp;nbsp;is considered null and void and of no merit and will be considered invalid and whatever outcome it has will not be associated with OURVILAGE.GOLD.&lt;/li&gt;&lt;li&gt;By accessing and/or using this website, using the provided tools, your&amp;nbsp;hereby agree&amp;nbsp;that you must make an upfront purchase minimum of your previous purchase amount, which&amp;nbsp;will serve as a 100% re-commitment policy which is compulsory for all members before they can make any sales on the system. This means that at all time, you&amp;nbsp;agree&amp;nbsp;that you must always have an outstanding purchase&amp;nbsp;on the system and if you must withdraw it, you must make a new purchase, minimum amount of your initial purchase.&lt;/li&gt;&lt;li&gt;By accessing and/or using this website, using the provided tools, you hereby agree&amp;nbsp;that, you will participate in OURVILAGE.GOLD program&amp;nbsp;ONLY with spare money and hereby indemnify the platform of any loss which may occur because of their non adherence to this clause.&lt;/li&gt;&lt;li&gt;You hereby agree&amp;nbsp;that the security of your passwords is your concern that you will not divulge your personal details to other members but that in the events that you do, you hereby indemnify OURVILAGE.GOLD Management of any loss that may result.&lt;/li&gt;&lt;li&gt;By accessing and/or using this website, using the provided facilities members hereby agrees that they will not use the same word (thing, name) used for email for password. This is to avoid the persons account from being hacked and the members also confirms that in the event of his/her neglect of this warning he/she will hold OURVILAGE.GOLD and all her associates free from blame.&lt;/li&gt;&lt;li&gt;By accessing and/or using this website, you hereby agree&amp;nbsp;that you are to increase your purchase amount&amp;nbsp;on every new purchase after a certain number of purchases to maintain high priority in being assigned to receive when you click on withdraw. You also agree&amp;nbsp;that OURVILAGE.GOLD reserve the right not to assign anyone to sell if they continuously repeat the same amount on their purchases.&lt;/li&gt;&lt;li&gt;You hereby agree&amp;nbsp;that by participating on OURVILAGE.GOLD Program, my priority in selling should be calculated by the system based on the percentage of increment on my purchases and you&amp;nbsp;also agree&amp;nbsp;that if your priority is low, your chances of being&amp;nbsp;assigned to sell should also be low and&amp;nbsp;will either wait till it gets to your turn on the queue or upgrade your purchase plan&amp;nbsp;to increase your priority level.&lt;/li&gt;&lt;li&gt;By accessing and/or using this website, using the provided tools, you hereby agree&amp;nbsp;to holds OURVILAGE.GOLD free from any loss which may be occasioned as a result of any cyber attack on our systems.&lt;/li&gt;&lt;li&gt;Upon termination or expiration of these Terms, your obligations and our proprietary rights, disclaimer of warranties, indemnities, limitations of liability and miscellaneous provisions survive, but your right to use the OURVILAGE.GOLD Website immediately ceases.&lt;/li&gt;&lt;li&gt;OURVILAGE.GOLD reserves the right, at its sole discretion, to immediately, with or without notice, suspend or terminate these Terms of Use, and/or your access to all or a portion of the OURVILAGE.GOLD Website and/or remove any registration information or User Content from the OURVILAGE.GOLD Website, for any reason (including but not limited to if you breach of any of the provisions of these Terms of Use). OURVILAGE.GOLD also reserves the right to change the OURVILAGE.GOLD Website without notice to you, at any time.&amp;nbsp; &amp;nbsp;&lt;/li&gt;&lt;li&gt;Please be aware that whenever you voluntarily post public information to message boards, playground&amp;nbsp;or any other public forum sections available on this website, that information can be accessed by the public and can in turn be used by those people to send you unsolicited communications. The platform is not responsible for the personally identifiable information you choose to submit on the above-mentioned sections. Please use your utmost discretion before you post any personal information online. Users should give special attention to the information they disclose publicly.&amp;nbsp;&lt;/li&gt;&lt;li&gt;OURVILAGE.GOLD is entitled to change these Terms and Conditions at any time. In case of invalidity or incompleteness of any clause of the present Terms and Conditions, the validity of the entire document shall not be affected. Instead of that, the invalid clause shall then be replaced by a valid one whose economic purpose comes as close as possible to that of the invalid clause. The same shall apply when covering a gap requiring regulation.&lt;/li&gt;&lt;li&gt;By accessing and/or using this website, using the provided tools, you&amp;nbsp;hereby give&amp;nbsp;up your right(s) with regards to any loss you might encounter from the use of this site, irrespective of any extent you may feel that&amp;nbsp; Ourzobia PHP contributed to to occurrence of such loss, no matter how reasonable your reasons or the available evidence you may&amp;nbsp;raise&amp;nbsp;in any court of competent jurisdiction, you agree that this clause shall be used to determine the outcome of such proceeding.&lt;/li&gt;&lt;/ol&gt;\r\n', NULL, 'terms-of-use', '', '', 'left', 'fa fa-500px', '', '', 0, 0, 1, 0, 0, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `sortname` varchar(3) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phonecode` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `details` text NOT NULL,
  `icon` varchar(128) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `title`, `details`, `icon`, `image`) VALUES
(3, 'Quick & Easy', 'Gain quick access to every tool you need to buy and sell, Our simplified interface and high resolution icons makes finding the tools you need to buy and sell OV Gold a click away.\r\n', 'fa fa-car', NULL),
(4, 'Absolute Security', 'Ourzobia PHP uses an SSL certificate trusted in 99.9% of all major browsers worldwide, with state of the art data encryption for all transactions between Users.', 'fa fa-lock', NULL),
(8, 'Secure Automated Matching', 'Matching is encrypted and done automatically on secure servers, eliminating the fear of human error, DDOS attacks and activities of fraudulent individuals.', 'fa fa-laptop', NULL),
(9, '24/7 Support', 'Quickly gain access to technical and customer service support, depending on the severity of queries, we are available to take calls and provide support all day.', 'fa fa-adjust', NULL),
(10, 'High ROI', '<p>Get 50% profit on your first successful OV Gold order in 3 days, and subsequently get 50% profit in 7 days after complete refinement.</p>', 'fa fa-chart-area', NULL),
(12, 'Active Market', 'Our market structure ensures that Buyers and Sellers are always available, so you won\'t have to worry about delays in being assigned to a buyer or seller.', 'fa fa-users', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `seo_title` varchar(128) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `badge` varchar(128) DEFAULT NULL,
  `level_up` int(11) NOT NULL DEFAULT 5,
  `direct_refs` int(11) NOT NULL DEFAULT 1,
  `next_id` int(11) NOT NULL DEFAULT 1,
  `percentage` int(11) NOT NULL DEFAULT 0,
  `precentage` int(11) NOT NULL DEFAULT 0,
  `starter` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `seo_title`, `title`, `badge`, `level_up`, `direct_refs`, `next_id`, `percentage`, `precentage`, `starter`) VALUES
(1, 'starter', 'Starter', 'gold-', 0, 0, 2, 0, 0, 0),
(2, 'townsmen', 'Villager', 'qconq-', 3, 3, 3, 0, 0, 1),
(3, 'elders', 'Elder', 'tycoon-', 1, 5, 4, 5, 10, 0),
(4, 'chiefs', 'Chief', 'collector-', 4, 10, 5, 0, 0, 0),
(5, 'king', 'King', 'rulerm-', 10, 50, 6, 1, 1, 0),
(6, 'royal_highness', 'Royal Highness', 'uploads/content/royal_highness.png', 50, 100, 6, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(55) DEFAULT NULL,
  `time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `notice_board`
--

CREATE TABLE `notice_board` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `page` varchar(123) DEFAULT NULL,
  `type` varchar(128) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notice_board`
--

INSERT INTO `notice_board` (`id`, `title`, `content`, `position`, `page`, `type`, `status`, `date`, `updated`, `deleted`) VALUES
(5, 'Support Notice', 'If you experience any difficulty in Ourzobia PHP please contact support', 1, 'dashboard', 'info', 1, 1596283237, 1596283279, NULL),
(8, 'WHAT IS Ourzobia PHP ABOUT', 'Ourzobia PHP is a micro social marketplace where we buy and sell (trade) OV Gold (Ourzobia Gold) to make weekly profit.', 1, 'faq', 'success', 1, 1597335031, 1597335031, NULL),
(9, 'HOW DO I MAKE MONEY IN Ourzobia PHP', 'When you register and make an investment in Ourzobia PHP Market, you will receive 50% interest as soon as a merchant confirms reception of your payment, in 3 days and subsequently in 7 days. For example: Let\'s assume you buy OV Gold of N20,000 from Ourzobia PHP market on the 1st of August, you will sell it at the rate of N30,000 after it has been processed on the 7th day. but before you sell, you must place a new OV Gold order to maintain stability in the market.', 1, 'faq', 'success', 1, 1597335051, 1597335051, NULL),
(10, 'WHEN WAS Ourzobia PHP FOUND', 'Ourzobia PHP was launched on the 13th of August 2020.', 1, 'faq', 'success', 1, 1597335070, 1597335070, NULL),
(11, 'IS IT A PONZI SCHEME', 'No,  Ourzobia PHP is a micro social marketplace where we buy and sell (trade) OV Gold (Ourzobia Gold) to make weekly profit.', 1, 'faq', 'success', 1, 1597335087, 1597335087, NULL),
(12, 'HOW SAFE IS Ourzobia PHP', 'Ourzobia PHP is a secure and solid online Village, designed to accommodate millions of users with the sole aim of bridging the gap between business and family created by social lock down imposed during the Covid 19 Pandemic and  the empowerment of every other users financially, using our Quick, Secure and Safe Peer-to-Peer village market structure and social tools.', 1, 'faq', 'success', 1, 1597335111, 1597335111, NULL),
(13, 'IS THERE A REGISTRATION FEE', 'YES! Registration Fee is N1,000.', 1, 'faq', 'success', 1, 1597335131, 1597335131, NULL),
(14, 'DO I GET BONUS FOR REFERRING PEOPLE', 'YES! You get 10% referral bonus for all completed purchase orders made by the users you referred.', 1, 'faq', 'success', 1, 1597335149, 1597335149, NULL),
(15, 'HOW DO I REACH SUPPORT IF I HAVE ANY ISSUE', 'You can chat support via the chat box on the website and get a nearly instant response or call:<br>\r\nSupport Line: +2349028996764<br>\r\nWhatsapp: +2349010178154<br>\r\nSupport Email: support@ourzobiaphp.cf<br>\r\nContact Email: ourzobia@gmail.com<br>\r\nTelegram: https://t.me/ourzobia<br>', 1, 'faq', 'success', 1, 1597335195, 1597335280, NULL),
(16, 'Town Crier!', 'The entire Ourzobia PHP team wants to use this medium to appreciate every member of Ourzobia PHP for their cooperative support during the pre-launching and launching period, for all your referrals, suggestions and bug reports... Thanks a million! Keep spreading the good news!', 1, 'dashboard', 'success', 1, 1597345518, 1597345608, NULL),
(17, 'Town Crier!', 'We just recently launched on the 13th of August 2020, at the moment registrations and account activation are ongoing, Merchant activation of OV Gold Purchase and Sales will commence soon.\r\nThanks for your understanding!', 1, 'modal', 'success', 0, 1597411892, 1597425604, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notifier_id` int(11) NOT NULL DEFAULT 0,
  `recipient_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(128) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `seen` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `intro` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `min_deposit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_deposit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `starter` int(11) NOT NULL DEFAULT 0,
  `rate` int(11) NOT NULL DEFAULT 0,
  `duration` int(11) NOT NULL DEFAULT 1,
  `ini_duration` int(11) NOT NULL DEFAULT 1,
  `units` enum('seconds','minutes','hours','days','weeks','months','years') NOT NULL DEFAULT 'days',
  `status` int(11) NOT NULL DEFAULT 1,
  `banner` varchar(128) DEFAULT NULL,
  `icon` varchar(128) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 3,
  `color` varchar(128) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `intro`, `description`, `min_deposit`, `max_deposit`, `amount`, `starter`, `rate`, `duration`, `ini_duration`, `units`, `status`, `banner`, `icon`, `rating`, `color`, `deleted`) VALUES
(1, 'Gold Bar', 'Introductory Package', 'Package fit for people who are willing to take their first steps to greatness in Ourzobia PHP.', 18000.00, 26000.00, 18000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 4, '#d3a20c', NULL),
(2, 'Crate of Gold', 'The next step is perfection', 'When you are ready to make a new leap and step up, this is the perfect plan.', 41000.00, 61000.00, 41000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 3, '#d3a20c', NULL),
(3, 'Bag of Gold', 'The bigger things might look small', 'Grow your OV Gold merchandise at the right time, one step at a time is how to grow.', 93000.00, 139000.00, 93000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 3, '#d3a20c', NULL),
(4, 'Box of Gold', 'Growth begins when you choose', 'There is no better way to get along with the concept of increase than understanding trying it.', 315000.00, 472000.00, 315000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 5, '#d3a20c', NULL),
(5, 'Gold Vault', 'You begin before you proceed', 'Just when you feel you have it all, you dawn on the realization of the want for more.', 708000.00, 1062000.00, 708000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 3, '#d3a20c', NULL),
(6, 'Golden Estate', 'The closer to success the better', 'At this time, you realize just how much you may have missed staying below this line.', 1000000.00, 1000000.00, 1000000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 3, '#d3a20c', NULL),
(8, 'Ultra Goldbar', 'Introductory Package Ultra', 'Ultra Package fit for people who are willing to take their first steps to greatness in Ourzobia PHP.', 12000.00, 17000.00, 12000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 3, '#51b749', NULL),
(9, 'Midi Goldbar', 'Introductory Package Midi', 'Midi Package fit for people who are willing to take their first steps to greatness in Ourzobia PHP.', 7500.00, 11500.00, 7500.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 2, '#fbd75b', NULL),
(10, 'Mini Goldbar', 'Mini Introductory Package', 'Mini Package fit for people who are willing to take their first steps to greatness in Ourzobia PHP.', 5000.00, 7400.00, 5000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 4, '#7bd148', NULL),
(11, 'Medium Goldbar', 'Medium Introductory Package', 'Medium Package fit for people who are willing to take their first steps to greatness in Ourzobia PHP.', 3000.00, 4400.00, 3000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 3, '#a4bdfc', NULL),
(12, 'Lite Goldbar', 'Lite Introductory Package', 'Lite Package fit for people who are willing to take their first steps to greatness in Ourzobia PHP.', 2000.00, 2900.00, 2000.00, 1, 50, 7, 3, 'days', 1, NULL, NULL, 2, '#ff7537', NULL),
(13, 'Small Crate of Gold', 'The next step is perfection', 'When you are ready to make a new leap and step up, this is the perfectly small plan.', 23000.00, 40000.00, 23000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 4, '#ffc107', NULL),
(14, 'Small Bag of Gold', 'The bigger things might look small at first', 'Grow your small OV Gold merchandise at the right time, one step at a time is how to grow.', 62000.00, 92000.00, 62000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 3, '#d3a20c', NULL),
(15, 'Medium Box of Gold', 'Growth begins when you choose to leave the middle', 'There is no better way to get along with the concept of increase than understanding it.', 210000.00, 314000.00, 210000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 4, '#dc2127', NULL),
(16, 'Small Box of Gold', 'Growth begins when you choose to begin', 'There is no better way to get along with the concept of increase than understanding it from scratch.', 140000.00, 209000.00, 140000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 2, '#ff887c', NULL),
(17, 'Small Gold Vault', 'You begin small before you proceed', 'Just when you feel you have it all, you dawn on the realization of the want for a little more.', 473000.00, 709000.00, 473000.00, 0, 50, 7, 3, 'days', 1, NULL, NULL, 5, '#a4bdfc', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pairing`
--

CREATE TABLE `pairing` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `pledge_id` int(11) DEFAULT NULL,
  `cashout_id` int(11) DEFAULT NULL,
  `pairer_id` varchar(11) NOT NULL DEFAULT 'system',
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','confirm') NOT NULL DEFAULT 'pending',
  `pop` varchar(128) DEFAULT NULL,
  `channel` varchar(128) DEFAULT NULL,
  `bank_code` varchar(128) DEFAULT NULL,
  `reported` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 

--
-- Table structure for table `pledges`
--

CREATE TABLE `pledges` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','paired','pop','paid','pre_cashout','cashout') NOT NULL DEFAULT 'pending',
  `type` varchar(123) DEFAULT '1',
  `logins` int(11) NOT NULL DEFAULT 1,
  `recommit_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `ref_paid` int(11) NOT NULL DEFAULT 0,
  `ini_pledge` int(11) NOT NULL DEFAULT 0,
  `recommit_skip` int(11) NOT NULL DEFAULT 0,
  `date` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 

--
-- Table structure for table `pledges_deleted`
--

CREATE TABLE `pledges_deleted` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pledge_id` int(11) NOT NULL,
  `pledge_date` int(11) DEFAULT NULL,
  `pledge_amount` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pledge_type` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_status` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `link` varchar(3000) DEFAULT NULL,
  `file` varchar(3000) DEFAULT NULL,
  `thumbnail` varchar(3000) DEFAULT NULL,
  `youtube` varchar(150) DEFAULT NULL,
  `meta` text DEFAULT NULL,
  `time` varchar(100) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT '',
  `views` int(11) NOT NULL DEFAULT 0,
  `shares` int(11) NOT NULL DEFAULT 0,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `featured` int(11) NOT NULL DEFAULT 0,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 

--
-- Table structure for table `prepaid`
--

CREATE TABLE `prepaid` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pledge_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','paired','paid') NOT NULL DEFAULT 'pending',
  `date` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `type` varchar(128) DEFAULT NULL,
  `severity` int(11) NOT NULL DEFAULT 1,
  `details` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'site_name', 'Ourzobia PHP'),
(2, 'payment_ref_pref', 'OZB-'),
(3, 'site_currency', 'NGN'),
(4, 'currency_symbol', '$'),
(5, 'ip_interval', '2'),
(6, 'site_logo', 'uploads/content/site_logo.png'),
(7, 'contact_email', 'support@ourzobiaphp.cf'),
(8, 'contact_phone', '09028996764'),
(9, 'contact_address', ''),
(10, 'contact_facebook', 'https://facebook.com/Ourzobia'),
(11, 'paystack_public', ''),
(12, 'paystack_secret', ''),
(13, 'offline_access', '1'),
(14, 'currency_name', 'Naira'),
(43, 'show_link_back', '0'),
(44, 'des_fixed_layout', ' layout-fixed'),
(48, 'des_nav_border', ' border-bottom-0'),
(49, 'des_body_small_text', ''),
(50, 'des_nav_small_text', ''),
(51, 'des_sidenav_small_text', ''),
(52, 'des_footer_small_text', ''),
(53, 'des_flat_nav', ''),
(55, 'des_legacy_nav', ''),
(56, 'des_compact_nav', ''),
(59, 'des_disable_sidebar', ' sidebar-no-expand'),
(60, 'des_disable_sidebar_expand', ' sidebar-no-expand'),
(61, 'des_small_brand', ''),
(62, 'des_nav_variant', ' navbar-light navbar-warning'),
(63, 'des_accent_color_variant', ' accent-success'),
(64, 'des_sidebar_variants', ' sidebar-dark-success'),
(65, 'des_logo_skin', ' navbar-success'),
(66, 'exclusive_amounts', '1000,2000,3000,4000,5000,10000,20000,30000,40000,50000,100000,300000,500000,1000000'),
(67, 'total_daily_percent', '0'),
(68, 'pre_withdraw', '15'),
(69, 'ref_percentage', '3'),
(70, 'activation_fee', '1000'),
(71, 'pay_activation_to', '634'),
(72, 'no_activator_msg', 'An error occurred, please try again after some! '),
(73, 'min_ref_withdraw', '5000'),
(74, 'site_theme', 'socially'),
(75, 'admin_theme', 'default'),
(76, 'max_pending', '1'),
(77, 'auto_m_cashout', '0'),
(78, 'auto_m_pledge', '0'),
(79, 'cron_jobs', '2'),
(80, 'recommitment', '1'),
(81, 'guider_credit_qualifier', '50000'),
(82, 'guider_level', 'king'),
(83, 'front_percentage', '50'),
(84, 'vision', 'To create an online village where people work, buy and sell to make a life, not just a living. '),
(85, 'mission', 'To create the world\'s first ever self sustained, fully automated, social media integrated online village, where members rise by lifting other members, with quick, secure and safe peer-to-peer village market structure where everyone grows financially.'),
(86, 'value', ''),
(87, 'enforce_upgrade', '5'),
(88, 'tawk_id', '5eff6d71760b2b560e6fb2dc'),
(89, 'truthful', '0'),
(90, 'contact_hours', '                            <ul>\r\n                                <li>Monday - Friday: 9:00 am - 8:00 pm</li>\r\n                                <li>Saturday: 11:00 am - 4:00 pm</li>\r\n                                <li>Sunday: 3:00 pm - 6:00 pm</li>\r\n                            </ul>'),
(91, 'des_indent_nav', ' nav-child-indent'),
(92, 'reactivation_fee', '30%'),
(93, 'default_guider', 'system'),
(94, 'country_code', '234'),
(95, 'contact_days', ''),
(96, 'contact_twitter', ''),
(97, 'contact_instagram', ''),
(98, 'prev_def_guider', 'system'),
(99, 'theme_mode', 'light'),
(100, 'truthful', '0'),
(101, 'truthful', '0'),
(102, 'total_daily_percent', '0'),
(103, 'reactivation_fee_monthly', '1000'),
(104, 'last_pledge_equals_ref', '1'),
(105, 'tax', '0.5%'),
(106, 'enforce_tax', '0'),
(107, 'tax_force_cap', '1000'),
(108, 'max_pledge_auto_pair', '100000'),
(109, 'max_cashout_auto_pair', '90000'),
(110, 'reg_mode', '1'),
(111, 'email_template', '<meta charset=\"utf-8\"> <!-- utf-8 works for most cases -->\r\n<meta name=\"viewport\" content=\"width=device-width\"> <!-- Forcing initial-scale shouldn\'t be necessary -->\r\n<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <!-- Use the latest (edge) version of IE rendering engine -->\r\n<meta name=\"x-apple-disable-message-reformatting\"> <!-- Disable auto-scale in iOS 10 Mail entirely -->\r\n<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700\" rel=\"stylesheet\">\r\n\r\n<!-- CSS Reset : BEGIN -->\r\n<style>\r\n    /* What it does: Remove spaces around the email design added by some email clients. */\r\n    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */\r\n    html,\r\n    body {\r\n        margin: 0 auto !important;\r\n        padding: 0 !important;\r\n        height: 100% !important;\r\n        width: 100% !important;\r\n        background: #f1f1f1;\r\n    }\r\n    \r\n    /* What it does: Stops email clients resizing small text. */\r\n    * {\r\n        -ms-text-size-adjust: 100%;\r\n        -webkit-text-size-adjust: 100%;\r\n    }\r\n    \r\n    /* What it does: Centers email on Android 4.4 */\r\n    div[style*=\"margin: 16px 0\"] {\r\n        margin: 0 !important;\r\n    }\r\n    \r\n    /* What it does: Stops Outlook from adding extra spacing to tables. */\r\n    table,\r\n    td {\r\n        mso-table-lspace: 0pt !important;\r\n        mso-table-rspace: 0pt !important;\r\n    }\r\n    \r\n    /* What it does: Fixes webkit padding issue. */\r\n    table {\r\n        border-spacing: 0 !important;\r\n        border-collapse: collapse !important;\r\n        table-layout: fixed !important;\r\n        margin: 0 auto !important;\r\n    }\r\n    \r\n    /* What it does: Uses a better rendering method when resizing images in IE. */\r\n    img {\r\n        -ms-interpolation-mode:bicubic;\r\n    }\r\n    \r\n    /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */\r\n    a {\r\n        text-decoration: none;\r\n    }\r\n    \r\n    /* What it does: A work-around for email clients meddling in triggered links. */\r\n    *[x-apple-data-detectors],  /* iOS */\r\n    .unstyle-auto-detected-links *,\r\n    .aBn {\r\n        border-bottom: 0 !important;\r\n        cursor: default !important;\r\n        color: inherit !important;\r\n        text-decoration: none !important;\r\n        font-size: inherit !important;\r\n        font-family: inherit !important;\r\n        font-weight: inherit !important;\r\n        line-height: inherit !important;\r\n    }\r\n    \r\n    /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */\r\n    .a6S {\r\n        display: none !important;\r\n        opacity: 0.01 !important;\r\n    }\r\n    \r\n    /* What it does: Prevents Gmail from changing the text color in conversation threads. */\r\n    .im {\r\n        color: inherit !important;\r\n    }\r\n    \r\n    /* If the above doesn\'t work, add a .g-img class to any image in question. */\r\n    img.g-img + div {\r\n        display: none !important;\r\n    }\r\n    \r\n    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */\r\n    /* Create one of these media queries for each additional viewport size you\'d like to fix */\r\n    \r\n    /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */\r\n    @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {\r\n        u ~ div .email-container {\r\n    min-width: 320px !important;\r\n        }\r\n    }\r\n    /* iPhone 6, 6S, 7, 8, and X */\r\n    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\r\n        u ~ div .email-container {\r\n    min-width: 375px !important;\r\n        }\r\n    }\r\n    /* iPhone 6+, 7+, and 8+ */\r\n    @media only screen and (min-device-width: 414px) {\r\n        u ~ div .email-container {\r\n    min-width: 414px !important;\r\n        }\r\n    }\r\n    \r\n</style>\r\n\r\n<!-- CSS Reset : END -->\r\n\r\n<!-- Progressive Enhancements : BEGIN -->\r\n<style>\r\n    .primary{\r\n      background: #30e3ca;\r\n    }\r\n    .bg_white{\r\n     background: #ffffff;\r\n    }\r\n    .bg_light{\r\n     background: #fafafa;\r\n    }\r\n    .bg_black{\r\n     background: #000000;\r\n    }\r\n    .bg_dark{\r\n      background: rgba(0,0,0,.8);\r\n    }\r\n    .email-section{\r\n     padding:2.5em;\r\n    }\r\n    \r\n    /*BUTTON*/\r\n    .btn{\r\n      padding: 10px 15px;\r\n     display: inline-block;\r\n    }\r\n    .btn.btn-primary{\r\n      border-radius: 5px;\r\n     background: #30e3ca;\r\n      color: #ffffff;\r\n    }\r\n    .btn.btn-white{\r\n     border-radius: 5px;\r\n     background: #ffffff;\r\n      color: #000000;\r\n    }\r\n    .btn.btn-white-outline{\r\n     border-radius: 5px;\r\n     background: transparent;\r\n      border: 1px solid #fff;\r\n     color: #fff;\r\n    }\r\n    .btn.btn-black-outline{\r\n      border-radius: 0px;\r\n     background: transparent;\r\n      border: 2px solid #000;\r\n     color: #000;\r\n      font-weight: 700;\r\n    }\r\n    \r\n    h1,h2,h3,h4,h5,h6{\r\n      font-family: \'Lato\', sans-serif;\r\n      color: #000000;\r\n     margin-top: 0;\r\n      font-weight: 400;\r\n    }\r\n    \r\n    body{\r\n     font-family: \'Lato\', sans-serif;\r\n      font-weight: 400;\r\n     font-size: 15px;\r\n      line-height: 1.8;\r\n     color: rgba(0,0,0,.4);\r\n    }\r\n    \r\n    a{\r\n     color: #30e3ca;\r\n    }\r\n    \r\n    table{\r\n    }\r\n    /*LOGO*/\r\n    \r\n    .logo h1{\r\n      margin: 0;\r\n    }\r\n    .logo h1 a{\r\n      color: #30e3ca;\r\n     font-size: 24px;\r\n      font-weight: 700;\r\n     font-family: \'Lato\', sans-serif;\r\n    }\r\n    \r\n    /*HERO*/\r\n    .hero{\r\n     position: relative;\r\n     z-index: 0;\r\n    }\r\n    \r\n    .hero .text{\r\n      color: rgba(0,0,0,.3);\r\n    }\r\n    .hero .text h2{\r\n      color: #000;\r\n      font-size: 40px;\r\n      margin-bottom: 0;\r\n     font-weight: 400;\r\n     line-height: 1.4;\r\n    }\r\n    .hero .text h3{\r\n     font-size: 24px;\r\n      font-weight: 300;\r\n    }\r\n    .hero .text h2 span{\r\n      font-weight: 600;\r\n     color: #30e3ca;\r\n    }\r\n    \r\n    \r\n    /*HEADING SECTION*/\r\n    .heading-section{\r\n    }\r\n    .heading-section h2{\r\n     color: #000000;\r\n     font-size: 28px;\r\n      margin-top: 0;\r\n      line-height: 1.4;\r\n     font-weight: 400;\r\n    }\r\n    .heading-section .subheading{\r\n     margin-bottom: 20px !important;\r\n     display: inline-block;\r\n      font-size: 13px;\r\n      text-transform: uppercase;\r\n      letter-spacing: 2px;\r\n      color: rgba(0,0,0,.4);\r\n      position: relative;\r\n    }\r\n    .heading-section .subheading::after{\r\n      position: absolute;\r\n     left: 0;\r\n      right: 0;\r\n     bottom: -10px;\r\n      content: \'\';\r\n      width: 100%;\r\n      height: 2px;\r\n      background: #30e3ca;\r\n      margin: 0 auto;\r\n    }\r\n    \r\n    .heading-section-white{\r\n     color: rgba(255,255,255,.8);\r\n    }\r\n    .heading-section-white h2{\r\n     font-family: \r\n     line-height: 1;\r\n     padding-bottom: 0;\r\n    }\r\n    .heading-section-white h2{\r\n     color: #ffffff;\r\n    }\r\n    .heading-section-white .subheading{\r\n     margin-bottom: 0;\r\n     display: inline-block;\r\n      font-size: 13px;\r\n      text-transform: uppercase;\r\n      letter-spacing: 2px;\r\n      color: rgba(255,255,255,.4);\r\n    }\r\n    \r\n    \r\n    ul.social{\r\n     padding: 0;\r\n    }\r\n    ul.social li{\r\n     display: inline-block;\r\n      margin-right: 10px;\r\n    }\r\n    \r\n    /*FOOTER*/\r\n    \r\n    .footer{\r\n      border-top: 1px solid rgba(0,0,0,.05);\r\n      color: rgba(0,0,0,.5);\r\n    }\r\n    .footer .heading{\r\n      color: #000;\r\n      font-size: 20px;\r\n    }\r\n    .footer ul{\r\n      margin: 0;\r\n      padding: 0;\r\n    }\r\n    .footer ul li{\r\n      list-style: none;\r\n     margin-bottom: 10px;\r\n    }\r\n    .footer ul li a{\r\n     color: rgba(0,0,0,1);\r\n    }\r\n    \r\n    \r\n    @media screen and (max-width: 500px) {\r\n    \r\n    \r\n    }\r\n    \r\n    \r\n</style>\r\n\r\n\r\n\r\n\r\n\r\n<center style=\"width: 100%; background-color: #f1f1f1;\">\r\n    <div style=\"display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;\">\r\n        ‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;\r\n    </div>\r\n    <div style=\"max-width: 600px; margin: 0 auto;\" class=\"email-container\">\r\n        <!-- BEGIN BODY -->\r\n        <table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">\r\n            <tbody>\r\n                <tr>\r\n                    <td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">\r\n                        <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td class=\"logo\" style=\"text-align: center;\">\r\n                                        <h1>{$conf=site_name}</h1>\r\n                                        <img src=\"{$conf=logo}\" alt=\"\" style=\"width: 100px; max-width: 100px; height: auto; margin: auto; display: block;\">\r\n                                    </td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>\r\n                    </td>\r\n                </tr><!-- end tr -->\r\n                <tr>\r\n                    <td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">\r\n                        Hello {$user}</td>\r\n                </tr><!-- end tr -->\r\n                <!--<tr>-->\r\n                <!--<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 3em 0 2em 0;\">-->\r\n                <!--<img src=\"{$conf=logo}\" alt=\"\" style=\"width: 300px; max-width: 600px; height: auto; margin: auto; display: block;\">-->\r\n                <!--</td>-->\r\n                <!--</tr><!-- end tr -->\r\n                <tr>\r\n                    <td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 2em 0 4em 0;\">\r\n                        <table>\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td>\r\n                                        <div class=\"text\" style=\"padding: 0 2.5em; text-align: center;\">\r\n                                            <h2>\r\n                                                <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">{$title}</h2>\r\n                                            <h3>{$message}</h3>\r\n                                            <p>[link={$link} class=btn btn-primary] {$link_title} [/link]</p>\r\n                                        </div>\r\n                                    </td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>\r\n                    </td>\r\n                </tr><!-- end tr -->\r\n                <!-- 1 Column Text + Button : END -->\r\n            </tbody>\r\n        </table>\r\n        <table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">\r\n            <tbody>\r\n                <tr>\r\n                    <td class=\"bg_light\" style=\"text-align: center;\">\r\n                        <p>You are receiving this email because you created an account on&nbsp;<a href=\"{$conf=site_url}\" style=\"color: rgba(0,0,0,.8);\">{$conf=site_name}</a>, if you no longer want to get this email, please contact support to delete your account.</p>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n\r\n    </div>\r\n</center>'),
(112, 'favicon', 'uploads/content/favicon.png'),
(113, 'login_banner', 'uploads/content/login_banner.jpg'),
(114, 'show_loader', '0'),
(115, 'email_protocol', 'SMTP'),
(116, 'smtp_crypto', 'tls'),
(117, 'mailpath', '/usr/sbin/sendmail'),
(118, 'smtp_host', 'mail.ourzobiaphp.cf'),
(119, 'smtp_port', '587'),
(120, 'smtp_user', 'support@ourzobiaphp.cf'),
(121, 'smtp_pass', 'schalkboy11@'),
(122, 'start_posting', '06:00'),
(123, 'stop_posting', '23:59'),
(124, 'site_mode', '2'),
(125, 'show_countdown', '0'),
(126, 'countdown_time', '2020-08-13 12:00:00'),
(127, 'shutdown_message', 'Ourzobia PHP will officially launch in'),
(128, 'google_analytics_key', 'UA-150997403-3'),
(129, 'default_banner', 'uploads/content/default_banner.jpg'),
(130, 'post_after_time', '60'),
(131, 'show_loader_pages', 'playground'),
(132, 'site_slogan', 'We rise by lifting others'),
(133, 'site_keywords', 'Social, Playground, Investment, Social Investments, Make Money Online, Build Communities, Invest, Grow, Financially, Finances, Network, Meet, People, New, Something Different, '),
(134, 'site_description', 'Discover A brand new way to meetup and make profit in Ourzobia PHP. NO EXPERIENCE needed, NO TRAINING required, everything has been made Simple and very Easy.'),
(135, 'fb_app_id', '647390476216383'),
(136, 'timeout_action', '2'),
(137, '_countdown_time', '2020-08-13 12:00:00'),
(138, 'timeout_message', 'Ourzobia PHP will officially launch in'),
(139, 'contact_telegram', 'https://t.me/ourzobia'),
(140, 'perpage', '15'),
(141, 'perpost', '10'),
(142, 'pagination', 'scroll'),
(143, 'force_testimony', '1'),
(144, 'leader_board', '0');

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES   
('restrictions', '0'),
('send_welcome', '0'),
('send_activation', '1'),
('email_welcome', 'Hello {$user} welcome to {$conf=site_name} , Your account has been activated.'),
('email_activation', 'Hello {$user} welcome to {$conf=site_name} , Please activate your account.'),
('email_token', 'You or someone requested token access to your account on {$conf=site_name} if you do not recognize this action you don\'t have to do anything, otherwise, copy and paste the link below on to your browser\'s address bar if you are unable to click on it.<br>{$anchor_link}, treat this link as you would your password.'),
('email_incognito', 'You or someone requested incognito access to {$conf=site_name} if you do not recognize this action you don\'t have to do anything, otherwise, copy and paste the link below on to your browser\'s address bar if you are unable to click on it.<br>{$anchor_link}, <p>All your records and investments would be deleted if an abuse to Incognito access is traced back to you.</p>'),
('email_recovery', 'You or someone requested a password reset for your account on {$conf=site_name} if you do not recognize this action you don\'t have to do anything, otherwise, copy and paste the link below on to your browser\'s address bar if you are unable to click on it.<br>{$anchor_link}'),
('mail_debug', '1');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `username` varchar(128) DEFAULT NULL,
  `admin_name` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone_code` varchar(128) DEFAULT NULL,
  `phone_number` varchar(128) DEFAULT NULL,
  `fullname` varchar(128) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `nuban` varchar(128) DEFAULT NULL,
  `crypto_wallets` text NULL DEFAULT NULL,
  `bank_code` varchar(128) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `credits` decimal(10,2) NOT NULL DEFAULT 0.00,
  `withdrawable` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fees` decimal(10,2) NOT NULL DEFAULT 0.00,
  `benefit` int(11) DEFAULT NULL,
  `credit_out` int(11) NOT NULL DEFAULT 0,
  `ini_cashout` int(11) NOT NULL DEFAULT 0,
  `ini_ref` int(11) NOT NULL DEFAULT 0,
  `last_pledge` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `prepaid` int(11) NOT NULL DEFAULT 0,
  `package` int(11) DEFAULT NULL,
  `referrer` int(11) DEFAULT NULL,
  `guider` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(4) NOT NULL DEFAULT 2,
  `verified` INT(4) NOT NULL DEFAULT 1,
  `last_activation` int(11) NOT NULL DEFAULT 0,
  `support_code` varchar(128) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `uip` varchar(128) DEFAULT NULL,
  `reg_time` int(11) NOT NULL,
  `last_update` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `admin_name`, `email`, `phone_code`, `phone_number`, `fullname`, `avatar`, `cover`, `nuban`, `bank_code`, `account_type`, `credits`, `withdrawable`, `tax`, `fees`, `benefit`, `credit_out`, `ini_cashout`, `ini_ref`, `last_pledge`, `level`, `admin`, `prepaid`, `package`, `referrer`, `guider`, `password`, `status`, `last_activation`, `support_code`, `token`, `uip`, `reg_time`, `last_update`, `deleted`) VALUES
(1, 'system', NULL, 'system.ng@system.system', '43', '09000000000', 'System User', NULL, NULL, '0000000000', '011', NULL, 800.00, 0.00, 0.00, 0.00, NULL, 0, 0, 0, 0, 3, 1, 0, 1, NULL, 3, '$2y$10$SQEUSgxUcRCGdpRpFoVcNOH8vtmgsiI4wzxEE8paGn1AU5LYUGcjS', 2, 0, NULL, NULL, NULL, 1594015919, 1596618121, NULL);
--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifier_id` (`uid`);

--
-- Indexes for table `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `cashout`
--
ALTER TABLE `cashout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `pair_id` (`pledge_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`,`safelink`) USING BTREE,
  ADD UNIQUE KEY `safelink_1` (`safelink`),
  ADD KEY `safelink` (`safelink`) USING BTREE;

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `track_id` (`uid`),
  ADD KEY `user_id` (`item_id`),
  ADD KEY `time` (`time`);

--
-- Indexes for table `notice_board`
--
ALTER TABLE `notice_board`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipient_id` (`recipient_id`),
  ADD KEY `notifier_id` (`notifier_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pairing`
--
ALTER TABLE `pairing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `pairing_pledges_set` (`pledge_id`),
  ADD KEY `pairing_cashout_set` (`cashout_id`);

--
-- Indexes for table `pledges`
--
ALTER TABLE `pledges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `pledges_deleted`
--
ALTER TABLE `pledges_deleted`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `pledge_id` (`pledge_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`uid`);

--
-- Indexes for table `prepaid`
--
ALTER TABLE `prepaid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `pair_id` (`pledge_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `uip` (`uip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `analytics`
--
ALTER TABLE `analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashout`
--
ALTER TABLE `cashout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notice_board`
--
ALTER TABLE `notice_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pairing`
--
ALTER TABLE `pairing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pledges`
--
ALTER TABLE `pledges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pledges_deleted`
--
ALTER TABLE `pledges_deleted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prepaid`
--
ALTER TABLE `prepaid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cashout`
--
ALTER TABLE `cashout`
  ADD CONSTRAINT `cashout_pledges_set` FOREIGN KEY (`pledge_id`) REFERENCES `pledges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `post_comment_fkc` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pairing`
--
ALTER TABLE `pairing`
  ADD CONSTRAINT `pairing_pledges_set` FOREIGN KEY (`pledge_id`) REFERENCES `pledges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pledges`
--
ALTER TABLE `pledges`
  ADD CONSTRAINT `users_pledges_set` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Constraints for table `prepaid`
--
ALTER TABLE `prepaid`
  ADD CONSTRAINT `prepaid_pledges_set` FOREIGN KEY (`pledge_id`) REFERENCES `pledges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;