<?php
include_once('header.php');

page_header('Delete Assistant');

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
		$sql = "UPDATE `assistant` SET `date_deleted` = '".time()."' WHERE `id` = ".$_REQUEST['id'];
		if (mysql_query($sql, $db))
			echo 'User deleted successfully.';
		else
			echo 'Error: ' . mysql_error($db);
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('Assistant:', 'id');
		
		$sql = "SELECT `id`,`person` FROM `assistant` WHERE `date_deleted` = 0";
		$query = mysql_query($sql, $db);
		
		while ($info = mysql_fetch_assoc($query))
			$form->addOption($info['id'], $roster->getPerson($info['person'])->getName());
		
		$form->EndSelect();
		
		$form->AddSubmitButton('submit', 'Delete Assistant');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
