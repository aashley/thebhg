<?php
function title() {
    return 'Administration :: XOC Interface :: Character Sheets :: Test';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return true;
}

function output() {
    global $arena, $auth_data, $hunter, $page, $sheet, $roster;

    arena_header();

    if ($_REQUEST['submit']){
    	
	    foreach ($_REQUEST['nameused'] as $name){
		    
		    $split = explode('_', $_REQUEST[$name]);
			$value = $split[1];
		    
			print_r($split);
			
			if ($split == 'skill'){
				$retrn = new Skill($value);
				echo 'Skill';
			} else {
				$retrn = new Statribute($value);
				echo 'Stat';
			}
		    
		    if ($sheet->HasValue($hunter->GetID(), $_REQUEST[$name], $_REQUEST['txt_'.$name])){			    
			    echo 'You have at least a  '.$_REQUEST['txt_'.$name].' in '.$retrn->GetName().'.';
		    } else {
			    echo 'You do not have at least a '.$_REQUEST['txt_'.$name].' in '.$retrn->GetName().'.';
		    }
		    echo '<br />';
	    }
	    
	} elseif ($_REQUEST['next']){
	    $form = new Form($page);
	    
	    for ($i = 1; $i <= $_REQUEST['fields']; $i++){
		    $sheet->DropdownFields($form, 'field'.$i);
	    }
	    
	    $form->AddSubmitButton('submit', 'Make final checks.');
	    $form->EndForm();
    } else {
	    $form = new Form($page);
	    $form->AddTextBox('Number of Fields:', 'fields');
	    $form->AddSubmitButton('next', 'Choose fields.');
	    $form->EndForm();
    }

    admin_footer($auth_data);
}
?>