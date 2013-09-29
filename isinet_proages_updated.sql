ALTER TABLE `policies` ADD `prima` FLOAT(10,2) AFTER `payment_method_id`;

/**
 *	Table for temporal data
 **/
CREATE TABLE `payments_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Add field product_group_id table policies*/
ALTER TABLE `policies` ADD product_group_id INT NULL AFTER product_id;

/*Add field year_prime table payments*/
ALTER TABLE `payments` ADD `year_prime` INT NOT NULL AFTER `policy_id`;

/*Activity module*/
CREATE TABLE `agents_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `begin` date DEFAULT  NULL,
  `end` date DEFAULT  NULL,
  `cita` int DEFAULT 0 NULL,
  `prospectus` int DEFAULT 0 NULL,
  `interview` int DEFAULT 0 NULL,  
  `comments` text character set utf8 collate utf8_spanish_ci DEFAULT '' NULL,  
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;