<?php
function title() {
    return 'Administration :: Solo Mission :: Contract Poster';
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

        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Enter Contract Information', 2);
        $form->table->EndRow();
        $form->AddTextArea('Contract Information', 'info');
        $form->table->StartRow();
        $form->table->AddHeader('Non-Player Character', 2);
        $form->table->EndRow();
        $form->table->StartRow();
        $form->table->AddCell($npc->BuildSheet(), 2);
        $form->table->EndRow();
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);

        $form->AddSubmitButton('generate', 'Generate Post');
        $form->EndForm();

    }
    elseif (isset($_REQUEST['generate'])) {
        $type = $contract->GetType();
        $person = $contract->GetHunter();

        echo "<b>Subject Line</b>: Contract ".$contract->GetContractID()." - ".$person->GetName()."<br /><br />";

        echo "[i]Bounty Contract ".$contract->GetContractID()." - Target: ".$npc->GetName()."[/i]<br /><br />";
        echo "Contract must be completed by: ".$contract->GetTimeframe()." Midnight, EST<br /><br />";
        echo "{".$type->GetName()." Contract}<br /><br />";
        echo "[b]Information[/b]<br />".stripslashes($_REQUEST['info'])."<br /><br />";
        echo "[b]Stats on Target[/b]<br />".$npc->BuildSheet();
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
            echo "Contract process completed.";

        } else {

            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 52';
        }

    }
    else {
	    if (count($solo->RequestedContracts())){
	        $form = new Form($page);
	        $form->StartSelect('Contract:', 'contract_id');
	        foreach ($solo->RequestedContracts() as $value) {
		        $hunter = $value->GetHunter();
		        if ($hunter){
			        $name = $hunter->GetName();
		        } else {
			        $name = "Dead Contract";
		        }
		        $type = $value->GetType();
	            $form->AddOption($value->GetID(), $type->GetName()." Contract ".$value->GetContractID()." - ".$name);
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