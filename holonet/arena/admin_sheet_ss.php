<?php

function title() {
    return 'Administration :: Character Sheet :: Modify Modification Sheet Stats';
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
	    
	    foreach ($_REQUEST['stats'] as $id){
		    if (isset($_REQUEST['stat'][$id])){
			    $yes = $_REQUEST['stat'][$id];
		    } else {
			    $yes = 0;
		    }
		    $sheet->SetSheetMod($_REQUEST['mod'], 1, $id, $yes);
	    }
	    
	    foreach ($_REQUEST['skills'] as $id){
		    if (isset($_REQUEST['skill'][$id])){
			    $yes = $_REQUEST['skill'][$id];
		    } else {
			    $yes = 0;
		    }
		    $sheet->SetSheetMod($_REQUEST['mod'], 2, $id, $yes);
	    }
		
		echo 'System updated.';
    } else {
	    $form = new Form($page);
	    $form->AddSectionTitle('Character Sheet Modifications');
	    
	    $form->AddHidden('mod', 1);
	    $form->table->AddRow('Stat/Skill', 'Include?');
	    
	    $fields = array_flip($sheet->ModFields(1));
	    
	    foreach ($fields as $field=>$s){
		    foreach ($sheet->GetStats($field) as $stat){
			    $form->AddCheckBox($stat->GetName(), 'stat['.$stat->GetID().']', 1, $sheet->Permit(1, $stat->GetID(), $_REQUEST['mod']));
			    $form->AddHidden('stats[]', $stat->GetID());
		    }
		    foreach ($sheet->GetSkills($field) as $skill){
			    $form->AddCheckBox($skill->GetName(), 'skill['.$skill->GetID().']', 1, $sheet->Permit(2, $skill->GetID(), $_REQUEST['mod']));
			    $form->AddHidden('skills[]', $skill->GetID());
		    }
	    }
	    $form->AddSubmitButton('submit', 'Submit Modification Skill/Stats');
	    
	    $form->EndForm();
    }
    
    admin_footer($auth_data);
}
?>