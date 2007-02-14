<?php
include_once('citadel.inc');
$citadel = new Citadel();

$pleb = $roster->GetPerson($_REQUEST['id']);

function title() {
	global $pleb;

	return 'Courses :: ' . $pleb->GetName();
}

function output() {
	global $pleb, $citadel;

	roster_header();

	$table = new Table('', true);
	$table->StartRow();
	$table->AddHeader('Date');
	$table->AddHeader('Course');
	$table->EndRow();

	$results = $citadel->GetPersonsResults($pleb, CITADEL_PASSED);
	if (count($results)) {
		usort($results, 'citadel_recent_sort');
		foreach ($results as $cex) {
			$exam = $cex->GetExam();
			$table->AddRow(date('j F Y', $cex->GetDateTaken()), 'Passed ' . html_escape($exam->GetName()) . ' exam with a score of ' . number_format($cex->GetScore(), 0) . '%.');
		}
	}
	else {
		$table->StartRow();
		$table->AddCell('This hunter has not passed any courses yet.', 2);
		$table->EndRow();
	}
	$table->EndTable();
	
	roster_footer();
}
?>
