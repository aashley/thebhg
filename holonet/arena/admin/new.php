<?php

function display(){
	global $activity, $arena, $type, $roster, $page;
	
	if ($type->Get(submit)){
	    $_REQUEST['fading'] = true;
    }
	
	if ($_REQUEST['submit']){
		$_REQUEST['data']['values'][] = addslashes(serialize($_REQUEST['serialize']));
	    
	    $id = $arena->NewRow($_REQUEST['data']);
	    
	    if ($id){		    
		    $aux = false;
		    $aide_types = $arena->Search(array('table'=>'ams_access', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get(id))));
		    if (is_object($aide_types[0])){
				$aides = $arena->Search(array('table'=>'ams_aides', 'search'=>array('end_date'=>'0', 'aide'=>$aide_types[0]->Get(aide))));
				if (count($aides)){
					$aide = $aides[0]->Get(id);
					$pers = new Person($aides[0]->Get(bhg_id));
				} else {
					$aux = true;
				}
			} else {
				$aux = true;
			}
			
			if ($aux){
				$aj = Adjunct();
				$ov = Overseer();
				if ($aj->GetID()){
					$aide = '-'.$aj->GetID();
					$pers = new Person($aj->GetID());
				} else {
					if ($ov->GetID()){
						$aide = '-'.$ov->GetID();
						$pers = new Person($ov->GetID());
					} else {
						$aide = '-2650';
						$pers = new Person(2650);
					}
				}
			}
			$match = new Obj('ams_match', $id, 'holonet');
			$match->Edit(array('aide'=>$aide), 1);
			echo 'Event added';
	    } else {
		    echo 'Error adding data.';
	    }
	} elseif ($_REQUEST['fading']) {
		$form = new Form($page);
		$form->AddHidden('data[table]', 'ams_match');
		
		$form->AddSectionTitle('Add Data');
		$form->AddTextBox('Name:', 'data[values][]');
		$form->AddHidden('data[fields][]', 'name');
		    
	    $form->AddTextArea('Plot:', 'data[values][]');
	    $form->AddHidden('data[fields][]', 'comments');
	    
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddHidden('op', $_REQUEST['op']);
		
		$form->AddHidden('data[values][]', $_REQUEST['id']);
		$form->AddHidden('data[fields][]', 'type');
		
		$form->AddHidden('data[values][]', 1);
		$form->AddHidden('data[fields][]', 'accepted');
		
		$builds = array();
		
		foreach ($arena->Search(array('table'=>'ams_event_builds', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get(id), 'grade'=>0))) as $obj){
		    $new = new Obj('ams_specifics_types', $obj->Get(resource), 'holonet');
		    $builds[addslashes($new->Get(name))] = $new;
		}
		
		ksort($builds);
		
		foreach ($builds as $build){
		    if ($build->Get(multiple)){
			    foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$build->Get(id)))) as $obj) {
				    $form->AddSectionTitle($obj->Get(name));
			        $form->AddCheckBox($obj->Get(name), 'serialize['.$build->Get(id).'][]', $obj->Get(id));
			    }
		    } else {
			    $form->StartSelect($build->Get(name), 'serialize['.$build->Get(id).']');
			    foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$build->Get(id)))) as $obj) {
			        $form->AddOption($obj->Get(id), $obj->Get(name));
			    }
			    $form->EndSelect();
		    }
		}
		
		$form->AddSubmitButton('submit', 'Transmit to Holonet Servers');
		if ($_REQUEST['npc']){
			$npcsa = array();
			for ($i = 1; $i <= $_REQUEST['npcs']; $i++){
				$noc = new Parse_NPC($_REQUEST['max'], true);
				$npcsa[] = $noc->GetString();
			}
			$bild = new NPC_Utilities();
			$form->AddHidden('data[values][]', serialize($npcsa));
			$form->AddHidden('data[fields][]', 'data');
			$form->AddSectionTitle('NPC');
			foreach ($npcsa as $npc){
				$form->table->StartRow();
				$form->table->AddCell($bild->Construct($npc), 2);
				$form->table->EndRow();
			}
		}
		$form->AddHidden('data[fields][]', 'specifics');
		$form->EndForm();
	} else {
		$form = new Form($page);
		$form->AddCheckBox('Use NPC:', 'npc', 1);
		$form->StartSelect('Number of NPC:', 'npcs');
		for ($i = 1; $i <= 3; $i++){
			$form->AddOption($i, $i);
		}
		$form->EndSelect();
		$form->StartSelect('Max Stat Value for NPC:', 'max');
		for ($i = 5; $i <= 10; $i++){
			$form->AddOption($i, $i);
		}
		$form->EndSelect();
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddHidden('op', $_REQUEST['op']);
		$form->AddSubmitButton('fading', 'Build Event');
		$form->EndForm();
	}
}

?>