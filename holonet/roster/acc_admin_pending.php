<?php
function title() {
	return 'Arena Challenge Centre :: Pending Challenges';
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
	$table->AddHeader('&nbsp;');
	$table->EndRow();

	$result = mysql_query('SELECT * FROM arena WHERE status=0 ORDER BY id', $db);
	while ($pending = mysql_fetch_array($result)) {
		$challenger = $roster->GetPerson($pending['challenger']);
		$challengee = $roster->GetPerson($pending['challengee']);
		$table->StartRow();
		$table->AddCell('<a href="' . internal_link('acc_admin_details', array('id'=>$pending['id'])) . '">' . $pending['id'] . '</a>');
		$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pending['challenger']), 'roster') . '">' . $challenger->GetName() . '</a>');
		$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pending['challengee']), 'roster') . '">' . $challengee->GetName() . '</a>');
		$table->AddCell(date('j M Y', $pending['challenge_time']));
		$table->AddCell('<a href="' . internal_link('acc_admin_remove', array('id'=>$pending['id'])) . '">Remove</a>');
		$table->EndRow();
	}
	$table->EndTable();

	acc_footer();
}
?>
