﻿# Host: localhost  (Version: 5.5.24)
# Date: 2013-07-26 15:01:55
# Generator: MySQL-Front 5.3  (Build 4.4)

/*!40101 SET NAMES utf8 */;

#
# Source for table "actions"
#

CREATE TABLE `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

#
# Data for table "actions"
#

INSERT INTO `actions` VALUES (1,'Ver','','2013-07-15 14:27:28','2013-07-15 14:27:28'),(2,'Crear','','2013-07-15 14:27:28','2013-07-15 14:27:28'),(3,'Editar','','2013-07-15 14:27:28','2013-07-15 14:27:28'),(4,'Activar/Desactivar','','2013-07-15 14:27:28','2013-07-15 14:27:28'),(5,'Export xls','','2013-07-15 14:27:28','2013-07-15 14:27:28'),(6,'Import xls','','2013-07-15 14:27:28','2013-07-15 14:27:28'),(7,'Export pdf','','2013-07-15 14:27:28','2013-07-15 14:27:28'),(8,'Cambiar estatus','','2013-07-15 14:27:28','2013-07-15 14:27:28'),(9,'Importar payments','','2013-07-15 14:27:28','2013-07-15 14:27:28'),(10,'Ver reporte','','2013-07-15 14:27:28','2013-07-15 14:27:28'),(11,'Petición nuevo usuario','','2013-07-15 14:39:53','2013-07-15 14:39:53'),(12,'Eliminar','','2013-07-20 13:53:58','2013-07-20 13:53:58'),(13,'Enviar correo','','2013-07-20 13:53:58','2013-07-20 13:53:58');

#
# Source for table "agencies"
#

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

CREATE TABLE `agent_uids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `type` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `uid` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "agent_uids"
#

INSERT INTO `agent_uids` VALUES (1,1,'clave','','2013-07-24 21:23:33','2013-07-24 21:23:33'),(2,1,'national','','2013-07-24 21:23:33','2013-07-24 21:23:33'),(3,1,'provincial','','2013-07-24 21:23:33','2013-07-24 21:23:33'),(4,2,'clave','','2013-07-24 21:24:50','2013-07-24 21:24:50'),(5,2,'national','','2013-07-24 21:24:50','2013-07-24 21:24:50'),(6,2,'provincial','','2013-07-24 21:24:50','2013-07-24 21:24:50');

#
# Source for table "agents"
#

CREATE TABLE `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `connection_date` date DEFAULT NULL,
  `license_expired_date` date DEFAULT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "agents"
#

INSERT INTO `agents` VALUES (1,7,'2013-07-24','2013-07-24','2013-07-24 21:23:33','2013-07-24 21:23:33'),(2,8,'2013-07-24','2013-07-24','2013-07-24 21:24:50','2013-07-24 21:24:50');

#
# Source for table "currencies"
#

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "currencies"
#

INSERT INTO `currencies` VALUES (1,'Moneda Nacional','','2013-07-24 16:01:43','2013-07-24 16:01:43'),(2,'Dolares Americanos','','2013-07-24 16:01:43','2013-07-24 16:01:43');

#
# Source for table "folder"
#

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

CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) NOT NULL DEFAULT '',
  `last_updated` date DEFAULT '0000-00-00',
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "modules"
#

INSERT INTO `modules` VALUES (2,'Usuarios','','2013-07-15',1372286547),(3,'Modulos','','2013-07-15',1373913971),(4,'Rol','','2013-07-15',1373913981),(5,'Orden de trabajo','','2013-07-15',1373914004);

#
# Source for table "notification_types"
#

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

CREATE TABLE `payment_intervals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "payment_intervals"
#

INSERT INTO `payment_intervals` VALUES (1,'Mensual','','2013-07-24 16:03:12','2013-07-24 16:03:12'),(2,'Trimestral','','2013-07-24 16:03:12','2013-07-24 16:03:12'),(3,'Semestral','','2013-07-24 16:03:12','2013-07-24 16:03:12'),(4,'Anual','','2013-07-24 16:03:12','2013-07-24 16:03:12');

