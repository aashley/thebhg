<?php
function title() {
	return 'Administration :: Add Playlist';
}

function auth($user) {
	return is_admin($user);
}

function output() {
	global $db, $page, $prefix, $roster;

	admin_header();

	if ($_REQUEST['song']) {
		$values = array();
		foreach ($_REQUEST['song'] as $id=>$data) {
			if (strstr($data['length'], ':') === false) {
				$length = $data['length'];
			}
			else {
				$parts = explode(':', $data['length']);
				$length = (60 * (int) $parts[0]) + (int) $parts[1];
			}
			$values[] = '(' . $_REQUEST['id'] . ', "' . addslashes($data['artist']) . '", "' . addslashes($data['title']) . '", ' . $length . ', "' . addslashes($data['request']) . '")';
		}
		$sql = 'INSERT INTO '.$prefix.'songs (`show`, artist, title, length, request) VALUES ' . implode(', ', $values);
		if (mysql_query($sql, $db)) {
			echo 'Playlist added successfully.';
		}
		else {
			echo 'Error adding playlist: ' . mysql_error($db);
		}
	}
	elseif ($_REQUEST['length']) {
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddHidden('length', $_REQUEST['length']);
		
		$form->table->StartRow();
		$form->table->AddHeader('&nbsp;');
		$form->table->AddHeader('Artist');
		$form->table->AddHeader('Title');
		$form->table->AddHeader('Length');
		$form->table->AddHeader('Requested By');
		$form->table->EndRow();

		for ($i = 0; $i < $_REQUEST['length']; $i++) {
			$sid = "song[$i]";
			
			$form->table->StartRow();
			$form->table->AddCell('Song ' . number_format($i + 1));
			$form->table->AddCell('<input type="text" name="'.$sid.'[artist]" size=20>');
			$form->table->AddCell('<input type="text" name="'.$sid.'[title]" size=20>');
			$form->table->AddCell('<input type="text" name="'.$sid.'[length]" size=5>');
			$form->table->AddCell('<input type="text" name="'.$sid.'[request]" size=20>');
			$form->table->EndRow();
		}

		$form->table->StartRow();
		$form->table->AddCell('<div style="text-align: right"><input type="reset">&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Add Playlist"></div>', 5);
		$form->table->EndRow();

		$form->EndForm();			
	}
	elseif ($_REQUEST['id']) {
		$form = new Form($page, 'get');
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Playlist Length:', 'length');
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Show:', 'id');
		
		$result = mysql_query('SELECT * FROM '.$prefix.'shows ORDER BY time DESC', $db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$form->AddOption($row['id'], stripslashes($row['name']) . ' (' . date('j/n/Y @ G:i', $row['time']) . ')');
			}
		}
		
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
	
	admin_footer();
}
?>
