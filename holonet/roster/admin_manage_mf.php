<?php
function title() {
	return 'Administration :: Manage Merits &amp; Flaws';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['cs'];
}

function output() {
	global $auth_data, $sheet_db, $page;

	roster_header();

	if ($_REQUEST['action'] == 'add') {
		if (mysql_query('INSERT INTO cs_field_options (class, name) VALUES (' . $_REQUEST['class'] . ', "' . addslashes($_REQUEST['name']) . '")', $sheet_db)) {
			echo 'Option added.';
		}
		else {
			echo 'Error adding option: ' . mysql_error($sheet_db);
		}
	}
	elseif ($_REQUEST['action'] == 'delete') {
		mysql_query('DELETE FROM cs_field_options WHERE id=' . $_REQUEST['id'], $sheet_db);
		echo 'Option removed.';
	}
	elseif ($_REQUEST['action'] == 'edit') {
		$field_result = mysql_query('SELECT * FROM cs_field_options WHERE id=' . $_REQUEST['id'], $sheet_db);
		$field = mysql_fetch_array($field_result);
		$form = new Form($page);
		$form->AddHidden('action', 'save');
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Name:', 'name', stripslashes($field['name']));
		$form->StartSelect('Type:', 'class', $field['class']);
		$form->AddOption(8, 'Merit');
		$form->AddOption(9, 'Flaw');
		$form->EndSelect();
		$form->AddSubmitButton('', 'Save Merit/Flaw');
		$form->EndForm();
	}
	elseif ($_REQUEST['action'] == 'save') {
		if (mysql_query('UPDATE cs_field_options SET class=' . $_REQUEST['class'] . ', name="' . addslashes($_REQUEST['name']) . '" WHERE id=' . $_REQUEST['id'], $sheet_db)) {
			echo 'Option saved.';
		}
		else {
			echo 'Error saving option: ' . mysql_error($sheet_db);
		}
	}
	else {
		$form = new Form($page);
		$form->AddHidden('action', 'add');
		$form->AddTextBox('Name:', 'name');
		$form->StartSelect('Type:', 'class');
		$form->AddOption(8, 'Merit');
		$form->AddOption(9, 'Flaw');
		$form->EndSelect();
		$form->AddSubmitButton('', 'Add Merit/Flaw');
		$form->EndForm();
	}
		
	hr();
	$table = new Table();
	
	$dd_result = mysql_query('SELECT * FROM cs_field_options WHERE class=8 ORDER BY class, name', $sheet_db);
	$table->StartRow();
	$table->AddHeader('Merits', 3);
	$table->EndRow();
	while ($dd_row = mysql_fetch_array($dd_result)) {
		$table->AddRow(stripslashes($dd_row['name']), '<a href="' . internal_link($page, array('action'=>'edit', 'id'=>$dd_row['id'])) . '">Edit</a>', '<a href="' . internal_link($page, array('action'=>'delete', 'id'=>$dd_row['id'])) . '">Delete</a>');
	}
	
	$dd_result = mysql_query('SELECT * FROM cs_field_options WHERE class=9 ORDER BY class, name', $sheet_db);
	$table->StartRow();
	$table->AddHeader('Flaws', 3);
	$table->EndRow();
	while ($dd_row = mysql_fetch_array($dd_result)) {
		$table->AddRow(stripslashes($dd_row['name']), '<a href="' . internal_link($page, array('action'=>'edit', 'id'=>$dd_row['id'])) . '">Edit</a>', '<a href="' . internal_link($page, array('action'=>'delete', 'id'=>$dd_row['id'])) . '">Delete</a>');
	}

	$table->EndTable();

	admin_footer($auth_data);
}
?>
