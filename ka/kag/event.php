<?php
include_once('header.php');

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
	global $kag;
	$person =& $signup->GetPerson();
	$kabal =& $signup->GetKabal();

	$table->StartRow();
	$table->AddCell($signup->GetRank());
	$table->AddCell('<a href="hunter.php?kag=' . $kag->GetID() . '&amp;id=' . $person->GetID() . '">' . $person->GetName() . '</a>');
	$table->AddCell('<a href="kabal.php?kag=' . $kag->GetID() . '&amp;kabal=' . $kabal->GetID() . '">' . $kabal->GetName() . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($signup->GetPoints()) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($signup->GetCredits()) . '</div>');
	$table->EndRow();
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
