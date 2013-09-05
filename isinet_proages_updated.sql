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