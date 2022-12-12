CREATE DATABASE IF NOT EXISTS dashboard_lol;
USE dashboard_lol;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
`user_id` int NOT NULL AUTO_INCREMENT,
`user_name` varchar(255) NOT NULL,
`password` varchar(255) NOT NULL,
`num_of_columns` tinyint NOT NULL,
`user_first_name` varchar(255) NOT NULL,
`user_last_name` varchar(255) NOT NULL,
`user_email` varchar(255) NOT NULL,
`user_phone_num` varchar(255) NOT NULL,
`user_data` longtext,
PRIMARY KEY (`user_id`),
UNIQUE KEY `user_id_UNIQUE` (`user_id`),
UNIQUE KEY `user_name_UNIQUE` (`user_name`)
);

DROP TABLE IF EXISTS `widgets`;
CREATE TABLE `widgets` (
`widget_id` int NOT NULL AUTO_INCREMENT,
`internal_name` varchar(45) NOT NULL,
`data_dump` longtext,
PRIMARY KEY (`widget_id`),
UNIQUE KEY `widget_id_UNIQUE` (`widget_id`),
UNIQUE KEY `internal_name_UNIQUE` (`internal_name`)
);

DROP TABLE IF EXISTS `appstore`;
CREATE TABLE `appstore` (
`app_id` int NOT NULL AUTO_INCREMENT,
`widget_id` int NOT NULL,
`name` varchar(45) NOT NULL,
`description` text NOT NULL,
`ratings_count` int NOT NULL,
`rating` double(2,1) DEFAULT NULL,
`count_users_enabled` int DEFAULT NULL,
PRIMARY KEY (`app_id`),
UNIQUE KEY `app_id_UNIQUE` (`app_id`),
UNIQUE KEY `widget_id_UNIQUE` (`widget_id`),
KEY `fk_AppStore_Widgets1_idx` (`widget_id`),
CONSTRAINT `fk_AppStore_Widgets1` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`widget_id`)
);

DROP TABLE IF EXISTS `added`;
CREATE TABLE `added` (
`add_id` int NOT NULL AUTO_INCREMENT,
`user_id` int NOT NULL,
`widget_id` int NOT NULL,
`placed_column` int NOT NULL,
`order_in_column` int NOT NULL,
PRIMARY KEY (`add_id`),
UNIQUE KEY `add_id_UNIQUE` (`add_id`),
KEY `fk_Added_Users_idx` (`user_id`),
KEY `fk_Added_Widgets1_idx` (`widget_id`),
CONSTRAINT `fk_Added_Users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
CONSTRAINT `fk_Added_Widgets1` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`widget_id`)
);

CREATE USER IF NOT EXISTS 'dashboard_agent'@'localhost' IDENTIFIED BY 'thedashboardliveson';
GRANT ALL PRIVILEGES ON dashboard_lol.* TO 'dashboard_agent'@'localhost';