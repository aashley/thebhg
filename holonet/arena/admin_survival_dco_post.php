<?php
function title() {
    return 'Administration :: Survival Missions :: Dead Contract Poster';
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

    $ro = new RO();
    
    $solo = new Survival();
    if (isset($_REQUEST['contract_id'])){
	    $contract = new SurvivalContract($_REQUEST['contract_id']);
	    $npc = $contract->GetNPC();
    }

    if (isset($_REQUEST['next'])) {
	    
        $type = $contract->GetType();
        $person = $contract->GetHunter();

        echo $contract->GetLink();
        echo '<br />[b]Mission Issued To[/b]: '.$person->GetName();
        echo '<br />Must be completed by: '.$contract->GetTimeframe();

        hr();

        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Confirm Repost', 2);
        $form->table->EndRow();
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);
        $form->AddSubmitButton('submit', 'Complete Process');
        $form->AddSubmitButton('dco', 'Deny');
        $form->EndForm();

    }
    elseif (isset($_REQUEST['submit'])) {

        if ($contract->DeDCO()){
	        if ($contact = $contract->GetHunter()){
		        $contact->Notify($_REQUEST['mbid']);
            	echo "Contract process completed.";
        	} else {
	        	NEC(186);
        	}

        } else {

            NEC(185);
        }

    }
    elseif (isset($_REQUEST['dco'])) {

        if ($contract->DeDCO()){
	        $contract->SetHunter(0);
            echo "Denied reacquisition of dead contract.";

        } else {

            NEC(185);
        }

    }
    else {
	    if (count($solo->DCORequests())){
	        $form = new Form($page);
	        $form->StartSelect('Mission:', 'contract_id');
	        foreach ($solo->DCORequests() as $value) {
		        $hunter = $value->GetHunter();
		        $type = $value->GetType();
		        if (is_object($hunter)){
	            	$form->AddOption($value->GetID(), $type->GetName()." Mission ".$value->GetContractID()." - ".$hunter->GetName());
            	}
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