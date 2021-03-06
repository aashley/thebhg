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
	$has['CoderID'] = false;
	
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

				if ($secondary['type'] == 'CoderID') {
					
					$table->addRow($secondary['type'],
							$secondary['target'],
							$secondary['username'],
							'');

				} else {
					
					$table->addRow($secondary['type'],
							$secondary['target'],
							$account['username'],
							$account['password']);

				}

			}

		}

	}
	else
		$table->AddRow('You have access to no accounts on Loki.');
	
	$table->EndTable();

	print '<p/>';

	if ($has['FTP']) {

		print <<<EOFTP
<div>
<h3>FTP Details</h3>
<table border=0 cellspacing=1 cellpadding=2 style="background: black">
	<tr>
		<th>Website Address:</th>
		<td style="background: white">http://&lt;target&gt;/</td>
	</tr>
	<tr>
		<th>Server:</th>
		<td style="background: white">ftp.thebhg.org</td>
	</tr>
	<tr>
		<th>Username:</th>
		<td style="background: white">&lt;username&gt;</td>
	</tr>
	<tr>
		<th>Password:</th>
		<td style="background: white">&lt;password&gt;</td>
	</tr>
</table>
<p/>
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
		<td style="background: white">localhost</td>
	</tr>
	<tr>
		<th>Database Name:</th>
		<td style="background: white">&lt;target&gt;</td>
	</tr>
	<tr>
		<th>Username:</th>
		<td style="background: white">&lt;username&gt;</td>
	</tr>
	<tr>
		<th>Password:</th>
		<td style="background: white">&lt;password&gt;</td>
	</tr>
</table>
<p/>
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
		<td style="background: white">&lt;target&gt;</td>
	</tr>
	<tr>
		<th>Server:</th>
		<td style="background: white">mail.thebhg.org</td>
	</tr>
	<tr>
		<th>Username:</th>
		<td style="background: white">&lt;username&gt;</td>
	</tr>
	<tr>
		<th>Password:</th>
		<td style="background: white">&lt;password&gt;</td>
	</tr>
	<tr>
		<th>Connection Info:</th>
		<td style="background: white">All mail connection use SSL</td>
	</tr>
</table>
<p/>
</div>
EOFTP;

		if ($has['CoderID']) {

			print <<<EOFTP
<div>
<h3>Coder ID<h3>
<p>The Coder ID allows code on this site special access to features of the
BHG Roster system.</p>
</div>
EOFTP;

		}

	}

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
