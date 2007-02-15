BEGIN;

\! echo Dropping Old Tables
-- Drop old CS code
DROP TABLE `cs_bonus_points`, `cs_classes`, `cs_field_options`, `cs_fields`, `cs_pending_fields`, `cs_sheet_fields`, `cs_sheets`, `cs_unused_xp`, `cs_used_xp`, `new_members`;
-- Drop old Holonet Crap that shouldnt be here
DROP TABLE `hn_cadre_applications` ,
		 `hn_com_poll` ,
		 `hn_com_vote` ,
		 `hn_pending_awols` ,
		 `hn_pending_credits` ,
		 `hn_pending_medals` ,
		 `hn_pending_reasons` ,
		 `hn_reports` ,
		 `http_logins` ;
-- Roster Black list
DROP TABLE roster_blacklist;

-- Code IDs
\! echo core_code
ALTER TABLE coders RENAME core_code;
ALTER TABLE core_code DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE core_code CHANGE md5 hash CHAR(32) NOT NULL;
UPDATE core_code SET hash = LOWER(hash);
ALTER TABLE core_code ADD UNIQUE KEY(hash);

-- Roster Bio Data
\! echo roster_biographical_data
ALTER TABLE `roster_biographical_data` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_biographical_data ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_biographical_data ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_biographical_data ADD COLUMN datedeleted DATETIME;
UPDATE roster_biographical_data SET datecreated = NOW(), dateupdated = NOW();
ALTER TABLE roster_biographical_data CHANGE image_url imageurl TEXT;

-- Roster Cadres
\! echo roster_cadre
ALTER TABLE roster_cadres RENAME roster_cadre;
ALTER TABLE `roster_cadre` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_cadre ADD COLUMN datecreated DATETIME NOT NULL;
UPDATE roster_cadre SET datecreated = FROM_UNIXTIME(date_created);
ALTER TABLE roster_cadre DROP COLUMN date_created;

ALTER TABLE roster_cadre ADD COLUMN dateupdated DATETIME NOT NULL;
UPDATE roster_cadre SET dateupdated = NOW();

ALTER TABLE roster_cadre ADD COLUMN datedeleted DATETIME;
UPDATE roster_cadre SET datedeleted = FROM_UNIXTIME(date_deleted) WHERE date_deleted != 0;
UPDATE roster_cadre SET datedeleted = date_deleted WHERE date_deleted = 0;
ALTER TABLE roster_cadre DROP COLUMN date_deleted;

-- Roster Division Categories
\! echo roster_category
ALTER TABLE roster_division_categories RENAME roster_division_category;
ALTER TABLE `roster_division_category` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_division_category ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_division_category ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_division_category ADD COLUMN datedeleted DATETIME;
ALTER TABLE roster_division_category CHANGE haskabals kabals INT(1);
UPDATE roster_division_category SET datecreated = NOW(), dateupdated = NOW();
ALTER TABLE roster_division_category CHANGE `order` sortorder INT(4) NOT NULL;

-- Roster Divisions
\! echo roster_division
ALTER TABLE roster_divisions RENAME roster_division;
ALTER TABLE `roster_division` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_division ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_division ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_division ADD COLUMN datedeleted DATETIME;
UPDATE roster_division SET datecreated = NOW(), dateupdated = NOW();
UPDATE roster_division SET datedeleted = NOW() WHERE deleted = 1;
ALTER TABLE roster_division CHANGE home_page_url homepageurl VARCHAR(200);

-- Roster History
\! echo roster_history
ALTER TABLE roster_history RENAME history_event;
\! echo " - Renamed"
ALTER TABLE `history_event` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
\! echo " - Collation set"
ALTER TABLE history_event ADD COLUMN datecreated DATETIME NOT NULL AFTER `type`;
\! echo " - Added date_created"
UPDATE history_event SET datecreated = FROM_UNIXTIME(`date`);
\! echo " - Updated date_created"
ALTER TABLE history_event DROP COLUMN `date`;
\! echo " - Dropped date"
ALTER TABLE history_event ADD COLUMN item4 VARCHAR(250) NOT NULL DEFAULT '' AFTER `item3`;
\! echo " - Added item4"

