<?php
function title() {
    return 'Administration :: Starfield Arena Tournament :: Organize Brackets';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['star'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $page;

    arena_header();
    
    $at = new SATournament();

    if (isset($_REQUEST['submit'])) {
	    
	    $brackets = $_REQUEST['bracket'];
	    
	    if (count($brackets) > 2){
		    echo 'You have selected too many contestants to switch. Limit to 2 clicks, those being the two hunters you want to swap. Try again.';
    	} else {
	    	$bracket = array_keys($brackets);
	    	
	    	if ($at->Organize($bracket[0], $brackets[$bracket[1]], $bracket[1], $brackets[$bracket[0]])){
		        echo "Brackets Switched";
		    } else {
		        NEC(200);
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
