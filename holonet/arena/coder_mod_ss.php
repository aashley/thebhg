<?php

function title() {
    return 'Administration :: Coder Utilities :: Modify Modification Sheet Stats';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['coder'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;

    arena_header();
    
    if (isset($_REQUEST['submit'])){
	    
	    foreach ($_REQUEST['stats'] as $id){
		    if (isset($_REQUEST['stat'][$id])){
			    $yes = 1;
		    } else {
			    $yes = 0;
		    }
		    $sheet->SetSheetMod($_REQUEST['mod'], 1, $id, $yes);
	    }
	    
	    foreach ($_REQUEST['skills'] as $id){
		    if (isset($_REQUEST['skill'][$id])){
			    $yes = 1;
		    } else {
			    $yes = 0;
		    }
		    $sheet->SetSheetMod($_REQUEST['mod'], 2, $id, $yes);
	    }
		
		echo 'System updated.';
    } elseif ($_REQUEST['next']) {
	    $form = new Form($page);
	    $form->AddSectionTitle('Character Sheet Modifications');
	    
	    $form->AddHidden('mod', $_REQUEST['mod']);
	    $form->table->AddRow('Stat/Skill', 'Include?');
	    
	    $mod = $sheet->BuildModEdit($_REQUEST['mod']);
	    $fields = array_flip($mod['fields']);
	    
	    foreach ($fields as $field=>$s){
		    foreach ($sheet->GetStats($field) as $stat){
			    $form->AddCheckBox($stat->GetName(), 'stat['.$stat->GetID().']', 1, $fields[$field->GetID()]);
			    $form->AddHidden('stats[]', $stat->GetID());
		    }
		    foreach ($sheet->GetSkills($field) as $skill){
			    $form->AddCheckBox($skill->GetName(), 'skill['.$skill->GetID().']', 1, $fields[$field->GetID()]);
			    $form->AddHidden('skills[]', $skill->GetID());
		    }
	    }
	    $form->AddSubmitButton('submit', 'Submit Modification Skill/Stats');
	    
	    $form->EndForm();
    } else {
	    $form = new Form($page);
	    $form->AddSectionTitle('Character Sheet Modifications');
	    
	    if (count($sheet->AllMods())){
		    $form->StartSelect('Modification Name:', 'mod');
		    foreach ($sheet->AllMods() as $mod){
			    $form->AddOption($mod['id'], $mod['name']);
		    }
		    $form->EndSelect();
		    $form->AddSubmitButton('next', 'Set Modification Skill/Stats');
	    }	    
	    
	    $form->EndForm();
    }
    
    admin_footer($auth_data);
}
?>