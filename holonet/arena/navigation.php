<?php

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

?>