<?php
function title() {
    return 'Administration :: Solo Mission :: Commissioner of the Bounty Office';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $solo = new Solo();
    
    if (isset($_REQUEST['submit'])) {
		if ($solo->NewComissioner($_REQUEST['bhg_id'])) {
            echo 'New Comimssioner Declared.';
        }
        else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 57';
        }
    } elseif (isset($_REQUEST['end'])){
		$commie = new Comissioner($solo->CurrentComissioner());
		
		if ($commie->EndTerm()){
			echo 'Term Ended.';
		} else {
			echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 121';
        }
    }
    else {
        $form = new Form($page);
        $form->AddSectionTitle('Declare New Commissioner');
        $form->StartSelect('Hunter:', 'bhg_id');
        hunter_dropdown($form);
        $form->EndSelect();
        $form->AddSubmitButton('submit', 'Make New Commissioner');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->AddSectionTitle('Downsize Current Commissioner');
        $form->table->StartRow();
        $form->table->AddCell('<input type="submit" name="end" value="End Term">');
        $form->table->EndRow();
        $form->EndForm(); 
    }

    admin_footer($auth_data);
}
?>