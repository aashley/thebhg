<?php
include_once('header.php');
page_header('Kabal Restructure Proposal');

$active = array();

foreach ($roster->getDivisions() as $kabal){
	if (in_array($kabal->getID(), array(10, 16, 18, 12, 11)))
		continue;
	foreach ($kabal->getMembers() as $person)
		$active[] = $person->getID();

}
		
$active = implode(',', $active);

$maxima = GetKAGMaxima();
$hunters = array();
$total = 0;
foreach (array_unique($maxima) as $points) {
	$kags = implode(', ', array_keys($maxima, $points));
	$result = mysql_query("SELECT person, SUM(points) AS points, COUNT(DISTINCT id) AS events, COUNT(DISTINCT kag) AS kags FROM kag_signups WHERE state > 0 AND kag IN ($kags) AND person IN ($active) GROUP BY person ORDER BY person", $db);
	if ($result && mysql_num_rows($result))
		while ($row = mysql_fetch_array($result)) {
			if (isset($hunters[$row['person']])) {
				$hunters[$row['person']]['points'] += ScalePointsWithMaximum($points, $row['points'], $row['events']);
				$hunters[$row['person']]['events'] += $row['events'];
				$hunters[$row['person']]['kags'] += $row['kags'];
				$total += $row['points'];
			}
			else {
				$row['points'] = ScalePointsWithMaximum($points, $row['points'], $row['events']);
				$total += $row['points'];
				$hunters[$row['person']] = $row;
			}
		}
}

usort($hunters, 'SortPointsDesc');

$total /= 5;

$kabal[1] = array();
$kabal[2] = array();
$kabal[3] = array();
$kabal[4] = array();
$kabal[5] = array();

$i = 1;

foreach ($hunters as $id => $array){
	echo $id; 
	exit;
}
	
print_r($kabal[1]);

page_footer();

exit;

for ($i = 1; $i <= 5; $i++){
	echo '<div><h2>Kabal ' . $i . '</h2>Total Points: ' . number_format(array_sum($kabal[$i])) . '<br /><b>Members</b><br />';
	foreach ($kabal[$i] as $person => $pts)
		echo $roster->getPerson($person)->getName() . '<br />';
}

exit;


for ($i = 0; $i < 10; $i++) {
	$hunter =& $roster->GetPerson($hunters[$i]['person']);
	$table->StartRow();
	$table->AddCell('<div style="text-align: right">' . number_format($i + 1) . '</div>');
	$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['points']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['kags']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['events']) . '</div>');
	$table->EndRow();
}

$table->EndTable();


?>
