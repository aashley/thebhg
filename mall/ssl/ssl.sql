# phpMyAdmin MySQL-Dump
# version 2.2.0
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# Host: localhost
# Generation Time: July 11, 2002, 5:22 am
# Server version: 3.23.36
# PHP Version: 4.1.1
# Database : `thebhg_lawngnome`
# --------------------------------------------------------

#
# Table structure for table `ssl_bays`
#

CREATE TABLE `ssl_bays` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `size` int(11) NOT NULL default '0',
  `external` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Bay types';
# --------------------------------------------------------

#
# Table structure for table `ssl_hull_bays`
#

CREATE TABLE `ssl_hull_bays` (
  `id` int(11) NOT NULL auto_increment,
  `hull` int(11) NOT NULL default '0',
  `bay` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `hull` (`hull`),
  KEY `bay` (`bay`)
) TYPE=MyISAM COMMENT='Standard bays in a hull';
# --------------------------------------------------------

#
# Table structure for table `ssl_items`
#

CREATE TABLE `ssl_items` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(11) NOT NULL default '0',
  `name` tinytext NOT NULL,
  `price` int(11) NOT NULL default '0',
  `min` int(11) NOT NULL default '0',
  `max` int(11) NOT NULL default '0',
  `restriction` tinyint(4) NOT NULL default '0',
  `description` text NOT NULL,
  `limit` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`,`type`,`restriction`)
) TYPE=MyISAM COMMENT='Items for sale';
# --------------------------------------------------------

#
# Table structure for table `ssl_itemtypes`
#

CREATE TABLE `ssl_itemtypes` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) TYPE=MyISAM COMMENT='Item types';
# --------------------------------------------------------

#
# Table structure for table `ssl_parts`
#

CREATE TABLE `ssl_parts` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(11) NOT NULL default '0',
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL default '0',
  `size` int(11) NOT NULL default '0',
  `external` tinyint(4) NOT NULL default '0',
  `min` int(11) NOT NULL default '0',
  `max` int(11) NOT NULL default '0',
  `restriction` tinyint(4) NOT NULL default '0',
  `limit` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`)
) TYPE=MyISAM COMMENT='Parts available to buy';
# --------------------------------------------------------

#
# Table structure for table `ssl_partsales`
#

CREATE TABLE `ssl_partsales` (
  `id` int(11) NOT NULL auto_increment,
  `sale` int(11) NOT NULL default '0',
  `part` int(11) NOT NULL default '0',
  `bay` int(11) NOT NULL default '0',
  `owner` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `part` (`part`),
  KEY `bay` (`bay`),
  KEY `owner` (`owner`),
  KEY `hull` (`sale`)
) TYPE=MyISAM COMMENT='Parts sold';
# --------------------------------------------------------

#
# Table structure for table `ssl_parttypes`
#

CREATE TABLE `ssl_parttypes` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Part types';
# --------------------------------------------------------

#
# Table structure for table `ssl_sales`
#

CREATE TABLE `ssl_sales` (
  `id` int(11) NOT NULL auto_increment,
  `item` int(11) NOT NULL default '0',
  `name` tinytext NOT NULL,
  `owner` int(11) NOT NULL default '0',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`,`item`,`owner`)
) TYPE=MyISAM COMMENT='Sales of items to customers';

