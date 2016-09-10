SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema fwrsfarmacias
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fwrsfarmacias` DEFAULT CHARACTER SET utf8 ;
USE `fwrsfarmacias` ;

-- -----------------------------------------------------
-- Table `fwrsfarmacias`.`cidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fwrsfarmacias`.`cidade` (
  `id_cidade` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `uf` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`id_cidade`),
  UNIQUE INDEX `id_cidade_UNIQUE` (`id_cidade` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fwrsfarmacias`.`farmacias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fwrsfarmacias`.`farmacias` (
  `id_farmacias` INT NOT NULL AUTO_INCREMENT,
  `farmacia` VARCHAR(70) NOT NULL,
  `endereco` VARCHAR(255) NOT NULL,
  `latitude` VARCHAR(45) NOT NULL,
  `longitude` VARCHAR(45) NOT NULL,
  `teleentrega` TINYINT NULL DEFAULT 0,
  `farmaciapopular` TINYINT NULL DEFAULT 0,
  `manipulacao` TINYINT NULL DEFAULT 0,
  `aceitacartao` TINYINT NULL DEFAULT 0,
  `id_cidade` INT NOT NULL,
  PRIMARY KEY (`id_farmacias`),
  UNIQUE INDEX `id_farmacias_UNIQUE` (`id_farmacias` ASC),
  INDEX `fk_cidade_idx` (`id_cidade` ASC),
  CONSTRAINT `fk_cidade`
    FOREIGN KEY (`id_cidade`)
    REFERENCES `fwrsfarmacias`.`cidade` (`id_cidade`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fwrsfarmacias`.`telefone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fwrsfarmacias`.`telefone` (
  `id_telefone` INT NOT NULL AUTO_INCREMENT,
  `ddd` VARCHAR(2) NOT NULL DEFAULT '55',
  `telefone` VARCHAR(15) NOT NULL,
  `complemento` VARCHAR(45) NULL,
  `id_farmacias` INT NOT NULL,
  PRIMARY KEY (`id_telefone`),
  UNIQUE INDEX `id_UNIQUE` (`id_telefone` ASC),
  INDEX `fk_farm_idx` (`id_farmacias` ASC),
  CONSTRAINT `fk_farm`
    FOREIGN KEY (`id_farmacias`)
    REFERENCES `fwrsfarmacias`.`farmacias` (`id_farmacias`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fwrsfarmacias`.`funcionamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fwrsfarmacias`.`funcionamento` (
  `id_funcionamento` INT NOT NULL AUTO_INCREMENT,
  `id_farmacias` INT NOT NULL,
  `diasemana` TINYINT NOT NULL COMMENT '0 (para domingo) até 6 (para sábado)',
  `abertura` VARCHAR(4) NOT NULL DEFAULT '0000',
  `fechamento` VARCHAR(4) NOT NULL DEFAULT '0000',
  PRIMARY KEY (`id_funcionamento`),
  UNIQUE INDEX `id_funcionamento_UNIQUE` (`id_funcionamento` ASC),
  INDEX `fk_hora_idx` (`id_farmacias` ASC),
  CONSTRAINT `fk_hora`
    FOREIGN KEY (`id_farmacias`)
    REFERENCES `fwrsfarmacias`.`farmacias` (`id_farmacias`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
