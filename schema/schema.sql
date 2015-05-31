SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `doges` (
  `href` char(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `imageRef` varchar(255) NOT NULL,
  PRIMARY KEY (`href`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