#
# Source for table "payment_methods"
#

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "payment_methods"
#

INSERT INTO `payment_methods` VALUES (1,'Oficina de servicio','','2013-07-24 16:06:18','2013-07-24 16:06:18'),(2,'Cargo automático a tarjeta de credito','','2013-07-24 16:06:36','2013-07-24 16:06:36'),(3,'Cargo unico a tarjeta de Credito','','2013-07-24 16:06:36','2013-07-24 16:06:36'),(4,'Cargo a chequeras o tarjeta de debito','','2013-07-24 16:06:36','2013-07-24 16:06:36'),(5,'Pago en sucursal bancaria o por Internet','','2013-07-24 16:06:36','2013-07-24 16:06:36');

#
# Source for table "payments"
#

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
# Source for table "platforms"
#

CREATE TABLE `platforms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "platforms"
#

INSERT INTO `platforms` VALUES (1,'tradicional','traditional',NULL,NULL),(2,'universal','universal',NULL,NULL);

#
# Source for table "policies"
#

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "policies"
#

INSERT INTO `policies` VALUES (1,2,1,1,1,'0','Hector','Jimenez','Peres',0,'0000-00-00 00:00:00','2013-07-25 05:24:25','2013-07-25 05:24:25');

#
# Source for table "policies_vs_users"
#

CREATE TABLE `policies_vs_users` (
  `user_id` int(11) NOT NULL,
  `policy_id` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `since` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "policies_vs_users"
#

INSERT INTO `policies_vs_users` VALUES (1,1,20,'2013-07-25 05:24:25');

#
# Source for table "product_group"
#

CREATE TABLE `product_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "product_group"
#

INSERT INTO `product_group` VALUES (1,'Vida','2013-07-22 01:20:34','2013-07-22 01:20:34'),(2,'GIMM','2013-07-22 01:20:35','2013-07-22 01:20:35'),(3,'Auto','2013-07-22 01:20:35','2013-07-22 01:20:35');

#
# Source for table "products"
#

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) DEFAULT NULL,
  `product_group_id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `period` varchar(20) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

#
# Data for table "products"
#

INSERT INTO `products` VALUES (1,1,1,'PROFESIONAL','7-18',1,'2013-07-23 12:54:01','2013-07-23 12:54:01'),(2,1,1,'VIDA A TUS SUEÑOS','7-9',1,'2013-07-23 12:54:01','2013-07-23 12:54:01'),(3,1,1,'TRASCIENDE','5,10,15,20,EA65',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(4,1,1,'DOTAL','10,15,20',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(5,2,1,'VIDA INVERSIÓN','EA65,VITALICIO',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(6,2,1,'CONSOLIDA','EA65',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(7,2,1,'CONSOLIDA TOTAL','EA65',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(8,1,1,'PROYECTA AFECTO','10,EA55,60,65',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(9,1,1,'PROYECTA','EA55,60,65',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(10,2,1,'PRIVILEGIO UNIVERSAL','EA95',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(11,1,1,'PRIVILEGIO TEMPORAL','10,20',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(12,1,1,'PLATINO TEMPORAL','10,20,EA65',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(13,1,1,'PLATINO UNIVERSAL','EA95',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(14,1,1,'ORDINARIO DE VIDA','EA100',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(15,2,1,'VISION PLUS','20,EA65',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(16,2,1,'ELIGE','20,EA65',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(17,1,2,'Internacional','',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(18,1,2,'Vínculo Mundial','',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(19,1,2,'Premier 100','',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(20,1,2,'Premier 200','',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(21,1,2,'Premier 300','',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(22,1,2,'Premier 400','',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(23,1,2,'Conexión (cien mil)','',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(24,1,2,'VIP','',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(25,1,2,'Conexión (sin limite)','',1,'2013-07-23 12:54:02','2013-07-23 12:54:02'),(26,1,3,'Seguro de Auto','',1,'2013-07-23 12:54:02','2013-07-23 12:54:02');

#
# Source for table "products_vs_currencies"
#

CREATE TABLE `products_vs_currencies` (
  `product_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "products_vs_currencies"
