<?php
function title() {
    return 'Administration :: Solo Mission :: Process Retirees';
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

    $ro = new RO();
    
    $solo = new Solo();
    if (isset($_REQUEST['contract_id'])){
	    $contract = new Contract($_REQUEST['contract_id']);
	    $npc = $contract->GetNPC();
    }

    if (isset($_REQUEST['next'])) {
	    
        $type = $contract->GetType();
        $person = $contract->GetHunter();

        echo $contract->GetLink();
        echo '<br />[b]Contract Retired by[/b]: '.$person->GetName();
        echo '<br />Available in the Dead Contract Office';

        hr();

        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Confirm Repost', 2);
        $form->table->EndRow();
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);
        $form->AddSubmitButton('dco', 'Complete Process');
        $form->EndForm();

    }
    elseif (isset($_REQUEST['dco'])) {

        if ($contract->DeDCO()){
	        $contract->SetHunter(0)
            echo "Process finished.";

        } else {

            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 52';
        }

    }
    else {
	    if (count($solo->RetireRequests())){
	        $form = new Form($page);
	        $form->StartSelect('Contract:', 'contract_id');
	        foreach ($solo->RetireRequests() as $value) {
		        $hunter = $value->GetHunter();
		        $type = $value->GetType();
		        if (is_object($hunter)){
	            	$form->AddOption($value->GetID(), $type->GetName()." Contract ".$value->GetContractID()." - ".$hunter->GetName());
            	}
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