<?php
function title() {
    return 'Administration :: Starfield Arena :: Match Poster';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['star'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $starfield = new Starfield();
    if (isset($_REQUEST['match_id'])){
    	$match = new StarfieldMatch($_REQUEST['match_id']);
	}

    if (isset($_REQUEST['next'])) {  

        $type = $match->GetType();
        $location = $match->GetLocation();
        $setting = $match->GetSettings();

        echo "<b>Subject Line</b>: ".$match->GetName()."<br /><br />";

        echo "[[u]Match Setting[/u]]<br />".$setting->GetName()."<br /><br />"."[[u]Match Restrictions[/u]]<br />".$match->WriteRestrictions()."<br /><br />"
            ."[[u]Match Type[/u]]<br />".$type->GetName()."<br /><br />";

        if ($match->HasLocation()){
            echo "This match will begin on ".$location->GetName();
        } else {
            echo "There are no location confines to this match.";
        }

        echo "<br /><br />Each hunter will be expected to make [b]".$match->GetPosts()."[/b] posts.<br /><br />";

        foreach ($match->GetFighters() as $value){
            echo $value->GetName()." :: ".$value->GetShipMBLink()."<br />";
        }

        echo "<br />Good luck, hunters.";

        hr();

        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Enter Message Board ID', 2);
        $form->table->EndRow();
        $form->AddHidden('match_id', $_REQUEST['match_id']);
        $form->AddTextBox('Topic Number:', 'mbid');

        $form->AddSubmitButton('submit', 'Complete Process');
        $form->EndForm();

    }
    elseif (isset($_REQUEST['submit'])) {

        if ($match->StartMatch($_REQUEST['mbid'])){

            echo "Match process completed.";

        } else {

            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 49';
        }

    }
    else {
        $form = new Form($page);
        $form->StartSelect('Match:', 'match_id');
        foreach ($starfield->Unposted() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('next', 'Next >>');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>