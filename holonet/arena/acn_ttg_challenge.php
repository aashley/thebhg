<?php

function title() {
    return 'AMS Challenge Network :: Twilight Gauntlet :: Challenge the Gauntlet';
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

    $ttg = new TTG();

    if (in_array($hunter->GetID(), $ttg->Members())) {
	    
		    echo "You can't run the Gauntlet if you're in the Gauntlet...";
		    
	} else {
    
	    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';
	
	    hr();
	    
	    $form = new Form('acn_ttg_confirm');
	    
	    $form->table->StartRow();
	    $form->table->AddHeader('Twilight Gauntlet Queue', 2);
	    $form->table->EndRow();
	    
	    $form->table->StartRow();
	    $form->table->AddCell('Think you\'re good enough, do you? Then make your stand! Throw down the Twilight Gauntlet!', 2);
	    $form->table->EndRow();
	
	    $form->table->AddRow('Challenges pending in the queue:', $ttg->Pending());
	    
	    $form->AddSubmitButton('submit', 'Challenge the Gauntlet');
	    $form->EndForm();
	    
    }

    arena_footer();

}
?>
