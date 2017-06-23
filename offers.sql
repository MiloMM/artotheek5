-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                10.2.6-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Versie:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Structuur van  tabel forge.offers wordt geschreven
CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offers` decimal(10,2) NOT NULL DEFAULT 0.00,
  `name` varchar(50) DEFAULT NULL,
  `artworks_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel forge.offers: ~14 rows (ongeveer)
/*!40000 ALTER TABLE `offers` DISABLE KEYS */;
REPLACE INTO `offers` (`id`, `offers`, `name`, `artworks_id`) VALUES
	(1, 3.41, 'Sebas', 50),
	(2, 4.33, 'Sebas', NULL),
	(3, 4.32, 'Sebas', NULL),
	(4, 0.00, 'Sebas', NULL),
	(5, 4.32, 'Sebas', 0),
	(6, 4.32, 'Sebas', 0),
	(7, 4.32, 'Sebas', 0),
	(8, 4.32, 'Sebas', 0),
	(9, 4.32, 'Sebas', 0),
	(10, 3.55, 'Sebas', 0),
	(11, 3.55, 'Sebas', 50),
	(12, 4.99, 'Sebas', 50),
	(13, 6.32, 'Sebas', 50),
	(14, 7.32, 'Sebas', 50);
/*!40000 ALTER TABLE `offers` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
