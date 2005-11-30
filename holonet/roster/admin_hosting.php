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

	$has['FTP'] = false;
	$has['MySQL'] = false;
	$has['Email'] = false;
	
	$accounts = get_primary_accounts($pleb);

	$table = new Table();
	
	if (is_array($accounts) && sizeof($accounts) > 0) {
		$table->StartRow();
		$table->AddHeader('Type');
		$table->AddHeader('Target');
		$table->AddHeader('Username');
		$table->AddHeader('Password');
		$table->EndRow();
		
		foreach ($accounts as $account) {

			$has[$account['type']] = true;
			
			$table->AddRow($account['type'],
				       $account['target'],
				       $account['username'],
				       $account['password']);

			$secondaries = get_secondary_accounts($account);

			foreach ($secondaries as $secondary) {

				$has[$secondary['type']] = true;

				$table->addRow($secondary['type'],
						$secondary['target'],
						$account['username'],
						$account['password']);

			}

		}

	}
	else
		$table->AddRow('You have access to no accounts on Loki.');
	
	$table->EndTable();

	if ($has['FTP']) {

		print <<<EOFTP
<div>
<h3>FTP Details</h3>
<table border=0 cellspacing=1 cellpadding=2 style="background: black">
	<tr>
		<th>Website Address:</th>
		<td>http://&lt;target&gt;/</td>
	</tr>
	<tr>
		<th>Server:</th>
		<td>ftp.thebhg.org</td>
	</tr>
	<tr>
		<th>Username:</th>
		<td>&lt;username&gt;</td>
	</tr>
	<tr>
		<th>Password:</th>
		<td>&lt;password&gt;</td>
	</tr>
</table>
</div>
EOFTP;

	}

	if ($has['MySQL']) {

		print <<<EOFTP
<div>
<h3>MySQL Details</h3>
<table border=0 cellspacing=1 cellpadding=2 style="background: black">
	<tr>
		<th>Server:</th>
		<td>localhost</td>
	</tr>
	<tr>
		<th>Database Name:</th>
		<td>&lt;target&gt;</td>
	</tr>
	<tr>
		<th>Username:</th>
		<td>&lt;username&gt;</td>
	</tr>
	<tr>
		<th>Password:</th>
		<td>&lt;password&gt;</td>
	</tr>
</table>
</div>
EOFTP;

	}

	if ($has['Email']) {

		print <<<EOFTP
<div>
<h3>Email Details</h3>
<table border=0 cellspacing=1 cellpadding=2 style="background: black">
	<tr>
		<th>Email Address:</th>
		<td>&lt;target&gt;</td>
	</tr>
	<tr>
		<th>Server:</th>
		<td>mail.thebhg.org</td>
	</tr>
	<tr>
		<th>Username:</th>
		<td>&lt;username&gt;</td>
	</tr>
	<tr>
		<th>Password:</th>
		<td>&lt;password&gt;</td>
	</tr>
	<tr>
		<th>Connection Info:</th>
		<td>All mail connection use SSL</td>
	</tr>
</table>
</div>
EOFTP;

	}

	admin_footer($auth_data);
	admin_footer($auth_data);
	admin_footer($auth_data);
}


function get_primary_accounts($pleb) {
	global $roster;

	$sql = 'SELECT DISTINCT(account) '
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

		return $accounts;

	} else {

		return array();

	}

}

function get_secondary_accounts($account) {
	global $roster;

	$sql = 'SELECT * '
				.'FROM hosting_account '
				."WHERE parent = ".$account['id'];

	$result = mysql_query($sql, $roster->roster_db);

	$accounts = array();

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$accounts[] = $row;
	}

	return $accounts;

}
?>
