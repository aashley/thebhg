<?php
function title() {
    return 'AMS Tracking Network :: Dojo of Shadows :: List of Learners';
}

function output() {
    global $arena;

    arena_header();

    $table = new Table('', true);
    
    $table->StartRow();
    $table->AddHeader('Hunter');
	$table->EndRow();
	
	$hunters = array();
	
	foreach ($arena->GetDojo() as $hunter){	
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