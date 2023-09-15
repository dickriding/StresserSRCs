-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 05, 2023 at 03:32 PM
-- Server version: 8.0.33
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hinryxmwkbscpqej_sus`
--

-- --------------------------------------------------------

--
-- Table structure for table `2authsettings`
--

CREATE TABLE `2authsettings` (
  `secret` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int NOT NULL,
  `admin` varchar(64) NOT NULL,
  `client` varchar(64) NOT NULL,
  `action` varchar(6444) NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `affiliateWithdraws`
--

CREATE TABLE `affiliateWithdraws` (
  `ID` int NOT NULL,
  `userID` int NOT NULL,
  `withdrawAmount` varchar(255) NOT NULL,
  `paymentMethod` varchar(255) NOT NULL,
  `paymentAddress` varchar(255) NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE `api` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `api` varchar(1024) NOT NULL,
  `slots` int NOT NULL,
  `methods` varchar(100) NOT NULL,
  `vip` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api`
--

INSERT INTO `api` (`id`, `name`, `api`, `slots`, `methods`, `vip`) VALUES
(78, 'Layer 4', 'https://slackanet.com/api.php?key=45d2pUXDaXNn&target=[host]&port=[port]&duration=[time]&method=[method]', 6, 'DNS MIXAMP TCP OVH-TCP RAKNET SOCKET NTP SADP UDP', 0),
(79, 'Layer 7', 'https://slackanet.com/api.php?key=45d2pUXDaXNn&target=[host]&port=443&duration=[time]&method=[method]', 6, 'BYPASS BROWSER HTTPS KRBYPASS CNBYPASS', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `username` varchar(15) NOT NULL,
  `reason` varchar(1024) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bans`
--

INSERT INTO `bans` (`username`, `reason`) VALUES
('nihao111', ''),
('nihao111', ''),
('voexa', 'kid'),
('voexa', ''),
('radrian98', 'abusing'),
('radrian98', ''),
('nihao222', 'Double conning isnt allowed'),
('nihao222', ''),
('Polimist', 'cleared chat before buying a plan/time waster'),
('feiji', 'Time waster, tries to fool us for free test attack'),
('shdh', 'using an alt'),
('Ketch', 'test'),
('Ketch', ''),
('Ketch', 'time waster'),
('yaru43', 'being a fucking idiot');

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE `blacklist` (
  `ID` int NOT NULL,
  `data` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int NOT NULL,
  `question` varchar(1024) NOT NULL,
  `answer` varchar(5000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fe`
--

CREATE TABLE `fe` (
  `ID` int NOT NULL,
  `userID` int NOT NULL,
  `type` varchar(1) NOT NULL,
  `ip` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `giftcards`
--

CREATE TABLE `giftcards` (
  `ID` int NOT NULL,
  `code` varchar(255) NOT NULL,
  `planID` int NOT NULL,
  `claimedby` int NOT NULL,
  `dateClaimed` int NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `giftcards`
--

INSERT INTO `giftcards` (`ID`, `code`, `planID`, `claimedby`, `dateClaimed`, `date`) VALUES
(1, 'r4y6l28yk3', 44, 161, 1685368982, 1685368961);

-- --------------------------------------------------------

--
-- Table structure for table `iplogs`
--

CREATE TABLE `iplogs` (
  `ID` int NOT NULL,
  `userID` int NOT NULL,
  `logged` varchar(15) NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loginlogs`
--

CREATE TABLE `loginlogs` (
  `username` varchar(15) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `date` int NOT NULL,
  `country` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int NOT NULL,
  `user` varchar(15) NOT NULL,
  `ip` varchar(1024) NOT NULL,
  `time` int NOT NULL,
  `method` varchar(10) NOT NULL,
  `postdata` varchar(10) NOT NULL,
  `mode` varchar(20) NOT NULL,
  `ratelimit` varchar(10) NOT NULL,
  `cookie` varchar(10) NOT NULL,
  `date` int NOT NULL,
  `chart` varchar(255) NOT NULL,
  `stopped` int NOT NULL DEFAULT '0',
  `handler` varchar(1000) NOT NULL,
  `origin` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageid` int NOT NULL,
  `ticketid` int NOT NULL,
  `content` text NOT NULL,
  `sender` varchar(30) NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageid`, `ticketid`, `content`, `sender`, `date`) VALUES
(1, 1, 'Hello!', 'Admin', 1642257986),
(2, 1, '21321', 'Client', 1642268193),
(3, 1, '342432', 'Admin', 1642268210),
(4, 1, '342432', 'Admin', 1642268212),
(5, 1, '342432', 'Admin', 1642268212),
(6, 1, '342432', 'Admin', 1642268212),
(7, 1, '342432', 'Admin', 1642268212),
(8, 1, '342432', 'Admin', 1642268213),
(9, 2, 'No', 'Admin', 1642345622),
(10, 3, 'sex', 'Admin', 1642345635),
(11, 7, '5345', 'Admin', 1642850631),
(12, 7, '534543555555555555', 'Admin', 1642850633),
(13, 7, '534543555555555555', 'Admin', 1642850634),
(14, 7, '534543555555555555', 'Admin', 1642850634),
(15, 7, '534543555555555555', 'Admin', 1642850635),
(16, 7, '534543555555555555', 'Admin', 1642850636);

-- --------------------------------------------------------

--
-- Table structure for table `methods`
--

CREATE TABLE `methods` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `type` varchar(6) NOT NULL,
  `command` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `methods`
--

INSERT INTO `methods` (`id`, `name`, `fullname`, `type`, `command`) VALUES
(95, 'BYPASS', 'BYPASS', 'layer7', ''),
(100, 'DNS', 'DNS', 'layer4', ''),
(82, 'MIXAMP', 'MIXAMP', 'layer4', ''),
(96, 'BROWSER', 'BROWSER', 'layer7', ''),
(84, 'TCP', 'TCP', 'layer4', ''),
(85, 'OVH-TCP', 'OVH-TCP', 'layer4', ''),
(86, 'RAKNET', 'RAKNET', 'layer4', ''),
(94, 'HTTPS', 'HTTPS', 'layer7', ''),
(98, 'KRBYPASS', 'KRBYPASS', 'layer7', ''),
(90, 'SOCKET', 'SOCKET', 'layer4', ''),
(91, 'NTP', 'NTP', 'layer4', ''),
(97, 'CNBYPASS', 'CNBYPASS', 'layer7', ''),
(93, 'SADP', 'SADP', 'layer4', ''),
(99, 'UDP', 'UDP', 'layer4', '');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `ID` int NOT NULL,
  `title` varchar(1024) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `date` varchar(55) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`ID`, `title`, `content`, `date`) VALUES
(4, 'News #1', 'The hub was updated and divided into L4 and L7. L4 servers were added.\r\n</br> Our telegram channel is https://t.me/vuestress', '');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `ID` int NOT NULL,
  `paid` float NOT NULL,
  `plan` int NOT NULL,
  `user` int NOT NULL,
  `email` varchar(60) NOT NULL,
  `tid` varchar(30) NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ping_sessions`
--

CREATE TABLE `ping_sessions` (
  `ID` int NOT NULL,
  `ping_key` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  `ping_ip` varchar(25) NOT NULL,
  `ping_port` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `ID` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `vip` int NOT NULL,
  `mbt` int NOT NULL,
  `unit` varchar(10) NOT NULL,
  `length` int NOT NULL,
  `price` float NOT NULL,
  `concurrents` int NOT NULL,
  `private` int NOT NULL,
  `api` int NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`ID`, `name`, `vip`, `mbt`, `unit`, `length`, `price`, `concurrents`, `private`, `api`) VALUES
(43, 'Admin', 1, 86400, 'Years', 1000, 2000, 100, 1, 1),
(63, 'Custom 3', 1, 300, 'Days', 30, 125, 7, 1, 1),
(62, 'Custom', 1, 3200, 'Years', 99, 0, 2, 1, 1),
(61, 'Custom 1', 0, 1200, 'Days', 30, 30, 2, 1, 0),
(60, 'Testers', 1, 60, 'Days', 1, 0, 1, 1, 1),
(59, 'yes ', 1, 60, 'Days', 1, 9, 1, 1, 1),
(44, 'Good', 0, 320, 'Days', 30, 45, 3, 1, 1),
(58, 'Strong', 1, 1000, 'Days', 30, 100, 3, 1, 1),
(64, 'customer', 0, 600, 'Days', 30, 45, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `username` varchar(64) NOT NULL,
  `report` varchar(644) NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `slots` int NOT NULL,
  `methods` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `sitename` varchar(1024) NOT NULL,
  `stripePubKey` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cooldown` int NOT NULL,
  `cooldownTime` int NOT NULL,
  `paypal` varchar(50) NOT NULL,
  `bitcoin` varchar(50) NOT NULL,
  `stripe` int NOT NULL,
  `maintaince` varchar(100) NOT NULL,
  `rotation` int NOT NULL DEFAULT '0',
  `unique_attacks` int NOT NULL,
  `system` varchar(7) NOT NULL,
  `maxattacks` int NOT NULL,
  `testboots` int NOT NULL,
  `cloudflare` int NOT NULL,
  `skype` varchar(200) NOT NULL,
  `key` varchar(100) NOT NULL,
  `issuerId` varchar(50) NOT NULL,
  `coinpayments` varchar(50) NOT NULL,
  `ipnSecret` varchar(100) NOT NULL,
  `google_site` varchar(644) NOT NULL,
  `google_secret` varchar(644) NOT NULL,
  `btc_address` varchar(64) NOT NULL,
  `secretKey` varchar(50) NOT NULL,
  `cbp` int NOT NULL,
  `paypal_email` varchar(64) NOT NULL,
  `theme` varchar(64) NOT NULL,
  `logo` varchar(64) NOT NULL,
  `stripeSecretKey` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sitename`, `stripePubKey`, `url`, `description`, `cooldown`, `cooldownTime`, `paypal`, `bitcoin`, `stripe`, `maintaince`, `rotation`, `unique_attacks`, `system`, `maxattacks`, `testboots`, `cloudflare`, `skype`, `key`, `issuerId`, `coinpayments`, `ipnSecret`, `google_site`, `google_secret`, `btc_address`, `secretKey`, `cbp`, `paypal_email`, `theme`, `logo`, `stripeSecretKey`) VALUES
('Vue Stress', '', 'https://vuestress.ru', 'ddosing,ddos attack live,ddos attack explained,ddos protection,ddos tool,ddoser,ddos fortnite,ddos destiny 2,doxing people,ddos attack,ddos attack bangla,ddos app,ddos ark,ddos arrest,a ddos attack,ddos booter,ddos black ops 2,ddos ban wave,ddos bo4,ddos bo2,ddos blocker,ddos batch file,ddos booter free,ddos bot discord,ddos call of duty,ddos cod,ddos computerphile,ddos cs go,ddos cloudflare,ddos cydia tweak,ddos call center,ddos caught,ddos client,ddos cs 1.6 server,attaque ddos c\'est quoi,ddos c\'est quoi,ddos discord,ddos detection,ddos discord bot,ddos destiny,ddos defense,ddos dance team,ddos dog,ddos dead by daylight,how to ddos,ddos explained,ddos email,ddos example,ddos explained for dummies,ddos edureka,ddos exploit,ddos ente,ddos extra life,ddos effects,ddos en live,o\'que e ddos,ataque dos e ddos,ddos fortnite server,ddos fail,ddos free,ddos for hire,ddos fix,ddos fortnite lobby,ddos free booter,ddos flood attack,tf ddos,ddos gta,ddos gaming,ddos gmod,ddos gmod server,ddos gta online,ddos google,ddos gta 5 ps4,ddos guide,ddos game server,ddos gunz,ddos hacking theme,ddos how it works,ddos hypixel,ddos hotspot,ddos hacking theme song mac quayle,ddos hacking song mac quayle,ddos hacking theme 2.0,ddos in action,ddos in fortnite,ddos in game,ddos iphone app,i ddos my school,i got ddosed,i_o ddos,i got ddosed on ps4,i\'m getting ddosed,ddos jensen,ddos jahrein,j1nn ddos,javascript ddos,java ddos,jhalt ddos,jahrein ddos davas? sonucu,sta je ddos,java ddos program,jackal ddos,ddos king,ddos kahoot,ddos ki full form,ddos kali linux tools,ddos kali linux ip,ddos attack kali linux metasploit,kosdff ddos,kaska ddos,ddos live,ddos link,ddos loic,ddos lol,ddos linux terminal,ddos layer 4,ddos live stream,ddos league of legends tutorial,ddos laser cannon,ddos meaning,ddos mitigation,ddos minecraft,ddos mr robot,ddos modern warfare,ddos multi tool,ddos methods,ddos me,ddos news,ddos neighbors,ddos nedir,ddos notepad,ddos ntp,ddos nodejs,ddos nokia,ddos netscout,ddos nopixel,willst n ddos,ddos on iphone,ddos on android,ddos on phone,ddos overwatch,ddos osrs,ddos on peek,ddos on discord,ddos on chromebook,ddos ovh,ddos online tool,como funciona o ddos,o que e ddos,o que é ddos ataque,ddos panel source,ddos prank,ddos prevention,ddos protected vpn,ddos protection router,ddos panel source code,ddos protection minecraft server,ddos priest,ddos que es,mac quayle ddos hacking song,mac quayle ddos,qbot ddos,comment ddos quelqu\'un,ataque ddos que es,tuto ddos quelqu\'un,como quitar ddos ark,ddos o que é,ddos roblox,ddos rainbow six siege xbox,ddos r6,ddos roblox servers,ddos rust server,ddos runescape,ddos reaction,ddos rage,ddos rust,ddos rainbow six siege ban wave,ddos script menu,ddos streamer,ddos sound,ddos sites,ddos stresser,ddos servers,ddos siege,ddos script vps,ddos tool 2021,ddos theme,ddos tf2,ddos tool free,ddos threats,ddos twitch,ddos tool windows,ddos using command prompt,ddos using metasploit,ddos udp flood,ddos using ip,ddos using linux,ddos upgrade,ddos unicorn,ddos using slowloris,ddos using hping3,ddos ubuntu terminal,ddos vs vpn,ddos vpn,ddos vs dos,ddos vrchat,ddos visualization,ddos virus,ddos visual studio,ddos vs soft,ddos vs smurf attack,ddos video games,gta v ddosed,ddos wow,ddos what is it,ddos war,ddos website tool,ddos with loic,ddos wireshark,ddos website 2021,ddos with iphone,ddos with putty,ddos website free,jak ddosowac w minecraft,co to ddos w minecraft,xqc ddos,xerxes ddos attack,xerxes ddos termux,how to ddos r6 xbox,xbox ddos protection,loic ddos,loic ddos tool,xbox criminal ddos,xor ddos,ark xbox ddos,ddos youtube channel,ddos youtube,ddos youtube stream,ddos your own wifi,ddos youtube meaning,ddos your friends,how to ddos your school,ddos yiyen yay?nc?,ddos yapma,ddos zombie nets,atak ddos zwariowany marcin,zephix ddos,zp6x ddos,zambie ddos,ddos zurückverfolgen,ddos zocker,ddos nakit,maszynka ddos za free,zeon ddos,jak z ddosowac kolege,pharmakon ddos 100,vega conflict ddos 100,1tb ddos,top 10 ddos attacks,top 10 ddos tool,cs 1.6 ddos,cs 1.6 ddos atma,cs 1.6 ddos script,cs 1.6 ddos cfg,platinum 1 ddoser,tool ddos 2021,csgo ddos 2021,booter free ddos 2021,best ddos 2021,samp ddos 2021,loic ddos 2021,lol ddos 2021,destiny 2 ddos,best ddos website 2021,black ops 2 ddos,destiny 2 ddos competitive,topic links', 0, 1685303773, '', '', 0, '', 1, 1, 'api', 6, 0, 1, '', '', '', '', '', '', '', '', '', 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `smtpsettings`
--

CREATE TABLE `smtpsettings` (
  `host` varchar(255) NOT NULL,
  `auth` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `port` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int NOT NULL,
  `subject` varchar(1024) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `username` varchar(15) NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `subject`, `content`, `status`, `username`, `date`) VALUES
(1, 'Test', 'Hello!', 'Waiting for user response', 'Kaneki', 1642257963),
(2, 'Hey', 'Do you know, what i have big dick?', 'Closed', 'Swebs', 1642270672),
(3, 'sdad', 'asdad', 'Closed', 'ALH1MIK', 1642345602),
(4, 'dsa', 'das', 'Closed', 'qweqweqwe', 1642415916),
(5, '?????', '???????', 'Closed', 'qweqwe', 1642491956),
(6, '????????', '????', 'Closed', 'qweqwe', 1642491972),
(7, 'sdfsdfsdfs', 'fdsfsdfds', 'Waiting for user response', 'qweqwe', 1642491974),
(8, 'test', 'test', 'Waiting for admin response', 'fdsgfsdgfg', 1643074365),
(9, 'gfd', 'gfd', 'Closed', 'qweqwe1', 1643194193);

-- --------------------------------------------------------

--
-- Table structure for table `tos`
--

CREATE TABLE `tos` (
  `archive` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `rank` int NOT NULL DEFAULT '0',
  `membership` int NOT NULL,
  `expire` int NOT NULL,
  `status` int NOT NULL,
  `referral` varchar(50) NOT NULL,
  `referralbalance` int NOT NULL DEFAULT '0',
  `testattack` int NOT NULL,
  `activity` int NOT NULL DEFAULT '0',
  `2auth` int NOT NULL,
  `referedBy` int NOT NULL,
  `apikey` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `rank`, `membership`, `expire`, `status`, `referral`, `referralbalance`, `testattack`, `activity`, `2auth`, `referedBy`, `apikey`) VALUES
(152, 'williams', '7b5330fa9691b3b8c58b1ab2aad964c7bcdd9f1b', 1, 44, 1686960000, 0, '0', 0, 0, 0, 0, 0, '0'),
(194, 'Broshan', '19a010a0e5c3a64cde28487e51f28bcff0d70c95', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(195, 'Wrench', '3e073c1e929b02c0c52c5179a7969c11465ef861', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(196, 'vbcs', '335a1ce0f4fdf7afb27affa1b6a266a6ffe288c8', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(197, 'ZeroZeusID', '4b6e10a5c98bd87dd80846e9393a34c67cb1d19a', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 'Q891g0MLMmPohHAY'),
(198, 'carlosss', 'ca394dce4cb4694d2ab2c730c9e60e6a0551b214', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(199, 'ayoub', 'ca394dce4cb4694d2ab2c730c9e60e6a0551b214', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(200, 'ayoub66', 'ca394dce4cb4694d2ab2c730c9e60e6a0551b214', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(201, 'ayoub6688', 'ca394dce4cb4694d2ab2c730c9e60e6a0551b214', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(202, 'ayoub66889', 'ca394dce4cb4694d2ab2c730c9e60e6a0551b214', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(203, 'ayoub6688977', 'ca394dce4cb4694d2ab2c730c9e60e6a0551b214', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(204, 'prens', '3b43e979dbd27231fb7280f5a59d9ac7d8e66406', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(205, 'cweed', '3b43e979dbd27231fb7280f5a59d9ac7d8e66406', 0, 61, 1685864537, 0, '0', 0, 1, 0, 0, 0, NULL),
(206, 'ayoub66889771', 'ca394dce4cb4694d2ab2c730c9e60e6a0551b214', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(207, 'Magic', 'c8eca884404f57760e533af4e56b628d9b72f49a', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(208, 'ayoub6688977158', 'ca394dce4cb4694d2ab2c730c9e60e6a0551b214', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(209, 'AryanWNR', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', 0, 60, 1683461899, 0, '0', 0, 0, 0, 0, 0, 'Iwd6qIoyYTuBIkVj'),
(210, 'ayoub668897712', 'f88cfba67e9037c0360c0c3c1664915826d84893', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(211, 'jack78', 'c5d21b77d114d28ff8754bf8f56f7e8ff0568109', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(212, 'kienngo2007', '0ca8863c0ed4595034cb185c350fc08c4d67773a', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(213, 'NayemSA', '42a06c87cd0f29f674dcc3efe4699b2a3a525806', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(214, 'djphantomx2', '8b5afe672b1dcf002711b9662d2f34ddab3e3dc3', 0, 0, 0, 0, '0', 0, 1, 0, 0, 0, NULL),
(215, 'feiji', '34924e305625b4683af73163199eeb3ccdf452c6', 0, 0, 0, 1, '0', 0, 1, 0, 0, 0, NULL),
(216, 'voidhost', '9e4fb9aa80ccdfcf8560b3797533f5a07c2ecbbd', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(217, 'AlaaAhmed', 'ceb45489680a48b75ebf7fb35bfa5b20a936948f', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(218, 'Blackstorm777', '092c75cc4ddb2d912aa2d0e35b63b1420fc3a695', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(219, 'Cleiton', 'f092c13a6299f1cf25270edcd53eb5f173523698', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(220, 'wows', '5e75e79c69644636a75f0dbdd8fef42b0d36db77', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(221, 'Godfather', '179a71ee1792117d06d0725fd515c6ea0b2d610e', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(222, 'Loris94230', 'd8458920356d46f60fdb02051f5986f4a8859fd0', 0, 62, 2147483647, 0, '0', 0, 0, 0, 0, 0, NULL),
(223, 'ion798', '7b0336e612aecb9e03c862d22e876d7efe0cd217', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(224, 'goco', '8793c24a1323a230ff020bc9f5d0a63767a6e54f', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(228, 'twice', '279eca533e52105be77925a98bad1c5227f160fd', 0, 58, 1687764954, 0, '0', 0, 0, 0, 0, 0, '0'),
(225, 'catto', '8f848b81dcf62ea749b29403c6cff8dbd2462f25', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(226, 'whoot', '4e242c56b749402b5cf5346c24c7971bd2d2e7db', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(227, 'Joemama', '71ac4164fe46a9a44a95af34b19d719e2945d83d', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(229, 'DarckZ', 'a4085cd0c2aeeb8966678dd06a4e61a6f2d5dff8', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(230, 'xuanxi', '162008f17f49b739f75bc3cee62013e018f9e4e9', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(231, 'gomu', '97a45d7b83437d012472326e3768b27eb381e766', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(232, 'FDSFDSFDS', '2e35550ada97023ac68b203388fcf1131b5a3cf3', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(233, 'JOKERAARYAN', 'fc99ec89474cbe652dee9e23496d8a5dbc690700', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(234, 'GainProxy123', '2b40310f8309d50110acdd44b4b6e743eefe3572', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(235, 'Testsource', '83840e644f28719bbcc2b35f1d77eaf5044b1585', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(236, 'zamasu', 'c84e74c1a7a5d179a286fb67d49e2e9b7ac05c0e', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(237, 'maodui', '7169a7207b6abc10cebcecae3ac2f64dcd4406fa', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(238, 'Fasoninn', 'dc762eab16a6d97fda748387ff5e5cb895ac05e4', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(239, 'humayun', '714d9826df39c4efdc56c3a899a0fa2a4e3d266e', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(240, 'karinayov88', '573664d39d1182fb81a4ae4285c82812468c07dd', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(241, 'SonuModder', '7516f03484ce52bea6a99380ce234a5e0a3342d7', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(242, 'Lina', '05cc7436e313ca0c84170a8cd76e28c25c5fe599', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(243, 'XM1N21KR1', 'c9d497d690c44d647e4280a210958034e6596619', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(244, 'Gomu', 'd3601ffd56edd31c933ab58423a2f553f37707e1', 0, 44, 1687764705, 0, '0', 0, 0, 0, 0, 0, NULL),
(245, 'drak0nia', '7bf57da7ddae9e6fe45730259ab467958d74bbab', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(246, 'ssszzzaaaa', '91370305408ecc628ca669b34cc51e8e0adc96ad', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, 'i2HaeEQuu5xojio5'),
(247, 'hdd555', '67ac1861f0974e12a7e8bb92a0edd5fab178fc2a', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(248, 'atao90', 'b93d9adef310d6661ffcb981722c0e8ddf3e24d6', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(249, 'pheakpoipet', '5b2141b492205d0bafacbc6b4964ef2816b9165b', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(250, 'Mambica', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(251, 'alican', '2c5aefc8c766b5316acafea03463e0a266627d55', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(252, 'dstatcc', '2993b7111961c95e7c2903352e16ef89a0f53b2b', 0, 44, 1687889297, 0, '0', 0, 0, 0, 0, 0, 'QSs8zLqcyLjoud7v'),
(253, 'Rewin', '484a1e38f2527d257958f06ba40b331936db4d74', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(254, 'teerbtc', '0c5e08fcca1ea2ec1cb8dcf41a292bf1e67e7e8d', 0, 59, 1684496768, 0, '0', 0, 0, 0, 0, 0, NULL),
(257, 'domix478', 'e5a20cc553b894b8592a6b497845afba3cfd4402', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(258, 'Sasi7171', 'e28a7b018810ba99fce53a8742d3b2f71e412c23', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(259, 'v4nn', 'cf8c0fbc467fa4c689f635d06c2c24e275963d23', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(260, '123123', '040bd08a4290267535cd247b8ba2eca129d9fe9f', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(261, 'Kian0528', 'd94cb12507b0a301298a52396c8a9c9bcf12a08b', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(262, 'shdh', '77500b27c66b240e739da9164fa7231145dea054', 0, 0, 0, 1, '0', 0, 0, 0, 0, 0, NULL),
(263, 'Qxtog', '32756a5d43c0d25dcbb4deaaaecd2033bf4f7a92', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(264, 'Riad', '1203f368b3095efa7aecd24afb9ee2e69b32752d', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(265, 'zyiqrdarbflhww', '6f3f836eef1f52d2a4064fd7719918b2fd7c6436', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(266, 're4per', 'b44d2326c2d8ebe636ae90579fb470d575d076ae', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(267, 'X1RAYZ', '7fc26d5276bfea4ca9229390e6e616398ad8eba2', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(268, 'jers3y', '98db1fa1d10401d6fc81f42d857c910f163a4645', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(269, 'damon', '98772932a569afcd6e5fc92ce00a9880bc11d33f', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(270, 'arcturusarc', 'fb322e7272e6aa590d40d5d1841fe7cbbb827cdd', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(271, 'Ketch', '0fbd85eea5c50a5259b2fbe60f2f284545817e39', 0, 0, 1684800000, 1, '0', 0, 0, 0, 0, 0, 'aPQCneebbHuMJ1Xc'),
(272, 'legenddemon', '33f463ea225eefa24ced84ce3d0e5405bc3c8449', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(273, 'Lola', '10470c3b4b1fed12c3baac014be15fac67c6e815', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(274, 'oppomil', 'a1cd46a039cfe427b72f96adba84c4f89aaf299b', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(275, 'Deiv', '50ddd0252313a956da29a9d8c242e9972b00f639', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(276, 'ijij', '4bd96d3e9454f8f4d327819bc008a2928dde5af7', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(277, 'Diocanes', '32756a5d43c0d25dcbb4deaaaecd2033bf4f7a92', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(281, 'ww987987', 'bb9e3467877f6ea52b15087ddedee13f7ba73070', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(282, 'Hsyshsusiu', '7bd2b8f963eef2838b98eb123960a218b3dfafc1', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(283, 'mentalbrute', '124c704ae3455d6ec495c4629f280b4dff694ed9', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(284, 'asf4g432g', 'e7d907fc1ee4985359d40f7e3b48edbb00b5352e', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(285, 'fucknig', 'd70995bf321e954fd1f92ad0f9f3dc036c1c2e0b', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(286, 'vpsvpsip', '796c7474010d16c05867480c17ceab185e88bf0b', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(287, 'toski', '2bb1908e8cc664f36310e6b3adaacf302574cf17', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(288, 'hung8496', '040bd08a4290267535cd247b8ba2eca129d9fe9f', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(289, 'bzone1', '31612048a4e9d336047723a045d7a1f3825bcfcd', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(290, 'd3x73rstresser', '9c7651d1fa4a094a5f777f367b12b8cb922dc096', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(291, 'asadsasdx', '015da2d0c2ea1e049e15212a0a4e672519d7bdec', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(292, 'Damian', '764aa754781e9f926702f0197af8d0a04e77282f', 0, 64, 1687710173, 0, '0', 0, 0, 0, 0, 0, NULL),
(293, 'nayermcard', 'ca9d63f50d24bae49d61ca28016dd8504b11bd13', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(294, 'Daubuoi', 'b2ea7027c08642564a8b1cd4f70a9881c5c124cf', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(295, 'd4rky7', '297075535249edd97259ebed692a5b372187e886', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(296, 'test982', '529c252a5e3ef733bf24f8f8e5799fe8823945a1', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(297, 'mann', '2da6a2e2d33aa9c986334cb91edbf5d86dcc66ee', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(298, 'batata', '040bd08a4290267535cd247b8ba2eca129d9fe9f', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(299, 'murderme', '16675cf0bfab4bb37d65272cfc87b68fbdec28a0', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(300, 'MarioBloxxx121', 'e1e6e2efd9dad9567a996afee79658171b171936', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(301, 'ponpon1', 'af39001604327e9427cd17ac71352d044da29433', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(302, 'asdsadsad', 'a86ec8e4a0e98a69f6198e9d432e98cbc7900a82', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(303, 'Alexita22', '77cce05df1a829f9e1d50b949e1342f547538217', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(304, 'nigge', 'aa2a0f3bcb0327098aa339180f399609984a4ad3', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(305, 'gugugaga', '973e050a2b3fbe8f7a0a9749a839af99a00637a1', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(306, 'orbital', 'b997ffefc4c17a6f6298139f011b57b0bd309b3c', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(307, 'Damon01', 'a2bfec7635e5fa1cda9fb097dc5e5b03791eaac8', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(308, 'badguy', 'ae60154a5849a6e065eadd9380076d9029df95eb', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(310, 'CHAMPISANIGGER', '23b06b5bd593eee94740347025ec3343cb2b29e9', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(311, 'r23r32', '9b38b0106d22b7bff4970995881a5318b940e019', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(312, 'ccplay', '14feeef89481238d660c26f6e6f636405f3f9270', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(313, 'Seized', 'ca4eb9176f8d7b3213b423514620124ce2b86532', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(314, 'test', '3bc014437e2fa94a13c4768e5de9ed64c6db4a8d', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(315, 'haproxy63', '5f607842a781afe9c59246f79a92bd4c30bbb9fe', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(316, 'm1lan27', '84ab8d9ae8008d18ed07523d8abf4e29b98d11ad', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(317, 'orbit', 'd738e625721b5d361f833daa1038e317e36ce1a7', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(318, 'Loud', 'f21502743e7740ade260c60d1f990b60b0cb6940', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(319, 'tobi', '7a3be76e90a211612823d192af648ab086669260', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(320, '187Outer', 'fb65dc8b404c3bccee71a2a90e1abdf18bb13f14', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(326, 'Thanhhp1402', 'fdcaf69a2445d8b6be365856171fa7dfb9c3ea60', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(321, 'mysteri', 'ab3e3eb556113c7edb9e526348b0786e4e1d5c41', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(322, 'alexsander', '6f4bce46d370f40618c87aa0d349ab8029e23f46', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(323, 'Haccuswag', 'a06c04290e2645f62613ec1ef6242ea2c35627f3', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(324, 'Alyssa1234', '32e89b22f7e43525bc6b1e6e493e54752aeaf8f6', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(325, 'NightGTA', 'e25836ada262683ab6820ac120cb7597f41785d9', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(327, 'petkomoje', 'ad69c3c1fb3d5b4d5d2f902eb7620b2da38c294e', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(328, 'p519825', '1713aba30c97e5ea220a82019e8e12100d678039', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(329, 'sfa7isback', '65278b4d3a46e0eb7f0268d7e62482f8bfd53d80', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(330, 'bykyta', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(331, 'iamsajidjaved', 'eaa14e058f26d43302d153208bbfae3e4f94b37a', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(332, 'james', '3aa44d4274d0cb5964525a7d2ca3e4d2cf93548e', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(333, 'Venom331', 'dd27ad7e0a300736eec1969736c22d0b535e25e4', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(334, 'botnet', 'c29d145342feb0e7dfc61fd57c4c9c8036f83d63', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(335, 'zack44', '2bcafcd1fc0a5135374b76aa28c7cc25aa50ea1c', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(336, 'RIN1337', '360a66e8a32ef1ec2a03539f97a602394e8687b0', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(337, 'beterabapvp', 'b4e10a7c574c25c0062b22344c439f3b32d0647e', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(338, 'Abd176', '62be97392f95fadcef4e63139823fdd4416977ad', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(339, 'Falah', 'f73c4d9fab553b33f8a2b49e78ea84e41534d862', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(340, 'eeeeeeeeeee', 'ce562c245f78374a87a12ef83a86959c8fa1ab76', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(341, 'Sukytop', '4617c39032495818d1d73e616eb9757a49ae8831', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(342, 'RexoGer', 'ce2aebe0b7a63674a85ee0a868486fff5c841149', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(343, 'c0ns7', '8c986d1489801af6ade738178c1c72560559c255', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(344, 'async', '6bc8008a7541cb2a66ed38690533213ac3234e52', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(345, 'Janeshfears11', 'cf57155fab90fb417ddbb87c6d31aba3caf7bf02', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(346, 'Hsjxisiixsd', 'd6dbeb0cca0143aca2461adb7337b76f045b910c', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(347, 'ipulpunya', '7a782feb4a62ed8c0fb2866d47e13c9145583959', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(348, 'Mambica2', '56735fdd774b6c423696530c2befc623b2380640', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(349, 'akun', '10470c3b4b1fed12c3baac014be15fac67c6e815', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(350, 'leartbaba31', '589cabde6292a48043e12c3a4c269610b1de4173', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(351, 'Lango', 'd1f32b3f1dfcd97f95c934dd1f92940869da26c9', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(352, '1tekaso', '9a871d7356d1df3eac2551f24471a243fd105d0b', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(353, 'drenicbaba', '93d222d26ed6b8f693eefe486d8b7e94f864ef40', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(354, 'TheluloX', 'c07a2b4ba4f028d9235c7ac60151c71deb63a0c4', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(355, 'dthyfghfgh', '4d6469b49f9baed144681c074bd5174e5e622df9', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(356, 'yaru43', '4831b8968d8af8081f77a18726b490e9e68f557d', 0, 0, 0, 1, '0', 0, 0, 0, 0, 0, NULL),
(357, 'test41', '3d90d47b1b4dff3c5a0eb3cae9bd17f4733383dc', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(358, '3aki', '0f48284e82b39a4cab7f64bc1e1adda9581811e3', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(359, 'Beanerman32', 'a97534f39ceb9f9cda4bdd9e92135500c0142f4b', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(360, 'dgfdgdfgdf', '9b9e8cdff73efa58923d375f4cd097634ac5f2ca', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(361, 'Cookie0000', '46cbebebd828b6381091b6265dccbf681b87bd7e', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(362, 'oweu', '856383f98164c547cc3b02f8f3b0c9d5caf8e807', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL),
(363, 'rager', '9e8a28743c6b2652edeb6ee2bc524adcbc0db03d', 0, 0, 0, 0, '0', 0, 0, 0, 0, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `affiliateWithdraws`
--
ALTER TABLE `affiliateWithdraws`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fe`
--
ALTER TABLE `fe`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `giftcards`
--
ALTER TABLE `giftcards`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `iplogs`
--
ALTER TABLE `iplogs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageid`);

--
-- Indexes for table `methods`
--
ALTER TABLE `methods`
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ping_sessions`
--
ALTER TABLE `ping_sessions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD UNIQUE KEY `key` (`key`),
  ADD KEY `sitename` (`sitename`(767));

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliateWithdraws`
--
ALTER TABLE `affiliateWithdraws`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `api`
--
ALTER TABLE `api`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fe`
--
ALTER TABLE `fe`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `giftcards`
--
ALTER TABLE `giftcards`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `iplogs`
--
ALTER TABLE `iplogs`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `methods`
--
ALTER TABLE `methods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ping_sessions`
--
ALTER TABLE `ping_sessions`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=364;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
