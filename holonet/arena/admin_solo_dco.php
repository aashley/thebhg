<?php
function title() {
    return 'Administration :: Solo Mission :: Dead Contract';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['solo'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $solo = new Solo();
    if (isset($_REQUEST['contract_id'])){
    	$contract = new Contract($_REQUEST['contract_id']);
	}
    
    if (isset($_REQUEST['submit'])) {
        if ($contract->DCO()) {
            echo 'Contract DCOed.';
        }
        else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 55';
        }
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Contract:', 'contract_id');
        foreach ($solo->PendingContracts() as $value) {
            $form->AddOption($value->GetID(), "Contract ".$value->GetContractID());
        }
        $form->EndSelect();
        $form->AddSubmitButton('submit', 'Mark as a Dead Contract');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>