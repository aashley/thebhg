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
$str_name = 'Ehart Cybernetic Systems';
$str_abbrev = 'ECS';

// The singular and plural forms of the items being sold. (This makes more
// sense with an example.)
$str_singular = 'item';
$str_plural = 'items';

// URL to the person information page for the Roster, placing <id> where the
// roster ID would go.
$roster_person_url = 'http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=<id>';

// Base URL for the store, ending with a slash.
$base_url = 'http://mall.thebhg.org/ecs/';

// Singular and plural forms of whatever you want to call the plebs.
$str_person = 'hunter';
$str_people = 'hunters';

/*****************************************************************************/
// File specific strings.

/*****************************************************************************/
// top.php

// This is the sole line of output in the file. This will probably be an IMG
// tag when fully functional.
$str_top = 'Welcome to ' . $str_name;

/*****************************************************************************/
// menu.php: Edit this yourself. Nothing crucial here.

/*****************************************************************************/
// main.php

// Intro text.
$str_main_intro = <<<SMI
Welcome to $str_name. This intro needs to be replaced with a real intro before the site goes live.
SMI;

/*****************************************************************************/
// catalogue.php

// The title on the catalogue page.
$str_cat_title = 'Welcome to the ' . $str_name . ' catalogue.';

/*****************************************************************************/
// registries/index.php

// The introductory text for the registries.
$str_reg_intro = <<<SRI
Welcome to the $str_name registries.
SRI;
