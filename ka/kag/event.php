<?php
include_once('header.php');

$event =& $ka->GetEvent($_REQUEST['id']);
$kag =& $event->GetKAG();
page_header('KAG ' . roman($kag->GetID()) . ' :: ' . $event->GetName());
add_menu(array('KAG ' . roman($kag->GetID())=>'kag/kag.php?id=' . $kag->GetID()));

$table = new Table('', true);
$table->StartRow();
$table->AddHeader('Name');
$table->AddHeader('Kabal');
$table->AddHeader('Points');
$table->AddHeader('Credits');
$table->EndRow();

$signups =& $event->GetSignups();
if ($signups) {
	$sups = array();
	foreach ($signups as $signup) {
		$person =& $signup->GetPerson();
		$kabal =& $signup->GetKabal();

		$table->StartRow();
		$table->AddCell('<a href="hunter.php?kag=' . $kag->GetID() . '&amp;id=' . $person->GetID() . '">' . $person->GetName() . '</a>');
		$table->AddCell('<a href="kabal.php?kag=' . $kag->GetID() . '&amp;kabal=' . $kabal->GetID() . '">' . $kabal->GetName() . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($signup->GetPoints()) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($signup->GetCredits()) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();
page_footer();
?>
