<?php
$basic_crim = mysql_query("SELECT * FROM organisations WHERE id=$id");
if (mysql_result($basic_crim, 0, "leader")) {
	$crim_result = mysql_query("SELECT businesstypes.name AS business, criminals.name AS leader, organisations.leader AS lid, organisations.name, organisations.description, planets.name AS planet, organisations.homeworld FROM organisations, criminals, businesstypes, planets WHERE organisations.leader=criminals.id AND organisations.business=businesstypes.id AND organisations.homeworld=planets.id AND organisations.id=" . $_REQUEST['id'], $db);
}
else {
	$crim_result = mysql_query("SELECT businesstypes.name AS business, organisations.leader AS lid, organisations.name, organisations.description, planets.name AS planet, organisations.homeworld FROM organisations, businesstypes, planets WHERE organisations.business=businesstypes.id AND organisations.homeworld=planets.id AND organisations.id=" . $_REQUEST['id'], $db);
}
if ($crim_result && mysql_num_rows($crim_result)) {
	$crim = mysql_fetch_array($crim_result);
}

function title() {
	global $crim;
	if (isset($crim)) {
		return 'Organisation :: ' . stripslashes($crim['name']);
	}
	else {
		return 'Organisation';
	}
}

function output() {
	global $crim, $db;

	$table = new Table('Basic Information');
	$table->AddRow('Name:', stripslashes($crim['name']));
	$table->AddRow('Business:', stripslashes($crim['business']));
	$table->AddRow('Leader:', ($crim['lid'] ? '<a href="' . internal_link('criminal', array('id'=>$crim['lid'])) . '">' . stripslashes($crim['leader']) . '</a>' : 'No known leader'));
	$table->AddRow('Homeworld:', '<a href="' . internal_link('planet', array('id'=>$crim['homeworld'])) . '">' . stripslashes($crim['planet']) . '</a>');
	$table->EndTable();

	hr();
	
	$table = new Table('Known Members', true);
	$record_result = mysql_query("SELECT id, name FROM criminals WHERE organisation=" . $_REQUEST['id'] . " ORDER BY name ASC", $db);
	if ($record_result && mysql_num_rows($record_result)) {
		while ($record = mysql_fetch_array($record_result)) {
			$table->AddRow('<a href="' . internal_link('criminal', array('id'=>$record['id'])) . '">' . stripslashes($record['name']) . '</a>');
		}
	}
	else {
		$table->AddRow('No known members.');
	}
	$table->EndTable();

	hr();

	echo '<b>Description</b><br>';
	if (strlen($crim["description"])) echo stripslashes($crim["description"]);
}
?>
