ALTER TABLE `policies` ADD `prima` FLOAT(10,2) AFTER `payment_method_id`;

/**
 *	Table for temporal data
 **/
CREATE TABLE `payments_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
