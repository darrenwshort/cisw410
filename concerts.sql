-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 12, 2020 at 10:56 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `concerts`
--
CREATE DATABASE IF NOT EXISTS `concerts` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `concerts`;

-- --------------------------------------------------------

--
-- Table structure for table `bands`
--

DROP TABLE IF EXISTS `bands`;
CREATE TABLE `bands` (
  `bandID` int(11) UNSIGNED NOT NULL,
  `bandName` varchar(50) NOT NULL,
  `noMembers` smallint(5) UNSIGNED DEFAULT 1,
  `biography` text CHARACTER SET utf8 NOT NULL,
  `genreID` int(10) UNSIGNED DEFAULT 10,
  `countryID` int(11) DEFAULT 1,
  `image` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bands`
--

INSERT INTO `bands` (`bandID`, `bandName`, `noMembers`, `biography`, `genreID`, `countryID`, `image`, `thumbnail`) VALUES
(1, 'Iron Maiden', 6, 'Iron Maiden are an English heavy metal band formed in Leyton, East London, in 1975 by bassist and primary songwriter Steve Harris. The band\'s discography has grown to 39 albums, including 16 studio albums, 12 live albums, four EPs, and seven compilations. ', 1, 2, 'ironmaiden-img.jpg', 'ironmaiden-tn.jpg'),
(2, 'Disturbed', 4, 'Disturbed is an American heavy metal band from Chicago, formed in 1994. The band includes vocalist David Draiman, guitarist/keyboardist Dan Donegan, bassist John Moyer and drummer Mike Wengren. Draiman, Donegan and Wengren have been involved in the band since its inception with Moyer replacing former bassist Steve Kmak first as session performer in 2003 and then officially in 2005. ', 1, 1, 'disturbed-img.jpg', 'disturbed-tn.jpg'),
(3, 'Mastodon', 4, 'Mastodon is an American heavy metal band from Atlanta, Georgia, formed in 2000. The group is composed of Troy Sanders (bass/vocals), Brent Hinds (lead guitar/vocals), Bill Kelliher (rhythm guitar), and Brann Dailor (drums/vocals). Mastodon has released seven studio albums, as well as a number of other releases. ', 1, 1, 'mastodon-img.jpg', 'mastodon-tn.jpg'),
(4, 'The Boo Boos', 17, 'The Boo Boos are boo boos of all boo boos!!  ', 15, 2, 'thebooboos-img.jpg', 'thebooboos-tn.jpg'),
(5, 'Staind', 4, 'Staind (/steɪnd/ STAYND) is an American rock band formed in Springfield, Massachusetts, in 1995. The original lineup consisted of lead vocalist and rhythm guitarist Aaron Lewis, lead guitarist Mike Mushok, bassist and backing vocalist Johnny April, and drummer Jon Wysocki. The lineup has been stable outside of the 2011 departure of Wysocki, who was replaced by Sal Giancarelli. Staind has recorded seven studio albums: Tormented (1996), Dysfunction (1999), Break the Cycle (2001), 14 Shades of Grey (2003), Chapter V (2005), The Illusion of Progress (2008), and Staind (2011). The band\'s activity became more sporadic after their self-titled release, with Lewis pursuing a solo country music career and Mushok subsequently joining the band Saint Asonia, but they have continued to tour on and off in the following years. ', 1, 1, 'staind-img.jpg', 'staind-tn.jpg'),
(6, 'Sepultura', 4, 'Sepultura (Portuguese: [ˌsepuwˈtuɾɐ], \"grave\") is a Brazilian heavy metal band from Belo Horizonte. Formed in 1984 by brothers Max and Igor Cavalera, the band was a major force in the groove metal, thrash metal and death metal genres during the late 1980s and early 1990s, with their later experiments drawing influence from alternative metal, world music, nu metal, hardcore punk, and industrial metal. Sepultura has also been credited as one of the second wave of thrash metal acts from the late 1980s to early-to-mid-1990s, along with bands like Pantera, Testament, Sacred Reich, Dark Angel, Vio-lence, Forbidden, Death Angel and Machine Head.', 1, 4, 'sepultura-img.jpg', 'sepultura-tn.jpg'),
(7, 'William Hung', 3, 'William Hung, also known as Hung Hing Cheong (born January 13, 1983), is a Hong Kong-born American former singer who gained fame in early 2004 as a result of his unsuccessful audition performance of Ricky Martin\'s hit song \"She Bangs\" on the third season of the television series American Idol.', 9, 11, 'williamhung-img.jpg', 'williamhung-tn.jpg'),
(8, 'Tom Jones', 1, 'Sir Thomas John Woodward OBE (born 7 June 1940), known professionally as Tom Jones, is a Welsh singer. His career began with a string of top-ten hits in the mid-1960s. He has toured regularly, with appearances in Las Vegas (1967–2011), and has had several high points in his career, such as his coaching role on the television talent show The Voice UK from 2012 (with the exception of 2016). Jones\'s voice has been described by Stephen Thomas Erlewine of AllMusic as a \"full-throated, robust baritone\". ', 1, 2, 'tomjones-img.jpg', 'tomjones-tn.jpg'),
(10, 'Metallica', 4, 'Metallica is an American heavy metal band. The band was formed in 1981 in Los Angeles by vocalist/guitarist James Hetfield and drummer Lars Ulrich, and has been based in San Francisco for most of its career. The band\'s fast tempos, instrumentals and aggressive musicianship made them one of the founding \"big four\" bands of thrash metal, alongside Megadeth, Anthrax and Slayer. Metallica\'s current lineup comprises founding members and primary songwriters Hetfield and Ulrich, longtime lead guitarist Kirk Hammett and bassist Robert Trujillo. Guitarist Dave Mustaine (who went on to form Megadeth after being fired from the band) and bassists Ron McGovney, Cliff Burton (who died in a bus accident in Sweden in 1986) and Jason Newsted are former members of the band. ', 1, 1, 'metallica-img.jpg', 'metallica-tn.jpg'),
(11, 'Guns N Roses', 4, 'Guns N\' Roses, often abbreviated as GNR, is an American hard rock band from Los Angeles, California, formed in 1985. When they signed to Geffen Records in 1986, the band comprised vocalist Axl Rose, lead guitarist Slash, rhythm guitarist Izzy Stradlin, bassist Duff McKagan, and drummer Steven Adler. The current lineup consists of Rose, Slash, McKagan, keyboardist Dizzy Reed, guitarist Richard Fortus, drummer Frank Ferrer and keyboardist Melissa Reese.', 15, 2, 'gunsnroses-img.jpg', 'gunsnroses-tn.jpg'),
(12, 'Slipknot', 7, 'Slipknot is an American heavy metal band from Des Moines, Iowa. The band was founded in 1995 by percussionist Shawn Crahan, drummer Joey Jordison and bassist Paul Gray. After several lineup changes in its early years, the band settled on nine members for more than a decade: Crahan, Jordison, Gray, Craig Jones, Mick Thomson, Corey Taylor, Sid Wilson, Chris Fehn, and Jim Root. Gray died on May 24, 2010, and was replaced during 2011–2014 by guitarist Donnie Steele. Jordison was dismissed from the band on December 12, 2013. Steele left during the recording sessions for .5: The Gray Chapter. The band found replacements in Alessandro Venturella on bass and Jay Weinberg on drums. After the departure of Jordison, as of December 2013 the only founding member in the current lineup is percussionist Crahan. Fehn was also dismissed from the band in March of 2019 prior to the writing of We Are Not Your Kind.', 1, 1, 'slipknot-img.jpg', 'slipknot-tn.jpg'),
(17, 'AC/DC', 4, 'AC/DC are an Australian rock band formed in Sydney in 1973 by Scottish-born brothers Malcolm and Angus Young. Their music has been variously described as hard rock, blues rock, and heavy metal; however, the band themselves describe their music as simply \"rock and roll\".\r\n\r\nAC/DC underwent several line-up changes before releasing their first album, High Voltage, in 1975. Membership subsequently stabilised around the Young brothers, singer Bon Scott, drummer Phil Rudd, and bass player Mark Evans. Evans was replaced by Cliff Williams in 1977 for the album Powerage. In February 1980, a few months after recording the album Highway to Hell, lead singer and co-songwriter Bon Scott died of acute alcohol poisoning. The group considered disbanding but stayed together, bringing in Brian Johnson as replacement for Scott. Later that year, the band released their first album with Johnson, Back in Black, which they dedicated to Scott\'s memory. The album launched them to new heights of success and became one of the best selling albums of all time. ', 11, 5, 'acdc-img.jpg', 'acdc-tn.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `countryID` int(11) NOT NULL,
  `countryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`countryID`, `countryName`) VALUES
