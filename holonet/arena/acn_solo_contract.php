<?php

function title() {
    return 'AMS Challenge Network :: Solo Mission :: Request Contract';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
    global $arena, $roster, $hunter, $page;

    arena_header();

    $solo = new Solo();
    $control = new SoloControl();

    arena_header();

    if ($solo->PendingContract($hunter->GetID())){

        echo "You have a contract pending already. You can not request another contract until your current contract is completed or retired.<br /><br />~Challenge Network.";

    }
    else {

        if (isset($_REQUEST['submit'])) {
            if ($control->New_Contract($hunter->GetID(), $_REQUEST['type'])) {
                echo 'Contract Requested.';
            }
            else {
                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 7';
            }
        }
        else {
            $form = new Form($page);
            $form->StartSelect('Type of Contract:', 'type');
            foreach ($solo->Types() as $value) {
                $form->AddOption($value->GetID(), $value->GetName());
            }
            $form->EndSelect();
            $form->AddSubmitButton('submit', 'Request Contract');
            $form->EndForm();
        }
    }

    arena_footer();
}
?>