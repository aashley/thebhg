<?php
include_once('header.php');
page_header('KAG Hall of Shame');
?>
			<div>
				<h2>KAG Hall of Shame :: Most DNPs</h2>
				<p>Nobody likes to DNP. Doing so is embarrassing, and incurs the wrath of one's kabal-mates, who tend to be displeased when their kabal loses out because of the actions of one hunter. To make matters worse, nowadays you even lose significant credit amounts for a DNP. Therefore, this can be considered a Hall of Shame category.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Hunter');
$table->AddHeader('DNPs');
$table->AddHeader('KAGs');
$table->AddHeader('Completed Events');
$table->EndRow();

$result = mysql_query('SELECT person, COUNT(DISTINCT id) AS dnps FROM kag_signups WHERE state = 2 GROUP BY person ORDER BY dnps DESC LIMIT 10', $db);
if ($result && mysql_num_rows($result)) {
	$rank = 0;
	while ($row = mysql_fetch_array($result)) {
		$hunter =& $roster->GetPerson($row['person']);
		$hunter_result = mysql_query('SELECT COUNT(DISTINCT id) AS events, COUNT(DISTINCT kag) AS kags FROM kag_signups WHERE person = ' . $row['person'], $db);
		$h_row = mysql_fetch_array($hunter_result);
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
		$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['dnps']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($h_row['kags']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($h_row['events']) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();

page_footer();
?>
