<?php

if ($_REQUEST['match']){
	function display(){
		global $activity, $arena, $type, $roster, $page;
		
		$obj = new Obj('ams_match', $_REQUEST['match'], 'holonet');
		
		if ($_REQUEST['submit']){
			$return = array();
			
			if (!$type->Get(opponent)){
				$_REQUEST['data'][values][] = parse_date_box('should_be');
				$_REQUEST['data'][fields][] = 'should_be';
			}
			
			foreach ($_REQUEST['data'][fields] as $i=>$field){
				$return[$field] = $_REQUEST['data']['values'][$i];
			}
			//When PHP 5:
			//$return = array_combine($_REQUEST['data'][fields], $_REQUEST['data'][values]);
			$obj->Edit($return, 1);
			foreach ($arena->Search(array('table'=>'ams_records', 'search'=>array('date_deleted'=>'0', 'match'=>$_REQUEST['match'], 'outcome'=>0))) as $event){
				$person = new Person($event->Get(bhg_id));
				$person->SendEmail(from(), 'Event Posted', "Your event has been posted\n\n".linky($_REQUEST['data']['values'][0]));
			}
			echo 'Match Posted';
		} elseif ($_REQUEST['formdata']) {
			$creature = new Creature($_REQUEST['creature']);
			echo '<b>Subject</b>: '.($obj->Get(name) ? $obj->Get(name) : ($type->Get(creature) ? 'Challenge: '.$creature->GetName() : $_REQUEST['name']));
			
			echo '<br />';
			
			echo nl2br($_REQUEST['poster']);
			
			if ($type->Get(npc) || $obj->Get(data)){
				$bild = new NPC_Utilities();
				echo '<br />[b]Target[/b]';
				$deal = ($obj->Get(data) ? $obj->Get(data) : stripslashes($_REQUEST['npc']));
				foreach ($deal as $npc){
					echo $bild->Construct($npc);
				}
			} elseif ($type->Get(creature)){
				echo $creature->WriteSheet();
				$_REQUEST['name'] = 'Challenge: '.$creature->GetName();				
			}
			
			hr();
			
			$form = new Form($page);
			
			$form->AddTextBox('Message Board ID', 'data[values][]', '', 5);
			$form->AddHidden('data[fields][]', 'mbid');
			
			if ($type->Get(npc)){
				if (!$obj->Get(data)){
					$form->AddHidden('data[values][]', $_REQUEST['npc']);
					$form->AddHidden('data[fields][]', 'data');
				}
			} elseif ($type->Get(creature)){
				$form->AddHidden('data[values][]', $creature->GetID());
				$form->AddHidden('data[fields][]', 'data');
			}
			
			if (!$type->Get(opponent) && $type->Get(request)){
				$week = (3600*24*7);
				$date = time()+$week;
				
				$form->AddDateBox('Target Completion', 'should_be', $date);
			}
			
			$form->AddHidden('id', $_REQUEST['id']);
			$form->AddHidden('op', $_REQUEST['op']);
			$form->AddHidden('match', $_REQUEST['match']);
			($obj->Get(name) ? '' : $form->AddHidden('data[values][]', $_REQUEST['name']));
			($obj->Get(name) ? '' : $form->AddHidden('data[fields][]', 'name'));
			
			$form->AddHidden('data[values][]', time());
			$form->AddHidden('data[fields][]', 'started');
			
			$form->AddSubmitButton('submit', 'Post to System');
			
			$form->EndForm();
		} else {
			$form = new Form($page);
			
			$form->AddTextArea('Post Info', 'poster', $obj->Get(comments));
			$locations = $arena->Locations();
			
			($obj->Get(location) ? $form->table->AddRow('Location:', $locations[$obj->Get(location)]) : '');
			$data = unserialize($obj->Get(specifics));
			
			$builds = array();
	    
		    foreach ($arena->Search(array('table'=>'ams_event_builds', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get(id), 'grade'=>0))) as $ob){
			    $new = new Obj('ams_specifics_types', $ob->Get(resource), 'holonet');
			    $builds[addslashes($new->Get(name))] = $new;
			}
			
			ksort($builds);
			
		    $table->AddRow('Name:', ($match->Get(name) ? $match->Get(name) : 'No Name'));
		    foreach ($builds as $build){
			    foreach ($arena->Search(array('table'=>'ams_specifics_types', 'search'=>array('date_deleted'=>'0', 'id'=>$build->Get(id)))) as $ob) {
				    $info = new Obj('ams_specifics', $data[$build->Get(id)], 'holonet');
			        $table->AddRow($ob->Get(name).':', $info->Get(name));
			    }
		    }
			
			
			if ($type->Get(npc)){
				$data = unserialize($obj->Get(specifics));
				$npcs = array();
				for ($i = 1; $i <= $activity->Get(num_npc); $i++){
					$npcs[] = new Parse_NPC($data[$arena->NPCID()]);
				}
				$bild = new NPC_Utilities();
				$form->AddHidden('npc', serialize($npcs));
				$form->AddHidden('name', 'Target: '.$bild->GetName($npcs[0]->GetString()));
				
				$form->AddSectionTitle('NPC');
				
				foreach ($npcs as $npc){
					$form->table->StartRow();
					$form->table->AddCell($bild->Construct($npc->GetString()), 2);
					$form->table->EndRow();
				}
				
			} elseif ($type->Get(creature)){
				$form->StartSelect('Creature', 'creature');
			    foreach ($arena->Creatures() as $creature){
				    $form->AddOption($creature->GetID(), $creature->GetName());
			    }
			    $form->EndSelect();
		    }
			
			$form->AddHidden('id', $_REQUEST['id']);
			$form->AddHidden('op', $_REQUEST['op']);
			$form->AddHidden('match', $_REQUEST['match']);
			
			$form->AddSubmitButton('formdata', 'Format Post');
			
			$form->EndForm();
		}
	}
} else {
	include_once 'view.php';
}

?>