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
$str_name = 'Darth Shadow Manufacturing';
$str_abbrev = 'DSM';

// The singular and plural forms of the items being sold. (This makes more
// sense with an example.)
$str_singular = 'item';
$str_plural = 'items';

// The singular and plural forms for bays, or pods, or whatever the fuck
// equipment bays end up being called.
$bay_singular = 'bay';
$bay_plural = 'bays';

// The singular and plural forms for mods.
$mod_singular = 'modification';
$mod_plural = 'modifications';

// Singular and plural forms for hulls.
$hull_singular = 'armour';
$hull_plural = 'armours';

// URL to the person information page for the Roster, placing <id> where the
// roster ID would go.
$roster_person_url = 'http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=<id>';

// Base URL for the store, ending with a slash.
$base_url = 'http://mall.thebhg.org/dsm/';

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
Welcome to Darth Shadow Manufacturing, the BHG's armory. Made to the highest quality standards and using some of the rarest materials known in the galaxy, if you need that extra level of protection, you will find it here. From common leather to the finest Mandalorian alloys, we have the armour to suit just about any hunter's needs.
SMI;

/*****************************************************************************/
// catalogue.php

// The title on the catalogue page.
$str_cat_title = 'Armour Catalogue';

// The part catalogue title.
$part_cat_title = 'Modification Catalogue';

// The ship catalogue title.
$ship_cat_title = 'Pre-Assembled Armour Catalogue';

/*****************************************************************************/
// registries/index.php

// The introductory text for the registries.
$str_reg_intro = <<<SRI
Remember, a smart person always wears protection.
SRI;

/*****************************************************************************/
// junkyard.php

// Name of the Junkyard.
$junkyard_name = 'junkyard';
?>
