<?php
function title() {
    return 'Administration :: IRC Arena :: Grade Match';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $roster;

    arena_header();

    $irca = new IRCA();

    if (isset($_REQUEST['id'])) {
	    $match = new IRCAMatch($_REQUEST['id']);
        
        $people = $match->GetContenders();

     	$table = new Table();
     	$table->StartRow();
     	$table->AddHeader('Match Text');
     	$table->EndRow();
     	
     	$table->AddRow($match->GetMatch());
     	
     	$table->EndTable();
     	
     	hr();
        
        $form = new Form($page);
        $form->AddHidden('match_id', $_REQUEST['id']);
            
        for ($i = 0; $i < count($people); $i++) {
            $person = $people[$i];

            $form->table->StartRow();
            $form->table->AddHeader('Match Data for <b>'.$person->GetName().'</b>', 2);
            $form->table->EndRow();
            $form->AddHidden('add_xp', $_REQUEST['add_xp']);

            $form->AddHidden('person[' . $i . ']', $person->GetID());

            $form->StartSelect('Result:', 'outcome[' . $i . ']');
            foreach ($arena->Points() as $id=>$name) {
                $form->AddOption($id, $name);
            }
            $form->EndSelect();

            $form->AddTextBox('Credits Earned:', 'creds[' . $i . ']');
            $form->AddTextBox('Experience Points:', 'xp[' . $i . ']');
        }
        
        $form->AddTextArea('Match Comments:', 'comments');

        $form->AddSubmitButton('submit', 'Grade Match');
        $form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
	    
	    $match = new IRCAMatch($_REQUEST['match_id']);

        foreach($_REQUEST['person'] as $id=>$pid){
            if ($match->Complete($pid, $_REQUEST['xp'][$id], $_REQUEST['creds'][$id], $_REQUEST['outcome'][$id], $_REQUEST['comments'])) {
	            
	            if (!$_REQUEST['add_xp']){
		            $character = new Character($pid);
	        		$character->XPEvent($_REQUEST['xp'][$id], 'IRC Arena Match');
	        	}
	        	
                echo 'Match Results Added for Contender!';
            }
            else {
            	NEC(69);
            }

            echo "<br />";
        }

    }
    else {

        $pending = $irca->Ungraded();

        if (count($pending)) {
            $table = new Table('Ungraded Matches', true);
            $table->StartRow();
            $table->AddHeader('Challenger');
            $table->AddHeader('Challengee');
            $table->AddHeader('Match Type');
            $table->AddHeader('Location');
            $table->AddHeader('Weapon Type');
            $table->AddHeader('Num. of Weapons');
            $table->AddHeader('Actions');
            $table->AddHeader('&nbsp;', 2);
            $table->EndRow();
            foreach($pending as $value) {
                $type = $value->GetType();
                $combatants = $value->GetContenders();
                $weapon = $value->GetWeaponType();
                $location = $value->GetLocation();
                $challenger = $combatants[0];
                $challengee = $combatants[1];

                $table->StartRow();
                $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$challenger->GetID())) . '">' . $challenger->GetName() . '</a>');
                $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$challengee->GetID())) . '">' . $challengee->GetName() . '</a>');
                $table->AddCell($type->GetName());
                $table->AddCell($location->GetName());
                $table->AddCell($weapon->GetWeapon());
                $table->AddCell($value->GetWeapons());
                $table->AddCell($value->GetActions());
                $table->AddCell('<a href="' . internal_link('admin_irca_complete', array('id'=>$value->GetID())) . '">Complete</a>');
                $table->EndRow();
            }
            $table->EndTable();
        }
        else {
            echo 'No ungraded matches.';
        }

    }

    admin_footer($auth_data);
}
?>