<?php

function display(){
	global $activity, $arena, $type, $roster, $page;
	
	if ($_REQUEST['submit']){
		$_REQUEST['data']['values'][] = addslashes(serialize($_REQUEST['serialize']));
	    $chal = false;
	    if ($_REQUEST['name']){
		    $name = $_REQUEST['name'];
	    } elseif ($type->Get(opponent)){
		    $chal = true;
		    $hunter = new Person($_REQUEST['challenger']);
		    $person = new Person($_REQUEST['challengee']);
		    $name = $hunter->GetName().' vs '.$person->GetName();
	    }
	    
	    $_REQUEST['data']['values'][] = $name;
		$_REQUEST['data']['fields'][] = 'name';
	    
	    $_REQUEST['data']['values'][] = parse_date_box('startdate');
		$_REQUEST['data']['fields'][] = 'started';
		if ($_REQUEST['markdown']){
			$_REQUEST['data']['values'][] = parse_date_box('enddate');
			$_REQUEST['data']['fields'][] = 'completed';
		}
	    
	    $id = $arena->NewRow($_REQUEST['data']);
	    
	    if ($id){
		    $arena->NewRow(array('table'=>'ams_records', 'values'=>array($id, $_REQUEST['challenger'], 1, $_REQUEST['chalr_cred'], $_REQUEST['chalr_xp'], $_REQUEST['chalr_result']), 'fields'=>array('match', 'bhg_id', 'challenger', 'creds', 'xp', 'outcome')));
		    if ($chal){
			    $arena->NewRow(array('table'=>'ams_records', 'values'=>array($id, $_REQUEST['challengee'], $_REQUEST['chale_cred'], $_REQUEST['chale_xp'], $_REQUEST['chale_result']), 'fields'=>array('match', 'bhg_id', 'creds', 'xp', 'outcome')));
		    }
		    
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
	    } else {
		    echo 'Error adding data.';
	    }
	} else {
		$form = new Form($page);
		$form->AddHidden('data[table]', 'ams_match');

		$form->AddSectionTitle('Add Data');
		$form->AddTextBox('Name:', 'name');
			    
		    $ringa_ding = 'Hunter:';
		    if ($type->Get(opponent)){
			    $ringa_ding2 = 'Opponent:';
			    include_once 'double.php';
		    } else {
			    include_once 'single.php';
		    }
		    
		    $form->AddSectionTitle('Other Match Data');
		    
		if ($type->Get(opponent)){
		    $form->StartSelect('Location:', 'data[values][]');
		    foreach ($arena->Locations() as $lid=>$lname) {
		        $form->AddOption($lid, $lname);
		    }
		    $form->EndSelect();
		    $form->AddHidden('data[fields][]', 'location');
		}
		    
	    $form->AddTextArea('Match Data:', 'data[values][]');
	    $form->AddHidden('data[fields][]', 'data');
		
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddHidden('op', $_REQUEST['op']);
		$form->AddHidden('data[values][]', 1);
		$form->AddHidden('data[fields][]', 'accepted');
		
		$form->AddDateBox('Start Date', 'startdate', time());
		$form->AddCheckBox('Mark As Complete', 'markdown', 1, true);
		$week = time()+(7*24*60*60);
		$form->AddDateBox('End Date', 'enddate', $week);
		$form->AddHidden('data[values][]', $_REQUEST['id']);
		$form->AddHidden('data[fields][]', 'type');
		
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
		
		$form->AddHidden('data[fields][]', 'specifics');
		$form->AddSubmitButton('submit', 'Transmit to Holonet Servers');
		$form->EndForm();
	}
}

?>