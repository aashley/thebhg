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
    global $arena, $hunter, $sheet, $roster, $page;

    arena_header();

    if (is_object($hunter)){
    
	    $properties = count($arena->MyProperties($hunter));
	    
	    $arena_ladder = new Details();
	    $starfield_ladder = new StarfieldDetails();
	    $solo = new Solo();
	    $irca = new IRCADetails();
	    $at = new Tournament();
	    $lw = new LW_Solo();
	    $ttg = new TTG();
	    $tempy = new Tempy();
	    $ro = new RODetails();
	    $survival = new Survival();
	    $rewards = array();
	
	    $comiss = new Comissioner($hunter->GetID());
	    $master = new Master($hunter->GetID());
	    $regist = new Registrar($hunter->GetID());
	    $missio = new MissionMaster($hunter->GetID());
	    $overse = new Overseer($hunter->GetID());
	    $adjunc = new Adjunct($hunter->GetID());
	    $skippe = new Skipper($hunter->GetID());
	    $stewar = new Steward($hunter->GetID());
	    $commen = new Commentator($hunter->GetID());
	    $ranger = new Ranger($hunter->GetID());
	    
	    $boc = $comiss->GetStatus();
	    $djm = $master->GetStatus();
	    $reg = $regist->GetStatus();
	    $mis = $missio->GetStatus();
	    $ove = $overse->GetStatus();
	    $adj = $adjunc->GetStatus();
	    $ski = $skippe->GetStatus();
	    $ste = $stewar->GetStatus();
	    $com = $commen->GetStatus();
	    $ran = $ranger->GetStatus();
	    
	    if ($ove){ $rewards[$ove.'Overseer of the Guild'] = array('pic'=>'ov', 'page'=>'atn_award', 'anch'=>'overseer');}
		if ($adj){ $rewards[$adj.'Adjunct of the Guild'] = array('pic'=>'aj', 'page'=>'atn_award', 'anch'=>'adjunct');}
		if ($djm){ $rewards[$djm.'Master of the Dojo of Shadows'] = array('pic'=>'dojoofshadows', 'page'=>'atn_award', 'anch'=>'dojo');}
		if ($boc){ $rewards[$boc.'of the Bounty Office'] = array('pic'=>'bountyoffice', 'page'=>'atn_award', 'anch'=>'commiss');}
		if ($reg){ $rewards[$reg.'Registrar of the Office of Character Development'] = array('pic'=>'ocd', 'page'=>'atn_award', 'anch'=>'registrar');}
		if ($mis){ $rewards[$mis.'Mission Master of Run-Ons'] = array('pic'=>'mm', 'page'=>'atn_award', 'anch'=>'mission');}
		if ($ski){ $rewards[$ski.'Skipper of the Starfield Arena'] = array('pic'=>'skipper', 'page'=>'atn_award', 'anch'=>'skipper');}
		if ($ste){ $rewards[$ste.'Steward of the Arena'] = array('pic'=>'steward', 'page'=>'atn_award', 'anch'=>'steward');}
		if ($com){ $rewards[$com.'Holonet Commentator of the IRC Arena'] = array('pic'=>'hc', 'page'=>'atn_award', 'anch'=>'commentator');}
		if ($ran){ $rewards[$ran.'Survival Mission Ranger'] = array('pic'=>'ranger', 'page'=>'atn_award', 'anch'=>'ranger');}
	    
	    echo '<table border=0 width="100%"><tr valign="top"><td>';
	    
	    echo '<a name="stats"></a>';
	    $table = new Table();
	    $table->StartRow();
	    $table->AddHeader('Personal Profile', 2);
	    $table->EndRow();
	    $table->AddRow('Name:', '<a href="' . internal_link('hunter', array('id'=>$hunter->GetID()), 'roster') . '">' . $hunter->GetName() . '</a>');   
	    $table->AddRow('ID Line:', $hunter->IDLine(0));
	    $table->AddRow('Stat Tracker:', '<a href="' . internal_link('atn_match_stats', array('id'=>$hunter->GetID())) . '">Arena Match Stats</a>'); 
	    $table->AddRow('Character History:', '<a href="' . internal_link('point_history', array('id'=>$hunter->GetID())) . '">Experience/BP History</a>');
	    if (count($rewards)){ $table->AddRow('Administrative History:', '<a href="' . internal_link('atn_award', array('id'=>$hunter->GetID())) . '">Credits/Medals/XP Awarding History</a>'); }
	    
	    $arr = $arena_ladder->Search($hunter->GetID());
	    //$sar = $starfield_ladder->Search($hunter->GetID());
	    $sor = $solo->Search($hunter->GetID());
	    $lwr = $lw->Search($hunter->GetID());
	    $irr = $irca->Search($hunter->GetID());
	    $tgc = $ttg->QueueHistory($hunter->GetID());
	    $rod = $ro->Search($hunter->GetID());
	    $sur = $survival->Search($hunter->GetID());
	    
	    if ($arr){ $table->AddRow('Arena Ladder Rank:', $arr); }
	    //if ($sar){ $table->AddRow('Starfield Arena Ladder Rank:', $sar); }
	    if ($sor){ $table->AddRow('Solo Mission Ladder Rank:', $sor); }
	    if ($lwr){ $table->AddRow('Lone Wolf Mission Ladder Rank:', $lwr); }
	    if ($irr){ $table->AddRow('IRC Arena Ladder Rank:', $irr); }
	    if ($rod){ $table->AddRow('Run On Ladder Rank:', $rod); }
	    if ($tgc){ $table->AddRow('Twilight Gauntlet Challenges:', pluralise('Time', $tgc)); }
	    if ($sur){ $table->AddRow('Survival Mission Ladder Rank:', $sur); }

	    if ($properties){ $table->AddRow('Property in Lyarna:', '<a href="'.internal_link('atn_lyarna', array('id'=>$hunter->GetID())).'">Owns '.pluralise('Piece', $properties).' of Property</a>'); }
		$table->AddRow('Dojo of Shadows', (in_array($hunter->GetID(), $arena->GetApproved()) ? 'Graduate of' : 'Learner in').'the Dojo of Shadows');
		if ($at->IsGladius($hunter->GetID())){ 
			$table->AddRow('Gladius Prime', 'Achieved Gladius Prime '.pluralise('Time', $at->IsGladius($hunter->GetID()))); 
		}
	    if (in_array($hunter->GetID(), $arena->GetTeta())){ 
		    $table->AddRow('Arena Designation:', 'Owns Teta\'s Knives'); 
		}	
		
	    $table->EndTable();
	    
	    echo '</td><td align="center"><div style="text-align: left">';
		
		if (count($rewards)){			
			$table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Arena Administrative Positions');
		    $table->EndRow();
			
			foreach ($rewards as $info=>$reward){
				$table->AddRow('<a href="'.internal_link($reward['page'], array('id'=>$hunter->GetID())).'#'.$reward['anch'].'">'.$info.'</a>');	
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