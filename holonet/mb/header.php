<?php
include_once('roster.inc');
$mb = new MedalBoard();

function mb_header() {
	echo '<table border=0 width="100%"><tr valign="top"><td width="90%">';
}

function mb_footer($show_list = true) {
	global $mb;

	if ($show_list == false) {
		echo '</td></tr></table>';
		return;
	}
	
	echo '</td><td style="border-left: solid 1px black">Medals<small>';
	
	$cats = $mb->GetMedalCategories();
	foreach ($cats as $cat) {
		echo '<br>';
		$groups = $cat->GetMedalGroups();
		foreach ($groups as $group) {
			echo '<br><a href="' . internal_link('browse', array('group' => $group->GetID())) . '">' . str_replace(' ', '&nbsp;', $group->GetName()) . '</a>';
		}
	}

	echo '</small></td></tr></table>';
}
?>
