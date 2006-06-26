<?php
include_once('header.php');

page_header('Edit Event Type');

if ($level == 3) {
	
	if ($_REQUEST['delete']){
		
		if (isset($_REQUEST['event'])){
			
			$event = new CGType($_REQUEST['event'], $db);
			
			if ($event->DeleteHandler($_REQUEST['del_flag'])){
				echo 'Event successfully '.strtolower($_REQUEST['del_flag']).'d.';
			} else {
				echo "Error from Delete Handler";
			}
			
		} else {
			echo 'Error passing the required event field';
		}
		
	
		
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
