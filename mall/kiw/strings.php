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
$str_name = 'Khan Industrial Weapons';
$str_abbrev = 'KIW';

// The singular and plural forms of the items being sold. (This makes more
// sense with an example.)
$str_singular = 'weapon';
$str_plural = 'weapons';

// URL to the person information page for the Roster, placing <id> where the
// roster ID would go.
$roster_person_url = 'http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=<id>';

// Base URL for the store, ending with a slash.
$base_url = 'http://mall.thebhg.org/kiw/';

// Singular and plural forms of whatever you want to call the plebs.
$str_person = 'hunter';
$str_people = 'hunters';

/*****************************************************************************/
// File specific strings.

/*****************************************************************************/
// top.php

// This is the sole line of output in the file. This will probably be an IMG
// tag when fully functional.
$str_top = 'Title graphic goes here.';

/*****************************************************************************/
// menu.php: Edit this yourself. Nothing crucial here.

/*****************************************************************************/
// main.php

// Intro text.
$str_main_intro = <<<SMI
Welcome to Khan Industrial Weapons, your one stop shop for all your bounty hunting needs. Whether you         need something quiet and deadly, or something that could take out Coruscant in a single shot, you'll find it here. We sell our products only to those who have been trained to safely use them, the members of the <a href="http://www.thebhg.org" target="_blank">Bounty Hunters Guild</a>, and some of the more powerful weapons are only sold to the higher ranking members of the Guild, members of particular kabals, or people with specific skills. If you have any questions, please check the FAQ, and if the answer isn't there, e-mail the Tactician.
SMI;

/*****************************************************************************/
// catalogue.php

// The title on the catalogue page.
$str_cat_title = 'Need an excuse to kill something? You\'re in the right place.';

/*****************************************************************************/
// registries/index.php

// The introductory text for the registries.
$str_reg_intro = <<<SRI
Welcome to the KIW registries.
SRI;
