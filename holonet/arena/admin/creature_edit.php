<?php

function display(){
	global $activity, $arena, $type, $roster, $page;
	
	if (isset($_REQUEST['next'])) {		
		
		$npc = new Creature($_REQUEST['creature']);
		
		$form = new Form($page);
		$form->AddHidden('creature', $_REQUEST['creature']);
		$form->AddSectionTitle('Stats for Creature');
		$form->AddTextBox('Name', 'name', $npc->GetName());
		$form->table->AddRow('Stat Name', 'Stat Value');
		$form->table->StartRow();
		$form->table->AddHeader('[EXAMPLE] Barbed Tail: Melee');
		$form->table->AddHeader('6');
		$form->table->EndRow();
		foreach ($npc->npc_stats as $name=>$value){
			$form->table->AddRow('<input type="text" name="names['.$i.']" value="'.$name.'">', '<input type="text" name="stat['.$i.']" value="'.$value.'">');
		}
		$form->AddTextArea('Description', 'string', $npc->npc_string);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddHidden('op', $_REQUEST['op']);
		$form->AddSubmitButton('submit', 'Save Creature');
		$form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
	    
	    $npc = new Creature($_REQUEST['creature']);
	    
	    $stats = array();
	    
	    $stats['name'] = $_REQUEST['name'];
	    
	    foreach ($_REQUEST['names'] as $key=>$name){
		    if ($name){
			    if ($_REQUEST['stat'][$key]){
		    		$stats[$name] = $_REQUEST['stat'][$key];
	    		}
    		}
	    }
	    
		if (!$npc->Edit($stats, $_REQUEST['string'])){
			echo 'Error';
		} else {
			echo 'Creature Edited.';
		}
    }
    else {
	    $form = new Form($page);
	    $form->AddSectionTitle('Edit Creature');
	    $creatures = $arena->Creatures();
	    $form->StartSelect('Creature', 'creature');
	    foreach ($creatures as $creature){
		    $form->AddOption($creature->GetID(), $creature->GetName());
	    }
	    $form->EndSelect();
	    $form->AddHidden('id', $_REQUEST['id']);
		$form->AddHidden('op', $_REQUEST['op']);
	    $form->AddSubmitButton('next', 'Enter Creature Stats');
	    $form->EndForm();
    }
}

?>