<?php
include_once('header.php');

page_header('Delete KAG');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		$kag = $ka->GetKAG($_REQUEST['id']);
		if ($kag->DeleteKAG()) {
			echo 'KAG deleted.';
		}
		else {
			echo 'Error deleting KAG.';
		}
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('KAG:', 'id');
		foreach (array_reverse($ka->GetKAGs()) as $kag) {
			$form->AddOption($kag->GetID(), roman($kag->GetID()));
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Delete KAG');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to view this page.';
}

page_footer();
?>
