<?php
function title() {
	return 'Experience Points';
}

function coders() {
	return array(666);
}

function output() {
	global $roster;

	roster_header();

	$xp = array();
	$unused = array();
	$result = mysql_query('SELECT person, xp FROM cs_unused_xp', $roster->roster_db);
	while ($row = mysql_fetch_array($result)) {
		$xp[$row['person']] = $row['xp'];
		$unused[$row['person']] = $row['xp'];
		$used_result = mysql_query('SELECT class, COUNT(DISTINCT id) AS points FROM cs_used_xp WHERE person=' . $row['person'] . ' GROUP BY class', $roster->roster_db);
		if ($used_result && mysql_num_rows($used_result)) {
			while ($used_row = mysql_fetch_array($used_result)) {
				switch ($used_row['class']) {
					case -1:
						$mult = 400;
						break;
					case 7:
						$mult = 500;
						break;
					case 2:
						$mult = 2250;
						break;
					case 3:
						$mult = 2500;
						break;
					default:
						$mult = 0;
				}
				$xp[$row['person']] += ($mult * $used_row['points']);
			}
		}
	}

	arsort($xp);

	$row = 0;
	$rank = 0;
	$last_xp = -1;
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('');
	$table->AddHeader('Name');
	$table->AddHeader('Points');
	$table->AddHeader('Unused');
	$table->EndRow();
	foreach ($xp as $rid=>$points) {
		$person = $roster->GetPerson($rid);
		$row++;
		if ($last_xp != $points) {
			$rank = $row;
			$last_xp = $points;
		}
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format($rank) . '</div>');
		$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$rid)) . '">' . html_escape($person->GetName()) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($points) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($unused[$rid]) . '</div>');
		$table->EndRow();
	}
	$table->EndTable();

	roster_footer();
}
?>
