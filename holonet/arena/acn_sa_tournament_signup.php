<?php

function title() {
    return 'AMS Challenge Network :: Starfield Arena Tournament :: Signup';
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
    $starfield = new Starfield();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){
	
	    if (count($starfield->Ships($hunter->GetID()))){
	    
		    $form = new Form('acn_sa_tournament_confirm');
		    
		    $form->StartSelect('Your Ship:', 'my_ship');
	            foreach ($starfield->Ships($hunter->GetID()) as $value){
	                $form->AddOption(key($value), current($value));
	            }
	        $form->EndSelect();
		    
	        $form->AddSubmitButton('submit', 'Sign me up!');
	        $form->EndForm();
	    } else {
		    echo 'You need a ship to participate in the Starfield Arena Tournament.';
	    }
	} else {	    
	    echo 'You need a Character Sheet to challenge anyone. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();

}
?>
