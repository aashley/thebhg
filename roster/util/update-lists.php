<?php

include_once 'roster.inc';

$roster = new Roster();

$divisions = $roster->getDivisions();

$lists = array();

foreach ($divisions as $division) {

	$list = $division->getMailingList();

	if ($list == 'none@thebhg.org')
		continue;

	if (!is_array($lists[$list]))
		$lists[$list] = array();

	foreach ($division->getMembers() as $person) {
		
		$lists[$list][] = $person->getEmail();

	}

}

foreach ($lists as $name => $addresses) {

	$name = str_replace('@thebhg.org', '', $name);

	$fp = fopen('/tmp/lists/'.$name, 'w');

	fwrite($fp, implode($addresses, "\n"));

	fclose($fp);

}

?>
