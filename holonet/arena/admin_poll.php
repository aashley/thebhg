<?php

function title() {
    return 'Administration :: Arena Poll :: New Poll';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['aa'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet, $arena;

    arena_header();
    
    $show = true;
    
    if (isset($_REQUEST['submit'])){
	    
	    $arena = $_REQUEST['arenaposi'];
	    $posi = $_REQUEST['posi'];
	    $divi = $_REQUEST['divi'];
	    $open = $_REQUEST['open'];
	    
	    $open_to = array();
	    
	    if (count($arena)){
		    $open_to['aas'] = $arena;
	    }
	    
	    if (count($posi)){
		    $open_to['positions'] = $posi;
	    }
	    
	    if (count($divi)){
		    $open_to['divisions'] = $divi;
	    }
	    
	    if (count($open)){
		    $open_to['aa'] = 1;
	    }
	    
	    if ($arena->NewPoll($hunter->GetID(), $_REQUEST['rpa'], $_REQUEST['question'], $_REQUEST['multiple'], $open_to, parse_date_box('start'), parse_date_box('end'))){
		    echo 'New poll added successfully';
	    } else {
		    NEC(208);
	    }
	    
	    hr();
    } elseif ($_REQUEST['next']){
	    $form = new Form($page);
	    $form->AddSectionTitle('Add Options');
	    $form->AddHidden('multiple', $_REQUEST['multiple']);
	    $form->AddHidden('question', $_REQUEST['question']);
	    $form->AddHidden('start', $_REQUEST['start']);
	    $form->AddHidden('end', $_REQUEST['end']);
	    
	    $form->StartSelect('Post as', 'rpa');
	    foreach ($arena->CanBe($hunter) as $id=>$data){
		    $form->AddOption($id, $data['desc']);
	    }
	    $form->EndSelect();
	    
	    for ($i = 1; $i <= $_REQUEST['numop']; $i++){
		    $form->AddTextBox('Option '.$i, 'option[]');
	    }
	    
	    if ($_REQUEST['restrict']){
		    $form->AddCheckBox('RP Aides Only', 'open[aa]', 1);
		    $form->StartSelect('Arena Position', 'arenaposi[]', '', 5, true);
		    foreach ($arena->ArenaPositions() as $id=>$data){
			    $form->AddOption($id, $data['desc']);
		    }
		    $form->EndSelect();
		    
		    $form->StartSelect('Position', 'posi[]', '', 5, true);
		    foreach ($roster->GetPositions() as $data){
			    $form->AddOption($data->GetID(), $data->GetName());
		    }
		    $form->EndSelect();
		    
		    $form->StartSelect('Division', 'divi[]', '', 5, true);
		    foreach ($roster->GetDivisions() as $data){
			    $form->AddOption($data->GetID(), $data->GetName());
		    }
		    $form->EndSelect();
	    }
	    
	    $form->AddSubmitButton('submit', 'Add Poll');
	    $form->EndForm();
	    $show = false;
    }
    
    if ($show){
	    $form = new Form($page);
	    $form->AddSectionTitle('Create new Poll');
	    
	    $form->AddTextBox('Question', 'question');
	    $form->AddTextBox('Number of Options', 'numop', 3, 5);
	    $form->AddCheckBox('Multiple Answers?', 'multiple', 1);
	    $form->AddCheckBox('Restrict to Certain People?', 'restrict', 1);
	    $form->AddDateBox('Starts', 'start');
	    $form->AddDateBox('Ends', 'end');
	    $form->AddSubmitButton('next', 'Add Options');
	    
	    $form->EndForm();
    }
    
    admin_footer($auth_data);
}
?>