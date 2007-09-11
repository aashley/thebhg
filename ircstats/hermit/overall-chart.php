<?php
import_request_variables('g');
$db = mysql_connect('localhost', 'thebhg', '1IHfHTsAmILMwpP');
mysql_select_db('ircstats', $db);

ini_set('include_path', ini_get('include_path') . ':jpgraph:/var/www/html/include');
include('jpgraph.php');
include('jpgraph_bar.php');

include('roster.inc');
$roster = new Roster();
$pleb = $roster->GetPerson($id);

$graph = new Graph(640, 480);
$graph->SetScale('textlin');

$start_ts = $start;
$end_ts = $end;
$interval *= 86400;
$words = array();
for ($i = $start_ts; $i <= $end_ts; $i += $interval) {
	$start_int = $i;
	$end_int = ($i + $interval - 1);
	$result = mysql_query("SELECT SUM(words) AS words FROM irc_stats WHERE date BETWEEN $start_int AND $end_int", $db);
	if ($result && mysql_num_rows($result)) {
		$day_words = mysql_result($result, 0, 'words');
		$words[date('Y-m-d', $i)] = $day_words;
	}
}

$barplot = new BarPlot(array_values($words));
$barplot->SetFillColor('blue');
$barplot->SetWidth(0.8);

$graph->Add($barplot);

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->title->Set('Overall Stats');
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->Set('Date');
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->Set('Words');
$graph->yaxis->SetTitleMargin(35);

$graph->img->SetMargin(50, 50, 50, 50);
$graph->SetShadow();

$graph->xaxis->SetTickLabels(array_keys($words));
$graph->xaxis->SetTextTickInterval(ceil(count($words)) / 5);

$graph->Stroke();
?>
