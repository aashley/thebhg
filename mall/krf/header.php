<?php

// Include CPD.
include_once('store.php');

// Execute this when you're ready to start the page.
function page_header() {
	ob_start('ob_gzhandler');

	// Start headers.
	echo <<<EOH
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html/loose.dtd">
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
	ob_end_flush();
	exit;
}

// Prints a list of OPTION tags for every person in the BHG.
function person_list($select = 0) {
	global $roster;

	$categories = $roster->GetDivisionCategories();
	foreach ($categories as $cat) {
		$divisions = $cat->GetDivisions();
		foreach ($divisions as $div) {
			if ($div->GetID() == 16) continue;
			$people = $div->GetMembers();
			foreach ($people as $pleb) {
				$all[$div->GetName()][$pleb->GetName()] = $pleb->GetID();
			}
		}
	}

	ksort($all);
	foreach ($all as $name=>$div) {
		ksort($div);
		foreach ($div as $pname=>$pleb) {
			if ($pleb == $select) $sel = ' SELECTED';
			else $sel = '';
			echo "<OPTION VALUE=\"$pleb\"$sel>$name: $pname</OPTION>\n";
		}
	}
}

// Returns a Roster URL for a person.
function roster_person($id) {
	global $roster_person_url;

	return str_replace('<id>', $id, $roster_person_url);
}

?>
