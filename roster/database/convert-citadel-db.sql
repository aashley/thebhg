DROP TABLE IF EXISTS `thebhg_roster`.`ntc_exams`;
CREATE TABLE `thebhg_roster`.`ntc_exams` (
    `id` int( 11 ) NOT NULL auto_increment,
    `name` text NOT NULL ,
    `abbr` text NOT NULL ,
    `description` text NOT NULL ,
    `requirements` text NOT NULL ,
    `req_def` text NOT NULL ,
    `num_questions` int( 11 ) NOT NULL default '0',
    `passing_grade` double NOT NULL default '0',
    `credit_award` int( 11 ) NOT NULL default '0',
    `graded_by` int( 11 ) NOT NULL default '0',
    PRIMARY KEY ( `id` ) ,
    UNIQUE KEY `id` ( `id` )
    ) TYPE = MYISAM ;

INSERT INTO `thebhg_roster`.`ntc_exams`
SELECT *
FROM `thebhg_ntc`.`exams`;

DROP TABLE IF EXISTS `thebhg_roster`.`ntc_exam_completed`;
CREATE TABLE `thebhg_roster`.`ntc_exam_completed` (
    `id` int( 11 ) NOT NULL auto_increment,
    `bhg_id` int( 11 ) NOT NULL default '0',
    `exam` int( 11 ) NOT NULL default '0',
    `score` double NOT NULL default '0',
    `is_graded` int( 11 ) NOT NULL default '0',
    `date_taken` text NOT NULL ,
    PRIMARY KEY ( `id` ) ,
    UNIQUE KEY `id` ( `id` )
    ) TYPE = MYISAM ;

INSERT INTO `thebhg_roster`.`ntc_exam_completed` 
SELECT *
FROM `thebhg_ntc`.`exam_results`;

DROP TABLE IF EXISTS `thebhg_roster`.`ntc_exam_questions`;
CREATE TABLE `thebhg_roster`.`ntc_exam_questions` (
    `id` int( 11 ) NOT NULL auto_increment,
    `exam` int( 11 ) NOT NULL default '0',
    `question` text NOT NULL ,
    `weight` int( 11 ) NOT NULL default '1',
    PRIMARY KEY ( `id` ) ,
    UNIQUE KEY `id` ( `id` )
    ) TYPE = MYISAM ;

INSERT INTO `thebhg_roster`.`ntc_exam_questions`
SELECT *
FROM `thebhg_ntc`.`exam_questions`;

DROP TABLE IF EXISTS `thebhg_roster`.`ntc_exam_answers`;
CREATE TABLE `thebhg_roster`.`ntc_exam_answers` (
    `id` int( 11 ) NOT NULL auto_increment,
    `exam` int( 11 ) NOT NULL default '0',
    `result` int( 11 ) NOT NULL default '0',
    `question` int( 11 ) NOT NULL default '0',
    `answer` text NOT NULL ,
    `points` int( 11 ) NOT NULL default '0',
    `possible` int( 11 ) NOT NULL default '0',
    `comment` text NOT NULL ,
    PRIMARY KEY ( `id` ) ,
    UNIQUE KEY `id` ( `id` ) ,
    FULLTEXT KEY `answer` ( `answer` )
    ) TYPE = MYISAM ;

INSERT INTO `thebhg_roster`.`ntc_exam_answers`
SELECT *
FROM `thebhg_ntc`.`exam_answers`;

DROP TABLE IF EXISTS `thebhg_roster`.`ntc_exam_markers`;
CREATE TABLE `thebhg_roster`.`ntc_exam_markers` (
    `exam` INT( 10 ) UNSIGNED NOT NULL ,
    `marker` INT( 10 ) UNSIGNED NOT NULL ,
    PRIMARY KEY ( `exam` , `marker` )
    ) COMMENT = 'People that mark an exam';

INSERT INTO `thebhg_roster`.`ntc_exam_markers` 
SELECT `id`, `graded_by`
FROM `thebhg_roster`.`ntc_exams`;

ALTER TABLE `thebhg_roster`.`ntc_exams`
  DROP `requirements`,
  DROP `req_def`,
  DROP `graded_by`,
  ADD `notebook` INT( 10 ) UNSIGNED NOT NULL,
  ADD `date_deleted` DATETIME,
  ADD `medal_award` INT( 11 ) UNSIGNED NOT NULL AFTER `credit_award`;

UPDATE `thebhg_roster`.`ntc_exams`
SET `medal_award` = 49
WHERE `id` = 1;

ALTER TABLE `thebhg_roster`.`ntc_exam_completed` 
  ADD `has_passed` INT( 1 ) NOT NULL AFTER `is_graded`,
  CHANGE `date_taken` `date_taken` INT( 11 );

ALTER TABLE `thebhg_roster`.`ntc_exam_answers`
  DROP `exam`,
  DROP INDEX `answer`,
  CHANGE `points` `points` FLOAT( 11, 2 ) DEFAULT '0' NOT NULL ;

ALTER TABLE `thebhg_roster`.`ntc_exam_questions`
  ADD `answer` TEXT NOT NULL AFTER `question`,
  ADD `mandatory` INT( 1 ) NOT NULL,
  ADD `date_deleted` DATETIME,
  CHANGE `weight` `points` INT( 11 ) DEFAULT '1' NOT NULL;

UPDATE `thebhg_roster`.`ntc_exam_completed` 
SET `date_taken` = NULL
WHERE `date_taken` = 0;

UPDATE `thebhg_roster`.`ntc_exam_completed`
SET `is_graded` = 0
WHERE `is_graded` = -1;


