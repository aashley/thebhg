<?php
include_once('header.php');
page_header('KAG Hall of Fame');
?>
			<div>
				<h2>KAG Hall of Fame :: Most Points Per Signup (Single KAG)</h2>
				<p>High scoring kabals. These kabals have proven that its not just numbers that wins them KAGs, but talent.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Kabal');
$table->AddHeader('KAG');
$table->AddHeader('Scaled Points');
$table->AddHeader('Total Signups');
$table->AddHeader('Points Per Signup');
$table->EndRow();

$maxima = GetKAGMaxima();
$hunters = array();
foreach (array_unique($maxima) as $points) {
	$kags = implode(', ', array_keys($maxima, $points));
	$result = mysql_query("SELECT kabal, SUM(points) AS points, COUNT(DISTINCT id) AS events, ROUND(SUM(points)/COUNT(DISTINCT id)) as pps, kag FROM kag_signups WHERE state > 0 AND kag IN ($kags) GROUP BY kabal, kag ORDER BY pps DESC, events ASC LIMIT 10", $db);
	if ($result && mysql_num_rows($result))
		while ($row = mysql_fetch_array($result)) {
			$hunters[] = $row;
		}
}

usort($hunters, 'SortPointsDesc');

for ($i = 0; $i < 10; $i++) {
	$kabal =& $roster->GetKabal($hunters[$i]['kabal']);
	$table->StartRow();
	$table->AddCell('<div style="text-align: right">' . number_format($i + 1) . '</div>');
	$table->AddCell('<a href="../kabal.php?kag=' . $row['kag'] . '&amp;kabal=' . $kabal->GetID() . '">' . htmlspecialchars($kabal->GetName()) . '</a>');
	$table->AddCell('<a href="../kag.php?id=' . $hunters[$i]['kag'] . '">KAG ' . roman($hunters[$i]['kag']) . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['points']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['events']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['pps']) . '</div>');
	$table->EndRow();
}

$table->EndTable();

page_footer();
?>
