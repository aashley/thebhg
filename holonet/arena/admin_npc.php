<?php
function title() {
    return 'Administration :: General :: Generate NPC';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return ($auth_data['aide'] || $auth_data['ch']);
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();
    
    if (isset($_REQUEST['submit'])) {
		$npc = new Parse_NPC($_REQUEST['type'], true);
		
		$utility = new NPC_Utilities();
		
		echo $utility->Construct($npc->GetString());
    }
    else {	    
        $form = new Form($page);
        $form->StartSelect('Max Stats:', 'type');
        for ($i = 5; $i <= 10; $i++) {
            $form->AddOption($i, $i);
        }
        $form->EndSelect();
        $form->AddSubmitButton('submit', 'Generate NPC');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>