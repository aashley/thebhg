<?php

function title() {
    return 'Administration :: Run-Ons :: Add New Match';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['ro'];
}

function output() {
    global $arena, $hunter, $roster, $page, $auth_data;

    arena_header();

    $ro = new RO();
    
    if (isset($_REQUEST['submit'])){

        $new = $ro->NewRunOn($_REQUEST['name'], parse_date_box('start'), parse_date_box('end'), $_REQUEST['mbid']);
        
        if ($new){               
            echo 'Run-on started successfully.';                
        }
        else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 123';
        }
	    
    } 
    else {
	    $form = new Form($page);
	    
	    $form->AddTextBox('Message Board ID', 'mbid', '', 10);
	    
	    $form->AddTextBox('Run On Name', 'name', '', 50);
	    
	    $form->AddDateBox('Run On Start', 'start');
	    $form->AddDateBox('Run On End', 'end');
	
	    $form->AddSubmitButton('submit', 'Add Run On');
	    $form->EndForm();
    }

    admin_footer($auth_data);

}
?>
