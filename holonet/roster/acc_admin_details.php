<?php
function title() {
	return 'Arena Challenge Centre :: Challenge Details';
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

	$details_result = mysql_query('SELECT arena.challenger, arena.challengee, arena.challenge_time, arena.num_weapons, arena.location, arena.post_count, arena.interference, arena.status, arena_rules.rule, arena_weapons.weapon FROM arena LEFT JOIN arena_rules ON arena_rules.id=arena.rules LEFT JOIN arena_weapons ON arena_weapons.id=arena.type_weapon WHERE arena.id=' . $_REQUEST['id'], $db);
	$details = mysql_fetch_array($details_result);

	$challenger = $roster->GetPerson($details['challenger']);
	$challengee = $roster->GetPerson($details['challengee']);

	$table = new Table('', true);
	$table->AddRow('Challenge ID:', $_REQUEST['id']);
	$table->AddRow('Challenger:', '<a href="' . internal_link('hunter', array('id'=>$challenger->GetID()), 'roster') . '">' . $challenger->GetName() . '</a>');
	$table->AddRow('Challengee:', '<a href="' . internal_link('hunter', array('id'=>$challengee->GetID()), 'roster') . '">' . $challengee->GetName() . '</a>');
	$table->AddRow('Challenge Date:', date('j M Y', $details['challenge_time']));
	$table->AddRow('Number of Weapons:', $details['num_weapons']);
	$table->AddRow('Weapon Type:' , $details['weapon']);
	$table->AddRow('Location:', stripslashes($details['location']));
	$table->AddRow('Post Count:', $details['post_count']);
	$table->AddRow('Rules:', $details['rule']);
	$table->AddRow('Interference:', $details['interference']);
	$table->StartRow();
	$table->AddCell('Status:');
	switch ($details['status']) {
		case 0:
			$table->AddCell('Pending');
			break;
		case -1:
			$table->AddCell('Declined');
			break;
		default:
			$table->AddCell('Accepted');
	}
	$table->EndRow();
	$table->EndTable();

	hr();

	echo '<a href="' . internal_link('acc_admin_remove', array('id'=>$_REQUEST['id'])) . '">Remove Challenge from Database</a>';
	
	acc_footer();
}
?>
