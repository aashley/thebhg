# phpMyAdmin MySQL-Dump
# version 2.2.0
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# Host: localhost
# Generation Time: November 28, 2001, 5:43 am
# Server version: 3.23.45
# PHP Version: 4.0.6
# Database : `thebhg_mall`
# --------------------------------------------------------

#
# Table structure for table `kiw_items`
#

DROP TABLE IF EXISTS `kiw_items`;
CREATE TABLE `kiw_items` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(11) NOT NULL default '0',
  `name` tinytext NOT NULL,
  `price` int(11) NOT NULL default '0',
  `min` int(11) NOT NULL default '0',
  `max` int(11) NOT NULL default '0',
  `restriction` tinyint(4) NOT NULL default '0',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`,`type`,`restriction`)
) TYPE=MyISAM COMMENT='Items for sale';
# --------------------------------------------------------

#
# Table structure for table `kiw_itemtypes`
#

DROP TABLE IF EXISTS `kiw_itemtypes`;
CREATE TABLE `kiw_itemtypes` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) TYPE=MyISAM COMMENT='Item types';
# --------------------------------------------------------

#
# Table structure for table `kiw_sales`
#

DROP TABLE IF EXISTS `kiw_sales`;
CREATE TABLE `kiw_sales` (
  `id` int(11) NOT NULL auto_increment,
  `item` int(11) NOT NULL default '0',
  `owner` int(11) NOT NULL default '0',
  `quantity` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`,`item`,`owner`)
) TYPE=MyISAM COMMENT='Sales of items to customers';

