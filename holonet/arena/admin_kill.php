<?php
if (isset($_REQUEST['id'])){
	$person = new Person($_REQUEST['id']);
}

function title() {
	global $person;
	
	$return = '';
	
	if (is_object($person)){
		$return .= $person->GetName().'\'s ';
	} 
	
	$return .= 'Character Sheet';
	
	return $return;
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;

    $position = $hunter->GetPosition();
    
    arena_header();
    
    if (isset($_REQUEST['id'])){
		$character = new Character($_REQUEST['id']);
	
		if (isset($_REQUEST['submit'])){
			echo $character->Kill($_REQUEST['reason']);
		} else {
			$form = new Form($page);
			$form->AddHidden('id', $_REQUEST['id']);
			$form->AddTextBox('Reason (for denial): ', 'reason');
			'<center><input style="background-color: red; font-weight: bold; border: dotted" type="submit" name="submit" value="Confirm Character Assassination"><center>';
			$form->EndForm();
		}
	}
	
	admin_footer($auth_data);

}
?>