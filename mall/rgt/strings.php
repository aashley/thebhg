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
$str_name = 'Royal Ground Transport';
$str_abbrev = 'RGT';

// The singular and plural forms of the items being sold. (This makes more
// sense with an example.)
$str_singular = 'vehicle';
$str_plural = 'vehicles';

// The singular and plural forms for bays, or pods, or whatever the fuck
// equipment bays end up being called.
$bay_singular = 'pod';
$bay_plural = 'pods';

// The singular and plural forms for mods.
$mod_singular = 'part';
$mod_plural = 'parts';

// Singular and plural forms for hulls.
$hull_singular = 'chassis';
$hull_plural = 'chassis';

// URL to the person information page for the Roster, placing <id> where the
// roster ID would go.
$roster_person_url = 'http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=<id>';

// Base URL for the store, ending with a slash.
$base_url = 'http://mall.thebhg.org/rgt/';

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
Welcome to Royal Ground Transport.
SMI;

/*****************************************************************************/
// catalogue.php

// The title on the catalogue page.
$str_cat_title = 'Chassis Catalogue';

// The part catalogue title.
$part_cat_title = 'Part Catalogue';

// The ship catalogue title.
$ship_cat_title = 'Vehicle Catalogue';

/*****************************************************************************/
// registries/index.php

// The introductory text for the registries.
$str_reg_intro = <<<SRI
Greetings, Hunter...
<BR><BR>
Welcome to the RGT registries. Here you can get information on every vehicle sold by Royal Ground Transport to the hunters of the Bounty Hunter's Guild.
<BR><BR>
Please follow the links below to view your ships.
SRI;

/*****************************************************************************/
// junkyard.php

// Name of the Junkyard.
$junkyard_name = 'junkyard';
?>
