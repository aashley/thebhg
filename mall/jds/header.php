<?php

// Include CPD.
include_once('store.php');

// Execute this when you're ready to start the page.
function page_header() {
	ob_start('ob_gzhandler');

	// Start headers.
	echo <<<EOH
<HTML>
<HEAD>
<TITLE>$str_name</TITLE>
<BASE TARGET="main">
<LINK REL="stylesheet" TYPE="text/css" HREF="style.css">
</HEAD>
<BODY>
EOH;
}

// Same for the end of the page.
function page_footer() {
	echo <<<EOF
</BODY>
</HTML>
EOF;
	header('Content-Length: ' . ob_get_length());
	ob_end_flush();
	exit;
}

// Returns a Roster URL for a person.
function roster_person($id) {
	global $roster_person_url;

	return str_replace('<id>', $id, $roster_person_url);
}

?>
