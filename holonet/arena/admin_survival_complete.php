<?php
function title() {
    return 'Administration :: Survival Missions :: Complete Mission';
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

    if (isset($_REQUEST['next'])) {       
        $form = new Form($page);
        $form->AddSectionTitle('Imput Contract Stats');
        $form->StartSelect('Grade:', 'grade');
        foreach ($solo->GetGrades() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddTextBox('Credits Earned:', 'creds');
        $form->AddTextBox('Experience Points:', 'xp');
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);
        $form->AddSubmitButton('submit', 'Complete Mission');
        $form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
        if ($contract->Complete($_REQUEST['creds'], $_REQUEST['xp'], $_REQUEST['grade'])) {
	        $ahunter = $contract->GetHunter();
	        $person = new Person($ahunter->GetID());
	        $character = new Character($person->GetID());
	        $character->XPEvent($_REQUEST['xp'], 'Survival Mission '.$contract->GetContractID());
	        
            echo 'Mission Completed.';
        }
        else {
            NEC(188);
        }
    }
    else {
	    if (count($solo->PendingContracts())){
	        $form = new Form($page);
	        $form->StartSelect('Mission:', 'contract_id');
	        foreach ($solo->PendingContracts() as $value) {
	            $form->AddOption($value->GetID(), "Mission ".$value->GetContractID());
	        }
	        $form->EndSelect();
	        $form->AddSubmitButton('next', 'Next >>');
	        $form->EndForm();
        } else {	        
	        echo "No Pending Missions.";	        
        }
    }

    admin_footer($auth_data);
}
?>