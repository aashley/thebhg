<?php
include_once('header.php');

$event =& $ka->GetEvent($_REQUEST['id']);
$cg =& $event->GetCG();
page_header('CG ' . roman($cg->GetID()) . ' :: ' . $event->GetName());
add_menu(array('CG ' . roman($cg->GetID())=>'cg/cg.php?id=' . $cg->GetID()));

$table = new Table('', true);
$table->StartRow();
$table->AddHeader('Name');
$table->AddHeader('Cadre');
$table->AddHeader('Points');
$table->AddHeader('Credits');
$table->EndRow();

$signups =& $event->GetSignups();
if ($signups) {
	$sups = array();
	foreach ($signups as $signup) {
		$person =& $signup->GetPerson();
		$cadre =& $signup->GetCadre();

		$table->StartRow();
		$table->AddCell('<a href="hunter.php?cg=' . $cg->GetID() . '&amp;id=' . $person->GetID() . '">' . $person->GetName() . '</a>');
		$table->AddCell('<a href="cadre.php?cg=' . $cg->GetID() . '&amp;cadre=' . $cadre->GetID() . '">' . $cadre->GetName() . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($signup->GetPoints()) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($signup->GetCredits()) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();
page_footer();
?>
