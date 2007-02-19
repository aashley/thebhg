<?php
function title() {
	return 'Statistics';
}

function output() {
	global $roster;

	roster_header();

	$table = new Table('Overall Statistics');
	$result = mysql_query('SELECT COUNT(*) AS num FROM roster_roster WHERE division NOT IN (0,16)', $roster->roster_db);
	$tmc = mysql_result($result, 0, 'num');
	$table->AddRow('Total Member Count:', $tmc);

	$result = mysql_query('SELECT COUNT(*) AS num FROM roster_roster WHERE division NOT IN (0,12,16)', $roster->roster_db);
	$amc = mysql_result($result, 0, 'num');
	$table->AddRow('Active Member Count:', $amc);
	$table->EndTable();

	hr();

	$table = new Table('Overall Kabal Authority Statistics');
	$result = mysql_query('SELECT COUNT(*) AS num FROM roster_roster, roster_divisions WHERE roster_divisions.id=roster_roster.division AND roster_divisions.category=2', $roster->roster_db);
	$ka = $roster->GetDivisionCategory(2);
	$kabals = $ka->GetDivisions();
	$mika = mysql_result($result, 0, 'num');
	$table->AddRow('Number of Members in KA:', $mika);
	$table->AddRow('Percentage of Total Members in KA:', number_format(100 * $mika / $tmc, 1) . '%');
	$table->AddRow('Average Number of Members per Kabal:', number_format($mika / count($kabals), 1));
	$table->EndTable();
	unset($ka);
	unset($kabals);
	
	hr();
	echo '<table border=0 width="100%"><tr valign="top"><td>';

	$divs = $roster->GetDivisions('name');
	$table = new Table('Kabal Membership Totals');
	$table->StartRow();
	$table->AddHeader('Kabal');
	$table->AddHeader('Members');
	$table->EndRow();
	foreach ($divs as $div) {
		if ($div->IsKabal()) {
			$members = $div->GetMemberCount();
			$table->AddRow('<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a>', '<div style="text-align: right">' . number_format($members) . '</div>');
		}
	}
	$table->EndTable();

	hr();

	$table = new Table('Wings');
	$table->StartRow();
	$table->AddHeader('Wing');
	$table->AddHeader('Members');
	$table->EndRow();
	foreach ($divs as $div) {
		if ($div->IsWing()) {
			$members = $div->GetMemberCount();
			$table->AddRow('<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a>', '<div style="text-align: right">' . number_format($members) . '</div>');
		}
	}
	$table->EndTable();

	hr();

	$table = new Table('Other Divisions');
	$table->StartRow();
	$table->AddHeader('Division');
	$table->AddHeader('Members');
	$table->EndRow();
	foreach ($divs as $div) {
		if (!($div->GetID() == 16 || $div->IsKabal() || $div->IsWing())) {
			$members = $div->GetMemberCount();
			$table->AddRow('<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a>', '<div style="text-align: right">' . number_format($members) . '</div>');
		}
	}
	$table->EndTable();

	echo '</td><td width=400><img src="roster/graphs/divisions.php" alt="Divisions Graph" width=400 height=300 border=0></td></tr></table>';
	hr();
	echo '<table border=0 width="100%"><tr valign="top"><td>';

	$result = mysql_query('SELECT roster_rank.name, roster_rank.id, COUNT(*) AS num FROM roster_roster, roster_rank WHERE roster_roster.rank=roster_rank.id AND roster_roster.division NOT IN (0, 16) GROUP BY roster_rank.id ORDER BY roster_rank.order ASC', $roster->roster_db);
	$activeResult = mysql_query('SELECT roster_rank.name, roster_rank.id, COUNT(*) AS num FROM roster_roster, roster_rank WHERE roster_roster.rank=roster_rank.id AND roster_roster.division NOT IN (0, 12, 16) GROUP BY roster_rank.id ORDER BY roster_rank.order ASC', $roster->roster_db);
	$table = new Table('Rank Statistics');
	$table->StartRow();
	$table->AddHeader('Rank');
	$table->AddHeader('Active Members');
	$table->AddHeader('Percentage');
	$table->AddHeader('Total Members');
	$table->AddHeader('Percentage');
	$table->EndRow();
	while (($row = mysql_fetch_array($result)) && ($active = mysql_fetch_array($activeResult))) {
		$table->AddRow('<a href="' . internal_link('rank', array('id'=>$row['id'])) . '">' . stripslashes($row['name']) . '</a>', '<div style="text-align: right">' . number_format($active['num']) . '</div>', '<div style="text-align: right">' . number_format(100 * $active['num'] / $amc, 1) . '%</div>', '<div style="text-align: right">' . number_format($row['num']) . '</div>', '<div style="text-align: right">' . number_format(100 * $row['num'] / $tmc, 1) . '%</div>');
	}
	$table->EndTable();

	echo '</td><td width=400><img src="roster/graphs/ranks.php" alt="Ranks Graph" width=400 height=300 border=0></td></tr></table>';

	roster_footer();
}
?>
