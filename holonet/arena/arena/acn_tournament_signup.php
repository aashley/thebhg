<?php

function title() {
    return 'AMS Challenge Network :: Arena Tournament :: Signup';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
    global $arena, $hunter, $roster, $page, $auth_data;

    arena_header();

    $sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){

	    echo "By clicking the below link, you will enter yourself into the current roster for the next Arena Tournament. Once you are entered, you can not"
	    	." be removed, so please, <b>do not click on the link which says 'Sign me up' if you do not intend to sign up</b>.";
	    
	    hr();
	
	    echo '<a href="' . internal_link('acn_tournament_confirm') . '">Sign me up!</a>';
	} else {	    
	    echo 'You need a Character Sheet to challenge anyone. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();

}
?>
