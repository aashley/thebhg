# phpMyAdmin MySQL-Dump
# version 2.3.0
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Nov 14, 2002 at 01:25 AM
# Server version: 3.23.41
# PHP Version: 4.2.2
# Database : `thebhg_mall`
# --------------------------------------------------------

#
# Table structure for table `ssl_auctions`
#

CREATE TABLE `ssl_auctions` (
  `id` int(11) NOT NULL auto_increment,
  `sale` int(11) NOT NULL default '0',
  `minimum` bigint(20) NOT NULL default '0',
  `enforce` smallint(6) NOT NULL default '0',
  `description` text NOT NULL,
  `end` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `sale` (`sale`),
  KEY `end` (`end`)
) TYPE=MyISAM COMMENT='Junkyard auctions';
# --------------------------------------------------------

#
# Table structure for table `ssl_bays`
#

CREATE TABLE `ssl_bays` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `external` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Bay types';
# --------------------------------------------------------

#
# Table structure for table `ssl_bids`
#

CREATE TABLE `ssl_bids` (
  `id` int(11) NOT NULL auto_increment,
  `auction` int(11) NOT NULL default '0',
  `person` int(11) NOT NULL default '0',
  `bid` int(11) NOT NULL default '0',
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `auction` (`auction`),
  KEY `person` (`person`)
) TYPE=MyISAM COMMENT='Junkyard auction bids';
# --------------------------------------------------------

#
# Table structure for table `ssl_faq`
#

CREATE TABLE `ssl_faq` (
  `id` int(11) NOT NULL auto_increment,
  `section` int(11) NOT NULL default '0',
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `after` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `section` (`section`),
  KEY `after` (`after`)
) TYPE=MyISAM COMMENT='FAQ';
# --------------------------------------------------------

#
# Table structure for table `ssl_faq_sections`
#

CREATE TABLE `ssl_faq_sections` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `after` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `after` (`after`)
) TYPE=MyISAM COMMENT='FAQ sections';
# --------------------------------------------------------

#
# Table structure for table `ssl_history`
#

CREATE TABLE `ssl_history` (
  `id` int(11) NOT NULL auto_increment,
  `time` int(11) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `owner` int(11) NOT NULL default '0',
  `sale` int(11) NOT NULL default '0',
  `bloba` blob NOT NULL,
  `blobb` blob NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `sale` (`sale`),
  KEY `time` (`time`),
  KEY `type` (`type`),
  KEY `owner` (`owner`)
) TYPE=MyISAM COMMENT='Sale history';
# --------------------------------------------------------

#
# Table structure for table `ssl_hull_bays`
#

CREATE TABLE `ssl_hull_bays` (
  `id` int(11) NOT NULL auto_increment,
  `hull` int(11) NOT NULL default '0',
  `bay` int(11) NOT NULL default '0',
  `size` int(11) NOT NULL default '0',
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
  `length` int(11) NOT NULL default '0',
  `hull` int(11) NOT NULL default '0',
  `people` int(11) NOT NULL default '0',
  `min` int(11) NOT NULL default '0',
  `max` int(11) NOT NULL default '0',
  `restriction` tinyint(4) NOT NULL default '0',
  `description` text NOT NULL,
  `limit` int(11) NOT NULL default '0',
  `image` blob NOT NULL,
  `imagetype` tinytext NOT NULL,
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
  `bay` int(11) NOT NULL default '0',
  `external` tinyint(4) NOT NULL default '0',
  `min` int(11) NOT NULL default '0',
  `max` int(11) NOT NULL default '0',
  `restriction` tinyint(4) NOT NULL default '0',
  `limit` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`),
  KEY `bay` (`bay`)
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
  `purchase_time` int(11) NOT NULL default '0',
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
  `purchase_time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`,`item`,`owner`)
) TYPE=MyISAM COMMENT='Sales of items to customers';
# --------------------------------------------------------

#
# Table structure for table `ssl_shipparts`
#

CREATE TABLE `ssl_shipparts` (
  `id` int(11) NOT NULL auto_increment,
  `ship` int(11) NOT NULL default '0',
  `part` int(11) NOT NULL default '0',
  `hullbay` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `item` (`ship`),
  KEY `part` (`part`),
  KEY `hullbay` (`hullbay`)
) TYPE=MyISAM COMMENT='Pre-defined ship parts';
# --------------------------------------------------------

#
# Table structure for table `ssl_ships`
#

CREATE TABLE `ssl_ships` (
  `id` int(11) NOT NULL auto_increment,
  `type` int(11) NOT NULL default '0',
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL default '0',
  `hull` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `price` (`price`),
  KEY `hull` (`hull`),
  KEY `type` (`type`)
) TYPE=MyISAM COMMENT='Predefined ships';
# --------------------------------------------------------

#
# Table structure for table `ssl_shiptypes`
#

CREATE TABLE `ssl_shiptypes` (
  `id` int(11) NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Pre-defined ship types';
# --------------------------------------------------------

#
# Table structure for table `ssl_stats`
#

CREATE TABLE `ssl_stats` (
  `id` int(11) NOT NULL default '0',
  `consumables` int(11) NOT NULL default '0',
  `hull` int(11) NOT NULL default '0',
  `shields` int(11) NOT NULL default '0',
  `speed` int(11) NOT NULL default '0',
  `acceleration` int(11) NOT NULL default '0',
  `turnrate` int(11) NOT NULL default '0',
  `hyperdrive` decimal(4,2) NOT NULL default '0.00',
  `power` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Statistics for each part';

