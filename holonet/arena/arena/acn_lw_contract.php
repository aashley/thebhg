<?php

function title() {
    return 'AMS Challenge Network :: Lone Wolf Mission :: Request Contract';
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

    $solo = new LW_Solo();
    $control = new LW_SoloControl();

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
		    	
			    if ($solo->PendingContract($hunter->GetID())){
			
			        echo "You have a contract pending already. You can not request another contract until your current contract is completed or retired.<br /><br />~Challenge Network.";
			
			    }
			    else {
				    
			        if (isset($_REQUEST['submit'])) {
			            if ($control->NewContract($hunter->GetID())) {
			                echo 'Contract Requested.';
			            }
			            else {
			                NEC(5);
			            }
			        }
			        else {
			            $form = new Form($page);
			            $form->StartSelect('Type of Contract:', 'type');
			            $form->AddOption(1, 'Lone Wolf');
			            $form->EndSelect();
			            $form->AddSubmitButton('submit', 'Request Contract');
			            $form->EndForm();
			        }
			    }  
		    }
	    } else {
		    echo 'Only Lone Wolves may use this function.';
	    }

	} else {	    
	    echo 'You need a Character Sheet to challenge anyone. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }
	    
    arena_footer();
}
?>