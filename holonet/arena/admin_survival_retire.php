<?php
function title() {
    return 'Administration :: Survival Missions :: Process Retirees';
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
	    $npc = $contract->GetNPC();
    }

    if (isset($_REQUEST['next'])) {
	    
        $type = $contract->GetType();

        echo $contract->GetLink();
        echo '<br />[b]Mission Retired[/b]';
        echo '<br />Available as a Failed Mission';

        hr();

        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Confirm Retire', 2);
        $form->table->EndRow();
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);
        $form->AddSubmitButton('dco', 'Complete Process');
        $form->EndForm();

    }
    elseif (isset($_REQUEST['dco'])) {

        if ($contract->DeDCO()){
	        if ($contract->SetHunter(0)){
            	echo "Process finished.";
        	} else {
	        	NEC(178);
        	}

        } else {

            NEC(179);
        }

    }
    else {
	    if (count($solo->RetireRequests())){
	        $form = new Form($page);
	        $form->StartSelect('Mission:', 'contract_id');
	        foreach ($solo->RetireRequests() as $value) {
		        $type = $value->GetType();
	            $form->AddOption($value->GetID(), $type->GetName()." Mission ".$value->GetContractID());
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