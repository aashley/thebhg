<?php
$title = 'Administration :: Edit Block';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	$result = mysql_query('SELECT * FROM blocks WHERE id=' . $_REQUEST['id'], $db);
	if ($result && mysql_num_rows($result)) {
		$row = mysql_fetch_array($result);
		$ow = $row['weight'];
		
		if (mysql_query('UPDATE blocks SET title="' . addslashes($_REQUEST['title']) . '", data="' . addslashes($_REQUEST['data']) . '", weight=' . $_REQUEST['weight'] . ' WHERE id=' . $_REQUEST['id'], $db)) {
			if ($_REQUEST['weight'] != $ow) {
				mysql_query('UPDATE blocks SET weight=weight+1 WHERE id != ' . $_REQUEST['id'], $db);
			}
			mysql_query('DELETE FROM block_cache WHERE id=' . $_REQUEST['id'], $db);
			echo 'Block saved successfully.';
		}
		else {
			echo 'Error saving block: ' . mysql_error($db);
		}
	}
	else {
		echo 'Error loading block.';
	}
}
elseif ($_REQUEST['id']) {
	$result = mysql_query('SELECT * FROM blocks WHERE id=' . $_REQUEST['id'], $db);
	if ($result && mysql_num_rows($result)) {
		$row = mysql_fetch_array($result);
		
		$form = new Form($_SERVER['PHP_SELF']);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Title:', 'title', stripslashes($row['title']));
		$types = get_block_types();
		if (strlen($types[$row['type']])) {
			$form->AddTextArea($types[$row['type']], 'data', stripslashes($row['data']), 5, 40);
		}
		$form->StartSelect('Block Placement:', 'weight', $row['weight']);
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
		$form->AddSubmitButton('submit', 'Save Block');
		$form->EndForm();
	}
	else {
		echo 'Error loading block.';
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF'], 'get');
	$form->StartSelect('Block:', 'id');
	$block_result = mysql_query('SELECT id, title FROM blocks ORDER BY weight', $db);
	if ($block_result && mysql_num_rows($block_result)) {
		while ($block_row = mysql_fetch_array($block_result)) {
			$form->AddOption($block_row['id'], $block_row['title']);
		}
	}
	$form->EndSelect();
	$form->AddSubmitButton('', 'Edit Block');
	$form->EndForm();
}

include('../../footer.php');
?>
