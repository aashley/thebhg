<?php
if (isset($_REQUEST['id'])){
	$hunter = new Person($_REQUEST['id']);
}

function title() {
    global $hunter;

    $return = 'AMS Tracking Network :: Property Claims';
    
    if (is_object($hunter)){
	    $return .= ' :: ' . $hunter->GetName();
    }
    
    return $return;
}

function output() {
    global $arena, $hunter, $sheet, $roster;

    arena_header();

    echo '<a href="'.internal_link('atn_general', array('id'=>$hunter->GetID())).'">Back to '.$hunter->GetName().'\'s General Tracking</a>';
    
    hr();
    
    if (is_object($hunter)){
    	$properties = $arena->MyProperties($hunter);

    	if (count($properties)){
	    	$posi = array();
	    	$pers = array();
	    	foreach ($properties as $land){
		    	if ($land['posi']){
			    	$posi[] = $land['name'];
		    	} else {
			    	$pers[] = $land['name'];
		    	}
	    	}
	    	
	    	ksort($posi);
	    	ksort($pers);
	    	
	    	if (count($pers)){
		    	$table = new Table('', true);
		    	$table->StartRow();
		    	$table->AddHeader('<center>Custom Owned Properties</center>', 4);
		    	$table->EndRow();
		    	
		    	foreach ($pers as $data){
			    	$table->StartRow();
			    	$table->AddCell($data);
		    	}
		    	$table->EndTable();			    	
	    	}
	    	
	    	if (count($posi)){
		    	if (count($pers)){
			    	hr();
		    	}
		    	$table = new Table('', true);
		    	$table->StartRow();
		    	$table->AddHeader('<center>Position Deeded Properties</center>', 4);
		    	$table->EndRow();
		    	
		    	foreach ($posi as $data){
			    	$table->StartRow();
			    	$table->AddCell($data);
		    	}
		    	$table->EndTable();
	    	}
    	} else {
	    	echo 'This hunter owns no pieces of Lyarna.';
    	}   		
	}
    
    arena_footer();
}
?>