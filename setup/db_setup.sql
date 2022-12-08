-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: dashboard_lol
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `added`
--

DROP TABLE IF EXISTS `added`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `added` (
  `add_id` int NOT NULL AUTO_INCREMENT COMMENT 'Which widgets the user has added to their dashboard',
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appstore`
--

DROP TABLE IF EXISTS `appstore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `num_of_columns` tinyint NOT NULL,
  `user_first_name` varchar(255) NOT NULL,
  `user_last_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone_num` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `widgets`
--

DROP TABLE IF EXISTS `widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widgets` (
  `widget_id` int NOT NULL AUTO_INCREMENT,
  `internal_name` varchar(45) NOT NULL,
  `data_dump` longtext,
  PRIMARY KEY (`widget_id`),
  UNIQUE KEY `widget_id_UNIQUE` (`widget_id`),
  UNIQUE KEY `internal_name_UNIQUE` (`internal_name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-07 19:41:50



-- Create a transaction to insert the data into the database
START TRANSACTION;

-- Create two test users, with our accounts
INSERT INTO `users` VALUES (2,'mwcurtis','31013932',3,'Matt','Curtis','mwcurtis@oakland.edu','8103283548'),(3,'dan','anythingsecure',3,'Dan','M','dmocnik@oakland.edu','5862592498');

-- Create the matching widgets and their associated HTML data
INSERT INTO `widgets` VALUES (15,'helloworld','<p>Hello!</p>'),(16,'stevewilson','<img src=\"https://moodle.oakland.edu/pluginfile.php/6941179/user/icon/ou_boost/f3\">'),(17,'calculator','<!-- https://www.geeksforgeeks.org/html-calculator/ -->\n\n<!DOCTYPE html>\n<html>\n\n<head>\n	<script src=\n\"https://cdnjs.cloudflare.com/ajax/libs/mathjs/10.6.4/math.js\"\n		integrity=\n\"sha512-BbVEDjbqdN3Eow8+empLMrJlxXRj5nEitiCAK5A1pUr66+jLVejo3PmjIaucRnjlB0P9R3rBUs3g5jXc8ti+fQ==\"\n		crossorigin=\"anonymous\"\n		referrerpolicy=\"no-referrer\"></script>\n	<script src=\n\"https://cdnjs.cloudflare.com/ajax/libs/mathjs/10.6.4/math.min.js\"\n		integrity=\n\"sha512-iphNRh6dPbeuPGIrQbCdbBF/qcqadKWLa35YPVfMZMHBSI6PLJh1om2xCTWhpVpmUyb4IvVS9iYnnYMkleVXLA==\"\n		crossorigin=\"anonymous\"\n		referrerpolicy=\"no-referrer\"></script>\n	<!-- for styling -->\n	<style>\n		table {\n			border: 1px solid black;\n			margin-left: auto;\n			margin-right: auto;\n		}\n\n		input[type=\"button\"] {\n			width: 100%;\n			padding: 20px 40px;\n			background-color: green;\n			color: white;\n			font-size: 24px;\n			font-weight: bold;\n			border: none;\n			border-radius: 5px;\n		}\n\n		input[type=\"text\"] {\n			padding: 20px 30px;\n			font-size: 24px;\n			font-weight: bold;\n			border: none;\n			border-radius: 5px;\n			border: 2px solid black;\n		}\n	</style>\n</head>\n<!-- create table -->\n\n<body>\n	<table id=\"calcu\">\n		<tr>\n			<td colspan=\"3\"><input type=\"text\" id=\"result\"></td>\n			<!-- clr() function will call clr to clear all value -->\n			<td><input type=\"button\" value=\"c\" onclick=\"clr()\" /> </td>\n		</tr>\n		<tr>\n			<!-- create button and assign value to each button -->\n			<!-- dis(\"1\") will call function dis to display value -->\n			<td><input type=\"button\" value=\"1\" onclick=\"dis(\'1\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<td><input type=\"button\" value=\"2\" onclick=\"dis(\'2\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<td><input type=\"button\" value=\"3\" onclick=\"dis(\'3\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<td><input type=\"button\" value=\"/\" onclick=\"dis(\'/\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n		</tr>\n		<tr>\n			<td><input type=\"button\" value=\"4\" onclick=\"dis(\'4\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<td><input type=\"button\" value=\"5\" onclick=\"dis(\'5\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<td><input type=\"button\" value=\"6\" onclick=\"dis(\'6\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<td><input type=\"button\" value=\"*\" onclick=\"dis(\'*\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n		</tr>\n		<tr>\n			<td><input type=\"button\" value=\"7\" onclick=\"dis(\'7\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<td><input type=\"button\" value=\"8\" onclick=\"dis(\'8\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<td><input type=\"button\" value=\"9\" onclick=\"dis(\'9\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<td><input type=\"button\" value=\"-\" onclick=\"dis(\'-\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n		</tr>\n		<tr>\n			<td><input type=\"button\" value=\"0\" onclick=\"dis(\'0\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<td><input type=\"button\" value=\".\" onclick=\"dis(\'.\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n			<!-- solve function call function solve to evaluate value -->\n			<td><input type=\"button\" value=\"=\" onclick=\"solve()\"> </td>\n\n			<td><input type=\"button\" value=\"+\" onclick=\"dis(\'+\')\"\n						onkeydown=\"myFunction(event)\"> </td>\n		</tr>\n	</table>\n\n	<script>\n		// Function that display value\n		function dis(val) {\n			document.getElementById(\"result\").value += val\n		}\n\n		function myFunction(event) {\n			if (event.key == \'0\' || event.key == \'1\'\n				|| event.key == \'2\' || event.key == \'3\'\n				|| event.key == \'4\' || event.key == \'5\'\n				|| event.key == \'6\' || event.key == \'7\'\n				|| event.key == \'8\' || event.key == \'9\'\n				|| event.key == \'+\' || event.key == \'-\'\n				|| event.key == \'*\' || event.key == \'/\')\n				document.getElementById(\"result\").value += event.key;\n		}\n\n		var cal = document.getElementById(\"calcu\");\n		cal.onkeyup = function (event) {\n			if (event.keyCode === 13) {\n				console.log(\"Enter\");\n				let x = document.getElementById(\"result\").value\n				console.log(x);\n				solve();\n			}\n		}\n\n		// Function that evaluates the digit and return result\n		function solve() {\n			let x = document.getElementById(\"result\").value\n			let y = math.evaluate(x)\n			document.getElementById(\"result\").value = y\n		}\n\n		// Function that clear the display\n		function clr() {\n			document.getElementById(\"result\").value = \"\"\n		}\n	</script>\n</body>\n\n</html>\n'),(18,'dadjoke','<div id=\"text\"></div>\n<script>\n    fetch(\'https://icanhazdadjoke.com/\', {\n            headers: {\n                \'Accept\': \'application/json\'\n            }\n        })\n        .then(res => res.json())\n        .then(data => {\n            document.getElementById(\"text\").innerText = data.joke\n        });\n</script>');

-- Add entries for each widget in the app store
INSERT INTO `appstore` VALUES (15,15,'Hello World','This demonstrates that the backend functionality works.',0,5.0,0),(16,16,'Steve Wilson Appreciation','This is a silly widget.',0,5.0,0),(17,17,'Calculator','Basic HTML calculator',0,5.0,0),(18,18,'Dad Joke','Random dad joke',0,5.0,0);

-- Link the other tables together using integer IDs
INSERT INTO `added` VALUES (1,2,15,5,0),(3,2,16,2,0),(4,2,17,3,0),(5,2,18,4,0),(6,3,16,2,0),(7,3,17,0,0),(8,3,15,0,0),(9,3,18,1,0);

-- Commit transaction
COMMIT;