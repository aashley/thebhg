<?php
$pleb = $roster->GetPerson($_REQUEST['id']);

function title() {
	global $pleb;

	return 'Medals :: ' . $pleb->GetName();
}

function output() {
	global $pleb, $page;

	roster_header();

	$bydate = (isset($_REQUEST['bydate']) && $_REQUEST['bydate'] == 1);

	if ($bydate) {
		echo '<a href="' . internal_link($page, array('id'=>$pleb->GetID(), 'bydate'=>0)) . '">Sort by importance</a> | <b>Sort by date</b>';
	}
	else {
		echo '<b>Sort by importance</b> | <a href="' . internal_link($page, array('id'=>$pleb->GetID(), 'bydate'=>1)) . '">Sort by date</a>';
	}

	hr();

	$table = new Table('', true);
	$table->StartRow();
	$table->AddHeader('Date');
	$table->AddHeader('Medal');
	$table->EndRow();

	$medals = $pleb->GetMedals();
	if ($bydate) {
		usort($medals, recent_medals);
	}
	foreach ($medals as $am) {
		$medal = $am->GetMedal();
		$group = $medal->GetGroup();
		$awarder = $am->GetAwarder();
		$table->AddRow(date('j F Y', $am->GetDate()), '<a href="' . internal_link('browse', array('group'=>$group->GetID()), 'mb') . '">' . html_escape($medal->GetName()) . '</a>' . ($am->GetReason() ? ' for ' . html_escape($am->GetReason()) : '') . '.');
	}

	$table->EndTable();
	
	roster_footer();
}
?>
