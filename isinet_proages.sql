﻿# Host: localhost  (Version: 5.5.24)
# Date: 2013-07-20 13:54:23
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "agent_uids"
#

INSERT INTO `agent_uids` VALUES (1,1,'clave','24124safaf','2013-07-10 17:18:54','2013-07-10 17:18:54'),(2,1,'national','AFASF2414','2013-07-10 17:18:54','2013-07-10 17:18:54'),(3,1,'national','1241ASFAF','2013-07-10 17:18:54','2013-07-10 17:18:54'),(4,1,'provincial','ASFAF12414','2013-07-10 17:18:54','2013-07-10 17:18:54');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "agents"
#

INSERT INTO `agents` VALUES (1,2,'2013-07-10','2013-07-10','2013-07-10 17:18:54','2013-07-10 17:18:54');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "currencies"
#


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "payment_intervals"
#


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "payment_methods"
#


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "policies"
#


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


#
# Source for table "product_group"
#

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
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

#
# Data for table "user_roles_vs_access"
#

INSERT INTO `user_roles_vs_access` VALUES (8,4,2,1,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(9,4,2,5,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(10,4,2,11,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(11,3,2,1,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(12,3,2,5,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(13,3,2,11,'2013-07-15 22:44:39','2013-07-15 22:44:39'),(53,1,2,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(54,1,2,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(55,1,2,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(56,5,2,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(57,5,2,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(58,5,2,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(59,5,2,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(60,5,2,5,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(61,5,2,6,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(62,5,2,7,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(63,5,2,8,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(64,5,2,9,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(65,5,2,10,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(66,5,2,11,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(67,5,3,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(68,5,3,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(69,5,3,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(70,5,4,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(71,5,4,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(72,5,4,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(73,5,5,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(74,5,5,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(75,5,5,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(76,5,5,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(77,5,5,5,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(78,5,5,6,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(79,5,5,7,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(80,5,5,8,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(81,5,5,9,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(82,5,5,10,'0000-00-00 00:00:00','0000-00-00 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,0,0,'SOS','gerente','827ccb0eea8a706c4c34a16891f84e7b','Gerente','APP','2013-07-09','gerente@gmail.com','default.png',1,'2013-07-09 20:21:36','2013-07-15 12:24:12'),(2,0,1,'sos','agente','827ccb0eea8a706c4c34a16891f84e7b','AGENTE','AGENTEAS','2013-07-10','ing.ulisesrodriguez@gmail.com','default.png',1,'2013-07-10 17:18:54','2013-07-15 12:24:12'),(3,0,0,'SOS','ulises','827ccb0eea8a706c4c34a16891f84e7b','ulisess','rodriguez','2013-07-10','ing.ulisesrodriguezs@gmail.com','default.png',1,'2013-07-10 17:53:06','2013-07-15 12:24:12'),(4,0,0,'Compañia','coordinador','827ccb0eea8a706c4c34a16891f84e7b','Coordinador','Co','2013-07-15','coordinador@gmail.com','default.png',1,'2013-07-15 16:08:56','2013-07-15 12:24:12'),(5,0,0,'SOS','administrador','827ccb0eea8a706c4c34a16891f84e7b','Administrador','Admin','1994-07-05','administrador@gmail.com','default.png',1,'0000-00-00 00:00:00','2013-07-20 00:09:43'),(6,0,0,'SOS','admin','827ccb0eea8a706c4c34a16891f84e7b','Ulises','Rodriguez','2013-07-19','admin@gmail.com',NULL,0,'2013-07-19 17:46:38','2013-07-19 17:46:38'),(7,0,0,'SOS','coord','827ccb0eea8a706c4c34a16891f84e7b','Ulises','Rodriguez','2013-07-19','corrd@mail.com','8920_164632873081_807988081_3695183_7912140_n.jpg',0,'2013-07-19 18:00:45','2013-07-19 18:00:45');

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

INSERT INTO `users_vs_user_roles` VALUES (1,3),(2,1),(2,2),(3,2),(4,2),(5,5),(6,5),(7,2);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "work_order"
#


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "work_order_reason"
#


#
# Source for table "work_order_responsibles"
#

CREATE TABLE `work_order_responsibles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `last_updated` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "work_order_responsibles"
#


#
# Source for table "work_order_status"
#

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

CREATE TABLE `work_order_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patent_id` int(11) NOT NULL,
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

