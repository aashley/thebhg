<?php

if ($_REQUEST['id']){
	$activity = new Obj('ams_activities', $_REQUEST['id'], 'holonet');

	if (!$activity->Get('name')){
		$activity = false;
	}
	$type = new Obj('ams_types', $activity->Get('type'), 'holonet');
}

function title() {
	global $activity;
    return 'AMS Challenge Network :: Transmit Request'.(is_object($activity) ? ' :: '.$activity->Get('name') : '');
}

function auth($person) {
    global $arena, $hunter, $roster, $auth_data, $citadel, $activity, $type, $bar_slut, $bar_whore;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();

    if (is_object($activity) && $div->GetID() != 0 && $div->GetID() != 16 && $type->Get('request')){		
		return true;
	} else {
		return false;
	}
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $sheet, $citadel, $activity, $page, $type, $bar_slut, $bar_whore;

    arena_header();
	
    echo 'Welcome, ' . $hunter->GetName() . '.';

    if ($sheet->HasSheet($hunter->GetID())){
    
	    hr();
	    
	    $exams = array();
	    $lists = array();
	    $bar_slut = array();
	    $bar_whore = array();
	    $err = 0;
	    
	    $courses = $citadel->GetPersonsResults($hunter, CITADEL_PASSED);
		
	    foreach ($courses as $course){
		   $exam = $course->GetExam();
		   $exams[] = $exam->GetID();
	    }
	    
	    $search = $arena->Search(array('table'=>'ams_lists', 'search'=>array('date_deleted'=>'0', 'bhg_id'=>$hunter->GetID())));
	    foreach ($search as $list){
		   $lists[] = $list->Get('list');
	    }
	    
	    foreach ($arena->Search(array('table'=>'ams_restrict', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get('id')))) as $obj){
		    if ($obj->Get('course') > 0){
				if (!in_array($obj->Get('course'), $exams)){
					echo 'You do not possess the necessary Citadel Courses to use this activity.<br />';
					$err = 1;
				}
				$bar_slut[] = $obj->Get('course');
			}
			
			if ($obj->Get('list') > 0){
				if (!in_array($obj->Get('list'), $lists)){
					echo 'You are not a member of the necessary Elite lists to use this activity.<br />';
					$err = 1;
				}
				$bar_whore[] = $obj->Get('list');
			}
			
		}
		
		if ($err){
			arena_footer();
			return;
		}
	    
	    if (isset($_REQUEST['submit'])){
		    $_REQUEST['data']['values'][] = addslashes(serialize($_REQUEST['serialize']));
		    $auth = false;
		    $chal = false;
		    if ($type->Get('opponent')){
			    if ($_REQUEST['bhg_id'] > 0){
				    $auth = true;
				    $chal = true;
				    $person = new Person($_REQUEST['bhg_id']);
				    $_REQUEST['data']['values'][] = $hunter->GetName().' vs '.$person->GetName();
				    $_REQUEST['data']['fields'][] = 'name';
			    }
		    } else {
			    $auth = true;
		    }
		    
		    if ($auth){
			    $id = $arena->NewRow($_REQUEST['data']);
			    
			    if ($id){
				    $arena->NewRow(array('table'=>'ams_records', 'values'=>array($id, $hunter->GetID(), 1), 'fields'=>array('match', 'bhg_id', 'challenger')));
				    $info = 'Type: '.$activity->Get('name')."\n";
				    if ($type->Get('opponent')){
					    $opp = new Person($_REQUEST['bhg_id']);
					    $info .= 'Opponent: '.$opp->GetName()."\n";
				    }
				    foreach ($_REQUEST['serialize'] as $dab=>$data){
					    $name = new Obj('ams_specifics_types', $dab, 'holonet');
					    $info .= $name->Get('name').': ';
					    if (is_array($data)){
						    foreach ($data as $dab){
							    $name = new Obj('ams_specifics', $dab, 'holonet');
							    $info .= $name->Get('name')."\n";
						    }
					    } else {
						    $name = new Obj('ams_specifics', $data, 'holonet');
							$info .= $name->Get('name')."\n";
						}
					}

				    $hunter->SendEmail(from(), 'ACN Request', "You have requested a ".($type->Get('opponent') ? ' Match' : ' Mission').". \n\n[Info]\n".$info);
				    
				    if ($chal){
					    $arena->NewRow(array('table'=>'ams_records', 'values'=>array($id, $_REQUEST['bhg_id']), 'fields'=>array('match', 'bhg_id')));
					    $opp->SendEmail(from(), 'ACN Request', "You have been challenged to a match. \n\n[Info]\n".$info);
				    } else {
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
						$match = new Obj('ams_match', $id, 'holonet');
						$match->Edit(array('aide'=>$aide), 1);
						$pers->SendEmail(from(), 'New '.$activity->Get('name').' Mission', "A new ".$activity->Get('name').' Mission'." has been requested. Go to the Holonet to process it.");
					}
				    echo 'Request sent.';
			    } else {
				    echo 'Error making request';
			    }
		    } else {
			    echo 'Wow, you suck. You have to chose somebody to challenge.';
		    }
	    } else {	    
		    $form = new Form($page);
		    
		    $form->AddHidden('data[table]', 'ams_match');
		    
		    if ($type->Get('opponent')){		    
			    $form->AddSectionTitle('Issue Challenge');
			    $ringa_ding = 'Hunter to Challenge:';
			    $huid = $hunter->GetID();
			    include_once 'search.php';
			    
			    $form->StartSelect('Location:', 'data[values][]');
			    foreach ($arena->Locations() as $lid=>$lname) {
			        $form->AddOption($lid, $lname);
			    }
			    $form->EndSelect();
			    $form->AddHidden('data[fields][]', 'location');
		    }
		    
		    if ($type->Get('submit')){		    
			    $form->AddTextArea('Match Data:', 'data[values][]');
			    $form->AddHidden('data[fields][]', 'data');
			    
			    $form->AddHidden('data[values][]', time());
			    $form->AddHidden('data[fields][]', 'started');
			    $form->AddHidden('data[values][]', 1);
			    $form->AddHidden('data[fields][]', 'accepted');
		    }
		    
		    $form->AddHidden('id', $_REQUEST['id']);
		    $form->AddHidden('data[values][]', $_REQUEST['id']);
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
		    
		    hr();
		    $table = new Table();
		    $table->AddRow('Name', 'Rules', 'Description');
		    foreach ($builds as $build){
			    $work = array();
			    foreach ($arena->Search(array('table'=>'ams_specifics', 'search'=>array('date_deleted'=>'0', 'type'=>$build->Get('id')))) as $obj) {
				    if ($obj->Get('rules') || $obj->Get('description')){
					    $work[] = array('name'=>$obj->Get('name'), 'desc'=>$obj->Get('description', 1), 'rules'=>$obj->Get('rules', 1));
				    }
			    }
			    
			    if (count($work)){
				    $table->StartRow();
				    $table->AddHeader($build->Get('name'), 3);
				    $table->EndRow();
				    
				    foreach ($work as $bld){
					    $table->AddRow($bld['name'], $bld['desc'], $bld['rules']);
				    }
			    }
		    }
		    $table->EndTable();
	    }

	} else {	    
	    echo 'You need a Character Sheet to use this module. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();

}
?>
