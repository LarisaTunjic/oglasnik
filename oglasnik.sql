-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 30, 2020 at 01:50 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oglasnik`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

DROP TABLE IF EXISTS `kategorija`;
CREATE TABLE IF NOT EXISTS `kategorija` (
  `id_kategorija` int(11) NOT NULL,
  `naziv` varchar(100) DEFAULT NULL,
  `slika` int(11) DEFAULT '0',
  `nadkategorija_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_kategorija`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`id_kategorija`, `naziv`, `slika`, `nadkategorija_id`) VALUES
(1, 'Nekretnine', 1, NULL),
(2, 'Auto-moto', 1, NULL),
(3, 'Informatika', 1, NULL),
(4, 'Mobiteli', 1, NULL),
(5, 'Posao', 1, NULL),
(6, 'Glazbala', 1, NULL),
(7, 'Sport', 1, NULL),
(8, 'Sve za dom', 1, NULL),
(9, 'Kućni ljubimci', 1, NULL),
(10, 'Ostalo', 1, NULL),
(11, 'Usluge', 1, NULL),
(12, 'Turizam', 1, NULL),
(13, 'Audio, Video i Foto', 1, NULL),
(14, 'Kuće', 1, 1),
(15, 'Stanovi', 1, 1),
(16, 'Osobni automobili', 1, 2),
(17, 'Kamperi i kamp prikolice', 1, 2),
(18, 'Kamperi', 1, 17),
(19, 'Kamp prikolice', 1, 17),
(20, 'Dalmacija', 1, 12),
(21, 'Čišćenje i održavanje', 1, 11),
(22, 'PC računala i oprema', 1, 3),
(23, 'Klavijature i oprema', 1, 6),
(24, 'Bicikli i biciklistička oprema', 1, 7),
(25, 'i-phone', 1, 4),
(26, 'Samsung', 1, 4),
(27, 'Informatika i telekomunikacije', 1, 5),
(28, 'Prodaja', 1, 5),
(29, 'Strojevi i alati', 1, NULL),
(30, 'Puhački instumenti i oprema', 1, 6),
(31, 'Golf oprema', 1, 7),
(32, 'Namještaj', 1, 8),
(33, 'Suđe i posuđe', 1, 8),
(34, 'Prodaja kućnih ljubimaca', 1, 9),
(35, 'Udomljavanje kućnih ljubimaca', 1, 9),
(36, 'Ljepota i njega', 1, 11),
(37, 'Izvan Hrvatske', 1, 12),
(38, 'Nokia', 1, 4),
(39, 'HTC', 1, 4),
(40, 'Umjetni nokti i oprema', 1, 10),
(41, 'Karte i ulaznice', 1, 10),
(42, 'Medicinska pomagala', 1, 10),
(43, 'Invalidska kolica', 1, 42),
(44, 'Maske za lice', 1, 42),
(45, 'Literatura', 1, NULL),
(47, 'Stripovi', 1, 45),
(46, 'Književnost', 1, 45),
(48, 'Renault', 1, 16),
(49, 'Mazda', 1, 16),
(50, 'Softver', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `id_korisnik` int(11) NOT NULL AUTO_INCREMENT,
  `id_tip` int(11) NOT NULL DEFAULT '1',
  `korisnicko_ime` varchar(50) DEFAULT NULL,
  `lozinka` varchar(32) DEFAULT NULL,
  `ime` varchar(50) DEFAULT NULL,
  `prezime` varchar(100) DEFAULT NULL,
  `kontakt_k` varchar(200) DEFAULT '0',
  `email` varchar(50) DEFAULT NULL,
  `slika` int(11) DEFAULT '0',
  PRIMARY KEY (`id_korisnik`),
  KEY `id_tip` (`id_tip`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id_korisnik`, `id_tip`, `korisnicko_ime`, `lozinka`, `ime`, `prezime`, `kontakt_k`, `email`, `slika`) VALUES
