<?php
function title() {
	return 'Administration :: Edit Report';
}

function auth($person) {
	global $auth_data, $pleb, $roster;
	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return ($auth_data['commission'] || $auth_data['chief'] || $auth_data['warden']);
}

function output() {
	global $auth_data, $pleb, $roster, $page;

	roster_header();

	if ($_REQUEST['id']) {
		$result = mysql_query('SELECT * FROM hn_reports WHERE id=' . $_REQUEST['id'], $roster->roster_db);
		if ($result && mysql_num_rows($result)) {
			$report = mysql_fetch_array($result);
			if ($report['author'] != $pleb->GetID() && empty($auth_data['underlord'])) {
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

	if ($_REQUEST['report']) {
		if (mysql_query('UPDATE hn_reports SET report="' . addslashes($_REQUEST['report']) . '", html=' . ($_REQUEST['html'] == on ? '1' : '0') . ' WHERE id=' . $_REQUEST['id'], $roster->roster_db)) {
			echo 'Report saved successfully.';
		}
		else {
			echo 'Error saving report: ' . mysql_error($roster->roster_db);
		}
	}
	elseif ($_REQUEST['id']) {
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextArea('Report:', 'report', stripslashes($report['report']), 20, 70);
		$form->AddCheckBox('Enable HTML:', 'html', 'on', $report['html'] == 1);
		$form->AddSubmitButton('submit', 'Save Report');
		$form->EndForm();
	}
	else {
		$result = mysql_query('SELECT * FROM hn_reports WHERE author=' . $pleb->GetID() . ' ORDER BY time DESC', $roster->roster_db);
		if ($result && mysql_num_rows($result)) {
			$table = new Table('', true);
			$table->StartRow();
			$table->AddHeader('&nbsp;');
			$table->AddHeader('Date');
			$table->AddHeader('Position');
			$table->EndRow();
			while ($row = mysql_fetch_array($result)) {
				$pos = $roster->GetPosition($row['position']);
				$pos_text = $pos->GetName();
				if ($row['position'] >= 10) {
					$div = $roster->GetDivision($row['division']);
					$pos_text = $div->GetName() . ' ' . $pos_text;
				}
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
