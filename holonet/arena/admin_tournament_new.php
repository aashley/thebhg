<?php
function title() {
    return 'Administration :: Tournament :: Start New Tournament';
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
    					
    $activity = new Obj('ams_activities', $_REQUEST['act'], 'holonet');
    $type = new Obj('ams_types', $activity->Get(type), 'holonet');

    if ($type->Get(opponent)){
	    $at = new Tournament($_REQUEST['act']);
	    
	    if (isset($_REQUEST['submit'])) {
		    
		    if ($at->SetSignup(parse_date_box('start'), parse_date_box('end'), $_REQUEST['double_elim'], $_REQUEST['act'])){
			    echo "New season information added.";
		    } else {
			    echo 'Error';
		    }
	    } else {
	    
		    $form = new Form($page);
		    
		    $form->AddDateBox('Start Date', 'start');
		    $form->AddDateBox('End Date', 'end');
		    $form->AddCheckBox('Double Elimination', 'double_elim', '1');
		    $form->AddHidden('act', $_REQUEST['act']);
		    
		    $form->AddSubmitButton('submit', 'Start New Season');
		    
		    $form->EndForm();
		    
	    }
    }
    
    admin_footer($auth_data);

}
?>
