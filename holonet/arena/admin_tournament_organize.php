<?php
function title() {
    return 'Administration :: Arena Tournament :: Organize Brackets';
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
	    
	    $brackets = $_REQUEST['bracket'];
	    
	    if (count($brackets) > 2){
		    echo 'You have selected too many contestants to switch. Limit to 2 clicks, those being the two hunters you want to swap. Try again.';
    	} else {
	    	$bracket = array_keys($brackets);
	    	
	    	if ($at->Organize($bracket[0], $brackets[$bracket[1]], $bracket[1], $brackets[$bracket[0]])){
		        echo "Brackets Switched";
		    } else {
		        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 108';
		    }
	    	
    	}		    
	    
    	hr();
    	
    }   
    
    
    $form = new Form($page, 'Round '.$at->CurrentRound(), true);
    
    $at->AdminOrganize($form);
    
    $form->AddSubmitButton('submit', 'Make Switch');
    
    $form->EndForm();
    
    admin_footer($auth_data);

}
?>
