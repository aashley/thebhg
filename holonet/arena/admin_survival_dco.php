<?php
function title() {
    return 'Administration :: Survival Missions :: Dead Contract';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['survival'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $solo = new Survival();
    if (isset($_REQUEST['contract_id'])){
    	$contract = new SurvivalContract($_REQUEST['contract_id']);
	}
    
    if (isset($_REQUEST['submit'])) {
        if ($contract->DCO()) {
            echo 'Mission Failed.';
        }
        else {
            NEC(187);
        }
    }
    else {
	    if (count($solo->PendingContracts())){
	        $form = new Form($page);
	        $form->StartSelect('Mission:', 'contract_id');
	        foreach ($solo->PendingContracts() as $value) {
	            $form->AddOption($value->GetID(), "Contract ".$value->GetContractID());
	        }
	        $form->EndSelect();
	        $form->AddSubmitButton('submit', 'Mark as a Dead Contract');
	        $form->EndForm();
	    } else {	        
	        echo "No Pending Missions.";	        
        }
    }

    admin_footer($auth_data);
}
?>