<?php

function output(){
	global $ka;
	
	if ($_REQUEST['submit']){
		$errors = array();
		
		if (parse_date_box('start') > parse_date_box('end')){
			$errors[] = 'Your season can not start after it ends.';
		}
		
		if ($_REQUEST['maximum'] < $_REQUEST['minimum']){
			$errors[] = 'Your maximum points can not be smaller than your minimum points.';
		}
		
		if ($_REQUEST['kabal_count'] <= 0){
			$errors[] = 'You must have a positive kabal count amount, or the season won\'t work.';
		}
		
		if (!count($errors)){
			
			if ($ka->NewKAC($_REQUEST['id'], parse_date_box('start'), parse_date_box('end'), $_REQUEST['maximum'], $_REQUEST['minimum']
					, $_REQUEST['kabal_count'])){
				echo 'New KAC season started successfully.';
			} else {
				echo $ka->Error();
			}
			
		} else {
			echo implode('<br />', $errors);
		}
		
		hr();
	}
	
	$form = new Form($PHP_SELF);
	
	$form->AddSectionTitle('Enter Season Data');
	
	$form->AddTextBox('Last KAG Season Number', 'id', '', 5);
	$form->AddDateBox('Start', 'start', '', true);
	$form->AddDateBox('End', 'end', '', true);
	$form->AddTextBox('Maximum Points', 'maximum', 11, 5);
	$form->AddTextBox('Minimum Points', 'minimum', 1, 5);
	$form->AddTextBox('Top Finishers Per Kabal', 'kabal_count', 5, 5);
		
	$form->AddSubmitButton('submit', 'Start new KAC');
	$form->EndForm();
	
	echo "
		Notes:
		<ul>
			<li><b>Last KAG Season Number</b>: This is the number which corresponds to the last season of the KAG and is used to generate the brackets. If you just finished KAG 70, enter 70 in this box.</li>
			<li><b>Maximum Points</b>: The number of points which is maximum for hunters, plus one for events. So if you want 10 points (the standard) the max points are 11.</li>
			<li><b>Minimum Points</b>: The minimum number of points hunters will get for completing an event. If you want zero, put 1, just as with maximum.</li>
			<li><b>Top Finishers per Kabal</b>: Usually 5, it is the number of entries received per kabal when tabulating kabal vs. kabal ranks.</li>
		</ul>
		";
	
}

?>