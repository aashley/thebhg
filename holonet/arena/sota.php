<?php
function title() {
    return 'AMS Tracking Network :: State of the Arena Report';
}

function output() {
    global $arena;

    echo 'The State of the Arena Report is an automatically generate stat printout of the current status of the Arena, valid up to the second which this page is viewed.';
    
    hr();

    $table = new Table('SECTION A: Match Statistics', true);
    
    $table->StartRow();
    $table->AddHeader('Activity');
    $table->AddHeader('Completed Events');
    $table->AddHeader('Outstanding Events');
    $table->AddHeader('Unposted Events');
    $table->AddHeader('Awarded XP');
    $table->AddHeader('Awarded Credits');
    $table->AddHeader('Administrator');
    $table->EndTable();
    
    $activities = array();
    $ladder = new Ladder();
    $ladder->Build();
    $st = new Person($ladder->CurrentSteward());
    $stwa = 'Steward <a href="'.internal_link('atn_general', array('id'=>$st->GetID())).'">'.$st->GetName().'</a>';
    
    $activities['The Arena'] = array('te'=>count($arena->ArenaMatches()), 'oe'=>count($ladder->Pending()), 'ce'=>count($ladder->Unposted()), 'xp'=>$ladder->GetXP(), 'cr'=>$ladder->GetCreds(), 'ad'=>$stwa);
    
    foreach ($activities as $activity=>$stats){
	    $table->AddRow($activity);	    
    }
    
    $table->EndTable();
    
    hr();
    
    arena_header();
	$arena->LatestReport($arena->ArenaPositions());
    arena_footer();
}
?>