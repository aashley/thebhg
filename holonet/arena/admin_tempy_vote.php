<?php
function title() {
    return 'Administration :: Tempestuous Group :: Review and Vote';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['tempy_mod'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $tempy = new Tempy();
    
    $pending = $tempy->RequiredVotes($hunter->GetID());

	if (isset($_REQUEST['id'])){
		$petition = new Petition($_REQUEST['id']);
	}
	
	if (isset($_REQUEST['work'])) {
        
		if ($petition->CanVote($petition->JurorID($hunter->GetID()))){

	        if ($petition->Vote($petition->JurorID($hunter->GetID()), $_REQUEST['approve'], $_REQUEST['comments'])){
		        echo "Vote cast successfully.";
	        } else {
		        NEC(36);
	        }
	        
        } else {
	        
	        echo "You have already voted on this application.";
	        
        }
        
    } 
    elseif (isset($_REQUEST['view'])) {    
	    
	    echo "Works Submitted <br /><br />";
	    
	    echo "<b>Fiction</b><br />";
	    
	    for ($i = 1; $i <= 3; $i++) {
	    	echo $i.'. <a target="_fiction" href="'.$petition->GetFiction($i).'">'.$petition->GetFiction($i).'</a><br />';
    	}
    	
    	echo "<br /><br />";
	    
	    echo "<b>Arena</b><br />";
	    
	    for ($i = 1; $i <= 2; $i++) {
	    	echo $i.'. <a target="_arena" href="'.$petition->GetArena($i).'">'.$petition->GetArena($i).'</a><br />';
    	}
    	
    	echo "<br /><br />";
	    
	    echo "<b>Runon</b><br />";
	    echo '1. <a target="_runon" href="'.$petition->GetRO().'">'.$petition->GetRO().'</a>';
		    
	    hr();
	    
	    $form = new Form($page);
			        
        $form->table->StartRow();
        $form->table->AddHeader('Vote on Applicant', 2);
        $form->table->EndRow();
        
        $form->AddRadioButton('Vote For Admission', 'approve', 1);
        $form->AddRadioButton('Vote Against Admission', 'approve', 0);
        $form->AddHidden('work', 1);
        $form->AddHidden('id', $_REQUEST['id']);
        $form->AddTextArea('Comments', 'comments');
        
        $form->AddSubmitButton('submit', 'Process Petition');
        $form->EndForm();
	       
    }
    else {
	    
	    if (count($pending)){
			    
	        $form = new Form($page);
	        
	        $form->table->StartRow();
	        $form->table->AddHeader('Applications', 2);
	        $form->table->EndRow();
	        
	        $form->StartSelect('Applicant:', 'id');
	        foreach ($pending as $value) {
		        $person = $value->GetApplicant();
		        if ($value->CanVote($value->JurorID($hunter->GetID()))){
	            	$form->AddOption($value->GetID(), $person->GetName());
            	}
	        }
	        $form->EndSelect();
	        $form->AddSubmitButton('view', 'View Works');
	        $form->EndForm();
        
        } else {
	        
	        echo "No pending petitions.";
	        
        }
        
    }

    admin_footer($auth_data);
}
?>