<?php

function title() {
    return 'AMS Challenge Network :: Lone Wolf Mission :: Request Contract';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data;
}

function output() {
    global $arena, $roster, $hunter, $page, $auth_data;

    arena_header();

    $solo = new LW_Solo();
    $control = new LW_SoloControl();

    arena_header();
    
    if ($auth_data['lw']){
    
	    if ($solo->PendingContract($hunter->GetID())){
	
	        echo "You have a contract pending already. You can not request another contract until your current contract is completed or retired.<br /><br />~Challenge Network.";
	
	    }
	    else {
		    
	        if (isset($_REQUEST['submit'])) {
	            if ($control->New_Contract($hunter->GetID())) {
	                echo 'Contract Requested.';
	            }
	            else {
	                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 5';
	            }
	        }
	        else {
	            $form = new Form($page);
	            $form->StartSelect('Type of Contract:', 'type');
	            $form->AddOption(1, 'Lone Wolf');
	            $form->EndSelect();
	            $form->AddSubmitButton('submit', 'Request Contract');
	            $form->EndForm();
	        }
	    }  
    } else {
	    echo 'Only Lone Wolves may use this function.';
    }

    arena_footer();
}
?>