(1, 'USA'),
(2, 'United Kingdom'),
(3, 'China'),
(4, 'Brazil'),
(5, 'Australia'),
(6, 'Canada'),
(7, 'Bolivia'),
(8, 'Peru'),
(9, 'Bulgaria'),
(10, 'Malaysia'),
(11, 'Hong kong');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `eventID` int(11) NOT NULL,
  `eventName` varchar(50) NOT NULL,
  `eventDesc` text NOT NULL,
  `eventDate` datetime NOT NULL,
  `bandID` int(11) NOT NULL,
  `ticketPrice` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventID`, `eventName`, `eventDesc`, `eventDate`, `bandID`, `ticketPrice`) VALUES
(1, 'William Hung - No One Can Stop Me! Tour', 'William Hung, will dazzle us with his soulful voice.  His #1 hit - She Bangs! - is one you\'re sure to enjoy.', '2020-06-01 06:50:50', 7, '250.50'),
(2, 'Tom Jones - I\'m back, baby! Tour', 'Tom Jones’ 50  year career has remarkably gone from strength to strength. His top hits like \"She\'s a lady\", \"It\'s Not Unusual\" and \"What\'s New Pussycat?\" will be performed.  Don\'t be late!', '2026-05-00 00:00:00', 8, '300.01'),
(3, 'Disturbed rocks Vacaville @ The Creek!', 'Disturbed makes a debut showing at The Creek!  We\'re honored to have them rock us to the core!', '2021-04-10 00:00:00', 2, '10.00'),
(4, 'Eddie Takes CA! Tour', 'Eddie, Iron Maiden\'s mascot is ready to take on CA!   The band from The UK is ready to blow your socks off with new hits and old hits, like, \"Where Eagles Dare\", \"The Trooper\" and many more.', '2022-07-01 19:30:00', 1, '24.99'),
(5, 'The Big Show!', 'Mastodon touches down to rock all of Vacaville!!!   These guys have been on break and ready to get back to it.  Don\'t miss out on this one or you\'ll be sorry!', '2021-08-01 19:00:00', 3, '101.10'),
(6, '\'Guns N Roses North American Tour\'', 'The colossal Guns N’ Roses 2020 Tour will feature The Smashing Pumpkins at stops in major cities across North America', '2020-08-08 20:04:50', 11, '999.25'),
(7, 'Rockin\' the Night Away @ The Creek with Sepultura!', 'Sepultura makes their presence felt with hardcore riffs and brilliant lyrics!', '2020-08-29 08:48:11', 6, '50.50');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `genreID` int(10) UNSIGNED NOT NULL,
  `genreName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`genreID`, `genreName`) VALUES
(1, 'Heavy Metal'),
(2, 'Doom Metal'),
(3, 'Nu Metal'),
(4, 'RnB'),
(5, 'Neo Soul'),
(6, 'Classical'),
(7, 'Disco'),
(8, 'Ragtime'),
(9, 'Pop'),
(10, 'Misc'),
(11, 'Classic Rock'),
(12, 'Funk'),
(13, 'Progressive Rock'),
(14, 'Jazz'),
(15, 'Boo Boo Rock'),
(16, 'Rock');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bands`
--
ALTER TABLE `bands`
  ADD PRIMARY KEY (`bandID`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`countryID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genreID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bands`
--
ALTER TABLE `bands`
  MODIFY `bandID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `countryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `genreID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
