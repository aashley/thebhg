<?php
function title() {
    return 'Administration :: General :: Insert Blank Sheet';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['aa'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $sheet, $roster;

    arena_header();
    
    if (isset($_REQUEST['submit'])) {
	    $character = new Character($_REQUEST['person']);
		if ($character->IsNew()){
			if (!$character->NewSheet()){
				NEC(158);
				admin_footer($auth_data);
				return;
			} else {
				echo 'Sheet created.';
			}
		} else {
			echo 'Character has a sheet.';
		}
    }
    else {
        $form = new Form($page);
        $form->AddSectionTitle('Roster ID Number of Sheet to Add');
        $form->AddTextBox('BHG ID', 'person', '', 5);
        $form->AddSubmitButton('submit', 'Go Go Low-Tech Add');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>