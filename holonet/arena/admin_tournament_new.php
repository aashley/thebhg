<?php
function title() {
    return 'Administration :: Arena Tournament :: Start New Tournament';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $page;

    arena_header();
    
    $at = new Tournament();
    
    if (isset($_REQUEST['submit'])) {
	    
	    if ($at->SetSignup(parse_date_box('start'), parse_date_box('end'), $_REQUEST['double_elim'])){
		    echo "New season information added.";
	    } else {
		    NEC(34);
	    }
	    
    } else {
    
	    $form = new Form($page);
	    
	    $form->AddDateBox('Start Date', 'start');
	    $form->AddDateBox('End Date', 'end');
	    $form->AddCheckBox('Double Elimination', 'double_elim', '1');
	    
	    $form->AddSubmitButton('submit', 'Start New Season');
	    
	    $form->EndForm();
	    
    }
    
    admin_footer($auth_data);

}
?>
