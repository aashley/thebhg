<?php
function title() {
	return 'Administration :: Add Experience Points';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['cs'];
}

function output() {
	global $auth_data, $sheet_db, $page, $roster;

	roster_header();

	if ($_REQUEST['submit']) {
		foreach ($_REQUEST['hunter'] as $id=>$pid) {
			if ($pid > 0) {
				$sheet = new Sheet($roster->GetPerson($pid));
				$sheet->AddXP($_REQUEST['xp'][$id]);
			}
		}
		echo 'Experience points added.';

		hr();
	}

	$result = mysql_query('SELECT person FROM cs_sheets WHERE time>0', $sheet_db);
	while ($row = mysql_fetch_array($result)) {
		$person = $roster->GetPerson($row['person']);
		$div = $person->GetDivision();
		$str = $div->GetName() . ': ' . $person->GetName();
		$hunters[$str] = '<option value="' . $row['person'] . '">' . html_escape($str) . '</option>';
	}
	ksort($hunters);

	$form = new Form($page);
	$form->table->StartRow();
	$form->table->AddHeader('Hunter');
	$form->table->AddHeader('XP');
	$form->table->EndRow();
	for ($i = 0; $i < 10; $i++) {
		$form->table->StartRow();
		$form->table->AddCell('<select name="hunter[' . $i . ']" size=1 selected="0"><option value="0">N/A</option>' . implode('', $hunters) . '</select>');
		$form->table->AddCell('<input type="text" name="xp[' . $i . ']" size=5>');
		$form->table->EndRow();
	}
	$form->AddSubmitButton('submit', 'Add Experience Points');
	$form->EndForm();

	admin_footer($auth_data);
}
?>
