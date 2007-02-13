<?php

if ($_REQUEST['match']){
	function display(){
		global $activity, $arena, $type, $roster, $page, $mb, $hunter;

		if ($type->Get('multiple')){
			if ($_REQUEST['submit']){
				$obj = new Obj('ams_match', $_REQUEST['match'], 'holonet');
				$builds = array();
		    
			    foreach ($arena->Search(array('table'=>'ams_event_builds', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get('id'), 'grade'=>0))) as $bojj){
				    $new = new Obj('ams_specifics_types', $bojj->Get('resource'), 'holonet');
				    $builds[addslashes($new->Get('name'))] = $new;
			    }
			    
			    ksort($builds);
			    
			    $data = unserialize($obj->Get('specifics'));
			    foreach ($builds as $build){
				    foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$build->Get('id')))) as $jobj) {
				        if ($jobj->Get('medal')){
					        $medal = $jobj->Get('medal');
				        }
				    }
			    }
			    
			    for ($i = 1; $i <= $_REQUEST['num']; $i++) {
      
					$person = "person$i";
					
					if ($_REQUEST[$person] > 0){
						$awarded = $roster->GetPerson($_REQUEST[$person]);
						$awarded->SendEmail(from(), 'Event Completed', "Your performance in an RP event has been graded.");
						$character = new Character($awarded->GetID());
			        	$character->XPEvent($_REQUEST['chalr_xp'][$i], $obj->Get('name'));
			        	$awarded->AddCredits($_REQUEST['chalr_cred'][$i], $obj->Get('name'));
			        	$yay = 0;
						if ($_REQUEST['first'] == $i){
							$mb->AwardMedal($awarded, $hunter, next_medal($awarded, $medal), 'First Place in '.$obj->Get('name'));
							$yay = $medal;
						}
						$arena->NewRow(array('table'=>'ams_records', 'values'=>array($obj->Get('id'), $awarded->GetID(), 1, $_REQUEST['chalr_cred'][$i], $_REQUEST['chalr_xp'][$i], $_REQUEST['chalr_result'][$i], $yay), 'fields'=>array('match', 'bhg_id', 'challenger', 'creds', 'xp', 'outcome', 'medal')));
					}
					
				}
				$obj->Edit(array('completed'=>time(), 'comments'=>$_REQUEST['comments']), 1);
				echo 'Event Completed.';
			} elseif ($_REQUEST['build']){
				$form = new Form($page);
				$bar_maid = $_REQUEST['num'];
				$form->AddHidden('num', $_REQUEST['num']);
				include_once 'multiple.php';
				$form->AddHidden('id', $_REQUEST['id']);
				$form->AddHidden('op', $_REQUEST['op']);
				$form->AddHidden('match', $_REQUEST['match']);
				
				if ($type->Get('submit')){
					$obj = new Obj('ams_match', $_REQUEST['match'], 'holonet');
					$form->AddTextArea('Comments:', 'comments', $mat->Get('comments'));
				}
				
				$form->AddSubmitButton('submit', 'Award Awards');
				$form->EndForm();
			} else {
				$form = new Form($page);
				$form->AddTextBox('Number of Participants:', 'num', '', 5);
				$form->AddSubmitButton('build', 'Enter Awards');
				$form->AddHidden('id', $_REQUEST['id']);
				$form->AddHidden('op', $_REQUEST['op']);
				$form->AddHidden('match', $_REQUEST['match']);
				$form->EndForm();
			}			
		} else {
			if ($_REQUEST['submit']){
				foreach ($_REQUEST['results'] as $event=>$toss){
					$match = new Obj('ams_records', $event, 'holonet');
					$evnt = new Obj('ams_match', $match->Get('match'), 'holonet');
					$event = new Obj('ams_activities', $evnt->Get('type'), 'holonet');
					$person = $roster->GetPerson($match->Get('bhg_id'));
					$person->SendEmail(from(), 'Event Completed', "Your performance in an RP event has been graded.");
					$character = new Character($person->GetID());
		        	$character->XPEvent($_REQUEST['results'][$match->Get('id')][xp], $event->Get('name'));
		        	$person->AddCredits($_REQUEST['results'][$match->Get('id')][creds], $event->Get('name'));
					$return = array();
					foreach ($toss as $name=>$agogo){
						$return[$name] = $agogo;
					}
					$match->Edit($return, 1);
					$evnt->Edit(array('completed'=>time(), 'comments'=>$_REQUEST['comments']), 1);
				}
				echo 'Match Completed';
			} else {
				$form = new Form($page);
				$shutdown = false;
				foreach ($arena->Search(array('table'=>'ams_records', 'search'=>array('date_deleted'=>'0', 'match'=>$_REQUEST['match'], 'outcome'=>0))) as $event){
					$person = new Person($event->Get('bhg_id'));
					$form->AddSectionTitle('Results for '.$person->GetName());
					$form->AddTextBox('Credits:', 'results['.$event->Get('id').'][creds]');
					$form->AddTextBox('Experience Points:', 'results['.$event->Get('id').'][xp]');
					foreach ($arena->Search(array('table'=>'ams_event_builds', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get('id'), 'grade'=>1), 'limit'=>1)) as $grd){
						$grade = $grd;
					}
					if (is_object($grade)){
						$form->StartSelect('Result:', 'results['.$event->Get('id').'][outcome]');
						foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$grade->Get('resource')))) as $obj) {
					        $form->AddOption($obj->Get('id'), $obj->Get('name'));
					    }
					    $form->EndSelect();
				    } else {
					    $shutdown = true;
				    }
			    }
			    
			    $form->AddHidden('id', $_REQUEST['id']);
				$form->AddHidden('op', $_REQUEST['op']);
				$form->AddHidden('match', $_REQUEST['match']);
				
				if ($type->Get('submit')){
					$form->AddTextArea('Comments:', 'comments');
				}
				
				if ($shutdown){
					$form->AddSectionTitle('Please contact the coder. No grades are set for this event');
				} else {
					$form->AddSubmitButton('submit', 'Complete Match');
				}
				
				$form->EndForm();
			}
		}
	}
} else {
	include_once 'pending.php';
}

?>