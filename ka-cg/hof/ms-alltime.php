<?php
include_once('header.php');
page_header('CG Hall of Fame');
?>
			<div>
				<h2>CG Hall of Fame :: Most Master's Shields (All-Time)</h2>
				<p>Winning even one Master's Shield is a massive achievement. It demonstrates that a hunter is among the best in the entire BHG in their chosen field, and is a force to be reckoned with. Therefore, one can immediately tell that a hunter who has won multiple Master's Shields is truly one of the greats. Below is a list of the greatest.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Hunter');
$table->AddHeader('Master\'s Shields');
$table->AddHeader('CGs');
$table->AddHeader('Completed Events');
$table->EndRow();

$result = mysql_query('SELECT person, COUNT(DISTINCT id) AS shields FROM cg_signups WHERE state > 0 AND rank = 1 GROUP BY person ORDER BY shields DESC LIMIT 10', $db);
if ($result && mysql_num_rows($result)) {
	$rank = 0;
	while ($row = mysql_fetch_array($result)) {
		$hunter =& $roster->GetPerson($row['person']);
		$hunter_result = mysql_query('SELECT COUNT(DISTINCT id) AS events, COUNT(DISTINCT cg) AS cgs FROM cg_signups WHERE person = ' . $row['person'], $db);
		$h_row = mysql_fetch_array($hunter_result);
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
		$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['shields']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($h_row['cgs']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($h_row['events']) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();

page_footer();
?>
