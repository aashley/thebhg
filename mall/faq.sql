# phpMyAdmin MySQL-Dump
# version 2.3.0
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Aug 28, 2002 at 07:59 AM
# Server version: 3.23.36
# PHP Version: 4.1.1
# Database : `thebhg_lawngnome`
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

