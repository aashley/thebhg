<?php
if (isset($_REQUEST['id'])){
	$hunter = new Person($_REQUEST['id']);
}

function title() {
    global $hunter;

    $return = 'AMS Tracking Network';
    
    if (is_object($hunter)){
	    $return .= ' :: Hunter Information :: ' . $hunter->GetName();
    }
    
    return $return;
}

function output() {
    global $arena, $hunter, $sheet, $roster;

    arena_header();

    if (is_object($hunter)){
    
	    $arena_ladder = new Details();
	    $starfield_ladder = new StarfieldDetails();
	    $solo = new Solo();
	    $irca = new IRCADetails();
	    $at = new Tournament();
	    $lw = new LW_Solo();
	    $ttg = new TTG();
	    $tempy = new Tempy();
	
	    echo '<table border=0 width="100%"><tr valign="top"><td rowspan="3">';
	    
	    echo '<a name="stats"></a>';
	    $table = new Table();
	    $table->StartRow();
	    $table->AddHeader('Personal Profile', 2);
	    $table->EndRow();
	    $table->AddRow('Name:', '<a href="' . internal_link('hunter', array('id'=>$hunter->GetID()), 'roster') . '">' . $hunter->GetName() . '</a>');   
	    $table->AddRow('ID Line:', $hunter->IDLine(0));
	    $table->AddRow('Stat Tracker:', '<a href="' . internal_link('atn_match_stats', array('id'=>$hunter->GetID())) . '">View Arena Stats</a>'); 
	    $table->AddRow('Experience History:', '<a href="' . internal_link('point_history', array('id'=>$hunter->GetID())) . '">View Arena History</a>');
	    
	    $arr = $arena_ladder->Search($hunter->GetID());
	    $sar = $starfield_ladder->Search($hunter->GetID());
	    $sor = $solo->Search($hunter->GetID());
	    $lwr = $lw->Search($hunter->GetID());
	    $irr = $irca->Search($hunter->GetID());
	    $tgc = $ttg->QueueHistory($hunter->GetID());
	    
	    if ($arr){ $table->AddRow('Arena Ladder Rank:', $arr); }
	    if ($sar){ $table->AddRow('Starfield Arena Ladder Rank:', $sar); }
	    if ($sor){ $table->AddRow('Solo Mission Ladder Rank:', $sor); }
	    if ($lwr){ $table->AddRow('Lone Wolf Mission Ladder Rank:', $lwr); }
	    if ($irr){ $table->AddRow('IRC Arena Ladder Rank:', $irr); }
	    if ($tgc){ $table->AddRow('Twilight Gauntlet Challenges:', $tgc); }
	    
	    $plural = '';
	    
	    if ($at->IsGladius($hunter->GetID())){
		    if ($at->IsGladius($hunter->GetID()) > 1){ 
			    $plural = 's';
		    }
		    $table->AddRow('Achieved Gladius Prime:', $at->IsGladius($hunter->GetID()).' time'.$plural);
	    }
	    
	    $table->EndTable();
	    
	    echo '</td><td align="center"><div style="text-align: left">';
	
	    $ttgm = false;
	    $tempym = false;
	    
	    if (in_array($hunter->GetID(), $ttg->Members())){
		    $ttgm = true;
	    }
	
	    if (in_array($hunter->GetID(), $tempy->Members())){
		    $tempym = true;
	    }
	    
	    if ($ttgm || $tempym){
		    $table = new Table();
			$table->StartRow();
			$table->AddHeader('Elite Arena Divisions', 2);
			$table->EndRow();
		}
	    
	    if ($ttgm){
		    $table->StartRow();
		    $table->AddCell('<a href="' . internal_link('atn_ttg', array('id'=>$hunter->GetID())) . '">Twilight Gauntlet Member</a>', 2);
		    $table->EndRow();
	    }
	    
	    if ($tempym){
		    $table->StartRow();
		    $table->AddCell('<a href="' . internal_link('atn_tempy', array('id'=>$hunter->GetID())) . '">Tempestuous Board Member</a>', 2);
		    $table->EndRow();
	    }    
	    
	    if ($ttgm || $tempym){
	    	$table->EndTable();
		}
	    
	    echo '</div></td></tr><tr><td><div style="text-align: left">';
	    
	    $comiss = new Comissioner($hunter->GetID());
	    $master = new Master($hunter->GetID());
	    
	    $boc = $comiss->GetStatus();
	    $djm = $master->GetStatus();
	    
	    if ($boc || $djm){
		    
		    $table = new Table();
		    
		    $table->StartRow();
		    $table->AddHeader('Arena Aide Positions', 2);
		    $table->EndRow();
		    
		    if ($boc){
			    $table->StartRow();
		    	$table->AddCell($boc.'of the Bounty Office', 2);
		    	$table->EndRow();
			}
			
			if ($djm){
			    $table->StartRow();
		    	$table->AddCell($djm.'Master of the Dojo of Shadows', 2);
		    	$table->EndRow();
			}
			
			$table->EndTable();
			
		}
	    
	    echo '</div></td></tr></table>';
	
	    hr();
	    
	    $character = new Character($hunter->GetID());
	    
	    $character->ParseSheet();
	    
    }
    
    arena_footer();
}
?>