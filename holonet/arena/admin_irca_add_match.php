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
        
        $form = new Form($page);
        $form->AddHidden('match_id', $_REQUEST['id']);
        
        $form->AddTextArea('Match:', 'match_text');

        $form->AddSubmitButton('submit', 'Add Match Text');
        $form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
	    
	    $match = new IRCAMatch($_REQUEST['match_id']);

	    if ($match->AddMatchText($_REQUEST['match_text'])){
		    echo 'Match Text added!';
	    } else {
		    NEC(109);
    	}

    }
    else {

        $pending = $irca->Unfinished();

        if (count($pending)) {
            $table = new Table('Unfinished Matches', true);
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
                $table->AddCell('<a href="' . internal_link('hunter', array('id'=>$challenger->GetID()), 'roster') . '">' . $challenger->GetName() . '</a>');
                $table->AddCell('<a href="' . internal_link('hunter', array('id'=>$challengee->GetID()), 'roster') . '">' . $challengee->GetName() . '</a>');
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