<?php
function title() {
    return 'Administration :: Network Error Codes';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['coder'];
}

function output() {
    global $arena, $db, $page, $auth_data;

    arena_header();
    
    if (isset($_REQUEST['submit'])){
	    $sql = "INSERT INTO `arena_errors` (`page`, `class`, `function`) VALUES ('".$_REQUEST['erp']."', '".$_REQUEST['class']."', '"
	    	.$_REQUEST['function']."')";
	    if (mysql_query($sql, $db)) { echo "New NEC Code (Error #".mysql_insert_id($db).") Added"; }
    }
    
    hr();
    
    $form = new Form($page);
    $form->table->StartRow();
    $form->table->AddHeader('Add New NEC Code', 2);
    $form->table->EndRow();
    
    $form->AddTextBox('Page', 'erp', '', 50);
    $form->AddTextBox('Class', 'class', '', 50);
    $form->AddTextBox('Function', 'function', '', 50);
    
    $form->AddSubmitButton('submit', 'Submit New NEC Code');
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>