<?php
function title() {
	return 'Medal Awards';
}

function output() {
	global $mb, $roster;

	roster_header();
	echo 'Note that only the following medals are counted: ODP, ME, HM, GHP, BoH, GP, SP, LC.';
	hr();

	$result = mysql_query('select month(from_unixtime(date)) as month, year(from_unixtime(date)) as year, count(*) as medals from mb_awarded_medals where medal<=4 or medal between 20 and 42 group by month, year order by year asc, month asc', $roster->roster_db);
	if ($result && mysql_num_rows($result)) {
		$table = new Table();
		$table->StartRow();
		$table->AddHeader('Month');
		$table->AddHeader('Medals');
		$table->EndRow();
		while ($row = mysql_fetch_array($result)) {
			$ts = mktime(0, 0, 0, $row['month'], 1, $row['year']);
			$table->AddRow(date('F Y', $ts), number_format($row['medals']));
		}
		$table->EndTable();
	}

	hr();

	echo '<img src="roster/graphs/medal_awards.php" height=300 width=400 alt="Medal Awards" border=0>';
	
	roster_footer();
}
?>
