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
			$members = $cadre->GetMembers();
			$leader = array_shift($members);
			
			$line = sprintf('%s: Led by %s (#%d).', $cadre->GetName(), $leader->GetName(), $leader->GetID());

			if (count($members) > 0) {
				$names = array();
				foreach ($members as $member)
					$names[] = sprintf('%s (#%d)', $member->GetName(), $member->GetID());
				$line .= ' Members: '.implode('; ', $names).'.';
			}

			$output[] = $line;
		}
		echo implode("\n", $output);
	}
}
else {
	echo 'No cadres were found matching your search criteria.';
}
?>
