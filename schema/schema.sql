SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `instance` char(255) NOT NULL,
  `href` char(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `imageRef` varchar(255) NOT NULL,
  INDEX `instHref` (`instance`, `href`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
