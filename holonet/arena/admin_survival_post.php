<?php
function title() {
    return 'Administration :: Survival Missions :: Contract Poster';
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
	    $form = new Form($page);
	    $form->AddHidden('contract_id', $_REQUEST['contract_id']);
	    $form->AddSectionTitle('Creature Target');
	    $type = $contract->GetType();
	    $creatures = $solo->Creatures($type->GetID());
	    $form->StartSelect('Creature', 'creature', array_rand($creatures));
	    foreach ($creatures as $creature){
		    $form->AddOption($creature->GetID(), $creature->GetName());
	    }
	    $form->EndSelect();
	    $form->AddSubmitButton('second', 'Write Post');
	    $form->EndForm();
    }
    elseif (isset($_REQUEST['second'])) {

	    $contract->SetCreature($_REQUEST['creature']);
	    $contract = new SurvivalContract($_REQUEST['contract_id']);
	    
        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Enter Mission Information', 2);
        $form->table->EndRow();
        $form->AddTextArea('Mission Information', 'info');
        $form->table->StartRow();
        $form->table->AddHeader('Creature Target', 2);
        $form->table->EndRow();
        $form->table->StartRow();
        $form->table->AddCell($npc->WriteSheet(), 2);
        $form->table->EndRow();
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);

        $form->AddSubmitButton('generate', 'Generate Post');
        $form->EndForm();

    }
    elseif (isset($_REQUEST['generate'])) {
        $type = $contract->GetType();
        $person = $contract->GetHunter();

        echo "<b>Subject Line</b>: Mission ".$contract->GetContractID()." - ".$person->GetName()."<br /><br />";

        echo "[i]Survival Mission ".$contract->GetContractID()." - Target: ".$npc->GetName()."[/i]<br /><br />";
        echo "Mission must be completed by: ".$contract->GetTimeframe()." Midnight, EST<br /><br />";
        echo "{".$type->GetName()." Mission}<br /><br />";
        echo "[b]Information[/b]<br />".stripslashes($_REQUEST['info'])."<br /><br />";
        echo "[b]Creature Stats[/b]<br />".$npc->WriteSheet();
        echo "Good Hunting.";

        echo "<br /><br />";

        hr();

        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Enter Message Board ID', 2);
        $form->table->EndRow();
        $form->AddTextBox('Topic Number:', 'mbid');
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);
        $form->AddSubmitButton('submit', 'Complete Process');
        $form->EndForm();

    }
    elseif (isset($_REQUEST['submit'])) {

        if ($contract->SetMBID($_REQUEST['mbid'])){
	        $contact = $contract->GetHunter();
            $contact->Notify($_REQUEST['mbid']);
            echo "Mission process completed.";
        } else {
            NEC(180);
        }

    }
    else {
	    if (count($solo->RequestedContracts())){
	        $form = new Form($page);
	        $form->StartSelect('Mission:', 'contract_id');
	        foreach ($solo->RequestedContracts() as $value) {
		        $hunter = $value->GetHunter();
		        if ($hunter){
			        $name = $hunter->GetName();
		        } else {
			        $name = "Dead Contract";
		        }
		        $type = $value->GetType();
	            $form->AddOption($value->GetID(), $type->GetName()." Mission ".$value->GetContractID()." - ".$name);
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