CREATE TABLE amaxoop_lite2_conf (
	RecID		mediumint unsigned	NOT NULL auto_increment,
	BlockID		tinyint				NOT NULL default 0,
	cfgname		varchar(32)			NOT NULL default '',
	cfgvalue	varchar(254)		NOT NULL default '',
	PRIMARY KEY  (RecID)
) TYPE=MyISAM;

CREATE TABLE amaxoop_lite2_items (
	RecID				mediumint unsigned NOT NULL auto_increment,
	BlockID				tinyint NOT NULL default 0,
	ASIN				char(16) NOT NULL,
	Title				text,
	SmallImageURL		text NOT NULL default '',
	SmallImageHeight	mediumint unsigned,
	SmallImageWidth		mediumint unsigned,
	MediumImageURL		text NOT NULL default '',
	MediumImageHeight	mediumint unsigned,
	MediumImageWidth	mediumint unsigned,
	AverageRating		decimal(4,2),
	RatingImageURL		text NOT NULL default '',
	Authors				text NOT NULL default '',
	Manufacturer		text NOT NULL default '',
	ProductGroup		varchar(255),
	Attribute1			varchar(254),
	Attribute2			text,
	EditorialReview		text NOT NULL default '',
	PRIMARY KEY (RecID)
) TYPE=MyISAM;

INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (0, 'AssID',	'amaxoop-1-22');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (0, 'SubID',	'0EKVYRPBK0HDA1DP3EG2');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (1, 'Titles',	'3');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (1, 'ASIN',	'');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (1, 'YMD',	'----/--/--');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (2, 'Titles',	'3');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (2, 'ASIN',	'');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (2, 'YMD',	'----/--/--');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (3, 'Titles',	'3');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (3, 'ASIN',	'');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (3, 'YMD',	'----/--/--');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (4, 'Titles',	'3');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (4, 'ASIN',	'');
INSERT INTO amaxoop_lite2_conf (BlockID, cfgname, cfgvalue) VALUES (4, 'YMD',	'----/--/--');
