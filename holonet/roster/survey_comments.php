<?php
function title() {
	return 'Survey Results';
}

function auth($person) {
	return ($person->GetID() == 666 || $person->getID() == 94);
}

function output() {
	global $db, $roster;
	
	roster_header();

	$result = mysql_query('SELECT * FROM qa_answers WHERE question=24 AND answer != ""', $db);
	$table = new Table();
	while ($row = mysql_fetch_array($result)) {
		$pleb = $roster->GetPerson($row['person']);
		$table->AddRow($pleb->GetName(), html_escape(stripslashes($row['answer'])));
	}
	$table->EndTable();

	roster_footer();
}
?>
