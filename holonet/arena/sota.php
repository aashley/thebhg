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
    echo 'The State of the Arena Report is an automatically generate stat printout of the current status of the Arena.';
    
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
    $star = new Starfield();
    $star->Build();
    $ladder->Build();
    $solo = new Solo();
    $solo->SecondBuild();
    $lw = new LW_Solo();
    $surv = new Survival();
    $surv->SecondBuild();
    $ro = new RO();
    $ro->Build();
    $irca = new IRCA();
    $irca->Build();
    $st = new Person($ladder->CurrentSteward());
    $dm = new Person($ladder->CurrentMaster());
    $cb = new Person($solo->CurrentComissioner());
    $ra = new Person($surv->CurrentRanger());
    $sk = new Person($star->CurrentSkipper());
    $mm = new Person($ro->CurrentMM());
    $hc = new Person($irca->CurrentHC());
    if ($st->GetName()){ $stwa = 'Steward <a href="'.internal_link('atn_general', array('id'=>$st->GetID())).'">'.$st->GetName().'</a>'; } else { $stwa = 'None'; }
    if ($dm->GetName()){ $djm = 'Dojo Master <a href="'.internal_link('atn_general', array('id'=>$dm->GetID())).'">'.$dm->GetName().'</a>'; } else { $djm = 'None'; }
    if ($cb->GetName()){ $cbo = 'Commissioner <a href="'.internal_link('atn_general', array('id'=>$cb->GetID())).'">'.$cb->GetName().'</a>'; } else { $cbo = 'None'; }
    if ($ra->GetName()){ $sur = 'Ranger <a href="'.internal_link('atn_general', array('id'=>$ra->GetID())).'">'.$ra->GetName().'</a>'; } else { $sur = 'None'; }
    if ($sk->GetName()){ $ski = 'Skipper <a href="'.internal_link('atn_general', array('id'=>$sk->GetID())).'">'.$sk->GetName().'</a>'; } else { $ski = 'None'; }
    if ($mm->GetName()){ $mim = 'Mission Master <a href="'.internal_link('atn_general', array('id'=>$mm->GetID())).'">'.$mm->GetName().'</a>'; } else { $mim = 'None'; }
    if ($hc->GetName()){ $hoc = 'Commentator <a href="'.internal_link('atn_general', array('id'=>$hc->GetID())).'">'.$hc->GetName().'</a>'; } else { $hoc = 'None'; }
    
    $activities['The Arena'] = array('ce'=>count($arena->ArenaMatches('AND `is_dojo` = 0 AND `end` > 0')), 'oe'=>count($ladder->Pending()), 'ue'=>count($ladder->Unposted()), 'xp'=>$ladder->GetXP(), 'cr'=>$ladder->GetCreds(), 'ad'=>$stwa);
    $activities['The Dojo of Shadows'] = array('ce'=>count($arena->ArenaMatches('AND `is_dojo` > 0 AND `end` > 0')), 'oe'=>count($ladder->PendingDojo('end')), 'ue'=>count($ladder->PendingDojo()), 'xp'=>$ladder->GetDXP(), 'cr'=>$ladder->GetDCreds(), 'ad'=>$djm);
    $activities['Solo Missions'] = array('ce'=>count($arena->SoloContracts()), 'oe'=>count($solo->PendingContracts()), 'ue'=>count($solo->RequestedContracts()), 'xp'=>$solo->GetXP(), 'cr'=>$solo->GetCreds(), 'ad'=>$cbo);
    $activities['Lone Wolf Missions'] = array('ce'=>count($arena->LWContracts()), 'oe'=>count($lw->PendingContracts()), 'ue'=>count($lw->RequestedContracts()), 'xp'=>$solo->GetDXP(), 'cr'=>$solo->GetDCreds(), 'ad'=>$cbo);
    $activities['Survival Missions'] = array('ce'=>count($arena->SurvivalContracts()), 'oe'=>count($surv->PendingContracts()), 'ue'=>count($surv->RequestedContracts()), 'xp'=>$surv->GetXP(), 'cr'=>$surv->GetCreds(), 'ad'=>$sur);
    $activities['Starfield Arena'] = array('ce'=>count($arena->StarfieldMatches('AND `end` > 0')), 'oe'=>count($star->Pending()), 'ue'=>count($star->Unposted()), 'xp'=>$star->GetXP(), 'cr'=>$star->GetCreds(), 'ad'=>$ski);
	$activities['Run Ons'] = array('ce'=>count($ro->GetROs()), 'oe'=>count($ro->Pending()), 'ue'=>count($ro->Unposted()), 'xp'=>$ro->GetXP(), 'cr'=>$ro->GetCreds(), 'ad'=>$mim);
    $activities['IRC Arena'] = array('ce'=>count($arena->IRCAMatches('AND `graded` > 0')), 'oe'=>count($irca->Ungraded()), 'ue'=>count($irca->Unfinished()), 'xp'=>$irca->GetXP(), 'cr'=>$irca->GetCreds(), 'ad'=>$hoc);
    
    ksort($activities);
    
    foreach ($activities as $activity=>$stats){
	    $table->AddRow($activity, nf($stats['ce']), nf($stats['oe']), nf($stats['ue']), nf($stats['xp']), nf($stats['cr']), $stats['ad']);	    
    }
    
    $table->EndTable();
    
	hr();
	
	$table = new Table('SECTION B: Ladder Leaders', true);
	
	$table->StartRow();
	$table->AddHeader('Ladder');
	$table->AddHeader('Hunter');
	$table->EndRow();
	
	$al = new Person(array_shift(array_keys($arena->ArenaLadder())));
	$il = new Person(array_shift(array_keys($arena->IRCALadder())));
	$sl = new Person(array_shift(array_keys($arena->StarfieldLadder())));
	$ol = new Person(array_shift(array_keys($arena->SoloLadder())));
	$ll = new Person(array_shift(array_keys($arena->LWLadder())));
	$ul = new Person(array_shift(array_keys($arena->SurvivalLadder())));
	$rl = new Person(array_shift(array_keys($arena->ROLadder())));
	
	$table->AddRow('The Arena', '<a href="'.internal_link('atn_general', array('id'=>$al->GetID())).'">'.$al->GetName().'</a>');
	$table->AddRow('Run-Ons', '<a href="'.internal_link('atn_general', array('id'=>$rl->GetID())).'">'.$rl->GetName().'</a>');
	$table->AddRow('Starfield Arena', '<a href="'.internal_link('atn_general', array('id'=>$sl->GetID())).'">'.$sl->GetName().'</a>');
	$table->AddRow('IRC Arena', '<a href="'.internal_link('atn_general', array('id'=>$il->GetID())).'">'.$il->GetName().'</a>');
	$table->AddRow('Solo Missions', '<a href="'.internal_link('atn_general', array('id'=>$ol->GetID())).'">'.$ol->GetName().'</a>');
	$table->AddRow('Survival Missions', '<a href="'.internal_link('atn_general', array('id'=>$ul->GetID())).'">'.$ul->GetName().'</a>');
	$table->AddRow('Lone Wolf Missions', '<a href="'.internal_link('atn_general', array('id'=>$ll->GetID())).'">'.$ll->GetName().'</a>');
	
	$table->EndTable();
	
    hr();

	$arena->LatestReport($arena->ArenaPositions(), 'SECTION C: Arena Reports');
	
    arena_footer();
}
?>