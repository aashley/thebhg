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
		    	$local = new Location($land['id'], $land['table']);
		    	$planet = new StarfieldLocation($land['planet']);
		    	$data = array('name'=>'<a href="'.$local->GetLink().'">'.$local->GetName().'</a>', 
		    					'planet'=>'<a href="'.$planet->GetLink().'">'.$planet->GetName().'</a>',
		    					'arena'=>($land['arena'] ? true : false), 'used'=>$local->GetUsed());
		    	if ($land['posi']){
			    	$posi[$planet->GetName()] = $data;
		    	} else {
			    	$pers[$planet->GetName()] = $data;
		    	}
	    	}
	    	
	    	ksort($posi);
	    	ksort($pers);
	    	
	    	if (count($pers)){
		    	$table = new Table('', true);
		    	$table->StartRow();
		    	$table->AddHeader('<center>Custom Owned Properties</center>');
		    	$table->EndRow();
		    	
		    	$table->AddRow('Name', 'Planet', 'Arena Approved', 'Times Used');
		    	foreach ($pers as $data){
			    	$table->StartRow();
			    	$table->AddCell($data['name']);
			    	$table->AddCell($data['planet']);
			    	$table->AddCell(($data['arena'] ? 'Yes' : 'No'), ($data['arena'] ? '' : '2'));
			    	if ($data['arena']){ $table->AddCell($data['used']); }
		    	}
		    	$table->EndTable();			    	
	    	}
	    	
	    	if (count($posi)){
		    	$table = new Table('', true);
		    	$table->StartRow();
		    	$table->AddHeader('<center>Position Deeded Properties</center>');
		    	$table->EndRow();
		    	
		    	$table->AddRow('Name', 'Planet', 'Arena Approved', 'Times Used');
		    	foreach ($posi as $data){
			    	$table->StartRow();
			    	$table->AddCell($data['name']);
			    	$table->AddCell($data['planet']);
			    	$table->AddCell(($data['arena'] ? 'Yes' : 'No'), ($data['arena'] ? '' : '2'));
			    	if ($data['arena']){ $table->AddCell($data['used']); }
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