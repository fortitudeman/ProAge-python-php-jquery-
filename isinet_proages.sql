# Host: localhost  (Version: 5.5.24)
# Date: 2013-06-28 12:05:57
# Generator: MySQL-Front 5.3  (Build 4.4)

/*!40101 SET NAMES utf8 */;

#
# Source for table "actions"
#

DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "actions"
#


#
# Source for table "agencies"
#

DROP TABLE IF EXISTS `agencies`;
CREATE TABLE `agencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `insurance` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `joined_since` date DEFAULT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "agencies"
#


#
# Source for table "agent_uids"
#

DROP TABLE IF EXISTS `agent_uids`;
CREATE TABLE `agent_uids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `type` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `uid` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "agent_uids"
#


#
# Source for table "agents"
#

DROP TABLE IF EXISTS `agents`;
CREATE TABLE `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lastnames` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `birthdate` date DEFAULT NULL,
  `connection_date` date DEFAULT NULL,
  `license_expired_date` date DEFAULT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "agents"
#


#
# Source for table "currencies"
#

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "currencies"
#


#
# Source for table "folder"
#

DROP TABLE IF EXISTS `folder`;
CREATE TABLE `folder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "folder"
#


#
# Source for table "log_types"
#

DROP TABLE IF EXISTS `log_types`;
CREATE TABLE `log_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "log_types"
#


#
# Source for table "logs"
#

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_type_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `user_agent` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `referer` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "logs"
#


#
# Source for table "modules"
#

DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) NOT NULL DEFAULT '',
  `last_updated` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "modules"
#

INSERT INTO `modules` VALUES (2,'Usuarios','',1372286547,1372286547);

#
# Source for table "notification_types"
#

DROP TABLE IF EXISTS `notification_types`;
CREATE TABLE `notification_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "notification_types"
#


#
# Source for table "notifications"
#

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_type_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `subject` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `send` tinyint(4) NOT NULL,
  `unread` tinyint(4) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "notifications"
#


#
# Source for table "offices"
#

DROP TABLE IF EXISTS `offices`;
CREATE TABLE `offices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_id` int(11) NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "offices"
#


#
# Source for table "payment_intervals"
#

DROP TABLE IF EXISTS `payment_intervals`;
CREATE TABLE `payment_intervals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "payment_intervals"
#


#
# Source for table "payment_methods"
#

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "payment_methods"
#


#
# Source for table "payments"
#

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "payments"
#


#
# Source for table "policies"
#

DROP TABLE IF EXISTS `policies`;
CREATE TABLE `policies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `payment_interval_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `uid` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lastname_father` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lastname_mother` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `year_premium` decimal(10,0) DEFAULT NULL,
  `expired_date` datetime DEFAULT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "policies"
#


#
# Source for table "policies_vs_users"
#

DROP TABLE IF EXISTS `policies_vs_users`;
CREATE TABLE `policies_vs_users` (
  `user_id` int(11) NOT NULL,
  `policy_id` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `since` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "policies_vs_users"
#


#
# Source for table "product_group"
#

DROP TABLE IF EXISTS `product_group`;
CREATE TABLE `product_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "product_group"
#


#
# Source for table "products"
#

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_group_id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "products"
#


#
# Source for table "representatives"
#

DROP TABLE IF EXISTS `representatives`;
CREATE TABLE `representatives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lastnames` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `office_phone` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `office_ext` varchar(5) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `movile` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "representatives"
#


#
# Source for table "sources"
#

DROP TABLE IF EXISTS `sources`;
CREATE TABLE `sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "sources"
#


#
# Source for table "user_roles"
#

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "user_roles"
#


#
# Source for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_id` int(11) NOT NULL,
  `office_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `username` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lastname` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `working_since` date NOT NULL,
  `disabled` tinyint(4) NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "users"
#


#
# Source for table "users_role_vs_access"
#

DROP TABLE IF EXISTS `users_role_vs_access`;
CREATE TABLE `users_role_vs_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "users_role_vs_access"
#


#
# Source for table "work_order"
#

DROP TABLE IF EXISTS `work_order`;
CREATE TABLE `work_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_id` int(11) NOT NULL,
  `work_order_type_id` int(11) NOT NULL,
  `work_order_status_id` int(11) NOT NULL,
  `uid` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `comments` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "work_order"
#


#
# Source for table "work_order_history"
#

DROP TABLE IF EXISTS `work_order_history`;
CREATE TABLE `work_order_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `field` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `original` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `new` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "work_order_history"
#


#
# Source for table "work_order_status"
#

DROP TABLE IF EXISTS `work_order_status`;
CREATE TABLE `work_order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "work_order_status"
#


#
# Source for table "work_order_types"
#

DROP TABLE IF EXISTS `work_order_types`;
CREATE TABLE `work_order_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `description` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "work_order_types"
#

