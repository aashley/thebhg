<?php

function title() {
    return 'AMS Challenge Network :: Survival Mission :: Request Mission';
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

    $solo = new Survival();
    $control = new SurvivalControl();

    arena_header();

    $sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){
    
	    $hunter = new SurvivalHunter($hunter->GetID());
	    $dco = $hunter->DCOPenalty();
	    
	    if ($dco){
		    $date = getdate($dco);
	    	echo '<br />You are currently under the Failed Mission penalty. You cannot request missions until this ban expires.<br />'
	    		.'This ban will end on: '.$date['month']." ".$date['mday'].", ".$date['year'];
    	} else {
		    if ($solo->PendingContract($hunter->GetID())){
		
		        echo "You have a mission pending already. You can not request another contract until your current mission is completed or retired.<br /><br />~Challenge Network.";
		
		    }
		    else {
		
		        if (isset($_REQUEST['submit'])) {
		            if ($control->NewContract($hunter->GetID(), $_REQUEST['type'])) {
		                echo 'Mission Requested.';
		            }
		            else {
		                NEC(193);
		            }
		        }
		        else {
		            $form = new Form($page);
		            $form->StartSelect('Type of Mission:', 'type');
		            foreach ($solo->Types() as $value) {
		                $form->AddOption($value->GetID(), $value->GetName());
		            }
		            $form->EndSelect();
		            $form->AddSubmitButton('submit', 'Request Mission');
		            $form->EndForm();
		        }
		    }
	    }
	    
	} else {	    
	    echo 'You need a Character Sheet to challenge anyone. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();
}
?>