<?php
/**
 * Main Roster Include File
 *
 * Including this file in your progam includes everything needed to make use
 * of the core features of the Roster.
 *
 * @access public
 * @package Roster
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.19 $
 */

/**
 * Include PEAR Date Object
 */
include_once 'Date.php';
/**
 * Include Base Object
 */
include_once('general/bhgobject.inc');
/**
 * Include Settings Object
 */
include_once('general/settings.inc');

/**
 * Include Parsers
 */
include_once('util/parse.inc');

/**
 * Include Primary Roster Object
 */
include_once('roster/rosterobject.inc');
/**
 * Include BioData Object (Biographical Data)
 */
include_once('roster/biodata.inc');
/**
 * Include Division Category Support
 */
include_once('roster/divisioncategory.inc');
/**
 * Include Division Support
 */
include_once('roster/division.inc');
/**
 * Include Kabal Support
 */
include_once('roster/kabal.inc');
/**
 * Include Wing Support
 */
include_once('roster/wing.inc');
/**
 * Include Cadre Support
 */
include_once('roster/cadre.inc');
/**
 * Include Positions
 */
include_once('roster/position.inc');
/**
 * Include Ranks
 */
include_once('roster/rank.inc');
/**
 * Include Primary Person Object
 */
include_once('roster/person.inc');
/**
 * Include Authentication Support
 */
include_once('roster/login.inc');
/**
 * Include HTTP Auth object
 */
include_once('util/login_http.inc');
/**
 * Include Person's History
 */
include_once('roster/personhistory.inc');
/**
 * Include History Event
 */
include_once('roster/historyitem.inc');

/**
 * Include Medal Board Access
 */
include_once('medalboard/medalboard.inc');
/**
 * Include Awarded Medal Support
 */
include_once('medalboard/awardedmedal.inc');
/**
 * Include Medals
 */
include_once('medalboard/medal.inc');
/**
 * Include Medal Categories
 */
include_once('medalboard/medalcategory.inc');
/**
 * Include Medal Groups
 */
include_once('medalboard/medalgroup.inc');

/**
 * Include News Board
 */
include_once('news/news.inc');
/**
 * Include News Item
 */
include_once('news/newsitem.inc');

/* vim: set ts=2 sw=2 fdm=marker: */

?>
