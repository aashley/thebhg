<?php
include_once('header.php');
page_header('CG Hall of Fame');
?>
			<div>
				<h2>CG Hall of Fame :: Most Points (Single CG)</h2>
				<p>High scoring hunters. Hunters love them when they're in the same cadre as them, and hate them when they're in opposing cadres. The ability to dominate a CG is a rare one, and can be the difference between a cadre receiving a Badge of Supremacy or not. These hunters have shown that they can take a CG by the scruff of the neck and dominate it.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Hunter');
$table->AddHeader('Cadre');
$table->AddHeader('CG');
$table->AddHeader('Points');
$table->AddHeader('Completed Events');
$table->EndRow();

$result = mysql_query('SELECT cg_signups.person, SUM(cg_signups.points) AS points, COUNT(DISTINCT cg_signups.id) AS events, cg_signups.cg, cg_signups.cadre FROM cg_signups, cg_events WHERE cg_signups.state > 0 AND cg_events.id = cg_signups.event AND cg_events.team = 0 GROUP BY cg_signups.person, cg_signups.cg ORDER BY points DESC, events ASC, cg_signups.cg ASC LIMIT 10', $db);
if ($result && mysql_num_rows($result)) {
	$rank = 0;
	while ($row = mysql_fetch_array($result)) {
		$hunter =& $roster->GetPerson($row['person']);
		$cadre =& $roster->GetCadre($row['cadre']);
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
		$table->AddCell('<a href="../hunter.php?cg=' . $row['cg'] . '&amp;id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
		$table->AddCell('<a href="../cadre.php?cg=' . $row['cg'] . '&amp;cadre=' . $cadre->GetID() . '">' . htmlspecialchars($cadre->GetName()) . '</a>');
		$table->AddCell('<a href="../cg.php?id=' . $row['cg'] . '">CG ' . roman($row['cg']) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['points']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['events']) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();

page_footer();
?>
