<?php
/* This is the strings file for CPD.
 *
 * Put simply, all of the strings that can be presented to the user are defined
 * here (apart from things like "SQL error"). This allows for easy deployment
 * of new stores, since config.php and strings.php are the only two files that
 * need to be changed.
 *
 * I suppose one day we could extend this to support multiple languages, but it
 * seems somewhat pointless.
 */

/*****************************************************************************/
// Global strings (used on multiple pages or in core.php)

// The name of the store, and the abbreviated form.
$str_name = 'Stalker Shipyards Limited';
$str_abbrev = 'SSL';

// The singular and plural forms of the items being sold. (This makes more
// sense with an example.)
$str_singular = 'ship';
$str_plural = 'ships';

// The singular and plural forms for bays, or pods, or whatever the fuck
// equipment bays end up being called.
$bay_singular = 'bay';
$bay_plural = 'bays';

// The singular and plural forms for mods.
$mod_singular = 'part';
$mod_plural = 'parts';

// Singular and plural forms for hulls.
$hull_singular = 'hull';
$hull_plural = 'hulls';

// URL to the person information page for the Roster, placing <id> where the
// roster ID would go.
$roster_person_url = 'http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=<id>';

// Base URL for the store, ending with a slash.
$base_url = 'http://mall.thebhg.org/ssl/';

// Singular and plural forms of whatever you want to call the plebs.
$str_person = 'hunter';
$str_people = 'hunters';

// Singular and plural forms of the volume unit.
$vol_singular = 'VU';
$vol_plural = 'VUs';

// Singular and plural forms of the length unit.
$len_singular = 'metre';
$len_plural = 'metres';

/*****************************************************************************/
// File specific strings.

/*****************************************************************************/
// top.php

// This is the sole line of output in the file. This will probably be an IMG
// tag when fully functional.
$str_top = '<CENTER><IMG SRC="images/top.gif" BORDER=0 WIDTH=601 HEIGHT=168></CENTER>';

/*****************************************************************************/
// menu.php: Edit this yourself. Nothing crucial here.

/*****************************************************************************/
// main.php

// Intro text.
$str_main_intro = <<<SMI
Welcome to Stalker Shipyards Limited (SSL). We are the official shipyards of the Bounty Hunters Guild. Within this Holonet site you will find numerous ships and parts which are currently available on the market to the hunters of the BHG. SSL is no longer a young company, but it is committed to constantly improving and updating its catalogue. Please enjoy your stay and choose carefully before purchasing. Any and all comments are appreciated. Simply click select "Contact Us" from the menu above if you have any questions that aren't answered in the FAQ.
SMI;

/*****************************************************************************/
// catalogue.php

// The title on the catalogue page.
$str_cat_title = 'Hull Catalogue';

// The part catalogue title.
$part_cat_title = 'Part Catalogue';

// The ship catalogue title.
$ship_cat_title = 'Ship Catalogue';

/*****************************************************************************/
// registries/index.php

// The introductory text for the registries.
$str_reg_intro = <<<SRI
Greetings, Hunter...
<BR><BR>
Welcome to the SSL registries. Here you can get information on every ship sold by Stalker Shipyards Limited to the hunters of the Bounty Hunter's Guild.
<BR><BR>
Please follow the links below to view your ships.
SRI;

/*****************************************************************************/
// junkyard.php

// Name of the Junkyard.
$junkyard_name = 'junkyard';
?>
