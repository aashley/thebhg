<?php

include_once 'roster.inc';

$roster = new Roster();

$divisions = $roster->getDivisions();

$lists = array();

foreach ($divisions as $division) {

	$list = $division->getMailingList();

	if ($list == 'none@thebhg.org')
		continue;

	if (!isset($lists[$list]) || !is_array($lists[$list]))
		$lists[$list] = array();

	print "Processing ".$division->getName()."...\n";
	foreach ($division->getMembers() as $person) {
		
		$lists[$list][] = $person->getEmail();

	}

}

// Special case list: reports@thebhg.org.
$lists['reports'] = array();

$reportees = array_merge($roster->searchPosition('DP'),
												 $roster->searchPosition('U'),
												 $roster->searchPosition('JUD'));

foreach ($reportees as $person) {

	// Commission only.
	if ($person->getDivision()->getID() == 10)
		$lists['reports'][] = $person->getEmail();
	
}

foreach ($lists as $name => $addresses) {

	if (is_numeric($name))
		continue;

	$name = str_replace('@thebhg.org', '', $name);

	$fp = fopen('/tmp/lists/'.$name, 'w');

	fwrite($fp, implode($addresses, "\n"));

	fclose($fp);

}

?>
