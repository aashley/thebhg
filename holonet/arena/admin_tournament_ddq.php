<?php
function title() {
    return 'Administration :: Tournament :: Double Disqualification';
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
    global $arena, $hunter, $roster, $auth_data;

    arena_header();
    
    $at = new Tournament($_REQUEST['act']);

    if (isset($_REQUEST['id'])){
    
	    if ($at->DoubleDQ($at->CurrentRound(), $_REQUEST['id'])){
	        echo "DDQ declared.";
	    } else {
	        echo 'Error';
	    }
	    
	    $at->NewRound();
	    
    }
    
    admin_footer($auth_data);

}
?>
