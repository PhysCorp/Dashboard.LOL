-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema dashboard_lol
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dashboard_lol
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dashboard_lol` DEFAULT CHARACTER SET utf8 ;
USE `dashboard_lol` ;

-- -----------------------------------------------------
-- Table `dashboard_lol`.`Users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dashboard_lol`.`Users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(20) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `num_of_columns` TINYINT(4) NOT NULL,
  `user_first_name` VARCHAR(45) NOT NULL,
  `user_last_name` VARCHAR(45) NOT NULL,
  `user_email` VARCHAR(45) NOT NULL,
  `user_phone_num` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC) VISIBLE,
  UNIQUE INDEX `user_name_UNIQUE` (`user_name` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dashboard_lol`.`Widgets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dashboard_lol`.`Widgets` (
  `widget_id` INT NOT NULL AUTO_INCREMENT,
  `internal_name` VARCHAR(45) NOT NULL,
  `data_dump` LONGTEXT NULL,
  PRIMARY KEY (`widget_id`),
  UNIQUE INDEX `widget_id_UNIQUE` (`widget_id` ASC) VISIBLE,
  UNIQUE INDEX `internal_name_UNIQUE` (`internal_name` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dashboard_lol`.`Added`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dashboard_lol`.`Added` (
  `add_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Which widgets the user has added to their dashboard',
  `user_id` INT NOT NULL,
  `widget_id` INT NOT NULL,
  `placed_column` INT NOT NULL,
  `order_in_column` INT NOT NULL,
  PRIMARY KEY (`add_id`),
  INDEX `fk_Added_Users_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_Added_Widgets1_idx` (`widget_id` ASC) VISIBLE,
  UNIQUE INDEX `add_id_UNIQUE` (`add_id` ASC) VISIBLE,
  CONSTRAINT `fk_Added_Users`
    FOREIGN KEY (`user_id`)
    REFERENCES `dashboard_lol`.`Users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Added_Widgets1`
    FOREIGN KEY (`widget_id`)
    REFERENCES `dashboard_lol`.`Widgets` (`widget_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dashboard_lol`.`AppStore`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dashboard_lol`.`AppStore` (
  `app_id` INT NOT NULL AUTO_INCREMENT,
  `widget_id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `description` TEXT(500) NOT NULL,
  `ratings_count` INT NOT NULL,
  `rating` DOUBLE(2,1) NULL,
  `count_users_enabled` INT NULL,
  PRIMARY KEY (`app_id`),
  INDEX `fk_AppStore_Widgets1_idx` (`widget_id` ASC) VISIBLE,
  UNIQUE INDEX `app_id_UNIQUE` (`app_id` ASC) VISIBLE,
  UNIQUE INDEX `widget_id_UNIQUE` (`widget_id` ASC) VISIBLE,
  CONSTRAINT `fk_AppStore_Widgets1`
    FOREIGN KEY (`widget_id`)
    REFERENCES `dashboard_lol`.`Widgets` (`widget_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dashboard_lol`.`IsChartwellsGood`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dashboard_lol`.`IsChartwellsGood` (
  `day_id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `count_yes_votes` INT NOT NULL,
  `count_no_votes` INT NOT NULL,
  PRIMARY KEY (`day_id`),
  UNIQUE INDEX `id_day_UNIQUE` (`day_id` ASC) VISIBLE,
  UNIQUE INDEX `date_UNIQUE` (`date` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dashboard_lol`.`ToDoList`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dashboard_lol`.`ToDoList` (
  `note_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `note_text` TEXT(500) NULL,
  `is_completed` TINYINT NULL,
  PRIMARY KEY (`note_id`),
  UNIQUE INDEX `note_id_UNIQUE` (`note_id` ASC) VISIBLE,
  INDEX `fk_ToDoList_Users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_ToDoList_Users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `dashboard_lol`.`Users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

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