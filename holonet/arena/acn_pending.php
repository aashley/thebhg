<?php

if ($_REQUEST['id']){
	$match = new Obj('ams_match', $_REQUEST['id'], 'holonet');
	$activity = new Obj('ams_activities', $match->Get(type), 'holonet');

	if (!$activity->Get(name)){
		$activity = false;
	}
	$type = new Obj('ams_types', $activity->Get(type), 'holonet');
}

function title() {
	global $activity;
    return 'AMS Challenge Network :: Event Processing'.(is_object($activity) ? ' :: '.$activity->Get(name) : '');
}

function auth($person) {
    global $arena, $hunter, $roster, $auth_data, $citadel, $activity, $type, $match;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();

    if (is_object($match) && $div->GetID() != 0 && $div->GetID() != 16 && $type->Get(request)){
	    $search = $arena->Search(array('table'=>'ams_records', 'search'=>array('date_deleted'=>'0', 'outcome'=>'0', 'bhg_id'=>$hunter->GetID(), 'match'=>$match->Get(id))));
		
	    if (!count($search)){
		    return false;
	    }
	    
	    $opp = array('acc', 'den');
	    $solo = array('ret', 'ext');
	    
	    if (!in_array($_REQUEST['op'], $opp)){
		    if (!in_array($_REQUEST['op'], $solo)){
			    return false;
		    }
	    }
	    
	    if ($type->Get(opponent) && (!in_array($_REQUEST['op'], $opp))){
		    return false;
	    }
	    
	    if (!$type->Get(opponent) && (!in_array($_REQUEST['op'], $solo))){
		    return false;
	    }
	    	
		return true;
	} else {
		return false;
	}
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $sheet, $citadel, $match, $activity, $page, $type;

    arena_header();
	
    echo 'Welcome, ' . $hunter->GetName() . '.';

    if ($sheet->HasSheet($hunter->GetID())){
    
	    hr();
	    
	    if (!$type->Get(opponent)){
			if ($match->Get(aide) > 0){
				$aides = new Obj('ams_aides', $match->Get(aide), 'holonet');
				$aide = new Person($aides->Get(bhg_id));
			} else {
				$frm = str_replace('-', '', $match->Get(aide));
				$aide = new Person($frm);
			}
		}

		if ($_REQUEST['submit']){
			$match->Edit(array('to_date'=>parse_date_box('extend'), 'comments'=>addslashes($_REQUEST['reason'])), 1);
			echo 'Extension requested.';
			$aide->SendEmail(from(), 'Mission Extension', "A posted ".$activity->Get(name).' Mission'." has a pending extension request. Go to the Holonet to process it.");
		} else {
			
			$search = $arena->Search(array('table'=>'ams_records', 'search'=>array('match'=>$match->Get(id), 'date_deleted'=>0)));
			foreach ($search as $obj){
				if ($obj->Get(bhg_id) != $hunter->GetID()){
					$opp = new Person($obj->Get(bhg_id));
				}
			}
			
		    switch ($_REQUEST['op']){
			    case 'acc':
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
					$pers->SendEmail(from(), 'New '.$activity->Get(name).' Match', "A new ".$activity->Get(name).' Match'." has been requested. Go to the Holonet to process it.");
			    	$match->Edit(array('accepted'=>1, 'aide'=>$aide), 1);
			    	$hunter->SendEmail(from(), 'Match Accepted', "You have accepted the ".$activity->Get(name)." challenge from ".$opp->GetName().". It will be posted shortly.");
			    	$opp->SendEmail(from(), 'Match Accepted', $hunter->GetName()." has accepted your ".$activity->Get(name)." challenge. It will be posted shortly.");
			    	echo 'Match Accepted';
			    break;
			    
			    case 'den':
			    	$match->Edit(array('date_deleted'=>time(), 'completed'=>time()), 1);
			    	$search = $arena->Search(array('table'=>'ams_records', 'search'=>array('match'=>$match->Get(id))));
			    	foreach ($search as $obj){
				    	$obj->Edit(array('date_deleted'=>time(), 'outcome'=>-1), 1);
			    	}
			    	$hunter->SendEmail(from(), 'Match Declined', "You have declined the ".$activity->Get(name)." challenge from ".$opp-Get(name).".");
			    	$opp->SendEmail(from(), 'Match Declined', $hunter->GetName()." has declined your ".$activity->Get(name)." challenge.");
			    	echo 'Match Declined';
			    break;
			    
			    case 'ret':
			    	$search = $arena->Search(array('table'=>'ams_records', 'search'=>array('match'=>$match->Get(id))));
			    	foreach ($search as $obj){
				    	$obj->Edit(array('date_deleted'=>time(), 'outcome'=>-1), 1);
			    	}
			    	$match->Edit(array('date_deleted'=>time()), 1);
			    	$aide->SendEmail(from(), 'Mission Retired', "A posted ".$activity->Get(name).' Mission'." has been retired.\n\n".linky($match->Get(mbid)));
			    	echo 'Retired Mission';
			    break;
			    
			    case 'ext':
			    	$form = new Form($page);
			    	$form->AddSectionTitle('Request Extension');
			    	$week = 7*24*60*60;
			    	$time = $match->Get(should_be)+$week;
			    	$form->AddDateBox('Extend To:', 'extend', $time);
			    	$form->AddHidden('id', $_REQUEST['id']);
			    	$form->AddHidden('op', $_REQUEST['op']);
			    	$form->AddTextArea('Reason:', 'reason');
			    	$form->AddSubmitButton('submit', 'Request Extension');
			    	$form->EndForm();
			    break;
		    }
	    }		    
	    
	} else {	    
	    echo 'You need a Character Sheet to use this module. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer();

}
?>
