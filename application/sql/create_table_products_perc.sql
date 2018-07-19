CREATE TABLE `proages`.`products_percentage` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idProducts` INT NULL,
  `ubicar` DOUBLE NULL,
  `bono` DOUBLE NULL,
  `period` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `id_idx` (`idProducts` ASC),
  CONSTRAINT `id`
    FOREIGN KEY (`idProducts`)
    REFERENCES `proages`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



CREATE TABLE `proages`.`products_period` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idPerc` VARCHAR(45) NULL,
  `period` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));


ALTER TABLE `proages`.`policies` 
ADD COLUMN `prima_ubicar` DECIMAL(20,2) NULL DEFAULT NULL AFTER `date`,
ADD COLUMN `prima_bono` DECIMAL(20,2) NULL DEFAULT NULL AFTER `prima_ubicar`;

SELECT (15000 * perc.ubicar) as ubicar, (15000 * perc.bono) as bono from products as prod
JOIN products_percentage as perc on prod.id = perc.idProducts
JOIN products_period as period on perc.id = period.idPerc
WHERE prod.id = 1
and period.period = 10
