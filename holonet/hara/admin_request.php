<?php
function title() {
	return 'Administration :: Requests'; 
}

function auth($user) {
	return is_admin($user);
}

function output() {
	global $db, $page, $prefix, $roster;

	admin_header();

	if ($_REQUEST['days']) {
		$days = $_REQUEST['days'];
	}
	else {
		$days = 7;
	}
	$start = time() - ($days * 86400);

	$result = mysql_query('SELECT * FROM '.$prefix.'requests WHERE time>=' . $start . ' ORDER BY artist, title, time', $db);
	if ($result && mysql_num_rows($result)) {
		$table = new Table('', true);
		$table->StartRow();
		$table->AddHeader('Artist');
		$table->AddHeader('Title');
		$table->AddHeader('Requested By');
		$table->AddHeader('Comments');
		$table->EndRow();
		while ($row = mysql_fetch_array($result)) {
			$questor = $roster->GetPerson($row['person']);
			$table->AddRow(html_escape($row['artist']), html_escape($row['title']), '<a href="' . internal_link('hunter', array('id'=>$row['person']), 'roster') . '">' . html_escape($questor->GetName()) . '</a>', nl2br(html_escape($row['comments'])));
		}
		$table->EndTable();
	}
	else {
		echo 'No requests have been made in the last ' . number_format($days) . ' day' . ($days > 1 ? 's' : '') . '.';
	}

	hr();

	$form = new Form($page, 'get');
	$form->AddTextBox('Days to Show:', 'days', $days, 3);
	$form->AddSubmitButton('', 'Go!');
	$form->EndForm();

	admin_footer();
}
?>
