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
    global $auth_data, $page, $roster;

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
    elseif ($_REQUEST['next'){
	    $form = new Form($page);
		$form->StartSelect('Choose Hunter', 'person');
		$kab = new Division($_REQUEST['kabal']);
		foreach ($kab->GetMembers('name') as $kabal){
			$form->AddOption($kabal->GetID(), $kabal->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Insert Blank');
		$form->EndForm();
    } else {
		$form = new Form($page);
		$form->StartSelect('Choose Division', 'kabal');
		foreach ($roster->GetDivisions() as $kabal){
			$form->AddOption($kabal->GetID(), $kabal->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('next', 'Choose Hunter');
		$form->EndForm();
	}

    admin_footer($auth_data);
}
?>