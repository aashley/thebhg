-- phpMyAdmin SQL Dump
-- version 2.9.1.1-Debian-2ubuntu1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Aug 17, 2007 at 05:01 PM
-- Server version: 5.0.38
-- PHP Version: 5.2.1
-- 
-- Database: `bhgdevel`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `college_exam`
-- 

CREATE TABLE `college_exam` (
  `id` int(11) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `abbr` text character set latin1 NOT NULL,
  `description` text character set latin1 NOT NULL,
  `numberofquestions` int(11) NOT NULL default '0',
  `passinggrade` double NOT NULL default '0',
  `notebook` int(10) unsigned NOT NULL default '0',
  `datedeleted` datetime default NULL,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `school` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `college_exam_marker`
-- 

CREATE TABLE `college_exam_marker` (
  `exam` int(10) unsigned NOT NULL default '0',
  `marker` int(10) unsigned NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`exam`,`marker`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='People that mark an exam';

-- --------------------------------------------------------

-- 
-- Table structure for table `college_exam_question`
-- 

CREATE TABLE `college_exam_question` (
  `id` int(11) NOT NULL auto_increment,
  `exam` int(11) NOT NULL default '0',
  `question` text character set latin1 NOT NULL,
  `answer` text character set latin1 NOT NULL,
  `points` int(11) NOT NULL default '1',
  `mandatory` int(1) NOT NULL default '0',
  `datedeleted` datetime default NULL,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `college_reward`
-- 

CREATE TABLE `college_reward` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `exam` int(10) unsigned NOT NULL default '0',
  `rewardtype` enum('credit','medal') NOT NULL default 'credit',
  `requiredscore` double NOT NULL default '0',
  `award` int(11) NOT NULL default '0',
  `description` text,
  PRIMARY KEY  (`id`),
  KEY `exam` (`exam`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `college_school`
-- 

CREATE TABLE `college_school` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `name` varchar(250) NOT NULL default '',
  `description` text,
  `weight` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `college_submission`
-- 

CREATE TABLE `college_submission` (
  `id` int(11) NOT NULL auto_increment,
  `submitter` int(11) NOT NULL default '0',
  `exam` int(11) NOT NULL default '0',
  `score` double NOT NULL default '0',
  `graded` int(1) NOT NULL default '0',
  `passed` int(1) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `college_submission_answer`
-- 

CREATE TABLE `college_submission_answer` (
  `id` int(11) NOT NULL auto_increment,
  `submission` int(11) NOT NULL default '0',
  `question` int(11) NOT NULL default '0',
  `answer` text character set latin1 NOT NULL,
  `points` float(11,2) NOT NULL default '0.00',
  `possible` int(11) NOT NULL default '0',
  `comment` text character set latin1 NOT NULL,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `core_code`
-- 

CREATE TABLE `core_code` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(250) character set latin1 NOT NULL default '',
  `hash` varchar(32) NOT NULL default '',
  `god` tinyint(1) NOT NULL default '0',
  `credits` tinyint(1) NOT NULL default '0',
  `purchase` tinyint(1) NOT NULL default '0',
  `medalaward` tinyint(1) NOT NULL default '0',
  `citadel` tinyint(1) NOT NULL default '0',
  `ssl` tinyint(1) NOT NULL default '0',
  `history` tinyint(1) NOT NULL default '0',
  `email` tinyint(1) NOT NULL default '0',
  `news` tinyint(1) NOT NULL default '1',
  `allnews` tinyint(1) NOT NULL default '0',
  `library` tinyint(1) NOT NULL default '0',
  `cadre` tinyint(1) NOT NULL default '0',
  `hunts` tinyint(1) NOT NULL default '0',
  `allhunts` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `md5` (`hash`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Coder Identification Strings';

-- --------------------------------------------------------

-- 
-- Table structure for table `core_setting`
-- 

CREATE TABLE `core_setting` (
  `id` varchar(200) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `humanname` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `value` text character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='General Settings for the Roster';

-- --------------------------------------------------------

-- 
-- Table structure for table `history_event`
-- 

CREATE TABLE `history_event` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `person` int(11) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `item1` varchar(250) character set latin1 default NULL,
  `item2` varchar(250) character set latin1 default NULL,
  `item3` varchar(250) character set latin1 default NULL,
  `item4` varchar(250) default NULL,
  PRIMARY KEY  (`id`),
  KEY `person_date` (`person`),
  KEY `person` (`person`),
  KEY `person_type` (`person`,`type`),
  KEY `person_type_date` (`person`,`type`),
  KEY `type` (`type`),
  KEY `type_date` (`type`),
  KEY `type_1_2_date` (`type`,`item1`(20),`item2`(20)),
  KEY `type_1_date` (`type`,`item1`(20)),
  KEY `type_1_2_3_date` (`type`,`item1`(20),`item2`(20),`item3`(20))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `hosting_account`
-- 

CREATE TABLE `hosting_account` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` enum('FTP','MySQL','Email','CoderID') NOT NULL default 'FTP',
  `parent` int(10) unsigned NOT NULL default '0',
  `target` varchar(250) NOT NULL default '',
  `username` varchar(50) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `hosting_rule`
-- 

CREATE TABLE `hosting_rule` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `account` int(10) unsigned NOT NULL default '0',
  `division` int(11) default NULL,
  `person` int(11) default NULL,
  `position` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `library_book`
-- 

CREATE TABLE `library_book` (
  `id` int(11) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `description` longtext character set latin1 NOT NULL,
  `imagetype` text,
  `image` longblob NOT NULL,
  `shelf` int(10) unsigned NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `library_chapter`
-- 

CREATE TABLE `library_chapter` (
  `id` int(11) NOT NULL auto_increment,
  `book` int(11) NOT NULL default '0',
  `name` text character set latin1 NOT NULL,
  `sortorder` int(11) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `library_moderator`
-- 

CREATE TABLE `library_moderator` (
  `book` int(11) NOT NULL default '0',
  `person` int(11) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`book`,`person`),
  KEY `book` (`book`),
  KEY `person` (`person`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `library_section`
-- 

CREATE TABLE `library_section` (
  `id` int(11) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `content` longtext character set latin1 NOT NULL,
  `chapter` int(11) NOT NULL default '0',
  `sortorder` int(11) NOT NULL default '0',
  `html` int(1) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `library_shelf`
-- 

CREATE TABLE `library_shelf` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) character set latin1 NOT NULL default '',
  `description` text character set latin1 NOT NULL,
  `sortorder` int(11) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='The Shelves in the BHG Library';

-- --------------------------------------------------------

-- 
-- Table structure for table `medalboard_award`
-- 

CREATE TABLE `medalboard_award` (
  `id` int(11) NOT NULL auto_increment,
  `recipient` int(11) NOT NULL default '0',
  `awarder` int(11) NOT NULL default '0',
  `medal` tinyint(4) NOT NULL default '0',
  `reason` text NOT NULL,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `awarderid` (`awarder`),
  KEY `medal` (`medal`),
  KEY `recipientid` (`recipient`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='The medals that have been awarded';

-- --------------------------------------------------------

-- 
-- Table structure for table `medalboard_category`
-- 

CREATE TABLE `medalboard_category` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `sortorder` int(4) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Medal Categories';

-- --------------------------------------------------------

-- 
-- Table structure for table `medalboard_group`
-- 

CREATE TABLE `medalboard_group` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `abbrev` varchar(10) character set latin1 NOT NULL default '',
  `category` tinyint(4) NOT NULL default '0',
  `multiple` tinyint(1) NOT NULL default '0',
  `displaytype` tinyint(1) NOT NULL default '0',
  `startbracket` varchar(10) character set latin1 NOT NULL default '',
  `endbracket` varchar(10) character set latin1 NOT NULL default '',
  `sortorder` int(4) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `description` longtext,
  PRIMARY KEY  (`id`),
  KEY `category` (`category`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Medal Type info';

-- --------------------------------------------------------

-- 
-- Table structure for table `medalboard_medal`
-- 

CREATE TABLE `medalboard_medal` (
  `id` int(11) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `abbrev` varchar(10) character set latin1 NOT NULL default '',
  `group` tinyint(4) NOT NULL default '0',
  `image` varchar(200) character set latin1 default NULL,
  `sortorder` int(4) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `group` (`group`),
  KEY `abbrev` (`abbrev`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Individual medal names and abbreviations';

-- --------------------------------------------------------

-- 
-- Table structure for table `news_item`
-- 

CREATE TABLE `news_item` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `section` int(10) unsigned NOT NULL default '0',
  `poster` int(11) NOT NULL default '0',
  `topic` text character set latin1 NOT NULL,
  `message` text character set latin1 NOT NULL,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `topic` (`topic`),
  FULLTEXT KEY `topic_2` (`topic`,`message`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_biographical_data`
-- 

CREATE TABLE `roster_biographical_data` (
  `id` bigint(20) NOT NULL auto_increment,
  `person` bigint(20) NOT NULL default '0',
  `homeworld` text character set latin1,
  `age` int(5) default '0',
  `species` text character set latin1,
  `height` text character set latin1,
  `sex` text character set latin1,
  `imageurl` text,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `person` (`person`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='This table contains biographical data and CS details';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_cadre_bank`
-- 

CREATE TABLE `roster_cadre_bank` (
  `cadre` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `source` int(11) NOT NULL,
  `datecreated` datetime NOT NULL,
  `dateupdated` datetime NOT NULL,
  `datedeleted` datetime default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Account Credits';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_division`
-- 

CREATE TABLE `roster_division` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(150) character set latin1 NOT NULL default '',
  `category` tinyint(4) NOT NULL default '0',
  `cadre` tinyint(1) NOT NULL,
  `homepageurl` varchar(200) default NULL,
  `slogan` text character set latin1,
  `logo` varchar(200) character set latin1 default NULL,
  `mailinglist` varchar(50) character set latin1 default 'none',
  `deleted` tinyint(1) default '0',
  `welcomemessage` text character set latin1,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `category` (`category`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Details for each division/kabal';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_division_category`
-- 

CREATE TABLE `roster_division_category` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(150) character set latin1 NOT NULL default '',
  `cadres` int(1) default NULL,
  `sortorder` int(4) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Info for grouping of divisions';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_new_person`
-- 

CREATE TABLE `roster_new_person` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(100) character set latin1 NOT NULL default '',
  `email` varchar(150) character set latin1 NOT NULL default '',
  `password` text character set latin1 NOT NULL,
  `underage` tinyint(1) NOT NULL default '0',
  `parentemail` varchar(150) character set latin1 default NULL,
  `comments` longtext character set latin1,
  `recruiter` int(11) default NULL,
  `added` tinyint(1) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Storage for new members';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_pending_credit`
-- 

CREATE TABLE `roster_pending_credit` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `recipient` int(11) unsigned NOT NULL default '0',
  `awarder` int(11) unsigned NOT NULL default '0',
  `amount` int(11) NOT NULL default '0',
  `account` int(11) NOT NULL,
  `reason` text collate utf8_unicode_ci NOT NULL,
  `approved` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Pending Credit Awards';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_pending_medal`
-- 

CREATE TABLE `roster_pending_medal` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `recipient` int(11) unsigned NOT NULL default '0',
  `awarder` int(11) NOT NULL default '0',
  `medaltype` enum('group','medal') collate utf8_unicode_ci NOT NULL default 'group',
  `medal` int(11) unsigned NOT NULL default '0',
  `reason` text collate utf8_unicode_ci NOT NULL,
  `approved` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Pending Medal Awards';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_pending_transfer`
-- 

CREATE TABLE `roster_pending_transfer` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `person` int(11) unsigned NOT NULL default '0',
  `target` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Pending Transfer Requests';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_person`
-- 

CREATE TABLE `roster_person` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(100) character set latin1 NOT NULL default '',
  `email` varchar(150) character set latin1 NOT NULL default '',
  `rank` int(4) NOT NULL default '0',
  `rankcredits` bigint(20) NOT NULL default '0',
  `division` tinyint(4) NOT NULL default '0',
  `cadrerank` int(11) unsigned NOT NULL default '0',
  `position` tinyint(4) NOT NULL default '0',
  `url` varchar(200) character set latin1 default NULL,
  `ircnicks` text character set latin1,
  `passwd` text character set latin1,
  `quote` text character set latin1,
  `previousdivision` int(4) default NULL,
  `ship` int(1) NOT NULL default '0',
  `completedcoreexam` int(1) NOT NULL default '0',
  `lha` tinyint(1) NOT NULL,
  `inactive` tinyint(1) NOT NULL,
  `aim` varchar(250) character set latin1 NOT NULL default '',
  `msn` varchar(250) character set latin1 NOT NULL default '',
  `icq` int(15) unsigned NOT NULL default '0',
  `yahoo` varchar(250) character set latin1 NOT NULL default '',
  `jabber` varchar(250) character set latin1 NOT NULL default '',
  `redoranks` int(1) NOT NULL default '0',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `md5Password` char(32) default NULL,
  `xp` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `division` (`division`),
  KEY `position` (`position`),
  KEY `cadre` (`cadrerank`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='The actual roster where people are kept';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_person_bank`
-- 

CREATE TABLE `roster_person_bank` (
  `person` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `source` int(11) NOT NULL,
  `datecreated` datetime NOT NULL,
  `dateupdated` datetime NOT NULL,
  `datedeleted` datetime default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Account Credits';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_position`
-- 

CREATE TABLE `roster_position` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `abbrev` varchar(5) character set latin1 NOT NULL default '',
  `income` bigint(20) NOT NULL default '0',
  `trainee` int(1) NOT NULL default '0',
  `specialdivision` text NOT NULL,
  `emailalias` int(1) NOT NULL default '0',
  `sortorder` int(4) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Position details';

-- --------------------------------------------------------

-- 
-- Table structure for table `roster_rank`
-- 

CREATE TABLE `roster_rank` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `abbrev` varchar(5) character set latin1 NOT NULL default '',
  `division` int(11) default NULL,
  `requiredcredits` int(11) NOT NULL default '0',
  `alwaysavailable` int(1) NOT NULL default '0',
  `unlimitedcredits` int(1) NOT NULL default '0',
  `manuallyset` int(1) NOT NULL default '0',
  `cadre` tinyint(1) NOT NULL default '0',
  `core` tinyint(1) NOT NULL default '0',
  `standard` tinyint(1) NOT NULL default '0',
  `initiate` tinyint(1) NOT NULL default '0',
  `inactive` tinyint(1) NOT NULL default '0',
  `sortorder` int(4) NOT NULL default '0',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Rank details';

-- --------------------------------------------------------

-- 
-- Table structure for table `starchart_attribute_type`
-- 

CREATE TABLE `starchart_attribute_type` (
  `id` int(11) NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `name` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `starchart_object`
-- 

CREATE TABLE `starchart_object` (
  `id` int(11) NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `type` int(11) NOT NULL default '0',
  `typeextended` varchar(250) default NULL,
  `name` varchar(200) NOT NULL default '',
  `description` text NOT NULL,
  `picture` text,
  `parent` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `starchart_object_attribute`
-- 

CREATE TABLE `starchart_object_attribute` (
  `id` int(11) NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `object` int(11) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `starchart_object_type`
-- 

CREATE TABLE `starchart_object_type` (
  `id` int(11) NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `name` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `starchart_object_type_attribute`
-- 

CREATE TABLE `starchart_object_type_attribute` (
  `id` int(11) NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateupdated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datedeleted` datetime default NULL,
  `type` int(11) NOT NULL default '0',
  `attribute` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
