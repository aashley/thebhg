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
			
			if ($split[0] == 'skill'){
				$retrn = new Skill($value);
			} else {
				$retrn = new Statribute($value);
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
    
    hr();
    
    echo 'How to code this in:<br >';
    
?>

You'll need the CS fields included. If FC ever adds them to the Roster doc, then it'll be kinky and run off that. If not, I can make an include for you
to them from here.<pre>

if ($_REQUEST['submit']){
    	
	    foreach ($_REQUEST['nameused'] as $name){
		    
		    $split = explode('_', $_REQUEST[$name]);
			$value = $split[1];
			
			if ($split[0] == 'skill'){
				$retrn = new Skill($value);
			} else {
				$retrn = new Statribute($value);
			}
		    
		    if ($sheet->HasValue($hunter->GetID(), $_REQUEST[$name], $_REQUEST['txt_'.$name])){			    
			    echo 'You have at least a  '.$_REQUEST['txt_'.$name].' in '.$retrn->GetName().'.';
		    } else {
			    echo 'You do not have at least a '.$_REQUEST['txt_'.$name].' in '.$retrn->GetName().'.';
		    }
		    echo '&lt;br />';
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
</pre>
<?php

    admin_footer($auth_data);
}
?>