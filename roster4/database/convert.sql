-- Roster Bio Data
ALTER TABLE roster_biographical_data ADD COLUMN date_created DATETIME NOT NULL;
ALTER TABLE roster_biographical_data ADD COLUMN date_updated DATETIME NOT NULL;
ALTER TABLE roster_biographical_data ADD COLUMN date_deleted DATETIME;
UPDATE roster_biographical_data SET date_created = NOW();
UPDATE roster_biographical_data SET date_updated = NOW();

-- Roster Black list
DROP TABLE roster_blacklist;

-- Roster Cadres
ALTER TABLE roster_cadres RENAME roster_cadre;
ALTER TABLE roster_cadre ADD COLUMN date_created_new DATETIME NOT NULL;
UPDATE roster_cadre SET date_created_new = FROM_UNIXTIME(date_created);
ALTER TABLE roster_cadre DROP COLUMN date_created;
ALTER TABLE roster_cadre CHANGE COLUMN date_created_new date_created DATETIME NOT NULL;

ALTER TABLE roster_cadre ADD COLUMN date_updated DATETIME NOT NULL;
UPDATE roster_cadre SET date_updated = NOW();

ALTER TABLE roster_cadre ADD COLUMN date_deleted_new DATETIME;
UPDATE roster_cadre SET date_deleted_new = FROM_UNIXTIME(date_deleted) WHERE date_deleted != 0;
UPDATE roster_cadre SET date_deleted_new = date_deleted WHERE date_deleted = 0;
ALTER TABLE roster_cadre DROP COLUMN date_deleted;
ALTER TABLE roster_cadre CHANGE COLUMN date_deleted_new date_deleted DATETIME;

-- Roster Division Categories
ALTER TABLE roster_division_categories RENAME roster_division_category;
ALTER TABLE roster_division_category ADD COLUMN date_created DATETIME NOT NULL;
ALTER TABLE roster_division_category ADD COLUMN date_updated DATETIME NOT NULL;
ALTER TABLE roster_division_category ADD COLUMN date_deleted DATETIME;
UPDATE roster_division_category SET date_created = NOW();
UPDATE roster_division_category SET date_updated = NOW();

-- Roster Divisions
ALTER TABLE roster_divisions RENAME roster_division;
ALTER TABLE roster_division ADD COLUMN date_created DATETIME NOT NULL;
ALTER TABLE roster_division ADD COLUMN date_updated DATETIME NOT NULL;
ALTER TABLE roster_division ADD COLUMN date_deleted DATETIME;
UPDATE roster_division SET date_created = NOW();
UPDATE roster_division SET date_updated = NOW();

-- Roster History
ALTER TABLE roster_history RENAME roster_history_event;
ALTER TABLE roster_history_event ADD COLUMN date_created DATETIME NOT NULL;
UPDATE roster_history_event SET date_created = FROM_UNIXTIME(`date`);
ALTER TABLE roster_history_event DROP COLUMN date;

-- Roster New Member
ALTER TABLE roster_new_members RENAME roster_new_member;
ALTER TABLE roster_new_member ADD COLUMN date_created DATETIME NOT NULL;
UPDATE roster_new_member SET date_created = NOW();

-- Roster Position
ALTER TABLE roster_position ADD COLUMN date_created DATETIME NOT NULL;
ALTER TABLE roster_position ADD COLUMN date_updated DATETIME NOT NULL;
ALTER TABLE roster_position ADD COLUMN date_deleted DATETIME;
UPDATE roster_position SET date_created = NOW(), date_updated = NOW();

-- Roster Rank
ALTER TABLE roster_rank ADD COLUMN date_created DATETIME NOT NULL;
ALTER TABLE roster_rank ADD COLUMN date_updated DATETIME NOT NULL;
ALTER TABLE roster_rank ADD COLUMN date_deleted DATETIME;
UPDATE roster_rank SET date_created = NOW(), date_updated = NOW();

-- Roster Person
ALTER TABLE roster_roster RENAME roster_person;
ALTER TABLE roster_person ADD COLUMN date_updated DATETIME NOT NULL;
ALTER TABLE roster_person ADD COLUMN date_deleted DATETIME;
UPDATE roster_person SET date_updated = last_updated;
UPDATE roster_person SET date_deleted = date_updated WHERE division = 16 AND rankcredits = 0;
ALTER TABLE roster_person DROP COLUMN last_updated;
ALTER TABLE roster_person ADD COLUMN date_created DATETIME NOT NULL;
UPDATE roster_person SET date_created = date_joined;
ALTER TABLE roster_person DROP COLUMN date_joined;
ALTER TABLE roster_person ADD COLUMN md5_password VARCHAR(32);

