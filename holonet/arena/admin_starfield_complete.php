<?php
function title() {
    return 'Administration :: Starfield Arena :: Complete Match';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['star'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $roster;

    arena_header();

    $starfield = new Starfield();

    if (isset($_REQUEST['id'])) {
        $match = new StarfieldMatch($_REQUEST['id']);
        $people = $match->GetContenders();

        $form = new Form($page);
        $form->AddHidden('match_id', $_REQUEST['id']);

        for ($i = 0; $i < count($people); $i++) {
            $person = $people[$i];

            $form->table->StartRow();
            $form->table->AddHeader('Match Data for <b>'.$person->GetName().'</b>', 2);
            $form->table->EndRow();

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
    }
    elseif (isset($_REQUEST['submit'])) {
	    
	    $match = new StarfieldMatch($_REQUEST['match_id']);

        foreach($_REQUEST['person'] as $id=>$pid){
            if ($match->Complete($pid, $_REQUEST['xp'][$id], $_REQUEST['creds'][$id], $_REQUEST['outcome'][$id])) {
                echo 'Match Results Added for Contender!';
                
                $character = new Character($pid);
	        	$character->XPEvent($_REQUEST['xp'][$id], 'Starfield Arena Match');
	        	
            }
            else {
                NEC(51);
            }

            echo "<br />";
        }

    }
    else {

        $pending = $starfield->Pending();

        if (count($pending)) {
            $table = new Table('Pending Challenges', true);
            $table->StartRow();
            $table->AddHeader('Challenger');
            $table->AddHeader('Challenger Ship');
            $table->AddHeader('Challengee');
            $table->AddHeader('Challengee Ship');
            $table->AddHeader('Location');
            $table->AddHeader('Match Type');
            $table->AddHeader('Settings');
            $table->AddHeader('Restrictions');
            $table->AddHeader('Posts');
            $table->AddHeader('&nbsp;');
            $table->EndRow();
            foreach($pending as $value) {
                $type = $value->GetType();
                $challenger = $value->GetChallenger();
                $challengee = $value->GetChallengee();
                $location = $value->GetLocation();
                $setting = $value->GetSettings();
                $table->StartRow();
                $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$challenger->GetID())) . '">' . $challenger->GetName() . '</a>');
                $table->AddCell($challenger->GetShipLink());
                $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$challengee->GetID())) . '">' . $challengee->GetName() . '</a>');
                $table->AddCell($challengee->GetShipLink());
                if ($value->HasLocation()){
                    $table->AddCell($location->GetName());
                } else {
                    $table->AddCell($value->GetLocation());
                }
                $table->AddCell($type->GetName());
                $table->AddCell($setting->GetName());
                $table->AddCell($value->WriteRestrictions());
                $table->AddCell($value->GetPosts());
                $table->AddCell('<a href="' . internal_link('admin_starfield_complete', array('id'=>$value->GetID())) . '">Complete</a>');
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