<?php
$rank = new Rank($_REQUEST['id']);

function title() {
	global $rank;

	return 'Rank :: ' . html_escape($rank->GetName());
}

function output() {
	global $rank;

	roster_header();
	echo 'Abbreviation: ' . html_escape($rank->GetAbbrev()) . '<br>';
	if ($rank->IsUnlimitedCredits()) {
		echo 'Hunters can only attain this rank through being promoted to it by the Dark Prince.<br>Hunters that hold this rank have unlimited credits.<br>';
	}
	else {
		echo 'Credits needed to achieve rank: ' . number_format($rank->GetRequiredCredits()) . '<br>';
		if (!$rank->IsAlwaysAvailable()) {
			echo 'You must be a hunter before you can be promoted to this rank.<br>';
		}
	}
	echo '<br><a href="#" onClick="history.go(-1); return false;">Back</a>';
	roster_footer();
}
?>
