<?php
if ($_REQUEST['group']) {
	$group = $mb->GetMedalGroup($_REQUEST['group']);
}

function title() {
	global $group;

	if (isset($group)) {
		return 'Medals :: ' . $group->GetName();
	}
	else {
		return 'Medals';
	}
}

function output() {
	global $group, $page;

	mb_header();

	$bydate = (isset($_REQUEST['bydate']) && $_REQUEST['bydate'] == 1);
	if ($bydate) {
		echo '<a href="' . internal_link($page, array('group'=>$_REQUEST['group'], 'bydate'=>0)) . '">Sort by name</a> | <b>Sort by date</b>';
	}
	else {
		echo '<b>Sort by name</b> | <a href="' . internal_link($page, array('group'=>$_REQUEST['group'], 'bydate'=>1)) . '">Sort by date</a>';
	}

	hr();

	echo $group->GetDescription();

	hr();

	$table = new Table('', true);
	$table->StartRow();
	$table->AddHeader('Date');
	$table->AddHeader('Recipient');
	$table->AddHeader('Awarder');
	$table->AddHeader('Medal');
	$table->AddHeader('Reason', 1, 1, 50);
	$table->EndRow();

	$medals = $group->GetAwardedMedals();
	if ($medals) {
		if ($bydate) {
			usort($medals, 'recent_medals');
		}
		else {
			usort($medals, 'alpha_medals');
		}
		foreach ($medals as $am) {
			$medal = $am->GetMedal();
			$group = $medal->GetGroup();
			$awarder = $am->GetAwarder();
			$recip = $am->GetRecipient();
			if ($recip->GetName()) {
				$table->AddRow(date('j F Y', $am->GetDate()), '<a href="' . internal_link('hunter', array('id'=>$recip->GetID()), 'roster') . '">' . $recip->GetName() . '</a>', '<a href="' . internal_link('hunter', array('id'=>$awarder->GetID()), 'roster') . '">' . $awarder->GetName() . '</a>', '<a href="' . internal_link('browse', array('group'=>$group->GetID()), 'mb') . '">' . html_escape($medal->GetName()) . '</a>', ($am->GetReason() ? ucfirst($am->GetReason()) . (substr($am->GetReason(), -1) == '.' ? '' : '.') : '&nbsp;'));
			}
		}
	}
	else {
		$table->StartRow();
		$table->AddCell('No medals have been awarded in this group.', 5);
		$table->EndRow();
	}

	$table->EndTable();
	
	mb_footer();
}
?>
