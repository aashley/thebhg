<?php

function title() {
    return 'Administration :: Character Sheet :: Award/Remove Character Attributes';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['sheet'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;

    arena_header();
    
    if (isset($_REQUEST['new'])){
		 $character = new Character($_REQUEST['bhg_id']);
		 $character->AwardCA($_REQUEST['ca']);
		 echo 'Awarded Character Attribute';
    } elseif (isset($_REQUEST['del'])){
		 $character = new Character($_REQUEST['bhg_id'][$_REQUEST['ca']]);
		 $character->DeleteCA($_REQUEST['ca']);
		 echo 'Deleted Character Attribute';
    } else {
	    $form = new Form($page, 'New Award');
	    $form->AddSectionTitle('Hunter');
        include_once 'search.php';
	    $form->StartSelect('Attribute', 'ca', $_REQUEST['ca']);
	    foreach ($sheet->GetCAs() as $id=>$value){
			$form->AddOption($id, $value['name']);
	    }
	    $form->EndSelect();
	    $form->AddSubmitButton('new', 'Award Attribute');
	    
	    $form->EndForm();
	    
	    hr();
	    
	    $form = new Form($page, 'Remove Award');
	    
	    $form->StartSelect('Attribute', 'ca');
	    foreach ($sheet->AwardedCAs() as $value){
			$form->AddOption($value['ca'], $value['name'].' - '.$value['person']->GetName());
			$form->AddHidden('bhg_id['.$value['ca'].']', $value['person']->GetID());
	    }
	    $form->EndSelect();
	    $form->AddSubmitButton('del', 'Delete Attribute');
	    $form->EndForm();
    }
    
    admin_footer($auth_data);
}
?>