SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `Lare_HomeAI` ;
CREATE SCHEMA IF NOT EXISTS `Lare_HomeAI` DEFAULT CHARACTER SET utf8 COLLATE utf8_swedish_ci ;
USE `Lare_HomeAI` ;

-- -----------------------------------------------------
-- Table `Lare_HomeAI`.`Session`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Lare_HomeAI`.`Session` ;

CREATE  TABLE IF NOT EXISTS `Lare_HomeAI`.`Session` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `SessionID` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_swedish_ci' NOT NULL ,
  `Data` LONGTEXT CHARACTER SET 'utf8' COLLATE 'utf8_swedish_ci' NOT NULL ,
  `Create` DATETIME NOT NULL ,
  `Expire` DATETIME NOT NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB
AUTO_INCREMENT = 148
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_swedish_ci;


-- -----------------------------------------------------
-- Table `Lare_HomeAI`.`Relay`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Lare_HomeAI`.`Relay` ;

CREATE  TABLE IF NOT EXISTS `Lare_HomeAI`.`Relay` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `Key` INT(1) NOT NULL ,
  `Name` VARCHAR(255) NOT NULL ,
  `Description` TEXT NULL ,
  `Status` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Lare_HomeAI`.`Relay_Timer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Lare_HomeAI`.`Relay_Timer` ;

CREATE  TABLE IF NOT EXISTS `Lare_HomeAI`.`Relay_Timer` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `Relay_ID` INT(10) NOT NULL ,
  `Stamp` DATETIME NOT NULL ,
  `Status` TINYINT(1) NOT NULL ,
  `Source` INT(1) NOT NULL ,
  PRIMARY KEY (`ID`) ,
  CONSTRAINT `fk_Relay_Timer_Relay`
    FOREIGN KEY (`Relay_ID` )
    REFERENCES `Lare_HomeAI`.`Relay` (`ID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_Relay_ID` ON `Lare_HomeAI`.`Relay_Timer` (`Relay_ID` ASC) ;


-- -----------------------------------------------------
-- Table `Lare_HomeAI`.`History_Relay_Status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Lare_HomeAI`.`History_Relay_Status` ;

CREATE  TABLE IF NOT EXISTS `Lare_HomeAI`.`History_Relay_Status` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `Relay_ID` INT(10) NOT NULL ,
  `Stamp` DATETIME NOT NULL ,
  `Status` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`ID`) ,
  CONSTRAINT `fk_History_Relay_Status_Relay1`
    FOREIGN KEY (`Relay_ID` )
    REFERENCES `Lare_HomeAI`.`Relay` (`ID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_Relay_ID` ON `Lare_HomeAI`.`History_Relay_Status` (`Relay_ID` ASC) ;


-- -----------------------------------------------------
-- Table `Lare_HomeAI`.`Event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Lare_HomeAI`.`Event` ;

CREATE  TABLE IF NOT EXISTS `Lare_HomeAI`.`Event` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `Title` VARCHAR(255) NOT NULL ,
  `Description` TEXT NULL ,
  `Date` DATE NOT NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB;

USE `Lare_HomeAI`;

DELIMITER $$

USE `Lare_HomeAI`$$
DROP TRIGGER IF EXISTS `Lare_HomeAI`.`relayInsert` $$
USE `Lare_HomeAI`$$
CREATE TRIGGER `relayInsert` AFTER INSERT on `Relay`
FOR EACH ROW
BEGIN
END$$


USE `Lare_HomeAI`$$
DROP TRIGGER IF EXISTS `Lare_HomeAI`.`relayUpdate` $$
USE `Lare_HomeAI`$$


CREATE TRIGGER `relayUpdate` AFTER UPDATE on `Relay`
FOR EACH ROW
BEGIN
    IF (NEW.Status != OLD.Status) THEN
        INSERT INTO History_Relay_Status
            (`Relay_ID`, `Status`, `Stamp`)
        VALUES
            (NEW.ID, NEW.Status, NOW());
    END IF;
END$$


DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
