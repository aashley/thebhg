BEGIN;

-- Code IDs
ALTER TABLE coders RENAME core_code;
ALTER TABLE core_code DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE core_code CHANGE md5 hash CHAR(32) NOT NULL;
UPDATE core_code SET hash = LOWER(hash);
ALTER TABLE core_code ADD UNIQUE KEY(hash);

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

-- Roster Bio Data
ALTER TABLE `roster_biographical_data` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_biographical_data ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_biographical_data ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_biographical_data ADD COLUMN datedeleted DATETIME;
UPDATE roster_biographical_data SET datecreated = NOW(), dateupdated = NOW();
ALTER TABLE roster_biographical_data CHANGE image_url imageurl TEXT;

-- Roster Black list
DROP TABLE roster_blacklist;

-- Roster Cadres
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
ALTER TABLE roster_division_categories RENAME roster_division_category;
ALTER TABLE `roster_division_category` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_division_category ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_division_category ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_division_category ADD COLUMN datedeleted DATETIME;
ALTER TABLE roster_division_category CHANGE haskabals kabals INT(1);
UPDATE roster_division_category SET datecreated = NOW(), dateupdated = NOW();
ALTER TABLE roster_division_category CHANGE `order` sortorder INT(4) NOT NULL;

-- Roster Divisions
ALTER TABLE roster_divisions RENAME roster_division;
ALTER TABLE `roster_division` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_division ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_division ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_division ADD COLUMN datedeleted DATETIME;
UPDATE roster_division SET datecreated = NOW(), dateupdated = NOW();
UPDATE roster_division SET datedeleted = NOW() WHERE deleted = 1;
ALTER TABLE roster_division CHANGE home_page_url homepageurl VARCHAR(200);

-- Roster History
ALTER TABLE roster_history RENAME history_event;
ALTER TABLE `history_event` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE history_event ADD COLUMN datecreated DATETIME NOT NULL;
UPDATE history_event SET datecreated = FROM_UNIXTIME(`date`);
ALTER TABLE history_event DROP COLUMN `date`;
ALTER TABLE history_event ADD COLUMN item4 VARCHAR(250);

-- Roster New Member
ALTER TABLE roster_new_members RENAME roster_new_person;
ALTER TABLE `roster_new_person` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE roster_new_person ADD COLUMN datecreated DATETIME NOT NULL;
UPDATE roster_new_person SET datecreated = NOW();

-- Roster Position
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


-- MedalBoard Awarded Medals
ALTER TABLE mb_awarded_medals RENAME medalboard_award;
ALTER TABLE `medalboard_award` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE medalboard_award ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE medalboard_award ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE medalboard_award CHANGE recipientid recipient INT(11) NOT NULL;
ALTER TABLE medalboard_award CHANGE awarderid awarder INT(11) NOT NULL;
UPDATE medalboard_award SET datecreated = FROM_UNIXTIME(`date`), dateupdated = FROM_UNIXTIME(`date`);
ALTER TABLE medalboard_award DROP COLUMN `date`;
ALTER TABLE `medalboard_award` CHANGE `why` `why` TEXT NOT NULL;

-- MedalBoard Medal Categories
ALTER TABLE mb_medal_categories RENAME medalboard_category;
ALTER TABLE `medalboard_category` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE medalboard_category ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE medalboard_category ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE medalboard_category ADD COLUMN datedeleted DATETIME;
ALTER TABLE medalboard_category CHANGE `order` sortorder INT(4) NOT NULL;

-- MedalBoard Medal Groups
ALTER TABLE mb_medal_groups RENAME medalboard_group;
ALTER TABLE `medalboard_group` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE medalboard_group ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE medalboard_group ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE medalboard_group ADD COLUMN datedeleted DATETIME;
ALTER TABLE medalboard_group CHANGE `order` sortorder INT(4) NOT NULL;
ALTER TABLE medalboard_group ADD COLUMN html LONGTEXT;
UPDATE medalboard_group,mb_medal_descriptions SET medalboard_group.html = mb_medal_descriptions.html WHERE medalboard_group.id = mb_medal_descriptions.group;
DROP TABLE mb_medal_descriptions;

