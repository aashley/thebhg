<?php
function title() {
	return 'Administration :: Vote Administration';
}

function auth($person) {
	global $auth_data, $pleb, $roster;
	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function output() {
	global $auth_data, $pleb, $roster, $page;

	roster_header();
	
	$sql = 'SELECT * '
	      .'FROM hn_com_poll '
	      .'ORDER BY ends DESC ';

	$result = mysql_query($sql, $roster->roster_db);

	echo '<a href="'
	    .internal_link('admin_vote_add')
	    .'">Add New Vote</a>';

	$table = new Table;

	if ($result
	 && mysql_num_rows($result) > 0) {
		$table->StartRow();
		$table->AddHeader('Vote');
		$table->AddHeader('Ends/Ended At');
		$table->AddHeader('Summary');
		$table->EndRow();
		
		while ($row = mysql_fetch_array($result)) {
			$options = unserialize(stripslashes($row['options']));
			
			$sql = 'SELECT vote '
				     .'COUNT(*) AS votes '
			      .'FROM hn_com_vote '
			      .'GROUP BY vote ';

			$votes = array_combine(array_keys($options), array_fill(0, count($options), 0));
			$votes[-1];
			$voteResult = mysql_query($sql, $roster->roster_db);
			if ($voteResult
			 && mysql_num_rows($voteResult) > 0)
				while ($voteRow = mysql_fetch_array($voteResult))
					$votes[$voteRow['vote']] = $voteRow['votes'];

			ksort($votes);
			$summary = array();
			foreach ($votes as $option => $total)
				$summary[] = htmlspecialchars($options[$option]).': '.number_format($total);

			$table->AddRow(stripslashes($row['title']),
				       date('j F Y \a\t G:i:s T', $row['ends']),
				       implode('<br />', $summary));
		}
	}
	else
		$table->AddRow('There are no votes in the database.');
	
	$table->EndTable();

	admin_footer($auth_data);
}
?>
