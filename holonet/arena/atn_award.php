<?php
if (isset($_REQUEST['id'])){
	$hunter = new Person($_REQUEST['id']);
}

function title() {
    global $hunter;

    $return = 'AMS Tracking Network :: Awarding History';
    
    if (is_object($hunter)){
	    $return .= ' :: ' . $hunter->GetName();
    }
    
    return $return;
}

function output() {
    global $arena, $hunter, $sheet, $roster;

    arena_header();

    if (is_object($hunter)){
    
	    $comiss = new Comissioner($hunter->GetID());
	    $master = new Master($hunter->GetID());
	    $regist = new Registrar($hunter->GetID());
	    $missio = new MissionMaster($hunter->GetID());
	    $overse = new Overseer($hunter->GetID());
	    $adjunc = new Adjunct($hunter->GetID());
	    
	    if ($comiss->GetStatus() || $master->GetStatus() || $regist->GetStatus() || $missio->GetStatus() || $overse->GetStatus() || $adjunc->GetStatus()){
		    $cred_total = $overse->GetCreds()+$adjunc->GetCreds()+$comiss->GetCreds()+$master->GetCreds()+$regist->GetCreds()+$missio->GetCreds();
		    $xp_total = $overse->GetXP()+$adjunc->GetXP()+$comiss->GetXP()+$master->GetXP()+$regist->GetXP()+$missio->GetXP();
		    $meda_total = $overse->GetMedals()+$adjunc->GetMedals()+$comiss->GetMedals()+$master->GetMedals()+$regist->GetMedals()+$missio->GetMedals();		    
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
	    
		if ($comiss->GetStatus()){
			
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
	    
	    if ($master->GetStatus()){
			
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
	    
	    if ($regist->GetStatus()){
			
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Office of Character Development Registrar', 2);
		    $table->EndRow();
		    if ($regist->GetCreds() || $regist->GetXP() || $regist->GetMedals()) {
			    if ($regist->GetCreds()){ $table->AddRow('Credits Awarded:', number_format($regist->GetCreds()).' Imperial Credits'); }
			    if ($regist->GetXP()){ $table->AddRow('Experience Points Awarded:', number_format($regist->GetXP())); }
			    if ($regist->GetMedals()){ $table->AddRow('Medals Awarded:', number_format($regist->GetMedals())); }
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
		
	}
    
    arena_footer();
}
?>