<?php
include('header.php');
include('jpgraph_bar.php');

$result = mysql_query('SELECT roster_rank.id, COUNT(*) AS num FROM roster_roster, roster_rank WHERE roster_roster.rank=roster_rank.id AND roster_roster.division NOT IN (0, 16) GROUP BY roster_rank.id ORDER BY roster_rank.order ASC', $roster->roster_db);
while ($row = mysql_fetch_array($result)) {
	$rank = $roster->GetRank($row['id']);
	$labels[] = $rank->GetAbbrev();
	$data[] = $row['num'];
}

$graph = new Graph(400, 300, 'h3r_ranks');
$graph->SetScale('textlin');
$graph->SetMarginColor('white');

$graph->img->SetMargin(50,30,30,50);

$graph->title->Set('Rank Statistics');
$graph->title->SetFont(FF_VERDANA, FS_BOLD, 14);

$graph->xaxis->title->Set('Ranks');
$graph->xaxis->title->SetFont(FF_VERDANA, FS_BOLD, 8);
$graph->xaxis->SetTickLabels($labels);
$graph->xaxis->SetLabelAngle(45);
$graph->xaxis->SetFont(FF_VERDANA, FS_NORMAL, 8);
$graph->xaxis->SetTitleMargin(20);

$graph->yaxis->title->Set('Members');
$graph->yaxis->title->SetFont(FF_VERDANA, FS_BOLD, 8);
$graph->yaxis->SetFont(FF_VERDANA, FS_NORMAL, 8);
$graph->yaxis->SetTitleMargin(35);

$plot = new BarPlot($data);
$plot->SetWidth(0.75);

$graph->Add($plot);
$graph->Stroke();
?>
