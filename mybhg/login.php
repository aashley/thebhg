<?php
$title = 'Log In';
include('header.php');

if ($_POST['submit']) {
	$rid = (int) $_POST['rid'];
	$login = new Login($rid, $_POST['password']);
	if ($login->IsValid()) {
		setcookie('rid', $rid, time() + (365 * 86400));
		$result = mysql_query('SELECT `key` FROM prefs WHERE id=' . $rid, $db);
		if ($result && mysql_num_rows($result)) {
			setcookie('key', mysql_result($result, 0, 'key'), time() + (365 * 86400));
		}
		else {
			$key = time() . '-' . mt_rand();
			
			$sections = array();
			foreach ($news->GetAvailableSections() as $section) {
				$sections[] = $section['id'];
			}

			$result = mysql_query('SELECT id FROM blocks ORDER BY weight', $db);
			$blocks = array();
			if ($result && mysql_num_rows($result)) {
				while ($row = mysql_fetch_array($result)) {
					$blocks[] = $row['id'];
				}
			}
			
			mysql_query('INSERT INTO prefs (id, `key`, blocks, sections, theme, posts) VALUES (' . $rid . ', "' . $key . '", "' . implode(',', $blocks) . '", "' . implode(',', $sections) . '", "default", ' . $my_posts . ')', $db);
			setcookie('key', $key, time() + (365 * 86400));
		}

		echo 'Thank you. You are now logged in, and may return to the index by clicking <a href="index.php">here</a>. Alternately, you could <a href="prefs.php">change your preferences</a>.';
	}
	else {
		echo 'There was an error logging you in. The exact error returned by the Roster was: ' . $login->Error() . '.<br /><br />Please go back and try again.';
	}
}
else {
	echo 'Please enter your BHG Roster ID and password to log in.<br />';

	$form = new Form($_SERVER['PHP_SELF'], 'post');
	$form->AddTextBox('Roster ID:', 'rid', '', 5);
	$form->AddPasswordBox('Password:', 'password', '', 15);
	$form->AddSubmitButton('submit', 'Log In');
	$form->EndForm();
}

include('footer.php');
?>
