<?php
if (empty($_REQUEST['order'])) {
	$_REQUEST['order'] = 'points';
	$_REQUEST['sort'] = 'desc';
}

include_once('header.php');

$cadre =& $roster->GetCadre($_REQUEST['cadre']);
$cg =& $ka->GetCG($_REQUEST['cg']);
page_header('CG ' . roman($cg->GetID()) . ' :: ' . $cadre->GetName() . ' Cadre');
add_menu(array('CG ' . roman($cg->GetID())=>'cg/cg.php?id=' . $cg->GetID(), $cadre->GetName() . '\'s Long-Term Statistics'=>'cg/stats/cadre.php?id=' . $cadre->GetID()));

$table = new Table('', true);
$table->StartRow();
create_sort_headers($table, array('name'=>'Name', 'points'=>'Points', 'events'=>'Events', 'dnp'=>'DNPs', '1'=>'1st', '2'=>'2nd', '3'=>'3rd', 'credits'=>'Credits'));
$table->EndRow();

$hunters =& $cg->GetCadreHunters($cadre);
if ($hunters) {
	$results = array();
	foreach ($hunters as $hunter) {
		$signups =& $cg->GetHunterSignups($hunter);
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

	foreach ($cg->GetTeamSignups($cadre) as $signup){
		foreach ($results as $hunter => $array){
			$array['credits'] += $signup->getCredits();
		}
	}
	uasort($results, sort_result_array);
	foreach ($results as $result) {
		$table->StartRow();
		$table->AddCell('<a href="hunter.php?cg=' . $cg->GetID() . '&amp;id=' . $result['person']->GetID() . '">' . $result['person']->GetName() . '</a>');
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
