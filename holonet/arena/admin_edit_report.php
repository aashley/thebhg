<?php
function title() {
    return 'Administration :: General :: Edit Report';
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
	
	if (isset($_REQUEST['id'])) {
		$result = mysql_query('SELECT * FROM arena_reports WHERE id=' . $_REQUEST['id'], $arena->connect);
		if ($result && mysql_num_rows($result)) {
			$report = mysql_fetch_array($result);
			if ($report['author'] != $hunter->GetID() && empty($auth_data['rp'])) {
				echo 'You are not permitted to edit this report.';
				admin_footer($auth_data);
				return;
			}
		}
		else {
			echo 'You have attempted to edit a report which doesn\'t exist.';
			admin_footer($auth_data);
			return;
		}
	}

	if (isset($_REQUEST['report'])) {
		if (mysql_query('UPDATE arena_reports SET report="' . addslashes($_REQUEST['report']) . '", html=' . ($_REQUEST['html'] == on ? '1' : '0') . ' WHERE id=' . $_REQUEST['id'], $arena->connect)) {
			echo 'Report saved successfully.';
		}
		else {
			echo 'Error saving report: ' . mysql_error($roster->roster_db);
		}
	}
	elseif (isset($_REQUEST['id'])) {
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextArea('Report:', 'report', stripslashes($report['report']), 20, 70);
		$form->AddCheckBox('Enable HTML:', 'html', 'on', $report['html'] == 1);
		$form->AddSubmitButton('submit', 'Save Report');
		$form->EndForm();
	}
	else {
		$result = mysql_query('SELECT * FROM arena_reports WHERE author=' . $hunter->GetID() . ' ORDER BY time DESC', $arena->connect);
		if ($result && mysql_num_rows($result)) {
			$table = new Table('', true);
			$table->StartRow();
			$table->AddHeader('&nbsp;');
			$table->AddHeader('Date');
			$table->AddHeader('Position');
			$table->EndRow();
			while ($row = mysql_fetch_array($result)) {
				$pos_text = $arena->ArenaPosition($row['admin']);
				$table->AddRow('<a href="' . internal_link($page, array('id'=>$row['id'])) . '">Edit</a>', date('j F Y', $row['time']), $pos_text);
			}
			$table->EndTable();
		}
		else {
			echo 'You have not lodged any reports.';
		}
	}

    admin_footer($auth_data);
}
?>
