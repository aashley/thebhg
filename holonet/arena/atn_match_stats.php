<?php
if (isset($_REQUEST['id'])){
	$hunter = new Person($_REQUEST['id']);
}

function title() {
    global $hunter;

    $return = 'AMS Tracking Network :: Stats Tracker';
    
    if (is_object($hunter)){
	    $return .= ' :: ' . $hunter->GetName();
    }
    
    return $return;
}

function output() {
    global $arena, $hunter, $sheet, $roster;

    arena_header();

    if (is_object($hunter)){
    
	    $arena_ladder = new Stats($hunter->GetID());
	    $starfield_ladder = new StarfieldStats($hunter->GetID());
	    $solo = new Hunter($hunter->GetID());
	    $irca = new IRCAStats($hunter->GetID());
	    $lw = new LW_Hunter($hunter->GetID());
	
	    $table = new Table();
	    $table->StartRow();
	    $table->AddHeader('Arena Stats', 2);
	    $table->EndRow();
	    $table->AddRow('Arena Matches:', $arena_ladder->GetMatches());
	    $table->AddRow('Arena Credits:', number_format($arena_ladder->GetCredits()).' Imperial Credits');
	    $table->AddRow('Arena Expirence Points:', number_format($arena_ladder->GetXP()));
	    $table->EndTable();
	
	    if ($arena_ladder->GetMatches()){
		    echo '<br /><a name="matches"></a>';
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Arena Matches', 3);
		    $table->EndRow();
		
	    	$table->AddRow('Match', 'Result', 'Links');
	
	    	foreach($arena_ladder->ReadMatches() as $value){
		    	$fighter = new Fighter($hunter->GetID(), $value->GetID());
	     	   $table->AddRow('Match '.$value->GetMatchID(), $fighter->GetResult(), '<a href="' . internal_link('atn_arena_match', array('id'=>$value->GetID())) . '">ATN Stats</a> | '.$value->ArenaLink());
	    	}
		
		    $table->EndTable();
	
		}
		
		hr();
		
		$table = new Table();
	    $table->StartRow();
	    $table->AddHeader('Starfield Arena Stats', 2);
	    $table->EndRow();
	    $table->AddRow('Starfield Arena Matches:', $starfield_ladder->GetMatches());
	    $table->AddRow('Starfield Arena Credits:', number_format($starfield_ladder->GetCredits()).' Imperial Credits');
	    $table->AddRow('Starfield Arena Expirence Points:', number_format($starfield_ladder->GetXP()));
	    $table->EndTable();
		
		if ($starfield_ladder->GetMatches()){
		    echo '<br /><a name="matches"></a>';
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Starfield Arena Matches', 3);
		    $table->EndRow();
		    $table->AddRow('Match', 'Result', 'Links');
		
		    foreach($starfield_ladder->ReadMatches() as $value){
			    $fighter = new StarfieldFighter($hunter->GetID(), $value->GetID());
		        $table->AddRow('Match '.$value->GetMatchID(), $fighter->GetResult(), '<a href="' . internal_link('atn_starfield_match', array('id'=>$value->GetMatchID())) . '">ATN Stats</a> | '.$value->ArenaLink());
		    }
		
		    $table->EndTable();
	
	    }
	    
		hr();
		
		$comish = new Comissioner($hunter->GetID());
		
		if ($comish->GetStatus()){
			
			$table = new Table();
		    $table->StartRow();
		    $table->AddHeader('Commissioner Stats', 2);
		    $table->EndRow();
		    $table->AddRow('Contracts Overseen:', $comish->GetContracts());
		    $table->AddRow('Credits Awarded:', number_format($comish->GetCreds()).' Imperial Credits');
		    $table->AddRow('Expirence Points Awarded:', number_format($comish->GetXP()));
		    $table->EndTable();
		    echo '<br />';
	    }		
		
		$table = new Table();
	    $table->StartRow();
	    $table->AddHeader('Solo Mission Stats', 2);
	    $table->EndRow();
	    $table->AddRow('Contracts Completed:', $solo->GetContracts()+$lw->GetContracts());
	    $table->AddRow('Contract Credits:', number_format($solo->GetCredits()+$lw->GetCredits()).' Imperial Credits');
	    $table->AddRow('Contract Expirence Points:', number_format($solo->GetXP()+$lw->GetXP()));
	    $table->EndTable();
	
	    if ($solo->GetContracts()){
		    echo '<br /><a name="matches"></a>';
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Solo Mission Contracts', 3);
		    $table->EndRow();
		    $table->AddRow('Match', 'Result', 'Links');
		
		    foreach($solo->ReadContracts() as $value){
			    $grade = $value->GetGrade();
		        $table->AddRow('Contract '.$value->GetContractID(), $grade->GetName(), '<a href="' . internal_link('atn_solo_contract', array('id'=>$value->GetID())) . '">ATN Stats</a> | '.$value->ArenaLink());
		    }
		
		    $table->EndTable();
	    }
	    
	    if ($lw->GetContracts()){
		    echo '<br /><a name="matches"></a>';
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Lone Wolf Mission Contracts', 3);
		    $table->EndRow();
		    $table->AddRow('Match', 'Result', 'Links');
		
		    foreach($lw->ReadContracts() as $value){
			    $grade = $value->GetGrade();
		        $table->AddRow('Contract '.$value->GetContractID(), $grade->GetName(), '<a href="' . internal_link('atn_lw_contract', array('id'=>$value->GetID())) . '">ATN Stats</a> | '.$value->ArenaLink());
		    }
		
		    $table->EndTable();
	    }
	    
	    hr();
	    
	    $table = new Table();
	    $table->StartRow();
	    $table->AddHeader('IRC Arena Stats', 2);
	    $table->EndRow();
	    $table->AddRow('IRC Arena Matches:', $irca->GetMatches());
	    $table->AddRow('IRC Arena Credits:', number_format($irca->GetCredits()).' Imperial Credits');
	    $table->AddRow('IRC Arena Expirence Points:', number_format($irca->GetXP()));
	    $table->EndTable();
	
	    if ($irca->GetMatches()){
		    echo '<br /><a name="matches"></a>';
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('IRC Arena Matches', 3);
		    $table->EndRow();
		
	    	$table->AddRow('Match', 'Result', 'Links');
	
	    	foreach($irca->ReadMatches() as $value){
		       $fighter = new IRCAFighter($hunter->GetID(), $value->GetID());
	     	   $table->AddRow('Match '.$value->GetID(), $fighter->GetResult(), '<a href="' . internal_link('atn_irca_match', array('id'=>$value->GetID())) . '">ATN Stats</a>');
	    	}
		
		    $table->EndTable();
	
		}
		
	}
    
    arena_footer();
}
?>