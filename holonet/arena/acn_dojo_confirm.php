<?php

function title() {
    return 'AMS Challenge Network :: Dojo of Shadows :: Send Challenge';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
    global $arena, $hunter, $roster;

    arena_header();

    $control = new Control();

    if (isset($_REQUEST['challengee'])){
    
    	if ($_REQUEST['challengee'] == -1) {
	        
	        echo "You need to pick a challenger first, bud.";
	        
        } elseif ($_REQUEST['challengee'] != $hunter->GetID()) {
            $hunted = $roster->GetPerson($_REQUEST['challengee']);
            $local = explode("_", $_REQUEST['location']);

            $new = $control->Challenge('3', $local[0], $local[1], $_REQUEST['posts'], $_REQUEST['num_weapon'], $hunter->GetID(), 
            	$hunted->GetID(), $_REQUEST['type_weapon'], 'http://holonet.thebhg.org/', 1);

            if ($new){
                echo "Challenge made successfully.";
            }
            else {
                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 2';
            }
        }
        else {
            echo 'You want to challenge yourself to a fight? How... interesting.';
        }
        
    }

    arena_footer();

}
?>
