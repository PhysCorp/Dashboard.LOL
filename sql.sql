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




-- Check if user has the app installed already from appstore
-- SELECT * FROM AppStore WHERE widget_id = (SELECT widget_id FROM Widgets WHERE widget_id = widget_id) AND app_id = (SELECT app_id FROM Added WHERE user_id = 1 AND widget_id = (SELECT widget_id FROM Widgets WHERE internal_name = 'ToDoList'));