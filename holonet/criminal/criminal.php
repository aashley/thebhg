<?php
$basic_crim = mysql_query("SELECT * FROM criminals WHERE id=" . $_REQUEST['id'], $db);
if (mysql_result($basic_crim, 0, "organisation")) {
	$crim_result = mysql_query("SELECT criminals.species AS sid, criminals.id, criminals.organisation AS orgid, organisations.name AS organisation, criminals.name, statustypes.status, criminals.price, criminals.description, criminals.age, species.name AS species FROM criminals, organisations, statustypes, species WHERE criminals.organisation=organisations.id AND criminals.status=statustypes.id AND criminals.species=species.id AND criminals.id=" . $_REQUEST['id'], $db);
}
else {
	$crim_result = mysql_query("SELECT criminals.species AS sid, criminals.id, criminals.organisation AS orgid, criminals.name, statustypes.status, criminals.price, criminals.description, criminals.age, species.name AS species FROM criminals, statustypes, species WHERE criminals.status=statustypes.id AND criminals.species=species.id AND criminals.id=" . $_REQUEST['id'], $db);
}

if ($crim_result && mysql_num_rows($crim_result)) {
	$crim = mysql_fetch_array($crim_result);
}

function title() {
	global $crim;
	if (isset($crim)) {
		return 'Criminal :: ' . stripslashes($crim['name']);
	}
	else {
		return 'Criminal ';
	}
}

function output() {
	global $db, $crim;

	if (empty($crim)) {
		echo 'Unable to load information.';
		return;
	}

	$table = new Table('Information');
	$table->AddRow('Name:', stripslashes($crim['name']));
	$table->AddRow('Status:', stripslashes($crim['status']));
	$table->AddRow('Organisation:', ($crim['orgid'] ? '<a href="' . internal_link('organisation', array('id'=>$crim['orgid'])) . '">' . stripslashes($crim['organisation']) . '</a>' : 'No known affiliation'));
	$table->AddRow('Informant Price:', ($crim['price'] ? (number_format($crim['price']) . ' ICs') : 'N/A'));
	$table->AddRow('Age:', $crim['age']);
	$table->AddRow('Species:', '<a href="' . internal_link('species', array('id'=>$crim['sid'])) . '">' . stripslashes($crim['species']) . '</a>');
	$table->EndTable();

	hr();

	$table = new Table('Criminal Record', true);
	$table->StartRow();
	$table->AddHeader('Crime');
	$table->AddHeader('Sentence');
	$table->EndRow();
	$record_result = mysql_query("SELECT crimetypes.name AS type, crimes.sentence FROM crimes, crimetypes WHERE crimes.type=crimetypes.id AND crimes.perp=" . $_REQUEST['id'] . " ORDER BY crimes.id ASC", $db);
	if ($record_result && mysql_num_rows($record_result)) {
		while ($record = mysql_fetch_array($record_result)) {
			$table->AddRow(stripslashes($record['type']), format_sentence($record['sentence']));
		}
	}
	else {
		$table->StartRow();
		$table->AddCell('No criminal record.', 2);
		$table->EndRow();
	}
	$table->EndTable();

	hr();

	$table = new Table('Skills', true);
	$table->StartRow();
	$table->AddHeader('Skill');
	$table->AddHeader('Ability');
	$table->EndRow();
	$skills_result = mysql_query("SELECT skilltypes.id, skilltypes.name, skills.ability FROM skills, skilltypes WHERE skills.skill=skilltypes.id AND skills.person=" . $_REQUEST['id'] . " ORDER BY skilltypes.name ASC", $db);
	if ($skills_result && mysql_num_rows($skills_result)) {
		while ($skill = mysql_fetch_array($skills_result)) {
			$table->AddRow('<a href="' . internal_link('skill', array('id'=>$skill['id'])) . '">' . stripslashes($skill['name']) . '</a>', $skill['ability'] . ' out of 10');
		}
	}
	else {
		$table->StartRow();
		$table->AddCell('No known skills.', 2);
		$table->EndRow();
	}
	$table->EndTable();

	hr();

	echo '<b>Description</b><br>' . (strlen($crim["description"]) ? stripslashes($crim["description"]) : 'No description has been added for this criminal yet.');
}
?>
