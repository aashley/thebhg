<?php
include('header.php');
include('jpgraph_line.php');

$pleb = $roster->GetPerson($_REQUEST['id']);

if ($pleb->GetJoinDate() > 1033401600) {
	$times[] = $pleb->GetJoinDate();
	$data[] = 0;
}

$history = new PersonHistory($pleb->GetID());
$history->Load(0, 0, array(6));
if ($history->Count()) {
	$item = $history->GetItem();
	$cred_total = $item->GetItem(3) - $item->GetItem(2);
	do {
		$item = $history->GetItem();
		$times[] = $item->GetDate();
		$data[] = $item->GetItem(3);
	} while ($history->Next());
}
else {
	$times[] = time();
	$data[] = $pleb->GetRankCredits();
}

/*$acc_times[] = min($times);
$acc_data[] = $cred_total;
$history = new PersonHistory($pleb->GetID());
$history->Load(0, 0, array(6, 7));
if ($history->Count()) {
	do {
		$item = $history->GetItem();
		$acc_times[] = $item->GetDate();
		if ($item->GetType() == 7) {
			$cred_total -= $item->GetItem(3);
		}
		else {
			$cred_total += $item->GetItem(2);
		}
		$acc_data[] = $cred_total;
	} while ($history->Next());
}*/

$graph = new Graph(640, 480, 'h3r_recent_credits_' . $pleb->GetID());
$graph->SetScale('linlin');
$graph->SetMarginColor('white');

$graph->img->SetMargin(60, 20, 30, 40);
$graph->img->SetAntiAliasing();

$graph->title->Set('Credit History for ' . $pleb->GetName());
$graph->title->SetFont(FF_VERDANA, FS_BOLD, 14);

$graph->xaxis->SetLabelAngle(45);
$graph->xaxis->SetFont(FF_VERDANA, FS_NORMAL, 8);
$graph->xaxis->SetLabelFormatCallback('format_month_label');

$graph->yaxis->title->Set('Credits');
$graph->yaxis->title->SetFont(FF_VERDANA, FS_BOLD, 8);
$graph->yaxis->SetFont(FF_VERDANA, FS_NORMAL, 8);
$graph->yaxis->SetTitleMargin(45);
$graph->yaxis->SetLabelFormatCallback('format_credit_label');

$plot = new LinePlot($data, $times);
$graph->Add($plot);

/*$acc_plot = new LinePlot($acc_data, $acc_times);
$acc_plot->SetColor('red');
$graph->Add($acc_plot);*/

$graph->Stroke();
?>
