<?php
include_once('roster.inc');
include_once('objects/arena.inc');
include_once('library.inc');
include_once('citadel.inc');

$roster = new Roster('fight-51-me');
$mb = new MedalBoard('fight-51-me');
$arena = new Arena();
$library = new Library();
$at = new Tournament();
$iat = new IRCTournament();
$sat = new SATournament();
$citadel = new Citadel();
$lw = new LW_Solo();
$sheet = new Sheet();

function arena_header() {
    echo '<table border=0 width="100%"><tr valign="top"><td width="90%">';
}

function coders(){
	return array(2650);
}

function rp_staff($person){
	$position = $person->GetPosition();
	return ($position->GetID() == 9 || $position->GetID() == 29 || $person->GetID() == 2650);
}

function NEC($error){
	global $arena;
	echo $arena->NEC($error);
}

function next_medal($person, $group) {
	global $mb;

	$mg = $mb->GetMedalGroup($group);
	if ($mg->GetDisplayType() != 0) {
		echo 'Numeric medal, leaving immediately.<br>';
		$medals = $mg->GetMedals();
		return $medals[0];
	}
	
	$medals = $person->GetMedals();
	if (count($medals)) {
		$orders = array();
		$group_medals = $mg->GetMedals();
		foreach ($group_medals as $medal) {
			$orders[$medal->GetOrder()] = 0;
		}
		foreach ($medals as $am) {
			$medal = $am->GetMedal();
			$mgroup = $medal->GetGroup();
			if ($mgroup->GetID() == $group) {
				$orders[$medal->GetOrder()]++;
			}
		}
		ksort($orders);
		$last = 0;
		foreach ($orders as $key=>$o) {
			if ($o < $last) {
				$order = $key;
				break;
			}
			$last = $o;
		}
		if (empty($order)) {
			$order = min(array_keys($orders));
		}
		
		$medals = $mg->GetMedals();
		foreach ($medals as $medal) {
			if ($medal->GetOrder() == $order) {
				return $medal;
			}
		}
		return $medals[0];
	}
	else {
		$medals = $mg->GetMedals();
		return $medals[0];
	}
}

function acn_nav(){
	global $at, $lw, $person, $iat, $sat;
	
	echo '<small>General<br />';
	echo '&nbsp;<a href="' . internal_link('acn_challenge') . '">Network&nbsp;Control</a><br />';
	
	if ($at->ValidSignup()){
		echo '<br />Arena Tournament<br />';
	    echo '&nbsp;<a href="' . internal_link('acn_tournament_signup') . '"><b>Signup&nbsp;For&nbsp;Tournament</b></a><br />';
	}
	
	if ($iat->ValidSignup()){
		echo '<br />IRC Arena Tournament<br />';
	    echo '&nbsp;<a href="' . internal_link('acn_irc_tournament_signup') . '"><b>Signup&nbsp;For&nbsp;Tournament</b></a><br />';
	}
	
	if ($sat->ValidSignup()){
		echo '<br />Starfield Arena Tournament<br />';
	    echo '&nbsp;<a href="' . internal_link('acn_sa_tournament_signup') . '"><b>Signup&nbsp;For&nbsp;Tournament</b></a><br />';
	}
	
	echo '<br />Arena<br />';
	echo '&nbsp;<a href="' . internal_link('acn_arena_challenge') . '">Arena&nbsp;Challenges</a><br />';
	
	echo '<br />Starfield Arena<br />';
    echo '&nbsp;<a href="' . internal_link('acn_starfield_challenge') . '">Starfield&nbsp;Arena&nbsp;Challenges</a><br />';
    
    echo '<br />Solo Missions<br />';
    echo '&nbsp;<a href="' . internal_link('acn_solo_contract') . '">Request&nbsp;Contract</a><br />';
    echo '&nbsp;<a href="' . internal_link('acn_solo_dco') . '">Request&nbsp;Dead&nbsp;Contract</a><br />';
    echo '&nbsp;<a href="' . internal_link('acn_solo_retire') . '">Retire&nbsp;a&nbsp;Contract</a><br />';
    
    echo '<br />Lone Wolf Contracts<br />';
    echo '&nbsp;<a href="' . internal_link('acn_lw_contract') . '">Request&nbsp;Contract</a><br />';
    echo '&nbsp;<a href="' . internal_link('acn_lw_dco') . '">Request&nbsp;Dead&nbsp;Contract</a><br />';
    echo '&nbsp;<a href="' . internal_link('acn_lw_retire') . '">Retire&nbsp;a&nbsp;Contract</a><br />';
    
    echo '<br />IRC Arena<br />';
    echo '&nbsp;<a href="' . internal_link('acn_irca_submit') . '">Submit&nbsp;Match</a><br />';
    
    /*More Elite nonsense

    echo '<br />Tempestuous Group<br />';
    echo '&nbsp;<a href="' . internal_link('acn_tempy_petition') . '">Admittance&nbsp;Petition</a><br />'; 
    */
}

