<?php

function title() {
    return 'AMS Challenge Network :: Tempestuous Group :: Petition for Enterance';
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

    $tempy = new Tempy();
    $sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){

	    if (in_array($hunter->GetID(), $tempy->Members())) {
		    
			    echo "You can't petition to join the Tempestuous Board.";
			    
		} else {
	    
		    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';
		
		    hr();
		    
		    $form = new Form('acn_tempy_confirm');
		    
		    $form->table->StartRow();
		    $form->table->AddHeader('Tempestuous Board Petition', 2);
		    $form->table->EndRow();
		    
		    $form->table->StartRow();
		    $form->table->AddCell('Think you\'re good enough, do you? Well, fill out the reasons you think so and find out!', 2);
		    $form->table->EndRow();
		    
		    $form->AddTextArea('Why should you be admitted:', 'reason');
		    
		    $form->AddSubmitButton('submit', 'Submit Petition');
		    $form->EndForm();
		    
	    }
	    
    } else {	    
	    echo 'You need a Character Sheet to petition. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();

}
?>
