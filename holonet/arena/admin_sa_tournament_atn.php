<?php
function title() {
    return 'Administration :: Starfield Arena Tournament :: Add Matches to ATN';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['star'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $page;

    arena_header();
    $at = new SATournament();
    $starfield = new Starfield();

    if (isset($_REQUEST['submit'])) {
    
	    if ($at->AddToATN($_REQUEST['type'], $_REQUEST['setting'], $_REQUEST['posts'], $_REQUEST['location'], $_REQUEST['restriction'])){
	        echo "Matches Added to Arena Tracking Network.";
	    } else {
	        NEC(204);
	    }
	    
    } else {
	    
	    $settings = $starfield->Settings();
	    $types = $starfield->Types();
	    $restrictions_type = $starfield->Restrictions();
	    $locations = $starfield->Locations();
    
	    $form = new Form($page);
		
	    $form->AddSectionTitle('Set Tournament Round Rules');

        $form->StartSelect('Match Type:', 'type');
        foreach($types as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();

        $form->StartSelect('Settings:', 'setting');
        foreach($settings as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();

        $i = 3;

        $form->StartSelect('Number of Posts:', 'posts');
        while ($i <= 5) {
            $form->AddOption($i, $i);
            $i++;
        }
        $form->EndSelect();

        $form->StartSelect('Location:', 'location', $locations[array_rand($locations)]);
        $form->AddOption(0, 'No Location Specified');
        foreach ($locations as $lid=>$lname) {
            $form->AddOption($lid, $lname);
        }
        $form->EndSelect();

        $form->table->StartRow();
        $form->table->AddCell('Restrictions', 2);
        $form->table->EndRow();

        foreach ($restrictions_type as $value) {
            $form->AddCheckBox($value->GetName(), 'restriction[]', $value->GetID());
        }

        $form->AddHidden('challengee', $_REQUEST['challengee']);

        $form->AddSubmitButton('submit', 'Challenge');
        $form->EndForm();
    
	}
    
    admin_footer($auth_data);

}
?>
