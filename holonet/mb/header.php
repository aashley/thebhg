<?php
include_once('roster.inc');
$mb = new MedalBoard();

function mb_header() {
	echo '<table border=0 width="100%"><tr valign="top"><td width="90%">';
}

function mb_footer($show_list = true) {
	global $mb;

	if ($show_list == false) {
		return;
	}
	
	$cats = $mb->GetMedalCategories();
	foreach ($cats as $cat) {
		$items = array();
		$groups = $cat->GetMedalGroups();
		foreach ($groups as $group) {
			$items[$group->getName()] = internal_link('browse', array('group' => $group->GetID()));
		}
		addMenu($cat->getName(), $items);
	}


}
?>
