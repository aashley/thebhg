<?php 

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
	echo '&nbsp;<a href="' . internal_link('admin_sheet_backup', array('id'=>$person->GetID())) . '">Sheet&nbsp;Saves&nbsp;and&nbsp;Cores</a><br />';
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
    
    if ($auth_data['coder']){
	    echo '<br /><b>Coder&nbsp;Resources</b><br />';
	    echo '&nbsp;<a href="' . internal_link('coder_mod') . '">Add&nbsp;CS&nbsp;Modifcation</a><br />';
	    echo '&nbsp;<a href="' . internal_link('coder_mod_mod') . '">Modify&nbsp;CS&nbsp;Modifcation</a><br />';
	    echo '&nbsp;<a href="' . internal_link('coder_mod_ss') . '">Modify&nbsp;Mod&nbsp;Skill/Stats</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_nec') . '">Add&nbsp;NEC&nbsp;Code</a><br />';	    
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
        echo '&nbsp;<a href="' . internal_link('admin_cas') . '">Award/Delete&nbsp;Character&nbsp;Attributes</a><br />';
        
        echo '<br />Character&nbsp;Sheet&nbsp;Development<br />';
  		echo '&nbsp;<a href="' . internal_link('admin_field') . '">Create&nbsp;New&nbsp;Field</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_stat') . '">Create&nbsp;New&nbsp;Statribute</a><br />';
	    echo '&nbsp;<a href="' . internal_link('admin_skill') . '">Create&nbsp;New&nbsp;Skill</a><br />';        
        echo '&nbsp;<a href="' . internal_link('admin_equation') . '">Create&nbsp;New&nbsp;Variable</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_sheet_ss') . '">Modify&nbsp;Shown&nbsp;Stats</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_sheet_fo') . '">Modify&nbsp;Field&nbsp;Order</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_ca') . '">Create&nbsp;Character&nbsp;Attribute</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_ca_stats') . '">Attribute&nbsp;Stat&nbsp;Modifier</a><br />';
        echo '&nbsp;<a href="' . internal_link('admin_edit_ca') . '">Edit&nbsp;Character&nbsp;Attribute</a><br />';
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
        echo '&nbsp;<a href="' . internal_link('admin_ro_cadre') . '">Cadre&nbsp;Run-Ons</a><br />';
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