<?php
function title() {
    return 'Administration :: Tournament :: Add Matches to ATN';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    if (in_array($_REQUEST['act'], $auth_data['activities'])){
    	return $auth_data['aide'];
	}
	
	return false;
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $page;

    arena_header();
    
    $at = new Tournament($_REQUEST['act']);

    $activity = new Obj('ams_activities', $_REQUEST['act'], 'holonet');
	$type = new Obj('ams_types', $activity->Get('type'), 'holonet');
    
    if (isset($_REQUEST['submit'])) {
	    $_REQUEST['data']['values'][] = addslashes(serialize($_REQUEST['serialize']));
	    $chal = false;

	    $aux = false;
	    $aide_types = $arena->Search(array('table'=>'ams_access', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get('id'))));
	    if (is_object($aide_types[0])){
			$aides = $arena->Search(array('table'=>'ams_aides', 'search'=>array('end_date'=>'0', 'aide'=>$aide_types[0]->Get('aide'))));
			if (count($aides)){
				$aide = $aides[0]->Get('id');
				$pers = new Person($aides[0]->Get('bhg_id'));
			} else {
				$aux = true;
			}
		} else {
			$aux = true;
		}
		
		if ($aux){
			$aj = Adjunct();
			$ov = Strategist();
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
		
	    foreach ($at->GetBracketHunters() as $bid=>$bracket){
		    if ($bid == 99){
			    continue;
	 		}
		    $chal = true;
		    $hunter = $bracket[0];
		    $person = $bracket[1];
		    $name = $hunter->GetName().' vs '.$person->GetName();

		    $_REQUEST['data']['values'][5] = $name;
			$_REQUEST['data']['fields'][5] = 'name';
		    
			$_REQUEST['data']['values'][6] = $aide;
			$_REQUEST['data']['fields'][6] = 'aide';
			
		    $id = $arena->NewRow($_REQUEST['data']);
		    
		    if ($id){
				$arena->NewRow(array('table'=>'ams_records', 'values'=>array($id, $hunter->GetID(), 1), 'fields'=>array('match', 'bhg_id', 'challenger')));
				$arena->NewRow(array('table'=>'ams_records', 'values'=>array($id, $person->GetID()), 'fields'=>array('match', 'bhg_id')));
			}
		}
		echo 'Rounds added to the ATN';
    } else {
	    $form = new Form($page);
	    $form->AddHidden('act', $_REQUEST['act']);
		$form->AddHidden('data[table]', 'ams_match');

		$form->AddSectionTitle('Add Data');
		    
		if ($type->Get('opponent')){
		    $form->StartSelect('Location:', 'data[values][]');
		    foreach ($arena->Locations() as $lid=>$lname) {
		        $form->AddOption($lid, $lname);
		    }
		    $form->EndSelect();
		    $form->AddHidden('data[fields][]', 'location');
		}
		    
	    $form->AddTextArea('Match Data:', 'data[values][]');
	    $form->AddHidden('data[fields][]', 'data');
		
		$form->AddHidden('data[values][]', 1);
		$form->AddHidden('data[fields][]', 'accepted');
		
		$form->AddHidden('data[values][]', $_REQUEST['act']);
		$form->AddHidden('data[fields][]', 'type');
		
		$builds = array();
		
		foreach ($arena->Search(array('table'=>'ams_event_builds', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get('id'), 'grade'=>0))) as $obj){
		    $new = new Obj('ams_specifics_types', $obj->Get('resource'), 'holonet');
		    $builds[addslashes($new->Get('name'))] = $new;
		}
		
		ksort($builds);
		
		foreach ($builds as $build){
		    if ($build->Get('multiple')){
			    foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$build->Get('id')))) as $obj) {
				    $form->AddSectionTitle($obj->Get('name'));
			        $form->AddCheckBox($obj->Get('name'), 'serialize['.$build->Get('id').'][]', $obj->Get('id'));
			    }
		    } else {
			    $form->StartSelect($build->Get('name'), 'serialize['.$build->Get('id').']');
			    foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$build->Get('id')))) as $obj) {
			        $form->AddOption($obj->Get('id'), $obj->Get('name'));
			    }
			    $form->EndSelect();
		    }
		}
		
		$form->AddHidden('data[fields][]', 'specifics');
		$form->AddSubmitButton('submit', 'Transmit to Holonet Servers');
		$form->EndForm();
    
	}
    
    admin_footer($auth_data);

}
?>
