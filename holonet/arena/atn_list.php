<?php

if (isset($_REQUEST['id'])){
	$activity = new Obj('ams_list_types', $_REQUEST['id'], 'holonet');
	
	if (!$activity->Get('name')){
		$activity = false;
	}
}

function title() {
    global $activity;

    $return = 'AMS Tracking Network';

    if (is_object($activity)){
	    $return .= ' :: Member List :: '.$activity->Get('name');
    }
    
    return $return;
}

function output() {
	global $activity, $arena, $type, $match, $mb;
	
	$sheet = new Sheet();
	
	arena_header();
	
	$current = $arena->Search(array('table'=>'ams_lists', 'search'=>array('list'=>$_REQUEST['id'], 'date_deleted'=>'0')));
	
	if (count($current)){
		
		$table = new Table('', true);
		
		$table->StartRow();
		$table->AddHeader('Hunter');
		$table->EndRow();
		
		foreach ($current as $obj){
			$hunter = new Person($obj->Get('bhg_id'));
			$table->AddRow('<a href="'.internal_link('atn_general', array('id'=>$hunter->GetID())).'">'.$hunter->GetName().'</a>');
		}
		
		$table->EndTable();
		
	}

  arena_footer();
}

?>
