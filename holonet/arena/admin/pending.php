<?php

function display(){
	global $activity, $arena, $type, $page;
	
	$builds = array();
			    
	foreach ($arena->Search(array('table'=>'ams_event_builds', 'search'=>array('date_deleted'=>'0', 'activity'=>$activity->Get(id), 'grade'=>0))) as $ob){
	    $new = new Obj('ams_specifics_types', $ob->Get(resource), 'holonet');
	    $builds[addslashes($new->Get(name))] = $new;
	}
	
	ksort($builds);
	
	$table = new Table('', true);
	
	if (count($builds)){
	    $table->StartRow();
	    ($type->Get(request) ? $table->AddCell('Requester') : '');
	    ($type->Get(opponent) ? $table->AddCell('Opponent') : '');
	    $table->AddCell('Topic ID');
	    $table->AddCell('Name');
	    foreach ($builds as $build){
		    foreach ($arena->Search(array('table'=>'ams_specifics_types', 'search'=>array('date_deleted'=>'0', 'id'=>$build->Get(id)))) as $ob) {
		        $table->AddCell($ob->Get(name));
		    }
	    }
	    $table->AddCell('&nbsp;');
	    $table->AddCell('&nbsp;');
	    $table->EndRow();
    }
    
    $pending = $arena->Search(array('table'=>'ams_match', 'search'=>array('type'=>$activity->Get(id), 'accepted'=>1, 'date_deleted'=>0, 'started` > 0 AND `completed'=>0)));
    $pendings = array();
    
    foreach ($pending as $obj){	
		$pendings[] = $obj;

	    foreach ($arena->Search(array('table'=>'ams_records', 'search'=>array('date_deleted'=>'0', 'match'=>$obj->Get(id), 'outcome'=>0))) as $yarm){		   				    
			$chal[$obj->Get(id)][$yarm->Get(challenger)] = new Person($yarm->Get(bhg_id));
	    }
    }
    
    foreach ($pendings as $ja=>$match){
	    if (count($builds)){
		    $data = unserialize($match->Get(specifics));
		    $table->StartRow();
		    ($type->Get(request) ? $table->AddCell((is_object($chal[$match->Get(id)][1]) ? $chal[$match->Get(id)][1]->GetName() : 'ERROR')) : '');
		    ($type->Get(opponent) ? $table->AddCell((is_object($chal[$match->Get(id)][0]) ? $chal[$match->Get(id)][0]->GetName() : 'ERROR')) : '');
		    $table->AddCell(($match->Get(mbid) ? mb_link($match->Get(mbid)) : 'Unposted'));
		    $table->AddCell(($match->Get(name) ? $match->Get(name) : 'No Name'));
		    foreach ($builds as $build){
			    $info = new Obj('ams_specifics', $data[$build->Get(id)], 'holonet');
			    $table->AddCell($info->Get(name));
		    }
		    
		    $urg = ($match->Get(should_be) <= time() && $match->Get(should_be) > 0);
		    
		    $table->AddCell('<a href="'.internal_link($page, array('op'=>'edit', 'id'=>$_REQUEST['id'], 'match'=>$match->Get(id))).'">Edit</a>');
		    $table->AddCell('<a href="'.internal_link($page, array('op'=>'finish', 'id'=>$_REQUEST['id'], 'match'=>$match->Get(id))).'">'.($urg ? '<b>Due for Completion</b>' : 'Complete').'</a>');
		    
		    $table->EndRow();
	    }
    }
    
    $table->EndTable();
}

?>