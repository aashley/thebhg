<?php
function title() {
    return 'Administration :: Run-Ons :: Run-On Editor';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['ro'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $ro = new RO();
    
    if (isset($_REQUEST['submit'])){
	    $run_on = new RunOn($_REQUEST['id']);
	    
        echo $run_on->Edit($_REQUEST['name'], $_REQUEST['mbid']);	    
    }
    elseif (isset($_REQUEST['delete'])){
	    $run_on = new RunOn($_REQUEST['id']);
	    
	    if ($run_on->GetDeleted()){
		    $ro = $run_on->Undelete();	
		    if ($ro){
			    echo 'Run On Undeleted';
		    } else {
			    echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 126';
		    }  	    
	    } else {
		    $ro = $run_on->Delete();
		    if ($ro){
			    echo 'Run On Deleted';
		    } else {
			    echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 127';
		    } 
	    }
	      
    } 
    elseif ($_REQUEST['next']) {
	    
	    $run = new RunOn($_REQUEST['id']);
	    
	    $form = new Form($page);
	    
	    $form->AddHidden('id', $_REQUEST['id']);
	    
	    $form->AddTextBox('Message Board ID', 'mbid', $run->GetMatchID(), 10);
	    
	    $form->AddTextBox('Run On Name', 'name', $run->GetName(), 50);
	
	    $form->AddSubmitButton('submit', 'Edit Run On');
	    $form->EndForm();
	    
	    $form = new Form($page);
	    
	    $form->AddHidden('id', $_REQUEST['id']);
	
	    if ($run->GetDeleted()){
		    $del = 'Und';
	    } else {
		    $del = 'D';
	    }
	    
	    $form->AddSubmitButton('delete', $del.'elete Run On');
	    $form->EndForm();
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Run On:', 'id');
        foreach ($ro->AllROs() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('next', 'Next >>');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>