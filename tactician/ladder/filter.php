<?php

include_once 'header.php';

page_header('Filter the Tactician Ladder');
	
	$form = new Form('ladder.php');
	
	$form->addSectionTitle('Tactician Ladder Filter');
	
	$form->startSelect('Filter By Kabal', 'kabal');
	$form->addOption('-1', 'All');
	
	foreach ($roster->getKabals() as $dbbal) {
	
		$form->addOption($dbbal->getID(), $dbbal->getName());
			
	}
	
	$form->endSelect();
	
	$form->startSelect('Month', 'dm', date('m')-1);
	foreach (range(01,12) as $month){
		$form->addOption($month, date('F', mktime(0, 0, 0, $month, 1, 2000)));
	}
	$form->endSelect();
	
	$form->startSelect('Year', 'dy', date('y'));
	foreach (range('04', date('y')) as $year){
		$form->addOption($year, date('Y', mktime(0, 0, 0, 1, 1, $year)));
	}
	$form->endSelect();
	
	$form->addCheckBox('Format for Message Boards?', 'bt', 1);
	$form->addCheckBox('Display Details Instead of Ladder?', 'details', 1);
	$form->addCheckBox('Use Global Ladder Rank?', 'globalrank', 1, true);
	
	$form->addSubmitButton('Display Ladder', 'Display Ladder');
	
	$form->endForm();

page_footer();
?>