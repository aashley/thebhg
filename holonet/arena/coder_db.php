<?php
function title() {
    return 'Coder Resources :: System :: Fields';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['coder'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $contract;

    arena_header();

    if ($_REQUEST['submit']){
    
	    $coder = new Coder();
	    
	    $coder->Fileds($table);
	    
	    echo '<pre>';
	    print_r($coder->fields);
	    echo '</pre>';
    } else {
	    $form = new Form($page);
	    $form->AddTextBox('Table', 'table');
	    $form->AddSubmitButton('submit', 'Submit');
	    $form->EndForm();
    }

    admin_footer($auth_data);
}
?>