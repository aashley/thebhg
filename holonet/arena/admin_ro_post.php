<?php
function title() {
    return 'Administration :: Run-Ons :: Run-On Poster';
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

    if (isset($_REQUEST['next'])) {

        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Enter Message Board ID', 2);
        $form->table->EndRow();
        $form->AddTextBox('Topic Number:', 'mbid');
        $form->AddHidden('id', $_REQUEST['id']);
        $form->AddSubmitButton('submit', 'Complete Process');
        $form->EndForm();

    }
    elseif (isset($_REQUEST['submit'])) {

	    $run_on = new RunOn($_REQUEST['id']);
	    
        if ($run_on->Post($_REQUEST['mbid'])){
            echo "Run-On posting process completed.";
        } else {

            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 124';
        }

    }
    else {
	    if (count($ro->Unposted())){
	        $form = new Form($page);
	        $form->StartSelect('Run-On:', 'id');
	        foreach ($ro->Unposted() as $value) {
	            $form->AddOption($value->GetID(), $value->GetName());
	        }
	        $form->EndSelect();
	        $form->AddSubmitButton('next', 'Next >>');
	        $form->EndForm();
        } else {	        
	        echo "No Pending Run-Ons.";	        
        }
    }

    admin_footer($auth_data);
}
?>