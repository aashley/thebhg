<?php
function title() {
    return 'AMS Tracking Network :: State of the Arena Report';
}

function nf ($input){
	return '<right>'.number_format($input).'</right>';
}

function output() {
    global $arena;

    arena_header();
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
    $table->EndRow();
    
    $activities = array();
    $ladder = new Ladder();
    $ladder->Build();
    $st = new Person($ladder->CurrentSteward());
    $dm = new Person($ladder->CurrentMaster());
    $stwa = 'Steward <a href="'.internal_link('atn_general', array('id'=>$st->GetID())).'">'.$st->GetName().'</a>';
    $djm = 'Dojo Master <a href="'.internal_link('atn_general', array('id'=>$dm->GetID())).'">'.$dm->GetName().'</a>';
    
    $activities['The Arena'] = array('ce'=>count($arena->ArenaMatches('AND `is_dojo` = 0')), 'oe'=>count($ladder->Pending()), 'ue'=>count($ladder->Unposted()), 'xp'=>$ladder->GetXP(), 'cr'=>$ladder->GetCreds(), 'ad'=>$stwa);
    $activities['The Dojo of Shadows'] = array('ce'=>count($arena->ArenaMatches('AND `is_dojo` > 0')), 'oe'=>count($ladder->PendingDojo('end')), 'ue'=>count($ladder->PendingDojo()), 'xp'=>$ladder->GetDXP(), 'cr'=>$ladder->GetDCreds(), 'ad'=>$djm);
    
    foreach ($activities as $activity=>$stats){
	    $table->AddRow($activity, nf($stats['ce']), nf($stats['oe']), nf($stats['ue']), nf($stats['xp']), nf($stats['cr']), $stats['ad']);	    
    }
    
    $table->EndTable();
    
    hr();

	$arena->LatestReport($arena->ArenaPositions());
    arena_footer();
}
?>