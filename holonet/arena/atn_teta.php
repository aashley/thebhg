<?php
function title() {
    return 'AMS Tracking Network :: General :: Owners of Teta\'s Knives';
}

function output() {
    global $arena;

    arena_header();

    $table = new Table('', true);
    
    $table->StartRow();
    $table->AddHeader('Hunter');
	$table->EndRow();
	
	$hunters = array();
	
	foreach ($arena->GetTeta() as $hunter){	
		$hunter = new Person($hunter);
		$hunters[$hunter->GetID()] = $hunter->GetName();
	}
	
	asort($hunters);
	
	foreach ($hunters as $id=>$hunter){		
		$table->AddRow('<a href="'. internal_link('atn_general', array('id'=>$id)) . '">' . $hunter . '</a>');
	}
	
	$table->EndTable();
    
    arena_footer();
}
?>