#


#
# Source for table "representatives"
#

CREATE TABLE `representatives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lastnames` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `office_phone` varchar(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `office_ext` varchar(5) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `mobile` varchar(13) NOT NULL,
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

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `label` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "user_roles"
#

INSERT INTO `user_roles` VALUES (1,'Agente','',1372810673,1372810673),(2,'Coordinador','',1372810735,1372810735),(3,'Gerente','',1372810751,1372810751),(4,'Director','',1372810758,1372810758),(5,'Administrador','',1372810768,1372810768);

#
# Source for table "user_roles_vs_access"
#

CREATE TABLE `user_roles_vs_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

#
# Data for table "user_roles_vs_access"
#

INSERT INTO `user_roles_vs_access` VALUES (8,4,2,1,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(9,4,2,5,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(10,4,2,11,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(11,3,2,1,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(12,3,2,5,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(13,3,2,11,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(53,1,2,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(54,1,2,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(55,1,2,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(83,5,2,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(84,5,2,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(85,5,2,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(86,5,2,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(87,5,2,5,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(88,5,2,6,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(89,5,2,7,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(90,5,2,8,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(91,5,2,9,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(92,5,2,10,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(93,5,2,11,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(94,5,2,12,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(95,5,2,13,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(96,5,3,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(97,5,3,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(98,5,3,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(99,5,4,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(100,5,4,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(101,5,4,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(102,5,5,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(103,5,5,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(104,5,5,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(105,5,5,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(106,5,5,5,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(107,5,5,6,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(108,5,5,7,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(109,5,5,8,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(110,5,5,9,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(111,5,5,10,'0000-00-00 00:00:00','0000-00-00 00:00:00');

#
# Source for table "users"
#

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `office_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `company_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `username` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastnames` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `disabled` tinyint(4) NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (5,0,0,'SOS','administrador','827ccb0eea8a706c4c34a16891f84e7b','Administrador','Admin','1994-07-05','administrador@gmail.com','default.png',1,'2013-07-21 07:05:33','2013-07-21 02:05:33'),(6,0,0,'SOS','admin','827ccb0eea8a706c4c34a16891f84e7b','Ulises','Rodriguez','2013-07-19','admin@gmail.com','2w53xh2.jpg',0,'2013-07-21 07:07:31','2013-07-21 02:07:31'),(7,0,0,'SOS','agente','827ccb0eea8a706c4c34a16891f84e7b','Ulises','Rodriguez','2013-07-24','agente@gmail.com','default.png',1,'2013-07-24 21:23:33','2013-07-24 21:23:33'),(8,0,0,'SOS','agente2','827ccb0eea8a706c4c34a16891f84e7b','Hector','Jimenez','2013-07-24','agent2@gmail.com','default.png',1,'2013-07-24 21:24:50','2013-07-24 21:24:50');

#
# Source for table "users_vs_user_roles"
#

CREATE TABLE `users_vs_user_roles` (
  `user_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "users_vs_user_roles"
#

INSERT INTO `users_vs_user_roles` VALUES (5,5),(6,5),(7,1),(8,1);

#
# Source for table "work_order"
#

CREATE TABLE `work_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_id` int(11) NOT NULL,
  `product_group_id` int(11) NOT NULL,
  `work_order_type_id` int(11) NOT NULL,
  `work_order_status_id` int(11) NOT NULL,
  `work_order_reason_id` int(11) NOT NULL,
  `work_order_responsible_id` int(11) NOT NULL,
  `uid` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `comments` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "work_order"
#

INSERT INTO `work_order` VALUES (1,1,2,62,2,1,1,'0','2013-06-05 14:52:47','COMENTARIOS',0,'2013-07-26 20:23:00','2013-07-26 15:00:23');

#
# Source for table "work_order_history"
#

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
# Source for table "work_order_reason"
#

CREATE TABLE `work_order_reason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

#
# Data for table "work_order_reason"
#

INSERT INTO `work_order_reason` VALUES (1,'INFORMACION MEDICA ADICIONAL Y/O LABORAL','2013-07-25 11:56:30','2013-07-25 11:56:30'),(2,'SOLICITUD INCOMPLETA','2013-07-25 11:56:30','2013-07-25 11:56:30'),(3,'A PETICION','2013-07-25 11:56:30','2013-07-25 11:56:30'),(4,'EXCEDE TIEMPO DE ESPERA ','2013-07-25 11:56:30','2013-07-25 11:56:30'),(5,'SUSTITUCION X OTRA OT','2013-07-25 11:56:30','2013-07-25 11:56:30'),(6,'NO ACEPTA EL RIESGO','2013-07-25 11:56:30','2013-07-25 11:56:30'),(7,'SOLICITUD INCOMPLETA','2013-07-25 11:56:30','2013-07-25 11:56:30'),(8,'NO ACEPTA EL RIESGO','2013-07-25 11:56:30','2013-07-25 11:56:30'),(9,'SOLICITUD INCOMPLETA','2013-07-25 11:56:30','2013-07-25 11:56:30'),(10,'A PETICION','2013-07-25 11:56:30','2013-07-25 11:56:30'),(11,'EXCEDE TIEMPO DE ESPERA','2013-07-25 11:56:30','2013-07-25 11:56:30'),(12,'SUSTITUCION X OTRA OT','2013-07-25 11:56:30','2013-07-25 11:56:30');

#
# Source for table "work_order_responsibles"
#

CREATE TABLE `work_order_responsibles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "work_order_responsibles"
#

INSERT INTO `work_order_responsibles` VALUES (1,'Agente','2013-07-25 11:52:07','2013-07-25 11:52:07'),(2,'Operaciones','2013-07-25 11:52:07','2013-07-25 11:52:07'),(3,'GNP','2013-07-25 11:52:07','2013-07-25 11:52:07');

#
# Source for table "work_order_status"
#

CREATE TABLE `work_order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "work_order_status"
#

INSERT INTO `work_order_status` VALUES (1,'activacion','2013-07-25 10:44:12','2013-07-25 10:44:12'),(2,'cancelada','2013-07-25 10:44:12','2013-07-25 10:44:12'),(3,'excedido','2013-07-25 10:44:12','2013-07-25 10:44:12'),(4,'pagada','2013-07-25 10:44:12','2013-07-25 10:44:12'),(5,'tramite','2013-07-25 10:44:12','2013-07-25 10:44:12');

#
# Source for table "work_order_types"
#

CREATE TABLE `work_order_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patent_id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `description` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;

#
# Data for table "work_order_types"
#

INSERT INTO `work_order_types` VALUES (1,1,'MOVIMIENTO   A POLIZA','',0,'2013-07-22 01:43:00','2013-07-22 02:14:47'),(2,1,'MOVIMIENTO   A POLIZA CORRECCION FECHA NACIMI','',7,'2013-07-22 01:52:22','2013-07-22 02:06:26'),(3,1,'ALTA, RECONSIDERACION Y CANCELACION DE EXTRAP','',3,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(4,1,'CORRECCION FECHA NACIMIENTO ALTERANDO EDAD','',3,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(5,1,'CAMBIO DE COBERTURA','',3,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(6,1,'CAMBIO CONDUCTO DE COBRO','',3,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(7,1,'CAMBIO CONTRATANTE','',9,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(8,1,'CAMBIO DIRECCION','',9,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(9,1,'CAMBIO FORMA DE PAGO','',3,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(10,1,'CAMBIO OPCION DE LIQUIDACION SUMA ASEGURADA','',7,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(11,1,'CAMBIO TELEFONO, FAX,CORREO ELECTRONICO','',3,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(12,1,'CAMBIO Y CORRECCION BENEFICARIOS','',7,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(13,1,'CAMBIO FIDEICOMISO','',2,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(14,1,'CANCELACION DE BENEFICIOS ADICIONALES','',7,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(15,1,'CONSTANCIA RETENCIO  DE IMPUESTOS','',9,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(16,1,'CORRECCION DE RFC','',3,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(17,1,'CORRECCION DEL NOMBRE DEL ASEGURADO','',2,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(18,1,'DEVOLUCION DE PRIMAS','',7,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(19,1,'DISMINUCION DE S.A.','',7,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(20,1,'INCLUSION DE BENEFICOS ADICIONALES','',9,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(21,1,'PAGO DE PRIMA COMPLEMENTANDO CON FONDO DE INV','',9,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(22,1,'PAGO PRIMA OTRO RAMO','',2,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(23,1,'PAGO PRIMANUEVO NEGOCIO CON FONDO DE INVERSIO','',7,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(24,1,'PAGO PRIMA RENOVACION CON FONDO INVERSION','',12,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(25,1,'REEXPEDICIONES BASICAS','',7,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(26,1,'REEXPEDICION CON MANTENIMIENTO','',9,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(27,1,'REHABILITACION CON CAMBIOS','',12,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(28,1,'REHABILITACION SIN CAMBIOS','',7,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(29,1,'REVALORACION APLICACION EXTRAPRIMA','',12,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(30,1,'DES-PRORROGAR POLIZA','',12,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(31,1,'PRORROGAR POLIZA','',7,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(32,1,'CESION DE COMISION','',7,'2013-07-22 01:52:22','2013-07-22 01:52:22'),(33,1,'MOVIMIENTO FINANCIERO','',0,'2013-07-22 01:55:01','2013-07-22 02:07:31'),(34,33,'MOVIMIENTO FINANCIERO\tACTUALIZACION DATOS BAN','',9,'2013-07-22 01:58:07','2013-07-22 02:01:26'),(35,33,'AHORRO PROGRAMADO EN EL CONDCUTO DE COBRO CAT','',7,'2013-07-22 01:58:07','2013-07-22 02:01:28'),(36,33,'AHORRO PROGRAMADO EN EL CONDCUTO DE COBRO DOM','',7,'2013-07-22 01:58:07','2013-07-22 02:01:30'),(37,33,'ALTA CONDUCTO DE COBRO ELECTRONICO','',7,'2013-07-22 01:58:07','2013-07-22 02:01:34'),(38,33,'CAMBIO DE CLABE','',7,'2013-07-22 01:58:07','2013-07-22 02:01:37'),(39,33,'CAMBIO TARJETA','',3,'2013-07-22 01:58:07','2013-07-22 02:01:41'),(40,33,'REACTIVACION COBRO ELECTRONICO','',7,'2013-07-22 01:58:07','2013-07-22 02:01:44'),(41,33,'RESCATE DE VALORES GARANTIZADOS','',7,'2013-07-22 01:58:07','2013-07-22 02:01:47'),(42,33,'RETIRO','',7,'2013-07-22 01:58:07','2013-07-22 02:01:50'),(43,33,'RETIRODE FONDO DE INVERSION','',7,'2013-07-22 01:58:07','2013-07-22 02:01:53'),(44,33,'PRESTAMO PARA PAGO DE PRIMA','',9,'2013-07-22 01:58:07','2013-07-22 02:01:56'),(45,33,'PRESTAMO PARA CHEQUE','',9,'2013-07-22 01:58:07','2013-07-22 02:02:02'),(46,33,'PRESTAMO POR MEDIO DE TRASFERENCIA BANCARIA','',9,'2013-07-22 01:58:07','2013-07-22 02:02:04'),(47,1,'NUEVO NEGOCIO','',0,'2013-07-22 01:58:24','2013-07-22 12:11:47'),(48,47,'RANGO   A','',5,'2013-07-22 01:59:34','2013-07-22 02:02:13'),(49,47,'RANGO   C','',8,'2013-07-22 01:59:34','2013-07-22 02:02:15'),(50,47,'RANGO   E','',10,'2013-07-22 01:59:34','2013-07-22 02:02:16'),(51,47,'RANGO   F','',10,'2013-07-22 01:59:34','2013-07-22 02:02:18'),(52,1,'ACTIVACION','',0,'2013-07-22 02:00:11','2013-07-22 12:12:11'),(54,52,'INFORMACION MEDICA ADICIONAL Y/O LABORAL','',0,'2013-07-22 02:03:07','2013-07-22 02:03:07'),(55,52,'SOLICITUD INCOMPLETA','',0,'2013-07-22 02:03:07','2013-07-22 02:03:07'),(56,1,'CANCELACIONES  ','',0,'2013-07-22 02:03:20','2013-07-22 12:12:13'),(57,56,'PETICION','',0,'2013-07-22 02:03:59','2013-07-22 02:03:59'),(58,56,'EXCEDE TIEMPO DE ESPERA','',0,'2013-07-22 02:03:59','2013-07-22 02:03:59'),(59,56,'SUSTITUCION X OTRA OT','',0,'2013-07-22 02:03:59','2013-07-22 02:03:59'),(60,2,'MOVIMIENTO   A POLIZA  ','',0,'2013-07-22 02:09:00','2013-07-22 02:09:00'),(61,60,'MOVIMIENTO   A POLIZA\tALTA ASEGURADO','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(62,60,'ALTA RECIEN NACIDO','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(63,60,'ALTA RECONSIDERACION  DE EXTRAPRIMA','',7,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(64,60,'BAJA ASEGURADO','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(65,60,'BAJA CLAUSULA','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(66,60,'CAMBIO COBERTURA','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(67,60,'CAMBIO CONDUCTO COBRO','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(68,60,'CAMBIO CONTRATANTE PERSONA MORAL','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(69,60,'CAMBIO DIRECCION','',3,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(70,60,'CAMBIO FORMA PAGO MAYOR A MENOR','',7,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(71,60,'CAMBIO DE SUSTITUCION DE RIESGO ASEGURADO','',7,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(72,60,'CAMBIO TELEFONO, FAX,CORREO ELECTRONICO','',3,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(73,60,'CANCELACION DE POLIZA A PETICION','',1,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(74,60,'CORRECCION FECHA NACIMIENTO','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(75,60,'CORRECCION FECHA NACIMIENTO ALTERANDO EDAD','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(76,60,'CORRECCION DE RFC','',3,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(77,60,'CORRECCION DEL NOMBRE DEL ASEGURADO','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(78,60,'INCLUSION DE INTERMEDIARIO ADICIONAL','',7,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(79,60,'INCLUSION, CAMBIO CORRECCION DE BENEFICIARIOS','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(80,60,'MODIFICACION DE  CLAVE DE SEXO ASEGURADOS','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(81,60,'MODIFICAICON DE CONDICIONES','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(82,60,'MODIFICACION FECHA DE ANTIGÜEDAD DE GNP','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(83,60,'MODIFICACION PERIODOS DE ESPERA','',7,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(84,60,'REHABILITACION -A PETICION ASEGURADO','',10,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(85,60,'CON CAMBIO GRUPO A INDIVIDUAL','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(86,60,'CONVERSION DE CONEXIÓN A INDIVUDUAL','',9,'2013-07-22 02:14:12','2013-07-22 02:14:12'),(87,2,'MOVIMIENTO FINANCIERO','',0,'2013-07-22 02:14:38','2013-07-22 02:14:38'),(88,87,'CAMBIO CUENTA BANCARIA','',3,'2013-07-22 02:15:45','2013-07-22 02:15:45'),(89,87,'MODIFICACION DATOS BANCARIOS','',3,'2013-07-22 02:15:45','2013-07-22 02:15:45'),(90,2,'NUEVO NEGOCIO','',0,'2013-07-22 02:16:01','2013-07-22 02:16:01'),(91,90,'SIN CONSIDERAR ESPECIALES','',7,'2013-07-22 02:17:17','2013-07-22 02:17:17'),(92,90,'CON ELIMINACION PERIODOS ESPERA','',9,'2013-07-22 02:17:17','2013-07-22 02:17:17'),(93,90,'INFORMACION MEDICA ADICIONAL Y/O LABORAL','',0,'2013-07-22 02:17:17','2013-07-22 02:17:17'),(94,90,'SOLICITUD INCOMPLETA','',0,'2013-07-22 02:17:17','2013-07-22 02:17:17'),(95,2,'CANCELACIONES  OTS','',0,'2013-07-22 02:17:29','2013-07-22 02:17:29'),(96,95,' A PETICION','',0,'2013-07-22 02:18:26','2013-07-22 02:18:26'),(97,95,'EXCEDE TIEMPO DE ESPERA ','',0,'2013-07-22 02:18:26','2013-07-22 02:18:26'),(98,95,'SUSTITUCION X OTRA OT','',0,'2013-07-22 02:18:26','2013-07-22 02:18:26'),(99,3,'MOVIMIENTO A LA POLIZA','',0,'2013-07-22 02:19:31','2013-07-22 02:19:31'),(100,99,'Cambios de Forma de Pago (con Recibos Pagados','',3,'2013-07-22 02:21:14','2013-07-22 02:21:14'),(101,99,'Cambios de Coberturas (Disminución de Paquete','',3,'2013-07-22 02:21:14','2013-07-22 02:21:14'),(102,99,'Modificación de Clave de Marca y/o Modelo','',3,'2013-07-22 02:21:14','2013-07-22 02:21:14'),(103,99,'Cambio de Contratante  y modificación de dato','',3,'2013-07-22 02:21:14','2013-07-22 02:21:14'),(104,99,'Cambio de Contratante y Modicación de datos d','',3,'2013-07-22 02:21:14','2013-07-22 02:21:14'),(105,99,'Modificación del Número de Serie','',3,'2013-07-22 02:21:14','2013-07-22 02:21:14'),(106,99,'Cancelación de Póliza a Petición','',3,'2013-07-22 02:21:14','2013-07-22 02:21:14'),(107,99,'Cancelaciones por Pérdida Total','',3,'2013-07-22 02:21:14','2013-07-22 02:21:14'),(108,99,'Disminución de Sumas Aseguradas','',3,'2013-07-22 02:21:14','2013-07-22 02:21:14'),(109,3,'COTIZACION  Y EMISION  DE  VEHICULOS','',0,'2013-07-22 02:21:31','2013-07-22 02:21:31'),(110,109,'Vehículos Residentes con valor comercial mayo','',5,'2013-07-22 02:22:45','2013-07-22 02:22:45'),(111,109,'Vehículos Residentes último modelo a valor fa','',5,'2013-07-22 02:22:45','2013-07-22 02:22:45'),(112,109,'Vehículos Residentes para vehículos en Jalisc','',5,'2013-07-22 02:22:45','2013-07-22 02:22:45'),(113,109,'Vehículos Importados, Antiguos,  Clásicos y B','',5,'2013-07-22 02:22:45','2013-07-22 02:22:45'),(114,109,'Vehículos Nuevos sin tarifa','',5,'2013-07-22 02:22:45','2013-07-22 02:22:45'),(115,3,'FINANCIEROS','',0,'2013-07-22 02:23:07','2013-07-22 02:23:07'),(116,115,'CAMBIO TC  O DOMICILIACION','',3,'2013-07-22 02:23:30','2013-07-22 02:23:30'),(117,3,'ACTIVACION OTS','',0,'2013-07-22 02:23:50','2013-07-22 02:23:50'),(118,117,'NO ACEPTA EL RIESGO','',0,'2013-07-22 02:24:18','2013-07-22 02:24:18'),(119,117,'SOLICITUD INCOMPLETA','',0,'2013-07-22 02:24:18','2013-07-22 02:24:18'),(120,3,'CANCELACIONES  OTS','',0,'2013-07-22 02:24:27','2013-07-22 02:24:27'),(121,120,'A PETICION','',0,'2013-07-22 02:25:05','2013-07-22 02:25:05'),(122,120,'EXCEDE TIEMPO DE ESPERA ','',0,'2013-07-22 02:25:05','2013-07-22 02:25:05'),(123,120,'SUSTITUCION X OTRA OT','',0,'2013-07-22 02:25:05','2013-07-22 02:25:05');
