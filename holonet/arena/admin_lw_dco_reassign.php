<?php
function title() {
    return 'Administration :: Lone Wolf Mission :: Dead Contract Reassign';
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

    $solo = new LW_Solo();
    if (isset($_REQUEST['contract_id'])){
	    $contract = new LW_Contract($_REQUEST['contract_id']);
    }
    
    if (isset($_REQUEST['next'])) {

        $form = new Form($page);
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);
        $form->StartSelect('Hunter:', 'bhg_id');
        hunter_dropdown($form);
        $form->EndSelect();
        $form->AddSubmitButton('submit', 'Reassign Contract');
        $form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
        if ($contract->SetHunter($_REQUEST['bhg_id'])) {
            echo 'Contract Reassigned.';
        }
        else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 63';
        }
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Contract:', 'contract_id');
        foreach ($solo->DeadContracts() as $value) {
            $form->AddOption($value->GetID(), "Contract ".$value->GetContractID());
        }
        $form->EndSelect();
        $form->AddSubmitButton('next', 'Next >>');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>