function atn_nav(){
	global $roster, $at, $iat, $sat;
	
	echo '<small>';
	
	echo 'Division Tracking';

    $cats = $roster->GetDivisionCategories();
    foreach ($cats as $dc) {
        $divs = $dc->GetDivisions();
        foreach ($divs as $div) {
	        if ($div != 16){
            	echo '<br />&nbsp;<a href="' . internal_link('atn_division', array('id' => $div->GetID())) . '">' . str_replace(' ', '&nbsp;', $div->GetName()) . '</a>';
        	}
        }
        echo '<br />';
    }
    
    echo '<br />Ladders<br />';
    echo '&nbsp;<a href="' . internal_link('atn_arena_ladder') . '">Arena Ladder</a><br />';
    echo '&nbsp;<a href="' . internal_link('atn_starfield_ladder') . '">Starfield Arena Ladder</a><br />';
    echo '&nbsp;<a href="' . internal_link('atn_irca_ladder') . '">IRC Arena Ladder</a><br />';
    echo '&nbsp;<a href="' . internal_link('atn_solo_ladder') . '">Solo Missions Ladder</a><br />';
    echo '&nbsp;<a href="' . internal_link('atn_lw_ladder') . '">Lone Wolf Ladder</a><br />';
    echo '&nbsp;<a href="' . internal_link('atn_ro_ladder') . '">Run-On Ladder</a><br />';
    echo '&nbsp;<a href="' . internal_link('atn_survival_ladder') . '">Survival Missions Ladder</a><br />';
	
	echo '<br />History<br />';
	echo '&nbsp;<a href="' . internal_link('atn_arena') . '">Arena Matches</a><br />';
	echo '&nbsp;<a href="' . internal_link('atn_starfield') . '">Starfield Arena Matches</a><br />';
	echo '&nbsp;<a href="' . internal_link('atn_irca') . '">IRC Arena Matches</a><br />';
	echo '&nbsp;<a href="' . internal_link('atn_solo') . '">Solo Contracts</a><br />';
	echo '&nbsp;<a href="' . internal_link('atn_lw') . '">Lone Wolf Contracts</a><br />';
    echo '&nbsp;<a href="' . internal_link('atn_ro') . '">Run-Ons</a><br />';
    echo '&nbsp;<a href="' . internal_link('atn_survival') . '">Survival Missions</a><br />';
    
    echo '<br />Hunter Lists<br />';
	echo '&nbsp;<a href="' . internal_link('atn_dojo') . '">Dojo&nbsp;Learners</a><br />';
	echo '&nbsp;<a href="' . internal_link('atn_dojo_grad') . '">Dojo&nbsp;Graduates</a><br />';
	echo '&nbsp;<a href="' . internal_link('atn_teta') . '">Teta\'s&nbsp;Knives&nbsp;Holders</a><br />';

	echo '<br />Reports<br />';
    echo '&nbsp;<a href="'.internal_link('reports').'">View&nbsp;Latest&nbsp;Reports</a><br />';
    echo '&nbsp;<a href="'.internal_link('view_reports').'">View&nbsp;All&nbsp;Reports</a><br />';
    
    echo '<br />Polling Centre<br />';
    echo '&nbsp;<a href="'.internal_link('atn_polling').'">View&nbsp;Arena&nbsp;Polls</a><br />';
	
    /*Removing the Elite RP stuff
    
    echo '<br />Tempestuous Group<br />';
    echo '&nbsp;<a href="' . internal_link('atn_tempy') . '">Members</a><br />';
    */
    
    echo '<br />Arena Tournaments<br />';
    echo '&nbsp;<a href="' . internal_link('atn_tournament') . '">AT Brackets</a><br />';
    echo '&nbsp;<a href="' . internal_link('atn_irc_tournament') . '">IRC AT Brackets</a><br />';
    echo '&nbsp;<a href="' . internal_link('atn_sa_tournament') . '">IRC AT Brackets</a><br />';
    if (count($at->GetHunters())){
    	echo '&nbsp;<a href="' . internal_link('atn_tournament_signups') . '">AT Signups</a><br />';
	}
    if (count($iat->GetHunters())){
    	echo '&nbsp;<a href="' . internal_link('atn_irc_tournament_signups') . '">IRC AT Signups</a><br />';
	}
	if (count($sat->GetHunters())){
    	echo '&nbsp;<a href="' . internal_link('atn_sa_tournament_signups') . '">Starfield AT Signups</a><br />';
	}
	echo '&nbsp;<a href="' . internal_link('atn_tournament_archive') . '">Archived [Arena]</a><br />';
	echo '&nbsp;<a href="' . internal_link('atn_irc_tournament_archive') . '">Archived [IRC Arena]</a><br />';
	echo '&nbsp;<a href="' . internal_link('atn_sa_tournament_archive') . '">Archived [Starfield Arena]</a><br />';
	
    echo '</small>';
}

