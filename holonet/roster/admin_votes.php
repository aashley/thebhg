<?php
function title() {
	return 'Administration :: Vote';
}

function auth($person) {
	global $auth_data, $pleb, $roster;
	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['commission'];
}

function coders() {
	return array(666);
}

function output() {
	global $auth_data, $pleb, $roster, $page;

	roster_header();
	
	$sql = 'SELECT * '
	      .'FROM hn_com_poll '
	      .'WHERE ends >= UNIX_TIMESTAMP() ';

	$result = mysql_query($sql, $roster->roster_db);

	$table = new Table;

	if ($result
	 && mysql_num_rows($result) > 0) {
		$table->StartRow();
		$table->AddHeader('Vote');
		$table->AddHeader('Ends At');
		$table->AddHeader('Current Vote');
		$table->AddHeader('');
		$table->EndRow();
		
		while ($row = mysql_fetch_array($result)) {
			$options = unserialize(stripslashes($row['options']));
			
			$sql = 'SELECT vote '
			      .'FROM hn_com_vote '
			      .'WHERE person = '.intval($pleb->GetID()).' '
			        .'AND poll = '.$row['id'];

			$voteResult = mysql_query($sql, $roster->roster_db);
			if ($voteResult
			 && mysql_num_rows($voteResult) > 0) {
				if (($vote = mysql_result($voteResult, 0, 'vote')) != -1)
					$option = $options[$vote];
				else
					$option = 'Abstain';
				$voted = true;
			}
			else {
				$option = 'No Vote';
				$voted = false;
			}

			$table->AddRow(stripslashes($row['title']),
				       date('j F Y \a\t G:i:s T', $row['ends']),
				       $option,
				       ($voted ? 'Vote Lodged' : '<a href="'.internal_link('admin_vote', array('id' => $row['id'])).'">Lodge Vote</a>'));
		}
	}
	else
		$table->AddRow('There are no outstanding votes.');
	
	$table->EndTable();

	admin_footer($auth_data);
}
?>
