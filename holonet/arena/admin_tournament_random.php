<?php
function title() {
    return 'Administration :: Tournament :: Randomize Brackets';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    if (in_array($_REQUEST['act'], $auth_data['activities'])){
    	return $auth_data['aide'];
	}
}

function output() {
    global $arena, $hunter, $roster, $auth_data;

    arena_header();
    
    $at = new Tournament($_REQUEST['act']);

    if ($at->Randomize()){
        echo "Brackets randomized.";
    } else {
        echo 'Error';
    }
    
    $at->NewRound();
    
    admin_footer($auth_data);

}
?>
