<?php
include_once('header.php');

function reformat($score){
	
	if ($score == 0)
		return 0;
	
	$new = $score - 20;
	
	if ($new <= 0)
		$new = 1;
		
	return $new;
	
}

$event =& $ka->GetEvent($_REQUEST['id']);
$kag =& $event->GetKAG();

if ($event->IsTimed()){
	$type = $event->GetTypes();
	$name = $type->GetName();
} else {
	$name = $event->GetName();
}

page_header('KAG ' . roman($kag->GetID()) . ' :: ' . $name);
add_menu(array('KAG ' . roman($kag->GetID())=>'kag/kag.php?id=' . $kag->GetID()));

$table = new Table('', true);
$table->StartRow();
$table->AddHeader('Rank');
$table->AddHeader('Name');
$table->AddHeader('Kabal');
$table->AddHeader('Points');
$table->AddHeader('Credits');
$table->EndRow();

function printer($signup, $table){
	
	$ktotal[$kabal->getID()] += reformat($signup->GetPoints());
}

foreach ($ktotal as $id => $points){
	
	$kabal = new Division($id);
	echo $kabal->getName() . ': ' . $points;
	
}

$signups =& $event->GetRankSignups();
ksort($signups);
if ($signups) {
	$sups = array();
	foreach ($signups as $data) {
		foreach ($data as $signup){
			if ($signup->GetRank()){
				printer($signup, $table);
			}
		}
	}
	if (is_array($signups[0])){
		foreach ($signups[0] as $signup){
			printer($signup, $table);
		}
	}
		
}

$table->EndTable();
page_footer();
?>
