CREATE DATABASE admin_db;
use admin_db;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(100)NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
);
INSERT INTO `users`(`id`, `username`, `email`, `password`) VALUES (1, "admin", "DBadmin@xyz.com", "admin");
