<?php

function title() {
	global $hunter, $arena;
	
    return 'AMS Challenge Network :: Cadre Run-Ons :: Request Cadre RO';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return $auth_data['cadre'];
}

function output() {
    global $arena, $hunter, $roster, $page, $auth_data, $citadel;

    arena_header();

    $ladder = new Ladder();
    $sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){
	
	    $cadre = $hunter->GetCadre();
	    
	    if ($_REQUEST['submit']){
		    $ro = new RO();
		    if ($ro->RequestCadreRO($cadre, $cadre->GetName().': '.$_REQUEST['title'], $_REQUEST['plot'])){
			    echo 'Cadre RO requested.';
		    } else {
			    echo 'Error';
		    }
	    } else {
		    if ($cadre){
			    if ($hunter->IsCadreLeader($cadre)){
				    if ($ro->CanRequest($cadre->GetID())){
				    	$form = new Form($page);
				    	$form->AddTextBox('Title: ', 'title');
				    	$form->AddTextArea('Plot/Opening Post:', 'plot');
				    	$form->AddSubmitButton('submit', 'Submit Request');
				    	$form->EndForm();
			    	} else {
				    	echo 'You cannot request a Cadre RO right now.';
			    	}
			    } else {
				    echo 'You need to be the Cadre Leader to request a Cadre RO.';
			    }
		    } else {
		    	echo 'Your not even in a Cadre. Go away.';
	    	}
    	}
    } else {	    
	    echo 'You need a Character Sheet to request a Cadre RO. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();

}
?>
