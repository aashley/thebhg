<?php

function title() {
    return 'AMS Challenge Network :: Lone Wolf Mission :: Request Dead Contract';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data;
}

function output() {
    global $arena, $roster, $hunter, $page, $auth_data;

    arena_header();

    if ($auth_data['lw']){
    
	    $solo = new LW_Solo();
	
	    if (isset($_REQUEST['submit'])) {
	
	        $contract = new LW_Contract($_REQUEST['contract_id']);
	
	        if ($contract->SetHunter($hunter->GetID())) {
	            echo 'Contract Request Sent.';
    
	            $solo->NotifyComissioner(2, $contract->GetMBID(), $hunter->GetName());
	        }
	        else {
	            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 6';
	        }
	    }
	    else {
		    if (count($solo->DEadContracts())){
		        $form = new Form($page);
		        $form->StartSelect('Contract:', 'contract_id');
		        foreach ($solo->DeadContracts() as $value) {
		            $form->AddOption($value->GetID(), "Contract ".$value->GetContractID());
		        }
		        $form->EndSelect();
		        $form->AddSubmitButton('submit', 'Request');
		        $form->EndForm();
	        } else {
		        echo "No Dead Contracts available.";
	        }
	    }
	} else {
	    echo 'Only Lone Wolves may use this function.';
    }
	      
    arena_footer();
}
?>