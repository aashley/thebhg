<?php
function title() {
    return 'Administration :: Survival Missions :: Creature Maker';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['survival'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $solo = new Survival();

	if (isset($_REQUEST['next'])) {		
		
		$npc = new Creature($_REQUEST['creature']);
		
		$form = new Form($page);
		$form->AddHidden('creature', $_REQUEST['creature']);
		$form->AddSectionTitle('Stats for <input type="text" value="'.$npc->GetName().'" name="name">');
		$form->table->AddRow('Stat Name', 'Stat Value');
		$form->table->StartRow();
		$form->table->AddHeader('[EXAMPLE] Barbed Tail: Melee');
		$form->table->AddHeader('6');
		$form->table->EndRow();
		foreach ($npc->npc_stats as $name=>$value){
			$form->table->AddRow('<input type="text" name="names['.$i.']" value="'.$name.'">', '<input type="text" name="stat['.$i.']" value="'.$value.'">');
		}
		$form->AddTextArea('Description', 'string', $npc->npc_string);
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
			NEC(196);
		} else {
			echo 'Creature Edited.';
		}
    }
    else {
	    $form = new Form($page);
	    $form->AddSectionTitle('Edit Creature');
	    $creatures = $solo->Creatures();
	    $form->StartSelect('Creature', 'creature');
	    foreach ($creatures as $creature){
		    $form->AddOption($creature->GetID(), $creature->GetName());
	    }
	    $form->EndSelect();
	    $form->AddSubmitButton('next', 'Enter Creature Stats');
	    $form->EndForm();
    }

    admin_footer($auth_data);
}
?>