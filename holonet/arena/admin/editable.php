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
	    $table->EndRow();
    }
    
    if ($_REQUEST['nexter']){
	    $grtrt = $_REQUEST['last'];
	    $fst = 'id` > \''.$grtrt.'\' AND `';
    } elseif ($_REQUEST['nextdw']){
	    $grtrt = $_REQUEST['first'];
	    $fst = 'id` < \''.$grtrt.'\' AND `';
    } 
    
    $pending = $arena->Search(array('table'=>'ams_match', 'search'=>array($fst.'type'=>$activity->Get(id), 'date_deleted'=>0), 'limit'=>20));
    $pendings = array();
    
    foreach ($pending as $obj){
	    if (!count($pendings)){
		    $first = $obj->Get(id);
	    }
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
		    $table->AddCell('<a href="'.internal_link($page, array('op'=>'edit', 'id'=>$_REQUEST['id'], 'match'=>$match->Get(id))).'">Edit</a>');
		    
		    $table->EndRow();
		    $last = $match->Get(id);
	    }
    }
    $pending = $arena->Search(array('table'=>'ams_match', 'search'=>array('id` > \''.$last.'\' AND `type'=>$activity->Get(id), 'date_deleted'=>0), 'limit'=>20), 0, 1);
    $denbo = $arena->Search(array('table'=>'ams_match', 'search'=>array('id` < \''.$first.'\' AND `type'=>$activity->Get(id), 'date_deleted'=>0), 'limit'=>20), 0, 1);
    
    $table->EndTable();
    if ($pending || $denbo){
	    hr();
	    $form = new Form($page);
	    
	    $form->AddHidden('id', $_REQUEST['id']);
		$form->AddHidden('op', $_REQUEST['op']);
		$form->table->StartRow();
		if ($denbo){
			$form->AddHidden('first', $first);
			$form->table->AddCell('<input type="submit" name="nextdw" value="<< Last 20">');
		}
		
		if ($pending){
			$form->AddHidden('last', $last);
			$form->table->AddCell('<input type="submit" name="nexter" value="Next 20 >>">');
		} 
	    $form->table->EndRow();
	    $form->EndForm();
    }
}

?>