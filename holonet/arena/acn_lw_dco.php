<?php

function title() {
    return 'AMS Challenge Network :: Lone Wolf Mission :: Request Dead Contract';
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
	    
		    $hunter = new LW_Hunter($hunter->GetID());
		    $dco = $hunter->DCOPenalty();
	    
		    if ($dco){
			    $date = getdate($dco);
		    	echo '<br />You are currently under the Dead Contract penalty. You cannot request contracts until this ban expires.<br />'
		    		.'This ban will end on: '.$date['month']." ".$date['mday'].", ".$date['year'];
	    	} else {
		    	
			    $solo = new LW_Solo();
			
			    if (isset($_REQUEST['submit'])) {
			
			        $contract = new LW_Contract($_REQUEST['contract_id']);
			
			        if ($contract->SetHunter($hunter->GetID(), 1)) {
			            echo 'Contract Request Sent.';
		    
			            $solo->NotifyComissioner(2, $contract->GetMBID(), $hunter->GetName());
			        }
			        else {
			            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 6';
			        }
			    }
			    else {
				    if (count($solo->DeadContracts())){
				        $form = new Form($page);
				        $form->StartSelect('Contract:', 'contract_id');
				        foreach ($solo->DeadContracts() as $value) {
				            $form->AddOption($value->GetID(), "Contract ".$value->GetContractID());
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
		    echo 'Only Lone Wolves may use this function.';
	    }
    
    } else {	    
	    echo 'You need a Character Sheet to get contracts. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }
	      
    arena_footer();
}
?>