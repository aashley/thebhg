<?php

function title() {
    return 'AMS Challenge Network :: Solo Mission :: Request Dead Contract';
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

    if (isset($_REQUEST['submit'])) {

        $contract = new Contract($_REQUEST['contract_id']);

        if ($contract->SetHunter($hunter->GetID())) {
            echo 'Contract Request Sent.';
            
            $solo->NotifyComissioner(2, $contract->GetID(), $hunter->GetName());
        }
        else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 8';
        }
    }
    else {
	    if (count($solo->DeadContracts())){
	        $form = new Form($page);
	        $form->StartSelect('Contract:', 'contract_id');
	        foreach ($solo->DeadContracts() as $value) {
	            $type = $value->GetType();
	            $form->AddOption($value->GetID(), "Difficulty: ".$type->GetName()." | Contract ".$value->GetContractID());
	        }
	        $form->EndSelect();
	        $form->AddSubmitButton('submit', 'Request');
	        $form->EndForm();
        } else {
	        echo "No Dead Contracts available.";
        }
    }

    arena_footer();
}
?>