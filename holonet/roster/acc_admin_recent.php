<?php
function title() {
	return 'Arena Challenge Centre :: Recent Challenges';
}

function auth($pleb) {
	global $user;
	$user = $pleb;
	$pos = $pleb->GetPosition();
	return ($pleb->GetID() == 666 || $pos->GetID() == 9 || $pos->GetID() == 29 || $pos->GetID() == 4);
}

function output() {
	global $user, $page, $roster, $db, $lyarna_db, $email_headers;

	menu_header();

	$table = new Table('', true);
	$table->StartRow();
	$table->AddHeader('ID');
	$table->AddHeader('Challenger');
	$table->AddHeader('Challengee');
	$table->AddHeader('Date Challenged');
	$table->AddHeader('Status');
	$table->AddHeader('&nbsp;');
	$table->EndRow();

	$result = mysql_query('SELECT * FROM arena ORDER BY id DESC LIMIT 20', $db);
	while ($pending = mysql_fetch_array($result)) {
		$challenger = $roster->GetPerson($pending['challenger']);
		$challengee = $roster->GetPerson($pending['challengee']);
		$table->StartRow();
		$table->AddCell('<a href="' . internal_link('acc_admin_details', array('id'=>$pending['id'])) . '">' . $pending['id'] . '</a>');
		$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pending['challenger']), 'roster') . '">' . $challenger->GetName() . '</a>');
		$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pending['challengee']), 'roster') . '">' . $challengee->GetName() . '</a>');
		$table->AddCell(date('j M Y', $pending['challenge_time']));
		if ($pending['status'] == 0) {
			$table->AddCell('Pending');
		}
		elseif ($pending['status'] == -1) {
			$table->AddCell('Declined');
		}
		else {
			$table->AddCell('Accepted');
		}
		$table->AddCell('<a href="' . internal_link('acc_admin_remove', array('id'=>$pending['id'])) . '">Remove</a>');
		$table->EndRow();
	}
	$table->EndTable();

	acc_footer();
}
?>
