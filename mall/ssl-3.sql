# phpMyAdmin MySQL-Dump
# version 2.3.0
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Oct 26, 2002 at 10:57 AM
# Server version: 3.23.41
# PHP Version: 4.2.2
# Database : `thebhg_lawngnome`
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

#
# Dumping data for table `ssl_auctions`
#

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

#
# Dumping data for table `ssl_bays`
#

INSERT INTO `ssl_bays` VALUES (1, 'Habitation Bay', 'Where you live, breathe, and eat. A good hunter never sleeps, because sleep is for the... zzzzzzzzzzz.', 0);
INSERT INTO `ssl_bays` VALUES (2, 'Cargo Bay', 'A place to throw those knick-knacks you pick up on missions, like spare heads.', 0);
INSERT INTO `ssl_bays` VALUES (3, 'Engine Bay', 'This would be where the engines go. Engines must go in here as this bay is specially reinforced to cope with the forces exerted on it.', 1);
INSERT INTO `ssl_bays` VALUES (4, 'Thruster Bay', 'For those occasions when you don\\\'t want to go in a straight line.', 1);
INSERT INTO `ssl_bays` VALUES (5, 'Weapons Bay', 'A weapons bay is a bay designed for laser and ion cannons, among other things. You might be able to fit a warhead launcher and a couple of warheads in, but that\\\'s not really what this bay is designed for.', 1);
INSERT INTO `ssl_bays` VALUES (6, 'Torpedo Bay', 'A larger version of the weapons bay. Torpedoes or missiles must be in the same bay as the launcher they are to be launched from.', 1);
INSERT INTO `ssl_bays` VALUES (7, 'Avionics Bay', 'A bay designed for delicate equipment with high power requirements, such as computers and sensors.', 0);
INSERT INTO `ssl_bays` VALUES (8, 'General Equipment Bay', 'For things that require external access but don\\\'t fit in anywhere else.', 1);
INSERT INTO `ssl_bays` VALUES (9, 'Armour Bay', 'A place to lock down your hull plating. Or exterior carpeting.', 1);
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

#
# Dumping data for table `ssl_bids`
#

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

#
# Dumping data for table `ssl_faq`
#

INSERT INTO `ssl_faq` VALUES (5, 6, 'What is this thing with all the questions?', 'It’s the Frequently Asked Questions section of the SSL. Its primary purpose is to stop the Tactician from getting cranky with silly questions being asked of him/her on a regular basis.', 0);
INSERT INTO `ssl_faq` VALUES (6, 6, 'Tell me more about this document. (Also known as the Credits.)', 'This is version 3.00 of the SSL FAQ, as written by Jernai Teifsel. It’s based on the SSL FAQ 0.90 which was compiled by then-Tactician Vesuvo Tharen, with help from Xythian, Minerva Ramirez, Zedder Netzach, Mark Drackson, and SithRage.', 5);
INSERT INTO `ssl_faq` VALUES (7, 7, 'What is the XOC?', 'The XOC is the portal for the SSL and all of its subdivisions.', 0);
INSERT INTO `ssl_faq` VALUES (8, 7, 'What subdivisions are there?', 'Such a list would quickly get out of date, the easiest way to find out is to simply look at the XOC’s main page.', 7);
INSERT INTO `ssl_faq` VALUES (9, 7, 'Can I suggest a subdivision?', 'Yes, by e-mailing the Tactician with your idea. We advise against starting to put together a database until the Tactician has approved your idea, as you will only be paid if your idea is accepted.', 7);
INSERT INTO `ssl_faq` VALUES (10, 7, 'Do all the subdivisions work in the same way?', 'Generally, yes. Any quirks particular to a subdivision will be detailed in the subdivision’s FAQ.', 9);
INSERT INTO `ssl_faq` VALUES (11, 8, 'What is the SSL? What does it stand for?', 'SSL stands for Stalker Shipyards Limited. The SSL is the official shipyards of the Bounty Hunter’s Guild, specialising in the sale of ships and parts for these ships.', 0);
INSERT INTO `ssl_faq` VALUES (12, 8, 'What in Slice’s name is a Tactition?', 'The Tactician (note the spelling), or TACT, is the head of all SSL operations, among other things.', 11);
INSERT INTO `ssl_faq` VALUES (13, 9, 'What are the different kinds of ships?', 'At the moment, the SSL offers fighters, transports, freighters, hybrids, and Special Edition ships.', 0);
INSERT INTO `ssl_faq` VALUES (14, 9, 'What are the differences between the different kinds of ships?', 'The easiest way to find out is to look at the ship catalogue, but here’s a quick guide:\r\n\r\nFighters: Small, usually one-man, ships used to fight other fighters. Some fighters can also be used to launch attacks on capital ships, but it’s not generally recommended unless you have backup or know exactly what you’re doing. Fighters are usually best-suited to short and medium range operations.\r\n\r\nTransports: These ships are usually weighted towards carrying groups of people over reasonably long distances. Some higher-end transports can also make decent combat craft in their own right, but it’s not really their primary purpose.\r\n\r\nFreighters: Freighters are designed to carry large amounts of cargo. Like transports, these ships tend to be designed and built for long-range trips. Although they tend to be slower and less manoeuvrable than the other ship types, freighters have the advantage that they are considerably more modifiable than other ships, meaning that you can really do anything from build a fast but lightly-armed long-range ship to a well-armed ship capable of mixing it up with Corvettes and larger capital ships.\r\n\r\nHybrids: These ships attempt to combine the best aspects of the above three types. Sometimes the sacrifices made to get the best of both worlds make the ships not particularly well suited to anything, other times they can be a positive bargain.\r\n\r\nSpecial Editions: A special edition ship is something for the richer hunters to have, and for the less rich hunters to gawk at in envy and naked jealousy. These ships are expensive and limited in number, but tend to be the best of their class.\r\n', 13);
INSERT INTO `ssl_faq` VALUES (15, 9, 'What is the best ship?', 'It depends entirely on what you want to do with it. Expensive isn’t always better, though.', 14);
INSERT INTO `ssl_faq` VALUES (16, 9, 'Why don’t you sell warships?', 'At present, we are not permitted to sell capital ships due to Emperor’s Hammer regulations. Also, hiring a crew for a warship is beyond the finances of virtually all the hunters in the Guild.', 15);
INSERT INTO `ssl_faq` VALUES (17, 9, 'What are the ships used for?', 'BHG ships are generally used in fiction pieces, and role-playing. There’s currently no facility to “fight” with another BHG member using your ships.', 16);
INSERT INTO `ssl_faq` VALUES (18, 9, 'What is the difference between a hull and a ship?', 'A hull is just that: a bare hull, which you can fit out however you like. A hull comes with no parts of any kind: no power, no engines, no weapons. A ship, however, comes with enough parts to allow you to fly it straightaway, although there’s usually some room for further expansion. This all comes at increased cost, of course.\r\n\r\nGenerally, if you’re looking for your first ship, we recommend buying a ready-to-fly ship, but experienced hunters tend to prefer to buy a bare hull and build it up from there.\r\n', 17);
INSERT INTO `ssl_faq` VALUES (19, 9, 'Can I suggest a new ship?', 'Absolutely. E-mail the ship’s stats, description, and a picture to the Tactician.', 18);
INSERT INTO `ssl_faq` VALUES (20, 10, 'Can I buy a ship with no credits? Please?!', 'No. That would defeat the entire purpose of the credit system. It’s exceptionally easy to make credits in the BHG now anyway.', 0);
INSERT INTO `ssl_faq` VALUES (21, 10, 'Can I get a loan to buy a ship or part if I know I’ll have the money soon?', 'No. You must have the credits required in your account in order to buy an item from the SSL.', 20);
INSERT INTO `ssl_faq` VALUES (22, 10, 'Can I give a ship as a gift to someone else?', 'You can. All you need to do is buy the ship yourself (and add any parts you want to add to it), and then edit the ship. On that page, you can choose the new owner and transfer it that way.', 21);
INSERT INTO `ssl_faq` VALUES (23, 10, 'Can I return parts and get a refund?', 'Yes. Go to the ship editing page, and click on the Delete link.', 22);
INSERT INTO `ssl_faq` VALUES (24, 11, 'How do I put a ship up for auction?', 'Go to the ship information page, click on “Auction This Ship”, and fill in the required information.', 0);
INSERT INTO `ssl_faq` VALUES (25, 11, 'Why can’t I start an auction running an unlimited length of time?', 'This option was abused in the previous version of the SSL and has been removed.', 24);
INSERT INTO `ssl_faq` VALUES (26, 11, 'Can I place a bid for more credits than I have?', 'You can, but the owner of the ship will not be able to accept your bid if you haven’t gained the required number of credits by the end of the auction.', 25);
INSERT INTO `ssl_faq` VALUES (27, 11, 'I had a ship up for auction, but now it’s disappeared!', 'Ships are automatically withdrawn from auction if a bid is not accepted within a week of the auction closing.', 26);
INSERT INTO `ssl_faq` VALUES (28, 12, 'Who designed this web site?', 'This web site was designed by Lord Oxxider.', 0);
INSERT INTO `ssl_faq` VALUES (29, 12, 'You can’t spell “catalog”!', 'Actually, I can. It’s just that the US can’t.', 28);
INSERT INTO `ssl_faq` VALUES (30, 12, 'What do I do if I find a bug?', 'Report it on the BHG Bug Tracker <http://bugs.thebhg.org> under the SSL 3 module.', 29);
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

#
# Dumping data for table `ssl_faq_sections`
#

INSERT INTO `ssl_faq_sections` VALUES (6, 'Introduction', 0);
INSERT INTO `ssl_faq_sections` VALUES (7, 'Xerokine Outlet Centre', 6);
INSERT INTO `ssl_faq_sections` VALUES (8, 'General SSL Questions', 7);
INSERT INTO `ssl_faq_sections` VALUES (9, 'Ships', 8);
INSERT INTO `ssl_faq_sections` VALUES (10, 'Purchases and Exchanges', 9);
INSERT INTO `ssl_faq_sections` VALUES (11, 'The Junkyard', 10);
INSERT INTO `ssl_faq_sections` VALUES (12, 'SSL Web Site', 11);
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

#
# Dumping data for table `ssl_history`
#

INSERT INTO `ssl_history` VALUES (1, 1035624871, 2, 1000, 3, 'Testmobile', '0');
INSERT INTO `ssl_history` VALUES (2, 1035638885, 2, 666, 4, 'Template', '0');
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

#
# Dumping data for table `ssl_hull_bays`
#

