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
	    $table->AddCell('Status');
	    $table->AddCell('&nbsp;');
	    $table->AddCell('&nbsp;');
	    $table->EndRow();
    }
    
    $pending = $arena->Search(array('table'=>'ams_match', 'search'=>array('type'=>$activity->Get(id)), 'limit'=>20));
    $pendings = array();
    $status = array();
    $second = array();
    
    foreach ($pending as $obj){	
		$pendings[] = $obj;

	    foreach ($arena->Search(array('table'=>'ams_records', 'search'=>array('match'=>$obj->Get(id), 'outcome'=>0))) as $yarm){		   				    
			$chal[$obj->Get(id)][$yarm->Get(challenger)] = new Person($yarm->Get(bhg_id));
	    }
	    if ($obj->Get(date_deleted)){
		    $stat = 'Denied';
	    } else {
		    if ($obj->Get(accepted)){
			    if ($obj->Get(started)){
				    if ($obj->Get(completed)){
					    $stat = 'Finished';
				    } else {
					    $stat = 'In Play';
					    $second[$obj->Get(id)] = '<a href="'.internal_link($page, array('op'=>'finish', 'id'=>$_REQUEST['id'], 'match'=>$obj->Get(id))).'">Complete</a>';
				    }
			    } else {
				    $stat = 'Awaiting Posting';
				    $second[$obj->Get(id)] = '<a href="'.internal_link($page, array('op'=>'post', 'id'=>$_REQUEST['id'], 'match'=>$obj->Get(id))).'">Post</a>';
			    }
		    } else {
			    $stat = 'Pending';
		    }
	    }
	    
	    $status[$obj->Get(id)] = $stat;
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
			    if ($build->Get(multiple)){
				    $print = array();
				    if (is_array($data[$build->Get(id)])){
					    foreach ($data[$build->Get(id)] as $valu){
						    $info = new Obj('ams_specifics', $valu, 'holonet');
						    $print[] = $info->Get(name);
					    }
					    $table->AddCell(implode("<br />", $print));
				    } else {
					    $table->AddCell('None');
				    }
			    } else {
				    $info = new Obj('ams_specifics', $data[$build->Get(id)], 'holonet');
				    $table->AddCell($info->Get(name));
			    }
		    }
		    $table->AddCell($status[$match->Get(id)]);
		    $table->AddCell('<a href="'.internal_link($page, array('op'=>'edit', 'id'=>$_REQUEST['id'], 'match'=>$match->Get(id))).'">Edit</a>');
		    $table->AddCell(($second[$match->Get(id)] ? $second[$match->Get(id)] : ''));
		    
		    $table->EndRow();
	    }
    }
    
    $table->EndTable();
}

?>