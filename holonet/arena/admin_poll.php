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
	    if ($arena->NewPoll($_REQUEST['name'], $_REQUEST['desc'])){
		    echo 'New Poll Added Successfully!';
	    } else {
		    NEC(152);
	    }
	    
	    hr();
    } elseif ($_REQUEST['next']){
	    $form = new Form($page);
	    $form->AddSectionTitle('Add Options');
	    $form->AddHidden('multiple', $_REQUEST['multiple']);
	    $form->AddHidden('restrict', $_REQUEST['restrict']);
	    $form->AddHidden('start', $_REQUEST['start']);
	    $form->AddHidden('end', $_REQUEST['end']);
	    
	    for ($i = 1; $i <= $_REQUEST['numop']; $i++){
		    $form->AddTextBox('Option '.$i, 'option[]');
	    }
	    
	    if ($_REQUEST['restrict']){
		    $form->AddCheckBox('RP Aides Only', 'open[aa]', 1);
		    $form->AddCheckBox('Use Aide Limiter?' 'aidelimit', 1);
		    $form->StartSelect('Arena Position', 'arenaposi', true);
		    foreach ($arena->ArenaPositions() as $id=>$data){
			    $form->AddOption($id, $data['desc']);
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