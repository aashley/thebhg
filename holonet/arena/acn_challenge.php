<?php

function title() {
    return 'AMS Challenge Network :: Challenges';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
    global $arena, $hunter, $roster, $page, $auth_data, $sheet, $at, $iat;

    arena_header();

    $ladder = new Ladder();
    $starfield = new Starfield();
    
    $sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){
    
	    hr();
	    
	    if ($at->ValidSignup()){
			echo '<b>A<u>rena Tournamen</u>t</b><br />';
		    echo '<a href="' . internal_link('acn_tournament_signup') . '">Signup&nbsp;For&nbsp;Tournament</a>';
		    hr();
		}
		
		if ($iat->ValidSignup()){
			echo '<b>I<u>RC Arena Tournamen</u>t</b><br />';
		    echo '<a href="' . internal_link('acn_irc_tournament_signup') . '">Signup&nbsp;For&nbsp;Tournament</a>';
		    hr();
		}
	    
	    echo '<b>T<u>he Aren</u>a</b>';
	    
	    echo '<br /><a href="'.internal_link('acn_arena_challenge').'">Make Arena Challenge</a>';
	
	    $challenges = $ladder->Pending($hunter->GetID());
	
	    if (count($challenges)) {
		    echo '<p>';
	        $table = new Table('Pending Challenges', true);
	        $table->StartRow();
	        $table->AddHeader('Challenger');
	        $table->AddHeader('Match Type');
	        $table->AddHeader('Location');
	        $table->AddHeader('Weapon Type');
	        $table->AddHeader('Num. of Weapons');
	        $table->AddHeader('Posts');
	        $table->AddHeader('&nbsp;', 2);
	        $table->EndRow();
	        foreach($challenges as $value) {
	            $type = $value->GetType();
	            $challenger = $value->GetChallenger();
	            $weapon = $value->GetWeaponType();
	            $location = $value->GetLocation();
	            
	            $table->StartRow();
	            $table->AddCell('<a href="' . internal_link('hunter', array('id'=>$challenger->GetID()), 'roster') . '">' . $challenger->GetName() . '</a>');
	            $table->AddCell($type->GetName());
	            $table->AddCell($location->GetName());
	            $table->AddCell($weapon->GetWeapon());
	            $table->AddCell($value->GetWeapons());
	            $table->AddCell($value->GetPosts());
	            $table->AddCell('<a href="' . internal_link('acn_arena_accept', array('id'=>$value->GetID())) . '">Accept</a>');
	            $table->AddCell('<a href="' . internal_link('acn_arena_decline', array('id'=>$value->GetID())) . '">Decline</a>');
	            $table->EndRow();
	        }
	        $table->EndTable();
	    }
	
	    /*
	    Commented Out until the SA is fixed
	    hr();
	
	    echo '<b>S<u>tarfield Aren</u>a</b>';
		echo '<br /><a href="'.internal_link('acn_starfield_challenge').'">Make Starfield Challenge</a><br />';
		
	    $challenges = $starfield->Pending($hunter->GetID());
	
	    if (count($challenges)) {
		    echo '<p>';
	        $table = new Table('Pending Challenges', true);
	        $table->StartRow();
	        $table->AddHeader('Challenger');
	        $table->AddHeader('Challenger Ship');
	        $table->AddHeader('Your Ship');
	        $table->AddHeader('Location');
	        $table->AddHeader('Match Type');
	        $table->AddHeader('Settings');
	        $table->AddHeader('Restrictions');
	        $table->AddHeader('Posts');
	        $table->AddHeader('&nbsp;', 2);
	        $table->EndRow();
	        foreach($challenges as $value) {
	            $type = $value->GetType();
	            $challenger = $value->GetChallenger();
	            $challengee = $value->GetChallengee();
	            $location = $value->GetLocation();
	            $setting = $value->GetSettings();
	            $table->StartRow();
	            $table->AddCell('<a href="' . internal_link('hunter', array('id'=>$challenger->GetID()), 'roster') . '">' . $challenger->GetName() . '</a>');
	            $table->AddCell($challenger->GetShipLink());
	            $table->AddCell($challengee->GetShipLink());
	            if ($value->HasLocation()){
	                $table->AddCell($location->GetName());
	            } else {
	                $table->AddCell($value->GetLocation());
	            }
	            $table->AddCell($type->GetName());
	            $table->AddCell($setting->GetName());
	            $table->AddCell($value->WriteRestrictions());
	            $table->AddCell($value->GetPosts());
	            $table->AddCell('<a href="' . internal_link('acn_starfield_accept', array('id'=>$value->GetID())) . '">Accept</a>');
	            $table->AddCell('<a href="' . internal_link('acn_starfield_decline', array('id'=>$value->GetID())) . '">Decline</a>');
	            $table->EndRow();
	        }
	        $table->EndTable();
	    }
	    */
	    
	    hr();
	    
	    echo '<b>S<u>olo Mission</u>s</b>';
	    $hunter = new Hunter($hunter->GetID());
	    $dco = $hunter->DCOPenalty();
	    
	    if ($dco){
		    $date = getdate($dco);
	    	echo '<br />You are currently under the Dead Contract penalty. You cannot request contracts until this ban expires.<br />'
	    		.'This ban will end on: '.$date['month']." ".$date['mday'].", ".$date['year'];
    	} else {
		    echo '<br /><a href="'.internal_link('acn_solo_contract').'">Request a New Contract</a>';
		    echo '<br /><a href="'.internal_link('acn_solo_dco').'">Request a Dead Contract</a>';
	    }
	    
	    if (count($hunter->Contracts())){
		    echo '<p>';
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Pending Contracts', 3);
		    $table->EndRow();
		    $table->AddRow('Difficulty', 'Contract ID', '&nbsp');
		    
	        foreach ($hunter->Contracts() as $value) {
		        $type = $value->GetType();
		        $table->AddRow($type->GetName(), $value->GetContractID(), '<a href="'.internal_link('acn_solo_retire', array('contract'=>$value->GetID())).'">Retire Contract</a>');
	        }
	        
	        $table->EndTable();
        }
        
        if ($auth_data['lw']){
	        hr();
		    
		    echo '<b>L<u>one Wolf Mission</u>s</b>';
		    $hunter = new LW_Hunter($hunter->GetID());
		    $dco = $hunter->DCOPenalty();
	    
		    if ($dco){
			    $date = getdate($dco);
		    	echo '<br />You are currently under the Dead Contract penalty. You cannot request contracts until this ban expires.<br />'
		    		.'This ban will end on: '.$date['month']." ".$date['mday'].", ".$date['year'];
	    	} else {
			    echo '<br /><a href="'.internal_link('acn_solo_contract').'">Request a New Contract</a>';
			    echo '<br /><a href="'.internal_link('acn_solo_dco').'">Request a Dead Contract</a>';
		    }
		    
		    $hunter = new LW_Hunter($hunter->GetID());
		    
		    if (count($hunter->Contracts())){
			    echo '<p>';
			    $table = new Table('', true);
			    $table->StartRow();
			    $table->AddHeader('Pending Contracts', 3);
			    $table->EndRow();
			    $table->AddRow('Contract ID', '&nbsp');
			    
		        foreach ($hunter->Contracts() as $value) {
			        $table->AddRow($value->GetContractID(), '<a href="'.internal_link('acn_solo_retire', array('contract'=>$value->GetID())).'">Retire Contract</a>');
		        }
		        
		        $table->EndTable();
	        }
        }
        
        hr();
        
        echo '<b>S<u>urvival Mission</u>s</b>';
	    $hunter = new SurvivalHunter($hunter->GetID());
	    $dco = $hunter->DCOPenalty();
	    
	    if ($dco){
		    $date = getdate($dco);
	    	echo '<br />You are currently under the Failed Mission penalty. You cannot request missions until this ban expires.<br />'
	    		.'This ban will end on: '.$date['month']." ".$date['mday'].", ".$date['year'];
    	} else {
		    echo '<br /><a href="'.internal_link('acn_survival_contract').'">Request a New Mission</a>';
		    echo '<br /><a href="'.internal_link('acn_survival_dco').'">Request a Failed Mission</a>';
	    }
	    
	    if (count($hunter->Contracts())){
		    echo '<p>';
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Pending Missions', 3);
		    $table->EndRow();
		    $table->AddRow('Difficulty', 'Contract ID', '&nbsp');
		    
	        foreach ($hunter->Contracts() as $value) {
		        $type = $value->GetType();
		        $table->AddRow($type->GetName(), $value->GetContractID(), '<a href="'.internal_link('acn_survival_retire', array('contract'=>$value->GetID())).'">Retire Mission</a>');
	        }
	        
	        $table->EndTable();
        }
        
        hr();
        echo '<b>I<u>RC Aren</u>a</b>';
        echo '<br /><a href="' . internal_link('acn_irca_submit') . '">Submit&nbsp;Match</a><br />';
	    
	} else {	    
	    echo 'You need a Character Sheet to challenge anyone. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();

}
?>
