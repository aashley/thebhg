<?php

if (isset($_REQUEST['id'])){
	$match = new Obj('ams_match', $_REQUEST['id'], 'holonet');
	$activity = new Obj('ams_activities', $match->Get(type), 'holonet');
	if (!$activity->Get(name)){
		$activity = false;
	} else {
		$type = new Obj('ams_types', $activity->Get(type), 'holonet');
	}
}

function title() {
    global $activity;

    $return = 'AMS Tracking Network';

    if (is_object($activity)){
	    $return .= ' :: Activity :: '.$activity->Get(name);
    }
    
    return $return;
}

function output() {
    global $activity, $arena, $type, $match, $mb;

    $sheet = new Sheet();
    
    arena_header();

    if (is_object($activity)){
    
	    foreach ($arena->Search(array('table'=>'ams_event_builds', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get(id), 'grade'=>0))) as $ob){
		    $new = new Obj('ams_specifics_types', $ob->Get(resource), 'holonet');
		    $builds[addslashes($new->Get(name))] = $new;
		}
		
		ksort($builds);
		
		$table = new Table('', true);
		
		if (count($builds)){
		    $table->StartRow();
		    $table->AddHeader('Stat');
		    $table->AddHeader('Value');
		    $table->EndRow();
	    }
	
	    if ($match->Get(date_deleted)){
		    $stat = 'Denied';
	    } else {
		    if ($match->Get(accepted)){
			    if ($match->Get(started)){
				    if ($match->Get(completed)){
					    $stat = 'Finished';
				    } else {
					    $stat = 'In Play';						    
				    }
			    } else {
				    $stat = 'Awaiting Posting';					    
			    }
		    } else {
			    $stat = 'Pending';
		    }
	    }
	    
	    if (count($builds)){
		    $data = unserialize($match->Get(specifics));
		    $table->AddRow('Topic ID:', ($match->Get(mbid) ? mb_link($match->Get(mbid)) : 'Unposted'));
		    $table->AddRow('Name:', ($match->Get(name) ? $match->Get(name) : 'No Name'));
		    foreach ($builds as $build){
			    foreach ($arena->Search(array('table'=>'ams_specifics_types', 'search'=>array('date_deleted'=>'0', 'id'=>$build->Get(id)))) as $ob) {
				    $info = new Obj('ams_specifics', $data[$build->Get(id)], 'holonet');
			        $table->AddRow($ob->Get(name).':', $info->Get(name));
			    }
		    }
		    
		    $urg = ($match->Get(should_be) <= time() && $match->Get(should_be) > 0);
		    ($urg ? $table->AddRow('Due By:', $match->Get(should_be, 0, 1)) : '');
		    if ($match->Get(data)){
			    $ser = unserialize($match->Get(data));
			    if (is_array($ser)){
				    $bld = new NPC_Utilities();
				    $table->AddRow('NPC:', $bld->Construct($match->Get(data, 1)));
			    } elseif (is_int(($match->Get(data)))) {
				    $cre = new Creature($match->Get(data));
				    $table->AddRow('Creature:', $cre->WriteSheet());
			    } else {
				    $table->AddRow('Match Data:', $match->Get(data, 1));
			    }
		    }
		    ($match->Get(comments) ? $table->AddRow('Comments:', $match->Get(comments, 1)) : '');
		    $table->AddRow('Status:', $stat);
		    $table->EndRow();
	    }
	    
	    $table->EndTable();
	    
	    hr();
	    
	    $table = new Table();
	    
	    foreach ($arena->Search(array('table'=>'ams_records', 'search'=>array('date_deleted'=>'0', 'match'=>$match->Get(id)))) as $yarm){		   				    
			$person = new Person($yarm->Get(bhg_id));
			$table->StartRow();
			$table->AddHeader($person->GetName(), 2);
			$table->EndRow();
			$c = 0;
			if ($yarm->Get(outcome) > 0){
				$spec = new Obj('ams_specifics', $yarm->Get(outcome), 'holonet');
				$table->AddRow('Outcome:', $spec->Get(name));
			} else {
				$table->AddRow('Result Data:', 'Pending');
			}
			if ($yarm->Get(medal)){
				$medal = new MedalGroup($yarm->Get(medal));
				$table->AddRow('Medal:', $medal->GetName());
			}
			($yarm->Get(creds) ? $table->AddRow('Credits', $yarm->Get(creds, 0, 0, 1)) : '');
			($yarm->Get(xp) ? $table->AddRow('Experience Points', $yarm->Get(xp, 0, 0, 1)) : '');
	    }
	    
	    $table->EndTable();
	    
    }

    arena_footer();
}

?>