-- MedalBoard Medal Names
ALTER TABLE mb_medal_names RENAME medalboard_medal;
ALTER TABLE `medalboard_medal` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE medalboard_medal ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE medalboard_medal ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE medalboard_medal ADD COLUMN datedeleted DATETIME;
ALTER TABLE medalboard_medal CHANGE `order` sortorder INT(4) NOT NULL;

-- Library Books
ALTER TABLE library_books RENAME library_book;
ALTER TABLE `library_book` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE library_book ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE library_book ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE library_book ADD COLUMN datedeleted DATETIME;
ALTER TABLE library_book CHANGE image_type imagetype TEXT;

-- Library Chapters
ALTER TABLE library_chapters RENAME library_chapter;
ALTER TABLE `library_chapter` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE library_chapter ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE library_chapter ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE library_chapter ADD COLUMN datedeleted DATETIME;
ALTER TABLE library_chapter CHANGE sort_order sortorder INT(11) NOT NULL;

-- Library Moderators
ALTER TABLE library_moderators RENAME library_moderator;
ALTER TABLE `library_moderator` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE library_moderator ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE library_moderator ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE library_moderator ADD COLUMN datedeleted DATETIME;

-- Library Sections
ALTER TABLE library_sections RENAME library_section;
ALTER TABLE `library_section` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE library_section ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE library_section ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE library_section ADD COLUMN datedeleted DATETIME;
ALTER TABLE library_section CHANGE sort_order sortorder INT(11) NOT NULL;
ALTER TABLE library_section CHANGE useHTML html INT(1) NOT NULL;

-- Library Shelves
ALTER TABLE library_shelves RENAME library_shelf;
ALTER TABLE `library_shelf` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE library_shelf ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE library_shelf ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE library_shelf ADD COLUMN datedeleted DATETIME;
ALTER TABLE library_shelf CHANGE sort_order sortorder INT(11) NOT NULL;

-- Newsboard
ALTER TABLE newsboard RENAME news_item;
ALTER TABLE `news_item` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE news_item ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE news_item ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE news_item ADD COLUMN datedeleted DATETIME;
UPDATE news_item SET datecreated = FROM_UNIXTIME(`timestamp`);
ALTER TABLE news_item DROP COLUMN `timestamp`;

