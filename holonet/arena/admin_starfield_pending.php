<?php
function title() {
    return 'Administration :: Starfield Arena :: Pending Challenges';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['star'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $contract;

    arena_header();

    $starfield = new Starfield();
    $pending = $starfield->Pending();

    if (count($pending)) {
        $table = new Table('Pending Challenges', true);
        $table->StartRow();
        $table->AddHeader('Challenger');
        $table->AddHeader('Challenger Ship');
        $table->AddHeader('Challengee');
        $table->AddHeader('Challengee Ship');
        $table->AddHeader('Location');
        $table->AddHeader('Match Type');
        $table->AddHeader('Settings');
        $table->AddHeader('Restrictions');
        $table->AddHeader('Posts');
        $table->AddHeader('&nbsp;', 2);
        $table->EndRow();
        foreach($pending as $value) {
            $type = $value->GetType();
            $challenger = $value->GetChallenger();
            $challengee = $value->GetChallengee();
            $location = $value->GetLocation();
            $setting = $value->GetSettings();
            $table->StartRow();
            $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$challenger->GetID())) . '">' . $challenger->GetName() . '</a>');
            $table->AddCell($challenger->GetShipLink());
            $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$challengee->GetID())) . '">' . $challengee->GetName() . '</a>');
            $table->AddCell($challengee->GetShipLink());
            if ($value->HasLocation()){
                $table->AddCell($location->GetName());
            } else {
                $table->AddCell($value->GetLocation());
            }
            $table->AddCell($type->GetName());
            $table->AddCell($setting->GetName());
            $table->AddCell($value->WriteRestrictions());
            $table->AddCell($value->Posts());
            $table->AddCell('<a href="' . internal_link('admin_starfield_complete', array('id'=>$value->GetID())) . '">Complete</a>');
            $table->AddCell('<a href="' . internal_link('admin_starfield_remove', array('id'=>$value->GetID())) . '">Remove</a>');
            $table->EndRow();
        }
        $table->EndTable();
    }
    else {
        echo 'No challenges pending.';
    }

    admin_footer($auth_data);
}
?>