(1, 0, 'admin', '123', 'Administrator', '', '0', '', 1),
(2, 0, 'lara', '123', 'Larisa', 'Čemeljić', '911520109', 'larisa.cemeljic@gmail.com', 1),
(3, 1, 'korisnik', '123', 'Neću', 'Reći', '0', 'korisnik@gmail.com', 1),
(4, 1, 'ivanmatic24', '123', 'Ivan', 'Matić', '0', 'ivanmatic@info.hr', 1),
(5, 1, 'lucija99', '123', 'Lucija', 'Čemeljić', '0', 'lucija99@gmail.com', 0),
(6, 1, 'ivan', '123', 'Ivan', 'Tunjić', '0', 'ivan@gmail.com', 1),
(7, 1, 'Loro', '123', 'Loris', 'Matić', '0', 'loris@gmail.com', 0),
(8, 1, 'maja', '123', 'Maja', 'Lončar', '0', 'majaloncar@gmail.com', 0),
(9, 1, 'ifka', '123', 'Ivana', 'Leutarević', '0', 'ivana@gmail.com', 1),
(10, 1, 'JokyRu', '123', 'Josipa', 'Rukavina', '0', 'Jopica@gmail.com', 0),
(11, 1, 'sandy', '123', 'Sandra', 'Marić', '0', 'sandra@gmail.com', 0),
(12, 1, 'superman', '123', 'super', 'čovjek', '0', 'superman@gmail.com', 1),
(13, 1, 'andja', '123', 'Anđelina', 'Pakračić', '0', 'angelina@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `oglas`
--

DROP TABLE IF EXISTS `oglas`;
CREATE TABLE IF NOT EXISTS `oglas` (
  `id_oglas` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategorija` int(11) NOT NULL,
  `id_tip_oglas` int(11) NOT NULL,
  `id_korisnik` int(11) NOT NULL,
  `naslov` varchar(100) DEFAULT NULL,
  `tekst` varchar(5000) DEFAULT NULL,
  `vrijedi_od` datetime DEFAULT NULL,
  `vrijedi_do` datetime DEFAULT NULL,
  `aktivan` int(11) DEFAULT NULL,
  `kontakt_o` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_oglas`),
  KEY `oglas_FKIndex1` (`id_kategorija`),
  KEY `oglas_FKIndex2` (`id_tip_oglas`),
  KEY `oglas_FKIndex3` (`id_korisnik`),
  KEY `IFK_Rel_07` (`id_kategorija`),
  KEY `IFK_Rel_08` (`id_tip_oglas`),
  KEY `IFK_Rel_09` (`id_korisnik`)
) ENGINE=MyISAM AUTO_INCREMENT=387 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oglas`
--

INSERT INTO `oglas` (`id_oglas`, `id_kategorija`, `id_tip_oglas`, `id_korisnik`, `naslov`, `tekst`, `vrijedi_od`, `vrijedi_do`, `aktivan`, `kontakt_o`) VALUES
(159, 14, 2, 2, 'Prodajem kuću', 'Prodajem kuću na klizištu, nije mnogo prešla.', '2020-09-29 19:05:51', '2020-10-29 19:05:51', 1, '0911542744'),
(160, 15, 1, 2, 'Stan u centru', 'Prodajem stan u centru, Ilica 147, 20 m2 samo 50 000€', '2020-09-25 12:57:00', '2020-10-28 12:57:00', 1, '09115400888'),
(161, 16, 2, 2, 'Prodajem Ladu', 'Prodajem Ladu trula višnja. Šifra: Više trula, nego višnja', '2020-09-28 12:57:04', '2020-10-28 12:57:04', 1, '0911542711'),
(162, 16, 2, 2, 'Prodajem Mazdu', 'Mazda 626, glasi na mene.', '2020-09-28 12:57:06', '2020-10-28 12:57:06', 1, '0911234567'),
(163, 18, 1, 2, 'Kamper Hobby', 'Prodajem novi kamper Hobby nemam novaca za benzin.', '2020-09-28 12:57:09', '2020-10-28 12:57:09', 1, '0911113331'),
(164, 19, 2, 2, 'Adria - kamp-kućica 1999', 'Prodajem kamp kućicu marke Adrija, godina 1999, u jako dobrom je stanju.', '2020-09-28 12:57:11', '2020-10-28 12:57:11', 1, '0911542755'),
(165, 16, 2, 4, 'Zamjena', 'Mijenjam Fiću sa kukom za Trabanta sa kukom', '2020-09-28 17:04:56', '2020-10-28 17:04:56', 1, '09811554477'),
(166, 16, 2, 4, 'VW Buba', 'VW buba, 59. god, kao nova.', '2020-09-28 17:04:58', '2020-10-28 17:04:58', 1, '0976321882'),
(167, 32, 2, 5, 'Fotelja', 'Poklanjam fotelju, zainteresirani javite se na mobitel.', '2020-09-28 17:05:00', '2020-10-28 17:05:00', 1, '09511447513'),
(168, 27, 2, 5, 'PHP programer', 'PHP programer s iskustvom od 6 godina traži honorarni posao.', '2020-09-28 17:05:02', '2020-10-28 17:05:02', 1, '0922131177'),
(169, 27, 1, 6, 'Java programer', 'Tražim Java programera s iskustvom izrade hibernate aplikacija.', '2020-09-28 17:05:04', '2020-10-28 17:05:04', 1, '0924721454'),
(170, 38, 2, 6, 'Nokia 5800XM', 'Prodajem Nokiu 5800 Xpress Music za 600kn.', '2020-09-28 17:05:06', '2020-10-28 17:05:06', 1, '091004444'),
(171, 39, 1, 7, 'HTC Desire', 'Kupujem HTC Desire otključan na sve mreže.', '2020-09-28 17:05:07', '2020-10-28 17:05:07', 1, '0923451477'),
(172, 22, 2, 7, 'Kupujem printer', 'Kupujem neki printer do 100kn koji može koristiti zamjenske tinte. Nešto tipa ovog na slici.', '2020-09-28 17:05:09', '2020-10-28 17:05:09', 1, '0991641312'),
(363, 21, 2, 8, 'Čistim stanove', '75 kn sat', '2020-09-28 17:31:45', '2020-10-28 17:31:45', 1, '0914127451'),
(374, 33, 2, 10, 'Prodajem Mehrzer tave', 'Set se sastoji od:\r\n● Tava 24cm,\r\n● Tava 28cm,\r\n● Tava za palačinke 28cm,\r\n● Lonac za umake 20cm,\r\n● Duboka tava 28cm.\r\n\r\n', '2020-09-28 18:23:09', '2020-10-28 18:23:09', 1, '0911542744'),
(373, 20, 2, 9, 'PRODAJA UHODANOG POSLA - Luksuzne mobilne kuće u Kamp Parku Soline', 'Prodaju se 2 luksuzne mobilne kućice u kamp Parku Soline u Biogradu na Moru s pravom nastavka potpisivanja ugovora s kampom u svrhu zakupa parcela. Baobab Mobile Homes se uspješno iznajmljuju 3 godine te kupac može s istim brendom nastaviti svoje poslovanje. Nije potrebno nikakvo dodatno ulaganje-kućice su potpuno opremljene i vlasnici ostavljaju sve što je potrebno kako bi se gosti osjećali ugodno tokom odmora u Baobab MH.', '2020-09-28 18:06:35', '2020-10-28 18:06:35', 1, '0911542744'),
(376, 35, 2, 11, 'Udomite psa Elin', 'Draga naša Elin \r\nJedna od mama naše desetorke.\r\nMa ne mogu Vam riječima i kroz slike opisati koliko je to divan i poseban pas.\r\nSavršena.Doslovno.\r\nPas za poželjeti, ono kad ju upoznaš da poželiš da svaki idući dan bude uz tebe.\r\nMalena je svega 10-ak kilograma.\r\nNaučena na kućni red, suživot sa psima i mačkama.\r\nMazna, draga, poslušna i u kući neprimjetna, obožava ljude.\r\nUskoro sterilizirana, cijepljena, čipirana i očišćena od parazita.\r\nNalazi se u Zagrebu na smještaju!', '2020-09-28 18:23:25', '2020-10-28 18:23:25', 1, '0911542744'),
(377, 13, 2, 13, '***SONY A6500 tijelo, kao novi, sva oprema + 5 baterija ***', 'Prodajem Sony A6500 Mirrorless tijelo. Sve komplet u kutiji zapakirano (5 baterija FW50, remen, poklopci...) aparat je malo korišten, ima svega 9700 okidanja, full očuvan, nema ogrebotine. Cijena 6 000 kuna fiksna.\r\n', '2020-09-28 18:55:53', '2020-10-28 18:55:53', 1, '0952147413'),
(378, 29, 2, 12, 'MINI BAGER SUNWARD AKCIJA!!!', 'ROVOKOPAČ SUNWARD SWE 20F 1.94t MINI BAGER (specifikacija stroja na stranici www.sunward.hr)\r\ngodina proizvodnje: 2020 g.\r\n-gumene gusjenice\r\n-radio uređaj\r\n-3 korpe\r\n-mehanička brza spojka za izmjenu alata\r\n-Alfa gomma hidraulična instalacija\r\n-instalacija za čekić\r\n-duža ruka\r\n-YANMAR motor\r\n-KYB hidraulika (kao na BOBCATU-u)\r\n-EATON pogonski hidromotori\r\nAKCIJA!! !!', '2020-09-28 19:11:41', '2020-10-28 19:11:41', 1, '09214578475'),
(379, 24, 2, 12, 'BMX', 'Zion rama\r\nWTP dijelovi\r\n2 pega\r\nObnovljeni lageri u kotacima\r\nZa vise slika i dogovor oko cijene na broj 0921990123', '2020-09-28 20:20:23', '2020-10-28 20:20:23', 1, '09732141232'),
(380, 31, 2, 12, 'TORBA ZA GOLF', 'Golf torba \"Crew Parker\" za golf palice, nova, nekorištena', '2020-09-28 20:20:24', '2020-10-28 20:20:24', 1, '0988547412'),
(381, 23, 2, 6, 'Yamaha PSR-19 Keyboard', 'Dolazi sa stalkom za sintisazjer.', '2020-09-28 20:20:26', '2020-10-28 20:20:26', 1, '09541241244'),
(382, 30, 2, 10, 'Saksofon Jupiter 769/767 Alt sax', 'Povoljno prodajem alt sax Jupiter 769/767 (intermediate). Sax je generalno sređen nedavno (novi polsteri i pluta)i nema dodatnih ulaganja (uzmi i sviraj). Intonacija odlična, moguće isprobati prije kupnje.', '2020-09-28 20:20:28', '2020-10-28 20:20:28', 1, '09956413788'),
(383, 46, 2, 11, 'Joe Abercrombie - Trilogija: Smrskano more', 'Sve ono po čemu je Abercrombie poznat prisutno je u ovoj trilogiji: sjajno karakterizirani i životni likovi, zanimljiva radnja s tek mjestimično ubačenim elementima fantasyja, koja se većinom doima poput kakve povijesne priče, humor koji proizlazi iz reakcija odlično napisanih likova. Stoga je trilogija „Smrskano more“ zaokruženo i cjelovito djelo koje se čita u jednome dahu i teško ispušta iz ruku. Prava književna poslastica!', '2020-09-28 20:20:33', '2020-10-28 20:20:33', 1, '09811554477'),
(384, 44, 2, 7, 'Zaštitna maska', 'Zaštitna maska troslojna:\r\nviše o proizvodu pogledajte na http://boxes.hr/zastitne-maske/\r\n-sa EU certifikatom \"medicinski proizvod I. klase rizika\" MDR 2017/745 EU\r\n-proizvod je registriran u bazi EUDAMED (registrirani medicinski proizvodi za tržište EU)\r\n-proizvodi bez CE oznake ne mogu se uvesti u EU\r\n-samo registrirani EUDAMED proizvodi mogu biti medicinski proizvod i nositi CE oznaku\r\nprovjerite podrijetlo Vašeg proizvoda', '2020-09-28 20:27:28', '2020-10-28 20:27:28', 2, '09511447513'),
(385, 43, 2, 8, 'Vodootporna invalidska kolica', '- KOLICA KOJA SLUŽE ZA TRANSPORT- PREBACIVANJE , VRŠENJE NUŽDE I KUPANJE\r\n- DUBINA : 110 KG\r\n- ŠIRINA : 64 CM\r\n- VISINA : 102 cm\r\n- TEŽINA KOLICA 18,8 KG\r\n- UKUPNO OPTEREČENJE : 120 KG\r\n- ŠIRINA SJEDIŠTA : 44 CM\r\n\r\n\r\nCIJENA : 2500 KN', '2020-09-28 20:27:31', '2020-10-28 20:27:31', 2, '09754618578'),
(386, 48, 2, 2, 'Kupujem clio grandtour 2016', 'Ako ima u crvenoj boji kao na slikama.', NULL, NULL, 0, '0911542744');

-- --------------------------------------------------------

--
-- Table structure for table `slike_oglasa`
--

DROP TABLE IF EXISTS `slike_oglasa`;
CREATE TABLE IF NOT EXISTS `slike_oglasa` (
  `id_slika` int(11) NOT NULL AUTO_INCREMENT,
  `id_oglas` int(11) NOT NULL,
  `ime_slika` varchar(255) DEFAULT NULL,
  `tip_slika` varchar(255) DEFAULT NULL,
  `putanja_slika` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_slika`),
  KEY `id_oglas` (`id_oglas`)
) ENGINE=MyISAM AUTO_INCREMENT=695 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slike_oglasa`
--

INSERT INTO `slike_oglasa` (`id_slika`, `id_oglas`, `ime_slika`, `tip_slika`, `putanja_slika`) VALUES
(398, 160, '5eb05312db4ab3.99748528.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_160/5eb05312db4ab3.99748528.jpg'),
(397, 159, '5eb052763d63c1.68542438.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_159/5eb052763d63c1.68542438.jpg'),
(396, 159, '5eb052763d10d7.24738276.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_159/5eb052763d10d7.24738276.jpg'),
(395, 159, '5eb052763c96f7.40811282.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_159/5eb052763c96f7.40811282.jpg'),
(663, 374, '5f720bf2da5798.53899812.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_374/5f720bf2da5798.53899812.jpg'),
(662, 374, '5f720bf2d29584.83844297.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_374/5f720bf2d29584.83844297.jpg'),
(399, 160, '5eb05312dbc062.22878876.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_160/5eb05312dbc062.22878876.jpg'),
(400, 160, '5eb05312dc2ba2.15773775.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_160/5eb05312dc2ba2.15773775.jpg'),
(401, 161, '5eb053a9a69862.68058439.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_161/5eb053a9a69862.68058439.jpg'),
(402, 161, '5eb053a9a71b20.94835418.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_161/5eb053a9a71b20.94835418.jpg'),
(403, 161, '5eb053a9a76c79.30911449.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_161/5eb053a9a76c79.30911449.jpg'),
(404, 162, '5eb0542394f868.40759684.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_162/5eb0542394f868.40759684.jpg'),
(405, 162, '5eb0542395a0b9.91137457.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_162/5eb0542395a0b9.91137457.jpg'),
(406, 163, '5eb054dd54d7c1.06806437.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_163/5eb054dd54d7c1.06806437.jpg'),
(410, 164, '5eb055dc93e3c8.39772236.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_164/5eb055dc93e3c8.39772236.jpg'),
(408, 163, '5eb054dd559df6.15235940.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_163/5eb054dd559df6.15235940.jpg'),
(409, 163, '5eb054dd5666f7.98733787.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_163/5eb054dd5666f7.98733787.jpg'),
(411, 164, '5eb055dc946e07.65768081.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_164/5eb055dc946e07.65768081.jpg'),
(412, 165, '5eb1376907cb59.23779685.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_165/5eb1376907cb59.23779685.jpg'),
(413, 165, '5eb137690843d5.01698644.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_165/5eb137690843d5.01698644.jpg'),
(414, 165, '5eb13769089399.41261734.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_165/5eb13769089399.41261734.jpg'),
(415, 166, '5eb137c3a27288.58726802.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_166/5eb137c3a27288.58726802.jpg'),
(416, 166, '5eb137c3a32536.68208951.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_166/5eb137c3a32536.68208951.jpg'),
(417, 171, '5eb1578c581a68.38836718', 'image/jpeg', 'uploads/oglasi/slike_oglasa_171/5eb1578c581a68.38836718'),
(661, 374, '5f720bf2d21345.61797220.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_374/5f720bf2d21345.61797220.jpg'),
(655, 367, '5f720635744004.91990029.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_367/5f720635744004.91990029.jpg'),
(654, 367, '5f7206356cced1.06232290.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_367/5f7206356cced1.06232290.jpg'),
(653, 367, '5f720635617bb8.54617045.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_367/5f720635617bb8.54617045.jpg'),
(652, 367, '5f72063558ce55.80219999.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_367/5f72063558ce55.80219999.jpg'),
(651, 367, '5f7206355853c5.98230983.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_367/5f7206355853c5.98230983.jpg'),
(619, 371, '5f7203ab06b410.90419165.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_371/5f7203ab06b410.90419165.jpg'),
(616, 370, '5f7203876b96a9.47431522.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_370/5f7203876b96a9.47431522.jpg'),
(617, 371, '5f7203aaf0c815.55664385.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_371/5f7203aaf0c815.55664385.jpg'),
(618, 371, '5f7203aaf144c4.67569274.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_371/5f7203aaf144c4.67569274.jpg'),
(615, 370, '5f7203876315e2.03949296.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_370/5f7203876315e2.03949296.jpg'),
(611, 368, '5f720342bd8d12.92142544.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_368/5f720342bd8d12.92142544.jpg'),
(612, 369, '5f720361b02f52.25140415.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_369/5f720361b02f52.25140415.jpg'),
(613, 369, '5f720361b13e66.53879368.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_369/5f720361b13e66.53879368.jpg'),
(614, 370, '5f72038762a453.07945008.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_370/5f72038762a453.07945008.jpg'),
(459, 172, '5eb3095088cf49.81441512.png', 'image/png', 'uploads/oglasi/slike_oglasa_172/5eb3095088cf49.81441512.png'),
(627, 372, '5f72040cf16048.22444381.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_372/5f72040cf16048.22444381.jpg'),
(626, 372, '5f72040ceafa42.14119524.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_372/5f72040ceafa42.14119524.jpg'),
(625, 372, '5f7203c7dc7a96.54679191.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_372/5f7203c7dc7a96.54679191.jpg'),
(620, 371, '5f7203ab0e9013.19061237.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_371/5f7203ab0e9013.19061237.jpg'),
(621, 372, '5f7203c7c3c9d8.23889810.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_372/5f7203c7c3c9d8.23889810.jpg'),
(622, 372, '5f7203c7c44859.43039536.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_372/5f7203c7c44859.43039536.jpg'),
(623, 372, '5f7203c7ccd5f9.05329322.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_372/5f7203c7ccd5f9.05329322.jpg'),
(624, 372, '5f7203c7d4d135.69505161.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_372/5f7203c7d4d135.69505161.jpg'),
(594, 363, '5f71fa8fd8c451.40486872.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_363/5f71fa8fd8c451.40486872.jpg'),
(593, 363, '5f71fa8fd6a7d0.92899577.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_363/5f71fa8fd6a7d0.92899577.jpg'),
(660, 373, '5f7206619756c8.42610052.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_373/5f7206619756c8.42610052.jpg'),
(659, 373, '5f7206618ed838.67764777.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_373/5f7206618ed838.67764777.jpg'),
(628, 372, '5f72040d052388.56974012.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_372/5f72040d052388.56974012.jpg'),
(629, 372, '5f72040d0b86e5.36976133.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_372/5f72040d0b86e5.36976133.jpg'),
(630, 372, '5f72040d119666.48215217.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_372/5f72040d119666.48215217.jpg'),
(658, 373, '5f72066182e201.68816911.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_373/5f72066182e201.68816911.jpg'),
(657, 373, '5f72066174c232.75502409.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_373/5f72066174c232.75502409.jpg'),
(656, 373, '5f720661743a89.11457489.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_373/5f720661743a89.11457489.jpg'),
(550, 172, '5eb5c3b5309af3.30038467.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_172/5eb5c3b5309af3.30038467.jpg'),
(538, 172, '5eb5c30ca97893.82432880.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_172/5eb5c30ca97893.82432880.jpg'),
(539, 172, '5eb5c30cb16126.31364938.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_172/5eb5c30cb16126.31364938.jpg'),
(540, 172, '5eb5c30cba0210.47077285.png', 'image/png', 'uploads/oglasi/slike_oglasa_172/5eb5c30cba0210.47077285.png'),
(541, 172, '5eb5c30cbffd60.97529783.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_172/5eb5c30cbffd60.97529783.jpg'),
(542, 172, '5eb5c30cc8bdf6.90612516.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_172/5eb5c30cc8bdf6.90612516.jpg'),
(543, 172, '5eb5c34f3efdb8.47149475.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_172/5eb5c34f3efdb8.47149475.jpg'),
(544, 172, '5eb5c34f4561a1.49913741.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_172/5eb5c34f4561a1.49913741.jpg'),
(545, 172, '5eb5c34f4ba213.63186036.png', 'image/png', 'uploads/oglasi/slike_oglasa_172/5eb5c34f4ba213.63186036.png'),
(546, 172, '5eb5c3b518c098.85596014.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_172/5eb5c3b518c098.85596014.jpg'),
(547, 172, '5eb5c3b51ee797.40179126.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_172/5eb5c3b51ee797.40179126.jpg'),
(548, 172, '5eb5c3b524a218.33181950.png', 'image/png', 'uploads/oglasi/slike_oglasa_172/5eb5c3b524a218.33181950.png'),
(549, 172, '5eb5c3b52a7fa5.76604992.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_172/5eb5c3b52a7fa5.76604992.jpg'),
(681, 379, '5f72171b834153.41218261.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_379/5f72171b834153.41218261.jpg'),
(680, 378, '5f7216994b5710.31877244.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_378/5f7216994b5710.31877244.jpg'),
(679, 378, '5f7216994378a2.66521210.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_378/5f7216994378a2.66521210.jpg'),
(678, 378, '5f72169942ed95.77574730.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_378/5f72169942ed95.77574730.jpg'),
(675, 376, '5f720e6d641a25.93041437.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_376/5f720e6d641a25.93041437.jpg'),
(677, 377, '5f7211903ac740.41221255.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_377/5f7211903ac740.41221255.jpg'),
(676, 376, '5f720eb64f71d8.64620320.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_376/5f720eb64f71d8.64620320.jpg'),
(672, 376, '5f720dcbaeed92.32019256.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_376/5f720dcbaeed92.32019256.jpg'),
(682, 380, '5f7217cd830ef4.14647675.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_380/5f7217cd830ef4.14647675.jpg'),
(683, 381, '5f72272b2e4d92.08205321.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_381/5f72272b2e4d92.08205321.jpg'),
(684, 381, '5f72272b2ed386.35986713.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_381/5f72272b2ed386.35986713.jpg'),
(685, 382, '5f7227868ba996.19565867.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_382/5f7227868ba996.19565867.jpg'),
(686, 383, '5f72281e597a27.04207622.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_383/5f72281e597a27.04207622.jpg'),
(687, 383, '5f72281e59fe24.17908979.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_383/5f72281e59fe24.17908979.jpg'),
(688, 383, '5f72281e63bc72.46649774.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_383/5f72281e63bc72.46649774.jpg'),
(689, 383, '5f72281e6d8a07.79931610.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_383/5f72281e6d8a07.79931610.jpg'),
(690, 384, '5f722a72c9a5b0.58702579.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_384/5f722a72c9a5b0.58702579.jpg'),
(691, 384, '5f722a72ca2809.06059240.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_384/5f722a72ca2809.06059240.jpg'),
(692, 385, '5f722afa427c67.47209052.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_385/5f722afa427c67.47209052.jpg'),
(693, 386, '5f7371560e7818.05893214.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_386/5f7371560e7818.05893214.jpg'),
(694, 386, '5f7371560f67c8.15707184.jpg', 'image/jpeg', 'uploads/oglasi/slike_oglasa_386/5f7371560f67c8.15707184.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tip_korisnika`
--

DROP TABLE IF EXISTS `tip_korisnika`;
CREATE TABLE IF NOT EXISTS `tip_korisnika` (
  `id_tip` int(11) NOT NULL,
  `naziv` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tip_korisnika`
--

INSERT INTO `tip_korisnika` (`id_tip`, `naziv`) VALUES
(0, 'administrator'),
(1, 'korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `tip_oglasa`
--

DROP TABLE IF EXISTS `tip_oglasa`;
CREATE TABLE IF NOT EXISTS `tip_oglasa` (
  `id_tip_oglas` int(11) NOT NULL,
  `naziv` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_tip_oglas`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tip_oglasa`
--

INSERT INTO `tip_oglasa` (`id_tip_oglas`, `naziv`) VALUES
(1, 'Plaćeni'),
(2, 'Besplatni');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
