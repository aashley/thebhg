<?php

function display(){
	global $activity, $arena, $type, $roster, $page;
	
	if (isset($_REQUEST['next'])) {		
		$form = new Form($page);
		$form->AddHidden('name', $_REQUEST['name']);
		$form->AddSectionTitle('Stats for '.stripslashes($_REQUEST['name']));
		$form->table->AddRow('Stat Name', 'Stat Value');
		$form->table->StartRow();
		$form->table->AddHeader('[EXAMPLE] Barbed Tail: Melee');
		$form->table->AddHeader('6');
		$form->table->EndRow();
		for ($i = 1; $i <= $_REQUEST['stats']; $i++){
			$form->table->AddRow('<input type="text" name="names['.$i.']">', '<input type="text" name="stat['.$i.']">');
		}
		$form->AddTextArea('Description', 'string');
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddHidden('op', $_REQUEST['op']);
		$form->AddSubmitButton('submit', 'Save Creature');
		$form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
	    
	    $stats = array();
	    
	    $stats['name'] = $_REQUEST['name'];
	    
	    foreach ($_REQUEST['names'] as $key=>$name){
		    if ($name){
			    if ($_REQUEST['stat'][$key]){
		    		$stats[$name] = $_REQUEST['stat'][$key];
	    		}
    		}
	    }
	    
		if (!$arena->NewCreature($stats, $_REQUEST['string'])){
			echo 'Error';
		} else {
			echo 'Creature Created.';
		}
    }
    else {
	    $form = new Form($page);
	    $form->AddSectionTitle('Make New Creature');
	    $form->AddTextBox('Creature Name:', 'name');
	    $form->AddTextBox('Number of Stats', 'stats', '', 5);
	    $form->AddHidden('id', $_REQUEST['id']);
		$form->AddHidden('op', $_REQUEST['op']);
	    $form->AddSubmitButton('next', 'Enter Creature Stats');
	    $form->EndForm();
    }
}

?>