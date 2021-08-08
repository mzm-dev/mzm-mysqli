# mzm-mysqli
Example MySQLi Object oriented style

> framework is always more feasible than coding in the pure language.

```mysql

-- Dumping database structure for db_mysqli
CREATE DATABASE IF NOT EXISTS `db_mysqli`
USE `db_mysqli`;

-- Dumping structure for table db_mysqli.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

```
