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
	    $aas = array();
	
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
		
	    if ($ove){ $aas[$ove.'Overseer of the Guild'] = array('pic'=>'ov', 'page'=>'atn_award', 'anch'=>'overseer'); $aa = true;}
		if ($adj){ $aas[$adj.'Adjunct of the Guild'] = array('pic'=>'aj', 'page'=>'atn_award', 'anch'=>'adjunct'); $aa = true;}
	    if ($djm){ $aas[$djm.'Master of the Dojo of Shadows'] = array('pic'=>'dojoofshadows', 'page'=>'atn_award', 'anch'=>'dojo'); $aa = true;}
		if ($boc){ $aas[$boc.'of the Bounty Office'] = array('pic'=>'bountyoffice', 'page'=>'atn_award', 'anch'=>'commiss'); $aa = true;}
		if ($reg){ $aas[$reg.'Registrar of the Office of Character Development'] = array('pic'=>'ocd', 'page'=>'atn_award', 'anch'=>'registrar'); $aa = true;}
		if ($mis){ $aas[$mis.'Mission Master of Run-Ons'] = array('pic'=>'mm', 'page'=>'atn_award', 'anch'=>'mission'); $aa = true;}
		if ($ski){ $aas[$ski.'Skipper of the Starfield Arena'] = array('pic'=>'skipper', 'page'=>'atn_award', 'anch'=>'skipper'); $aa = true;}
		if ($ste){ $aas[$ste.'Steward of the Arena'] = array('pic'=>'steward', 'page'=>'atn_award', 'anch'=>'steward'); $aa = true;}
		if ($com){ $aas[$com.'Holonet Commentator of the IRC Arena'] = array('pic'=>'hc', 'page'=>'atn_award', 'anch'=>'commentator'); $aa = true;}
		if ($ran){ $aas[$ran.'Survival Mission Ranger'] = array('pic'=>'ranger', 'page'=>'atn_award', 'anch'=>'ranger'); $aa = true;}
	    
		if ($hunter->GetID() == 2650){ $rewards['Arena Management System Coder']['pic'] = 'coder'; }
		if ($at->IsGladius($hunter->GetID())){ $rewards['Achieved Gladius Prime '.pluralise('Time', $at->IsGladius($hunter->GetID()))]['pic'] = 'gladius'; }
	    if (in_array($hunter->GetID(), $arena->GetTeta())){ $rewards['Owner of Teta\'s Knives']['pic'] = 'dagger'; }	
		if ($properties){ $rewards['Owns '.pluralise('piece', $properties).' of property in Lyarna.'] = array('pic'=>'lyarna', 'page'=>'atn_lyarna'); }
		if (in_array($hunter->GetID(), $arena->GetApproved())){ $rewards['Graduate of the Dojo of Shadows']['pic'] = 'dojo'; }
		if ($aa) { $rewards['Contributions to the Arena'] = array('pic'=>'contrib', 'page'=>'atn_award', 'anch'=>'total'); }
		
	    
	    echo '<table border=0 width="100%"><tr valign="top"><td rowspan="3">';
	    
	    echo '<a name="stats"></a>';
	    $table = new Table();
	    $table->StartRow();
	    $table->AddHeader('Personal Profile', 2);
	    $table->EndRow();
	    $table->AddRow('Name:', '<a href="' . internal_link('hunter', array('id'=>$hunter->GetID()), 'roster') . '">' . $hunter->GetName() . '</a>');   
	    $table->AddRow('ID Line:', $hunter->IDLine(0));
	    $table->AddRow('Stat Tracker:', '<a href="' . internal_link('atn_match_stats', array('id'=>$hunter->GetID())) . '">Arena Match Stats</a>'); 
	    $table->AddRow('Experience History:', '<a href="' . internal_link('point_history', array('id'=>$hunter->GetID())) . '">Experience/BP History</a>');
	    
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

	    $table->EndTable();
	    
	    echo '</td><td align="center"><div style="text-align: left">';
	
	    /*Elite references. Blecho.
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
	    */
		
	    if (count($aas)){			
			$setups = array();
			
			echo '<h4>Arena Aide Positions</h4>';
			
			foreach ($aas as $info=>$reward){		
				if (!$reward['page']){
					$reward['page'] = $page;
				}
				$setups[] = '<a href="'.internal_link($reward['page'], array('id'=>$hunter->GetID())).'#'.$reward['anch'].'" title="'.$info.
							'"><img border=0 src="arena/images/distinctions/'.$reward['pic'].'.png"></a>';				
			}
			
			for ($i = 0; $i < count($setups); $i += 5) {
				echo implode('', array_slice($setups, $i, 5)).'<br />';
			}
		}
	    
		if (count($rewards)){
			
			if (count($aas)){
				hr();
			}
			
			echo '<h4>Personal Stats</h4>';
			
			$setups = array();
			
			foreach ($rewards as $info=>$reward){		
				if (!$reward['page']){
					$reward['page'] = $page;
				}
				$setups[] = '<a href="'.internal_link($reward['page'], array('id'=>$hunter->GetID())).'#'.$reward['anch'].'" title="'.$info.
							'"><img border=0 src="arena/images/distinctions/'.$reward['pic'].'.png"></a>';				
			}
			
			for ($i = 0; $i < count($setups); $i += 5) {
				echo implode('', array_slice($setups, $i, 5)).'<br />';
			}
		}
	    
	    echo '</div></td></tr></table>';
	
	    hr();
	    
	    $character = new Character($hunter->GetID());
	    
	    $character->ParseSheet();
	    
    }
    
    arena_footer();
}
?>