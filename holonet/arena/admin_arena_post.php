<?php
function title() {
    return 'Administration :: Arena :: Match Poster';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $ladder = new ladder();
    if (isset($_REQUEST['match_id'])){
    	$match = new Match($_REQUEST['match_id']);
	}

    if (isset($_REQUEST['next'])) {

        $type = $match->GetType();
        $location = $match->GetLocation();
        $weapon = $match->GetWeaponType();

        if ($match->IsTTG()){
	        echo "<b>Post as a Twilight Gauntlet Match</b><br /><br />";
        }	        
        
        echo "<b>Subject Line</b>: ".$match->GetName()."<br /><br />";

        echo "Data You'll Need to Construct Opener:<br /><br />"
            ."Location: ".$location->GetName()." <br />Number of Weapons: ".$match->GetWeapons()." <br />Type of Weapons: ".$weapon->GetWeapon().
            " <br />Post Limit: ".$match->GetPosts()." <br />Rules: ".$type->GetRules();

        hr();

        $form = new Form($page);
        $form->AddHidden('match_id', $_REQUEST['match_id']);
        $form->table->StartRow();
        $form->table->AddHeader('Enter Message Board ID', 2);
        $form->table->EndRow();
        $form->AddTextBox('Topic Number:', 'mbid');

        $form->AddSubmitButton('submit', 'Complete Process');
        $form->EndForm();

    }
    elseif (isset($_REQUEST['submit'])) {
	    
        if ($match->StartMatch($_REQUEST['mbid'])){

            echo "Match process completed.";

        } else {

            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 71';
        }

    }
    else {
        $form = new Form($page);
        $form->StartSelect('Match:', 'match_id');
        foreach ($ladder->Unposted() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('next', 'Next >>');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>