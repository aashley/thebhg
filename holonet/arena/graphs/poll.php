<?php
include('header.php');
include('jpgraph_pie.php');

// Construct data.
$poll = new Poll(1);
$votes = $poll->GetVotes();
$i = 1;
foreach ($poll->GetOptions() as $option){
	$labels[] = '';
	$legends[] = $option->GetQuesion() . " (%d)";
	$data[] = $votes[$option->GetID()];
	$colours[] = get_colour($i);
	$i++;
}

$graph = new PieGraph(400, 300, 'h3r_poll');
$graph->title->Set($poll->GetQuestion());
$graph->title->SetFont(FF_VERDANA, FS_BOLD, 14);
$graph->SetBox(false);

$graph->legend->SetFont(FF_VERDANA, FS_NORMAL, 8);
$graph->legend->Pos(0.01, 0.5, 'right', 'center');

$plot = new PiePlot($data);
$plot->SetLabels($labels);
$plot->SetSliceColors($colours);
$plot->SetShadow();
$plot->SetLegends($legends);
$plot->SetLabelType(PIE_VALUE_ABS);
$plot->SetCenter(0.25);

$graph->Add($plot);
$graph->Stroke();
?>
