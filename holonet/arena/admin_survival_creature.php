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
		$form = new Form($page);
		$form->AddHidden('name', $_REQUEST['name']);
		$form->AddSectionTitle('Stats for '.$_REQUEST['name']);
		$form->table->AddRow('Stat Name', 'Stat Value');
		$form->table->StartRow();
		$form->table->AddHeader('[EXAMPLE] Barbed Tail: Melee');
		$form->table->AddHeader('6');
		$form->table->EndRow();
		for ($i = 1; $i <= $_REQUEST['stats']; $i++){
			$form->table->AddRow('<input type="text" name="names['.$i.']">', '<input type="text" name="stat['.$i.']">');
		}
		$form->AddTextArea('Description', 'string');
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
	    
		if (!$solo->NewCreature($stats, $_REQUEST['string'])){
			NEC(195);
		} else {
			echo 'Creature Created.';
		}
    }
    else {
	    $form = new Form($page);
	    $form->AddSectionTitle('Make New Creature');
	    $form->AddTextBox('Creature Name:', 'name');
	    $form->AddTextBox('Number of Stats', 'stats', '', 5);
	    $form->AddSubmitButton('next', 'Enter Creature Stats');
	    $form->EndForm();
    }

    admin_footer($auth_data);
}
?>