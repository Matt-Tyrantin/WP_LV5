-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for fighter_game
CREATE DATABASE IF NOT EXISTS `fighter_game` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */;
USE `fighter_game`;

-- Dumping structure for table fighter_game.fighter_cats
CREATE TABLE IF NOT EXISTS `fighter_cats` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `age` tinyint(3) unsigned NOT NULL,
  `info` tinytext COLLATE utf8mb4_bin,
  `img` text COLLATE utf8mb4_bin,
  `wins` int(10) unsigned NOT NULL DEFAULT '1',
  `losses` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumping data for table fighter_game.fighter_cats: ~6 rows (approximately)
/*!40000 ALTER TABLE `fighter_cats` DISABLE KEYS */;
INSERT INTO `fighter_cats` (`id`, `name`, `age`, `info`, `img`, `wins`, `losses`) VALUES
	(1, 'Cat McTerror Pro', 3, 'Very Loud', './img/cat01.png', 5, 4),
	(2, 'Caterson CatSpyder Silva', 5, 'Slim, broke leg in past years', './img/cat02.png', 34, 10),
	(3, 'Friko Cro Cat Pro', 6, 'Past his prime, doing seminars', './img/cat03.png', 40, 11),
	(4, 'Catbib Furwamagedov', 3, 'Current champion, wrestle and catmbo are his style', './img/cat04.png', 28, 0),
	(5, 'Kit Kitty Kones', 3, 'Bad kitty, loves to use dog food better strength', './img/cat05.png', 26, 1),
	(6, 'Coy BigCat Meowson', 5, 'Big kitty, loves to fight', './img/cat06.png', 23, 18),
	(7, 'Kitezer', 5, 'Loves being called kitty', './img/test_kitty.png', 3, 2);
/*!40000 ALTER TABLE `fighter_cats` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