-- Roster New Member
\! echo roster_new_person
ALTER TABLE roster_new_members RENAME roster_new_person;
ALTER TABLE `roster_new_person` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_new_person ADD COLUMN datecreated DATETIME NOT NULL;
UPDATE roster_new_person SET datecreated = NOW();

-- Roster Position
\! echo roster_position
ALTER TABLE `roster_position` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_position ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_position ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_position ADD COLUMN datedeleted DATETIME;
UPDATE roster_position SET datecreated = NOW(), dateupdated = NOW();
ALTER TABLE roster_position CHANGE special_division specialdivision TEXT NOT NULL;
ALTER TABLE roster_position CHANGE is_email_alias emailalias INT(1) NOT NULL;
ALTER TABLE roster_position CHANGE istrainee trainee INT(1) NOT NULL;
ALTER TABLE roster_position CHANGE `order` sortorder INT(4) NOT NULL;

-- Roster Rank
\! echo roster_rank
ALTER TABLE `roster_rank` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_rank ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_rank ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_rank ADD COLUMN datedeleted DATETIME;
UPDATE roster_rank SET datecreated = NOW(), dateupdated = NOW();
ALTER TABLE roster_rank CHANGE credits_needed requiredcredits INT(11) NOT NULL;
ALTER TABLE roster_rank CHANGE always_available alwaysavailable INT(1) NOT NULL;
ALTER TABLE roster_rank CHANGE unlimited_credits unlimitedcredits INT(1) NOT NULL;
ALTER TABLE roster_rank CHANGE manual_set manuallyset INT(1) NOT NULL;
ALTER TABLE roster_rank CHANGE `order` sortorder INT(4) NOT NULL;

-- Roster Person
\! echo roster_roster
ALTER TABLE roster_roster RENAME roster_person;
ALTER TABLE `roster_person` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_person ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_person ADD COLUMN datedeleted DATETIME;
UPDATE roster_person SET dateupdated = FROM_UNIXTIME(last_updated);
UPDATE roster_person SET datedeleted = dateupdated WHERE division IN (0, 16);
ALTER TABLE roster_person DROP COLUMN last_updated;
ALTER TABLE roster_person ADD COLUMN datecreated DATETIME NOT NULL;
UPDATE roster_person SET datecreated = date_joined;
ALTER TABLE roster_person DROP COLUMN date_joined;
ALTER TABLE roster_person ADD COLUMN md5Password VARCHAR(32);
ALTER TABLE roster_person CHANGE previous_division previousdivision INT(4);
ALTER TABLE roster_person CHANGE completed_ntc_exam completedcoreexam INT(1) NOT NULL;
ALTER TABLE roster_person CHANGE redo_ranks redoranks INT(1) NOT NULL;
ALTER TABLE roster_person CHANGE hasship ship INT(1) NOT NULL;
ALTER TABLE `roster_person` ADD `xp` INT NOT NULL DEFAULT '0';


-- Roster Transfer Request
\! echo roster_pending_transfer
CREATE TABLE `roster_pending_transfer` (
		`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`datecreated` DATETIME NOT NULL ,
		`dateupdated` DATETIME NOT NULL ,
		`datedeleted` DATETIME NOT NULL ,
		`person` INT( 11 ) UNSIGNED NOT NULL ,
		`target` INT( 11 ) UNSIGNED NOT NULL
		) TYPE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT = 'Pending Transfer Requests';


-- Roster Credit Award Request
\! echo roster_pending_credit
CREATE TABLE `roster_pending_credit` (
		`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`datecreated` DATETIME NOT NULL ,
		`dateupdated` DATETIME NOT NULL ,
		`datedeleted` DATETIME NOT NULL ,
		`recipient` INT( 11 ) UNSIGNED NOT NULL ,
		`awarder` INT( 11 ) UNSIGNED NOT NULL ,
		`amount` INT( 11 ) NOT NULL ,
		`reason` TEXT NOT NULL ,
		`approved` INT( 1 ) UNSIGNED NOT NULL DEFAULT '0'
		) TYPE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT = 'Pending Credit Awards';


