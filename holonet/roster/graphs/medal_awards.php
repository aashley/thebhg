<?php
include('header.php');
include('jpgraph_bar.php');

$result = mysql_query('select month(from_unixtime(date)) as month, year(from_unixtime(date)) as year, count(*) as medals from mb_awarded_medals where medal<=4 or medal between 20 and 42 group by month, year order by year asc, month asc', $roster->roster_db);
$first = true;
while ($row = mysql_fetch_array($result)) {
	$ts = mktime(0, 0, 0, $row['month'], 1, $row['year']);
	if ($first || $row['month'] == 1 || $row['month'] == 7) {
		$labels[] = date('M \'y', $ts);
		$first = false;
	}
	else {
		$labels[] = '';
	}
	$data[] = $row['medals'];
}

$graph = new Graph(400, 300, 'h3r_medal_awards');
$graph->SetScale('textlin');
$graph->SetMarginColor('white');

$graph->img->SetMargin(50,30,30,50);

$graph->title->Set('Medal Awards');
$graph->title->SetFont(FF_VERDANA, FS_BOLD, 14);

$graph->xaxis->title->Set('Months');
$graph->xaxis->title->SetFont(FF_VERDANA, FS_BOLD, 8);
$graph->xaxis->SetTickLabels($labels);
$graph->xaxis->SetLabelAngle(45);
$graph->xaxis->SetFont(FF_VERDANA, FS_NORMAL, 8);
$graph->xaxis->SetTitleMargin(30);

$graph->yaxis->title->Set('Medals');
$graph->yaxis->title->SetFont(FF_VERDANA, FS_BOLD, 8);
$graph->yaxis->SetFont(FF_VERDANA, FS_NORMAL, 8);
$graph->yaxis->SetTitleMargin(35);

$plot = new BarPlot($data);
$plot->SetWidth(0.75);

$graph->Add($plot);
$graph->Stroke();
?>
