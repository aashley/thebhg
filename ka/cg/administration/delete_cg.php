<?php
include_once('header.php');

page_header('Delete CG');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		$cg = $ka->GetCG($_REQUEST['id']);
		if ($cg->DeleteCG()) {
			echo 'CG deleted.';
		}
		else {
			echo 'Error deleting CG.';
		}
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('CG:', 'id');
		foreach (array_reverse($ka->GetCGs()) as $cg) {
			$form->AddOption($cg->GetID(), roman($cg->GetID()));
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Delete CG');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to view this page.';
}

page_footer();
?>
