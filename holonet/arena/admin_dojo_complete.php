<?php
function title() {
    return 'Administration :: Dojo of Shadows :: Complete Match';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['dojo'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $roster;

    arena_header();

    $ladder = new Ladder();

    if (isset($_REQUEST['id'])) {
	    $match = new Match($_REQUEST['id']);
        
	    if ($match->IsDojo()){
	    
	        $people = $match->GetContenders();
	
	        $form = new Form($page);
	        $form->AddHidden('match_id', $_REQUEST['id']);
	            
	        for ($i = 0; $i < count($people); $i++) {
	            $person = $people[$i];
	
	            $form->table->StartRow();
	            $form->table->AddHeader('Match Data for <b>'.$person->GetName().'</b>', 2);
	            $form->table->EndRow();
	            
	            $add_xp = '';
	            
	            if (isset($_REQUEST['add_xp'])){
		            $add_xp = $_REQUEST['add_xp'];
	            }
	            
	            $form->AddHidden('add_xp', $add_xp);
	
	            $form->AddHidden('person[' . $i . ']', $person->GetID());
	
	            $form->StartSelect('Result:', 'outcome[' . $i . ']');
	            foreach ($arena->Points() as $id=>$name) {
	                $form->AddOption($id, $name);
	            }
	            $form->EndSelect();
	
	            $form->AddTextBox('Credits Earned:', 'creds[' . $i . ']');
	            $form->AddTextBox('Experience Points:', 'xp[' . $i . ']');
	        }
	
	        $form->AddSubmitButton('submit', 'Complete Match');
        	$form->EndForm();
        } else {
	        echo 'Not a Dojo Match.';
        }
    }
    elseif (isset($_REQUEST['submit'])) {
	    
	    $match = new Match($_REQUEST['match_id']);

	    if ($match->IsDojo()){
	        foreach($_REQUEST['person'] as $id=>$pid){
	            if ($match->Complete($pid, $_REQUEST['xp'][$id], $_REQUEST['creds'][$id], $_REQUEST['outcome'][$id])) {
		            
		            if (!$_REQUEST['add_xp']){
			            $character = new Character($pid);
		        		$character->XPEvent($_REQUEST['xp'][$id], 'Dojo Match');
		        	}
		        	
	                echo 'Match Results Added for Contender!';
	            }
	            else {
	                NEC(121);
	            }
	
	            echo "<br />";
	        }
	    } else {
	        echo 'Not a Dojo Match.';
        }

    }
    else {

        $pending = $ladder->PendingDojo('end');

        if (count($pending)) {
            $table = new Table('Pending Challenges', true);
            $table->StartRow();
            $table->AddHeader('Challenger');
            $table->AddHeader('Challengee');
            $table->AddHeader('Match Type');
            $table->AddHeader('Location');
            $table->AddHeader('Weapon Type');
            $table->AddHeader('Num. of Weapons');
            $table->AddHeader('Posts');
            $table->AddHeader('&nbsp;', 2);
            $table->EndRow();
            foreach($pending as $value) {
                $type = $value->GetType();
                $challenger = $value->GetChallenger();
                $challengee = $value->GetChallengee();
                $weapon = $value->GetWeaponType();
                $location = $value->GetLocation();

                $table->StartRow();
                $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$challenger->GetID())) . '">' . $challenger->GetName() . '</a>');
                $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$challengee->GetID())) . '">' . $challengee->GetName() . '</a>');
                $table->AddCell($type->GetName());
                $table->AddCell($location->GetName());
                $table->AddCell($weapon->GetWeapon());
                $table->AddCell($value->GetWeapons());
                $table->AddCell($value->GetPosts());
                $table->AddCell('<a href="' . internal_link('admin_dojo_complete', array('id'=>$value->GetID())) . '">Complete</a>');
                $table->EndRow();
            }
            $table->EndTable();
        }
        else {
            echo 'No challenges pending.';
        }

    }

    admin_footer($auth_data);
}
?>