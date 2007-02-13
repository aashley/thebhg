<?php

if ($_REQUEST['match']){
	function display(){
		global $activity, $arena, $type, $roster, $page;
		
		$obj = new Obj('ams_match', $_REQUEST['match'], 'holonet');
		
		if ($_REQUEST['submit']){
			if ($_REQUEST['npc']){
				for ($i = 1; $i <= count($_REQUEST['npc']); $i++){
					$npc[] = serialize($_REQUEST['npc'][$i]);
				}
				$_REQUEST['data']['values'][] = serialize($npc);
			}
			if ($_REQUEST['serialize']){
				$_REQUEST['data']['values'][] = addslashes(serialize($_REQUEST['serialize']));
			}
			if (!$type->Get('opponent')){
				$_REQUEST['data'][values][] = parse_date_box('should_be');
				$_REQUEST['data'][fields][] = 'should_be';
			}
			/*$return = array();
			foreach ($_REQUEST['data'][fields] as $i=>$field){
				$return[$field] = $_REQUEST['data']['values'][$i];
			}*/
			//When PHP 5:
			$return = array_combine($_REQUEST['data'][fields], $_REQUEST['data'][values]);
			if (in_array('date_deleted', $_REQUEST['data']['values'])){
				$search = $arena->Search(array('table'=>'ams_records', 'search'=>array('match'=>$match->Get('id'), 'date_deleted'=>0)));
				foreach ($search as $mtc){
					$mtc->Edit($return, 1);
				}
			}
			$obj->Edit($return, 1);
			echo 'Edits Made';
		} else {
			$form = new Form($page);
			$form->AddHidden('id', $_REQUEST['id']);
			$form->AddHidden('op', $_REQUEST['op']);
			$form->AddHidden('match', $_REQUEST['match']);
			$form->AddHidden('data[values][]', time());
		    $form->AddHidden('data[fields][]', 'date_deleted');
		    echo '<center><input type="submit" name="submit" value="Delete Match"></center>';
		    $form->EndForm();
		    
			$form = new Form($page);
		    
		    $form->AddHidden('data[table]', 'ams_match');
		    $form->AddSectionTitle('Edit Match');
		    
		    if ($type->Get('opponent')){
			    $form->StartSelect('Location:', 'data[values][]', $obj->Get('location'));
			    foreach ($arena->Locations() as $lid=>$lname) {
			        $form->AddOption($lid, $lname);
			    }
			    $form->EndSelect();
			    $form->AddHidden('data[fields][]', 'location');
		    } elseif ($type->Get('request')) {
			    $form->AddDateBox('Target Completion', 'should_be', $obj->Get('should_be'));
		    }
		    
		    if ($type->Get('submit')){		    
			    $form->AddTextArea('Match Data:', 'data[values][]', $obj->Get('data'));
			    $form->AddHidden('data[fields][]', 'data');
		    }
		    
		    $form->AddTextArea(($type->Get('submit') ? 'Grade' : 'Comment').':', 'data[values][]', $obj->Get('comments'));
			$form->AddHidden('data[fields][]', 'comments');
		    
		    $form->StartSelect('Accepted', 'data[values][]', $obj->Get('accepted'));
			$form->AddOption(0, 'No');
			$form->AddOption(1, 'Yes');
			$form->EndSelect();
		    $form->AddHidden('data[fields][]', 'accepted');
		    
		    $form->AddTextBox('Name', 'data[values][]', $obj->Get('name'));
		    $form->AddHidden('data[fields][]', 'name');
		    
		    $form->AddHidden('id', $_REQUEST['id']);
			$form->AddHidden('op', $_REQUEST['op']);
			$form->AddHidden('match', $_REQUEST['match']);
		    
		    $builds = array();
		    
		    foreach ($arena->Search(array('table'=>'ams_event_builds', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get('id'), 'grade'=>0))) as $bojj){
			    $new = new Obj('ams_specifics_types', $bojj->Get('resource'), 'holonet');
			    $builds[addslashes($new->Get('name'))] = $new;
		    }
		    
		    ksort($builds);
		    
		    $data = unserialize($obj->Get('specifics'));
		    foreach ($builds as $build){
			    if ($build->Get('multiple')){
				    foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$build->Get('id')))) as $joj) {
					    $form->AddSectionTitle($build->Get('name'));
				        $form->AddCheckBox($joj->Get('name'), 'serialize['.$build->Get('id').'][]', $joj->Get('id'), in_array($obj->Get('id'), $data[$build->Get('id')]));
				    }
			    } else {
				    $form->StartSelect($build->Get('name'), 'serialize['.$build->Get('id').']', $data[$build->Get('id')]);
				    foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$build->Get('id')))) as $jobj) {
				        $form->AddOption($jobj->Get('id'), $jobj->Get('name'));
				    }
				    $form->EndSelect();
			    }
		    }
		    
		    $form->AddSectionTitle('Edit NPCs');

		    $ser = unserialize($obj->Get('data'));
		    if (is_array($ser)){
			    $form->AddHidden('data[fields][]', 'data');
			    $bld = new NPC_Utilities();
			    $i = 0;
			    foreach ($ser as $npc){
				    $i++;
				    $form->AddHidden('Test', $obj->Get('data'));
				    $npc = unserialize($npc);
			    	$form->AddTextBox('First Name:', 'npc['.$i.'][first]', $npc[first]);
			    	$form->AddTextBox('Last Name:', 'npc['.$i.'][last]', $npc[last]);
			    	$form->AddRadioButton('Male:', 'npc['.$i.'][sex]', 'Male', ($npc[sex] == 'Male'));
			    	$form->AddRadioButton('Female:', 'npc['.$i.'][sex]', 'Female', ($npc[sex] == 'Female'));
			    	$form->AddTextBox('Species:', 'npc['.$i.'][species]', $npc[species]);
			    	foreach ($npc[field] as $field){
			    		$form->AddHidden('npc['.$i.'][field][]', $field);
		    		}
			    	for ($a = 1; $a <= 10; $a++){
				    	if (is_array($npc[$a][stats])){
					    	foreach ($npc[$a][stats] as $stat=>$value){
						    	$stat = new Statribute($stat);
						    	$form->AddTextBox($stat->GetName(), 'npc['.$i.']['.$a.'][stats]['.$stat->GetID().']', $value, 5);
					    	}
				    	}
				    	if (is_array($npc[$a][skills])){
					    	foreach ($npc[$a][skills] as $stat=>$value){
						    	$stat = new Skill($stat);
						    	$form->AddTextBox($stat->GetName(), 'npc['.$i.']['.$a.'][skills]['.$stat->GetID().']', $value, 5);
					    	}
				    	}
			    	}
		    	}
		    }
		    $form->AddHidden('data[fields][]', 'specifics');
		    $form->AddSubmitButton('submit', 'Transmit to Holonet Servers');
		    $form->EndForm();
	    }
	    
	    //Make edits to players.
    }
} else {
	include_once 'editable.php';
}

?>