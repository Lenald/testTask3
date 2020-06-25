-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.3.22-MariaDB-0+deb10u1 - Debian 10
-- Операционная система:         debian-linux-gnu
-- HeidiSQL Версия:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица test_Dorosh_amdev.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы test_Dorosh_amdev.cities: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` (`id`, `name`) VALUES
	(1, 'Minsk'),
	(2, 'Gomel'),
	(3, 'Hrodna'),
	(4, 'Baranovichi'),
	(5, 'Brest'),
	(6, 'Zhlobin'),
	(7, 'Vitebsk'),
	(8, 'Krugloe');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;

-- Дамп структуры для таблица test_Dorosh_amdev.persons
CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `fullname` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `city_id` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы test_Dorosh_amdev.persons: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `persons` DISABLE KEYS */;
INSERT INTO `persons` (`id`, `city_id`, `fullname`) VALUES
	(1, 5, 'Ivan Petrov'),
	(2, 3, 'Sebastian Haponenka'),
	(3, 3, 'Vasil Lutsevich'),
	(4, 2, 'Leo Klimovich'),
	(5, 7, 'Matea Kezhman'),
	(6, 8, 'Alex Marshall'),
	(7, 3, 'Bilbo Beggins');
/*!40000 ALTER TABLE `persons` ENABLE KEYS */;

-- Дамп структуры для таблица test_Dorosh_amdev.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_person_id` int(11) NOT NULL,
  `to_person_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `from_person_id` (`from_person_id`),
  KEY `to_person_id` (`to_person_id`),
  CONSTRAINT `from` FOREIGN KEY (`from_person_id`) REFERENCES `persons` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `to` FOREIGN KEY (`to_person_id`) REFERENCES `persons` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы test_Dorosh_amdev.transactions: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` (`transaction_id`, `from_person_id`, `to_person_id`, `amount`) VALUES
	(1, 4, 2, 10),
	(2, 2, 3, 7),
	(3, 5, 2, 12.54),
	(4, 4, 7, 13),
	(5, 3, 1, 8.23),
	(6, 1, 3, 12.3),
	(7, 2, 5, 3.12);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
