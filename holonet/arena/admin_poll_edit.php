<?php

function title() {
    return 'Administration :: Arena Poll :: Edit Poll';
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
	    
	    $arenap = $_REQUEST['arenaposi'];
	    $posi = $_REQUEST['posi'];
	    $divi = $_REQUEST['divi'];
	    $open = $_REQUEST['open'];
	    
	    $poll = new Poll($_REQUEST['poll']);
	    
	    $open_to = array();
	    
	    if (count($arenap) && $_REQUEST['area']){
		    $open_to['aas'] = $arenap;
	    }
	    
	    if (count($posi) && $_REQUEST['posit']){
		    $open_to['positions'] = $posi;
	    }
	    
	    if (count($divi) && $_REQUEST['divis']){
		    $open_to['divisions'] = $divi;
	    }
	    
	    if (count($open)){
		    $open_to['aa'] = 1;
	    }
	    
	    echo $poll->Edit($_REQUEST['question'], $hunter->GetID(), $_REQUEST['rpa'], $_REQUEST['multiple'], $open_to, $_REQUEST['start'], $_REQUEST['end']);
	    $news = array();
	    $opts = $poll->GetOptions(0);
	    
	    if (count($opts) > count($_REQUEST['option'])){
		    $num = count($opts)--;
		    for ($i = count($_REQUEST['option']); $i <= $num; $i++){
			    $opts[$i]->Delete();
		    }
	    }
	    
	    foreach ($_REQUEST['option'] as $key=>$option){
			$explode = explode('_', $key);
			if ($explode[1] == 'NEW'){
				$news[] = $option;
			} else {
				$optiono = new Option($key);
				if ($optiono->IsDeleted()){
					$optiono->Undelete();
				}
				$optiono->Edit($option);
			}
	    }
	    
	    hr();
    } elseif ($_REQUEST['next']){
	    $form = new Form($page);
	    $form->AddSectionTitle('Add Options');
	    $form->AddHidden('multiple', $_REQUEST['multiple']);
	    $form->AddHidden('question', $_REQUEST['question']);
	    $form->AddHidden('start', parse_date_box('start'));
	    $form->AddHidden('end', parse_date_box('end'));
	    
	    $poll = new Poll($_REQUEST['poll']);
	    
	    $form->AddHidden('poll', $_REQUEST['poll']);
	    $options = $poll->GetOptions(0);
	    $open = $poll->GetOpen();
	    
	    $form->StartSelect('Post as', 'rpa', $poll->GetRPAKey());
	    foreach ($arena->CanBe($hunter) as $id=>$data){
		    $form->AddOption($id, $data);
	    }
	    $form->EndSelect();
	    
	    for ($i = 1; $i <= $_REQUEST['numop']; $i++){
		    $o = $i-1;
		    $opt = '';
		    $opn = $i.'_NEW';
		    if (is_object($options[$o])){
			    $opt = $options[$o]->GetQuestion();
			    $opn = $options[$o]->GetID();
		    }
		    $form->AddTextBox('Option '.$i, 'option['.$opn.']', $opt);
	    }
	    
	    if ($_REQUEST['restrict']){
		    $form->AddCheckBox('RP Aides Only', 'open[aa]', 1, $open['aa']);
		    $form->AddCheckBox('Use Arena Limiter', 'area', 1, count($open['aas']));
		    $form->StartSelect('Arena Position', 'arenaposi[]', $open['aas'], 5, true);
		    foreach ($arena->ArenaPositions() as $id=>$data){
			    $form->AddOption($id, $data['desc']);
		    }
		    $form->EndSelect();
		    
		    $form->AddCheckBox('Use Position Limiter', 'posit', 1, count($open['positions']));
		    $form->StartSelect('Position', 'posi[]', $open['positions'], 5, true);
		    foreach ($roster->GetPositions() as $data){
			    $form->AddOption($data->GetID(), $data->GetName());
		    }
		    $form->EndSelect();
		    
		    $form->AddCheckBox('Use Division Limiter', 'divis', 1, count($open['divisions']));
		    $form->StartSelect('Division', 'divi[]', $open['divisions'], 5, true);
		    foreach ($roster->GetDivisions() as $data){
			    $form->AddOption($data->GetID(), $data->GetName());
		    }
		    $form->EndSelect();
	    }
	    
	    $form->AddSubmitButton('submit', 'Submit Edits for Poll');
	    $form->EndForm();
	    $show = false;
    } elseif ($_REQUEST['initial']){
	    $form = new Form($page);
	    $form->AddSectionTitle('Create new Poll');
	    
	    $poll = new Poll($_REQUEST['poll']);
	    
	    $form->AddHidden('poll', $_REQUEST['poll']);
	    $form->AddTextBox('Question', 'question', $poll->GetQuestion());
	    $form->AddTextBox('Number of Options', 'numop', count($poll->GetOptions()), 5);
	    $form->AddCheckBox('Multiple Answers?', 'multiple', 1, $poll->GetMultiple());
	    $form->AddCheckBox('Restrict to Certain People?', 'restrict', 1, count($poll->GetOpen()));
	    $form->AddDateBox('Starts', 'start', $poll->GetStarts());
	    $form->AddDateBox('Ends', 'end', $poll->GetEnds());
	    $form->AddSubmitButton('next', 'Edit Options');
	    
	    $form->EndForm();
	    $show = false;
    }
    
    if ($show){
	    if (count($arena->GetPolls())){
	    	$form = new Form($page);
	    	$form->StartSelect('Poll Question ', 'poll');
	    	foreach ($arena->GetPolls() as $poll){
		    	$form->AddOption($poll->GetID(), $poll->GetQuestion());
	    	}
	    	$form->EndSelect();
	    	$form->AddSubmitButton('initial', 'Edit This Poll');
	    	$form->EndForm();
    	} else {
	    	echo 'No polls available.';
    	}
	}
    
    admin_footer($auth_data);
}
?>