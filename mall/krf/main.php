<?php
include('header.php');
page_header();
echo $str_main_intro;
$roster = new Roster();
$tactician = $roster->SearchPosition(3);
if ($tactician) {
	$rank = $tactician[0]->GetRank();
	echo '<BR><H1>' . $rank->GetName() . ' ' . $tactician[0]->GetName() . ', Tactician</H1>';
}
page_footer();
?>
