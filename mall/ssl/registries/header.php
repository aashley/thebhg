<?php
ini_set('include_path', ini_get('include_path').':..');
include('../header.php');

$roster = new Roster('ssl-2.5-sail');

function reg_footer() {
	global $roster;

	echo '<HR NOSHADE SIZE=2><CENTER><SMALL>';
	$categories = $roster->GetDivisionCategories();
	foreach ($categories as $cat) {
		$cd = array();
		$divisions = $cat->GetDivisions();
		if (count($divisions)) {
			foreach ($divisions as $div) {
				$cd[] = '<A HREF="kabal.php?id=' . $div->GetID() . '">' . $div->GetName() . '</A>';
			}
		}
		echo implode(' | ', $cd);
		echo '<BR>';
	}
	echo "</SMALL>\n</CENTER>\n";
	page_footer();
}
?>
