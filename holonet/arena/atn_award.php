<?php
if (isset($_REQUEST['id'])){
	$hunter = new Person($_REQUEST['id']);
}

function title() {
    global $hunter;

    $return = 'AMS Tracking Network :: Administrative History';
    
    if (is_object($hunter)){
	    $return .= ' :: ' . $hunter->GetName();
    }
    
    return $return;
}

function output() {
    global $arena, $hunter, $sheet, $roster;

    arena_header();

    echo '<a href="'.internal_link('atn_general', array('id'=>$hunter->GetID())).'">Back to '.$hunter->GetName().'\'s General Tracking</a>';
    
    hr();
    
    if (is_object($hunter)){
    
	    $comiss = new Comissioner($hunter->GetID());
	    $master = new Master($hunter->GetID());
	    $regist = new Registrar($hunter->GetID());
	    $missio = new MissionMaster($hunter->GetID());
	    $overse = new Overseer($hunter->GetID());
	    $adjunc = new Adjunct($hunter->GetID());
	    $stewar = new Steward($hunter->GetID());
	    $skippe = new Skipper($hunter->GetID());
	    $commen = new Commentator($hunter->GetID());
	    $ranger = new Ranger($hunter->GetID());
	    
	    if ($ranger->GetStatus() || $commen->GetStatus() || $comiss->GetStatus() || $master->GetStatus() || $regist->GetStatus() || $stewar->GetStatus() || $skippe->GetStatus() || $missio->GetStatus() || $overse->GetStatus() || $adjunc->GetStatus()){
		    $cred_total = $ranger->GetCreds()+$commen->GetCreds()+$stewar->GetCreds()+$skippe->GetCreds()+$overse->GetCreds()+$adjunc->GetCreds()+$comiss->GetCreds()+$master->GetCreds()+$regist->GetCreds()+$missio->GetCreds();
		    $xp_total = $ranger->GetXP()+$commen->GetXP()+$stewar->GetXP()+$skippe->GetXP()+$overse->GetXP()+$adjunc->GetXP()+$comiss->GetXP()+$master->GetXP()+$regist->GetXP()+$missio->GetXP();
		    $meda_total = $ranger->GetMedals()+$commen->GetMedals()+$stewar->GetMedals()+$skippe->GetMedals()+$overse->GetMedals()+$adjunc->GetMedals()+$comiss->GetMedals()+$master->GetMedals()+$regist->GetMedals()+$missio->GetMedals();		    
		    
		    echo '<a name="total"></a>';
		    $table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Total Contributions', 2);
		    $table->EndRow();
		    if ($cred_total || $xp_total || $meda_total){
			    if ($cred_total){ $table->AddRow('Credits Awarded:', number_format($cred_total).' Imperial Credits'); }
			    if ($xp_total) { $table->AddRow('Experience Points Awarded:', number_format($xp_total)); }
			    if ($meda_total) { $table->AddRow('Medals Awarded:', number_format($meda_total)); }
		    } else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    }
		    $table->EndTable();
		    echo '<br />';
		    
		    hr();
	    } else {
		    echo 'This hunter has not made any tracked contributions to the awards in the Arena.';
	    }
	    
	    if ($overse->GetStatus()){
			
		    echo '<a name="overseer"></a>';
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Overseer of the Guild', 3);
		    $table->EndRow();
		    if ($overse->GetCreds() || $overse->GetXP() || $overse->GetMedals() || $overse->OVCreds() || $overse->OVXP() || $overse->OVMedal()){
			    if ($overse->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($overse->GetCreds()).' Imperial Credits'); }
			    if ($overse->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($overse->GetXP())); }
			    if ($overse->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($overse->GetMedals())); }
			    if ($overse->OVCreds()){ $table->AddRow('Credits Overseen in Administration:', number_format($overse->OVCreds()).' Imperial Credits'); }
			    if ($overse->OVXP()){ $table->AddRow('Experience Points Overseen in Administration:', number_format($overse->OVXP())); }
			    if ($overse->OVMedal()){ $table->AddRow('Medal Awards Overseen in Administration:', number_format($overse->OVMedal())); }
			} else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    } 
		    $table->EndTable();
		    echo '<br />';
		    
		    hr();
	    }
	    
	    if ($adjunc->GetStatus()){
			
		    echo '<a name="adjunct"></a>';
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Adjunct of the Guild', 2);
		    $table->EndRow();
		    if ($adjunc->GetCreds() || $adjunc->GetXP() || $adjunc->GetMedals()){
			    if ($adjunc->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($adjunc->GetCreds()).' Imperial Credits'); }
			    if ($adjunc->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($adjunc->GetXP())); }
			    if ($adjunc->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($adjunc->GetMedals())); }
			} else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    }
		    $table->EndTable();
		    echo '<br />';
		    
		    hr();
	    }
	    
	    if ($stewar->GetStatus()){
			
		    echo '<a name="steward"></a>';
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Steward of the Arena', 2);
		    $table->EndRow();
		    if ($stewar->GetMatches() || $stewar->GetCreds() || $stewar->GetXP() || $stewar->GetMedals()){
			    if ($stewar->GetMatches()){ $table->AddRow('Matches Run:', number_format($stewar->GetMatches())); }
			    if ($stewar->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($stewar->GetCreds()).' Imperial Credits'); }
			    if ($stewar->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($stewar->GetXP())); }
			    if ($stewar->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($stewar->GetMedals())); }
		    } else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    }
		    $table->EndTable();
		    echo '<br />';
		    
		    hr();
	    }
	    
	    if ($master->GetStatus()){
			
		    echo '<a name="dojo"></a>';
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Master of the Dojo of Shadows', 2);
		    $table->EndRow();
		    if ($master->GetMatches() || $master->GetCreds() || $master->GetXP() || $master->GetMedals()){
			    if ($master->GetMatches()){ $table->AddRow('Matches Run:', number_format($master->GetMatches())); }
			    if ($master->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($master->GetCreds()).' Imperial Credits'); }
			    if ($master->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($master->GetXP())); }
			    if ($master->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($master->GetMedals())); }
		    } else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    }
		    $table->EndTable();
		    echo '<br />';
		    
		    hr();
	    }
	    
	    if ($commen->GetStatus()){
			
		    echo '<a name="commentator"></a>';
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Holonet Commentator of the IRC Arena', 2);
		    $table->EndRow();
		    if ($commen->GetMatches() || $commen->GetCreds() || $commen->GetXP() || $commen->GetMedals()){
			    if ($commen->GetMatches()){ $table->AddRow('Matches Run:', number_format($commen->GetMatches())); }
			    if ($commen->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($commen->GetCreds()).' Imperial Credits'); }
			    if ($commen->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($commen->GetXP())); }
			    if ($commen->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($commen->GetMedals())); }
		    } else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    }
		    $table->EndTable();
		    echo '<br />';
		    
		    hr();
	    }
	    
	    if ($skippe->GetStatus()){
			
		    echo '<a name="skipper"></a>';
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Skippers of the Starfield Arena', 2);
		    $table->EndRow();
		    if ($skippe->GetMatches() || $skippe->GetCreds() || $skippe->GetXP() || $skippe->GetMedals()){
			    if ($skippe->GetMatches()){ $table->AddRow('Matches Run:', number_format($skippe->GetMatches())); }
			    if ($skippe->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($skippe->GetCreds()).' Imperial Credits'); }
			    if ($skippe->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($skippe->GetXP())); }
			    if ($skippe->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($skippe->GetMedals())); }
		    } else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    }
		    $table->EndTable();
		    echo '<br />';
		    
		    hr();
	    }
	    
	    if ($missio->GetStatus()){
			
		    echo '<a name="mission"></a>';
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Mission Master of Run-Ons', 2);
		    $table->EndRow();
		    if ($missio->GetROs() || $missio->GetXP() || $missio->GetCreds() || $missio->GetMedals()){
			    if ($missio->GetROs()){ $table->AddRow('Run-Ons Moderated:', number_format($missio->GetROs())); }
			    if ($missio->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($missio->GetCreds()).' Imperial Credits'); }
			    if ($missio->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($missio->GetXP())); }
			    if ($missio->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($missio->GetMedals())); }
		    } else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    }
		    $table->EndTable();
		    echo '<br />';
		    
		    hr();
	    }
	    
		if ($comiss->GetStatus()){
			
			echo '<a name="commiss"></a>';
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Commissioner of the Bounty Office', 2);
		    $table->EndRow();
		    if ($comiss->GetContracts() || $comiss->GetCreds() || $comiss->GetXP() || $comiss->GetMedals()){
			    if ($comiss->GetContracts()){ $table->AddRow('Contracts Overseen:', number_format($comiss->GetContracts())); }
			    if ($comiss->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($comiss->GetCreds()).' Imperial Credits'); }
			    if ($comiss->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($comiss->GetXP())); }
			    if ($comiss->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($comiss->GetMedals())); }
			} else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    }
		    $table->EndTable();
		    echo '<br />';
		    
		    hr();
	    }
	    
	    if ($ranger->GetStatus()){
			
			echo '<a name="ranger"></a>';
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Survival Mission Ranger', 2);
		    $table->EndRow();
		    if ($ranger->GetContracts() || $ranger->GetCreds() || $ranger->GetXP() || $ranger->GetMedals()){
			    if ($ranger->GetContracts()){ $table->AddRow('Contracts Overseen:', number_format($ranger->GetContracts())); }
			    if ($ranger->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($ranger->GetCreds()).' Imperial Credits'); }
			    if ($ranger->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($ranger->GetXP())); }
			    if ($ranger->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($ranger->GetMedals())); }
			} else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    }
		    $table->EndTable();
		    echo '<br />';
		    
		    hr();
	    }
	    
	    if ($regist->GetStatus()){
			
		    echo '<a name="registrar"></a>';
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Office of Character Development Registrar', 2);
		    $table->EndRow();
		    if ($regist->GetCreds() || $regist->GetXP() || $regist->GetMedals() || $regist->Saves() || $regist->Submit() || $regist->BP() || 
		    $regist->Kill() || $regist->Approve() || $regist->Ban() || $regist->Deny() || $regist->NewSheet()) {
			    if ($regist->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($regist->GetCreds()).' Imperial Credits'); }
			    if ($regist->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($regist->GetXP())); }
			    if ($regist->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($regist->GetMedals())); }
			    if ($regist->NewSheet()){ $table->AddRow('New Sheets Under Administration:', number_format($regist->NewSheet())); }
			    if ($regist->Deny()){ $table->AddRow('Denied Sheets Under Administration:', number_format($regist->Deny())); }
			    if ($regist->Ban()){ $table->AddRow('Edit Bans Under Administration:', number_format($regist->Ban())); }
			    if ($regist->Approve()){ $table->AddRow('Approved Sheets Under Administration:', number_format($regist->Approve())); }
			    if ($regist->Kill()){ $table->AddRow('Killed Sheets Under Administration:', number_format($regist->Kill())); }
			    if ($regist->BP()){ $table->AddRow('Purchased Bonus Points Under Administration:', number_format($regist->BP())); }
			    if ($regist->Submit()){ $table->AddRow('Submitted Sheets Under Administration:', number_format($regist->Submit())); }
			    if ($regist->Saves()){ $table->AddRow('Sheet Saves Under Administration:', number_format($regist->Saves())); }
		    } else {
			    $table->StartRow();
			    $table->AddCell('<center>No Contributions Made</center>');
			    $table->EndRow();
		    }
		    $table->EndTable();
		    echo '<br />';
		    
	    }
		
	}
    
    arena_footer();
}
?>