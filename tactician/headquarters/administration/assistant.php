<?php
include_once('header.php');

page_header('Add New Assistant');

if (!$GLOBALS['approve']){
	echo 'You have no authority here.';
	page_footer();
	exit;
}

function boolv($name){
	return (isset($_REQUEST[$name]) ? 1 : 0);
}

if ($GLOBALS['approve']) {
	if ($_REQUEST['submit']) {
		$sql = "INSERT INTO `assistant` (`person`, `hunts`, `cg`, `kg`, `ladder`, `om`) VALUES ".
				"('".$_REQUEST['id']."', '".boolv('hunt')."', '".boolv('cg')."', '".boolv('kg').
				"', '".boolv('ladder')."', '".boolv('om')."')";
		if (mysql_query($sql, $db))
			echo 'User added successfully.';
		else
			echo 'Error: ' . mysql_error($db);
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('User:', 'id');
		hunter_dropdown($form);
		$form->EndSelect();
		
		$form->addCheckbox('Hunt Access', 'hunt');
		$form->addCheckbox('Cadre Games', 'cg');
		$form->addCheckbox('Kabal Games', 'kg');
		$form->addCheckbox('Tactician\'s Ladder', 'ladder');
		$form->addCheckbox('Online Missions', 'om');
		
		$form->AddSubmitButton('submit', 'Add Assistant');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
