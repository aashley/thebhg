<?php
function title() {
    return 'Administration :: General :: Generate NPC';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['solo'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $solo = new Solo();
    
    if (isset($_REQUEST['submit'])) {
		$npc = new Parse_NPC($_REQUEST['type']);
		
		$utility = new NPC_Utilities();
		
		echo $npc->GetString().'<p>';
		
		echo $utility->Construct($npc->GetString());
    }
    else {	    
        $form = new Form($page);
        $form->StartSelect('Difficulty:', 'type');
        foreach ($solo->Types() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('submit', 'Generate NPC');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>