<?php
function title() {
    return 'Administration :: Tournament :: Alter Double Elimination';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    if (in_array($_REQUEST['act'], $auth_data['activities'])){
    	return $auth_data['aide'];
	}
	
	return false;
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $page;

    arena_header();
    
    $at = new Tournament($_REQUEST['act']);

    if ($_REQUEST['submit']){
	    $at->EditDE($_REQUEST['de']);
	    echo 'Tournament set to '.($_REQUEST['de'] ? 'Double' : 'Single').' Elimination.';
    } else {	        
	    $form = new Form($page);
	    $form->AddHidden('act', $_REQUEST['act']);
	    
	    $value = 'Make this a ';    
	    if ($at->doubleelim){
		    $value .= 'Single Elimination';
		    $form->AddHidden('de', 0);
	    } else {
		    $value .= 'Double Elimination';
		    $form->AddHidden('de', 1);
	    }
	    
	    $value .= ' for the rest of the rounds.';
	    
	    $form->AddSubmitButton('submit', $value);
	    $form->EndForm();
    }
    
    admin_footer($auth_data);

}
?>