INSERT INTO `ssl_hull_bays` VALUES (1, 1, 3, 200);
INSERT INTO `ssl_hull_bays` VALUES (2, 1, 5, 40);
INSERT INTO `ssl_hull_bays` VALUES (3, 1, 7, 50);
INSERT INTO `ssl_hull_bays` VALUES (4, 1, 8, 60);
INSERT INTO `ssl_hull_bays` VALUES (5, 1, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (6, 1, 1, 25);
INSERT INTO `ssl_hull_bays` VALUES (7, 3, 9, 100);
INSERT INTO `ssl_hull_bays` VALUES (8, 3, 7, 80);
INSERT INTO `ssl_hull_bays` VALUES (9, 3, 2, 50);
INSERT INTO `ssl_hull_bays` VALUES (10, 3, 3, 400);
INSERT INTO `ssl_hull_bays` VALUES (11, 3, 8, 100);
INSERT INTO `ssl_hull_bays` VALUES (12, 3, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (13, 5, 3, 630);
INSERT INTO `ssl_hull_bays` VALUES (14, 5, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (15, 5, 7, 70);
INSERT INTO `ssl_hull_bays` VALUES (16, 5, 6, 80);
INSERT INTO `ssl_hull_bays` VALUES (17, 5, 5, 520);
INSERT INTO `ssl_hull_bays` VALUES (18, 5, 5, 200);
INSERT INTO `ssl_hull_bays` VALUES (19, 5, 8, 1200);
INSERT INTO `ssl_hull_bays` VALUES (20, 5, 1, 100);
INSERT INTO `ssl_hull_bays` VALUES (21, 3, 5, 60);
INSERT INTO `ssl_hull_bays` VALUES (22, 3, 5, 60);
INSERT INTO `ssl_hull_bays` VALUES (23, 3, 6, 120);
INSERT INTO `ssl_hull_bays` VALUES (24, 2, 9, 100);
INSERT INTO `ssl_hull_bays` VALUES (25, 2, 7, 70);
INSERT INTO `ssl_hull_bays` VALUES (26, 2, 8, 90);
INSERT INTO `ssl_hull_bays` VALUES (27, 2, 3, 300);
INSERT INTO `ssl_hull_bays` VALUES (28, 2, 1, 40);
INSERT INTO `ssl_hull_bays` VALUES (29, 2, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (30, 2, 6, 95);
INSERT INTO `ssl_hull_bays` VALUES (31, 2, 5, 80);
INSERT INTO `ssl_hull_bays` VALUES (32, 4, 3, 450);
INSERT INTO `ssl_hull_bays` VALUES (33, 4, 9, 100);
INSERT INTO `ssl_hull_bays` VALUES (34, 4, 7, 100);
INSERT INTO `ssl_hull_bays` VALUES (35, 4, 2, 50);
INSERT INTO `ssl_hull_bays` VALUES (36, 4, 1, 50);
INSERT INTO `ssl_hull_bays` VALUES (37, 4, 8, 150);
INSERT INTO `ssl_hull_bays` VALUES (38, 4, 4, 60);
INSERT INTO `ssl_hull_bays` VALUES (39, 4, 6, 80);
INSERT INTO `ssl_hull_bays` VALUES (40, 4, 6, 80);
INSERT INTO `ssl_hull_bays` VALUES (41, 4, 6, 80);
INSERT INTO `ssl_hull_bays` VALUES (42, 4, 6, 80);
INSERT INTO `ssl_hull_bays` VALUES (43, 4, 6, 80);
INSERT INTO `ssl_hull_bays` VALUES (44, 4, 6, 80);
INSERT INTO `ssl_hull_bays` VALUES (45, 4, 5, 40);
INSERT INTO `ssl_hull_bays` VALUES (46, 4, 5, 50);
INSERT INTO `ssl_hull_bays` VALUES (47, 4, 5, 50);
INSERT INTO `ssl_hull_bays` VALUES (48, 4, 5, 40);
INSERT INTO `ssl_hull_bays` VALUES (49, 6, 9, 100);
INSERT INTO `ssl_hull_bays` VALUES (50, 6, 7, 70);
INSERT INTO `ssl_hull_bays` VALUES (51, 6, 8, 70);
INSERT INTO `ssl_hull_bays` VALUES (52, 6, 3, 330);
INSERT INTO `ssl_hull_bays` VALUES (53, 6, 1, 20);
INSERT INTO `ssl_hull_bays` VALUES (54, 6, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (55, 6, 6, 60);
INSERT INTO `ssl_hull_bays` VALUES (56, 6, 5, 40);
INSERT INTO `ssl_hull_bays` VALUES (57, 8, 9, 100);
INSERT INTO `ssl_hull_bays` VALUES (58, 8, 7, 80);
INSERT INTO `ssl_hull_bays` VALUES (59, 8, 2, 60);
INSERT INTO `ssl_hull_bays` VALUES (60, 8, 3, 290);
INSERT INTO `ssl_hull_bays` VALUES (61, 8, 8, 125);
INSERT INTO `ssl_hull_bays` VALUES (62, 8, 1, 50);
INSERT INTO `ssl_hull_bays` VALUES (63, 8, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (64, 8, 6, 70);
INSERT INTO `ssl_hull_bays` VALUES (65, 8, 5, 40);
INSERT INTO `ssl_hull_bays` VALUES (66, 8, 5, 60);
INSERT INTO `ssl_hull_bays` VALUES (67, 7, 7, 50);
INSERT INTO `ssl_hull_bays` VALUES (68, 7, 3, 300);
INSERT INTO `ssl_hull_bays` VALUES (69, 7, 8, 50);
INSERT INTO `ssl_hull_bays` VALUES (70, 7, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (71, 7, 6, 60);
INSERT INTO `ssl_hull_bays` VALUES (72, 7, 5, 40);
INSERT INTO `ssl_hull_bays` VALUES (73, 9, 9, 100);
INSERT INTO `ssl_hull_bays` VALUES (74, 9, 7, 100);
INSERT INTO `ssl_hull_bays` VALUES (75, 9, 2, 800);
INSERT INTO `ssl_hull_bays` VALUES (76, 9, 3, 200);
INSERT INTO `ssl_hull_bays` VALUES (77, 9, 8, 400);
INSERT INTO `ssl_hull_bays` VALUES (78, 9, 1, 150);
INSERT INTO `ssl_hull_bays` VALUES (79, 9, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (80, 10, 9, 100);
INSERT INTO `ssl_hull_bays` VALUES (81, 10, 7, 80);
INSERT INTO `ssl_hull_bays` VALUES (82, 10, 2, 120);
INSERT INTO `ssl_hull_bays` VALUES (83, 10, 3, 330);
INSERT INTO `ssl_hull_bays` VALUES (84, 10, 8, 60);
INSERT INTO `ssl_hull_bays` VALUES (85, 10, 1, 120);
INSERT INTO `ssl_hull_bays` VALUES (86, 10, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (87, 10, 5, 20);
INSERT INTO `ssl_hull_bays` VALUES (88, 11, 9, 100);
INSERT INTO `ssl_hull_bays` VALUES (89, 11, 7, 80);
INSERT INTO `ssl_hull_bays` VALUES (90, 11, 2, 160);
INSERT INTO `ssl_hull_bays` VALUES (91, 11, 3, 200);
INSERT INTO `ssl_hull_bays` VALUES (92, 11, 8, 80);
INSERT INTO `ssl_hull_bays` VALUES (93, 11, 1, 150);
INSERT INTO `ssl_hull_bays` VALUES (94, 11, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (95, 11, 5, 40);
INSERT INTO `ssl_hull_bays` VALUES (96, 11, 6, 80);
INSERT INTO `ssl_hull_bays` VALUES (97, 12, 7, 80);
INSERT INTO `ssl_hull_bays` VALUES (98, 12, 3, 250);
INSERT INTO `ssl_hull_bays` VALUES (99, 12, 8, 200);
INSERT INTO `ssl_hull_bays` VALUES (100, 12, 1, 200);
INSERT INTO `ssl_hull_bays` VALUES (101, 12, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (102, 12, 5, 80);
INSERT INTO `ssl_hull_bays` VALUES (103, 12, 5, 60);
INSERT INTO `ssl_hull_bays` VALUES (104, 13, 9, 100);
INSERT INTO `ssl_hull_bays` VALUES (105, 13, 7, 80);
INSERT INTO `ssl_hull_bays` VALUES (106, 13, 3, 230);
INSERT INTO `ssl_hull_bays` VALUES (107, 13, 8, 300);
INSERT INTO `ssl_hull_bays` VALUES (108, 13, 1, 250);
INSERT INTO `ssl_hull_bays` VALUES (109, 13, 4, 30);
INSERT INTO `ssl_hull_bays` VALUES (110, 13, 6, 80);
INSERT INTO `ssl_hull_bays` VALUES (111, 13, 5, 40);
INSERT INTO `ssl_hull_bays` VALUES (112, 13, 5, 80);
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

#
# Dumping data for table `ssl_items`
#

INSERT INTO `ssl_items` VALUES (1, 1, 'Muskrat Patrol Craft', 5000, 8, 20, 0, -1, -1, 4, 'Beep beep, cheap cheap.', 0, '', '');
INSERT INTO `ssl_items` VALUES (2, 1, 'R-41 Starchaser', 100000, 12, 14, 0, -1, -1, 4, 'Your basic two man fighter, can be piloted by only one.', 0, '', '');
INSERT INTO `ssl_items` VALUES (3, 1, 'Firespray-Class Patrol and Attack Ship', 150000, 30, 50, 0, -1, -1, 4, 'The Firespray-Class Patrol and Attack Ship has gained its fame as it was the favored ship model of the galaxy\\\'s most notorious bounty hunter, Boba Fett. Famed almost entirely due to Fett\\\'s \\"Slave I\\" there was a good reason this ship was chosen by the hunter.', 0, '', '');
INSERT INTO `ssl_items` VALUES (4, 1, 'Superviper Starfighter', 250000, 13, 50, 0, -1, -1, 4, 'The Superviper is a top of the line space superiority starfighter. It was built along the lines of the New Republic A-Wing. With its unmatched engine bay capcity this hull has superior potential. Its 4 weapon and 6 torpedo bays make this a very dangerous opponent. A single Superviper can easily take out corvette analogs, and a squadron of them can wipe out cruiser analogs without breaking a sweat. This sleek fighter was designed to intimidate it\\\'s target, instilling fear and causing them to freeze up.  ', 0, '', '');
INSERT INTO `ssl_items` VALUES (5, 5, 'Cadre Starfighter', 0, 45, 115, 0, 3, 3, 2, 'The first ship to ever by produced by Dak`wind Enterprises (EDE). Designed by Ehart, the companys director to be all he would ever want in a ship. This ship is not mass produced and is only available to the winning leader in the Cadre Games run by Ehart hmself. The ship has been designed to be fast and reliable. It will even give as good as it gets! The main design of the ship is to be able to transport an entire Cadre and a few prisinors from the hunt. All in all, it\\\'s the ship everyone would want but only the best can have.', 0, '', '');
INSERT INTO `ssl_items` VALUES (6, 1, 'Authority IRD', 60000, 13, 18, 0, -1, -1, 4, '', 0, '', '');
INSERT INTO `ssl_items` VALUES (7, 1, 'Z-95 Headhunter', 45000, 12, 14, 0, -1, -1, 4, 'Probably the most famous starfighter of old, the Z-95 has been around for ages. When it was first released, it was a technological breakthrough, and its design was mimicked for the now famous X-Wing fighter. Although it is old, the Z-95 can still compete with most of the galaxy\\\'s big shots. Fast and maneuverable, the ship has good a strong hull shielding, while it\\\'s weapon systems are equally formidable.', 0, '', '');
INSERT INTO `ssl_items` VALUES (8, 1, 'Skipray Blastboat', 200000, 15, 61, 0, -1, -1, 4, '', 0, '', '');
INSERT INTO `ssl_items` VALUES (9, 2, 'Bulk Freighter', 180000, 121, 140, 0, -1, -1, 4, 'Standard medium-sized freighter. Common throughout the entire galaxy. It\\\'s cost effective and capable of extremely long range tasks.', 0, '', '');
INSERT INTO `ssl_items` VALUES (10, 2, 'YT-1300 Freighter', 100000, 26, 86, 0, -1, -1, 4, 'Called the ultimate ship in the galaxy by some, the YT-1300 is probably the most famous. Extreme modification posibilities, good strength, and affordability shot the YT-1300 to the top of the freighter market. Many famed smugglers, such as the legendary Han Solo, have YT-1300\\\'s that are almost as famous as they are.', 0, '', '');
INSERT INTO `ssl_items` VALUES (11, 2, 'YX-2000 Freighter', 400000, 100, 200, 0, -1, -1, 4, 'The heavy shields and hull on this ship could possibily be classified in the warship type. It has far weaker weapons. If attacked it would probably retreat instead of fight since it has a limited weapons array.', 0, '', '');
INSERT INTO `ssl_items` VALUES (12, 4, ' Lambda Class T-4A Shuttle', 150000, 24, 66, 0, -1, -1, 4, 'This shuttle was designed to ferry people between ships or systems. It wasn\\\'t meant for pure hard combat. It can lightly defend itself with its array of weapons but not enough for assaults.', 0, '', '');
INSERT INTO `ssl_items` VALUES (13, 4, 'Assault Transport', 200000, 44, 142, 0, -1, -1, 4, 'Its name says it all! It is an attack transport. With it\\\'s heavy shields and armor and it\\\'s array of weaponry make it a deadly opponent. Its array of weapons can range from ions to torpedo\\\'s to laser turrents.', 0, '', '');
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

#
# Dumping data for table `ssl_itemtypes`
#

INSERT INTO `ssl_itemtypes` VALUES (1, 'Fighters', 'Small & maneuverable, fighters are great for the hunter that might see a lot of space combat and doesn\\\'t believe in moving slowly.');
INSERT INTO `ssl_itemtypes` VALUES (2, 'Freighters', 'With plenty of space for expansion, freighters are perfect for any scum who doesn\\\'t mind having a slow yet powerful ship at their command.');
INSERT INTO `ssl_itemtypes` VALUES (3, 'Hybrids', 'When it comes to ships, a hybrid is one of the best you can find, with speed and weapons as well as a little room for a few extra items that you might need.');
INSERT INTO `ssl_itemtypes` VALUES (4, 'Transports', 'Transports are much like freighters as room goes, but can also hold plenty of passengers or prisoners that you might need to bring in.');
INSERT INTO `ssl_itemtypes` VALUES (5, 'Special Edition', 'Special Edition ships are a limited thing, so get them while you can before the next set is up. Very few can own them due to the price but special craft are by far the best ships for any task.');
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

#
# Dumping data for table `ssl_parts`
#

INSERT INTO `ssl_parts` VALUES (1, 1, 'Anti-Cargo Scan Field', 'The ACSC allows you to deny any scans of what you have in your cargo hold, though this is illegal in some sectors, it can be easily turned on and off whenever you may need it.', 150000, 30, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (2, 1, 'Gravity Distorter', 'The new perfect tool for those that worry about running into things. This new device can make a gravity field in front of your ship to push away small to medium sized asteroids, or keep small ships from colliding into yours.', 300000, 30, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (3, 17, 'Gravity Well Projector', 'It\\\'s like having a Interdictor on your ship! The handy device will pull keep ships from jumping to hyperspace, or even pull passing ships out! As long as they are within range, of course.', 1500000, 300, 0, 1, 10, -1, 1, 0);
INSERT INTO `ssl_parts` VALUES (4, 1, 'Gravity Well Static Field', 'The GWSF allows you to escape the hold of a gravity projection field just long enough to make your jump to hyperspace, but be quick about it! The GWSF only makes a sort of negative charge against the surrounding gravity field for about 30 seconds, if you blow your chance you\\\'ll have to wait 3 hours until the GWSF is charged again.', 200000, 95, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (5, 1, 'Holo Emitter System', 'These emitters are the latest in SSL hologram technology. Each ship has to be evaluated for proper placement of these devices. These Devices require 420 units of power to operate. With this modification you can mask the design of your ship. Have you ever needed to change from a YT-1300 to a HT-2200 to fool anyone trying to catch you? The holo emitter can do this and more. It can project false images; Fighter escorts, asteroids, family pictures, etc. If you cant think of anything to do with this device you probably shouldnt buy it.', 2000000, 300, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (6, 17, 'Power Dissipator', 'A great tool for draining energy from ships to your own. The Power Dissipator can drain the power supply of any ship in seconds. Only problem so far has been if you take too much it will overload your power core causing an explosion. So use it carefully.', 1000000, 50, 0, 1, 8, -1, 1, 0);
INSERT INTO `ssl_parts` VALUES (7, 1, 'Stasis Field', 'Sometimes force can\\\'t be avoided and is needed to take your mark down. But if it should come to that, maybe it\\\'s best to place your prey into a stasis field to keep it alive on its way to your employer.', 15000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (8, 1, 'Tractor Beam', 'Long a handy tool. The Tractor Beam will lock onto its target and prevent it from moving. You have full control to either push the ship or pull it anyway you like.', 50000, 50, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (9, 1, 'Tractor Beam Reversal Field', 'The TBRF will allow you to escape the beam pull of any tractor beam field allowing you to make your get away.', 350000, 50, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (10, 1, 'Weapon Frequency Jamming Beam', 'When this beam locks onto your targeted ship it will knock out any use of laser based weapons on that craft, the WFJB can lock all weapons on smaller ships but only a limited number on larger capital craft considering how many weapons they may hold. The WFJB\\\'s only other draw back is its short range requirements.', 150000, 50, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (11, 2, 'Anti-Missile Laser', 'Damage: .5 MED<br>\r\nRate of Fire: 10/second<br>\r\nRange: 300 meters<br><br>\r\nThis is a last resort weapon against warheads before they hit your shields or your hull. It is computer controlled and extremely accurate. During testing it had an 80% success rate at knocking down incoming warheads. It is a defensive must in a battle with warheads flying around to have this weapon on your ship.', 5000, 15, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (12, 2, 'Blaster Cannon', 'Damage: 3 MED<br>\r\nRate of Fire: 5/second<br>\r\nRange: 1 km<br><br>\r\nThe oldest, still heavily used weapon in the galaxy. The Blaster Cannon has been around for centuries. Invented long ago by an unknown scientist, this weapons was once the standard weapon on starfighters. It has moderately good range and damage, yet doesn\\\'t take up a great deal of space.', 7000, 30, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (14, 2, 'FR1 Disruptor', 'Damage: 10 MED<br>\r\nRate of Fire: once every 2 seconds<br>\r\nRange: 2.5 km<br><br>\r\nMuch like hand held disruptors, the FR1 Disruptor destroys things at the molecular level. Because of the extreme power of Disruptor technology (as it not only harms things as a regular energy weapon, but also warms their molecules) this weapon is illegal across the galaxy. Only available to specially licensed individuals, SSL is now one of the last places where such a weapon can be had.', 15000, 25, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (15, 2, 'Fusion Cannon', 'Damage: 10 MED standard; 20 MED full charge<br>\r\nRate of Fire: 1/second standard; 1/5seconds full charge<br>\r\nRange: 2 km<br><br>\r\nThis is a unique weapon that operates slightly differently than other weapons in its class. Instead of firing a straight, simple beam this weapon must load up power and then discharges a powerful beam which can decimate enemy fighters.', 150000, 80, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (16, 2, 'Ion Cannon', 'Damage: 5 MED ION<br>\r\nRate of Fire: 5/second<br>\r\nRange: 1.5 km<br><br>\r\nA must for all hunters, the Ion Cannon will not harm a ship, but will instead disable it. My ionizing computer curcuits and overloading machinery, an ion blast can literally deactivate a ship or other mechanical item. Impervious to shields, an ion blast can seep through and turn a fleeing enemy into a sitting duck.', 10000, 20, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (17, 2, 'Ionic Shockwave', 'Damage: 15 MED<br>\r\nRate of Fire 1/2 minutes<br>\r\nRange: 400 meters<br><br>\r\nUnleases a wave of energy that will do 15 MED damage to all objects in the blast radius. It will surely destroy incoming warheads and disrupt incoming blaster fire.', 300000, 100, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (19, 2, 'Laser Cannon', 'Damage: 5 MED<br>\r\nRate of Fire: 5/second<br>\r\nRange: 1.5 km<br><br>\r\nThe current standard for most mass produced starfighters, the Laser Cannon is an accurate and dangerous weapon. Through better focusing and channeling a standard laser beam. A beam is \\"excited\\" by a small amount of blaster gas and comes out, more than twice as powerful as a Stream Laser.', 10000, 20, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (21, 2, 'Mass Barrage Cannon', 'Damage: 2 MED<br>\r\nRate of Fire: 15/second<br>\r\nRange: 800 meters<br><br>\r\nThe mass barrage cannon launches a solid metal projectiles from its electromagnetic accelerators. It\\\'s cheap to build and uses little power. The projectiles are low-tech spheres that rely on kinetic energy to do damage. While not incredibly advanced, it has its uses.', 8000, 35, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (22, 17, 'Maximum Incinerator', 'Damage: 300 MED<br>\r\nRate of Fire: 1/hour<br>\r\nRange: 5 km<br><br>\r\nThis weapon is extremely powerful and can fire a distance of 5 km. It has vaporized Z-95\\\'s, X-Wings, and many other ships in a single blast. It is the most powerful beam weapon produced by SSL.<br>\r\nUsed in concert with a harmonics sensor these ships can suprise and enemy with their range and destructive power. It can seriously maul an ISD with its shields down. It also consumes 400 units of power. So use this weapon wisely.', 500000, 200, 0, 1, 4, -1, 1, 0);
INSERT INTO `ssl_parts` VALUES (24, 2, 'Pulse Laser Cannon', 'Damage: 4 MED/second<br>\r\nRate of Fire: Lasts 4 seconds, streaming<br>\r\nRange: 850 meters<br><br>\r\nThe Pulse Laser is an older weapon, so old that it\\\'s actually been in use for over half a millenium. The predicessor to the modern blaster, the Pulse Laser uses a \\"heart beat\\" pulse to clump together a mass of energy and fire it into space. While not the most accurate weapon, it is reliable and fairly cheap.', 9500, 40, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (26, 2, 'Retractable Blaster Cannon', 'Damage: .5 MED<br>\r\nRate of Fire: 8/second<br>\r\nRange: 250 meters<br><br>\r\nFor those quick escapes. This handy concealed weapon will deal with unwanted soldiers in a pinch. Simply retract the blaster from it\\\'s housing, and blow those unwanted guests away. Oh and by the way, although this weapon is great on the anti-personal scale. Don\\\'t bother shooting at starfighters with it, you\\\'ll find it most ineffective.', 3500, 10, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (226, 19, 'Consumables Storage SL I', 'Provides one day\\\'s worth of air, food, and water. Best suited to fighters.', 5000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (227, 9, 'Frayed Knicker Elastic', 'Can be used in place of a tow cable for the terminally stupid. Has the advantage of being much cheaper and lighter, but the disadvantage of being totally useless.', 5, 1, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (225, 19, 'Consumables Storage SL II', 'Provides one week\\\'s worth of air, food, and water.', 10000, 15, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (30, 2, 'Blaster Cannon Turret', 'Damage: 6 MED<br>\r\nRate of Fire: 3/Second<br>\r\nRange: 1 km<br><br>\r\nBy combining two Blaster Cannons onto a single, swiveling turret the Blaster Cannon Turret was born. This is basically nothing more than that, just two Blaster Cannons which fire as a single unit which can be rotated.', 15000, 60, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (31, 2, 'Ion Cannon Turret', 'Damage: 10 MED ION<br>\r\nRate of Fire: 3/second<br>\r\nRange: 1.5 km<br><br>\r\nBy combining two Ion Cannons onto a single, swiveling turret the Ion Cannon Turret was born. This is basically nothing more than that, just two Ion Cannons which fire as a single unit which can be rotated. ', 25000, 85, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (32, 2, 'Laser Cannon Turret', 'Damage: 10 MED<br>\r\nRate of Fire: 3/second<br>\r\nRange: 1.5 km<br><br>\r\nBy combining two Laser Cannons onto a single, swiveling turret the Laser Cannon Turret was born. This is basically nothing more than that, just two Laser Cannons which fire as a single unit which can be rotated.', 25000, 85, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (33, 2, 'Quad Ion Turret', 'Damage: 20 MED ION<br>\r\nRate of Fire: 1/second, 4/second separately<br>\r\nRange: 1.5 km<br><br>\r\nMuch like the Quad-Laser cannon, only 4 ion cannon mounted on a turret will be shooting to disable your target ship.', 35000, 130, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (34, 2, 'Quad Laser Turret', 'Damage: 20 MED<br>\r\nRate of Fire: 1/second, 4/second separately<br>\r\nRange: 1.5 km<br><br>\r\nConsidered the ultimate anti-fighter weapen, the Quad Laser is a real blast. With incredible power and an excellent range, this four barreled weapon is right up the alley of most hunters. Although designed against fighters, this weapon has numerous capital ship kills marked to it as well.', 35000, 130, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (35, 2, 'SSL Mk.I Interceptor', 'Damage: 2 MED<br>\r\nRate of Fire: 8/second<br>\r\nRange: 500 meters<br><br>\r\nThis weapon is the most advanced point-defense pulse laser turret in existance. This weapon is a last ditch defense against missiles and incoming starfighters. It has also been rated at nearly 35% effective in intercepting incoming beam weapons. It is not effective againt armored ships like a Victory Star Destroyer. On lighter hulled ships it can do serious damage in close quarters battle.', 100000, 50, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (36, 2, 'Turbo Laser Turret', 'Damage: 28 MED<br>\r\nRate of Fire: 6/sec separate<br>\r\nRange: 2.5 km<br><br>\r\nThe standard weapon on Rebel and Imperial starships. It is extremely powerful. It takes up alot of mass and power on your ship. but makes up for it in the sheer volume of firepower.', 150000, 250, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (37, 3, 'Armoured Spacesuit', 'Air Supply: 25 hours<br>\r\nArmor Level: 90%<br><br>\r\nSo, even an armored vac-suit didn\\\'t work for you? Then this is your key to victory. This Armoured Spacesuit is superior. With 25 hours of atmosphere, heating unit, waste unit, and onboard food supplements, is self-patching, and includes comlink, not to mention ease of mind as blaster fire doesn\\\'t touch you.', 10000, 2, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (38, 3, 'Armoured Vacuum Suit', 'Air Supply: 15 hours<br>\r\nArmor Level: 35%<br><br>\r\nWell you\\\'re smart right? You\\\'re not just going to get into a flimsy vacuum suit and parade into your bounties domain. No, you\\\'re far to intelligent for that. You\\\'re going to wear something with a little more protection. The Armoured Vacuum Suit is your solution. With all the advantages of a vac-suit this one can take a little fire before you get burned.', 4000, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (39, 3, 'Battering Ram', 'Access Ability: 75%<br>\r\nEstimated Access Time: 1 minute<br><br>\r\nIf there isn\\\'t a hole... make one! Although the Battering Ram is more than a little ancient, it can still be of practical use. Instead of wooden timber, this ram is made of a large, durable slap of Durasteel. Attached to your ships hull, and powered by your ships power core, the Battering Ram is a real bash. When activated the ram will swing back and forth at an incredible speed, pounding its way through the hull of any ship set before it.', 5000, 50, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (40, 3, 'Boarding Droid', 'Access Ability: 80%<br>\r\nEstimated Access Time: 30 seconds<br><br>\r\nProbably the most effective and fastest boarding device available. You launch the Boarding Droid and after attaching itself to the hull of your victim, the droid explodes, creating an easy access hole.', 8000, 2, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (41, 3, 'Boarding Tube', 'For those with a little more money, and a great deal more brain, the Boarding Tube is the only way to board an enemy vessel. Much more secure than going out in a Vacuum Suit, the Boarding Tube extends from your hull and will latch onto the hull of the enemy vessel. Complete with its own artificial atmosphere, the Boarding Tube is safe and secure. Most optimal is of course to install a Plasma Torch to the inside of the tube, then once the enemy vessel is disabled attach the tube to an airlock and cut the airlock away with the Torch and you have yourself a perfect entrance.', 12000, 25, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (42, 3, 'Plasma Drill', 'Access Ability: 92 %<br>\r\nEstimated Access Time: 1 minute<br><br>\r\nOne of the quickest ways to earn yourself access to another vessel is with this little friendly drill. The rotational plasma bit will drill its way through any hull in existance leaving a nice access area.', 15000, 50, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (43, 3, 'Plasma Punch', 'Access Ability: 78 %<br>\r\nEstimated Access Time: 2 minutes<br><br>\r\nFor those that don\\\'t wish to tinker with the weighty Battering Ram, this is another alternative. The Plasma Punch is a blaster shaped device, which shoots out a small suction cup. Once attached to the hull of an enemy ship, the suction cup pumps the hull with plasmatic energy, literally burns the hull away.', 9000, 25, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (44, 3, 'Plasma Torch', 'Access Ability: 87%<br>\r\nEstimated Access Time: 1 minute<br><br>\r\nYet another possibility for boarders. The Plasma Torch is similar to the Plasma Punch in that is uses plasmatic energy to cut and burn the hull away. However, the Plasma Torch is a more compact and advanced device. Only the size of a hand held blaster, the Plasma Torch most efficiently delivers the plasma in a beam which can cut a perfect hole into the hull of any ship. The downside to this weapon is its range. Because of its small size and focusing methods, the Torch needs to be directly next to the opposing hull, his means that almost no space can exist between the two ships.', 12000, 30, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (45, 3, 'Roto-Cutter', 'Access Ability: 90%<br>\r\nEstimated Access Time: 20 seconds<br><br>\r\nThe roto-cutter is a expasion from any other previous device in that it doesn’t just drill or burn its way it, it slices! With a built in plasma rotation blade this is the best way yet to quickly gain access to anothers ship.', 12000, 20, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (46, 3, 'Vacuum Suit', 'Air Supply: 15 hours<br>\r\nArmor Level: 10%<br><br>\r\nNow you have the hole, but you have to get across to the other ship. For the true hunter that means a little space walk. But don\\\'t worry, with a handy Vacuum Suit you could parade around the enemy vessel before boarding her!', 2000, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (47, 4, 'Comm Jammer', 'This modification jams your targets ability to contact others.', 100000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (48, 4, 'External Comm System', 'It allows short range ship to ship communication.', 10000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (49, 4, 'Holonet Transceiver', 'This device allows Instant communication with any other holonet transceiver in the galaxy.', 1000000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (50, 4, 'Internal Comm System', 'This modification allows interal ship communication, since it\\\'s kind of hard to yell through a bulkhead.', 5000, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (51, 4, 'Summoner Unit', 'This device calls your ship to your exact location. It would come in very handy if you are stuck between a rock and a hard place, provided your ship is less than 5000 km away.', 40000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (52, 4, 'Subspace Transceiver', 'This device allow communication within a range of 5-8 light years depending on the area you are in. It is unreliable at ranges over 8 light years.', 60000, 15, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (53, 14, 'Missile Lock Stealth', 'Reduces the chances of your ship being locked on as a target by 40%.', 150000, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (54, 5, ' Computer SL I', 'The S.L I Computer is an old model computer, slow and unable to store huge amounts of data it is perhaps better used as a backup than a primary system.', 50000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (55, 5, ' Computer SL II', 'Similar to the SL I, this model is capable of storing considerably more information.', 100000, 25, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (56, 5, ' Computer SL III', 'The S.L III is the first computer ever to be capable of functioning entirely on voice commands. It does more than function, it interacts with you making computer usage much faster and more enjoyable. But don\\\'t worry, speech is not the only plus of the S.L III, this model is also three times faster than the S.L II and much more intelligent.', 250000, 30, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (57, 5, ' Computer SL IV', 'The best of the best as far as computers are concerned, the S.L IV onboard computer is a wonder. Capable of handling trillions of calculations per second, this is the perfect computer. Much like the S.L III this model can communicate via voice command. The S.L IV also utilizes a special artifical intelligence chip, which allows you to actually carry on a conversation with your computer!', 500000, 25, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (58, 5, ' NavComp SL I', '', 25000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (59, 5, ' NavComp SL II', '', 50000, 12, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (60, 5, ' NavComp SL III', '', 125000, 15, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (61, 5, ' NavComp SL IV', 'This is the top of the line navigational computer. Built by SSL. This computer has up to date Starcharts and information not available anywhere else.', 250000, 12, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (62, 5, ' TargetComp SL I', 'This is the base-level targeting computer, as used in many starfighters.', 25000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (63, 5, ' TargetComp SL II', '', 50000, 12, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (64, 5, ' TargetComp SL III', '', 125000, 15, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (65, 5, ' TargetComp SL IV', 'This computer is three times as powerful as the old SL III version. It can track up to 1,000 targets and lock on 8 of of them. A hunter who is going into battle would be crazy not to have one of these on his side.', 250000, 12, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (66, 5, 'Ace Pilot', '', 600000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (67, 5, 'Novice Pilot', 'This droid brain will keep your ship from flying into anything while you maim your prey. Hopefully.', 200000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (68, 5, 'Super Ace Pilot', 'The highest level of AI ever achieved in a droid pilot brain. This will keep your enemies at bay and your ship safe from harm.', 1000000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (69, 5, 'Top Ace Pilot', '', 800000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (70, 5, 'Veteran Pilot', '', 400000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (71, 5, 'Datalink', 'Allows for the transfer of large sets of data between ships.', 80000, 2, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (73, 5, 'Rapid Fire Warhead Add-On', 'This Modification allow the launching of multiple numbers of warheads. It can lock onto 8 targets at a time when coupled with a TargetComp SL IV, 6 targets with a TC SL III, or 2 targets with the lower end models.', 20000, 0, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (74, 5, 'Ship Slaving Circuit', 'Allows you to slave ships to your own systems and control them.', 150000, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (75, 6, 'Air Freshener', 'Tired of that funky smell in your ship after having friends or relatives over? Or perhaps you had a wild night and a pugnent odour is there to remind you of it.\r\n<br><br>\r\nNow you can eliminate these foul smells with an Air Freshener!\r\n<br><br>\r\nFor those of you who have problems with body odour, we recommend you buy several.', 10, 0, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (76, 6, 'Beaded Seat Cover', 'Jawas use them. Taxi drivers swear by them. A bead seat cover will make your seat infinitely cooler, and lots more fun when you have attractive members of the opposite gender, same gender... well, whatever you go for, really... staying on your ship for some quality time.', 20, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (77, 6, 'Bumper Sticker', 'Do you have a baby on board?\r\n<br><br>\r\nCan you go from 0 to horny in under 3.5 beers?\r\n<br><br>\r\nNow you can let all your fellow travelers know about it with your very own bumper stickers!', 10, 0, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (78, 6, 'Cup Holder', 'Tired of chasing down enemy fighters while juggling a hot cup of coffee?\r\n<br><br>\r\nConstantly having to deal with stains from cups you left sitting on the controls?\r\n<br><br>\r\nWhy not purchase some cup holders and put an end to all your woes!', 50, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (79, 6, 'Dancing Hula Trooper', 'Ok, I\\\'m sure you\\\'re wondering why you would possibly want something like this. Well, it dances. It\\\'s a hula trooper. What more could you ask for in a modification?', 20, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (80, 6, 'Deaf Maker Sound System', 'Are you tired of listening to your Chief or boss blab on about this and that? Well after purchasing one of our Deaf Maker Sound Systems you\\\'ll never have to worry about hearing things again!', 3000, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (81, 6, 'Dewback and Bantha Leather Seats', 'mmm.... leather... You know you want it!', 250, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (82, 6, 'Exterior Repainting', 'Some ships that come off the assembly line are just darned ugly! That\\\'s why we provide Exterior repainting.\r\n<br><br>\r\nNot only will your prey fear you, but they\\\'ll recognize your good fashion sense as well!', 10000, 0, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (83, 6, 'Fuzzy Dice', 'No ship is complete without a set of Fuzzy Dice. Not even your super modified Special Edition ship. So buy some today!', 10, 0, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (84, 6, 'Holo Chess Board', 'Sometimes your out on a long chase and buy the time you capture your prey you are desperate for something to do on the long ride home.\r\n<br><br>\r\nWith a Holo Chess Board you can not only distract your prey from attempts to escape, but entertain yourself as well!', 500, 2, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (85, 6, 'HoloVision', 'Porn.', 15000, 2, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (86, 6, 'Hood Ornament', 'Nothing says a cheap attempt at style and class like a Hood Ornament.', 100, 1, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (87, 6, 'Interior Carpeting', 'Are those cold, hard, metal floors causing your feet to blister and grow strange bumps? With Interior Carpeting your feet will be happy and so will you!', 500, 2, 1, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (88, 6, 'Interior Repainting', 'Because the inside of your ship can be just as ugly as the outside, we also offer Interior Repainting.\r\n<br><br>\r\nIf you are not satisfied with the job we do, you can get us to paint it again!', 7500, 0, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (89, 6, 'Lava Lamp', 'What more do we need to say? It\\\'s a lava lamp. A must have for any self-respecting hunter.\r\n<br><br>\r\nGroovy, baby!', 150, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (90, 6, 'Leather Seats', 'mmm.... more leather... You want it. You need it. You will buy it!', 100, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (91, 6, 'Portable Refrigerator', 'Keeps your beer or pop or juice nice and cold. Is also good for keeping food from rotting on a long chase.', 1500, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (92, 6, 'Rotation Seat Add-On', 'Now you can spin and spin and spin to your hearts content!', 100, 0, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (93, 6, 'Sabacc Deck', '\\\'Cause everyone plays cards at some time.', 25, 0, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (94, 6, 'Small Trashcan', 'You\\\'re a Bounty Hunter, of course you\\\'re going to be dirty, as scum it\\\'s only natural. With a trash can you can help to keep that dirt and garbage from taking up valuable space inside your ship, and make it take up valuable space outside.', 9, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (95, 6, 'Spy Satellite Ceiling Fan', 'Following the trend started by Ace Azzameen, SSL has started stocking the coveted Spy Satellite Ceiling Fan. Made from sto... surplus Imperial Spy Satellites these little fans will keep air circulating in most mid to large sized areas.', 1000, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (96, 6, 'Ultima AC/Heater', 'Some like it hot. Some like it cold.\r\n<br><br>\r\nWith our AC/Heater system you can have it whatever way you like!', 1000, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (97, 6, 'Window Washers', 'Hate those jetpackers in space that splat on your front window? Don\\\'t worry any longer, the Window washer will clean even the worst grime off that window to give you a crisp clear view.', 150, 1, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (98, 6, 'Card Table', 'What\\\'s the use of having cards if you don\\\'t have anywhere to play? Cards, that is.', 80, 2, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (99, 7, 'After Burner', 'By reignition of exhaust gas an Afterburner hurls your ship forward at an incredible speed, although the effect is short lived this can be a life saver if you are ever forced to flee from a battle.', 50000, 15, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (100, 7, 'Engine Upgrade', 'Given a skilled technician and some tools you can have your engines tweaked and enhanced for their optimal potential, thus improving sublight speeds.', 15000, 0, 3, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (101, 7, 'Small Ion Engine', 'Why bother with a simple enhancement, why not just add another engine? With proper installation an Additional Engine will help more than any single enhancement.', 30000, 60, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (102, 7, 'Large Ion Engine', 'A large, 70 MGLT engine suitable for most craft.', 100000, 210, 3, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (103, 7, 'Scram Jet', 'Effect: +15 MGLT (in atmosphere)<br><br>\r\nThis atmospheric accelerator takes air from the atmosphere, compresses it and shoots it out the rear end of the scramjet for an additional speed boost. It only works in the atmosphere, of course, but having no moving parts whatsoever, it requires essentially no maintenance.', 60000, 40, 3, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (104, 7, 'Medium Ion Engine', 'An engine capable of adding 50 MGLT to your speed.', 75000, 150, 3, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (105, 7, 'Turbo Ion Engine', 'So, even an additional engine didn\\\'t suit you? Well, maybe you need a Turbo Engine. With a stronger power output you\\\'ll be ready to rock, run, and fly circles around any enemy in no time.', 60000, 120, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (106, 7, 'Class x.20 Hyperdrive', 'Even the x.25 was considered unbelievable we now have the x.20. Though it is in experimental phases the SSL believes it is safe for experimental release to the public.', 2000000, 13, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (107, 7, 'Class x.25 Hyperdrive', 'Considered an impossible speed, the x.25 Hyperdrive is here! Although still a prototype produced exclusively by SSL, all tests of the x.25 have proven it to be reliable and safe. With this newest model you can race to your destination more than three times faster than a military grade Class x1 drive!', 1000000, 13, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (108, 7, 'Class x.5 Hyperdrive', 'The Class x.5 Hyperdrive was actually only recently created. Created by a group of outlaw techs that wishes to make a huge profit off of selling the model to smugglers and bounty hunters the x.5 Hyperdrive is now in extensive use throughout the Rim Territories.', 750000, 13, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (109, 7, 'Class x.75 Hyperdrive', 'A few years after the creation of the Class x1 Hyperdrive, tales of a smuggler able to outrun military vessels began to arise in the core worlds. This smuggler had apparently tinkered with his stolen Class x1 Hyperdrive and improved its power output and efficiency to the point were he actually improved the speed. The exact modifications needed were first discovered after the smuggler was killed and his hyperdrive torn to pieces. Now the Class x.75 Hyperdrive is a popular drive amoung those who wish to partake in shady activities.', 500000, 13, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (110, 7, 'Class x1 Hyperdrive', 'The standard hyperdrive for most military vessels. The Class x1 Hyperdrive is twice as fast as a more standard Class x2. Previously outlawed to all but Imperial ships the ban on Class x1 Hyperdrives is now lifted and these drives are in high demand everywhere.', 300000, 13, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (111, 7, 'Class x10 Hyperdrive', 'A useful backup hyperdrive, the x10 is slow but handy in a clinch.', 20000, 13, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (112, 7, 'Class x2 Hyperdrive', 'The standard on most ships in the galaxy, the Class x2 Hyperdrive is the most commonly found drive in existance. Althought not the fastest in the galaxy, by installing this unit to your ship you can traverse hyperspace with an x2 modifier.', 150000, 13, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (113, 7, 'Class x5 Hyperdrive', 'Slower than most hyperdrives in use these days, the x5 is another alternative for a backup drive.', 50000, 13, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (114, 7, 'Maneuvering Fins', 'Effect: +12 DPF (in atmosphere)<br><br>\r\nInstead of adding simple jets, adding an actual maneuvering fin to your ship will dramatically improve the maneuverability of your ship.', 20000, 20, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (115, 7, 'Turn Jets SL I', 'Going in a straight line isn\\\'t much fun, so you\\\'ll need to add some turn jets to change direction.', 20000, 30, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (116, 7, 'Turn Jets SL II', '', 35000, 30, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (117, 7, 'Turn Jets SL III', '', 50000, 30, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (118, 7, 'Acceleration Upgrade SL I', 'If it\\\'s quicker acceleration that you want then this is what you will need, the acceleration upgrade will give your ship that extra fast start you might need to survive.', 5000, 10, 3, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (119, 7, 'Acceleration Upgrade SL II', '', 7500, 10, 3, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (120, 7, 'Acceleration Upgrade SL III', '', 10000, 10, 3, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (121, 18, 'Corusca Gem Armour', 'This material is found on the mines of Yavin, it is the hardest known material in the Galaxy! Though it is extremely expensive, you will be amazed at how much better it can protect then even Iratone could.', 1000000, 100, 9, 1, 10, -1, 1, 0);
INSERT INTO `ssl_parts` VALUES (122, 8, 'Durasteel Hull Plating', 'Durasteel plating is todays equivalent of the older steel plating. Although still not the strongest armour plating available it is twice as effective as standard steel plating. Durasteel is the current standard for a ship\\\'s hull, and almost all ships are manufactured out of it.', 10000, 100, 9, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (123, 8, 'Exterior Carpeting', 'For those who enjoy to relax on top of their ship in comfort and style. Good for parties and celebrations on your new ship; you\\\'ll want to have carpeting all over so your toes are stubbed on that new tractor beam. Just remember to clean it after every hyperspace trip, as those trainees you tied to the top before entering vacuum might leave a mess.', 1000, 100, 9, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (124, 8, 'Iratone Hull Plating', 'The very pinnacle of modern starship hull plating. Iratone armour is a revolution, it\\\'s light, durable and extremely resistant to all forms of weaponry. Doesn\\\'t matter if you encounter turbolasers, or old black powder weapons. Iratone armour will protect like nothing else can.', 70000, 100, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (125, 8, 'Neutronium Hull Plating', 'After the total revolution of Durasteel, Neutronium was the next great invention. Actually an alloy of Durasteel. Durasteel was mixed with stronger metals to form Neutronium. Still used for the construction of some starfighters in private shipyards, Neutronium is a nice step up from Durasteel for those that can afford it.', 15000, 100, 9, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (126, 8, 'Ponium Hull Plating', 'Ponium is a fairly common heavy metal used on Imperial ships even today, though it is not as strong as Titanium, it is considered the middle-class armour, price, and weight making it a very useful metal even today.', 30000, 100, 9, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (127, 8, 'Quadanium Hull Plating', 'Quadanium armor was long the standard for high grade war ships. Everything from Imperial Star Destroyers to Rebel Mon Calamari combat vessels were built with at least one layer of Quadanium armouring.', 60000, 100, 9, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (128, 8, 'Steel Hull Plating', 'Steel is an ancient metal. Long ago used for almost every practical purpose, it is still useful today to plate a ships hull. Although no match for newer and stronger alloys, it is a much less expensive alternative for those who just want a little more security.', 5000, 100, 9, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (129, 8, 'Titanium Hull Plating', 'Titanium. A rare metal ideal for starfighers that want to survive a serious battle, it\\\'s the most advanced metal which can be used on older starfighter models. Titanium is usually the hull plating chosen by people that are upgrading their old fighters to compete with newer fighters.', 50000, 100, 9, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (130, 9, 'Durasteel Door', 'It\\\'s a door. It\\\'s made out of durasteel. Any other questions?', 750, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (131, 9, 'Gravity Pads', 'Do you like weightlessness? If not, you might want to buy a set of these for your new ship.', 10000, 15, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (132, 9, 'Display Screen', 'Displays numerous images, ship\\\'s status. etc. Handy for quick assessment of situations.', 1000, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (133, 9, 'Magnetic Pads', 'Useful for locking down metal items in cargo bays.', 5000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (134, 9, 'Mechanical Pads', 'Also handy for keeping your cargo from floating away. There are limits to the size and shape of objects you can place on this pad, however.', 5000, 15, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (135, 9, 'Quick Close Add-On', 'Allows you to close the door quickly.', 500, 0, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (136, 9, 'Shield Doorway', 'A door with an added shield, making it resistant to most blasters.', 3500, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (137, 9, 'Steel Door', 'A door made out of steel.', 375, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (138, 9, 'Maximum Doorway', 'The Maximum Doorway combines the other doors available into one impenetrable barrier. Its unique multi-layered design incorporates layers of steel, durasteel, and a shield. Most importantly, it has a big sticker on it saying \\"Keep Out\\".', 20000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (139, 9, 'Transparisteel Window', 'What fun is flying through space if you can\\\'t see out?', 500, 0, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (140, 19, 'Consumables Storage SL III', 'Increases your air, food, & water supply for 2 more weeks.', 20000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (141, 19, 'Consumables Storage SL IV', 'Increases your air, food, & water supply for 1 more month.', 40000, 30, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (142, 19, 'Consumables Storage SL V', 'Increases your air, food, & water supply for 1.5 more months.', 60000, 40, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (143, 19, 'Consumables Storage SL VI', 'Increases your air, food, & water supply for 2 more months.', 80000, 50, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (144, 9, 'Docking Port', 'This is a Docking Port. Its where you dock ships, but only one ship per docking port at a time. For fighters and ships that dont have a docking hatch. It is possible to bring the area that opens into the docking port. It then seals the port electromagnetically. If the ship is too big to do this. The Telescoping Docking tube comes into play. It extends and attaches to the ship.', 60000, 75, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (145, 9, 'Hangar', 'A hangar takes up a considerable amount of space and carries room for 1 under 25 meter ship. The ships that is receiving the hangar must be over 50 meters in length.', 100000, 500, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (146, 9, 'Passenger Pod', 'Contains room for one or two passengers, including a bunk bed.', 6000, 30, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (147, 9, 'Prisoner Hold', 'A secure place to put a prisoner.', 10000, 30, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (148, 9, 'Secret Cargo Hold', 'A place to stash those less-than-legal items. Or, in an emergency, yourself.', 15000, 40, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (149, 9, 'Tow Cable', 'Like a tractor beam, only old-fashioned.', 2500, 10, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (150, 9, 'ShipCam', 'The ShipCam provides internal surveillance allowing you to check other parts of the ship.', 7500, 8, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (151, 10, 'Backup Battery', 'This battery can be used in the event of a system-wide power failure to ensure that life support and other key systems will remain on for at least 5 days.', 10000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (152, 10, 'Miniature Fusion Generator', 'Minature Fusion generator that generates a large amount of backup power for your ships systems.', 37500, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (153, 10, 'Miniature Solar Generator', 'This device is capable of converting solar wind along with solar energy to power your ship. It is expensive, but works better then a backup battery in the long run, provided you are near a solar system.', 25000, 50, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (154, 10, 'Fusion Power Reactor', 'It may not be the absolute best but it is close, the Fusion Reactor is common in a lot of rebel craft, though don’t let that fool you, it still is an excellent power supply running anything from multiple weapons to shields, engines, hyperdrives and still have power for your radio!', 120000, 40, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (155, 10, 'Ionisation Reactor', 'The absolute best reactor the SSL has to offer, this can run basically everything you want, from power hungry beam devices, to big weapons, shields, etc. It can handle it all. ', 150000, 50, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (156, 10, 'Nuclear Reactor', 'An old but still useful reactor, though the Nuclear Reactor can provide you with a good power supply it can cause a melt down which would destroy your ship... so watch how much of a strain you put on it!', 70000, 50, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (157, 10, 'Solar Power Reactor', 'By collecting power from suns the Solar Power Reactor is one of the most sufficient power sources, used even on the Empires TIE craft, though it doesn\\\'t provide for much power.', 55000, 30, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (158, 9, 'Backup Life Support', 'This portable life support model can be run for 24 hours independent of all other systems.', 15000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (159, 11, 'Bacta Tank', 'In need of some healing? If so, a Bacta Tank is just for you. Take a dip and allow nature to take its course.', 30000, 40, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (160, 11, 'Bugs Bunny Night Light', 'Are you a poor frightened TRN away from mummy for the first time? Worried that those nasty monsters under the bed are going to come and get you? Fear no longer, because this cute, functional night light will keep you reassured and safe, thereby saving expensive dry-cleaning bills.', 50, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (161, 11, 'Console Dead Lock', 'Protective Ability: 93%<br><br>\r\nThis device cuts all power to your consoles until the proper key card or combination is run through the lock mechanism. This can be used with the console lock.', 1000, 0, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (162, 11, 'Console Lock', 'Protective Ability: 90%<br><br>\r\nThese large sheets of durasteel are pulled over your console and locked into place making the controls to your ship inaccessibly.', 500, 2, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (163, 11, 'Console Shield Lock', 'Protective Ability: 95%<br><br>\r\nNot only cuts power to the consoles until a key card is run through the lock, but gives anyone trying to use a locked console a nasty electric shock.', 5000, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (164, 11, 'Electronic Combination Hatch Lock', 'Protective Ability: 85%<br><br>\r\nIf you need to lock your ship. Lock it with a combination. With over a million possible codes you can rest easy knowing your ship is secure, with you, the only one that knows the combination.', 750, 2, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (165, 11, 'Emergency Self-Destruct', 'Effectiveness: 100%<br><br>\r\nIt happens. You could be outnumbered, or outgunned, or at worst... both. It\\\'s your job to take prey, not become one. If the need should arise activation of this unit will turn you into a flying fireball. With some luck the explosion will take some of your enemies with you.', 10000, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (166, 11, 'Escape Pod SL I', 'Escape Info: Holds 1 passenger<br><br>\r\nThis little pod will be your ticket to survival in the unlikely event of your ship flying to pieces.', 10000, 20, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (167, 11, 'Escape Pod SL II', 'Escape Info: Holds 3 passengers<br><br>\r\nThis little pod will be your ticket to survival in the unlikely event of your ship flying to pieces.', 30000, 40, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (168, 11, 'Escape Pod SL III', 'Escape Info: Holds 5 passengers<br><br>\r\nThis little pod will be your ticket to survival in the unlikely event of your ship flying to pieces.', 50000, 75, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (169, 11, 'Fingerprint Hatch Lock', 'Protective Ability: 94%<br><br>\r\nI hope no one else has your fingerprint. Because that\\\'s what\\\'s keeping your ship secure with this hatch lock. A simple system that reads your individual fingerprint and will lock or unlock your hatch on command.', 1750, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (170, 11, 'Key Card Ship Lock', 'Protective Ability: 89%<br><br>\r\nIf you\\\'re the type that doesn\\\'t want to rely on a slicable code then perhaps having a key card is right for you. After leaving your ship the lock will remain activated as long as the proper key card isn\\\'t inserted.', 600, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (171, 11, 'Man-Trap', 'Effectiveness: 80%<br><br>\r\nWorking on the same principles as the stun net, the Man-Trap works on sensors installed under your deck plates. However instead of hurling a stun net, the Man-Trap will increase the gravity on that deck plate by ten fold. This will cause anyone standing there to be literally frozen in place, unable to move against the extreme gravity.', 2500, 8, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (172, 11, 'Pilot Ejection System', 'If it\\\'s instant excape you want then the ejection seat is what you will need. This makes your captain seat give you a boost up and safely out of your craft, just don\\\'t forget to wear your space suit before you do it, or you will have problems.', 10000, 10, 1, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (173, 17, 'Rabid Creature Security System', 'If it\\\'s security you\\\'re looking for then look no further then the rabid creature! It rips anything that enters your ship to pieces, of course this doesn\\\'t mean it won\\\'t try to make a meal out of you too... So we will have to work on that problem.', 500000, 50, 0, 0, 9, -1, 1, 0);
INSERT INTO `ssl_parts` VALUES (174, 11, 'Remote Control Hatch Lock', 'Protective Ability: 91%<br><br>\r\nBy all means the most convinient locking method. By having this lock installed you can handle ship security by remote. Just push LOCK and walk away. When you want to get back aboard, UNLOCK and you\\\'re in.', 1250, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (175, 11, 'Retina Scan Hatch Lock', 'Protective Ability: 96%<br><br>\r\nFar more difficult to deal with than a key card or a remote that can be stolen. A shipjacker is going to have a wonderful time emulating your retina. The difficulty surrounding this system, both for shipjackers and slicers makes this one of the safest on the market.', 5000, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (176, 11, 'Freeze-Tech', 'Effectiveness: 92%<br><br>\r\nBy installing sensors under the floor plating which is activated when the pilot/crew is not aboard. Any weights above 5 grams triggers an energy discharge which is powerful enough to knock even the largest and strongest ship-jacker unconsious for a number of hours.', 7500, 8, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (177, 11, 'Iron-Claw', 'Effectiveness: 97%<br><br>\r\nMuch like the \\"Freeze-Tech\\" only this unit has a much higher power feed and will kill any intruder with a massive energy discharge.', 15000, 15, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (178, 11, 'Ultra-Lock Hatch Lock', 'Protective Ability: 99.9%<br><br>\r\nIncludes all of the hatch locks in one, you must use all to get this lock open.', 15000, 6, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (179, 11, 'Voice ID Hatch Lock', 'Protective Ability: 95%<br><br>\r\nMuch like your fingerprint, your voice has its own tone quality and frequency unlike any other. You can use that to your advantage with this handy lock which works on voice control.', 2750, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (180, 11, 'Weapon Lock', 'Effectiveness: 90%<br><br>\r\nDetects missile and blaster locks on your ship, can estimate time for warhead lock.', 8000, 3, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (181, 12, 'Cargo Sensor', 'So you\\\'re a pirate and looking to ransack your very first cargo ferry. Not without this baby you aren\\\'t. Designed to scan a ship for anything located in it\\\'s cargo hold as well as the data stored in it\\\'s cargo manifest files, it absolutely ensures you\\\'ll know whether you\\\'re jumping a cargo ship containing weapons or a ship containing nerf sausages.', 70000, 10, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (182, 12, 'Comm Filter', 'Let\\\'s face it, viruses are great until you\\\'re on the receiving end of one. Suddenly, your computer is fried and takes hours to repair, all because you didn\\\'t have one of these installed.\r\n<br><br>\r\nWith a Comm Filter, you can be assured that no viruses will ever reach your computer systems. It\\\'s made to scan a file before recieving it, instantly destroying any files containing a bug or virus.', 20000, 1, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (183, 17, 'Force Sensor', 'The plans for this device were intially laid down by Emperor Palpatine in his search for Jedi of the Light Side, it has been tweaked and modified by the SSL until it was perfect. Still highly unstable, this device allows a ship to detect a disturbance in the force from up to a sector away, perfect for those bounties that happen to be force-sensitive. It has helped to catch numerous force-sensitive beings and while their isn\\\'t a guaranteed success, it\\\'s definately worth every decicred you pay for it.', 3500000, 30, 0, 1, 12, -1, 1, 0);
INSERT INTO `ssl_parts` VALUES (184, 12, 'Friendly-Fire Lock', 'Lost one too many friends to your own crappy targetting system? Now with friendly-fire lock you can keep from \\\'accidentally\\\' putting an end to your fellow hunters careers.', 250000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (185, 12, 'Harmonics Sensor', 'The legendary Pirate Xaul Zan used this to capture the Marauder Corvette \\"Gem of Yavin\\" with only a squadron of TIE Bombers. It probes the ship\\\'s shield harmonics and establishes your frequency to match their frequency, ensuring that your weapons are able to fire through an enemy\\\'s shield systems.\r\n<br><br>\r\n(Note: Please be aware that Harmonics Sensor can only lock onto one ship at a time, and requires some time to fully configure your weapons to the harmonics of enemies shield systems)', 1500000, 30, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (187, 12, 'Missile Jammer', 'How many times have you been on the receiving end of a concussion missile? Too many, right? And without some awesome maneuvering skills, that missile has a date with your ship. With this baby, you\\\'ll never worry about missiles ever again. Made specifically to scramble the targetting sensors of all incoming missiles and redirect them away from your craft.', 100000, 15, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (228, 12, 'Short Range Sensors', 'Effective to a range of 15 kilometres, these sensors will tell you who\\\'s out there gunning for you.', 25000, 10, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (229, 12, 'Long Range Sensors', 'Long range sensors are a hunter\\\'s best friend. With both active and passive sensing modules, you can be sure that nothing in your solar system will escape your attention.', 75000, 20, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (189, 12, 'Sensor Jammer', 'This is a cheap way of ensuring you don\\\'t show up on long range scans. The closer the other ship is to you, though, the more likely they will pick you up anyway.', 170000, 20, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (190, 12, 'Sensor Satellite', 'This upgrade to your standard sensors is definately one of the most useful items in the SSL. It drops a small satellite from the hull of your ship, which relays detailed sensor data from up to 50 KM away. This will give you more then enough time to plan your attack on that convoy to ensure that your ship doesn\\\'t end up in a million pieces.', 50000, 25, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (192, 12, 'Virus Transmitter', 'We\\\'ve all been there. His shields are too strong, he\\\'s a damn good pilot and you just can\\\'t get a missile lock on his ship, no matter how hard you try. He\\\'s about to get away, but wait, you have a virus transmitter installed! Suddenly, his ship powers down, and is unable to function as the virus you transmitted fries his main computer, leaving him stranded in space. C\\\'mon, you know you want one of these babies, and they\\\'re definately worth it.\r\n<br><br>\r\n(Note: Virus is transmitted via Commlink and carries a 15% chance of success. The transmitter is incompatible with the Comm Filter.)', 20000, 2, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (193, 13, 'Power Charger', 'Effect: 50% increase in shield recharge rate<br><br>\r\nA great addition to any shield is the power charger, which can increase the rate your shields recharge by 50 percent, making battles a heck of a lot more fun!', 150000, 15, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (194, 13, 'Shield Regenerator', 'Effect: 100% Recharge to Shields<br><br>\r\nThe Shield Regenerator gives you one full 100% recharge to your shields, though use it wisely because recharge time for the generator is 5 hours after use.', 350000, 40, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (195, 13, 'Shield Generator SL I', 'The base level shield generator available for mounting on a ship.', 30000, 40, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (196, 13, 'Shield Generator SL II', '', 40000, 40, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (197, 13, 'Shield Generator SL III', '', 75000, 40, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (198, 13, 'Shield Generator SL IV', 'The best Shield Generator SSL has to offer.', 100000, 150, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (200, 14, 'Engine Baffles', 'Sensor Stealth: 5%<br><br>\r\nDid you know that your engines give off an enormous gas trail that makes your ship easily trackable? What\\\'s more, did you know that there is something that you can do about it? Engine Baffles are special micro-vents that affix to your engine funnels and both reduce visible glow and disperse your exhaust trail.', 5000, 5, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (201, 14, 'Exhaust Vents', 'Sensor Stealth: 10%<br><br>\r\nFor those who need a little more than just trial glow reduction and light trail dispersal, Exhaust Vents are micro-intakes that will inject surrounding space into your exhaust stream, diluting your trail and making your ship extremely difficult to track.', 12500, 10, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (202, 14, 'Semi-Cloak', 'Sensor Stealth: 30%\r\n<br><br>\r\nOriginally designed as an exclusive enhancement for the SSL Special Edition \\"Ghost\\", the Semi-Cloak was SSL\\\'s first attempt at a reasonably sized cloaking device, capable of hiding a fighter-sized craft. The Semi-Cloak works by \\"bending\\" the light around it, while at the same time absorbing sensor signals. While fully functional and capable of producing a sizable decrease in detectability, the Semi-Cloak has a fairly short work-span and typically can keep a ship hidden for no longer than fifteen to twenty minutes before requiring the system to \\"recharge\\" for approximately three hours.', 500000, 100, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (203, 14, 'Sensor Decoy Drone', 'Sensor Stealth: 15% (once launched from Sensor Decoy system)\r\n<br><br>\r\nThis self-propelled droid is the heart and soul of the Sensor Decoy system. Capable of replicating almost any ship identification code, Decoy Droids will give you all the edge you need in creating amusing and useful diversions for your prey.', 10000, 15, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (204, 14, 'Sensor Deflective Ship Coating', 'Sensor Stealth: 15%\r\n<br><br>\r\nWorking on a similar premise to a Sensor Shroud, Sensor Deflective Ship Coating is a clear, light fluid adhesive that can be \\"painted\\" onto your ships hull in a thin film. Once properly \\"installed\\" the coating works to absorb/redirect sensor signals that otherwise would detect you.', 200000, 0, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (205, 14, 'Sensor Scrambler', 'You are leisurely flying along when you get a public notice on subspace, your ship has been added to the New Republics \\"shoot on sight\\" list! Instead of panicking, you merely chuckle and flip the switch on your SSL Sensor Scrambler, which automatically changes your ship ID and sensor tags to anyone of a countless array of aliases, thus ensuring your security and travel comfort.', 300000, 3, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (206, 14, 'Sensor Shroud', 'Sensor Stealth: 15%\r\n<br><br>\r\nThe Sensor Shroud is an ingenious little device, which works by emitting a low-level sensor-absorbing field around the skin of your ship. This field works to counteract most common forms of sensor technology, thus making your ship difficult to detect and lock-down.', 150000, 20, 0, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (207, 17, 'TransparaCloak EX 1', 'Sensor Stealth: 50%\r\n<br><br>\r\nThe TransparaCloak is the galaxies current pinnacle of cloaking technology for small-mid range sized craft. Built off of the elder Semi-Cloak design, the TransparaCloak EX I is a slightly larger, but more powerful device. Capable of keeping a craft hidden for a period of several hours before requiring \\"recharging\\" the TransparaCloak\\\'s only downside is its substantial power drain and the systems frequent meltdowns, some of which have proven deadly. This device is highly experimental, and is offered here only for the most daring and foolhardy bounty hunter that can\\\'t wait for a more stable model to come out on the market.\r\n<br><br>\r\nNote: Do NOT install the TransparaCloak EX I on any ship that already has the SSL Semi-Cloak, although the systems were built along similar principles tests have indicated that craft are no able to withstand the extreme strain resulting from two such systems and that the results of such a marriage are almost certainly hazardous.', 1500000, 150, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (208, 15, 'Torpedo Launcher', 'For anyone that wants to fire a Proton Torpedo. A launcher must be installed first. And with this model built into your ship, you\\\'re ready for action. Designed to launch any of the numerous different types of Torpedoes, you should be most satisfied with this launcher. The one proviso is that all the torpedoes to be fired by this launcher must be in the same bay as it.', 20000, 50, 6, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (209, 15, 'Missile Launcher', 'For anyone that wants to fire a missile. A launcher must be installed first. And with this model built into your ship, you\\\'re ready for action. Designed to launch any of the numerous different types of missiles, you should be most satisfied with this launcher. The one proviso is that all the missiles to be fired by this launcher must be in the same bay as it.', 15000, 50, 6, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (214, 16, 'Advanced Torpedo', 'A Proton Torpedo on steroids, this is what it pretty much is. Faster and more powerful, this will definitely ruin a person\\\'s day who is on the recieving end of this.', 10000, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (211, 15, 'Mine Launcher', 'A highly illegal modification for civilian craft. The Mine Placer is designed to drop space mines which react to the proximity of other craft, generally destroying them when they explode.', 300000, 50, 6, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (212, 15, 'Heavy Warhead Launcher', 'Need to fire some Heavy Bombs or Rockets? Install this launcher and your heavy armament needs are met.', 30000, 50, 6, 1, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (215, 16, 'Proton Torpedo', 'The standard torpedo, this weapon went from pretty much nothing to a primary weapon for those that have the extra money. It\\\'s pretty much every one uses to get out of a pinch, not to mention a lot more damage.', 800, 5, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (216, 16, 'Advanced Missile', 'An upgraded Concussion Missile, this has most of the punching power of the Proton Torpedo while retaining most of a missile\\\'s speed.', 2000, 3, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (217, 16, 'Banshee Missile', 'A specially designed missile which will only damage its target\\\'s shields. Perfect for those missions where the bounty has to be captured alive.', 1500, 3, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (218, 16, 'Concussion Missile', 'This Missile is by far the fastest of most and is very useful. Some people even use this against other missiles.', 800, 3, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (219, 16, 'Mag Pulse Missile', 'Saps the weapons energy of its target on impact, causing them to recharge and giving you a window of opportunity.', 5000, 3, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (220, 16, 'Ion Space Mine', 'A variation on the standard mine which fires an ion cannon at its target rather than a laser cannon.', 2500, 3, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (221, 16, 'Laser Mine', 'A standard mine.', 1500, 3, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (222, 16, 'Missile Mine', 'A mine which contains a laser cannon and a missile fired at whichever craft destroys it.', 3000, 6, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (223, 16, 'Heavy Bomb', 'The ubiqitous Space Bomb, used by the Empire, Alliance, and pretty much everyone else. Don\\\'t leave home without some if you\\\'re planning to take on capital ships. Requires a Heavy Warhead launcher.', 20000, 10, 0, 0, -1, -1, 4, 0);
INSERT INTO `ssl_parts` VALUES (224, 16, 'Heavy Rocket', 'The Heavy Rocket, ideal for taking out medium-sized ships. Requires a Heavy Warhead launcher.', 15000, 8, 0, 0, -1, -1, 4, 0);
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

#
# Dumping data for table `ssl_partsales`
#

INSERT INTO `ssl_partsales` VALUES (12, 1, 228, 4, 1000, 1035634962);
INSERT INTO `ssl_partsales` VALUES (2, 1, 105, 1, 1000, 1035625188);
INSERT INTO `ssl_partsales` VALUES (3, 1, 101, 1, 1000, 1035625614);
INSERT INTO `ssl_partsales` VALUES (4, 1, 19, 2, 1000, 1035625662);
INSERT INTO `ssl_partsales` VALUES (5, 1, 19, 2, 1000, 1035625685);
INSERT INTO `ssl_partsales` VALUES (10, 1, 115, 5, 1000, 1035634840);
INSERT INTO `ssl_partsales` VALUES (13, 1, 226, 6, 1000, 1035635008);
INSERT INTO `ssl_partsales` VALUES (16, 1, 156, 4, 1000, 1035635165);
INSERT INTO `ssl_partsales` VALUES (9, 1, 195, 3, 1000, 1035625949);
INSERT INTO `ssl_partsales` VALUES (15, 1, 62, 3, 1000, 1035635120);
INSERT INTO `ssl_partsales` VALUES (17, 4, 102, 13, 666, 1035638910);
INSERT INTO `ssl_partsales` VALUES (18, 4, 102, 13, 666, 1035638915);
INSERT INTO `ssl_partsales` VALUES (19, 4, 102, 13, 666, 1035638922);
INSERT INTO `ssl_partsales` VALUES (20, 4, 117, 14, 666, 1035638977);
INSERT INTO `ssl_partsales` VALUES (21, 4, 57, 15, 666, 1035639153);
INSERT INTO `ssl_partsales` VALUES (22, 4, 61, 15, 666, 1035639165);
INSERT INTO `ssl_partsales` VALUES (23, 4, 65, 15, 666, 1035639181);
INSERT INTO `ssl_partsales` VALUES (24, 4, 229, 19, 666, 1035639246);
INSERT INTO `ssl_partsales` VALUES (25, 4, 209, 16, 666, 1035639277);
INSERT INTO `ssl_partsales` VALUES (26, 4, 218, 16, 666, 1035639308);
INSERT INTO `ssl_partsales` VALUES (27, 4, 218, 16, 666, 1035639314);
INSERT INTO `ssl_partsales` VALUES (28, 4, 218, 16, 666, 1035639322);
INSERT INTO `ssl_partsales` VALUES (29, 4, 218, 16, 666, 1035639329);
INSERT INTO `ssl_partsales` VALUES (30, 4, 218, 16, 666, 1035639335);
INSERT INTO `ssl_partsales` VALUES (31, 4, 218, 16, 666, 1035639341);
INSERT INTO `ssl_partsales` VALUES (32, 4, 218, 16, 666, 1035639349);
INSERT INTO `ssl_partsales` VALUES (33, 4, 218, 16, 666, 1035639357);
INSERT INTO `ssl_partsales` VALUES (34, 4, 218, 16, 666, 1035639364);
INSERT INTO `ssl_partsales` VALUES (35, 4, 218, 16, 666, 1035639370);
INSERT INTO `ssl_partsales` VALUES (36, 4, 34, 17, 666, 1035639415);
INSERT INTO `ssl_partsales` VALUES (37, 4, 34, 17, 666, 1035639421);
INSERT INTO `ssl_partsales` VALUES (38, 4, 34, 17, 666, 1035639428);
INSERT INTO `ssl_partsales` VALUES (39, 4, 34, 17, 666, 1035639434);
INSERT INTO `ssl_partsales` VALUES (40, 4, 16, 18, 666, 1035639476);
INSERT INTO `ssl_partsales` VALUES (41, 4, 16, 18, 666, 1035639483);
INSERT INTO `ssl_partsales` VALUES (42, 4, 15, 18, 666, 1035639496);
INSERT INTO `ssl_partsales` VALUES (43, 4, 15, 18, 666, 1035639502);
INSERT INTO `ssl_partsales` VALUES (44, 4, 50, 20, 666, 1035639547);
INSERT INTO `ssl_partsales` VALUES (45, 4, 48, 19, 666, 1035639562);
INSERT INTO `ssl_partsales` VALUES (46, 4, 52, 19, 666, 1035639579);
INSERT INTO `ssl_partsales` VALUES (47, 4, 51, 19, 666, 1035639596);
INSERT INTO `ssl_partsales` VALUES (48, 4, 158, 20, 666, 1035639618);
INSERT INTO `ssl_partsales` VALUES (49, 4, 178, 20, 666, 1035639656);
INSERT INTO `ssl_partsales` VALUES (50, 4, 177, 20, 666, 1035639671);
INSERT INTO `ssl_partsales` VALUES (51, 4, 45, 19, 666, 1035639690);
INSERT INTO `ssl_partsales` VALUES (52, 4, 41, 19, 666, 1035639703);
INSERT INTO `ssl_partsales` VALUES (53, 4, 194, 19, 666, 1035639723);
INSERT INTO `ssl_partsales` VALUES (54, 4, 198, 19, 666, 1035639738);
INSERT INTO `ssl_partsales` VALUES (55, 4, 198, 19, 666, 1035639744);
INSERT INTO `ssl_partsales` VALUES (56, 4, 198, 19, 666, 1035639753);
INSERT INTO `ssl_partsales` VALUES (57, 4, 159, 19, 666, 1035639797);
INSERT INTO `ssl_partsales` VALUES (58, 4, 162, 19, 666, 1035639816);
INSERT INTO `ssl_partsales` VALUES (59, 4, 202, 19, 666, 1035639833);
INSERT INTO `ssl_partsales` VALUES (60, 4, 204, 19, 666, 1035639849);
INSERT INTO `ssl_partsales` VALUES (61, 4, 77, 13, 666, 1035639908);
INSERT INTO `ssl_partsales` VALUES (62, 4, 86, 19, 666, 1035639924);
INSERT INTO `ssl_partsales` VALUES (63, 4, 80, 20, 666, 1035639945);
INSERT INTO `ssl_partsales` VALUES (64, 4, 75, 20, 666, 1035639960);
INSERT INTO `ssl_partsales` VALUES (65, 4, 4, 19, 666, 1035639979);
INSERT INTO `ssl_partsales` VALUES (66, 4, 149, 19, 666, 1035640041);
INSERT INTO `ssl_partsales` VALUES (67, 4, 176, 20, 666, 1035640061);
INSERT INTO `ssl_partsales` VALUES (68, 4, 155, 19, 666, 1035640103);
INSERT INTO `ssl_partsales` VALUES (69, 4, 155, 19, 666, 1035640109);
INSERT INTO `ssl_partsales` VALUES (70, 4, 155, 19, 666, 1035640117);
INSERT INTO `ssl_partsales` VALUES (71, 4, 155, 19, 666, 1035640126);
INSERT INTO `ssl_partsales` VALUES (72, 4, 143, 19, 666, 1035640167);
INSERT INTO `ssl_partsales` VALUES (73, 4, 106, 19, 666, 1035640486);
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

#
# Dumping data for table `ssl_parttypes`
#

INSERT INTO `ssl_parttypes` VALUES (1, 'Beam and Field Devices', 'These parts allow you to interact with other ships without actually firing at them, which takes all the fun out of it. They are useful, though.');
INSERT INTO `ssl_parttypes` VALUES (2, 'Blasters', 'Need to mess someone up? These will help you make them regret what they said about your mother.');
INSERT INTO `ssl_parttypes` VALUES (3, 'Boarding Devices', 'For those occasions when you want to go meet and greet someone.');
INSERT INTO `ssl_parttypes` VALUES (4, 'Communications', 'It\\\'s good to talk.');
INSERT INTO `ssl_parttypes` VALUES (5, 'Computers', 'Whether you don\\\'t want to deal with the hassle of working out the best intercept course, or just want to play Solitaire, these computers will do the job for you.');
INSERT INTO `ssl_parttypes` VALUES (6, 'Cosmetics', 'A few things to make your ship look better or be more comfortable.');
INSERT INTO `ssl_parttypes` VALUES (7, 'Engines and Hyperdrives', 'After all, there\\\'s no point having a ship if you can\\\'t get from A to B.');
INSERT INTO `ssl_parttypes` VALUES (8, 'Hull Plating', 'Ramming speed!');
INSERT INTO `ssl_parttypes` VALUES (9, 'Other Items', 'Doors, pads, and other things that don\\\'t really fit in anywhere else.');
INSERT INTO `ssl_parttypes` VALUES (10, 'Power Supply', 'Without one of these, it\\\'s awful dark and cold in space.');
INSERT INTO `ssl_parttypes` VALUES (11, 'Security', 'Sometimes, despite your best efforts, you get boarded. It happens to the best of us. These parts provide a good way to get rid of those unwanted visitors... or that strange uncle you don\\\'t want to see.');
INSERT INTO `ssl_parttypes` VALUES (12, 'Sensors', 'For those times when eyes and ears don\\\'t cut the mustard.');
INSERT INTO `ssl_parttypes` VALUES (13, 'Shields', 'Parts to keep the mustard out. Weapons fire, too.');
INSERT INTO `ssl_parttypes` VALUES (14, 'Stealth', 'Hiding might not be the most exciting course of action, but it will often save your mustard.');
INSERT INTO `ssl_parttypes` VALUES (15, 'Warhead Launchers', 'Warheads are great, but not much use if you have to throw them out of your cargo bay yourself.');
INSERT INTO `ssl_parttypes` VALUES (16, 'Warheads', 'Things that make you go boom.');
INSERT INTO `ssl_parttypes` VALUES (17, 'Experimental Items', 'Many of the coolest items in the SSL are here. It\\\'s a pity most of them are dangerously unstable.');
INSERT INTO `ssl_parttypes` VALUES (18, 'Special Edition', 'Proven parts that are either too dangerous or too exclusive for the general membership of the BHG.');
INSERT INTO `ssl_parttypes` VALUES (19, 'Consumables', 'Unless you can live in a vacuum, consumables are definitely a good thing.');
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

#
# Dumping data for table `ssl_sales`
#

INSERT INTO `ssl_sales` VALUES (1, 1, 'Testmobile', 1000, '', 1035624750);
INSERT INTO `ssl_sales` VALUES (4, 5, 'Template', 666, '', 1035638885);
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

#
# Dumping data for table `ssl_shipparts`
#

INSERT INTO `ssl_shipparts` VALUES (1, 1, 105, 1);
INSERT INTO `ssl_shipparts` VALUES (2, 1, 101, 1);
INSERT INTO `ssl_shipparts` VALUES (3, 1, 19, 2);
INSERT INTO `ssl_shipparts` VALUES (4, 1, 19, 2);
INSERT INTO `ssl_shipparts` VALUES (5, 1, 195, 3);
INSERT INTO `ssl_shipparts` VALUES (6, 1, 62, 3);
INSERT INTO `ssl_shipparts` VALUES (7, 1, 228, 4);
INSERT INTO `ssl_shipparts` VALUES (8, 1, 156, 4);
INSERT INTO `ssl_shipparts` VALUES (9, 1, 115, 5);
INSERT INTO `ssl_shipparts` VALUES (10, 1, 226, 6);
INSERT INTO `ssl_shipparts` VALUES (132, 5, 75, 20);
INSERT INTO `ssl_shipparts` VALUES (131, 5, 80, 20);
INSERT INTO `ssl_shipparts` VALUES (130, 5, 177, 20);
INSERT INTO `ssl_shipparts` VALUES (129, 5, 178, 20);
INSERT INTO `ssl_shipparts` VALUES (128, 5, 158, 20);
INSERT INTO `ssl_shipparts` VALUES (127, 5, 50, 20);
INSERT INTO `ssl_shipparts` VALUES (126, 5, 106, 19);
INSERT INTO `ssl_shipparts` VALUES (125, 5, 143, 19);
INSERT INTO `ssl_shipparts` VALUES (124, 5, 155, 19);
INSERT INTO `ssl_shipparts` VALUES (123, 5, 155, 19);
INSERT INTO `ssl_shipparts` VALUES (122, 5, 155, 19);
INSERT INTO `ssl_shipparts` VALUES (121, 5, 155, 19);
INSERT INTO `ssl_shipparts` VALUES (120, 5, 149, 19);
INSERT INTO `ssl_shipparts` VALUES (119, 5, 4, 19);
INSERT INTO `ssl_shipparts` VALUES (118, 5, 86, 19);
INSERT INTO `ssl_shipparts` VALUES (117, 5, 204, 19);
INSERT INTO `ssl_shipparts` VALUES (116, 5, 202, 19);
INSERT INTO `ssl_shipparts` VALUES (115, 5, 162, 19);
INSERT INTO `ssl_shipparts` VALUES (114, 5, 159, 19);
INSERT INTO `ssl_shipparts` VALUES (113, 5, 198, 19);
INSERT INTO `ssl_shipparts` VALUES (112, 5, 198, 19);
INSERT INTO `ssl_shipparts` VALUES (111, 5, 198, 19);
INSERT INTO `ssl_shipparts` VALUES (110, 5, 194, 19);
INSERT INTO `ssl_shipparts` VALUES (109, 5, 41, 19);
INSERT INTO `ssl_shipparts` VALUES (108, 5, 45, 19);
INSERT INTO `ssl_shipparts` VALUES (107, 5, 51, 19);
INSERT INTO `ssl_shipparts` VALUES (106, 5, 52, 19);
INSERT INTO `ssl_shipparts` VALUES (105, 5, 48, 19);
INSERT INTO `ssl_shipparts` VALUES (104, 5, 229, 19);
INSERT INTO `ssl_shipparts` VALUES (103, 5, 15, 18);
INSERT INTO `ssl_shipparts` VALUES (102, 5, 15, 18);
INSERT INTO `ssl_shipparts` VALUES (101, 5, 16, 18);
INSERT INTO `ssl_shipparts` VALUES (100, 5, 16, 18);
INSERT INTO `ssl_shipparts` VALUES (99, 5, 34, 17);
INSERT INTO `ssl_shipparts` VALUES (98, 5, 34, 17);
INSERT INTO `ssl_shipparts` VALUES (97, 5, 34, 17);
INSERT INTO `ssl_shipparts` VALUES (96, 5, 34, 17);
INSERT INTO `ssl_shipparts` VALUES (95, 5, 218, 16);
INSERT INTO `ssl_shipparts` VALUES (94, 5, 218, 16);
INSERT INTO `ssl_shipparts` VALUES (93, 5, 218, 16);
INSERT INTO `ssl_shipparts` VALUES (92, 5, 218, 16);
INSERT INTO `ssl_shipparts` VALUES (91, 5, 218, 16);
INSERT INTO `ssl_shipparts` VALUES (90, 5, 218, 16);
INSERT INTO `ssl_shipparts` VALUES (89, 5, 218, 16);
INSERT INTO `ssl_shipparts` VALUES (88, 5, 218, 16);
INSERT INTO `ssl_shipparts` VALUES (87, 5, 218, 16);
INSERT INTO `ssl_shipparts` VALUES (86, 5, 218, 16);
INSERT INTO `ssl_shipparts` VALUES (85, 5, 209, 16);
INSERT INTO `ssl_shipparts` VALUES (84, 5, 65, 15);
INSERT INTO `ssl_shipparts` VALUES (83, 5, 61, 15);
INSERT INTO `ssl_shipparts` VALUES (82, 5, 57, 15);
INSERT INTO `ssl_shipparts` VALUES (81, 5, 117, 14);
INSERT INTO `ssl_shipparts` VALUES (80, 5, 77, 13);
INSERT INTO `ssl_shipparts` VALUES (79, 5, 102, 13);
INSERT INTO `ssl_shipparts` VALUES (78, 5, 102, 13);
INSERT INTO `ssl_shipparts` VALUES (77, 5, 102, 13);
INSERT INTO `ssl_shipparts` VALUES (133, 5, 176, 20);
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

#
# Dumping data for table `ssl_ships`
#

INSERT INTO `ssl_ships` VALUES (1, 1, 'Muskrat Anniversary Edition', 'A special, cheap version of the Muskrat available for trainees to use as their first ship.', 150000, 1);
INSERT INTO `ssl_ships` VALUES (5, 5, 'Cadre Starfighter', 'The first ship to ever by produced by Dak`wind Enterprises (EDE). Designed by Ehart, the companys director to be all he would ever want in a ship. This ship is not mass produced and is only available to the winning leader in the Cadre Games run by Ehart hmself. The ship has been designed to be fast and reliable. It will even give as good as it gets! The main design of the ship is to be able to transport an entire Cadre and a few prisinors from the hunt. All in all, it\\\'s the ship everyone would want but only the best can have.', 0, 5);
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

#
# Dumping data for table `ssl_shiptypes`
#

INSERT INTO `ssl_shiptypes` VALUES (1, 'Fighters', 'Small & maneuverable, fighters are great for the hunter that might see a lot of space combat and doesn\\\'t believe in moving slowly.');
INSERT INTO `ssl_shiptypes` VALUES (2, 'Freighters', 'With plenty of space for expansion, freighters are perfect for any scum who doesn\\\'t mind having a slow yet powerful ship at their command.');
INSERT INTO `ssl_shiptypes` VALUES (3, 'Hybrids', 'When it comes to ships, a hybrid is one of the best you can find, with speed and weapons as well as a little room for a few extra items that you might need.');
INSERT INTO `ssl_shiptypes` VALUES (4, 'Transports', 'Transports are much like freighters as room goes, but can also hold plenty of passengers or prisoners that you might need to bring in.');
INSERT INTO `ssl_shiptypes` VALUES (5, 'Special Edition', 'Special Edition ships are a limited thing, so get them while you can before the next set is up. Very few can own them due to the price but special craft are by far the best ships for any task.');
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

#
# Dumping data for table `ssl_stats`
#

INSERT INTO `ssl_stats` VALUES (1, 0, 0, 0, 0, 0, 0, '0.00', 30);
INSERT INTO `ssl_stats` VALUES (2, 0, 0, 0, 0, 0, 0, '0.00', 100);
INSERT INTO `ssl_stats` VALUES (3, 0, 0, 0, 0, 0, 0, '0.00', 400);
INSERT INTO `ssl_stats` VALUES (4, 0, 0, 0, 0, 0, 0, '0.00', 150);
INSERT INTO `ssl_stats` VALUES (5, 0, 0, 0, 0, 0, 0, '0.00', 420);
INSERT INTO `ssl_stats` VALUES (6, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (7, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (8, 0, 0, 0, 0, 0, 0, '0.00', 30);
INSERT INTO `ssl_stats` VALUES (9, 0, 0, 0, 0, 0, 0, '0.00', 60);
INSERT INTO `ssl_stats` VALUES (10, 0, 0, 0, 0, 0, 0, '0.00', 50);
INSERT INTO `ssl_stats` VALUES (11, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (12, 0, 0, 0, 0, 0, 0, '0.00', 8);
INSERT INTO `ssl_stats` VALUES (13, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (14, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (15, 0, 0, 0, 0, 0, 0, '0.00', 60);
INSERT INTO `ssl_stats` VALUES (16, 0, 0, 0, 0, 0, 0, '0.00', 10);
INSERT INTO `ssl_stats` VALUES (17, 0, 0, 0, 0, 0, 0, '0.00', 90);
INSERT INTO `ssl_stats` VALUES (18, 0, 0, 0, 0, 0, 0, '0.00', 10);
INSERT INTO `ssl_stats` VALUES (19, 0, 0, 0, 0, 0, 0, '0.00', 10);
INSERT INTO `ssl_stats` VALUES (20, 0, 0, 0, 0, 0, 0, '0.00', 8);
INSERT INTO `ssl_stats` VALUES (21, 0, 0, 0, 0, 0, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (22, 0, 0, 0, 0, 0, 0, '0.00', 400);
INSERT INTO `ssl_stats` VALUES (23, 0, 0, 0, 0, 0, 0, '0.00', 8);
INSERT INTO `ssl_stats` VALUES (24, 0, 0, 0, 0, 0, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (25, 0, 0, 0, 0, 0, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (26, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (27, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (28, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (29, 0, 0, 0, 0, 0, 0, '0.00', 4);
INSERT INTO `ssl_stats` VALUES (30, 0, 0, 0, 0, 0, 0, '0.00', 18);
INSERT INTO `ssl_stats` VALUES (31, 0, 0, 0, 0, 0, 0, '0.00', 25);
INSERT INTO `ssl_stats` VALUES (32, 0, 0, 0, 0, 0, 0, '0.00', 25);
INSERT INTO `ssl_stats` VALUES (33, 0, 0, 0, 0, 0, 0, '0.00', 45);
INSERT INTO `ssl_stats` VALUES (34, 0, 0, 0, 0, 0, 0, '0.00', 45);
INSERT INTO `ssl_stats` VALUES (35, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (36, 0, 0, 0, 0, 0, 0, '0.00', 200);
INSERT INTO `ssl_stats` VALUES (37, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (38, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (39, 0, 0, 0, 0, 0, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (40, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (41, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (42, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (43, 0, 0, 0, 0, 0, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (44, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (45, 0, 0, 0, 0, 0, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (46, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (47, 0, 0, 0, 0, 0, 0, '0.00', 30);
INSERT INTO `ssl_stats` VALUES (48, 0, 0, 0, 0, 0, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (49, 0, 0, 0, 0, 0, 0, '0.00', 30);
INSERT INTO `ssl_stats` VALUES (50, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (51, 0, 0, 0, 0, 0, 0, '0.00', 25);
INSERT INTO `ssl_stats` VALUES (52, 0, 0, 0, 0, 0, 0, '0.00', 25);
INSERT INTO `ssl_stats` VALUES (53, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (54, 0, 0, 0, 0, 0, 0, '0.00', 50);
INSERT INTO `ssl_stats` VALUES (55, 0, 0, 0, 0, 0, 0, '0.00', 60);
INSERT INTO `ssl_stats` VALUES (56, 0, 0, 0, 0, 0, 0, '0.00', 70);
INSERT INTO `ssl_stats` VALUES (57, 0, 0, 0, 0, 0, 0, '0.00', 70);
INSERT INTO `ssl_stats` VALUES (58, 0, 0, 0, 0, 0, 0, '0.00', 25);
INSERT INTO `ssl_stats` VALUES (59, 0, 0, 0, 0, 0, 0, '0.00', 30);
INSERT INTO `ssl_stats` VALUES (60, 0, 0, 0, 0, 0, 0, '0.00', 35);
INSERT INTO `ssl_stats` VALUES (61, 0, 0, 0, 0, 0, 0, '0.00', 35);
INSERT INTO `ssl_stats` VALUES (62, 0, 0, 0, 0, 0, 0, '0.00', 25);
INSERT INTO `ssl_stats` VALUES (63, 0, 0, 0, 0, 0, 0, '0.00', 30);
INSERT INTO `ssl_stats` VALUES (64, 0, 0, 0, 0, 0, 0, '0.00', 35);
INSERT INTO `ssl_stats` VALUES (65, 0, 0, 0, 0, 0, 0, '0.00', 35);
INSERT INTO `ssl_stats` VALUES (66, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (67, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (68, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (69, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (70, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (71, 0, 0, 0, 0, 0, 0, '0.00', 10);
INSERT INTO `ssl_stats` VALUES (72, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (73, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (74, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (75, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (76, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (77, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (78, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (79, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (80, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (81, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (82, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (83, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (84, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (85, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (86, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (87, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (88, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (89, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (90, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (91, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (92, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (93, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (94, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (95, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (96, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (97, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (98, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (99, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (100, 0, 0, 0, 5, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (101, 0, 0, 0, 20, 4, 0, '0.00', 50);
INSERT INTO `ssl_stats` VALUES (102, 0, 0, 0, 70, 14, 0, '0.00', 100);
INSERT INTO `ssl_stats` VALUES (103, 0, 0, 0, 0, 0, 0, '0.00', 60);
INSERT INTO `ssl_stats` VALUES (104, 0, 0, 0, 50, 10, 0, '0.00', 80);
INSERT INTO `ssl_stats` VALUES (105, 0, 0, 0, 40, 8, 0, '0.00', 65);
INSERT INTO `ssl_stats` VALUES (106, 0, 0, 0, 0, 0, 0, '0.20', 150);
INSERT INTO `ssl_stats` VALUES (107, 0, 0, 0, 0, 0, 0, '0.25', 120);
INSERT INTO `ssl_stats` VALUES (108, 0, 0, 0, 0, 0, 0, '0.50', 80);
INSERT INTO `ssl_stats` VALUES (109, 0, 0, 0, 0, 0, 0, '0.75', 60);
INSERT INTO `ssl_stats` VALUES (110, 0, 0, 0, 0, 0, 0, '1.00', 40);
INSERT INTO `ssl_stats` VALUES (111, 0, 0, 0, 0, 0, 0, '10.00', 5);
INSERT INTO `ssl_stats` VALUES (112, 0, 0, 0, 0, 0, 0, '2.00', 10);
INSERT INTO `ssl_stats` VALUES (113, 0, 0, 0, 0, 0, 0, '5.00', 10);
INSERT INTO `ssl_stats` VALUES (114, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (115, 0, 0, 0, 0, 0, 10, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (116, 0, 0, 0, 0, 0, 15, '0.00', 35);
INSERT INTO `ssl_stats` VALUES (117, 0, 0, 0, 0, 0, 20, '0.00', 50);
INSERT INTO `ssl_stats` VALUES (118, 0, 0, 0, 0, 4, 0, '0.00', 9);
INSERT INTO `ssl_stats` VALUES (119, 0, 0, 0, 0, 6, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (120, 0, 0, 0, 0, 8, 0, '0.00', 21);
INSERT INTO `ssl_stats` VALUES (121, 0, 80, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (122, 0, 20, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (123, 0, 1, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (124, 0, 50, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (125, 0, 25, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (126, 0, 30, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (127, 0, 40, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (128, 0, 10, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (129, 0, 35, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (130, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (131, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (132, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (133, 0, 0, 0, 0, 0, 0, '0.00', 3);
INSERT INTO `ssl_stats` VALUES (134, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (135, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (136, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (137, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (138, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (139, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (140, 14, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (141, 28, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (142, 45, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (143, 60, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (144, 0, 0, 0, 0, 0, 0, '0.00', 50);
INSERT INTO `ssl_stats` VALUES (145, 0, 0, 0, 0, 0, 0, '0.00', 100);
INSERT INTO `ssl_stats` VALUES (146, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (147, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (148, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (149, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (150, 0, 0, 0, 0, 0, 0, '0.00', 4);
INSERT INTO `ssl_stats` VALUES (151, 0, 0, 0, 0, 0, 0, '0.00', -30);
INSERT INTO `ssl_stats` VALUES (152, 0, 0, 0, 0, 0, 0, '0.00', -112);
INSERT INTO `ssl_stats` VALUES (153, 0, 0, 0, 0, 0, 0, '0.00', -75);
INSERT INTO `ssl_stats` VALUES (154, 0, 0, 0, 0, 0, 0, '0.00', -450);
INSERT INTO `ssl_stats` VALUES (155, 0, 0, 0, 0, 0, 0, '0.00', -600);
INSERT INTO `ssl_stats` VALUES (156, 0, 0, 0, 0, 0, 0, '0.00', -300);
INSERT INTO `ssl_stats` VALUES (157, 0, 0, 0, 0, 0, 0, '0.00', -225);
INSERT INTO `ssl_stats` VALUES (158, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (159, 0, 0, 0, 0, 0, 0, '0.00', 25);
INSERT INTO `ssl_stats` VALUES (160, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (161, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (162, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (163, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (164, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (165, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (166, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (167, 0, 0, 0, 0, 0, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (168, 0, 0, 0, 0, 0, 0, '0.00', 30);
INSERT INTO `ssl_stats` VALUES (169, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (170, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (171, 0, 0, 0, 0, 0, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (172, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (173, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (174, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (175, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (176, 0, 0, 0, 0, 0, 0, '0.00', 7);
INSERT INTO `ssl_stats` VALUES (177, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (178, 0, 0, 0, 0, 0, 0, '0.00', 10);
INSERT INTO `ssl_stats` VALUES (179, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (180, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (181, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (182, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (183, 0, 0, 0, 0, 0, 0, '0.00', 100);
INSERT INTO `ssl_stats` VALUES (184, 0, 0, 0, 0, 0, 0, '0.00', 3);
INSERT INTO `ssl_stats` VALUES (185, 0, 0, 0, 0, 0, 0, '0.00', 50);
INSERT INTO `ssl_stats` VALUES (186, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (187, 0, 0, 0, 0, 0, 0, '0.00', 10);
INSERT INTO `ssl_stats` VALUES (188, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (189, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (190, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (191, 0, 0, 0, 0, 0, 0, '0.00', 1);
INSERT INTO `ssl_stats` VALUES (192, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (193, 0, 0, 0, 0, 0, 0, '0.00', 80);
INSERT INTO `ssl_stats` VALUES (194, 0, 0, 0, 0, 0, 0, '0.00', 150);
INSERT INTO `ssl_stats` VALUES (195, 0, 0, 20, 0, 0, 0, '0.00', 50);
INSERT INTO `ssl_stats` VALUES (196, 0, 0, 40, 0, 0, 0, '0.00', 65);
INSERT INTO `ssl_stats` VALUES (197, 0, 0, 50, 0, 0, 0, '0.00', 80);
INSERT INTO `ssl_stats` VALUES (198, 0, 0, 70, 0, 0, 0, '0.00', 100);
INSERT INTO `ssl_stats` VALUES (199, 0, 0, 0, 0, 0, 0, '0.00', 15);
INSERT INTO `ssl_stats` VALUES (200, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (201, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (202, 0, 0, 0, 0, 0, 0, '0.00', 175);
INSERT INTO `ssl_stats` VALUES (203, 0, 0, 0, 0, 0, 0, '0.00', 4);
INSERT INTO `ssl_stats` VALUES (204, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (205, 0, 0, 0, 0, 0, 0, '0.00', 5);
INSERT INTO `ssl_stats` VALUES (206, 0, 0, 0, 0, 0, 0, '0.00', 60);
INSERT INTO `ssl_stats` VALUES (207, 0, 0, 0, 0, 0, 0, '0.00', 300);
INSERT INTO `ssl_stats` VALUES (208, 0, 0, 0, 0, 0, 0, '0.00', 40);
INSERT INTO `ssl_stats` VALUES (209, 0, 0, 0, 0, 0, 0, '0.00', 20);
INSERT INTO `ssl_stats` VALUES (210, 0, 0, 0, 0, 0, 0, '0.00', 3);
INSERT INTO `ssl_stats` VALUES (211, 0, 0, 0, 0, 0, 0, '0.00', 80);
INSERT INTO `ssl_stats` VALUES (212, 0, 0, 0, 0, 0, 0, '0.00', 80);
INSERT INTO `ssl_stats` VALUES (213, 0, 0, 0, 0, 0, 0, '0.00', 2);
INSERT INTO `ssl_stats` VALUES (214, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (215, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (216, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (217, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (218, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (219, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (220, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (221, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (222, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (223, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (224, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (225, 7, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (226, 1, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (227, 0, 0, 0, 0, 0, 0, '0.00', 0);
INSERT INTO `ssl_stats` VALUES (228, 0, 0, 0, 0, 0, 0, '0.00', 10);
INSERT INTO `ssl_stats` VALUES (229, 0, 0, 0, 0, 0, 0, '0.00', 30);

