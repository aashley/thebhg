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
$str_name = 'Jer\'s Drug Supplies';
$str_abbrev = 'JDS';

// The singular and plural forms of the items being sold. (This makes more
// sense with an example.)
$str_singular = 'item';
$str_plural = 'items';

// URL to the person information page for the Roster, placing <id> where the
// roster ID would go.
$roster_person_url = 'http://roster.thebhg.org/?page=person&amp;id=<id>';

// Singular and plural forms of whatever you want to call the plebs.
$str_person = 'hunter';
$str_people = 'hunters';

/*****************************************************************************/
// File specific strings.

/*****************************************************************************/
// top.php

// This is the sole line of output in the file. This will probably be an IMG
// tag when fully functional.
$str_top = '<IMG SRC="images/title.png" HEIGHT="110" WIDTH="655" ALT="Jer\'s Drug Supplies">';

/*****************************************************************************/
// menu.php: Edit this yourself. Nothing crucial here.

/*****************************************************************************/
// main.php

// Intro text.
$str_main_intro = <<<SMI
Welcome to Jer's Drug Supplies, your shop for drug-related paraphenalia.
<BR><BR>
Note for the humour-impaired: This is a joke. It's here simply to allow testing of the new store code. As you can see by browsing the catalogue, you can see the advanced item restriction systems available in this code in use. Items bought from this store will not be deducted from your account permanently, and will show up on the registries until the next time I empty out the database. :)
<BR><BR>
Just for those wondering why this is an advance, and because I'm bored, I'll go into a bit more detail. This store runs off Roster 3, and forms the first part of SSL 3 by implementing a basic store. It's considerably easier to modify than the current SSL/KIW code, as all of the front-end is actually handled by a strings file, a style sheet, and a configuration file. I've been testing this with the KIW data, and was able to set this store up in about ten minutes, excluding populating the item database.
<BR><BR>
It's best viewed in Mozilla, of course, but should work OK in pretty much everything else. There's nothing too complex going on here.
<BR><BR>
Any bugs found should be submitted on the <A HREF="http://bugs.thebhg.org/" TARGET="_top">bug tracker</A> on the "General Store" module. This will help with implementing the KIW quickly and painlessly once Roster 3 becomes the primary roster of the BHG.
<BR><BR>
<A HREF="mailto:jernai@iinet.net.au">Jernai Teifsel</A>, 29 June 2002
SMI;

/*****************************************************************************/
// catalogue.php

// The title on the catalogue page.
$str_cat_title = 'Having a party? Need to entertain your guests? Come on in.';

/*****************************************************************************/
// registries/index.php

// The introductory text for the registries.
$str_reg_intro = <<<SRI
Welcome to the JDS registries.
SRI;
