<?php
$db = mysql_connect('localhost', 'thebhg_lawngnome', 'thej3rchr0nicles');
mysql_select_db('thebhg_lawngnome', $db);

ini_set('include_path', ini_get('include_path') . ':jpgraph:/var/www/html/include');
include('jpgraph.php');
include('jpgraph_bar.php');

import_request_variables('g');

include('roster.inc');
$roster = new Roster();
$pleb = $roster->GetPerson($id);

$graph = new Graph(640, 480);
$graph->SetScale('textlin');

$words = array();
for ($i = $start; $i <= $end; $i += 86400) {
	$result = mysql_query("SELECT SUM(words) AS words FROM irc_stats WHERE person=$id AND date BETWEEN UNIX_TIMESTAMP(\"" . date('Y-m-d', $i) . '") AND UNIX_TIMESTAMP("' . date('Y-m-d', $i) . '")+86399 AND words>0', $db);
	if ($result && mysql_num_rows($result)) {
		$words[date('Y-m-d', $i)] = mysql_result($result, 0, 'words');
	}
	else $words[date('Y-m-d', $i)] = '0';
}

$barplot = new BarPlot(array_values($words));
$barplot->SetFillColor('blue');
$barplot->SetWidth(0.8);

$graph->Add($barplot);

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->title->Set('Person-Specific Stats :: ' . $pleb->GetName());
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
