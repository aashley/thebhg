<?php
// Roster coder ID.
define('SCUM_CODER', 'www-42scum');

// Database connection string.
define('SCUM_DSN', 'mysql://thebhg:1IHfHTsAmILMwpP@localhost/thebhg');

// Database table prefix.
define('SCUM_PREFIX', 'scum_');

// News sections to show.
$sections = array(28, // Adjunct's Office
		  38, // Arena
		  20, // Cadre Games
		  27, // Citadel
		  21, // Dark Prince's Office
		  23, // Executor's Office
		  25, // Judicator's Office
		  17, // Kabal Authority
		  19, // Kabal Authority Cup
		  18, // Kabal Authority Games
		  26, // Marshal's Office
		  9,  // MyBHG
		  12, // Newsletter
		  24, // Overseer's Office
		  27, // Proctor's Office
		  1,  // Roster
		  7,  // Tactician's Office
		  8,  // Underlord's Office
		  13, // Xerokine Outlet Centre
);

// Users with administrative access.
$users = array('position' => array(1, 2, 5),
	       'uid'      => array(85, 666));

$enableGoogleSitemap = true;
?>