function arena_footer($show_list = true) {
    global $roster, $arena, $library;
    
    $shelf = new Shelf(6);

    if ($show_list == false) {
        echo '</td></tr></table>';
        return;
    }

    echo '</td><td style="border-left: solid 1px black">';

    echo '<u>AMS Challenge Netowrk</u><small><br />';

    echo '&nbsp;<a href="' . internal_link('acn_challenge') . '">Network&nbsp;Control</a><br />';

    echo '</small>';
    
    echo '<br /><u>AMS Tracking Network</u><small><br />';

    atn_nav();
    
    echo '<br /><u>Arena Manuals</u><small><br />';
    
    $shelf_title = str_replace(' ', '&nbsp;', $shelf->GetName());
	echo '&nbsp;<a href="' . internal_link('shelf', array('id'=>$shelf->GetID()), 'library') . '">' . $shelf_title . '</a><small>';
	foreach ($shelf->GetBooks() as $book) {
		echo '<br />';
		$title = str_replace(' ', '&nbsp;', $book->GetTitle());
		echo '&nbsp;&nbsp;<a href="' . internal_link('book', array('id'=>$book->GetID()), 'library') . '">' . $title . '</a>';
	}
	echo '</small>';

  echo '</td></tr></table>';
}

function get_auth_data($hunter) {
    $pos = $hunter->GetPosition();
    $div = $hunter->GetDivision();
    $tempy = new Tempy();
    $lw = new LW_Solo();
    $solo = new Solo();
    $ladder = new Ladder();
    $ro = new RO();
    $sheet = new Sheet();
    $starfield = new Starfield();
    $irca = new IRCA();
    $survival = new Survival();

    $auth_data['id'] = $hunter->GetID();

    if ($hunter->GetID() == 2650){
	    $auth_data['coder'] = true;
    } else {
	    $auth_data['coder'] = false;
    }
    
    if ($pos->GetID() == 29 || $hunter->GetID() == 2650){
    	$auth_data['overseer'] = true;
	} else {
		$auth_data['overseer'] = false;
	}
    
    if ($pos->GetID() == 9 || $pos->GetID() == 29 || $hunter->GetID() == 2650) {
        $auth_data['rp'] = true;
        $auth_data['solo'] = true;
        $auth_data['tempy'] = true;
        $auth_data['elite'] = true;
        $auth_data['tempy_mod'] = true;   
        $auth_data['lw'] = true;   
        $auth_data['citadel'] = true;
        $auth_data['star'] = true;
        $auth_data['dojo'] = true;
        $auth_data['sheet'] = true;
        $auth_data['ro'] = true;
        $auth_data['aa'] = true;
        $auth_data['arena'] = true;
        $auth_data['irc'] = true;
        $auth_data['survival'] = true;
        $auth_data['ch'] = true;
    } else {
        $auth_data['rp'] = false;
        $auth_data['solo'] = false;
        $auth_data['tempy'] = false;
        $auth_data['elite'] = false;
        $auth_data['tempy_mod'] = false; 
        $auth_data['lw'] = false;  
        $auth_data['citadel'] = false;
        $auth_data['star'] = false; 
        $auth_data['dojo'] = false;  
        $auth_data['sheet'] = false; 
        $auth_data['ro'] = false; 
        $auth_data['aa'] = false;
        $auth_data['arena'] = false;
        $auth_data['irc'] = false;
        $auth_data['survival'] = false;
        $auth_data['ch'] = false;
    }
    
    if ($pos->GetID() == 11 || $pos->GetID() == 12){
	    $auth_data['ch'] = true;
    }
    
    if ($hunter->GetID() == $ladder->CurrentMaster()){
	    $auth_data['dojo'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $ladder->CurrentSteward()){
	    $auth_data['arena'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $survival->CurrentRanger()){
	    $auth_data['survival'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $starfield->CurrentSkipper()){
	    $auth_data['star'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $ro->CurrentMM()){
	    $auth_data['ro'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $sheet->CurrentRegistrar()){
	    $auth_data['sheet'] = true;
	    $auth_data['aa'] = true;
    }
    
    /*Elite RP nonsense.    
    if (in_array($hunter->GetID(), $tempy->ActiveMods())){
	    $auth_data['tempy_mod'] = true;
    }
    
    if (in_array($hunter->GetID(), $tempy->Members())){
	    $auth_data['tempy'] = true;
	    $auth_data['elite'] = true;
    }
    
    if (in_array($hunter->GetID(), $ttg->Winners())){
	    $auth_data['fin_ttg'] = true;
	    $auth_data['elite'] = true;
    }

    if (in_array($hunter->GetID(), $tempy->Solidified())){
	    $auth_data['tempy_sub'] = true;
	    $auth_data['elite'] = true;
    }
    */
    
    if (in_array($hunter->GetID(), $lw->Members())){
	    $auth_data['lw'] = true;
    }
    
    if ($hunter->GetID() == $solo->CurrentComissioner()){
	    $auth_data['solo'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $irca->CurrentHC()){
	    $auth_data['irc'] = true;
	    $auth_data['aa'] = true;
    }
    
    return $auth_data;
}

function admin_footer($auth_data) {
	global $roster, $arena, $library, $at, $iat, $sat, $citadel;
	
	$person = new Person($auth_data['id']);
	$posi = $person->GetPosition();
	
	if ($posi->GetID() == 29) {
		$tests = $citadel->GetExamsMarkedBy($arena->Overseer());
	} elseif ($posi->GetID() == 9){
		$tests = $citadel->GetExamsMarkedBy($arena->Adjunct());
	}
	
	echo '</td><td style="border-left: solid 1px black">';
	
	echo '<small>';
	echo '<br /><b>External Links</b><br />';
	echo '&nbsp;<a href="' . internal_link('atn_general', array('id'=>$person->GetID())) . '">View&nbsp;My&nbsp;Profile</a><br />';
	echo '&nbsp;<a href="' . internal_link('acn_challenge', array('id'=>$person->GetID())) . '">Network&nbsp;Control</a><br />';
	echo '<br /><b>Hunter Options</b><br />';
	echo '&nbsp;<a href="' . internal_link('admin_sheet', array('id'=>$person->GetID())) . '">Edit&nbsp;My&nbsp;Sheet</a><br />';
	echo '&nbsp;<a href="' . internal_link('admin_sheet_backup', array('id'=>$person->GetID())) . '">Sheet&nbsp;Backups</a><br />';
	echo '&nbsp;<a href="' . internal_link('admin_sheet_core') . '">Edit&nbsp;Core&nbsp;Sheets</a><br />';
	
	if ($auth_data['ch']){
	    echo '<br /><b>Chief&nbsp;Resources</b><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_ch_npc') . '">Generate&nbsp;NPC</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_ch_xp') . '">Award&nbsp;Experience&nbsp;Points</a><br />';
    }
	
	if ($auth_data['citadel']){
		echo '<br /><b>Pending&nbsp;Citadel&nbsp;Exams</b><br />';
	    foreach ($tests as $value){
		    echo '<a target="citadel" href="http://citadel.thebhg.org/admin/grade/'. $value->GetAbbrev() .'">' . $value->CountPending().' '
		    	.$value->GetAbbrev().' exams</a><br />';
	    }
    }
    
	if ($auth_data['aa']){
		echo '<br /><b>Arena&nbsp;System&nbsp;Management</b><br />';   
        echo '<br />General&nbsp;Management<br />';
        if ($auth_data['rp']){
        	echo '&nbsp;<a href="' . internal_link('admin_location') . '">Modify&nbsp;Arena&nbsp;Locations</a><br />';
        	echo '&nbsp;<a href="' . internal_link('admin_teta_award') . '">Award&nbsp;Teta\'s&nbsp;Knives</a><br />';	    
	    	echo '&nbsp;<a href="' . internal_link('admin_teta_remove') . '">Remove&nbsp;Teta\'s&nbsp;Knives</a><br />';
	    	echo '&nbsp;<a href="' . internal_link('admin_approve_xp') . '">Approve&nbsp;CH&nbsp;XP</a><br />';
    	}
        echo '&nbsp;<a href="' . internal_link('admin_xp') . '">Award&nbsp;Experience&nbsp;Points</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_credits') . '">Award&nbsp;Credits</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_medals') . '">Award&nbsp;Medals</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_npc') . '">Generate&nbsp;NPC</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_sheet_blank') . '">Insert&nbsp;Blank&nbsp;Sheet</a><br />';
	    
	    echo '<br />Polls<br />';
        echo '&nbsp;<a href="' . internal_link('admin_poll') . '">New&nbsp;Poll</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_poll_edit') . '">Edit&nbsp;Poll</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_poll_ban') . '">Ban&nbsp;Users</a><br />';
	    
	    echo '<br />Reports<br />';
        echo '&nbsp;<a href="' . internal_link('admin_report') . '">Add&nbsp;Report</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_edit_report') . '">Edit&nbsp;Report</a><br />';
    }
    
    if ($auth_data['overseer']) {   
	    echo '<br />Overseer&nbsp;Utilities<br />';
	    echo '&nbsp;<a href="' . internal_link('admin_lyarna') . '">Property&nbsp;Management</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_demerit') . '">Issue&nbsp;Demerit&nbsp;Points</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_bp') . '">Award&nbsp;Bonus&nbsp;Points</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_backup_manage') . '">Edit&nbsp;Sheet&nbsp;Backups</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_overseer') . '">Edit&nbsp;Overseer</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_adjunct') . '">Edit&nbsp;Adjunct</a><br />';
    }
	    
    if ($auth_data['rp']) {      
        echo '<br />RP&nbsp;Aides<br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_commish') . '">Edit&nbsp;Solo&nbsp;Comissioner</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_dojo_master') . '">Edit&nbsp;Dojo&nbsp;Master</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_registrar') . '">Edit&nbsp;OCD&nbsp;Registrar</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_mission_master') . '">Edit&nbsp;Mission&nbsp;Master</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_steward') . '">Edit&nbsp;Arena&nbsp;Steward</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_skipper') . '">Edit&nbsp;Starfield&nbsp;Skipper</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_commentator') . '">Edit&nbsp;Holonet&nbsp;Commentator</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_ranger') . '">Edit&nbsp;Ranger</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_salaries') . '">Pay&nbsp;Aides</a><br />';
    }
    
    if ($auth_data['sheet']){
        echo '<br />Character&nbsp;Sheets<br />';
        echo '&nbsp;<a href="' . internal_link('admin_sheet_list') . '">Edit&nbsp;Character&nbsp;Sheets</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_sheet_core') . '">Edit&nbsp;Core&nbsp;Sheets</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_field') . '">Create&nbsp;New&nbsp;Field</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_stat') . '">Create&nbsp;New&nbsp;Statribute</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_skill') . '">Create&nbsp;New&nbsp;Skill</a><br />';        
        echo '&nbsp;<a href="' . internal_link('admin_equation') . '">Create&nbsp;New&nbsp;Variable</a><br />';
    }
    
    if ($auth_data['arena']) {    
        echo '<br />Arena&nbsp;System<br />';
        echo '&nbsp;<a href="' . internal_link('admin_arena_old') . '">Add&nbsp;Match</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_arena_faceoff') . '">Add&nbsp;Ladder&nbsp;Faceoff</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_arena_complete') . '">Complete&nbsp;Match</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_arena_editor') . '">Edit&nbsp;Match</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_arena_post') . '">Post&nbsp;New&nbsp;Match</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_arena_pending') . '">View&nbsp;Pending&nbsp;Matches</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_arena_recent') . '">View&nbsp;Recent&nbsp;Matches</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_arena_type') . '">Edit&nbsp;Types</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_arena_weapons') . '">Edit&nbsp;Weapon&nbsp;Types</a><br />';
        
        echo '<br />Arena&nbsp;Tournament<br />';
        if (count($at->GetHunters())){
	        echo '&nbsp;<a href="' . internal_link('admin_tournament_wildcard') . '">Declare&nbsp;Wildcard</a><br />';
	        echo '&nbsp;<a href="' . internal_link('admin_tournament_manage') . '">Manage&nbsp;Signups</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_tournament_random') . '">Randomize&nbsp;Brackets</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_tournament_organize') . '">Organize&nbsp;Brackets</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_tournament_atn') . '">Add&nbsp;Round&nbsp;to&nbsp;ATN</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_tournament_round') . '">Enter&nbsp;Round&nbsp;Stats</a><br />';
    	}
    	echo '&nbsp;<a href="' . internal_link('admin_tournament_new') . '">Start&nbsp;New&nbsp;Season</a><br />';
    }
    
    if ($auth_data['survival']){
	    echo '<br />Survival&nbsp;Missions<br />';
	    echo '&nbsp;<a href="' . internal_link('admin_survival_creature') . '">Creature&nbsp;Maker</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_survival_creature_editor') . '">Creature&nbsp;Editor</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_survival_complete') . '">Complete&nbsp;a&nbsp;Mission</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_survival_dco_reassign') . '">Manage&nbsp;Failed&nbsp;Missions</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_survival_dco') . '">Declare&nbsp;Failed&nbsp;Mission</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_survival_editor') . '">Edit&nbsp;Missions</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_survival_approve') . '">Process&nbsp;Requested&nbsp;Mission</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_survival_post') . '">Post&nbsp;New&nbsp;Mission</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_survival_dco_post') . '">Post&nbsp;Requested&nbsp;Failed&nbsp;Mission</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_survival_retire') . '">Process&nbsp;Retired&nbsp;Mission</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_survival_type') . '">Edit&nbsp;Types</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_survival_grade') . '">Edit&nbsp;Grades</a><br />';
    }
    
    if ($auth_data['irc']){
        echo '<br />IRC&nbsp;Arena&nbsp;System<br />';
        echo '&nbsp;<a href="' . internal_link('admin_irca_pending') . '">Pending&nbsp;Matches</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_irca_complete') . '">Complete&nbsp;Match</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_irca_add_match') . '">Add&nbsp;Match&nbsp;Text</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_irca_faceoff') . '">Add&nbsp;Ladder&nbsp;Faceoff</a><br />';
        
        echo '<br />IRC Arena&nbsp;Tournament<br />';
        if (count($iat->GetHunters())){
	        echo '&nbsp;<a href="' . internal_link('admin_irc_tournament_wildcard') . '">Declare&nbsp;Wildcard</a><br />';
	        echo '&nbsp;<a href="' . internal_link('admin_irc_tournament_manage') . '">Manage&nbsp;Signups</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_irc_tournament_random') . '">Randomize&nbsp;Brackets</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_irc_tournament_organize') . '">Organize&nbsp;Brackets</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_irc_tournament_atn') . '">Add&nbsp;Round&nbsp;to&nbsp;ATN</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_irc_tournament_round') . '">Enter&nbsp;Round&nbsp;Stats</a><br />';
    	}
    	echo '&nbsp;<a href="' . internal_link('admin_irc_tournament_new') . '">Start&nbsp;New&nbsp;Season</a><br />';
    } 
    
    if ($auth_data['ro']){
	    echo '<br />Run&nbsp;On&nbsp;System<br />';
        echo '&nbsp;<a href="' . internal_link('admin_ro_new') . '">Make&nbsp;New&nbsp;Run-On</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_ro_edit') . '">Edit&nbsp;a&nbsp;Run-On</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_ro_post') . '">Post&nbsp;a&nbsp;Run-On</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_ro_complete') . '">Complete&nbsp;Run-On</a><br />';
    }
    
    if ($auth_data['dojo']){	    
	    echo '<br />Dojo&nbsp;of&nbsp;Shadows<br />';
        echo '&nbsp;<a href="' . internal_link('admin_dojo_post') . '">Post&nbsp;New&nbsp;Match</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_dojo_complete') . '">Complete&nbsp;Dojo&nbsp;Match</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_dojo_graduate') . '">Declare&nbsp;Dojo&nbsp;Graduate</a><br />';
    }
    
    if ($auth_data['rp']){
	    echo '&nbsp;<a href="' . internal_link('admin_dojo_retrain') . '">Declare&nbsp;Dojo&nbsp;Retraining</a><br />';
    }
    
    if ($auth_data['solo']){	    	    
	    echo '<br />Solo&nbsp;Contracts<br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_complete') . '">Complete&nbsp;a&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_dco_reassign') . '">Manage&nbsp;Dead&nbsp;Contracts</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_dco') . '">Declare&nbsp;Dead&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_editor') . '">Edit&nbsp;Contracts</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_approve') . '">Process&nbsp;Requested&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_post') . '">Post&nbsp;New&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_dco_post') . '">Post&nbsp;Requested&nbsp;Dead&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_retire') . '">Process&nbsp;Retired&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_type') . '">Edit&nbsp;Types</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_solo_grade') . '">Edit&nbsp;Grades</a><br />';
        
        echo '<br />Lone&nbsp;Wolf&nbsp;Contracts<br />';
        echo '&nbsp;<a href="' . internal_link('admin_lw_members') . '">Edit&nbsp;Lone&nbsp;Wolves</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_lw_complete') . '">Complete&nbsp;a&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_lw_dco_reassign') . '">Manage&nbsp;Dead&nbsp;Contracts</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_lw_dco') . '">Declare&nbsp;Dead&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_lw_editor') . '">Edit&nbsp;Contracts</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_lw_approve') . '">Process&nbsp;Requested&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_lw_post') . '">Post&nbsp;New&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_lw_dco_post') . '">Post&nbsp;Requested&nbsp;Dead&nbsp;Contract</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_lw_retire') . '">Process&nbsp;Retired&nbsp;Contract</a><br />';
    }
    
    if ($auth_data['star']) {
    	echo '<br />Starfield&nbsp;Arena&nbsp;System<br />';
        echo '&nbsp;<a href="' . internal_link('admin_starfield_complete') . '">Complete&nbsp;Match</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_starfield_editor') . '">Edit&nbsp;Match</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_starfield_post') . '">Post&nbsp;New&nbsp;Match</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_starfield_pending') . '">View&nbsp;Pending&nbsp;Matches</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_starfield_recent') . '">View&nbsp;Recent&nbsp;Matches</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_starfield_type') . '">Edit&nbsp;Types</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_starfield_setting') . '">Edit&nbsp;Settings</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_starfield_restriction') . '">Edit&nbsp;Restrictions</a><br />';
        
        echo '<br />Starfield Arena&nbsp;Tournament<br />';
        if (count($sat->GetHunters())){
	        echo '&nbsp;<a href="' . internal_link('admin_sa_tournament_wildcard') . '">Declare&nbsp;Wildcard</a><br />';
	        echo '&nbsp;<a href="' . internal_link('admin_sa_tournament_manage') . '">Manage&nbsp;Signups</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_sa_tournament_random') . '">Randomize&nbsp;Brackets</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_sa_tournament_organize') . '">Organize&nbsp;Brackets</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_sa_tournament_atn') . '">Add&nbsp;Round&nbsp;to&nbsp;ATN</a><br />';
    		echo '&nbsp;<a href="' . internal_link('admin_sa_tournament_round') . '">Enter&nbsp;Round&nbsp;Stats</a><br />';
    	}
    	echo '&nbsp;<a href="' . internal_link('admin_sa_tournament_new') . '">Start&nbsp;New&nbsp;Season</a><br />';
    }
    
    if ($auth_data['rp']) {	            
        echo '<br />Arena&nbsp;Manuals&nbsp;Admin<small><br />';
    
        $shelf = new Shelf(6);
        
	    $shelf_title = str_replace(' ', '&nbsp;', $shelf->GetName());
		echo '&nbsp;<a href="' . internal_link('admin_shelf', array('id'=>$shelf->GetID()), 'library') . '">' . $shelf_title . '</a><small>';
		foreach ($shelf->GetBooks() as $book) {
			echo '<br />';
			$title = str_replace(' ', '&nbsp;', $book->GetTitle());
			echo '&nbsp;&nbsp;<a href="' . internal_link('admin_book', array('id'=>$book->GetID()), 'library') . '">' . $title . '</a>';
		}		
	}
	
	/*
	All the elite RP is gone (TTG) or needs reworking, so, it's gone.
	if ($auth_data['elite']) {
	    echo '<br /><br /><b>Elite&nbsp;Role-Play&nbsp;Groups</b><br />';
    }
	
	if ($auth_data['tempy_sub']){
		echo '<br />Tempestuous&nbsp;Group&nbsp;Applications<br />';
		echo '&nbsp;<b><a href="' . internal_link('admin_tempy_submit') . '">Submit&nbsp;Required&nbsp;Works</a></b><br />';
	}
    
    if ($auth_data['tempy']) {
	    echo '<br />Tempestuous&nbsp;Board<br />';
        echo '&nbsp;<a href="' . internal_link('admin_tempy_jury') . '">Jury&nbsp;Selection</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_tempy_manage') . '">Manage&nbsp;My&nbsp;Signups</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_tempy_vote') . '">Review&nbsp;And&nbsp;Vote</a><br />';
    }
    
    if ($auth_data['tempy_mod']) {
	    echo '<br />Tempestuous&nbsp;Board&nbsp;Admin<br />';
	    echo '&nbsp;<a href="' . internal_link('admin_tempy_members') . '">Eject&nbsp;Member</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_tempy_mods') . '">Edit&nbsp;Moderators</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_tempy_pending') . '">Pending&nbsp;Admission&nbsp;Requests</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_tempy_signups') . '">Edit&nbsp;Jury&nbsp;Signups</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_tempy_solidify') . '">Solidify&nbsp;Jury</a><br />';
    }
    */

    echo '</small></td></tr></table>';
}

?>