<?php

function title() {
    return 'AMS Challenge Network :: Starfield Arena :: Send Challenge';
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

    $control = new StarfieldControl();
    
    $i = 0;
    $num = 1;
    $restrictions = array();
    
    $starfield = new StarfieldControl();
    
    $challenge = $starfield->Challenge($_REQUEST['type'], $_REQUEST['restriction'], $_REQUEST['setting'], $_REQUEST['location'], $_REQUEST['posts'],
    				$hunter->GetID(), $_REQUEST['challengee'], $_REQUEST['my_ship'], $_REQUEST['their_ship'], 
    				'http://holonet.thebhg.org/');
    				
    if ($challenge){
	    echo "Challenge Sent Successfully.";
    } else {
	    NEC(9);
    }	   

    arena_footer();

}
?>
