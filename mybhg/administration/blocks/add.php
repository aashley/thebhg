<?php
$title = 'Administration :: Add Block';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	if (mysql_query('UPDATE blocks SET weight=weight+1 WHERE weight>=' . ($_REQUEST['weight']), $db) && mysql_query('INSERT INTO blocks (type, title, data, weight) VALUES ("' . $_REQUEST['type'] . '", "' . addslashes($_REQUEST['title']) . '", "' . addslashes($_REQUEST['data']) . '", ' . ($_REQUEST['weight']) . ')', $db)) {
		$block_id = mysql_insert_id($db);
		mysql_query('UPDATE prefs SET blocks=CONCAT(blocks,",' . $block_id . '") WHERE blocks != ""', $db);
		mysql_query('UPDATE prefs SET blocks="' . $block_id . '" WHERE blocks = ""', $db);
		echo 'Block added successfully.';
	}
	else {
		echo 'Error adding block: ' . mysql_error($db);
	}
}
elseif ($_REQUEST['type']) {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddHidden('type', $_REQUEST['type']);
	$form->AddTextBox('Title:', 'title');
	$types = get_block_types();
	if (strlen($types[$_REQUEST['type']])) {
		$form->AddTextArea($types[$_REQUEST['type']], 'data', '', 5, 40);
	}
	$form->StartSelect('Block Placement:', 'weight');
	$block_result = mysql_query('SELECT id, title, weight FROM blocks ORDER BY weight', $db);
	$weight = 0;
	if ($block_result && mysql_num_rows($block_result)) {
		while ($block_row = mysql_fetch_array($block_result)) {
			$weight = $block_row['weight'];
			$form->AddOption($block_row['weight'], 'Before ' . $block_row['title']);
		}
	}
	$form->AddOption($weight + 1, 'At end');
	$form->EndSelect();
	$form->AddSubmitButton('submit', 'Add Block');
	$form->EndForm();
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->StartSelect('Block Type:', 'type');
	foreach (get_block_types() as $name=>$label) {
		$form->AddOption($name, $name);
	}
	$form->EndSelect();
	$form->AddSubmitButton('', 'Next >>');
	$form->EndForm();
}

include('../../footer.php');
?>
