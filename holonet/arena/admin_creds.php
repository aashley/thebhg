<?php

function title() {
    return 'Administration :: Overseer Utilities :: Award Credits';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['overseer'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet, $arena;

    arena_header();

    $kabalch = $hunter->GetDivision();
    
    if (isset($_REQUEST['submit'])){
	    
	    $error = false;
	    
	    for ($i = 0; $i < 10; $i++) {
      
			$person = "person$i";
			
			$xp = "val$i";
			
			if ($_REQUEST[$person] > 0){
				$awarded = $roster->GetPerson($_REQUEST[$person]);
	        	$awarded->AddCredits($_REQUEST[$xp], $_REQUEST['reason']);
        	}
			
		}
		
		if ($error){
			echo 'Erorr';
		} else {
			echo 'Credits Awarded.';
		}
		
		hr();
	    
    }

	$form = new Form($page);
	$form->AddTextBox('Reason:', 'reason');
  	$bar_maid = 10;
  	$zise = 5;
	$form->table->StartRow();
	$form->table->AddHeader('Hunter');
	$form->table->AddHeader('Credits');
	$form->table->EndRow();
	
	if ($auth_data['aide']){
		$bar_cunt = array($kabalch->GetID());
	}

	include_once 'multiple.php';

    $form->table->StartRow();
	$form->table->AddCell('<input type="submit" name="submit" value="Award Credits" size="50">', 2);
	$form->table->EndRow();
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>