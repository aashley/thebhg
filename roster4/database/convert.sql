-- Code IDs
ALTER TABLE coders RENAME core_code;
ALTER TABLE core_code DROP COLUMN id;
ALTER TABLE core_code CHANGE md5 id CHAR(32) NOT NULL;
UPDATE core_code SET id = LOWER(id);
ALTER TABLE core_code ADD PRIMARY KEY (id);

-- Roster Bio Data
ALTER TABLE roster_biographical_data ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_biographical_data ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_biographical_data ADD COLUMN datedeleted DATETIME;
UPDATE roster_biographical_data SET datecreated = NOW(), dateupdated = NOW();
ALTER TABLE roster_biographical_data CHANGE image_url imageurl TEXT;

-- Roster Black list
DROP TABLE roster_blacklist;

-- Roster Cadres
ALTER TABLE roster_cadres RENAME roster_cadre;
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
ALTER TABLE roster_division_category ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_division_category ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_division_category ADD COLUMN datedeleted DATETIME;
UPDATE roster_division_category SET datecreated = NOW(), dateupdated = NOW();

-- Roster Divisions
ALTER TABLE roster_divisions RENAME roster_division;
ALTER TABLE roster_division ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_division ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_division ADD COLUMN datedeleted DATETIME;
UPDATE roster_division SET datecreated = NOW(), dateupdated = NOW();
UPDATE roster_division SET datedeleted = NOW() WHERE deleted = 1;
ALTER TABLE roster_division CHANGE home_page_url homepageurl VARCHAR(200);

-- Roster History
ALTER TABLE roster_history RENAME roster_history_event;
ALTER TABLE roster_history_event ADD COLUMN datecreated DATETIME NOT NULL;
UPDATE roster_history_event SET datecreated = FROM_UNIXTIME(`date`);
ALTER TABLE roster_history_event DROP COLUMN `date`;

-- Roster New Member
ALTER TABLE roster_new_members RENAME roster_new_member;
ALTER TABLE roster_new_member ADD COLUMN datecreated DATETIME NOT NULL;
UPDATE roster_new_member SET datecreated = NOW();

-- Roster Position
ALTER TABLE roster_position ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_position ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_position ADD COLUMN datedeleted DATETIME;
UPDATE roster_position SET datecreated = NOW(), dateupdated = NOW();
ALTER TABLE roster_position CHANGE special_division specialdivision TEXT NOT NULL;
ALTER TABLE roster_position CHANGE is_email_alias emailalias INT(1) NOT NULL;
ALTER TABLE roster_position CHANGE istrainee trainee INT(1) NOT NULL;

-- Roster Rank
ALTER TABLE roster_rank ADD COLUMN datecreated DATETIME NOT NULL;
ALTER TABLE roster_rank ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_rank ADD COLUMN datedeleted DATETIME;
UPDATE roster_rank SET datecreated = NOW(), dateupdated = NOW();
ALTER TABLE roster_rank CHANGE credits_needed requiredcredits INT(11) NOT NULL;
ALTER TABLE roster_rank CHANGE always_available alwaysavailable INT(1) NOT NULL;
ALTER TABLE roster_rank CHANGE unlimited_credits unlimitedcredits INT(1) NOT NULL;
ALTER TABLE roster_rank CHANGE manual_set manuallyset INT(1) NOT NULL;

-- Roster Person
ALTER TABLE roster_roster RENAME roster_person;
ALTER TABLE roster_person ADD COLUMN dateupdated DATETIME NOT NULL;
ALTER TABLE roster_person ADD COLUMN datedeleted DATETIME;
UPDATE roster_person SET dateupdated = last_updated;
UPDATE roster_person SET datedeleted = dateupdated WHERE division = 16 AND rankcredits = 0;
ALTER TABLE roster_person DROP COLUMN last_updated;
ALTER TABLE roster_person ADD COLUMN datecreated DATETIME NOT NULL;
UPDATE roster_person SET datecreated = date_joined;
ALTER TABLE roster_person DROP COLUMN date_joined;
ALTER TABLE roster_person ADD COLUMN md5Password VARCHAR(32);
ALTER TABLE roster_person CHANGE previous_division previousdivision INT(4);
ALTER TABLE roster_person CHANGE completed_ntc_exam completedcoreexam INT(1) NOT NULL;
ALTER TABLE roster_person CHANGE redo_ranks redoranks INT(1) NOT NULL;
ALTER TABLE roster_person CHANGE hasship ship INT(1) NOT NULL;
