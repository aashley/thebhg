<?php
function title() {
	return 'Organisations';
}

function output() {
	global $db;

	$crims = mysql_query("SELECT organisations.id, organisations.name, organisations.leader FROM organisations ORDER BY organisations.name ASC", $db);
	if ($crims && mysql_num_rows($crims)) {
		$table = new Table('', true);
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Leader');
		$table->EndRow();
		while ($crim = mysql_fetch_array($crims)) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('organisation', array('id'=>$crim['id'])) . '">' . stripslashes($crim['name']) . '</a>');
			if ($crim["leader"]) {
				$leader = mysql_query("SELECT name FROM criminals WHERE id=" . $crim["leader"], $db);
				$lname = stripslashes(mysql_result($leader, 0, "name"));
				$table->AddCell('<a href="' . internal_link('criminal', array('id'=>$crim['leader'])) . '">' . $lname . '</a>');
			}
			else {
				$table->AddCell('No leader');
			}
			$table->EndRow();
		}
		$table->EndTable();
	}
	else {
		echo mysql_error($db);
		echo "No organisations found.<BR><BR>\n";
	}
}
?>
