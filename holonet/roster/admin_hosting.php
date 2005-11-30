<?php
function title() {
	return 'Administration :: Hosting';
}

function auth($person) {
	global $auth_data, $pleb, $roster;
	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['commission'] || $auth_data['chief'];
}

function coders() {
	return array(94);
}

function output() {
	global $auth_data, $pleb, $roster, $page;

	roster_header();
	
	$accounts = get_primary_accounts($pleb);

	$table = new Table();
	
	if (is_array($accounts) && sizeof($accounts) > 0)) {{
		$table->StartRow();
		$table->AddHeader('Type');
		$table->AddHeader('Target');
		$table->AddHeader('Username');
		$table->AddHeader('Password');
		$table->EndRow();
		
		foreach ($accounts as $account) {
			
			$table->AddRow($account['type'],
				       $account['target'],
				       $account['username'],
				       $account['password']);
		}
	}
	else
		$table->AddRow('You have access to no accounts on Loki.');
	
	$table->EndTable();

	admin_footer($auth_data);
}


function get_primary_accounts($pleb) {

	$sql = 'SELECT UNIQUE(account) '
				.'FROM hosting_rule '
				.'WHERE person = '.$pleb->getID().' '
					 .'OR (division = '.$pleb->getDivision()->getID().' AND position IS NULL) '
					 .'OR (division IS NULL AND position = '.$pleb->getPosition()->getID().') '
					 .'OR (division = '.$pleb->getDivision()->getID().' AND position = '.$pleb->getPosition()->getID().') ';

	$result = mysql_query($sql, $roster->roster_db);

	if ($result
			&& mysql_num_rows($result) > 0) {

		$ids = array();

		while ($row = mysql_fetch_row($result)) {
			$ids[] = $row[0];
		}

		$sql = 'SELECT * '
					.'FROM hosting_account '
					."WHERE id IN (".implode(',', $ids).')';

		$result = mysql_query($sql, $roster->roster_db);

		$accounts = array();

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$accounts[] = $row;
		}

	} else {

		return array();

	}

}

?>
