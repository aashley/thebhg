<?php

function title() {
    return 'AMS Challenge Network';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $sheet, $citadel, $page;

    arena_header();
	
    echo 'Welcome, ' . $hunter->GetName() . '.';

    if ($sheet->HasSheet($hunter->GetID())){
    
		if (isset($_REQUEST['at-id'])) {
			echo '<br />';
			$at = new Tournament($_REQUEST['at-id']);
			if ($at->season){
				if ($_REQUEST['del']){
					if ($at->DeleteSignup($hunter->GetID())){
						echo 'Signup delted successfully.';
					} else {
						echo 'Error deleting signup.';
					}
				} else {
					if ($at->signup($hunter->GetID())){
						echo 'Signup successful.';
					} else {
						echo $at->denied;
					}
				}
			}
		}				
	    
    hr();
	    
    $pending = $arena->Search(array('table'=>'ams_records', 'search'=>array('date_deleted'=>'0', 'bhg_id'=>$hunter->GetID(), 'outcome'=>0)));
	    
    $pendings = array();
    $cancha = array();
    $exams = array();
    $lists = array();
	  $chal = array();

	  foreach ($pending as $obj){	
		  $act = new Obj('ams_match', $obj->Get('match'), 'holonet');
			$type = new Obj('ams_types', $act->Get('type'), 'holonet');
			if ((!$act->Get('accepted') && !$act->Get('date_deleted') && $type->Get('opponent')) || !$type->Get('opponent')){
				$pendings[$act->Get('type')][] = $act;
			}
			$yes = false;
			if (!$obj->Get('challenger')){
				$yes = true;
			}
			$chanca[$act->Get('id')] = $yes;
			foreach ($arena->Search(array('table'=>'ams_records', 'search'=>array('date_deleted'=>'0', 'match'=>$obj->Get('match'), 'outcome'=>0))) as $yarm){		   
				if ($yarm->Get('bhg_id') != $hunter->GetID()){				    
					$chal[$act->Get('id')] = new Person($yarm->Get('bhg_id'));
				}
			}
		}
		
		$courses = $citadel->GetPersonsResults($hunter, CITADEL_PASSED);
		
		foreach ($courses as $course){
			$exam = $course->GetExam();
			$exams[] = $exam->GetID();
		}
		
		$search = $arena->Search(array('table'=>'ams_lists', 'search'=>array('date_deleted'=>'0', 'bhg_id'=>$hunter->GetID())));
		foreach ($search as $list){
			$lists[] = $list->Get('list');
		}
		
		$activities = $arena->Search(array('table'=>'ams_activities', 'search'=>array('date_deleted'=>'0'), 'order'=>array('type'=>'ASC', 'name'=>'ASC')));
		foreach ($activities as $obj){
			$go = false;
			$chk = new Obj('ams_types', $obj->Get('type'), 'holonet');
			if ($chk->Get('request')){
				$check = $arena->Search(array('table'=>'ams_restrict', 'search'=>array('date_deleted'=>'0', 'activity'=>$obj->Get('id'))));
				if (count($check)){
					foreach ($check as $val){
						$c = 0;
						
						if ($val->Get('course')){
							if (in_array($val->Get('course'), $exams)){
								$go = true;
							} else {
								$go = false;
							}
							$c++;
						}

						if ($val->Get('list')){
							if (in_array($val->Get('list'), $lists)){
								$go = true;
							} else {
								$go = false;
							}
							$c++;
						}
						
						if ($val->Get('position')){
							$posi = $hunter->GetPosition();
							if ($val->Get('position') == $posi->GetID()){
								$go = true;
							} else {
								$go = false;
							}
							$c++;
						}
						
						if ($val->Get('rank')){
							$rank = $hunter->GetRank();
							if ($val->Get('rank') == $rank->GetID()){
								$go = true;
							} else {
								$go = false;
							}
							$c++;
						}
						
						if ($val->Get('division')){
							$divi = $hunter->GetDivision();
							if ($val->Get('division') == $divi->GetID()){
								$go = true;
							} else {
								$go = false;
							}
							$c++;
						}
						
						if (!$c){
							$go = true;
						}
					}
				} else {
					$go = true;
				}
			} else {
				$go = false;
			}
			
			if ($go){
				$table = new Table();
				$type = new Obj('ams_types', $obj->Get('type'), 'holonet');
				$table->StartRow();
				$table->AddHeader('<center>'.$obj->Get('name').' <small>(<a href="' . internal_link('acn_challenge', array('id'=>$obj->Get('id'))) . '">'.($type->Get('submit') ? 'Submit Match' : ($type->Get('opponent') ? 'Issue Challenge' : 'Request Mission')).'</a>)</small></center>', 2);
				$table->EndRow();
				
				$table->StartRow();
				$table->AddCell($obj->Get('desc'), 2);
				$table->EndRow();
				$content = array('Match Type'=>$chk->Get('name'));
				
				foreach ($content as $na=>$fi){
					$table->StartRow();
					$table->AddCell($na.':');
					$table->AddCell($fi);
					$table->EndRow();
				}
			    
		    $table->EndTable();
			    
		    $at = new Tournament($obj->Get('id'));
		    
		    if (!$at->Ended() && $at->season){
			    echo '<p>';
			    $table = new Table();
			    $table->StartRow();
			    $table->AddHeader('Tournament');
			    $table->EndRow();
				    
			    if ($at->CanSignup($hunter->GetID())){
			    	$table->AddRow('<a href="'.internal_link($page, array('at-id'=>$obj->Get('id'))).'">Sign Up!</a>');
		    	} else {
			    	$table->AddRow('You are signed up for this tournament. <a href="'.internal_link($page, array('at-id'=>$obj->Get('id'), 'del'=>1)).'">Remove Me</a>');
		    	}
		    	echo $table->EndTable();
			    	
		    }
			    
		    if (isset($pendings[$obj->Get('id')]) && count($pendings[$obj->Get('id')])){
			    echo '<p>';
				    
			    $table = new Table('', true);
			    
			    $builds = array();
					
					foreach ($arena->Search(array('table'=>'ams_event_builds', 'search'=>array('date_deleted'=>'0', 'activity'=>$obj->Get('id'), 'grade'=>0))) as $ob){
						$new = new Obj('ams_specifics_types', $ob->Get('resource'), 'holonet');
						$builds[addslashes($new->Get('name'))] = $new;
					}
					
					ksort($builds);				    
					
					$span = count($builds)+3+$type->Get('opponent');
					
					$table->StartRow();
					$table->AddHeader('<center>Pending '.$obj->Get('name').' Events</center>', $span);
			    $table->EndRow();				    
				    
			    if (count($builds)){
				    $table->StartRow();
				    ($type->Get('opponent') ? $table->AddCell('Opponent') : '');
				    $table->AddCell('Topic ID');
				    foreach ($builds as $build){
					    foreach ($arena->Search(array('table'=>'ams_specifics_types', 'search'=>array('date_deleted'=>'0', 'id'=>$build->Get('id')))) as $ob) {
								$table->AddCell($ob->Get('name'));
							}
						}
						$table->AddCell('&nbsp;');
						$table->AddCell('&nbsp;');
						$table->EndRow();
					}
					
					foreach ($pendings[$obj->Get('id')] as $ja=>$match){
						if (count($builds)){
							$data = unserialize($match->Get('specifics'));
							$table->StartRow();
							($type->Get('opponent') ? $table->AddCell($chal[$match->Get('id')]->GetName()) : '');
							$table->AddCell(($match->Get('mbid') ? mb_link($match->Get('mbid')) : 'Unposted'));
							foreach ($builds as $build){
								if ($build->Get('multiple')){
									$print = array();
									if (is_array($data[$build->Get('id')])){
										foreach ($data[$build->Get('id')] as $valu){
											$info = new Obj('ams_specifics', $valu, 'holonet');
											$print[] = $info->Get('name');
										}
										$table->AddCell(implode("<br />", $print));
									} else {
										$table->AddCell('None');
									}
								} else {
									$info = new Obj('ams_specifics', $data[$build->Get('id')], 'holonet');
									$table->AddCell($info->Get('name'));
								}
							}
							
							$use = ($chanca[$match->Get('id')] && $type->Get('opponent'));
							$started = ($match->Get('accepted') && $match->Get('started'));
							if ($use){
								if ($match->Get('accepted')){
									$table->AddCell('Pending Posting', 2);
								} else {
									$table->AddCell('<a href="'.internal_link('acn_pending', array('id'=>$match->Get('id'), 'op'=>'acc')).'">Accept</a>');
									$table->AddCell('<a href="'.internal_link('acn_pending', array('id'=>$match->Get('id'), 'op'=>'den')).'">Deny</a>');
								}
							} else {
								if ($started && !$chanca[$match->Get('id')] && !$type->Get('opponent')){
									$table->AddCell('<a href="'.internal_link('acn_pending', array('id'=>$match->Get('id'), 'op'=>'ret')).'">Retire</a>');
									$table->AddCell(($match->Get('to_date') ? 'Extension Requested' : '<a href="'.internal_link('acn_pending', array('id'=>$match->Get('id'), 'op'=>'ext')).'">Extension</a>'));
								} else {
									$table->AddCell('Pending Acceptance', 2);
								}
							}
							$table->EndRow();
						}
					}
					
					$table->EndTable();
				}
				hr();
			}
		}
	    
	} else {	    
	    echo 'You need a Character Sheet to use this module. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();

}
?>
