<?php

function title() {
    return 'Administration :: General Management :: Expeirence Points';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return ($auth_data['aide'] || $auth_data['ch']);
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
				if ($auth_data['aide']){
					$character = new Character($_REQUEST[$person]);
		            if (!$character->XPEvent($_REQUEST[$xp], $_REQUEST['reason'])){
			            $error = true;
		            }
				} else {
					$arena->StorePendingXP($_REQUEST[$person], $kabalch->GetName().' Chief Award: '.$_REQUEST['reason'], $_REQUEST[$xp], $hunter->GetID());
	            }
        	}
			
		}
		
		if ($error){
			echo 'Erorr';
		} else {
			echo 'Experience Points Added.';
		}
		
		hr();
	    
    }

	$form = new Form($page);
	$form->AddTextBox('Reason:', 'reason');
  	$bar_maid = 10;
  	$zise = 5;
	$form->table->StartRow();
	$form->table->AddHeader('Hunter');
	$form->table->AddHeader('Points');
	$form->table->EndRow();
	
	if (!$auth_data['aide']){
		$bar_cunt = array($kabalch->GetID());
	}

	include_once 'multiple.php';

    $form->table->StartRow();
	$form->table->AddCell('<input type="submit" name="submit" value="Add Experience Points" size="50">', 2);
	$form->table->EndRow();
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>