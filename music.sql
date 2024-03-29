-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2019 at 08:47 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderNumber` int(10) UNSIGNED NOT NULL,
  `accountNumber` int(10) UNSIGNED NOT NULL,
  `orderDate` datetime NOT NULL,
  `forFirstName` varchar(255) NOT NULL,
  `forLastName` varchar(255) NOT NULL,
  `shipAddress1` varchar(255) NOT NULL,
  `shipAddress2` varchar(255) DEFAULT NULL,
  `shipCity` varchar(255) NOT NULL,
  `shipState` varchar(255) NOT NULL,
  `shipZip` char(5) NOT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderNumber`, `accountNumber`, `orderDate`, `forFirstName`, `forLastName`, `shipAddress1`, `shipAddress2`, `shipCity`, `shipState`, `shipZip`, `comments`) VALUES
(5, 2, '2019-12-10 00:00:00', 'Dillon', 'John', '1233 Main Street', '', 'Wayne', 'NJ', '07470', ''),
(6, 5, '2019-12-10 00:00:00', 'Lia', 'Esa', '123 E Newcomb St', '', 'Lubbock', 'Texas', '79401', 'Leave it on the porch.'),
(7, 5, '2019-12-10 00:00:00', 'Lia', 'Esa', '123 E Newcomb St', '', 'Lubbock', 'Texas', '79401', ''),
(8, 11, '2019-12-10 00:00:00', 'Michael', 'Serfs', '207 Valley Rd', '', 'Montclair', 'New Jersey', '07043', ''),
(9, 6, '2019-12-10 00:00:00', 'Paul', 'Cravo', '520 Kearny Ave', '', 'Kearny', 'New Jersey', '07032', ''),
(10, 7, '2019-12-10 00:00:00', 'Amanda', 'Burns', '123 Belleville Ave', '', 'Belleville', 'New Jersey', '07109', ''),
(11, 7, '2019-12-10 00:00:00', 'Amanda', 'Burns', '123 Belleville Ave', '', 'Belleville', 'New Jersey', '07109', ''),
(12, 8, '2019-12-10 00:00:00', 'Sarah', 'Garrison', '302 Norman St', '', 'Sparta', 'Ohio', '43350', ''),
(13, 9, '2019-12-10 00:00:00', 'Robert', 'Spera', '670 Ulster Rd', '', 'Smithfield', 'Pennsylvania', '15478', ''),
(14, 10, '2019-12-10 00:00:00', 'Bre', 'Smith', '401 Paddock Ave', '', 'Iowa City', 'Ioiwa', '52240', ''),
(15, 7, '2019-12-10 00:00:00', 'Amanda', 'Burns', '123 Belleville Ave', '', 'Belleville', 'New Jersey', '07109', ''),
(16, 7, '2019-12-10 00:00:00', 'Amanda', 'Burns', '123 Belleville Ave', '', 'Belleville', 'New Jersey', '07109', ''),
(20, 2, '2019-12-10 00:00:00', 'Dillon', 'John', '1233 Main Street', '', 'Wayne', 'NJ', '07470', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `orderNumber` int(10) UNSIGNED NOT NULL,
  `productNumber` int(10) UNSIGNED NOT NULL,
  `price` decimal(7,2) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`orderNumber`, `productNumber`, `price`, `quantity`) VALUES
(5, 4, '64.99', 1),
(5, 15, '329.99', 1),
(5, 17, '5561.86', 1),
(5, 23, '299.99', 1),
(6, 25, '834.99', 1),
(7, 4, '64.99', 2),
(7, 14, '3798.99', 1),
(7, 17, '5561.86', 1),
(8, 13, '439.00', 1),
(8, 22, '3385.41', 1),
(9, 20, '1999.00', 1),
(10, 8, '1299.00', 1),
(10, 9, '2400.00', 3),
(11, 24, '31.95', 1),
(12, 6, '2895.00', 1),
(13, 15, '329.99', 1),
(14, 21, '30000.00', 1),
(16, 2, '569.99', 1),
(16, 10, '479.00', 1),
(16, 12, '1190.00', 1),
(20, 5, '8390.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productNumber` int(10) UNSIGNED NOT NULL,
  `productName` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `subcategory` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `numInStock` smallint(5) UNSIGNED NOT NULL,
  `price` decimal(7,2) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `imagePath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productNumber`, `productName`, `category`, `subcategory`, `manufacturer`, `numInStock`, `price`, `description`, `imagePath`) VALUES
