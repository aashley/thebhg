<?php

function title() {
    return 'AMS Challenge Network :: Solo Mission :: Retire Contract';
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

    $solo = new Solo();
	$sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){
    
	    $hunter = new Hunter($hunter->GetID());    
	    
	    if (isset($_REQUEST['submit'])) {
	
	        $contract = new Contract($_REQUEST['contract_id']);
	
	        if ($contract->Retire()) {
	            echo 'Contract Retired.';
	            
	            $solo->NotifyComissioner(3, $contract->GetMBID(), $hunter->GetName());
	        }
	        else {
	            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 8';
	        }
	    }
	    else {
		    if (count($hunter->Contracts())){
		        $form = new Form($page);
		        $form->StartSelect('Contract:', 'contract_id', $_REQUEST['contract']);
		        foreach ($hunter->Contracts() as $value) {
		            $type = $value->GetType();
		            $form->AddOption($value->GetID(), "Difficulty: ".$type->GetName()." | Contract ".$value->GetContractID());
		        }
		        $form->EndSelect();
		        $form->AddSubmitButton('submit', 'Retire');
		        $form->EndForm();
	        } else {
		        echo "You have no pending contracts.";
	        }
	    }
	    
	} else {	    
	    echo 'You need a Character Sheet to get contracts. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();
}
?>