# Database for BHG Roster V3.0
# Database : `thebhg_roster`
# --------------------------------------------------------

#
# Table structure for table `mb_medal_categories`
#

DROP TABLE IF EXISTS `mb_medal_categories`;
CREATE TABLE `mb_medal_categories` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Medal Categories';
# --------------------------------------------------------

#
# Table structure for table `mb_medal_descriptions`
#

DROP TABLE IF EXISTS `mb_medal_descriptions`;
CREATE TABLE `mb_medal_descriptions` (
  `id` tinyint(4) NOT NULL auto_increment,
  `type` tinyint(4) NOT NULL default '0',
  `html` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `type` (`type`)
) TYPE=MyISAM COMMENT='HTML Descriptions for each categories';
# --------------------------------------------------------

#
# Table structure for table `mb_medal_names`
#

DROP TABLE IF EXISTS `mb_medal_names`;
CREATE TABLE `mb_medal_names` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `abbrev` varchar(10) NOT NULL default '',
  `type` tinyint(4) NOT NULL default '0',
  `imageurl` text default '',
  `imagedir` text default '',
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `abbrev` (`abbrev`)
) TYPE=MyISAM COMMENT='Individual medal names and abbreviations';
# --------------------------------------------------------

#
# Table structure for table `mb_medal_types`
#

DROP TABLE IF EXISTS `mb_medal_types`;
CREATE TABLE `mb_medal_types` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` text NOT NULL,
  `abbrev` varchar(10) NOT NULL default '',
  `category` tinyint(4) NOT NULL default '0',
  `order` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `category` (`category`)
) TYPE=MyISAM COMMENT='Medal Type infto';
# --------------------------------------------------------

#
# Table structure for table `mb_medals`
#

DROP TABLE IF EXISTS `mb_medals`;
CREATE TABLE `mb_medals` (
  `id` int(11) NOT NULL auto_increment,
  `recipientid` int(11) NOT NULL default '0',
  `awarderid` int(11) NOT NULL default '0',
  `medal` tinyint(4) NOT NULL default '0',
  `medaltype` tinyint(4) NOT NULL default '0',
  `why` text,
  `date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `recipientid` (`recipientid`),
  KEY `awarderid` (`awarderid`),
  KEY `medal` (`medal`),
  KEY `medaltype` (`medaltype`)
) TYPE=MyISAM COMMENT='The medals that have been awarded';
# --------------------------------------------------------

#
# Table structure for table `roster_biographical_data`
#

DROP TABLE IF EXISTS `roster_biographical_data`;
CREATE TABLE `roster_biographical_data` (
  `id` bigint(20) NOT NULL auto_increment,
  `person` bigint(20) NOT NULL default '0',
  `homeworld` text,
  `age` int(5) default '0',
  `species` text,
  `height` text,
  `sex` text,
  `image_url` text,
  PRIMARY KEY  (`id`),
  KEY `person` (`person`)
) TYPE=MyISAM COMMENT='This table contains biographical data and CS details';
# --------------------------------------------------------

#
# Table structure for table `roster_blacklist`
#

DROP TABLE IF EXISTS `roster_blacklist`;
CREATE TABLE `roster_blacklist` (
  `id` bigint(10) NOT NULL auto_increment,
  `word` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='This table contains bad words not to be in name';
# --------------------------------------------------------

#
# Table structure for table `roster_division_categories`
#

DROP TABLE IF EXISTS `roster_division_categories`;
CREATE TABLE `roster_division_categories` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(150) NOT NULL default '',
  `haskabals` tinyint(1) NOT NULL default 0,
  `order` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Info for grouping of divisions';
# --------------------------------------------------------

#
# Table structure for table `roster_divisions`
#

DROP TABLE IF EXISTS `roster_divisions`;
CREATE TABLE `roster_divisions` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(150) NOT NULL default '',
  `category` tinyint(4) NOT NULL default '0',
  `home_page_url` varchar(200) default NULL,
  `slogan` text,
  `logo` varchar(200) default NULL,
  `mailinglist` varchar(50) default 'none',
  `deleted` tinyint(1) default '0',
  `welcomemessage` text,
  PRIMARY KEY  (`id`),
  KEY `category` (`category`)
) TYPE=MyISAM COMMENT='Details for each division/kabal';
# --------------------------------------------------------

#
# Table structure for table `roster_new_members`
#

DROP TABLE IF EXISTS `roster_new_members`;
CREATE TABLE `roster_new_members` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `email` varchar(150) NOT NULL default '',
  `kabal` int(4) NOT NULL default '0',
  `password` text NOT NULL,
  `underage` tinyint(1) NOT NULL default '0',
  `parentemail` varchar(150) default NULL,
  `comments` longtext,
  `added` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Storage for new members';
# --------------------------------------------------------

#
# Table structure for table `roster_position`
#

DROP TABLE IF EXISTS `roster_position`;
CREATE TABLE `roster_position` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` text NOT NULL,
  `abbrev` varchar(5) NOT NULL default '',
  `income` bigint(20) NOT NULL default '0',
  `istrainee` tinyint(1) NOT NULL default '0',
  `order` int(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Position details';
# --------------------------------------------------------

#
# Table structure for table `roster_rank`
#

DROP TABLE IF EXISTS `roster_rank`;
CREATE TABLE `roster_rank` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` text NOT NULL,
  `abbrev` varchar(5) NOT NULL default '',
  `credits_needed` int(11) NOT NULL default '0',
  `always_available` tinyint(1) NOT NULL default '0',
  `unlimited_credits` tinyint(1) NOT NULL default '0',
  `order` int(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='Rank details';
# --------------------------------------------------------

#
# Table structure for table `roster_roster`
#

DROP TABLE IF EXISTS `roster_roster`;
CREATE TABLE `roster_roster` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `email` varchar(150) NOT NULL default '',
  `rank` int(4) NOT NULL default '0',
  `rankcredits` bigint(20) NOT NULL default '0',
  `accountbalance` bigint(20) NOT NULL default '0',
  `division` tinyint(4) NOT NULL default '0',
  `position` tinyint(4) NOT NULL default '0',
  `url` varchar(200) default NULL,
  `ircnicks` text,
  `passwd` text,
  `quote` text,
  `previous_division` int(4) NOT NULL default '0',
  `hasship` tinyint(1) NOT NULL default '0',
  `completed_ntc_exam` tinyint(1) NOT NULL default '0',
  `redo_ranks` tinyint(1) NOT NULL default '0',
  `date_joined` date NOT NULL default '0000-00-00',
  `last_updated` timestamp(14) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `division` (`division`),
  KEY `position` (`position`),
  KEY `name` (`name`)
) TYPE=MyISAM COMMENT='The actual roster where people are kept';

