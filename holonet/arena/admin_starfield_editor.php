<?php
function title() {
    return 'Administration :: Starfield Arena :: Match Editor';
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

        $settings = $starfield->Settings();
        $types = $starfield->Types();
        $restrictions = $starfield->Restrictions();
        $locations = $starfield->Locations();

        $form = new Form($page);
        $form->AddHidden('match_id', $_REQUEST['match_id']);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddTextBox('Message Board ID:', 'match_id', $match->GetMatchID(), 10);

        $form->AddTextBox('Match Name:', 'name', $match->GetName(), 50);

        $form->StartSelect('Match Type:', 'type', $type->GetID());
        foreach($types as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();

        $form->StartSelect('Settings:', 'setting', $setting->GetID());
        foreach($settings as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();

        $i = 3;

        $form->StartSelect('Number of Posts:', 'posts', $match->GetPosts());
        while ($i <= 5) {
            $form->AddOption($i, $i);
            $i++;
        }
        $form->EndSelect();

        if ($match->HasLocation()){
	        $lccid = $location->GetID();
        } else {
	        $lccid = 0;
        }
        
        $form->StartSelect('Location:', 'location', $lccid);
        $form->AddOption(0, 'No Location Specified');
        foreach ($locations as $lid=>$lname) {
            $form->AddOption($lid, $lname);
        }
        $form->EndSelect();

        $form->table->StartRow();
        $form->table->AddCell('Restrictions', 2);
        $form->table->EndRow();

        foreach ($restrictions as $value) {
            $form->AddCheckBox($value->GetName(), 'restriction_'.$value->GetID(), 1, $match->IsRestriction($value->GetID()));
        }

        $form->AddHidden('match_id', $_REQUEST['match_id']);
        $form->AddHidden('restrictions', count($restrictions));

        $form->AddSubmitButton('submit', 'Edit Match');      
        $form->EndForm();
	    
    }
    elseif (isset($_REQUEST['submit'])) {

        $i = 0;
        $num = 1;
        $restriction = array();

        while ($i < $_REQUEST['restrictions']){
            $value = $_REQUEST['restriction_'.$i];

            if ($value){
                array_push($restriction, $num);
                $num++;
            }

            $i++;
        }

        $edit = $match->Edit($_REQUEST['name'], $_REQUEST['location'], $_REQUEST['setting'], $restriction, $_REQUEST['posts'], $_REQUEST['match_id'], $_REQUEST['type']);
		echo $edit;

    }
    else {
        $form = new Form($page);
        $form->StartSelect('Match:', 'match_id');
        foreach ($starfield->Unfinished() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('next', 'Next >>');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>