-- Roster Medal Award Request
\! echo roster_pending_medal
CREATE TABLE `roster_pending_medal` (
		`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`datecreated` DATETIME NOT NULL ,
		`dateupdated` DATETIME NOT NULL ,
		`datedeleted` DATETIME NOT NULL ,
		`recipient` INT( 11 ) UNSIGNED NOT NULL ,
		`awarder` INT( 11 ) NOT NULL ,
		`medaltype` ENUM( 'group', 'medal' ) NOT NULL ,
		`medal` INT( 11 ) UNSIGNED NOT NULL ,
		`reason` TEXT NOT NULL ,
		`approved` INT( 1 ) NOT NULL
		) TYPE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT = 'Pending Medal Awards';


-- MedalBoard Awarded Medals
\! echo medalboard_award
ALTER TABLE mb_awarded_medals RENAME medalboard_award;
ALTER TABLE `medalboard_award` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE medalboard_award ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE medalboard_award ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE medalboard_award CHANGE recipientid recipient INT(11) NOT NULL;
ALTER TABLE medalboard_award CHANGE awarderid awarder INT(11) NOT NULL;
UPDATE medalboard_award SET datecreated = FROM_UNIXTIME(`date`), dateupdated = FROM_UNIXTIME(`date`);
ALTER TABLE medalboard_award DROP COLUMN `date`;
ALTER TABLE `medalboard_award` CHANGE `why` `reason` TEXT NOT NULL;

-- MedalBoard Medal Categories
\! echo medalboard_category
ALTER TABLE mb_medal_categories RENAME medalboard_category;
ALTER TABLE `medalboard_category` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE medalboard_category ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE medalboard_category ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE medalboard_category ADD COLUMN datedeleted DATETIME;
ALTER TABLE medalboard_category CHANGE `order` sortorder INT(4) NOT NULL;

-- MedalBoard Medal Groups
\! echo medalboard_group
ALTER TABLE mb_medal_groups RENAME medalboard_group;
ALTER TABLE `medalboard_group` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE medalboard_group ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE medalboard_group ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE medalboard_group ADD COLUMN datedeleted DATETIME;
ALTER TABLE medalboard_group CHANGE `order` sortorder INT(4) NOT NULL;
ALTER TABLE medalboard_group ADD COLUMN description LONGTEXT;
UPDATE medalboard_group,mb_medal_descriptions SET medalboard_group.description = mb_medal_descriptions.html WHERE medalboard_group.id = mb_medal_descriptions.group;
DROP TABLE mb_medal_descriptions;

-- MedalBoard Medal Names
\! echo medalboard_medal
ALTER TABLE mb_medal_names RENAME medalboard_medal;
ALTER TABLE `medalboard_medal` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE medalboard_medal ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE medalboard_medal ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE medalboard_medal ADD COLUMN datedeleted DATETIME;
ALTER TABLE medalboard_medal CHANGE `order` sortorder INT(4) NOT NULL;

-- Library Books
\! echo library_book
ALTER TABLE library_books RENAME library_book;
ALTER TABLE `library_book` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE library_book ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE library_book ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE library_book ADD COLUMN datedeleted DATETIME;
ALTER TABLE library_book CHANGE image_type imagetype TEXT;

-- Library Chapters
\! echo library_chapter
ALTER TABLE library_chapters RENAME library_chapter;
ALTER TABLE `library_chapter` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE library_chapter ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE library_chapter ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE library_chapter ADD COLUMN datedeleted DATETIME;
ALTER TABLE library_chapter CHANGE sort_order sortorder INT(11) NOT NULL;

-- Library Moderators
\! echo library_moderator
ALTER TABLE library_moderators RENAME library_moderator;
ALTER TABLE `library_moderator` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE library_moderator ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE library_moderator ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE library_moderator ADD COLUMN datedeleted DATETIME;

-- Library Sections
\! echo library_section
ALTER TABLE library_sections RENAME library_section;
ALTER TABLE `library_section` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE library_section ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE library_section ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE library_section ADD COLUMN datedeleted DATETIME;
ALTER TABLE library_section CHANGE sort_order sortorder INT(11) NOT NULL;
ALTER TABLE library_section CHANGE useHTML html INT(1) NOT NULL;

-- Library Shelves
\! echo library_shelves
ALTER TABLE library_shelves RENAME library_shelf;
ALTER TABLE `library_shelf` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE library_shelf ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE library_shelf ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE library_shelf ADD COLUMN datedeleted DATETIME;
ALTER TABLE library_shelf CHANGE sort_order sortorder INT(11) NOT NULL;

-- Newsboard
\! echo news_item
ALTER TABLE newsboard RENAME news_item;
ALTER TABLE `news_item` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE news_item ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE news_item ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE news_item ADD COLUMN datedeleted DATETIME;
UPDATE news_item SET datecreated = FROM_UNIXTIME(`timestamp`);
ALTER TABLE news_item DROP COLUMN `timestamp`;

-- College Reward
\! echo college_reward
CREATE TABLE `college_reward` (
		`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`exam` INT UNSIGNED NOT NULL ,
		`rewardtype` ENUM( 'credit', 'medal' ) NOT NULL ,
		`requiredscore` DOUBLE NOT NULL ,
		`award` INT NOT NULL ,
		`description` TEXT DEFAULT NULL,
		PRIMARY KEY ( `id` ) ,
		INDEX ( `exam` )
		) TYPE = MYISAM, COLLATE = utf8_general_ci ;

