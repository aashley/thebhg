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
    global $arena, $hunter, $roster, $page, $auth_data, $citadel;

    arena_header();

    $ttg = new TTG();
    $sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){

	    if (in_array($hunter->GetID(), $ttg->Members())) {
		    
			    echo "You can't run the Gauntlet if you're in the Gauntlet...";
			    
		} else {
	    
		    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';
		
		    $me = $citadel->GetPersonsResults($hunter, CITADEL_PASSED);
		    $mytest = array();
		    foreach ($me as $test){
			    $exam = $test->GetExam();
			    $mytest[] = $exam->GetID();
		    }
		    
		    $exam = $citadel->GetExambyAbbrev('AT');
		    
		    $tests = (in_array($exam->GetID(), $mytest));
		    
		    if (in_array($hunter->GetID(), $arena->GetApproved()) && in_array($_REQUEST['challengee'], $arena->GetApproved()) && $tests){
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
		    } else {
			    echo 'You must be a Dojo Graduate and must have passed the AT test to be allowed to take part in the Twilight Gauntlet.';
		    }
		    
	    }
	    
	} else {	    
	    echo 'You need a Character Sheet to challenge. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();

}
?>
