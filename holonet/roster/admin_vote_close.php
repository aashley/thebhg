<?php
function title() {
	global $poll, $roster;

	$sql = 'SELECT * '
	      .'FROM hn_com_poll '
	      .'WHERE id = '.intval($_REQUEST['id']);

	$result = mysql_query($sql, $roster->roster_db);

	if ($result
	 && mysql_num_rows($result)) {
		$poll = mysql_fetch_array($result);
		return 'Administration :: Close Vote :: '.stripslashes($poll['title']);
	}

	return 'Administration :: Close Vote';
}

function auth($person) {
	global $auth_data, $pleb, $roster;
	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function coders() {
	return array(666);
}

function output() {
	global $auth_data, $pleb, $roster, $page, $poll;

	roster_header();

	$sql = 'UPDATE hn_com_poll '
	      .'SET ends = '.time().' '
	      .'WHERE id = '.$poll['id'];
	
	$result = mysql_query($sql, $roster->roster_db);
	if ($result) {
		echo 'Poll closed successfully.'; 
		header('Location: '.str_replace('&amp;', '&', internal_link('admin_vote_admin')));
	}
	else {
		echo '<p>Error closing poll: '.mysql_error($roster->roster_db).'</p>';
		echo '<p>SQL: '.$sql.'</p>';
	}

	admin_footer($auth_data);
}
?>
