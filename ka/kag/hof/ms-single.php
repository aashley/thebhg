<?php
include_once('header.php');
page_header('KAG Hall of Fame');
?>
			<div>
				<h2>KAG Hall of Fame :: Most Master's Shields (Single KAG)</h2>
				<p>Dominating a KAG is no easy feat. Dominating it to such an extent that a hunter wins more than one Master's Shield is even harder. The hunters below have managed just that.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Hunter');
$table->AddHeader('Kabal');
$table->AddHeader('KAG');
$table->AddHeader('Master\'s Shields');
$table->AddHeader('Completed Events');
$table->EndRow();

$result = mysql_query('SELECT person, kag, kabal, COUNT(DISTINCT id) AS shields FROM kag_signups WHERE state > 0 AND rank = 1 GROUP BY person, kag ORDER BY shields DESC, kag DESC LIMIT 10', $db);
if ($result && mysql_num_rows($result)) {
	$rank = 0;
	while (($row = mysql_fetch_array($result)) && $row['shields'] > 1) {
		$hunter =& $roster->GetPerson($row['person']);
		$kabal =& $roster->GetKabal($row['kabal']);
		$hunter_result = mysql_query('SELECT COUNT(DISTINCT id) AS events FROM kag_signups WHERE person = ' . $row['person'] . ' AND kag = ' . $row['kag'], $db);
		$h_row = mysql_fetch_array($hunter_result);
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
		$table->AddCell('<a href="../hunter.php?kag=' . $row['kag'] . '&amp;id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
		$table->AddCell('<a href="../kabal.php?kag=' . $row['kag'] . '&amp;kabal=' . $kabal->GetID() . '">' . htmlspecialchars($kabal->GetName()) . '</a>');
		$table->AddCell('<a href="../kag.php?id=' . $row['kag'] . '">KAG ' . roman($row['kag']) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['shields']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($h_row['events']) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();

page_footer();
?>
