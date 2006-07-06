<?php
error_reporting(E_NONE);

header('Content-Type: text/plain');

include_once 'roster.inc';
$roster = new Roster;

$cadres = $roster->SearchCadre($_GET['search']);
if (is_array($cadres) && count($cadres) > 0) {
	if (count($cadres) > 3) {
		echo count($cadres).' matches have been found. Please narrow down your criteria to see more information.';
	}
	else {
		$output = array();
		foreach ($cadres as $cadre) {
			$names = array();
			foreach ($cadre->GetMembers() as $member) {
				$names[] = sprintf('%s (#%d)', $member->GetName(), $member->GetID());
			}
			
			$output[] = sprintf('Cadre %s: %s.', implode('; ', $names));
		}
		echo implode("\n", $output);
	}
}
else {
	echo 'No cadres were found matching your search criteria.';
}
?>
