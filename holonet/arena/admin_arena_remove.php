<?php
function title() {
    return 'Administration :: Arena :: Remove Challenge';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['arena'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data;

    arena_header();
    
    if (isset($_REQUEST['id'])){
	    $match = new Match($_REQUEST['id']);
	
	    if ($match->Remove()){
	        echo "Match removed!";
	    } else {
	        NEC(70);
	    }
    }
    
    admin_footer($auth_data);

}
?>
