<?php

function title() {
    return 'Administration :: Character Sheet :: Demerit Points';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['demerit'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;

    arena_header();

    if (isset($_REQUEST['submit'])) {
        foreach ($_REQUEST['hunter'] as $id=>$pid) {
            if ($pid > 0) {
                $character = new Character($pid);
                $character->RemovePoint($_REQUEST['reason'][$id]);
            }
        }
        echo 'Demerit points added.';

        hr();
    }

    foreach ($sheet->SheetHolders() as $character) {
        $person = new Person($character->GetID());
        $div = $person->GetDivision();
        $str = $div->GetName() . ': ' . $person->GetName();
        $hunters[$str] = '<option value="' . $character->GetID() . '">' . html_escape($str) . '</option>';
    }
    ksort($hunters);

    $form = new Form($page);
    $form->table->StartRow();
    $form->table->AddHeader('Hunter');
    $form->table->AddHeader('Reason');
    $form->table->EndRow();
    for ($i = 0; $i < 10; $i++) {
        $form->table->StartRow();
        $form->table->AddCell('<select name="hunter[' . $i . ']" size=1 selected="0"><option value="0">N/A</option>' . implode('', $hunters) . '</select>');
        $form->table->AddCell('<input type="text" name="reason[' . $i . ']" size=15>');
        $form->table->EndRow();
    }
    $form->AddSubmitButton('submit', 'Issue Demerit Points');
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>