CREATE TABLE `college_reward` (
		`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`exam` INT UNSIGNED NOT NULL ,
		`rewardtype` ENUM( 'credit', 'medal' ) NOT NULL ,
		`requiredscore` DOUBLE NOT NULL ,
		`award` INT NOT NULL ,
		`description` STRING,
		PRIMARY KEY ( `id` ) ,
		INDEX ( `exam` )
		) TYPE = MYISAM, COLLATE = utf8_general_ci ;

INSERT INTO `college_reward` (datecreated, dateupdated, exam, rewardtype, requiredscore, award) SELECT NOW(), NOW(), id, 'credit', passing_grade, credit_award FROM ntc_exams WHERE credit_award != 0;
INSERT INTO `college_reward` (datecreated, dateupdated, exam, rewardtype, requiredscore, award) SELECT NOW(), NOW(), id, 'medal', 100, medal_award FROM ntc_exams WHERE medal_award != 0;

-- NTC Exams
ALTER TABLE ntc_exams RENAME college_exam;
ALTER TABLE `college_exam` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE college_exam ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE college_exam ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE college_exam CHANGE date_deleted datedeleted DATETIME;
ALTER TABLE college_exam CHANGE num_questions numberofquestions INT(11) NOT NULL;
ALTER TABLE college_exam CHANGE passing_grade passinggrade DOUBLE NOT NULL;
ALTER TABLE college_exam DROP COLUMN medal_award;
ALTER TABLE college_exam DROP COLUMN credit_award;

-- NTC Questions
ALTER TABLE ntc_exam_questions RENAME college_exam_question;
ALTER TABLE `college_exam_question` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE college_exam_question ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE college_exam_question ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE college_exam_question CHANGE date_deleted datedeleted DATETIME;

-- NTC Exam Markers
ALTER TABLE ntc_exam_markers RENAME college_exam_marker;
ALTER TABLE `college_exam_marker` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE college_exam_marker ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE college_exam_marker ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE college_exam_marker ADD COLUMN datedeleted DATETIME;

-- NTC Exam Completed
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

-- Start Chart System
CREATE TABLE `starchart_system` (
		`id` INT(11) NOT NULL auto_increment,
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`name` TEXT NOT NULL,
		`description` TEXT NOT NULL,
		PRIMARY KEY(`id`)
		) TYPE = MyISAM, COLLATE = utf8_general_ci ;

INSERT INTO starchart_system (name, datecreated, dateupdated, datedeleted, description) VALUES ('Lyarna', NOW(), NOW(), NULL, 'The Lyarna system. Home to the BHG');

-- Lyarna planets
CREATE TABLE `starchart_planet` (
		`id` int(11) NOT NULL auto_increment,
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`system` INT(11) NOT NULL,
		`name` text NOT NULL,
		`picture` text NOT NULL,
		`type` text NOT NULL,
		`temperature` text NOT NULL,
		`atmosphere` text NOT NULL,
		`hydrosphere` text NOT NULL,
		`gravity` text NOT NULL,
		`terrain` text NOT NULL,
		`day` text NOT NULL,
		`year` text NOT NULL,
		`species` text NOT NULL,
		`starport` text NOT NULL,
		`population` text NOT NULL,
		`technology` text NOT NULL,
		`exports` text NOT NULL,
		`imports` text NOT NULL,
		`misc` text NOT NULL,
		PRIMARY KEY  (`id`)
		) TYPE=MyISAM, COLLATE = utf8_general_ci;

INSERT INTO starchart_planet SELECT `id`, NOW(), NOW(), NULL, 1, `name`, `pic`, `type`, `temp`, `atmo`, `hydro`, `gravity`, `terrain`, `day`, `year`, `species`, `starport`, `pop`, `tech`, `exp`, `imp`, `misc` FROM thebhg_lyarna.planets;

-- Lyarna Sites
CREATE TABLE `starchart_site` (
		`id` int(11) NOT NULL auto_increment,
		`datecreated` DATETIME NOT NULL,
		`dateupdated` DATETIME NOT NULL,
		`datedeleted` DATETIME,
		`sitetype` ENUM('complex', 'estate', 'headquarters', 'other', 'personal') NOT NULL DEFAULT 'complex',
		`planet` int(11) NOT NULL default '0',
		`name` text NOT NULL,
		`misc` text NOT NULL,
		`pic` text NOT NULL,
		`owner` text NOT NULL,
		`location` text NOT NULL,
		`type` text NOT NULL,
		`arena` smallint(6) NOT NULL default '0',
		`position` int(11) NOT NULL default '0',
		`division` int(11) NOT NULL default '0',
		`person` int(11) NOT NULL default '0',
		PRIMARY KEY  (`id`)
		) TYPE=MyISAM, COLLATE = utf8_general_ci;

INSERT INTO starchart_site SELECT NULL, NOW(), NOW(), NULL, 'complex', `planet`, `name`, `misc`, `pic`, `owner`, `location`, `type`, `arena`, `position`, `division`, `bhg_id` FROM thebhg_lyarna.complex;
INSERT INTO starchart_site SELECT NULL, NOW(), NOW(), NULL, 'estate', `planet`, `name`, `misc`, `pic`, `owner`, `location`, `type`, `arena`, `position`, `division`, `bhg_id` FROM thebhg_lyarna.estate;
INSERT INTO starchart_site SELECT NULL, NOW(), NOW(), NULL, 'headquarters', `planet`, `name`, `misc`, `pic`, `owner`, `location`, `type`, `arena`, `position`, `division`, `bhg_id` FROM thebhg_lyarna.hq;
INSERT INTO starchart_site SELECT NULL, NOW(), NOW(), NULL, 'other', `planet`, `name`, `misc`, `pic`, `owner`, `location`, `type`, `arena`, `position`, `division`, `bhg_id` FROM thebhg_lyarna.other;
INSERT INTO starchart_site SELECT NULL, NOW(), NOW(), NULL, 'personal', `planet`, `name`, `misc`, `pic`, `owner`, `location`, `type`, `arena`, `position`, `division`, `bhg_id` FROM thebhg_lyarna.personal;

COMMIT;