INSERT INTO `college_reward` (datecreated, dateupdated, exam, rewardtype, requiredscore, award) SELECT NOW(), NOW(), id, 'credit', passing_grade, credit_award FROM ntc_exams WHERE credit_award != 0;
INSERT INTO `college_reward` (datecreated, dateupdated, exam, rewardtype, requiredscore, award) SELECT NOW(), NOW(), id, 'medal', 100, medal_award FROM ntc_exams WHERE medal_award != 0;

-- College School
\! echo college_school
CREATE TABLE `college_school` (
		`id` INT UNSIGNED NOT NULL AUTO_INCREMENT <
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`name` VARCHAR(250) NOT NULL,
		`description` TEXT DEFAULT NULL,
		`weight` INT NOT NULL DEFAULT '1',
		PRIMARY KEY ( `id` ) ,
		) TYPE = MYISAM, COLLATE = utf8_general_ci ;

INSERT INTO `college_school (1, NOW(), NOW(), NULL, 'General', 'The first school of the college.', 1);

-- NTC Exams
\! echo college_exam
ALTER TABLE ntc_exams RENAME college_exam;
ALTER TABLE `college_exam` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE college_exam ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE college_exam ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE college_exam CHANGE date_deleted datedeleted DATETIME;
ALTER TABLE college_exam CHANGE num_questions numberofquestions INT(11) NOT NULL;
ALTER TABLE college_exam CHANGE passing_grade passinggrade DOUBLE NOT NULL;
ALTER TABLE college_exam DROP COLUMN medal_award;
ALTER TABLE college_exam DROP COLUMN credit_award;
ALTER TABLE college_exam ADD COLUMN school INT(11) NOT NULL;
UPDATE college_exam SET school = 1;

-- NTC Questions
\! echo college_exam_question
ALTER TABLE ntc_exam_questions RENAME college_exam_question;
ALTER TABLE `college_exam_question` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE college_exam_question ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE college_exam_question ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE college_exam_question CHANGE date_deleted datedeleted DATETIME;

-- NTC Exam Markers
\! echo college_exam_marker
ALTER TABLE ntc_exam_markers RENAME college_exam_marker;
ALTER TABLE `college_exam_marker` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE college_exam_marker ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE college_exam_marker ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE college_exam_marker ADD COLUMN datedeleted DATETIME;

-- NTC Exam Completed
\! echo college_submission
ALTER TABLE ntc_exam_completed RENAME college_submission;
ALTER TABLE `college_submission` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE college_submission ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE college_submission ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE college_submission ADD COLUMN datedeleted DATETIME;
ALTER TABLE college_submission CHANGE bhg_id submitter INT(11) NOT NULL;
ALTER TABLE college_submission CHANGE is_graded graded INT(1) NOT NULL;
ALTER TABLE college_submission CHANGE has_passed passed INT(1) NOT NULL;
UPDATE college_submission SET datecreated = FROM_UNIXTIME(date_taken), dateupdated = FROM_UNIXTIME(date_taken);
ALTER TABLE college_submission DROP COLUMN date_taken;
UPDATE college_submission SET datedeleted = NOW() WHERE exam IN (SELECT id FROM college_exam WHERE datedeleted IS NOT NULL);

-- NTC Exam Answers
ALTER TABLE ntc_exam_answers RENAME college_submission_answer;
ALTER TABLE `college_submission_answer` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE college_submission_answer ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE college_submission_answer ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE college_submission_answer CHANGE result submission INT(11) NOT NULL;

-- Star Chart Object
\! echo starchart_object
CREATE TABLE `starchart_object` (
		`id` INT(11) NOT NULL auto_increment,
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`type` INT(11) NOT NULL,
		`typeextended` VARCHAR(250),
		`name` VARCHAR(200) NOT NULL,
		`description` TEXT NOT NULL,
		`picture` TEXT,
		`parent` INT(11),
		PRIMARY KEY(`id`)
		) TYPE = MyISAM, COLLATE = utf8_general_ci ;

-- Star Chart Attribute Type
\! echo starchart_attribute_type
CREATE TABLE `starchart_attribute_type` (
		`id` INT(11) NOT NULL auto_increment,
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`name` VARCHAR(200) NOT NULL,
		PRIMARY KEY(`id`)
		) TYPE = MyISAM, COLLATE = utf8_general_ci ;

-- Star Chart Object Type
\! echo starchart_object_type
CREATE TABLE `starchart_object_type` (
		`id` INT(11) NOT NULL auto_increment,
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`name` VARCHAR(200) NOT NULL,
		PRIMARY KEY(`id`)
		) TYPE = MyISAM, COLLATE = utf8_general_ci ;

-- Star Chart Object Attribute
\! echo starchart_object_attribute
CREATE TABLE `starchart_object_attribute` (
		`id` INT(11) NOT NULL auto_increment,
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`object` INT(11) NOT NULL,
		`type` INT(11) NOT NULL,
		`value` TEXT NOT NULL,
		PRIMARY KEY(`id`)
		) TYPE = MyISAM, COLLATE = utf8_general_ci ;

-- Star Chart Object Type Attribute
\! echo starchart_object_type_attribute
CREATE TABLE `starchart_object_type_attribute` (
		`id` INT(11) NOT NULL auto_increment,
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`type` INT(11) NOT NULL,
		`attribute` INT(11) NOT NULL,
		PRIMARY KEY(`id`)
		) TYPE = MyISAM, COLLATE = utf8_general_ci ;

INSERT INTO `starchart_object_type` VALUES 
  ( 1, NOW(), NOW(), NULL, 'Universe'),
	( 2, NOW(), NOW(), NULL, 'Star System'),
	( 3, NOW(), NOW(), NULL, 'Celestial Body'),
	( 4, NOW(), NOW(), NULL, 'Building'),
	( 5, NOW(), NOW(), NULL, 'Location'),
	( 6, NOW(), NOW(), NULL, 'Landmark'),
	( 7, NOW(), NOW(), NULL, 'Estate'),
	( 8, NOW(), NOW(), NULL, 'Headquarters'),
	( 9, NOW(), NOW(), NULL, 'Spaceship'),
	(10, NOW(), NOW(), NULL, 'Space Station');

INSERT INTO `starchart_attribute_type` VALUES
	( 1, NOW(), NOW(), NULL, 'Temperature'),
	( 2, NOW(), NOW(), NULL, 'Atmosphere'),
	( 3, NOW(), NOW(), NULL, 'Hydrosphere'),
	( 4, NOW(), NOW(), NULL, 'Gravity'),
	( 5, NOW(), NOW(), NULL, 'Terrain'),
	( 6, NOW(), NOW(), NULL, 'Day'),
	( 7, NOW(), NOW(), NULL, 'Year'),
	( 8, NOW(), NOW(), NULL, 'Species'),
	( 9, NOW(), NOW(), NULL, 'Starport'),
	(10, NOW(), NOW(), NULL, 'Population'),
	(11, NOW(), NOW(), NULL, 'Technology'),
	(12, NOW(), NOW(), NULL, 'Exports'),
	(13, NOW(), NOW(), NULL, 'Imports'),
	(14, NOW(), NOW(), NULL, 'Owner'),
	(15, NOW(), NOW(), NULL, 'Owner (Division)'),
	(16, NOW(), NOW(), NULL, 'Owner (Position)'),
	(17, NOW(), NOW(), NULL, 'Owner (Individual)'),
	(18, NOW(), NOW(), NULL, 'Orbit'),
	(19, NOW(), NOW(), NULL, 'Orbit Position'),
	(20, NOW(), NOW(), NULL, 'Location');

INSERT INTO `starchart_object_type_attribute` VALUES
	(NULL, NOW(), NOW(), NULL,  3,  1), (NULL, NOW(), NOW(), NULL,  3,  2), (NULL, NOW(), NOW(), NULL,  3,  3), (NULL, NOW(), NOW(), NULL,  3,  4),
	(NULL, NOW(), NOW(), NULL,  3,  5), (NULL, NOW(), NOW(), NULL,  3,  6), (NULL, NOW(), NOW(), NULL,  3,  7), (NULL, NOW(), NOW(), NULL,  3,  8),
	(NULL, NOW(), NOW(), NULL,  3,  9), (NULL, NOW(), NOW(), NULL,  3, 10), (NULL, NOW(), NOW(), NULL,  3, 11), (NULL, NOW(), NOW(), NULL,  3, 12),
	(NULL, NOW(), NOW(), NULL,  3, 13), (NULL, NOW(), NOW(), NULL,  3, 18), (NULL, NOW(), NOW(), NULL,  3, 19),

	(NULL, NOW(), NOW(), NULL,  4, 14), (NULL, NOW(), NOW(), NULL,  4, 15), (NULL, NOW(), NOW(), NULL,  4, 16), (NULL, NOW(), NOW(), NULL,  4, 17),
	(NULL, NOW(), NOW(), NULL,  4, 20),

	(NULL, NOW(), NOW(), NULL,  5, 14), (NULL, NOW(), NOW(), NULL,  5, 15), (NULL, NOW(), NOW(), NULL,  5, 16), (NULL, NOW(), NOW(), NULL,  5, 17),
	(NULL, NOW(), NOW(), NULL,  5, 20),

	(NULL, NOW(), NOW(), NULL,  6, 14), (NULL, NOW(), NOW(), NULL,  6, 15), (NULL, NOW(), NOW(), NULL,  6, 16), (NULL, NOW(), NOW(), NULL,  6, 17),
	(NULL, NOW(), NOW(), NULL,  6, 20),

	(NULL, NOW(), NOW(), NULL,  7, 14), (NULL, NOW(), NOW(), NULL,  7, 15), (NULL, NOW(), NOW(), NULL,  7, 16), (NULL, NOW(), NOW(), NULL,  7, 17),
	(NULL, NOW(), NOW(), NULL,  7, 20),

	(NULL, NOW(), NOW(), NULL,  8, 14), (NULL, NOW(), NOW(), NULL,  8, 15), (NULL, NOW(), NOW(), NULL,  8, 16), (NULL, NOW(), NOW(), NULL,  8, 17),
	(NULL, NOW(), NOW(), NULL,  8, 20),

	(NULL, NOW(), NOW(), NULL,  9, 14), (NULL, NOW(), NOW(), NULL,  9, 15), (NULL, NOW(), NOW(), NULL,  9, 16), (NULL, NOW(), NOW(), NULL,  9, 17),
	(NULL, NOW(), NOW(), NULL,  9, 20), (NULL, NOW(), NOW(), NULL,  9, 18), (NULL, NOW(), NOW(), NULL,  9, 19),

	(NULL, NOW(), NOW(), NULL, 10, 14), (NULL, NOW(), NOW(), NULL, 10, 15), (NULL, NOW(), NOW(), NULL, 10, 16), (NULL, NOW(), NOW(), NULL, 10, 17),
	(NULL, NOW(), NOW(), NULL, 10, 20), (NULL, NOW(), NOW(), NULL, 10, 18), (NULL, NOW(), NOW(), NULL, 10, 19);

COMMIT;
