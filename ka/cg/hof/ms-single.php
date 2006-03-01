<?php
include_once('header.php');
page_header('CG Hall of Fame');
?>
			<div>
				<h2>CG Hall of Fame :: Most Master's Shields (Single CG)</h2>
				<p>Dominating a CG is no easy feat. Dominating it to such an extent that a hunter wins more than one Master's Shield is even harder. The hunters below have managed just that.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Hunter');
$table->AddHeader('Cadre');
$table->AddHeader('CG');
$table->AddHeader('Master\'s Shields');
$table->AddHeader('Completed Events');
$table->EndRow();

$result = mysql_query('SELECT person, cg, cadre, COUNT(DISTINCT id) AS shields FROM cg_signups WHERE state > 0 AND rank = 1 GROUP BY person, cg ORDER BY shields DESC, cg DESC LIMIT 10', $db);
if ($result && mysql_num_rows($result)) {
	$rank = 0;
	while (($row = mysql_fetch_array($result)) && $row['shields'] > 1) {
		$hunter =& $roster->GetPerson($row['person']);
		$cadre =& $roster->GetCadre($row['cadre']);
		$hunter_result = mysql_query('SELECT COUNT(DISTINCT id) AS events FROM cg_signups WHERE person = ' . $row['person'] . ' AND cg = ' . $row['cg'], $db);
		$h_row = mysql_fetch_array($hunter_result);
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
		$table->AddCell('<a href="../hunter.php?cg=' . $row['cg'] . '&amp;id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
		$table->AddCell('<a href="../cadre.php?cg=' . $row['cg'] . '&amp;cadre=' . $cadre->GetID() . '">' . htmlspecialchars($cadre->GetName()) . '</a>');
		$table->AddCell('<a href="../cg.php?id=' . $row['cg'] . '">CG ' . roman($row['cg']) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['shields']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($h_row['events']) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();

page_footer();
?>
