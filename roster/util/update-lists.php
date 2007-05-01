<?php

include_once 'roster.inc';

$roster = new Roster();

$divisions = $roster->getDivisions();

$lists = array();

foreach ($divisions as $division) {

	$list = $division->getMailingList();

	if ($list == 'none@thebhg.org'
			|| $list === false
			|| strlen($list) == 0)
		continue;

	if (!isset($lists[$list]) || !is_array($lists[$list]))
		$lists[$list] = array();

	print "Processing ".$division->getName()."... ";

	$members = $division->getMembers();

	if (is_array($members)) {

		foreach ($division->getMembers() as $person) {

			$lists[$list][] = $person->getEmail();

		}

		print "$list now contains ".count($lists[$list])." recipients.\n";

	} else {

		print "no recipients to add.\n";

	}

}

// Special case list: reports@thebhg.org.
$lists['reports'] = array();

$reportees = array_merge($roster->searchPosition('DP'),
												 $roster->searchPosition('U'),
												 $roster->searchPosition('WARD'));

foreach ($reportees as $person) {

	// Commission only.
	if ($person->getDivision()->getID() == 10)
		$lists['reports'][] = $person->getEmail();

}

$lists['chiefs'] = array();
$chiefs = $roster->searchPosition('CH');
foreach ($chiefs as $person)
	$lists['chiefs'][] = $person->getEmail();

$lists['cras'] = array();
$cras = $roster->searchPosition('CRA');
foreach ($cras as $person)
	$lists['cras'][] = $person->getEmail();

foreach ($lists as $name => $addresses) {

	if (is_numeric($name))
		continue;

	$name = str_replace('@thebhg.org', '', $name);

	$fp = fopen('/tmp/lists/'.$name, 'w');

	fwrite($fp, implode($addresses, "\n"));

	fclose($fp);

}

?>
