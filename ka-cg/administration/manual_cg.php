<?php
function roster_options(&$form, &$roster, $label, $name) {
	global $ro_cache;
	
	$form->table->StartRow();
	$form->table->AddCell($label);
	if (empty($ro_cache)) {
		$ro_cache = '<option value="0" selected="selected">None</option>';
		foreach ($roster->GetDivisions('name') as $div) {
			foreach ($div->GetMembers('name') as $member) {
				$ro_cache .= '<option value="' . $member->GetID() . '">' . $div->GetName() . ': ' . $member->GetName() . '</option>';
			}
		}
	}
	$form->table->AddCell("<select name=\"$name\">$ro_cache</select>");
	$form->table->EndRow();
}

include_once('header.php');

page_header('Manual CG');

if ($_REQUEST['stage'] == 3) {
	// Finish.
	$cg =& $ka->GetCG($_REQUEST['cg']);
	$events = array();
	foreach ($cg->GetEvents() as $event) {
		$events[] = $event;
	}
	
	foreach ($_REQUEST['names'] as $cid=>$name) {
		if (mysql_query('INSERT INTO roster_cadres (name, leader, date_created, date_deleted) VALUES ("' . addslashes($name) . '", ' . $_REQUEST['leaders'][$cid] . ', ' . $cg->GetStart() . ', ' . $cg->GetEnd() . ')', $roster->roster_db)) {
			$rcid = mysql_insert_id($roster->roster_db);
			foreach ($events as $event) {
				mysql_query('INSERT INTO cg_signups (person, cg, event, cadre) VALUES (' . $_REQUEST['leaders'][$cid] . ', ' . $_REQUEST['cg'] . ', ' . $event->GetID() . ', '. $rcid . ')', $db);
				foreach ($_REQUEST['members'][$cid] as $mid) {
					if ($mid) {
						mysql_query('INSERT INTO cg_signups (person, cg, event, cadre) VALUES (' . $mid . ', ' . $_REQUEST['cg'] . ', ' . $event->GetID() . ', '. $rcid . ')', $db);
					}
				}
			}
		}
		else {
			echo 'Error adding cadre: ' . mysql_error($roster->roster_db) . '<br />';
		}
	}

	echo 'Done.';
}
elseif ($_REQUEST['stage'] == 2) {
	// Fill out cadre details.
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddHidden('stage', 3);
	$form->AddHidden('cg', $_REQUEST['cg']);
	for ($i = 0; $i < ((int) $_REQUEST['cadres']); $i++) {
		$form->AddTextBox('Cadre ' . ($i + 1) . ' Name:', "names[{$i}]", '', 40);
		//roster_options($form, $roster, 'Cadre Leader:', "leaders[{$i}]");
		$form->AddTextBox('Cadre Leader:', "leaders[{$i}]", '', 5);
		for ($j = 1; $j < 6; $j++) {
			//roster_options($form, $roster, "Cadre Member $j:", "members[{$i}][{$j}]");
			$form->AddTextBox("Cadre Member $j:", "members[{$i}][{$j}]", '', 5);
		}
		$form->table->StartRow();
		$form->table->AddCell('&nbsp;', 2);
		$form->table->EndRow();
	}
	$form->AddSubmitButton('', 'Add Cadres');
	$form->EndForm();
}
elseif ($_REQUEST['stage'] == 1) {
	// Input the number of cadres.
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddHidden('stage', 2);
	$form->AddHidden('cg', $_REQUEST['cg']);
	$form->AddTextBox('Cadres:', 'cadres', '', 5);
	$form->AddSubmitButton('', 'Next >>');
	$form->EndForm();
}
else {
	// Select a CG.
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddHidden('stage', 1);
	$form->StartSelect('CG:', 'cg');
	foreach (array_reverse($ka->GetCGs()) as $cg) {
		$form->AddOption($cg->GetID(), roman($cg->GetID()));
	}
	$form->EndSelect();
	$form->AddSubmitButton('', 'Next >>');
	$form->EndForm();
}

page_footer();
?>
