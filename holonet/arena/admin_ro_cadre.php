<?php

function title() {
    return 'Administration :: Run-Ons :: Add New Cadre RO';
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
    $ros = $ro->GetCadrePending();
    
    if (isset($_REQUEST['submit'])){

        $new = $ro->NewRunOn($_REQUEST['name'], parse_date_box('start'), parse_date_box('end'), $_REQUEST['mbid']);
        
        if ($new){               
            echo 'Run-on started successfully.';                
        }
        else {
            NEC(123);
        }
        
        $ro->ProcessCadreRO($_REQUEST['ro']);
	    $ro = $ros[$_REQUEST['ro']];
	    
	    $text = $person->GetName().", the Mission Master has posted your Cadre Run-On. http://boards.thebhg.org/index.php?op=view&topic=".$_REQUEST['mbid'];

        $from = "overseer@thebhg.org";
        $subject = "Cadre RO Posted!";
	    
	    $ro['person']->SendEmail($from, $subject, $text);
	    echo 'RO Posted.';
	    
    } 
    elseif ($_REQUEST['deny']) {
	    $ro->ProcessCadreRO($_REQUEST['ro']);
	    $ro = $ros[$_REQUEST['ro']];
	    
	    $text = $person->GetName().", the Mission Master has denied your Cadre Run-On.";

        $from = "overseer@thebhg.org";
        $subject = "Cadre RO Denied!";
	    
	    $ro['person']->SendEmail($from, $subject, $text);
	    echo 'RO Denied.';
	} 
    elseif ($_REQUEST['next']) {
	    $form = new Form($page);
	    
	    $ro = $ros[$_REQUEST['ro']];
	    
	    $form->AddHidden('ro', $_REQUEST['ro']);
	    
	    $form->table->AddRow('Title:', $ro['title']);
	    $form->table->AddRow('Plot:', $ro['plot']);
	    
	    $form->table->AddRow('Approve:', '<input type="submit" name="post" value="Yes, I\'m Posting">');
	    $form->table->StartRow();
	    $form->table->AddCell('<input type="submit" name="deny" value="No, Deny">', 2);
	    $form->table->EndRow();
	    
	    $form->EndForm();
	} 
    elseif ($_REQUEST['post']) {    
	    $form = new Form($page);
	    
	    $form->table->AddRow('Title:', $ro['title']);
	    $form->table->AddRow('Plot:', $ro['plot']);
	    
	    $form->AddTextBox('Message Board ID', 'mbid', '', 10);
	    
	    $form->AddTextBox('Run On Name', 'name', '', 50);
	    
	    $time = time()+(60*60*24*31);
	    
	    $form->AddDateBox('Run On Start', 'start', time());
	    $form->AddDateBox('Run On End', 'end', $time);
	
	    $form->AddSubmitButton('submit', 'Add Run On');
	    $form->EndForm();
    }
    else {
	    $form = new Form($page);
	    
	    if (count($ros)){
		    $form->StartSelect('Request:', 'ro');
		    foreach ($ros as $rosa){
			    $form->AddOption($rosa['id'], $rosa['cadre']->GetName());
		    }
		    $form->EndSelect();
	    
	    	$form->AddSubmitButton('next', 'Process');
    	} else {
	    	echo 'No pending Cadre ROs';
    	}
	    $form->EndForm();
    }

    admin_footer($auth_data);

}
?>