(1, 'Guitar', 'String', 'Acoustic', 'Guitars R\' us', 25, '419.99', 'The LX1 is the lighter, smaller \'travel\' concert acoustic that every guitarist would love to have in their collection to play on around the house, in the car or on the move.', 'StringGuitar.jpg'),
(2, 'Flute', 'Woodwind', 'Brass', 'Instrument world', 22, '569.99', 'A Gemeinhardt student flute featuring a special black nickel-coated finish for the headjoint, body, keys and foot.', 'WoodwindFlute.jpg'),
(3, 'Saxophone', 'Brass', 'Woodwind', 'Songs, Brass, and beyond', 3, '3589.99', 'A specially manufactured  saxophone, handcrafted with and built for amazing playability.', 'BrassSaxophone.jpg'),
(4, 'Keyboard', 'Keyboard', 'Electric', 'Tap-tap products', 49, '64.99', 'A portable electronic keyboard that has the same feeling of a normal piano.', 'KeyboardElectronickeyboard.jpg'),
(5, 'Timpani', 'Percussion', 'Drums', 'Tap-tap products', 4, '8390.00', 'Represent the ultimate expression of quality in timpani sound and design.', 'PercussionTimpani.jpg'),
(6, 'Harp', 'String', 'Plucked string', 'Strings n Things', 14, '2895.00', 'With light tension, close string spacing, and a big, responsive sound, the Serrana is catching the fancy of players across a variety of genres who want a harp that is easy on the hands and very satisfying to play.', 'StringHarp.jpg'),
(7, 'Violin', 'String', '', 'Strings n Things', 13, '1095.00', 'One of the most popular violins available today for the advanced violinist or adult amateur.', 'StringViolin.jpg'),
(8, 'Cello', 'String', '', 'Strings n Things', 42, '1299.00', 'With careful wood selection, hand-craftsmanship, carving and bass bar design and installation, this cello is on tone and performance', 'StringCello.jpg'),
(9, 'Viola', 'String', '', 'Strings n Things', 8, '2400.00', '15.5? inch viola for an advanced player', 'StringViola.png'),
(10, 'Clarinet', 'Woodwind', 'Single-reed', 'Gone with the woodwind', 33, '479.00', 'A clarinet suitable for beginners and avid students alike.', 'WoodwindClarinet.jpg'),
(11, 'Oboe', 'Woodwind', 'Double-reed', 'Gone with the woodwind', 4, '2000.00', 'Basic oboe for beginner use', 'WoodwindOboe.jpg'),
(12, 'Bassoon', 'Woodwind', 'Double-reed', 'Gone with the woodwind', 14, '1190.00', 'C key bassoon designed for beginners and professional bassoonists.', 'WoodwindBassoon.jpg'),
(13, 'Piccolo', 'Woodwind', 'Aerophone', 'Gone with the woodwind', 16, '439.00', 'Designed as an affordable option for beginning band students, this piccolo combines value and performance.', 'WoodwindPiccolo.png'),
(14, 'Tuba', 'Brass', 'Aerophone', 'Songs, Brass, and beyond', 2, '3798.99', 'This tuba offers high quality pro-style models for student model prices', 'BrassTuba.jpg'),
(15, 'Trumpet', 'Brass', 'Aerophone', 'Songs, Brass, and beyond', 18, '329.99', 'Designed in conjunction with master brass consultants from around the world, this trumpet features yellow brass construction with a rose brass leadpipe and bell', 'BrassTrumpet.jpg'),
(16, 'Horn', 'Brass', 'Aerophone', 'Songs, Brass, and beyond', 11, '4059.00', 'A delicately crafted french horn made for use by professionals.', 'BrassFrenchhorn.jpg'),
(17, 'Trombone', 'Brass', 'Aerophone', 'Songs, Brass, and beyond', 5, '5561.86', 'Entirely handcrafted in the Historic District of Kansas City, Missouri, this all-American manufactured instrument is a premium model small bore jazz trombone.', 'BrassTrombone.jpg'),
(18, 'Piano', 'Keyboard', 'Percussion', 'Tap-tap products', 20, '1095.00', 'Standard grand piano for both beginners and professionals', 'KeyboardPiano.jpg'),
(19, 'Harpsichord', 'Keyboard', '', 'Tap-tap products', 6, '4050.00', 'A harpsichord with traditional wooden jacks, guides and keyboard, a detachable lid with solid decorative brass-work and a folding music desk', 'KeyboardHarpsichords.jpg'),
(20, 'Synthesizer', 'Keyboard', 'Electric', 'Tap-tap products', 48, '1999.00', 'A patchable 4-note paraphonic analog synthesizer with a built-in sequencer, arpeggiator, stereo modulation effects and more.', 'KeyboardSynthesizer.jpg'),
(21, 'Organ', 'Keyboard', '', 'Tap-tap products', 2, '30000.00', 'Two manual and pedal Instrument. Ideal as a practice instrument or for a small chapel', 'KeyboardOrgan.jpg'),
(22, 'Xylophone', 'Percussion', 'Pitched', 'Tap-tap products', 12, '3385.41', 'This xylphone is a set apart by its beautiful wood frame and classic curves.', 'PercussionXylophone.jpg'),
(23, 'Drums', 'Percussion', 'Drums', 'Tap-tap products', 59, '299.99', 'A complete drum set package with everything you need to start your rhythmic journey to the big time.', 'PercussionDrums.jpg'),
(24, 'Tambourine', 'Percussion', 'Drums', 'Instrument world', 42, '31.95', 'Features two in-line rows of hammered steel jingles and a natural skin head, giving you a pleasantly bright, happy sound on your shake rolls and thumb rolls. The frame is made of several plies of strong wood.', 'PercussionTambourine.jpg'),
(25, 'Cymbal', 'Percussion', '', 'Tap-tap products', 40, '834.99', 'Versatile cymbals of medium weight and thickness provide full sound with moderate decay.', 'PercussionCymbal.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `accountNumber` int(10) UNSIGNED NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `userType` varchar(255) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`accountNumber`, `emailAddress`, `password`, `firstName`, `lastName`, `userType`, `phoneNumber`, `address1`, `address2`, `city`, `state`, `zip`) VALUES
(2, 'dillon@ddm.com', '$2y$10$/9MNcADAqkXnLLHb0we6SeHiZzNYSH5BqK76yHHpe3bZnj82bfSGm', 'Dillon', 'John', 'manager', '1234567890', '1233 Main Street', 'Apt 42', 'Wayne', 'NJ', '07470'),
(3, 'bob@bobs.com', '$2y$10$wklC02bBgFcCRIBl9q0D0uvCfNdV44JAd68gQ5orGoEHjBFuDv54S', 'Bob', 'Johnson', 'customer', '(123) 456 - 789', '14 E. Columbia Ave', '', 'Westfield', 'South Dakota', '12345'),
(4, 'Danny_b@ddm.com', '$2y$10$c2TNSEz/4ld5X88RO95hsedNVYStVMMfGTr1k.g7.ayw/89V61Jca', 'Daniel', 'Burton', 'customer', '(123) 456-7890', '123 Chestnut', '', 'Montclair', 'New Jersey', '07032'),
(5, 'Lia_E@email.com', '$2y$10$OZs5ld76fYHiriYVL0V04eMFvM6NrXGpDZvNusHZUFQ0MeKQoibvC', 'Lia', 'Esa', 'customer', '(999) 999-9990', '123 E Newcomb St', '', 'Lubbock', 'Texas', '79401'),
(6, 'Paul_C@email.com', '$2y$10$30f5X03dFLx.ZnBeZkevuuFRallBk0xd5RGYyR6EpFq/zItXske.S', 'Paul', 'Cravo', 'customer', '(888) 888-8880', '520 Kearny Ave', '', 'Kearny', 'New Jersey', '07032'),
(7, 'Amanda_B@email.com', '$2y$10$bUiWoTuFX.Xbq2B2amnOJ.pMTBywEHm04xF70yOvHn5RBNO1zIaUK', 'Amanda', 'Burns', 'customer', '101-101-1010', '123 Belleville Ave', '', 'Belleville', 'New Jersey', '07109'),
(8, 'Sarah_G@email.com', '$2y$10$V.6dlvgHkwm3czFyQyi6DO0UGcB.WrQ1hqERiNpp2cW.SEDbiVQYy', 'Sarah', 'Garrison', 'customer', '(211) 211-455', '302 Norman St', 'Unit F1', 'Sparta', 'Ohio', '43350'),
(9, 'Robert_S@email.com', '$2y$10$3yZIXRlIC6oWpfCcIfOMh.bnjWacdonalvwywenUZoBCWoPhX08GW', 'Robert', 'Spera', 'customer', '(455) 333-2111', '670 Ulster Rd', '', 'Smithfield', 'Pennsylvania', '15478'),
(10, 'Bre_Smith@email.com', '$2y$10$tnBXBWO6jYaQ5rTfsdfOXulQiJ33I82PPmnF2ez5J1F0LUMZLy5Ey', 'Bre', 'Smith', 'employee', '(345) 135-1354', '401 Paddock Ave', '', 'Iowa City', 'Ioiwa', '52240'),
(11, 'Mike_S@ddm.com', '$2y$10$oP9R/XCJ5AmUx0PIHHAYWODRUot1pHVlEjnQMXb4SdjTjJI8c5lYK', 'Michael', 'Serfs', 'manager', '(123) 456-7034', '207 Valley Rd', '', 'Montclair', 'New Jersey', '07043');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderNumber`),
  ADD KEY `accountNumber` (`accountNumber`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderNumber`,`productNumber`),
  ADD KEY `productNumber` (`productNumber`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productNumber`),
  ADD UNIQUE KEY `productName` (`productName`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`accountNumber`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderNumber` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productNumber` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `accountNumber` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`accountNumber`) REFERENCES `users` (`accountNumber`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`orderNumber`) REFERENCES `orders` (`orderNumber`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productNumber`) REFERENCES `products` (`productNumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
