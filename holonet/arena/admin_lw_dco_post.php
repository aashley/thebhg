<?php
function title() {
    return 'Administration :: Lone Wolf Mission :: Dead Contract Poster';
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
        echo '<br />[b]Contract Issued To[/b]: '.$person->GetName();
        echo '<br />Must be completed by: '.$contract->GetTimeframe();

        hr();

        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Confirm Repost', 2);
        $form->table->EndRow();
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);
        $form->AddSubmitButton('submit', 'Complete Process');
        $form->EndForm();

    }
    elseif (isset($_REQUEST['submit'])) {

        if ($contract->DeDCO()){
	        $contact = $contract->GetHunter();
            $contact->Notify($_REQUEST['mbid']);
            echo "Contract process completed.";

        } else {

            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 59';
        }

    }
    else {
	    if (count($solo->RequestedContracts())){
	        $form = new Form($page);
	        $form->StartSelect('Contract:', 'contract_id');
	        foreach ($solo->DCORequests() as $value) {
		        $hunter = $value->GetHunter();
	            $form->AddOption($value->GetID(), "Contract ".$value->GetContractID()." - ".$hunter->GetName());
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