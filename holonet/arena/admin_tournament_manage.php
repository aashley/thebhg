<?php
function title() {
    return 'Administration :: Arena Tournament :: Manage Signups';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $page;

    arena_header();
    
    $at = new Tournament();

    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Manage Signups for Season '.$at->CurrentSeason());
    $table->EndRow();
    
    foreach($at->GetHunters() as $value){
        $table->AddRow('<a href="' . internal_link('admin_tournament_delete', array('id'=>$value->GetID())) . '">' . $value->GetName() . '</a>');
    }

    $table->EndTable();
    
    admin_footer($auth_data);

}
?>
