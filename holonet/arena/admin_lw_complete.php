<?php
function title() {
    return 'Administration :: Lone Wolf Mission :: Complete Contract';
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
	    $grad = new Solo();
    }

    if (isset($_REQUEST['next'])) {       
        $form = new Form($page);
        $form->AddSectionTitle('Imput Contract Stats');
        $form->StartSelect('Grade:', 'grade');
        foreach ($grad->GetGrades() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddTextBox('Credits Earned:', 'creds');
        $form->AddTextBox('Experience Points:', 'xp');
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);
        $form->AddSubmitButton('submit', 'Complete Contract');
        $form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
        if ($contract->Complete($_REQUEST['creds'], $_REQUEST['xp'], $_REQUEST['grade'])) {
	        $ahunter = $contract->GetHunter();
	        $person = new Person($ahunter->GetID());
	        $character = new Character($person->GetID());
	        $character->XPEvent($_REQUEST['xp'], 'Lone Wolf Contract '.$contract->GetContractID());
	        
            echo 'Contract Completed.';
        }
        else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 65';
        }
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Contract:', 'contract_id');
        foreach ($solo->PendingContracts() as $value) {
            $form->AddOption($value->GetID(), "Contract ".$value->GetContractID());
        }
        $form->EndSelect();
        $form->AddSubmitButton('next', 'Next >>');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>