<?php
function title() {
	return 'Divisions';
}

function output() {
	global $roster;

	roster_header();
	$cats = $roster->GetDivisionCategories();
	foreach ($cats as $dc) {
		echo '<b>' . $dc->GetName() . '</b><br>';
		$divs = $dc->GetDivisions();
		foreach ($divs as $div) {
			echo '<a href="' . internal_link('division', array('id' => $div->GetID())) . '">' . str_replace(' ', '&nbsp;', $div->GetName()) . '</a><br>';
		}
		echo '<br>';
	}
	roster_footer(false);
}
?>
