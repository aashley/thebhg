<?php

function title() {
    return 'AMS Challenge Network :: Lone Wolf Mission :: Retire Contract';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data;
}

function output() {
    global $arena, $roster, $hunter, $page, $auth_data;

    arena_header();

    $sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){
	    
	    if ($auth_data['lw']){
	    
		    $solo = new LW_Solo();
		
		    $hunter = new LW_Hunter($hunter->GetID());    
	    
	    if (isset($_REQUEST['submit'])) {
	
	        $contract = new LW_Contract($_REQUEST['contract_id']);
	
	        if ($contract->Retire(0)) {
	            echo 'Contract Retired.';
	            
	            $solo->NotifyComissioner(3, $contract->GetMBID(), $hunter->GetName());
	        }
	        else {
	            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 8';
	        }
	    }
	    else {
		    if (count($hunter->Contracts())){
		        $form = new Form($page);
		        $form->StartSelect('Contract:', 'contract_id', $_REQUEST['contract']);
		        foreach ($hunter->Contracts() as $value) {
		            $type = $value->GetType();
		            $form->AddOption($value->GetID(), "Difficulty: ".$type->GetName()." | Contract ".$value->GetContractID());
		        }
		        $form->EndSelect();
		        $form->AddSubmitButton('submit', 'Retire');
		        $form->EndForm();
	        } else {
		        echo "You have no pending contracts.";
	        }
	    }
		} else {
		    echo 'Only Lone Wolves may use this function.';
	    }
    
    } else {	    
	    echo 'You need a Character Sheet to get contracts. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }
	      
    arena_footer();
}
?>