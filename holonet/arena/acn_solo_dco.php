<?php

function title() {
    return 'AMS Challenge Network :: Solo Mission :: Request Dead Contract';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
    global $arena, $roster, $hunter, $page;

    arena_header();

    $solo = new Solo();
	$sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){
    
	    $hunter = new Hunter($hunter->GetID());
	    $dco = $hunter->DCOPenalty();
	    
	    if ($dco){
		    $date = getdate($dco);
	    	echo '<br />You are currently under the Dead Contract penalty. You cannot request contracts until this ban expires.<br />'
	    		.'This ban will end on: '.$date['month']." ".$date['mday'].", ".$date['year'];
    	} else {
		    if (isset($_REQUEST['submit']) || $_REQUEST['id']) {
			    if ($_REQUEST['contract_id']){
			    	$_REQUEST['contract_id'] = $_REQUEST['id'];
		    	}
		
		        $contract = new Contract($_REQUEST['contract_id']);
		
		        if ($contract->SetHunter($hunter->GetID(), 1)) {
		            echo 'Contract Request Sent.';
		            
		            $solo->NotifyComissioner(2, $contract->GetMBID(), $hunter->GetName());
		        }
		        else {
		            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 8';
		        }
		    }
		    else {
			    if (count($solo->DeadContracts())){
			        $form = new Form($page);
			        $form->StartSelect('Contract:', 'contract_id');
			        foreach ($solo->DeadContracts() as $value) {
			            $type = $value->GetType();
			            $form->AddOption($value->GetID(), "Difficulty: ".$type->GetName()." | Contract ".$value->GetContractID());
			        }
			        $form->EndSelect();
			        $form->AddSubmitButton('submit', 'Request');
			        $form->EndForm();
		        } else {
			        echo "No Dead Contracts available.";
		        }
		    }
    	}
	} else {	    
	    echo 'You need a Character Sheet to get contracts. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();
}
?>