<?php
if (empty($_REQUEST['order'])) {
	$_REQUEST['order'] = 'points';
	$_REQUEST['sort'] = 'desc';
}

include_once('header.php');

$kabal =& $roster->GetKabal($_REQUEST['kabal']);
$kag =& $ka->GetKAG($_REQUEST['kag']);
page_header('KAG ' . roman($kag->GetID()) . ' :: ' . $kabal->GetName() . ' Kabal');
add_menu(array('KAG ' . roman($kag->GetID())=>'kag/kag.php?id=' . $kag->GetID(), $kabal->GetName() . '\'s Long-Term Statistics'=>'kag/stats/kabal.php?id=' . $kabal->GetID()));

$table = new Table('', true);
$table->StartRow();
create_sort_headers($table, array('name'=>'Name', 'points'=>'Points', 'events'=>'Events', 'dnp'=>'DNPs', '1'=>'1st', '2'=>'2nd', '3'=>'3rd', 'credits'=>'Credits'));
$table->EndRow();

$hunters =& $kag->GetKabalHunters($kabal);
if ($hunters) {
	$results = array();
	foreach ($hunters as $hunter) {
		$signups =& $kag->GetHunterSignups($hunter);
		$results[$hunter->GetID()] = array('person'=>$hunter, 'points'=>0, 'dnp'=>0, 'credits'=>0, 'name'=>$hunter->GetName());
		$results[$hunter->GetID()]['events'] = count($signups);
		if ($signups) {
			foreach ($signups as $signup) {
				$results[$hunter->GetID()]['points'] += $signup->GetPoints();
				if ($signup->GetState() == 2) {
					$results[$hunter->GetID()]['dnp']++;
				}
				$results[$hunter->GetID()][$signup->GetRank()]++;
				$results[$hunter->GetID()]['credits'] += $signup->GetCredits();
			}
		}
	}
	uasort($results, sort_result_array);
	foreach ($results as $result) {
		$table->StartRow();
		$table->AddCell('<a href="hunter.php?kag=' . $kag->GetID() . '&amp;id=' . $result['person']->GetID() . '">' . $result['person']->GetName() . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($result['points']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($result['events']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($result['dnp']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($result[1]) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($result[2]) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($result[3]) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($result['credits']) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();

page_footer();
?>
