<?php
function title() {
    return 'Administration :: Tempestuous Group :: Submit Required Works';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['tempy_sub'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $fiction;
    
    arena_header();

    $tempy = new Tempy();
    
    $petition = $tempy->RequiredWorks($hunter->GetID());
	
    if (isset($_REQUEST['submit'])) {
        
	    if (isset($_REQUEST['arena_1'])){
		    $arna1 = $_REQUEST['arena_1'];
	    } else {
		    $arna1 = $_REQUEST['arena1'];
	    }
		   
	    if (isset($_REQUEST['arena_2'])){
		    $arna2 = $_REQUEST['arena_2'];
	    } else {
		    $arna2 = $_REQUEST['arena2'];
	    } 
	    
	    if ($petition->SetWorks($_REQUEST['fic1'], $_REQUEST['fic2'], $_REQUEST['fic3'], $arna1, $arna2, $_REQUEST['runon'])){
		    echo "The works you submitted have been added.";
		    
		    $petition = new Petition($_REQUEST['id']);
		    
		    if ($petition->AllWorks()){
			    echo "<br /><br />You have submitted all the required works. An eMail has been sent to your jury notifying them they may begin the "
			    	."review process. Good luck.";
		    }
		    
	    } else {
		    NEC(37);
	    }
	    
    } 
    else {
	    
	    if ($petition->GetID()){
			    
		    echo 'Guide for submitting<br />'
		    		
		    	.'<br /><b>Fiction</b><br />'
		    	.'Fiction submissions is driven by the Fiction Archive. (<a href="http://fiction.thebhg.org">http://fiction.thebhg.org</a>) Please go '
		    	.'there and submit the fictions you intend to use for your submissions. Then, from the dropdown lists, select the fictions.'
		    	.'<br /><br /><b>Arena Matches & Run-On</b><br />'
		    	.'Simply enter the <b>Topic ID</b> (from the Message Boards) of the match into the text box.';
		    	
		    hr();
		    
		    $works = $arena->FictionByPerson($hunter->GetID());
		    $arna = new Stats($hunter->GetID());
		    $arena_works = $arna->ReadMatches();
		    
	        $form = new Form($page);
	        
	        $form->table->StartRow();
	        $form->table->AddHeader('Your Required Works', 2);
	        $form->table->EndRow();
	        
	        for ($i = 1; $i <= 3; $i++) {
		        $form->StartSelect("Fiction $i&nbsp;", 'fic'.$i, $petition->GetFiction($i, 1));
		        $form->AddOption(0, '');
		        foreach ($works as $value){
			        $form->AddOption($value->GetID(), $value->GetTitle());
		        }
		        $form->EndSelect();
	        }
	        
	        $form->AddHidden('id', $petition->GetID());
	        
	        for ($i = 1; $i <= 2; $i++) {
		        if (count($arena_works)){
			        $form->StartSelect("Arena $i&nbsp;", 'arena'.$i, $petition->GetArena($i, 1));
			        $form->AddOption(0, '');
			        foreach ($arena_works as $value){
				        $form->AddOption($value->GetID(), $value->GetName());
			        }
			        $form->EndSelect();
		        }
				$form->AddTextBox("Arena $i ID&nbsp", 'arena_'.$i, $petition->GetArena($i, 1), 5);
	        }
	        
	        $form->AddTextBox("Run-On ID&nbsp", 'runon', $petition->GetRO(1), 5);
	        
	        $form->AddSubmitButton('submit', 'Submit');
	        $form->EndForm();
        
        } else {
	        
	        echo "Not a valid petition.";
	        
        }
        
    }

    admin_footer($auth_data);
}
?>