<?php
$title = 'About MyBHG';
include('header.php');

$jer = $roster->GetPerson(666);

$table = new Table();
$table->StartRow();
$table->AddCell('MyBHG has been the primary BHG web site since the second of May, 2003. For those with a morbid interest in how all this is done, the site\'s code is written in PHP. Most of the blocks on the side of the page are generated from XML news feeds which are then parsed by a home-grown PHP class, the existence of which proves that you really can re-invent the wheel. Speaking of news feeds, an RSS news feed is available from <a href="http://' . $_SERVER['HTTP_HOST'] . PARENT_DIR . 'backend.php">http://' . $_SERVER['HTTP_HOST'] . PARENT_DIR . 'backend.php</a>.<br /><br />Content on this site is covered by <a href="http://www.emperorshammer.org/disclaim.htm">the Emperor\'s Hammer Copyright &amp; Disclaimers</a>.<br /><br />Below are some credits and some general site information, but you\'re not interested in those, so you can return to the main page now.', 2);
$table->EndRow();
$table->AddRow('MyBHG Version:', '<a href="changelog.php">' . VERSION . '</a>');
$table->AddRow('Code:', '&copy; 2003 <a href="mailto:' . $jer->GetEmail() . '">Adam Harvey</a>');
$themers = $theme->GetAuthors();
$table->StartRow();
$table->AddCell($theme->GetName() . ' Theme By:', 1, count($themers));
$links = array();
foreach ($themers as $themer) {
	$themer = $roster->GetPerson($themer);
	$links[$themer->GetName()] = '<a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=' . $themer->GetID() . '">' . htmlspecialchars($themer->GetName()) . '</a>';
}
$first = true;
ksort($links);
foreach ($links as $link) {
	if ($first) {
		$first = false;
	}
	else {
		$table->StartRow();
	}
	$table->AddCell($link);
	$table->EndRow();
}

$table->EndTable();

$show_blocks = true;
include('footer.php');
?>
