<?php

if (isset($_REQUEST['id'])){
	$activity = new Obj(' ams_list_types', $_REQUEST['id'], 'holonet');
}

function title() {
    global $activity;

    $return = 'AMS Tracking Network';

    if (is_object($activity)){
	    $return .= ' :: Member List :: '.$activity->Get(name);
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
		$table->AddHeader('&nbsp;');
		$table->EndRow();
		
		foreach ($current as $obj){
			$hunter = new Person($obj->Get(bhg_id));
			$table->AddRow($hunter->GetName(), '<a href="'.internal_link($page, array('op'=>'de', 'go'=>$obj->Get(id), 'id'=>$_REQUEST['id'])).'">Remove</a>');
			$last_type = $obj->Get(type);
		}
		
		$table->EndTable();
		
		hr();
	}

    arena_footer();
}

?>