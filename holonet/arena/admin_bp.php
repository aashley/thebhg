<?php

function title() {
    return 'Administration :: Overseer Utilities :: Bonus Points';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['overseer'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;

    arena_header();

    if (isset($_REQUEST['submit'])){
	    
	    $error = false;
	    
	    for ($i = 0; $i < 20; $i++) {
      
			$person = "person$i";
			
			$reason = "val$i";
			
			if ($_REQUEST[$person] > 0){
				$character = new Character($_REQUEST[$person]);
            	if (!$character->AddPoint($_REQUEST[$reason])){
	            	$error = true;
            	}
        	}
			
		}
		
		if ($error){
			echo 'Erorr';
		} else {
			echo 'Bonus points added.';
		}
		
		hr();
	    
    }

	$form = new Form($page);
  	$bar_maid = 10;
	$form->table->StartRow();
	$form->table->AddHeader('Hunter');
	$form->table->AddHeader('Reason');
	$form->table->EndRow();
	include_once 'multiple.php';

    $form->table->StartRow();
	$form->table->AddCell('<input type="submit" name="submit" value="Add Bonus Points" size="50">', 2);
	$form->table->EndRow();
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>