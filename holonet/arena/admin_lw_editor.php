<?php
function title() {
    return 'Administration :: Lone Wolf Mission :: Contract Editor';
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

    $solo = new LW_Solo();
    if (isset($_REQUEST['contract_id'])){
	    $contract = new LW_Contract($_REQUEST['contract_id']);
    }

    if (isset($_REQUEST['next'])) {

        $form = new Form($page);
        $form->table->StartRow();
        $form->AddHidden('contract_id', $_REQUEST['contract_id']);
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();
        $form->table->StartRow();
        $form->table->AddCell('Message Board ID:');
        $form->table->AddCell('<input type="text" name="mbid" value="'.$contract->GetMBID().'" size="10">');
        $form->table->EndRow();
        $form->StartSelect('Hunter:', 'bhg_id', $contract->GetBHGID());
        hunter_dropdown($form);
        $form->EndSelect();

        $form->AddSubmitButton('submit', 'Edit Contract');
        $form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
        $edit = $contract->Edit($_REQUEST['bhg_id'], $_REQUEST['mbid']);
        print_r($edit);
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Contract:', 'contract_id');
        foreach ($solo->Contracts() as $value) {
            $form->AddOption($value->GetID(), "Contract ".$value->GetContractID());
        }
        $form->EndSelect();
        $form->AddSubmitButton('next', 'Next >>');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>