<?php

if ($_REQUEST['id']){
	$activity = new Obj('ams_activities', $_REQUEST['id'], 'holonet');

	if (!$activity->Get(name)){
		$activity = false;
	} else {
		$type = new Obj('ams_types', $activity->Get(type), 'holonet');
	}
}

function title() {
	global $activity;
    return 'Administration :: Event Management'.(is_object($activity) ? ' :: '.$activity->Get(name) : '');
}

function auth($person) {
    global $arena, $hunter, $roster, $auth_data, $citadel, $activity, $type;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    $pos = $person->GetPosition();

    if ($auth_data['rp']){
    	return true;
	}
    
    if (is_object($activity) && $div->GetID() != 0 && $div->GetID() != 16 && $type->Get(request)){
	    $aides = $arena->Search(array('table'=>'ams_aides', 'search'=>array('end_date'=>'0', 'bhg_id'=>$hunter->GetID())));
	    foreach ($aides as $aide){
	    	if ($arena->Search(array('table'=>'ams_access', 'search'=>array('date_deleted'=>'0', 'aide'=>$aide->Get(aide), 'activity'=>$activity->Get(id))), 0, 1)){
		    	return true;
	    	}
    	}
    				
		return false;
	} else {
		return false;
	}
}

function self($link){
	global $page;
	return '<a href="'.internal_link($page, array('id'=>$_REQUEST['id'], 'op'=>$link['op'])).'">'.$link['name'].'</a>';
}

function other($other){
	global $page;
	return '<a href="'.internal_link('admin_'.$other['page'], array('act'=>$_REQUEST['id'])).'">'.$other['name'].'</a>';
}

function frmt($name, $op, $desc, $attn = 0){
	return array('name'=>$name, 'op'=>$op, 'desc'=>$desc, 'attn'=>$attn);
}

function formt($name, $page, $desc){
	return array('name'=>$name, 'page'=>$page, 'desc'=>$desc);
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $sheet, $citadel, $activity, $page, $type;

    arena_header();
    
    if (!$_REQUEST['op']){
	    $table = new Table('', true);
	    $table->StartRow();
	    $table->AddHeader($activity->Get(name).' Options', 2);
	    $table->EndRow();
	    $options = array();
	    
	    if (!$type->Get(submit)){
	    	$options[] = frmt('Post New', 'post', 'Allows you to post pending matches to the Message Board.');
    	}

	    if (!$type->Get(opponent) && $type->Get(request)){
		    $options[] = frmt('Approve Request', 'approve', 'Approve requested events.');
		    $options[] = frmt('Approve Extensions', 'extend', 'Displays requested extensions for you to deny or approve.');
	    } 
	    
	    if ($type->Get(creature)) {
		    $options[] = frmt('New Creature', 'creature', 'Create a new creature.');
		    $options[] = frmt('Edit Creatures', 'creature_edit', 'Edit currently existing creatures.');
	    }
	    
	    if (!$type->Get(request)){
		    $options[] = frmt('Add New', 'new', 'Start a new Event.');
	    } else {
		    $options[] = frmt('Add Match', 'add', 'Add an old match to the system.');
	    }
	    
	    $options[] = frmt('View Pending', 'view', 'Displays all unfinished matches which have been posted.');
	    $options[] = frmt('View Recent', 'recent', 'Displays the 20 most recent matches, regardless of status.');
	    $options[] = frmt('Edit', 'edit', 'Allows you to edit a pending event.');
	    $options[] = frmt('Complete', 'finish', 'Grade an event and award credits/experience points.');	    
	    
	    foreach ($options as $option){
		    $table->StartRow();
		    $table->AddCell('&nbsp;');
		    $table->AddCell(self($option));
		    $table->EndRow();
		    
		    $table->StartRow();
		    $table->AddCell($option['desc'], 2);
		    $table->EndRow();
	    }
	    $table->EndTable();
	    
	    if ($type->Get(opponent)){
		    hr();
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader($activity->Get(name).' Tournament Options', 2);
		    $table->EndRow();
		    $options = array();
		    
		    $at = new Tournament($activity->Get(id));
		    
		    if (!$at->Ended()){
			    $options[] = formt('Add Hunter as Wildcard', 'tournament_wildcard', 'Adds a new hunter to the mix.');
			    $options[] = formt('Delete Hunters', 'tournament_manage', 'Allows you to delete people you have teh hate for.');
			    $options[] = formt('Randomize Brackets', 'tournament_random', 'Randomizes the brackets. <h5>Warning: Sentience Has Power Here</h5>');
			    $options[] = formt('Organize Round Brackets', 'tournament_organize', 'Allows you to fuddle with the brackets.');
			    $options[] = formt('Add Round to ATN', 'tournament_atn', 'Once you are good and happy, add round to the tracker.');
			    $options[] = formt('Enter Round Stats', 'tournament_round', 'Select winners, losers, DQers, et cetra.');
		    } else {
		    	$options[] = formt('Begin a new Tournament', 'tournament_new', 'Start a new Tournament for the '.$activity->Get(name).'.');
	    	}  
	    
		    foreach ($options as $option){
			    $table->StartRow();
			    $table->AddCell('&nbsp;');
			    $table->AddCell(other($option));
			    $table->EndRow();
			    
			    $table->StartRow();
			    $table->AddCell($option['desc'], 2);
			    $table->EndRow();
		    }
		    $table->EndTable();
	    }
		    
	    
    } else {
	    $func_page = 'arena/admin/'.$_REQUEST['op'].'.php';
	    if (file_exists($func_page)){
		    include_once $func_page;
		    display();
	    } else {
		    echo 'Error loading functionality';
	    }
    }

    admin_footer($auth_data);

}
?>