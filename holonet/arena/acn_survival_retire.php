<?php

function title() {
    return 'AMS Challenge Network :: Survival Mission :: Retire Mission';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
    global $arena, $roster, $hunter, $page;

    arena_header();

    $solo = new Survival();
	$sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){
    
	    $hunter = new SurvivalHunter($hunter->GetID());    
	    
	    if (isset($_REQUEST['submit'])) {
	
	        $contract = new SurvivalContract($_REQUEST['contract_id']);
	
	        if ($contract->Retire()) {
	            echo 'Mission Retired.';
	            
	            $solo->NotifyRanger(3, $contract->GetMBID(), $hunter->GetName());
	        }
	        else {
	            NEC(192);
	        }
	    }
	    else {
		    if (count($hunter->Contracts())){
		        $form = new Form($page);
		        $form->StartSelect('Mission:', 'contract_id', $_REQUEST['contract']);
		        foreach ($hunter->Contracts() as $value) {
		            $type = $value->GetType();
		            $form->AddOption($value->GetID(), "Difficulty: ".$type->GetName()." | Mission ".$value->GetContractID());
		        }
		        $form->EndSelect();
		        $form->AddSubmitButton('submit', 'Retire');
		        $form->EndForm();
	        } else {
		        echo "You have no pending missions.";
	        }
	    }
	    
	} else {	    
	    echo 'You need a Character Sheet to get missions. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();
}
?>