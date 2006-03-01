<?php
include_once('header.php');

page_header('Edit Assistant');

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
		$sql = "UPDATE `assistant` SET `hunts` = '".boolv('hunt')."', `cg` = '".boolv('cg')."', `kg` = '".boolv('kg').
				"', `ladder` = '".boolv('ladder')."', `om` = '".boolv('om')."' WHERE `id` = ".$_REQUEST['id'];
		if (mysql_query($sql, $db))
			echo 'User updated successfully.';
		else
			echo 'Error: ' . mysql_error($db);
	}
	elseif ($_REQUEST['next']) {
		$sql = "SELECT * FROM `assistant` WHERE `date_deleted` = 0 AND `id` = ".$_REQUEST['id'];
		$query = mysql_query($sql, $db);
		$data = mysql_fetch_assoc($query);

		$form = new Form($_SERVER['PHP_SELF']);
		
		$form->addSectionTitle('Access For ' . $roster->getPerson($data['person'])->getName());
		$form->addHidden('id', $_REQUEST['id']);
		$form->addCheckbox('Hunt Access', 'hunt', 1, $data['hunts']);
		$form->addCheckbox('Cadre Games', 'cg', 1, $data['cg']);
		$form->addCheckbox('Kabal Games', 'kg', 1, $data['kg']);
		$form->addCheckbox('Tactician\'s Ladder', 'ladder', 1, $data['ladder']);
		$form->addCheckbox('Online Missions', 'om', 1, $data['om']);
		
		$form->AddSubmitButton('submit', 'Save Access');
		$form->EndForm();
	} else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('Assistant:', 'id');
		
		$sql = "SELECT `id`,`person` FROM `assistant` WHERE `date_deleted` = 0";
		$query = mysql_query($sql, $db);
		
		while ($info = mysql_fetch_assoc($query))
			$form->addOption($info['id'], $roster->getPerson($info['person'])->getName());
		
		$form->EndSelect();
		
		$form->AddSubmitButton('next', 'Edit Assistant\'s Access');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
