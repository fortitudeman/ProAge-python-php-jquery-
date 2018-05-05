-- get generation of agent Vida
SELECT 
  DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0
  AS generation FROM agents where user_id = some_id;

-- get generation of agent GMM
SELECT (TIMESTAMPDIFF(MONTH, '2018-04-02', NOW()) - 4) div 12
-- update generation of agent vida
UPDATE `agents`
SET    generation_vida = (case when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) <= 1 then 'Generación 1' 
						  when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) = 2 then 'Generación 2'
						  when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) = 3 then 'Generación 3'
						  when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) = 4 then 'Generación 4'
						  when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) >= 5 then 'Consolidado'
						  end);

-- update generation of agent GMM
UPDATE `agents`
SET    generation_gmm = (case when (TIMESTAMPDIFF(MONTH, connection_date, NOW()) - 4) div 12 <= 1 then 'Generación 1' 
						  when (TIMESTAMPDIFF(MONTH, connection_date, NOW()) - 4) div 12 = 2 then 'Generación 2'
						  when (TIMESTAMPDIFF(MONTH, connection_date, NOW()) - 4) div 12 = 3 then 'Generación 3'
						  when (TIMESTAMPDIFF(MONTH, connection_date, NOW()) - 4) div 12 = 4 then 'Generación 4'
						  when (TIMESTAMPDIFF(MONTH, connection_date, NOW()) - 4) div 12 >= 5 then 'Consolidado'
						  end);

-- event Schendule Vida
DELIMITER $$

CREATE EVENT updateGenerationsAgentsVida
ON SCHEDULE
    EVERY 1 MINUTE
    STARTS '2018-04-05 12:00:00'
    ON COMPLETION PRESERVE
DO
BEGIN
    DECLARE rightnow DATETIME;
    DECLARE rightMonth,hh,mm TINYINT;

    SET rightnow = NOW();
    SET hh = HOUR(rightnow);
    SET rightMonth = month(NOW());
    SET mm = MINUTE(rightnow);

    IF (DATE(rightnow) = LAST_DAY(DATE(rightnow)) AND rightMonth = 3 ) 
    	OR (DATE(rightnow) = LAST_DAY(DATE(rightnow)) AND rightMonth = 6 ) 
    	OR (DATE(rightnow) = LAST_DAY(DATE(rightnow)) AND rightMonth = 9 ) 
    	OR (DATE(rightnow) = LAST_DAY(DATE(rightnow)) AND rightMonth = 12 ) THEN
        IF hh = 23 THEN
            IF mm = 50 THEN
                	UPDATE `agents`
					SET    generation_vida = (case when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) <= 1 then 1 
							  				       when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) = 2 then 2
							  				       when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) = 3 then 3
							  			           when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) = 4 then 4
							  			           when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) >= 5 then 5
							  			           end)
            END IF;
        END IF;
    END IF;

END $$

DELIMITER ;

-- event Schendule GMM
DELIMITER $$

CREATE EVENT updateGenerationsAgentsGMM
ON SCHEDULE
    EVERY 1 MINUTE
    STARTS '2018-04-05 12:00:00'
    ON COMPLETION PRESERVE
DO
BEGIN
    DECLARE rightnow DATETIME;
    DECLARE rightMonth,hh,mm TINYINT;

    SET rightnow = NOW();
    SET hh = HOUR(rightnow);
    SET rightMonth = month(NOW());
    SET mm = MINUTE(rightnow);

    IF (DATE(rightnow) = LAST_DAY(DATE(rightnow)) AND rightMonth = 4 ) 
    	OR (DATE(rightnow) = LAST_DAY(DATE(rightnow)) AND rightMonth = 8 ) 
    	OR (DATE(rightnow) = LAST_DAY(DATE(rightnow)) AND rightMonth = 12 ) THEN
        IF hh = 23 THEN
            IF mm = 50 THEN
                	UPDATE `agents`
					SET    generation_gmm = (case when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) <= 1 then 1 
							  				       when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) = 2 then 2
							  				       when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) = 3 then 3
							  			           when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) = 4 then 4
							  			           when (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(connection_date)), '%Y')+0) >= 5 then 5
							  			           end);
            END IF;
        END IF;
    END IF;

END $$

DELIMITER ;
							  
-- Down events			  
DROP EVENT updateGenerationsAgentsGMM;
DROP EVENT updateGenerationsAgentsVida;

-- Alter statement 
ALTER TABLE `proages`.`agents` 
ADD COLUMN `generation_gmm` INT(11) NULL AFTER `generation_vida`,
ADD COLUMN `generation_vida` INT(11) NULL AFTER `generation_gmm`;
