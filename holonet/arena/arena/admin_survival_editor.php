<?php
function title() {
    return 'Administration :: Survival Missions :: Mission Editor';
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
        $type = $contract->GetType();

        $form = new Form($page);
        $form->table->StartRow();
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();
        $form->table->StartRow();
        $form->table->AddCell('Message Board ID:');
        $form->table->AddCell('<input type="text" name="mbid" value="'.$contract->GetMBID().'" size="10">');
        $form->table->EndRow();
        $type = $contract->GetType();
	    $creatures = $solo->Creatures($type->GetID());
	    $npc = $contract->GetNPC();
	    $form->StartSelect('Creature', 'creature', $npc->GetID());
	    foreach ($creatures as $creature){
		    $form->AddOption($creature->GetID(), $creature->GetName());
	    }
	    $form->EndSelect();
        $form->StartSelect('Type:', 'type', $type->GetID());
        foreach ($solo->Types() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();

        $form->AddSubmitButton('submit', 'Edit Contract');
        $form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
        $edit = $contract->Edit($_REQUEST['type'], $_REQUEST['mbid']);
        print_r($edit);
    }
    else {
	    if (count($solo->Contracts())){
	        $form = new Form($page);
	        $form->StartSelect('Mission:', 'contract_id');
	        foreach ($solo->Contracts() as $value) {
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