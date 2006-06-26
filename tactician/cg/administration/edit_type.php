<?php
include_once('header.php');

page_header('Edit Event Type');

if ($level == 3) {
	
	if ($_REQUEST['delete']){
		
		
	} else {
	
		$form = new Form($PHP_SELF);
		
		$form->AddSectionTitle('Select Event Type');
		
		
		
		$form->AddSubmitButton('next', 'Continue to Edit >>');
		$form->EndForm();
		
	}
	
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
