<?php
function title() {
    return 'Administration :: Lone Wolf Mission :: Process Retirees';
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
	    $npc = $contract->GetNPC();
    }

    if (isset($_REQUEST['next'])) {
        $person = $contract->GetHunter();

        echo $contract->GetLink();
        echo '<br />[b]Contract Retired by[/b]';
        echo '<br />Available in the Dead Contract Office';

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
		        NEC(163);
	        }

        } else {
			NEC(162);
        }

    }
    else {
	    if (count($solo->RetireRequests())){
	        $form = new Form($page);
	        $form->StartSelect('Contract:', 'contract_id');
	        foreach ($solo->RetireRequests() as $value) {
		        $hunter = $value->GetHunter();
	            $form->AddOption($value->GetID(), "Contract ".$value->GetContractID());
	        }
	        $form->EndSelect();
	        $form->AddSubmitButton('next', 'Next >>');
	        $form->EndForm();
        } else {	        
	        echo "No Pending Contracts.";	        
        }
    }

    admin_footer($auth_data);
}
?>