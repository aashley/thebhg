<?php

if ($_REQUEST['match']){
	function display(){
		global $activity, $arena, $type, $roster, $page;
		
		$obj = new Obj('ams_match', $_REQUEST['match'], 'holonet');
		
		if ($_REQUEST['submit']){
			
			$no = false;
			
			if ($_REQUEST['data']['values'][0] == 0){
				$_REQUEST['data']['values'][] = $obj->Get(to_date);
				$_REQUEST['data']['fields'][] = 'should_be';
				$no = true;
			}
			
			$search = $arena->Search(array('table'=>'ams_records', 'search'=>array('match'=>$obj->Get(id), 'outcome'=>0, 'date_deleted'=>0)));
	    	foreach ($search as $ob){
		    	$man = new Person($ob->Get(bhg_id));
		    	$man->SendEmail(from(), 'Event Extension', "Your requested extension for ".$obj->Get(name)." has been ".($no ? 'denied' : 'approved').".");
	    	}
			
			$return = array();
			foreach ($_REQUEST['data'][fields] as $i=>$field){
				$return[$field] = $_REQUEST['data']['values'][$i];
			}
			//When PHP 5:
			//$return = array_combine($_REQUEST['data'][fields], $_REQUEST['data'][values]);
			$obj->Edit($return, 1);
			echo 'Processed';
		} else {		    
			$form = new Form($page);
		    
		    $form->AddHidden('data[table]', 'ams_match');
		    $form->AddSectionTitle('Approve Request');
		    
		    $form->table->AddRow('Reason', $obj->Get(comments));
		    $form->table->AddRow('To Date', $obj->Get(to_date, 0, 1));

		    $form->StartSelect('Approve', 'data[values][]', $obj->Get(accepted));
			$form->AddOption(0, 'No');
			$form->AddOption(1, 'Yes');
			$form->EndSelect();
		    $form->AddHidden('data[fields][]', 'accepted');
		    
		    $form->AddHidden('data[values][]', '');
			$form->AddHidden('data[fields][]', 'comments');
			$form->AddHidden('data[values][]', 0);
			$form->AddHidden('data[fields][]', 'to_date');
		    
		    $form->AddHidden('id', $_REQUEST['id']);
			$form->AddHidden('op', $_REQUEST['op']);
			$form->AddHidden('match', $_REQUEST['match']);

		    $form->AddSubmitButton('submit', 'Transmit to Holonet Servers');
		    $form->EndForm();
	    }
    }
} else {
	include_once 'extension.php';
}

?>