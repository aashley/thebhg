<?php

if ($_REQUEST['match']){
	function display(){
		global $activity, $arena, $type, $roster, $page;
		
		$obj = new Obj('ams_match', $_REQUEST['match'], 'holonet');
		
		if ($_REQUEST['submit']){
			if ($_REQUEST['serialize']){
				$_REQUEST['data']['values'][] = addslashes(serialize($_REQUEST['serialize']));
			}
			if (!$type->Get(opponent)){
				$_REQUEST['data'][values][] = parse_date_box('should_be');
				$_REQUEST['data'][fields][] = 'should_be';
			}
			$return = array();
			foreach ($_REQUEST['data'][fields] as $i=>$field){
				$return[$field] = $_REQUEST['data']['values'][$i];
			}
			//When PHP 5:
			//$return = array_combine($_REQUEST['data'][fields], $_REQUEST['data'][values]);
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
		    
		    if ($type->Get(opponent)){
			    $form->StartSelect('Location:', 'data[values][]', $obj->Get(location));
			    foreach ($arena->Locations() as $lid=>$lname) {
			        $form->AddOption($lid, $lname);
			    }
			    $form->EndSelect();
			    $form->AddHidden('data[fields][]', 'location');
		    } elseif ($type->Get(request)) {
			    $form->AddDateBox('Target Completion', 'should_be', $obj->Get(should_be));
		    }
		    
		    if ($type->Get(submit)){		    
			    $form->AddTextArea('Match Data:', 'data[values][]', $obj->Get(data));
			    $form->AddHidden('data[fields][]', 'data');
		    }
		    
		    $form->AddTextArea(($type->Get(submit) ? 'Grade' : 'Comment').':', 'data[values][]', $obj->Get(comments));
			$form->AddHidden('data[fields][]', 'comments');
		    
		    $form->StartSelect('Accepted', 'data[values][]', $obj->Get(accepted));
			$form->AddOption(0, 'No');
			$form->AddOption(1, 'Yes');
			$form->EndSelect();
		    $form->AddHidden('data[fields][]', 'accepted');
		    
		    $form->AddTextBox('Name', 'data[values][]', $obj->Get(name));
		    $form->AddHidden('data[fields][]', 'name');
		    
		    $form->AddHidden('id', $_REQUEST['id']);
			$form->AddHidden('op', $_REQUEST['op']);
			$form->AddHidden('match', $_REQUEST['match']);
		    
		    $builds = array();
		    
		    foreach ($arena->Search(array('table'=>'ams_event_builds', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get(id), 'grade'=>0))) as $bojj){
			    $new = new Obj('ams_specifics_types', $bojj->Get(resource), 'holonet');
			    $builds[addslashes($new->Get(name))] = $new;
		    }
		    
		    ksort($builds);
		    
		    $data = unserialize($obj->Get(specifics));
		    foreach ($builds as $build){
			    if ($build->Get(multiple)){
				    foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$build->Get(id)))) as $joj) {
					    $form->AddSectionTitle($build->Get(name));
				        $form->AddCheckBox($joj->Get(name), 'serialize['.$build->Get(id).'][]', $joj->Get(id), in_array($obj->Get(id), $data[$build->Get(id)]));
				    }
			    } else {
				    $form->StartSelect($build->Get(name), 'serialize['.$build->Get(id).']', $data[$build->Get(id)]);
				    foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$build->Get(id)))) as $jobj) {
				        $form->AddOption($jobj->Get(id), $jobj->Get(name));
				    }
				    $form->EndSelect();
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