<?php

if (isset($_REQUEST['id'])){
	$activity = new Obj('ams_activities', $_REQUEST['id'], 'holonet');
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
    global $activity, $arena, $type;

    $sheet = new Sheet();
    
    arena_header();

    if (is_object($activity)){
		
		$table = new Table('', true);
	    $table->StartRow();
	    $table->AddCell('Topic ID');
	    $table->AddCell('Name');
	    $table->EndRow();
	    
	    $pending = $arena->Search(array('table'=>'ams_match', 'search'=>array('type'=>$activity->Get(id), 'accepted'=>1, 'started` > 0 AND `completed` > 0 AND `date_deleted'=>0)));
	    $pendings = array();
	    
	    foreach ($pending as $obj){	
			$pendings[] = $obj;
	
		    foreach ($arena->Search(array('table'=>'ams_records', 'search'=>array('date_deleted'=>'0', 'match'=>$obj->Get(id)))) as $yarm){		   				    
				$chal[$obj->Get(id)][$yarm->Get(challenger)] = new Person($yarm->Get(bhg_id));
		    }
	    }
	    
	    foreach ($pendings as $ja=>$match){
		    $data = unserialize($match->Get(specifics));
		    $table->StartRow();
		    $table->AddCell(($match->Get(mbid) ? mb_link($match->Get(mbid)) : 'Unposted'));
		    $table->AddCell('<a href="'.internal_link(atn_stats, array('id'=>$match->Get(id))).'">'.($match->Get(name) ? $match->Get(name) : 'No Name').'</a>');
		    $table->EndRow();
	    }
	    
	    $table->EndTable();
	    
    }

    arena_footer();
}

?>