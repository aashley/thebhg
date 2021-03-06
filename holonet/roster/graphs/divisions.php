<?php
include('header.php');
include('jpgraph_pie.php');

// Construct data.
$divs = $roster->GetDivisions('name');
foreach ($divs as $div) {
	if ($div->GetID() != 16) {
		$labels[] = '';
		$legends[] = $div->GetName() . " (%d)";
		$data[] = $div->GetMemberCount();
		$colours[] = get_div_colour($div);
	}
}

$graph = new PieGraph(400, 300, 'h3r_divisions');
$graph->title->Set('Division Membership');
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
