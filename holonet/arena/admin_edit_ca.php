<?php

function title() {
    return 'Administration :: Character Sheet :: Add Character Attribute';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['sheet'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;

    arena_header();
    
    if (isset($_REQUEST['submit'])){
	    if ($_REQUEST['skill'] && $_REQUEST['stat']){
			echo 'Please don\'t be retarded. I told you, pick one or the other, either skill or stat.';
		} else {
			if ($_REQUEST['delete']){
			    $sheet->DeleteCA($id);
			    echo 'Character Attribute Deleted';
		    } else {
			    if ($sheet->EditCA($_REQUEST['ca'], $_REQUEST['name'], $_REQUEST['desc'])){
			    	echo 'Character Attribute Edited Successfully!';
			    } else {
				    NEC(217);
			    }
				foreach ($_REQUEST['stats'] as $id){
					if ($_REQUEST['del'][$id]){
						$sheet->DeleteCAValue($id);
					} else {
						if ($_REQUEST['skill'][$id]){
							$skill = 1;
							$field = $_REQUEST['skill'][$id];
						} else {
							$skill = 0;
							$field = $_REQUEST['stat'][$id];
						}
					    $sheet->EditCAValue($_REQUEST['ca'], $skill, $field, $_REQUEST['mod'][$id]);
				    }
			    }
			}
	    }
    } elseif ($_REQUEST['next']){
	    $ca = $sheet->GetCA($_REQUEST['ca']);
	    $form = new Form($page);
	    $form->table->StartRow();
	    $form->table->AddCell('Note, make sure either the stat or skill is set to 0, as if both are set to a value, it will kick you back', 2);
	    $form->table->EndRow();
	    $form->AddSectionTitle('Edit Character Sheet Character Attribute');
	    $form->AddHidden('ca', $ca['id']);
	    $form->AddTextBox('Name', 'name', $ca['name']);
	    $form->AddTextArea('Description', 'desc', $ca['desc']);
	    $form->AddCheckBox('Delete', 'delete', 1);
	    
	    $values = $sheet->GetCAValues($ca['id']);
	    foreach ($values as $id=>$value){
		    $skval = 0;
		    $stval = 0;
	    	if ($ca['skill']){
		    	$skval = $ca['field'];
	    	} else {
		    	$stval = $ca['field'];
	    	}
		    $form->StartSelect('Skill', 'skill['.$id.']', $skval);
		    $form->AddOption(0, '');
		    foreach ($sheet->GetSkills() as $value){
			    if ($sheet->Permit(2, $value->GetID(), 1)){
			    	$form->AddOption($value->GetID(), $value->GetName());
		    	}
		    }
		    
		    $form->EndSelect();
		    
		    $form->StartSelect('Statribute', 'stat['.$id.']', $stval);
		    $form->AddOption(0, '');
		    foreach ($sheet->GetStats() as $value){
			    if ($sheet->Permit(1, $value->GetID(), 1)){
			    	$form->AddOption($value->GetID(), $value->GetName());
		    	}
		    }
		    $form->AddTextBox('Modifier', 'mod['.$id.']', $ca['mod'], 5);
		    $form->AddCheckBox('Delete', 'del['.$id.']', 1);
		    $form->AddHidden('stats[]', $id);
	    }
	    
	    $form->AddSubmitButton('submit', 'Edit Attribute');
	    
	    $form->EndForm();
    } else {
	    $form = new Form($page);
	    $form->StartSelect('Attribute', 'ca', $_REQUEST['ca']);
	    foreach ($sheet->GetCAs() as $id=>$value){
			$form->AddOption($id, $value['name']);
	    }
	    $form->EndSelect();
	    $form->AddSubmitButton('next', 'Edit Attribute');
	    
	    $form->EndForm();
    }
    
    admin_footer($auth_data);
}
?>