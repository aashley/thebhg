<?php
/* Arguments
 * xaxis : X-axis label
 * yaxis : Y-axis label
 * title : Graph title
 * min : Minimum value
 * max : Maximum value
 * val : Values, seperated by commas
 * label : Labels, seperated by commas
 * xskip : Ticks to skip on the x-axis
 */

ini_set('include_path', ini_get('include_path') . ':/home/virtual/fst2/home/boards/public_html/jpgraph/src');
include('jpgraph.php');
include('jpgraph_bar.php');

$val = explode(',', $val);
$label = explode(',', $label);

$graph = new Graph(500, 400);
if ($min || $max) {
	$graph->SetScale('textlin', $min, $max);
}
else {
	$graph->SetScale('textlin');
}

$barplot = new BarPlot($val);
$barplot->SetFillColor('blue');
$barplot->SetWidth(0.8);

$graph->Add($barplot);

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->title->Set($title);
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->Set($xaxis);
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->Set($yaxis);
$graph->yaxis->SetTitleMargin(35);

$graph->img->SetMargin(50, 50, 50, 50);
$graph->SetShadow();

$graph->xaxis->SetTickLabels($label);
if ($xskip) {
	$graph->xaxis->SetTextTickInterval($xskip);
}

$graph->Stroke();
?>
