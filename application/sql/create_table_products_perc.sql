CREATE TABLE `products_percentage` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idProducts` INT NULL,
  `allocated_prime` DOUBLE NULL,
  `bonus_prime` DOUBLE NULL,
  `period` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `id_idx` (`idProducts` ASC),
  CONSTRAINT `id`
    FOREIGN KEY (`idProducts`)
    REFERENCES `products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



CREATE TABLE `products_period` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idPerc` VARCHAR(45) NULL,
  `period` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));


ALTER TABLE `policies` 
ADD COLUMN `allocated_prime` DECIMAL(20,2) NULL DEFAULT NULL AFTER `date`,
ADD COLUMN `bonus_prime` DECIMAL(20,2) NULL DEFAULT NULL AFTER `allocated_prime`;

