<?php
function title() {
    return 'Administration :: General :: Add Report';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['aa'];
}

function output() {
    global $auth_data, $page, $roster, $hunter, $arena;

    arena_header();

    $holonet = false;
    
    $pos = $hunter->GetPosition();
	$div = $hunter->GetDivision();
	if (($pos->GetID() == 29 && $_REQUEST['position'] == 'ov') || ($pos->GetID() == 9 && $_REQUEST['position'] == 'aj')){
		$holonet = true;
	}
	
	if (isset($_REQUEST['submit'])) {
		if ($holonet){
			if (mysql_query('INSERT INTO hn_reports (position, division, author, time, report, html) VALUES (' . $pos->GetID() . ', ' . $div->GetID() . ', ' . $hunter->GetID() . ', UNIX_TIMESTAMP(), "' . addslashes($_REQUEST['report']) . '", ' . ($_REQUEST['html'] == 'on' ? '1' : '0') . ')', $roster->roster_db)) {
				echo 'Formal Commission Report added successfully.';
			}
			else {
				echo 'Error adding Commission report: ' . mysql_error($roster->roster_db);
			}
			echo '<br />';
		}
		$sql = 'INSERT INTO arena_reports (admin, author, time, report, html) VALUES (' . addslashes($_REQUEST['position']) . ', ' . $hunter->GetID() . ', UNIX_TIMESTAMP(), "' . addslashes($_REQUEST['report']) . '", ' . ($_REQUEST['html'] == 'on' ? '1' : '0') . ')';
		echo $sql;
		if (mysql_query($sql, $arena->connect)) {
			echo 'Arena Report added successfully.';
		}
		else {
			echo 'Error adding report: ' . mysql_error($arena->connect);
		}
	}
	else {
		$can = $arena->CanBe($hunter);
		
		if (count($can)){		
			$form = new Form($page);
			$form->StartSelect('Post As:', 'position');
			foreach ($can as $call=>$desc){
				$form->AddOption($call, $desc);
			}
			$form->EndSelect();
			$form->AddTextArea('Report:', 'report', '', 20, 70);
			$form->AddCheckBox('Enable HTML:', 'html', 'on');
			$form->table->AddRow('Note:', 'This report cannot be deleted once added.');
			$form->AddSubmitButton('submit', 'Add Report');
			$form->EndForm();
		} else {
			echo 'You cannot submit as any kind of Arena Aide.';
		}
	}

    admin_footer($auth_data);
}
?>
