<?php
include_once('header.php');
page_header('CG Hall of Shame');
?>
			<div>
				<h2>CG Hall of Shame :: Highest DNP Rate</h2>
				<p>Nobody likes to DNP. Doing so is embarrassing, and incurs the wrath of one's cadre-mates, who tend to be displeased when their cadre loses out because of the actions of one hunter. To make matters worse, nowadays you even lose significant credit amounts for a DNP. Therefore, this can be considered a Hall of Shame category.</p>
				<p>Qualification: Minimum ten events.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Hunter');
$table->AddHeader('DNP Percentage');
$table->AddHeader('DNPs');
$table->AddHeader('CGs');
$table->AddHeader('Completed Events');
$table->EndRow();

$hunter_dnps = array();
$hunter_dnp_av = array();
$hunter_events = array();
$hunter_cgs = array();
$result = mysql_query('SELECT person, COUNT(DISTINCT id) AS events, COUNT(DISTINCT cg) AS cgs FROM cg_signups WHERE state > 0 GROUP BY person ORDER BY person ASC', $db);
while ($row = mysql_fetch_array($result)) {
	$hunter_events[$row['person']] = $row['events'];
	$hunter_cgs[$row['person']] = $row['cgs'];
}
$result = mysql_query('SELECT person, COUNT(DISTINCT id) AS dnps FROM cg_signups WHERE state = 2 GROUP BY person ORDER BY dnps DESC', $db);
while ($row = mysql_fetch_array($result)) {
	$hunter_dnps[$row['person']] = $row['dnps'];
}
foreach ($hunter_events as $id=>$events) {
	$hunter_dnp_av[$id] = $hunter_dnps[$id] / $events;
}
arsort($hunter_dnp_av);
$rank = 0;
foreach ($hunter_dnp_av as $id=>$average) {
	if ($hunter_events[$id] >= 10) {
		$hunter =& $roster->GetPerson($id);
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
		$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format(100 * $average, 1) . '%</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($hunter_dnps[$id]) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($hunter_cgs[$id]) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($hunter_events[$id]) . '</div>');
		$table->EndRow();
		if ($rank >= 10) {
			break;
		}
	}
}

$table->EndTable();

page_footer();
?>
