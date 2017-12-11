-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Lis 2017, 18:12
-- Wersja serwera: 10.1.25-MariaDB
-- Wersja PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `symfony`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `brand` text NOT NULL,
  `model` text NOT NULL,
  `enginePower` text NOT NULL,
  `acceleration` text NOT NULL,
  `createdAt` varchar(80) NOT NULL,
  `original` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `car`
--

INSERT INTO `car` (`id`, `brand`, `model`, `enginePower`, `acceleration`, `createdAt`, `original`, `visible`) VALUES
(43642, 'Rover', '211i', '60', '16.3', '2017-11-19 18:09:23', 1, 1),
(43643, 'Rover', '214i', '75', '13.3', '2017-11-19 18:09:23', 1, 1),
(43644, 'Rover', '214 Si', '103', '10.7', '2017-11-19 18:09:23', 1, 1),
(43645, 'Rover', '216 Si', '111', '9.9', '2017-11-19 18:09:23', 1, 1),
(43646, 'Rover', '218 Si', '120', '9', '2017-11-19 18:09:23', 1, 1),
(43647, 'Rover', '218 Vi', '145', '8', '2017-11-19 18:09:23', 1, 1),
(43648, 'Rover', '220D/SD', '86', '12.8', '2017-11-19 18:09:23', 1, 1),
(43649, 'Rover', '220 SDI', '105', '9.8', '2017-11-19 18:09:24', 1, 1),
(43650, 'Rover', '414', '103', '11.8', '2017-11-19 18:09:24', 1, 1),
(43651, 'Rover', '414i/si', '111', '10.6', '2017-11-19 18:09:24', 1, 1),
(43652, 'Rover', '416i/si/sli', '114', '12.8', '2017-11-19 18:09:24', 1, 1),
(43653, 'Rover', '420i/si/sli/gsi', '136', '9.6', '2017-11-19 18:09:24', 1, 1),
(43654, 'Rover', '420D/SD', '86', '14', '2017-11-19 18:09:24', 1, 1),
(43655, 'Rover', '420Di/SDI/SLDi/GSDI', '105', '11.2', '2017-11-19 18:09:24', 1, 1),
(43656, 'Rover', '425 v6 limited edition', '175', '8.5', '2017-11-19 18:09:24', 1, 1),
(43657, 'Rover', '618i/Si', '115', '11.3', '2017-11-19 18:09:24', 1, 1),
(43658, 'Rover', '620i', '115', '10.8', '2017-11-19 18:09:24', 1, 1),
(43659, 'Rover', '620Si/SLi', '131', '10.2', '2017-11-19 18:09:24', 1, 1),
(43660, 'Rover', '620Ti', '200', '7.5', '2017-11-19 18:09:24', 1, 1),
(43661, 'Rover', '623Si/SLi/GSi', '158', '8.6', '2017-11-19 18:09:24', 1, 1),
(43662, 'Rover', '620SDi/Di/GSDi', '105', '11.6', '2017-11-19 18:09:24', 1, 1),
(43663, 'Rover', '820', '100', '13.5', '2017-11-19 18:09:25', 1, 1),
(43664, 'Rover', '820E/e/Se', '120', '11', '2017-11-19 18:09:25', 1, 1),
(43665, 'Rover', '820i/Si/SLi', '140', '10.4', '2017-11-19 18:09:25', 1, 1),
(43666, 'Rover', '825i/Si', '175', '8.3', '2017-11-19 18:09:25', 1, 1),
(43667, 'Rover', '827i/Si/SLi', '177', '9.2', '2017-11-19 18:09:25', 1, 1),
(43668, 'Rover', '825SD/D', '118', '11.3', '2017-11-19 18:09:25', 1, 1),
(43669, 'Rover', '25 1.1 (60)', '60', '14.3', '2017-11-19 18:09:25', 1, 1),
(43670, 'Rover', '25 1.1 (75)', '75', '13.9', '2017-11-19 18:09:25', 1, 1),
(43671, 'Rover', '25 1.4 (83)', '83', '12.9', '2017-11-19 18:09:25', 1, 1),
(43672, 'Rover', '25 1.4(103)', '103', '11', '2017-11-19 18:09:25', 1, 1),
(43673, 'Rover', '25 1.6', '109', '10.1', '2017-11-19 18:09:26', 1, 1),
(43674, 'Rover', '25 1.8 (automat)', '117', '10.1', '2017-11-19 18:09:26', 1, 1),
(43675, 'Rover', '25 Vi', '145', '8.3', '2017-11-19 18:09:26', 1, 1),
(43676, 'Rover', '25 2.0 iDT (113)', '113', '10.2', '2017-11-19 18:09:26', 1, 1),
(43677, 'Rover', '25 2.0 iDT (101)', '101', '10.5', '2017-11-19 18:09:26', 1, 1),
(43678, 'Rover', '45 2.0', '150', '9.5', '2017-11-19 18:09:26', 1, 1),
(43679, 'Rover', '45 1.4', '103', '11.7', '2017-11-19 18:09:26', 1, 1),
(43680, 'Rover', '45 1.6', '109', '10.3', '2017-11-19 18:09:26', 1, 1),
(43681, 'Rover', '45 1.8', '117', '9.3', '2017-11-19 18:09:26', 1, 1),
(43682, 'Rover', '45 2.0', '101', '10.6', '2017-11-19 18:09:26', 1, 1),
(43683, 'Rover', '75 1.8', '120', '13.2', '2017-11-19 18:09:26', 1, 1),
(43684, 'Rover', '75 1.8 turbo', '150', '10.4', '2017-11-19 18:09:26', 1, 1),
(43685, 'Rover', '75 2.0 v6', '150', '11.6', '2017-11-19 18:09:26', 1, 1),
(43686, 'Rover', '75 2.5 v6', '177', '9.5', '2017-11-19 18:09:26', 1, 1),
(43687, 'Rover', '75 2.0 cdt', '116', '13.2', '2017-11-19 18:09:27', 1, 1),
(43688, 'Rover', '75 2.0 cdti', '131', '11.8', '2017-11-19 18:09:27', 1, 1),
(43689, 'Land Rover', 'Defender 2.5 TD5', '138', '15.3', '2017-11-19 18:09:27', 1, 1),
(43690, 'Land Rover', 'Defender 4.0 v8', '184', '11.7', '2017-11-19 18:09:27', 1, 1),
(43691, 'Land Rover', 'Freelander 1.8', '120', '11.9', '2017-11-19 18:09:27', 1, 1),
(43692, 'Land Rover', 'Freelander 2.0', '97', '15.8', '2017-11-19 18:09:27', 1, 1),
(43693, 'Range Rover', '4.0 SE', '190', '10.9', '2017-11-19 18:09:27', 1, 1),
(43694, 'Range Rover', '4.6 HSE', '218', '9.9', '2017-11-19 18:09:27', 1, 1),
(43695, 'Rover', '100 Mk1 111 C/L', '60', '14.8', '2017-11-19 18:09:27', 1, 1),
(43696, 'Rover', '100 Mk1 114 Si', '75', '11', '2017-11-19 18:09:27', 1, 1),
(43697, 'Rover', '100 Mk1 114 GTa', '90', '9.8', '2017-11-19 18:09:27', 1, 1),
(43698, 'Rover', '100 Mk1 114 GTi', '103', '8.8', '2017-11-19 18:09:27', 1, 1),
(43699, 'Rover', '100 Mk1 114 D/LD/SLD/GLD', '24', '5', '2017-11-19 18:09:27', 1, 1),
(43700, 'Rover', '100 Mk2 111 Si/SLi', '60', '14.8', '2017-11-19 18:09:27', 1, 1),
(43701, 'Rover', '100 Mk2 114 SLi/GSi', '75', '10.9', '2017-11-19 18:09:28', 1, 1),
(43702, 'Rover', '100 Mk2 114 GTa', '75', '10.9', '2017-11-19 18:09:28', 1, 1),
(43703, 'Rover', '100 Mk2 115D/LD/SLD', '58', '15.5', '2017-11-19 18:09:28', 1, 1),
(43704, 'Rover', '400 mk1 418 SD/GLD', '67', '13.5', '2017-11-19 18:09:28', 1, 1),
(43705, 'Rover', '400 mk1 418 SLD Turbo', '88', '11.8', '2017-11-19 18:09:28', 1, 1),
(43706, 'Rover', '400 mk1 420 GSi Turbo', '200', '8.5', '2017-11-19 18:09:28', 1, 1),
(43707, 'MG', 'ZR 105', '103', '10', '2017-11-19 18:09:28', 1, 1),
(43708, 'MG', 'ZR 120', '117', '8.8', '2017-11-19 18:09:28', 1, 1),
(43709, 'MG', 'ZR 120 Stepspeed', '117', '9.7', '2017-11-19 18:09:29', 1, 1),
(43710, 'MG', 'ZR 160', '160', '7.6', '2017-11-19 18:09:29', 1, 1),
(43711, 'MG', 'ZR ZR iDT (101)', '101', '9.8', '2017-11-19 18:09:29', 1, 1),
(43712, 'MG', 'ZR ZR iDT (113)', '113', '9.6', '2017-11-19 18:09:29', 1, 1),
(43713, 'MG', 'ZS 120', '116', '9.9', '2017-11-19 18:09:29', 1, 1),
(43714, 'MG', 'ZS 180', '176', '7.3', '2017-11-19 18:09:29', 1, 1),
(43715, 'MG', 'ZS 2.0 iTD', '112', '9.8', '2017-11-19 18:09:29', 1, 1),
(43716, 'MG', 'ZT 160', '160', '8.4', '2017-11-19 18:09:29', 1, 1),
(43717, 'MG', 'ZT 180 sports', '176', '8', '2017-11-19 18:09:30', 1, 1),
(43718, 'MG', 'ZT 190', '191', '7.4', '2017-11-19 18:09:30', 1, 1),
(43719, 'MG', 'ZT 135 CDTi', '116', '11.8', '2017-11-19 18:09:30', 1, 1),
(43720, 'MG', 'ZT 135 CDTi Sports', '131', '10.9', '2017-11-19 18:09:30', 1, 1),
(43721, 'MG', 'ZT 260', '-260', '6.5', '2017-11-19 18:09:30', 1, 1),
(43722, 'MG', 'F 1.6i', '112', '9.9', '2017-11-19 18:09:30', 1, 1),
(43723, 'MG', 'F Stepspeed', '120', '10', '2017-11-19 18:09:30', 1, 1),
(43724, 'MG', 'F 1.8i', '120', '9.2', '2017-11-19 18:09:30', 1, 1),
(43725, 'MG', 'F VVC', '145', '7.9', '2017-11-19 18:09:31', 1, 1),
(43726, 'MG', 'F 160SE', '160', '7.6', '2017-11-19 18:09:32', 1, 1),
(43727, 'MG', 'TF 115', '116', '9.8', '2017-11-19 18:09:32', 1, 1),
(43728, 'MG', '120 Stepspeed', '120', '10.4', '2017-11-19 18:09:32', 1, 1),
(43729, 'MG', 'TF 161', '165', '7.2', '2017-11-19 18:09:32', 1, 1),
(43730, 'MG', 'TF 135', '136', '8.8', '2017-11-19 18:09:33', 1, 1),
(43731, 'MG', 'TF 160', '160', '7.6', '2017-11-19 18:09:33', 1, 1),
(43732, 'MG', 'XPower SV', '10500', '4.3', '2017-11-19 18:09:33', 1, 1),
(43733, 'MG', 'XPower SV-R', 'qwerty', '5.1', '2017-11-19 18:09:33', 1, 1),
(43734, 'MG', 'Metro Turbo', '95', '9.5', '2017-11-19 18:09:34', 1, 1),
(43735, 'MG', 'Metro GTa', '74', '11.9', '2017-11-19 18:09:34', 1, 1),
(43736, 'MG', 'Metro 1.4 SL', '76', '12.1', '2017-11-19 18:09:34', 1, 1),
(43737, 'MG', 'Metro GTi 16v', '96', '9.9', '2017-11-19 18:09:35', 1, 1),
(43738, 'MG', 'Metro 1.1i', '61', '13.5', '2017-11-19 18:09:35', 1, 1),
(43739, 'MG', 'Metro Diesel', '53', '15.9', '2017-11-19 18:09:35', 1, 1),
(43740, 'MG', 'Maestro 2.0 EFi', '226', '15', '2017-11-19 18:09:35', 1, 1),
(43741, 'MG', 'Maestro Turbo', '152', '6.8', '2017-11-19 18:09:35', 1, 1),
(43742, 'Rover', '211i', '60', '16.3', '2017-11-19 18:09:36', 0, 1),
(43743, 'Rover', '214i', '75', '13.3', '2017-11-19 18:09:36', 0, 1),
(43744, 'Rover', '214 Si', '103', '10.7', '2017-11-19 18:09:36', 0, 1),
(43745, 'Rover', '216 Si', '111', '9.9', '2017-11-19 18:09:36', 0, 1),
(43746, 'Rover', '218 Si', '120', '9', '2017-11-19 18:09:36', 0, 1),
(43747, 'Rover', '218 Vi', '145', '8', '2017-11-19 18:09:37', 0, 1),
(43748, 'Rover', '220D/SD', '86', '12.8', '2017-11-19 18:09:37', 0, 1),
(43749, 'Rover', '220 SDI', '105', '9.8', '2017-11-19 18:09:37', 0, 1),
(43750, 'Rover', '414', '103', '11.8', '2017-11-19 18:09:37', 0, 1),
(43751, 'Rover', '414i/si', '111', '10.6', '2017-11-19 18:09:37', 0, 1),
(43752, 'Rover', '416i/si/sli', '114', '12.8', '2017-11-19 18:09:38', 0, 1),
(43753, 'Rover', '420i/si/sli/gsi', '136', '9.6', '2017-11-19 18:09:38', 0, 1),
(43754, 'Rover', '420D/SD', '86', '14', '2017-11-19 18:09:38', 0, 1),
(43755, 'Rover', '420Di/SDI/SLDi/GSDI', '105', '11.2', '2017-11-19 18:09:38', 0, 1),
(43756, 'Rover', '425 v6 limited edition', '175', '8.5', '2017-11-19 18:09:39', 0, 1),
(43757, 'Rover', '618i/Si', '115', '11.3', '2017-11-19 18:09:39', 0, 1),
(43758, 'Rover', '620i', '115', '10.8', '2017-11-19 18:09:39', 0, 1),
(43759, 'Rover', '620Si/SLi', '131', '10.2', '2017-11-19 18:09:39', 0, 1),
(43760, 'Rover', '620Ti', '200', '7.5', '2017-11-19 18:09:39', 0, 1),
(43761, 'Rover', '623Si/SLi/GSi', '158', '8.6', '2017-11-19 18:09:40', 0, 1),
(43762, 'Rover', '620SDi/Di/GSDi', '105', '11.6', '2017-11-19 18:09:40', 0, 1),
(43763, 'Rover', '820', '100', '13.5', '2017-11-19 18:09:40', 0, 1),
(43764, 'Rover', '820E/e/Se', '120', '11', '2017-11-19 18:09:40', 0, 1),
(43765, 'Rover', '820i/Si/SLi', '140', '10.4', '2017-11-19 18:09:40', 0, 1),
(43766, 'Rover', '825i/Si', '175', '8.3', '2017-11-19 18:09:41', 0, 1),
(43767, 'Rover', '827i/Si/SLi', '177', '9.2', '2017-11-19 18:09:41', 0, 1),
(43768, 'Rover', '825SD/D', '118', '11.3', '2017-11-19 18:09:41', 0, 1),
(43769, 'Rover', '25 1.1 (60)', '60', '14.3', '2017-11-19 18:09:41', 0, 1),
(43770, 'Rover', '25 1.1 (75)', '75', '13.9', '2017-11-19 18:09:41', 0, 1),
(43771, 'Rover', '25 1.4 (83)', '83', '12.9', '2017-11-19 18:09:41', 0, 1),
(43772, 'Rover', '25 1.4(103)', '103', '11', '2017-11-19 18:09:41', 0, 1),
(43773, 'Rover', '25 1.6', '109', '10.1', '2017-11-19 18:09:41', 0, 1),
(43774, 'Rover', '25 1.8 (automat)', '117', '10.1', '2017-11-19 18:09:41', 0, 1),
(43775, 'Rover', '25 Vi', '145', '8.3', '2017-11-19 18:09:42', 0, 1),
(43776, 'Rover', '25 2.0 iDT (113)', '113', '10.2', '2017-11-19 18:09:42', 0, 1),
(43777, 'Rover', '25 2.0 iDT (101)', '101', '10.5', '2017-11-19 18:09:42', 0, 1),
(43778, 'Rover', '45 2.0', '150', '9.5', '2017-11-19 18:09:42', 0, 1),
(43779, 'Rover', '45 1.4', '103', '11.7', '2017-11-19 18:09:42', 0, 1),
(43780, 'Rover', '45 1.6', '109', '10.3', '2017-11-19 18:09:42', 0, 1),
(43781, 'Rover', '45 1.8', '117', '9.3', '2017-11-19 18:09:42', 0, 1),
(43782, 'Rover', '45 2.0', '101', '10.6', '2017-11-19 18:09:42', 0, 1),
(43783, 'Rover', '75 1.8', '120', '13.2', '2017-11-19 18:09:42', 0, 1),
(43784, 'Rover', '75 1.8 turbo', '150', '10.4', '2017-11-19 18:09:42', 0, 1),
(43785, 'Rover', '75 2.0 v6', '150', '11.6', '2017-11-19 18:09:42', 0, 1),
(43786, 'Rover', '75 2.5 v6', '177', '9.5', '2017-11-19 18:09:42', 0, 1),
(43787, 'Rover', '75 2.0 cdt', '116', '13.2', '2017-11-19 18:09:42', 0, 1),
(43788, 'Rover', '75 2.0 cdti', '131', '11.8', '2017-11-19 18:09:42', 0, 1),
(43789, 'Land Rover', 'Defender 2.5 TD5', '138', '15.3', '2017-11-19 18:09:42', 0, 1),
(43790, 'Land Rover', 'Defender 4.0 v8', '184', '11.7', '2017-11-19 18:09:43', 0, 1),
(43791, 'Land Rover', 'Freelander 1.8', '120', '11.9', '2017-11-19 18:09:43', 0, 1),
(43792, 'Land Rover', 'Freelander 2.0', '97', '15.8', '2017-11-19 18:09:43', 0, 1),
(43793, 'Range Rover', '4.0 SE', '190', '10.9', '2017-11-19 18:09:43', 0, 1),
(43794, 'Range Rover', '4.6 HSE', '218', '9.9', '2017-11-19 18:09:43', 0, 1),
(43795, 'Rover', '100 Mk1 111 C/L', '60', '14.8', '2017-11-19 18:09:43', 0, 1),
(43796, 'Rover', '100 Mk1 114 Si', '75', '11', '2017-11-19 18:09:43', 0, 1),
(43797, 'Rover', '100 Mk1 114 GTa', '90', '9.8', '2017-11-19 18:09:43', 0, 1),
(43798, 'Rover', '100 Mk1 114 GTi', '103', '8.8', '2017-11-19 18:09:43', 0, 1),
(43799, 'Rover', '100 Mk1 114 D/LD/SLD/GLD', '24', '5', '2017-11-19 18:09:43', 0, 1),
(43800, 'Rover', '100 Mk2 111 Si/SLi', '60', '14.8', '2017-11-19 18:09:43', 0, 1),
(43801, 'Rover', '100 Mk2 114 SLi/GSi', '75', '10.9', '2017-11-19 18:09:43', 0, 1),
(43802, 'Rover', '100 Mk2 114 GTa', '75', '10.9', '2017-11-19 18:09:43', 0, 1),
(43803, 'Rover', '100 Mk2 115D/LD/SLD', '58', '15.5', '2017-11-19 18:09:43', 0, 1),
(43804, 'Rover', '400 mk1 418 SD/GLD', '67', '13.5', '2017-11-19 18:09:43', 0, 1),
(43805, 'Rover', '400 mk1 418 SLD Turbo', '88', '11.8', '2017-11-19 18:09:43', 0, 1),
(43806, 'Rover', '400 mk1 420 GSi Turbo', '200', '8.5', '2017-11-19 18:09:44', 0, 1),
(43807, 'MG', 'ZR 105', '103', '10', '2017-11-19 18:09:44', 0, 1),
(43808, 'MG', 'ZR 120', '117', '8.8', '2017-11-19 18:09:44', 0, 1),
(43809, 'MG', 'ZR 120 Stepspeed', '117', '9.7', '2017-11-19 18:09:44', 0, 1),
(43810, 'MG', 'ZR 160', '160', '7.6', '2017-11-19 18:09:44', 0, 1),
(43811, 'MG', 'ZR ZR iDT (101)', '101', '9.8', '2017-11-19 18:09:44', 0, 1),
(43812, 'MG', 'ZR ZR iDT (113)', '113', '9.6', '2017-11-19 18:09:44', 0, 1),
(43813, 'MG', 'ZS 120', '116', '9.9', '2017-11-19 18:09:44', 0, 1),
(43814, 'MG', 'ZS 180', '176', '7.3', '2017-11-19 18:09:44', 0, 1),
(43815, 'MG', 'ZS 2.0 iTD', '112', '9.8', '2017-11-19 18:09:44', 0, 1),
(43816, 'MG', 'ZT 160', '160', '8.4', '2017-11-19 18:09:44', 0, 1),
(43817, 'MG', 'ZT 180 sports', '176', '8', '2017-11-19 18:09:44', 0, 1),
(43818, 'MG', 'ZT 190', '191', '7.4', '2017-11-19 18:09:44', 0, 1),
(43819, 'MG', 'ZT 135 CDTi', '116', '11.8', '2017-11-19 18:09:44', 0, 1),
(43820, 'MG', 'ZT 135 CDTi Sports', '131', '10.9', '2017-11-19 18:09:44', 0, 1),
(43821, 'MG', 'ZT 260', '218.57', '6.5', '2017-11-19 18:09:44', 0, 1),
(43822, 'MG', 'F 1.6i', '112', '9.9', '2017-11-19 18:09:44', 0, 1),
(43823, 'MG', 'F Stepspeed', '120', '10', '2017-11-19 18:09:44', 0, 1),
(43824, 'MG', 'F 1.8i', '120', '9.2', '2017-11-19 18:09:44', 0, 1),
(43825, 'MG', 'F VVC', '145', '7.9', '2017-11-19 18:09:44', 0, 1),
(43826, 'MG', 'F 160SE', '160', '7.6', '2017-11-19 18:09:45', 0, 1),
(43827, 'MG', 'TF 115', '116', '9.8', '2017-11-19 18:09:45', 0, 1),
(43828, 'MG', '120 Stepspeed', '120', '10.4', '2017-11-19 18:09:45', 0, 1),
(43829, 'MG', 'TF 161', '165', '7.2', '2017-11-19 18:09:45', 0, 1),
(43830, 'MG', 'TF 135', '136', '8.8', '2017-11-19 18:09:45', 0, 1),
(43831, 'MG', 'TF 160', '160', '7.6', '2017-11-19 18:09:45', 0, 1),
(43832, 'MG', 'XPower SV', '218.57', '4.3', '2017-11-19 18:09:45', 0, 1),
(43833, 'MG', 'XPower SV-R', '218.57', '5.1', '2017-11-19 18:09:45', 0, 1),
(43834, 'MG', 'Metro Turbo', '95', '9.5', '2017-11-19 18:09:45', 0, 1),
(43835, 'MG', 'Metro GTa', '74', '11.9', '2017-11-19 18:09:45', 0, 1),
(43836, 'MG', 'Metro 1.4 SL', '76', '12.1', '2017-11-19 18:09:45', 0, 1),
(43837, 'MG', 'Metro GTi 16v', '96', '9.9', '2017-11-19 18:09:45', 0, 1),
(43838, 'MG', 'Metro 1.1i', '61', '13.5', '2017-11-19 18:09:45', 0, 1),
(43839, 'MG', 'Metro Diesel', '53', '15.9', '2017-11-19 18:09:45', 0, 1),
(43840, 'MG', 'Maestro 2.0 EFi', '226', '15', '2017-11-19 18:09:45', 0, 1),
(43841, 'MG', 'Maestro Turbo', '152', '6.8', '2017-11-19 18:09:46', 0, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43842;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;