<?php
function title() {
	return 'Request A Song';
}

function auth($pleb) {
	global $user, $roster;
	$user = $roster->GetPerson($pleb->GetID());
	return true;
}

function output() {
	global $user, $db, $prefix, $roster, $page;

	// Check if the user has made his/her two requests this week.
	$today = mktime(date('n'), date('j'), date('Y'), 0, 0, 0);
	$day = (int) date('w');
	if ($day == 0) {
		$day = 7;
	}
	$monday = $today - (86400 * ($day - 1));
	$result = mysql_query('SELECT id FROM '.$prefix.'requests WHERE person=' . $user->GetID() . ' AND time>=' . $monday, $db);
	if ($result && mysql_num_rows($result) >= 2) {
		echo 'You have already made your allotted requests for this week.';
	}
	else {
		if ($_REQUEST['submit']) {
			if (mysql_query('INSERT INTO '.$prefix.'requests (person, time, artist, title, comments) VALUES (' . $user->GetID() . ', UNIX_TIMESTAMP(), "' . addslashes($_REQUEST['artist']) . '", "' . addslashes($_REQUEST['title']) . '", "' . addslashes($_REQUEST['comments']) . '")', $db)) {
				echo 'Request lodged successfully.';
			}
			else {
				echo 'Error saving request: ' . mysql_error($db);
			}
		}
		else {
			echo 'Please enter the details for the song you would like to request.';
			hr();
			$form = new Form($page);
			$form->AddTextBox('Artist:', 'artist');
			$form->AddTextBox('Title:', 'title');
			$form->AddTextArea('Comments (Optional):', 'comments', '', 3, 40);
			$form->AddSubmitButton('submit', 'Lodge Request');
			$form->EndForm();
		}
	}
}
?>
